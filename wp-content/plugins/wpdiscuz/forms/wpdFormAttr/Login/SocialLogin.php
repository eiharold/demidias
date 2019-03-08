<?php

namespace wpdFormAttr\Login;

use wpdFormAttr\FormConst\wpdFormConst;
use wpdFormAttr\Login\twitter\TwitterOAuthException;
use wpdFormAttr\Login\twitter\TwitterOAuth;
use wpdFormAttr\Login\Utils;

class SocialLogin {

    private static $_instance = null;
    private $generalOptions;

    private function __construct($options) {
        $this->generalOptions = $options;
        add_action('wp_enqueue_scripts', array(&$this, 'socialScripts'));
        add_action('comment_main_form_bar_top', array(&$this, 'getButtons'));
        add_action('comment_reply_form_bar_top', array(&$this, 'getReplyFormButtons'));
        add_action('wp_ajax_wpd_social_login', array(&$this, 'login'));
        add_action('wp_ajax_nopriv_wpd_social_login', array(&$this, 'login'));
        add_action('wp_ajax_wpd_login_callback', array(&$this, 'loginCallBack'));
        add_action('wp_ajax_nopriv_wpd_login_callback', array(&$this, 'loginCallBack'));
        add_filter('get_avatar', array(&$this, 'userAvatar'), 1, 6);
    }

    public function login() {
        $postID = filter_input(INPUT_POST, 'postID', FILTER_SANITIZE_NUMBER_INT);
        $provider = filter_input(INPUT_POST, 'provider', FILTER_SANITIZE_STRING);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        $userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_NUMBER_INT);
        $response = array('code' => 'error', 'message' => __('Authentication failed.', 'wpdiscuz'), 'url' => '');
        switch ($provider) {
            case 'facebook':
                if ($this->generalOptions->fbUseOAuth2) {
                    $response = $this->facebookLoginPHP($postID, $response);
                } else {
                    $response = $this->facebookLogin($token, $userID, $response);
                }
                break;
            case 'google':
                $response = $this->googleLogin($token, $response);
                break;
            case 'twitter':
                $response = $this->twitterLogin($postID, $response);
                break;
            case 'vk':
                $response = $this->vkLogin($postID, $response);
                break;
            case 'ok':
                $response = $this->okLogin($postID, $response);
                break;
        }
        if (!$response['url']) {
            $response['url'] = $this->getPostLink($postID);
        }
        wp_die(json_encode(apply_filters('wpdiscuz_social_login_response', $response, $provider, $postID, $token, $userID)));
    }

    public function loginCallBack() {
        $this->deleteCookie();
        $provider = filter_input(INPUT_GET, 'provider', FILTER_SANITIZE_STRING);
        switch ($provider) {
            case 'facebook':
                $response = $this->facebookLoginPHPCallBack();
                break;
            case 'twitter':
                $response = $this->twitterLoginCallBack();
                break;
            case 'vk':
                $response = $this->vkLoginCallBack();
                break;
            case 'ok':
                $response = $this->okLoginCallBack();
                break;
        }
    }

    private function getPostLink($postID) {
        $url = home_url();
        if ($postID) {
            $url = get_permalink($postID);
        }
        return $url;
    }

    // https://developers.facebook.com/docs/apps/register
    public function facebookLogin($token, $userID, $response) {
        if (!$token || !$userID) {
            $response['message'] = __('Facebook access token or user ID invalid.', 'wpdiscuz');
            return $response;
        }
        if (!$this->generalOptions->fbAppSecret) {
            $response['message'] = __('Facebook App Secret is required.', 'wpdiscuz');
            return $response;
        }
        $appsecret_proof = hash_hmac('sha256', $token, trim($this->generalOptions->fbAppSecret));
        $url = add_query_arg(array('fields' => 'id,first_name,last_name,picture,email', 'access_token' => $token, 'appsecret_proof' => $appsecret_proof), 'https://graph.facebook.com/v2.8/' . $userID);
        $fb_response = wp_remote_get(esc_url_raw($url), array('timeout' => 30));

        if (is_wp_error($fb_response)) {
            $response['message'] = $fb_response->get_error_message();
            return $response;
        }

        $fb_user = json_decode(wp_remote_retrieve_body($fb_response), true);

        if (isset($fb_user['error'])) {
            $response['message'] = 'Error code: ' . $fb_user['error']['code'] . ' - ' . $fb_user['error']['message'];
            return $response;
        }
        if (empty($fb_user['email']) && $fb_user['id']) {
            $fb_user['email'] = $fb_user['id'] . '_anonymous@facebook.com';
        }
        $this->setCurrentUser(Utils::addUser($fb_user, 'facebook'));
        $response['code'] = 200;
        $response['message'] = '';
        return $response;
    }

    public function facebookLoginPHP($postID, $response) {
        if (!$this->generalOptions->fbAppID || !$this->generalOptions->fbAppSecret) {
            $response['message'] = __('Facebook Application ID and Application Secret  required.', 'wpdiscuz');
            return $response;
        }
        $fbAuthorizeURL = 'https://www.facebook.com/v3.0/dialog/oauth';
        $fbCallBack = $this->createCallBackURL('facebook');
        $state = Utils::generateOAuthState($this->generalOptions->fbAppID);
        Utils::addOAuthState('facebook', $state, $postID);
        $oautAttributs = array(
            'client_id' => $this->generalOptions->fbAppID,
            'redirect_uri' => urlencode($fbCallBack),
            'response_type' => 'code',
            'scope' => 'email,public_profile',
            'state' => $state);
        $oautURL = add_query_arg($oautAttributs, $fbAuthorizeURL);
        $response['code'] = 200;
        $response['message'] = '';
        $response['url'] = $oautURL;
        return $response;
    }

    public function facebookLoginPHPCallBack() {
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
        $state = filter_input(INPUT_GET, 'state', FILTER_SANITIZE_STRING);
        $providerData = Utils::getProviderByState($state);
        $provider = $providerData['provider'];
        $postID = $providerData['postID'];
        $postURL = $this->getPostLink($postID);
        if (!$state || ($provider != 'facebook')) {
            $this->redirect($postURL, __('Facebook authentication failed (OAuth <code>state</code> does not exist).', 'wpdiscuz'));
        }
        if (!$code) {
            $this->redirect($postURL, __('Facebook authentication failed (OAuth <code>code</code> does not exist).', 'wpdiscuz'));
        }
        $fbCallBack = $this->createCallBackURL('facebook');
        $fbAccessTokenURL = 'https://graph.facebook.com/v3.0/oauth/access_token';
        $accessTokenArgs = array('client_id' => $this->generalOptions->fbAppID,
            'client_secret' => $this->generalOptions->fbAppSecret,
            'redirect_uri' => urlencode($fbCallBack),
            'code' => $code);
        $fbAccessTokenURL = add_query_arg($accessTokenArgs, $fbAccessTokenURL);
        $fbAccesTokenResponse = wp_remote_get($fbAccessTokenURL);

        if (is_wp_error($fbAccesTokenResponse)) {
            $this->redirect($postURL, $fbAccesTokenResponse->get_error_message());
        }
        $fbAccesTokenData = json_decode(wp_remote_retrieve_body($fbAccesTokenResponse), true);
        if (isset($fbAccesTokenData['error'])) {
            $this->redirect($postURL, $fbAccesTokenData['error']['message']);
        }
        $token = $fbAccesTokenData['access_token'];
        $appsecret_proof = hash_hmac('sha256', $token, trim($this->generalOptions->fbAppSecret));
        $fbGetUserDataURL = add_query_arg(array('fields' => 'id,first_name,last_name,picture,email', 'access_token' => $token, 'appsecret_proof' => $appsecret_proof), 'https://graph.facebook.com/v3.0/me');
        $getFbUserResponse = wp_remote_get($fbGetUserDataURL);
        if (is_wp_error($getFbUserResponse)) {
            $this->redirect($postURL, $getFbUserResponse->get_error_message());
        }
        $fbUserData = json_decode(wp_remote_retrieve_body($getFbUserResponse), true);
        if (isset($fbUserData['error'])) {
            $this->redirect($postURL, $fbUserData['error']['message']);
        }
        if (empty($fbUserData['email']) && $fbUserData['id']) {
            $fbUserData['email'] = $fbUserData['id'] . '_anonymous@facebook.com';
        }
        $this->setCurrentUser(Utils::addUser($fbUserData, 'facebook'));
        $this->redirect($postURL);
    }

    // https://console.developers.google.com/
    public function googleLogin($token, $response) {
        if (!$token) {
            $response['message'] = __('Google access token  invalid.', 'wpdiscuz');
            return $response;
        }
        $url = 'https://www.googleapis.com/oauth2/v3/tokeninfo';
        $googleResponse = wp_remote_post($url, array('body' => array('id_token' => $token)));
        if (is_wp_error($googleResponse)) {
            $response['message'] = $googleResponse->get_error_message();
            return $response;
        }
        $googleUser = json_decode(wp_remote_retrieve_body($googleResponse), true);
        if (!isset($googleUser['sub'])) {
            $response['message'] = __('Google authentication failed.', 'wpdiscuz');
            return $response;
        }
        if (!isset($googleUser['email']) && !$googleUser['email']) {
            $googleUser['email'] = $googleUser['sub'] . '_anonymous@google.com';
        }
        $this->setCurrentUser(Utils::addUser($googleUser, 'google'));
        $response['code'] = 200;
        $response['message'] = '';
        return $response;
    }

    // https://apps.twitter.com/
    public function twitterLogin($postID, $response) {
        if ($this->generalOptions->twitterAppID && $this->generalOptions->twitterAppSecret) {
            $twitter = new TwitterOAuth($this->generalOptions->twitterAppID, $this->generalOptions->twitterAppSecret);
            $twitterCallBack = $this->createCallBackURL('twitter');
            try {
                $requestToken = $twitter->oauth('oauth/request_token', array('oauth_callback' => $twitterCallBack));
                Utils::addOAuthState($requestToken['oauth_token_secret'], $requestToken['oauth_token'], $postID);
                $url = $twitter->url('oauth/authorize', array('oauth_token' => $requestToken['oauth_token']));
                $response['code'] = 200;
                $response['message'] = '';
                $response['url'] = $url;
            } catch (TwitterOAuthException $e) {
                $response['message'] = $e->getOAuthMessage();
            }
        } else {
            $response['message'] = __('Twitter Consumer Key and Consumer Secret  required.', 'wpdiscuz');
        }
        return $response;
    }

    public function twitterLoginCallBack() {
        $oauthToken = filter_input(INPUT_GET, 'oauth_token', FILTER_SANITIZE_STRING);
        $oauthVerifier = filter_input(INPUT_GET, 'oauth_verifier', FILTER_SANITIZE_STRING);
        $oauthSecretData = Utils::getProviderByState($oauthToken);
        $oauthSecret = $oauthSecretData['provider'];
        $postID = $oauthSecretData['postID'];
        $postURL = $this->getPostLink($postID);
        if (!$oauthVerifier || !$oauthSecret) {
            $this->redirect($postURL, __('Twitter authentication failed (OAuth secret does not exist).', 'wpdiscuz'));
        }
        $twitter = new TwitterOAuth($this->generalOptions->twitterAppID, $this->generalOptions->twitterAppSecret, $oauthToken, $oauthSecret);
        try {
            $accessToken = $twitter->oauth('oauth/access_token', array('oauth_verifier' => $oauthVerifier));
            $connection = new TwitterOAuth($this->generalOptions->twitterAppID, $this->generalOptions->twitterAppSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
            $twitterUser = $connection->get('account/verify_credentials', array('include_email' => 'true'));
            if (is_object($twitterUser) && isset($twitterUser->id)) {
                $this->setCurrentUser(Utils::addUser($twitterUser, 'twitter'));
                $this->redirect($postURL);
            } else {
                $this->redirect($postURL, __('Twitter connection failed.', 'wpdiscuz'));
            }
        } catch (TwitterOAuthException $e) {
            $this->redirect($postURL, $e->getOAuthMessage());
        }
    }

    // https://vk.com/editapp?act=create
    public function vkLogin($postID, $response) {
        if (!$this->generalOptions->vkAppID || !$this->generalOptions->vkAppSecret) {
            $response['message'] = __('VK Client ID and Client Secret  required.', 'wpdiscuz');
            return $response;
        }
        $vkAuthorizeURL = 'https://oauth.vk.com/authorize';
        $vkCallBack = $this->createCallBackURL('vk');
        $state = Utils::generateOAuthState($this->generalOptions->vkAppID);
        Utils::addOAuthState('vk', $state, $postID);
        $oautAttributs = array('client_id' => $this->generalOptions->vkAppID,
            'client_secret' => $this->generalOptions->vkAppSecret,
            'redirect_uri' => urlencode($vkCallBack),
            'response_type' => 'code',
            'scope' => 'email',
            'state' => $state,
            'v' => '5.78');
        $oautURL = add_query_arg($oautAttributs, $vkAuthorizeURL);
        $response['code'] = 200;
        $response['message'] = '';
        $response['url'] = $oautURL;
        return $response;
    }

    public function vkLoginCallBack() {
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
        $state = filter_input(INPUT_GET, 'state', FILTER_SANITIZE_STRING);
        $providerData = Utils::getProviderByState($state);
        $provider = $providerData['provider'];
        $postID = $providerData['postID'];
        $postURL = $this->getPostLink($postID);
        if (!$state || ($provider != 'vk')) {
            $this->redirect($postURL, __('VK authentication failed (OAuth <code>state</code> does not exist).', 'wpdiscuz'));
        }
        if (!$code) {
            $this->redirect($postURL, __('VK authentication failed (OAuth <code>code</code> does not exist).', 'wpdiscuz'));
        }
        $vkCallBack = $this->createCallBackURL('vk');
        $vkAccessTokenURL = 'https://oauth.vk.com/access_token';
        $accessTokenArgs = array('client_id' => $this->generalOptions->vkAppID,
            'client_secret' => $this->generalOptions->vkAppSecret,
            'redirect_uri' => $vkCallBack,
            'code' => $code);
        $vkAccesTokenResponse = wp_remote_post($vkAccessTokenURL, array('body' => $accessTokenArgs));

        if (is_wp_error($vkAccesTokenResponse)) {
            $this->redirect($postURL, $vkAccesTokenResponse->get_error_message());
        }
        $vkAccesTokenData = json_decode(wp_remote_retrieve_body($vkAccesTokenResponse), true);
        if (isset($vkAccesTokenData['error'])) {
            $this->redirect($postURL, $vkAccesTokenData['error_description']);
        }
        if (!isset($vkAccesTokenData['user_id'])) {
            $this->redirect($postURL, __('VK authentication failed (<code>user_id</code> does not exist).', 'wpdiscuz'));
        }
        $userID = $vkAccesTokenData['user_id'];
        $email = isset($vkAccesTokenData['email']) ? $vkAccesTokenData['email'] : $userID . '_anonymous@vk.com';
        $vkGetUserDataURL = 'https://api.vk.com/method/users.get';
        $vkGetUserDataAttr = array('user_ids' => $userID,
            'access_token' => $vkAccesTokenData['access_token'],
            'fields' => 'first_name,last_name,screen_name,photo_100',
            'v' => '5.78');
        $getVkUserResponse = wp_remote_post($vkGetUserDataURL, array('body' => $vkGetUserDataAttr));
        if (is_wp_error($getVkUserResponse)) {
            $this->redirect($postURL, $getVkUserResponse->get_error_message());
        }
        $vkUserData = json_decode(wp_remote_retrieve_body($getVkUserResponse), true);
        if (isset($vkUserData['error'])) {
            $this->redirect($postURL, $vkUserData['error_msg']);
        }
        $vkUser = $vkUserData['response'][0];
        $vkUser['email'] = $email;
        $this->setCurrentUser(Utils::addUser($vkUser, 'vk'));
        $this->redirect($postURL);
    }

    //https://apiok.ru/dev/app/create
    public function okLogin($postID, $response) {
        if (!$this->generalOptions->okAppID || !$this->generalOptions->okAppSecret || !$this->generalOptions->okAppKey) {
            $response['message'] = __('OK Application ID, Application Key  and Application Secret  required.', 'wpdiscuz');
            return $response;
        }
        $okAuthorizeURL = 'https://connect.ok.ru/oauth/authorize';
        $okCallBack = $this->createCallBackURL('ok');
        $state = Utils::generateOAuthState($this->generalOptions->okAppID);
        Utils::addOAuthState('ok', $state, $postID);
        $oautAttributs = array('client_id' => $this->generalOptions->okAppID,
            'redirect_uri' => urlencode($okCallBack),
            'response_type' => 'code',
            'scope' => 'VALUABLE_ACCESS;GET_EMAIL',
            'state' => $state);
        $oautURL = add_query_arg($oautAttributs, $okAuthorizeURL);
        $response['code'] = 200;
        $response['message'] = '';
        $response['url'] = $oautURL;
        return $response;
    }

    public function okLoginCallBack() {
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
        $state = filter_input(INPUT_GET, 'state', FILTER_SANITIZE_STRING);
        $providerData = Utils::getProviderByState($state);
        $provider = $providerData['provider'];
        $postID = $providerData['postID'];
        $postURL = $this->getPostLink($postID);
        if (!$state || ($provider != 'ok')) {
            $this->redirect($postURL, __('OK authentication failed (OAuth <code>state</code> does not exist).', 'wpdiscuz'));
        }
        if (!$code) {
            $this->redirect($postURL, __('OK authentication failed (<code>code</code> does not exist).', 'wpdiscuz'));
        }
        $okCallBack = $this->createCallBackURL('ok');
        $okAccessTokenURL = 'https://api.ok.ru/oauth/token.do';
        $accessTokenArgs = array('client_id' => $this->generalOptions->okAppID,
            'client_secret' => $this->generalOptions->okAppSecret,
            'redirect_uri' => $okCallBack,
            'grant_type' => 'authorization_code',
            'code' => $code);
        $okAccesTokenResponse = wp_remote_post($okAccessTokenURL, array('body' => $accessTokenArgs));

        if (is_wp_error($okAccesTokenResponse)) {
            $this->redirect($postURL, $okAccesTokenResponse->get_error_message());
        }
        $okAccesTokenData = json_decode(wp_remote_retrieve_body($okAccesTokenResponse), true);
        if (isset($okAccesTokenData['error_code'])) {
            $this->redirect($postURL, $okAccesTokenData['error_msg']);
        }
        if (!isset($okAccesTokenData['access_token'])) {
            $this->redirect($postURL, __('OK authentication failed (<code>access_token</code> does not exist).', 'wpdiscuz'));
        }
        $accessToken = $okAccesTokenData['access_token'];
        $secretKey = md5($accessToken . $this->generalOptions->okAppSecret);
        $sig = md5("application_key={$this->generalOptions->okAppKey}format=jsonmethod=users.getCurrentUser$secretKey");
        $okGetUserDataURL = 'https://api.ok.ru/fb.do';
        $okGetUserDataAttr = array('application_key' => $this->generalOptions->okAppKey,
            'format' => 'json',
            'method' => 'users.getCurrentUser',
            'sig' => $sig,
            'access_token' => $accessToken);
        $getOkUserResponse = wp_remote_post($okGetUserDataURL, array('body' => $okGetUserDataAttr));
        if (is_wp_error($getOkUserResponse)) {
            $this->redirect($postURL, $getOkUserResponse->get_error_message());
        }
        $okUserData = json_decode(wp_remote_retrieve_body($getOkUserResponse), true);
        if (isset($okUserData['error_code'])) {
            $this->redirect($postURL, $okUserData['error_msg']);
        }
        $this->setCurrentUser(Utils::addUser($okUserData, 'ok'));
        $this->redirect($postURL);
    }

    private function redirect($postURL, $message = '') {
        if ($message) {
            setcookie('wpdiscuz_social_login_message', $message, 3 * DAYS_IN_SECONDS, '/', COOKIE_DOMAIN);
        }
        wp_redirect($postURL, 302);
        exit();
    }

    private function createCallBackURL($provider) {
        $adminAjaxURL = admin_url('admin-ajax.php');
        $urlAttributs = array('action' => 'wpd_login_callback',
            'provider' => $provider);
        return add_query_arg($urlAttributs, $adminAjaxURL);
    }

    private function deleteCookie() {
        unset($_COOKIE['wpdiscuz_social_login_message']);
        setcookie('wpdiscuz_social_login_message', '', time() - ( 15 * 60 ));
    }

    private function setCurrentUser($userID) {
        if (is_wp_error($userID)) {
            $this->generateResponse(0, $userID->get_error_message());
        } else {
            $user = get_user_by('id', $userID);
            wp_set_current_user($userID, $user->user_login);
            wp_set_auth_cookie($userID);
            do_action('wp_login', $user->user_login);
        }
    }

    public function getButtons() {
        global $post;
        if (!is_user_logged_in() && wpDiscuz()->helper->isLoadWpdiscuz($post) && ($this->generalOptions->enableFbLogin || $this->generalOptions->enableTwitterLogin || $this->generalOptions->enableGoogleLogin || $this->generalOptions->enableOkLogin || $this->generalOptions->enableVkLogin)) {
            echo '<div class="wpdiscuz-ftb-right"><div class="wpdiscuz-social-login"><div class="wpdiscuz-connect-with">' . $this->generalOptions->phrases['wc_connect_with'] . ' </div>';
            $this->facebookButton();
            $this->googleButton();
            $this->twitterButton();
            $this->okButton();
            $this->vkButton();
            echo '<div class="wpdiscuz-social-login-spinner"><i class="fas fa-spinner fa-pulse"></i></div><div class="wpd-clear"></div></div></div>';
            if ($this->generalOptions->socialLoginAgreementCheckbox) {
                ?>
                <div class="wpd-social-login-agreement" style="display: none;">
                    <div class="wpd-agreement-title"><?php echo $this->generalOptions->phrases['wc_social_login_agreement_label']; ?></div>
                    <div class="wpd-agreement"><?php echo $this->generalOptions->phrases['wc_social_login_agreement_desc']; ?></div>
                    <div class="wpd-agreement-buttons">
                        <div class="wpd-agreement-buttons-right"><span class="wpd-agreement-button wpd-agreement-button-disagree"><?php echo $this->generalOptions->phrases['wc_agreement_button_disagree']; ?></span><span class="wpd-agreement-button wpd-agreement-button-agree"><?php echo $this->generalOptions->phrases['wc_agreement_button_agree']; ?></span></div>
                        <div class="wpd-clear"></div>
                    </div>
                </div>
                <?php
            }
        }
    }

    public function getReplyFormButtons() {
        if ($this->generalOptions->socialLoginInSecondaryForm) {
            $this->getButtons();
        }
    }

    private function facebookButton() {
        if ($this->generalOptions->enableFbLogin && $this->generalOptions->fbAppID && $this->generalOptions->fbAppSecret) {
            echo '<div class="wpdiscuz-login-button wpdiscuz-facebook-button"><i class="fab fa-facebook-f"></i></div>';
        }
    }

    private function twitterButton() {
        if ($this->generalOptions->enableTwitterLogin && $this->generalOptions->twitterAppID && $this->generalOptions->twitterAppSecret) {
            echo '<div class="wpdiscuz-login-button wpdiscuz-twitter-button"><i class="fab fa-twitter"></i></div>';
        }
    }

    private function googleButton() {
        if ($this->generalOptions->enableGoogleLogin && $this->generalOptions->googleAppID) {
            echo '<div class="wpdiscuz-login-button wpdiscuz-google-button"><i class="fab fa-google"></i></div>';
        }
    }

    private function okButton() {
        if ($this->generalOptions->enableOkLogin && $this->generalOptions->okAppID && $this->generalOptions->okAppSecret) {
            echo '<div class="wpdiscuz-login-button wpdiscuz-ok-button"><i class="fab fa-odnoklassniki"></i></div>';
        }
    }

    private function vkButton() {
        if ($this->generalOptions->enableVkLogin && $this->generalOptions->vkAppID && $this->generalOptions->vkAppSecret) {
            echo '<div class="wpdiscuz-login-button wpdiscuz-vk-button"><i class="fab fa-vk"></i></div>';
        }
    }

    public function userAvatar($avatar, $id_or_email, $size, $default, $alt, $args) {
        $userID = false;
        if (is_numeric($id_or_email)) {
            $userID = (int) $id_or_email;
        } elseif (is_object($id_or_email)) {
            if (!empty($id_or_email->user_id)) {
                $userID = (int) $id_or_email->user_id;
            }
        } else {
            $user = get_user_by('email', $id_or_email);
            $userID = isset($user->ID) ? $user->ID : 0;
        }

        if ($userID && $avatarURL = get_user_meta($userID, wpdFormConst::WPDISCUZ_SOCIAL_AVATAR_KEY, true)) {
            $avatarURL = apply_filters('get_avatar_url', $avatarURL, $id_or_email, $args);
            $class = array('avatar', 'avatar-' . (int) $args['size'], 'photo');
            if (is_array($args['class'])) {
                $class = array_merge($class, $args['class']);
            } else {
                $class[] = $args['class'];
            }
            $avatar = "<img alt='" . esc_attr($alt) . "' src='" . esc_attr($avatarURL) . "' class='" . esc_attr(join(' ', $class)) . " wpdiscuz-social-avatar' height='" . intval($size) . "' width='" . intval($size) . "' " . $args['extra_attr'] . "/>";
        }
        return $avatar;
    }

    public function socialScripts() {
        global $post;
        if (wpDiscuz()->helper->isLoadWpdiscuz($post) && ($this->generalOptions->enableFbLogin || $this->generalOptions->enableFbShare || $this->generalOptions->enableTwitterLogin || $this->generalOptions->enableGoogleLogin || $this->generalOptions->enableVkLogin || $this->generalOptions->enableOkLogin)) {
            wp_register_script('wpdiscuz-social-js', plugins_url(WPDISCUZ_DIR_NAME . '/assets/js/wpdiscuz-social.js'), array('jquery'), get_option('wc_plugin_version', '1.0.0'), true);
            wp_enqueue_script('wpdiscuz-social-js');
        }
    }

    public static function getInstance($options) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }

}
