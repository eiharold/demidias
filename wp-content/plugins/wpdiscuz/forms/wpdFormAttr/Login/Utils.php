<?php

namespace wpdFormAttr\Login;

use wpdFormAttr\FormConst\wpdFormConst;

class Utils {

    public static function addUser($socialUser, $provider) {
        $userID = 0;
        $userData = array();
        switch ($provider) {
            case 'facebook':
                $userData = self::sanitizeFacebookUser($socialUser);
                break;
            case 'twitter':
                $userData = self::sanitizeTwitterUser($socialUser);
                break;
            case 'google':
                $userData = self::sanitizeGoogleUser($socialUser);
                break;
            case 'ok':
                $userData = self::sanitizeOkUser($socialUser);
                break;
            case 'vk':
                $userData = self::sanitizeVkUser($socialUser);
                break;
        }

        if ($userData) {
            if ($userID = email_exists($userData['user_email'])) {
                $userData['ID'] = $userID;
                $userData['status'] = 'update';
            } else {
                $userData['role'] = get_option('default_role');
                $userID = $userData['ID'] = wp_insert_user($userData);
            }
            if ($userID && !is_wp_error($userID)) {
                self::updateUserData($userData);
                update_user_meta($userID, wpdFormConst::WPDISCUZ_SOCIAL_AVATAR_KEY, $userData['avatar']);
            }
        }
        return $userID;
    }

    private static function updateUserData($userData) {
        $userProvider = get_user_meta($userData['ID'], wpdFormConst::WPDISCUZ_SOCIAL_PROVIDER_KEY, true);
        if ($userProvider !== $userData['provider']) {
            wp_update_user(array('ID' => $userData['ID'], 'user_url' => $userData['user_url']));
            update_user_meta($userData['ID'], wpdFormConst::WPDISCUZ_SOCIAL_PROVIDER_KEY, $userData['provider']);
            update_user_meta($userData['ID'], wpdFormConst::WPDISCUZ_SOCIAL_USER_ID_KEY, $userData['social_user_id']);
        }
    }

    private static function generateLogin($email) {
        $username = str_replace('-', '_', sanitize_title(strstr($email, '@', true)));
        $username = sanitize_user($username);
        return self::saitizeUsername($username);
    }

    private static function saitizeUsername($username) {
        if (mb_strlen($username) > 60) {
            $username = mb_substr($username, 0, 20);
        }
        $suffix = 2;
        $alt_username = $username;
        while (username_exists($alt_username)) {
            $alt_username = $username . '_' . $suffix;
            $suffix++;
        }
        return $alt_username;
    }

    private static function sanitizeFacebookUser($fbUser) {
        $userData = array(
            'user_login' => self::generateLogin($fbUser['email']),
            'first_name' => $fbUser['first_name'],
            'last_name' => $fbUser['last_name'],
            'display_name' => $fbUser['first_name'] . ' ' . $fbUser['last_name'],
            'user_url' => '',
            'user_email' => $fbUser['email'],
            'provider' => 'facebook',
            'social_user_id' => $fbUser['id'],
            'avatar' => 'https://graph.facebook.com/' . $fbUser['id'] . '/picture?type=large'
        );
        return $userData;
    }

    private static function sanitizeGoogleUser($googleUser) {
        $userData = array(
            'user_login' => self::generateLogin($googleUser['email']),
            'first_name' => $googleUser['given_name'],
            'last_name' => $googleUser['family_name'],
            'display_name' => $googleUser['name'],
            'user_url' => 'https://plus.google.com/' . $googleUser['sub'],
            'user_email' => $googleUser['email'],
            'provider' => 'google',
            'social_user_id' => $googleUser['id'],
            'avatar' => $googleUser['picture']
        );
        return $userData;
    }

    private static function sanitizeTwitterUser($socialUser) {
        $userData = array(
            'user_login' => self::saitizeUsername($socialUser->screen_name),
            'first_name' => $socialUser->name,
            'last_name' => '',
            'display_name' => $socialUser->name,
            'user_url' => 'https://twitter.com/' . $socialUser->screen_name,
            'user_email' => isset($socialUser->email) && $socialUser->email ? $socialUser->email : $socialUser->id . '_anonymous@twitter.com',
            'provider' => 'twitter',
            'social_user_id' => $socialUser->id,
            'avatar' => str_replace('_normal.', '_bigger.', $socialUser->profile_image_url_https)
        );
        return $userData;
    }

    private static function sanitizeVkUser($socialUser) {
        $userData = array(
            'user_login' => self::generateLogin($socialUser['email']),
            'first_name' => $socialUser['first_name'],
            'last_name' => $socialUser['last_name'],
            'display_name' => $socialUser['first_name'] . ' ' . $socialUser['last_name'],
            'user_url' => 'https://vk.com/' . (isset($socialUser['screen_name']) && $socialUser['screen_name'] ? $socialUser['screen_name'] : 'id' . $socialUser['id']),
            'user_email' => $socialUser['email'],
            'provider' => 'vk',
            'social_user_id' => $socialUser['id'],
            'avatar' => isset($socialUser['photo_100']) ? $socialUser['photo_100'] : '',
        );
        return $userData;
    }

    private static function sanitizeOkUser($socialUser) {
        $email = $socialUser['has_email'] ? $socialUser['email'] : $socialUser['uid'] . '_anonymous@ok.ru';
        $userData = array(
            'user_login' => self::generateLogin($email),
            'first_name' => $socialUser['first_name'],
            'last_name' => $socialUser['last_name'],
            'display_name' => $socialUser['name'],
            'user_url' => 'https://ok.ru/profile/' . $socialUser['uid'],
            'user_email' => $email,
            'provider' => 'ok',
            'social_user_id' => $socialUser['uid'],
            'avatar' => $socialUser['pic_2'],
        );
        return $userData;
    }

    public static function addOAuthState($provider, $secret, $postID) {
        global $wpdb;
        $tempUserID = $wpdb->get_var("SELECT MAX(`user_id`) +1 FROM  {$wpdb->usermeta}");
        update_user_meta($tempUserID, wpdFormConst::WPDISCUZ_OAUTH_STATE_PROVIDER, $provider);
        update_user_meta($tempUserID, wpdFormConst::WPDISCUZ_OAUTH_STATE_TOKEN, $secret);
        update_user_meta($tempUserID, wpdFormConst::WPDISCUZ_OAUTH_CURRENT_POSTID, $postID);
        return $tempUserID;
    }

    private static function getTempUserID($token) {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("SELECT `user_id`  FROM  {$wpdb->usermeta} WHERE `meta_key`= %s  AND `meta_value` = %s", wpdFormConst::WPDISCUZ_OAUTH_STATE_TOKEN, $token));
    }

    private static function deleteTempUserData($userID) {
        delete_user_meta($userID, wpdFormConst::WPDISCUZ_OAUTH_STATE_PROVIDER);
        delete_user_meta($userID, wpdFormConst::WPDISCUZ_OAUTH_STATE_TOKEN);
        delete_user_meta($userID, wpdFormConst::WPDISCUZ_OAUTH_CURRENT_POSTID);
    }

    public static function generateOAuthState($appID) {
        return md5("appID=$appID;date=" . time());
    }

    public static function getProviderByState($state) {
        $tempUserID = self::getTempUserID($state);
        $providerData = array();
        $providerData['provider'] = get_user_meta($tempUserID, wpdFormConst::WPDISCUZ_OAUTH_STATE_PROVIDER, true);
        $providerData['postID'] = get_user_meta($tempUserID, wpdFormConst::WPDISCUZ_OAUTH_CURRENT_POSTID, true);
        self::deleteTempUserData($tempUserID);
        return $providerData;
    }

}
