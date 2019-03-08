<?php
if (!defined('ABSPATH')) {
    exit();
}

class WpdiscuzHelper implements WpDiscuzConstants {

    private $spoilerPattern = '@\[(\[?)(spoiler)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)@is';
    private $optionsSerialized;
    private $dbManager;
    private $wpdiscuzForm;

    public function __construct($optionsSerialized, $dbManager, $wpdiscuzForm) {
        $this->optionsSerialized = $optionsSerialized;
        $this->dbManager = $dbManager;
        $this->wpdiscuzForm = $wpdiscuzForm;
        add_filter('the_champ_login_interface_filter', array(&$this, 'wpDiscuzSuperSocializerLogin'), 15, 2);
        add_action('wpdiscuz_form_bottom', array(&$this, 'formBottom'), 10, 4);
        add_filter('pre_comment_user_ip', array(&$this, 'fixLocalhostIp'), 10);
    }

    public function filterKses() {
        $allowedtags = array();
        $allowedtags['br'] = array();
        $allowedtags['a'] = array('href' => array(), 'title' => array(), 'target' => array(), 'rel' => array(), 'download' => array(), 'hreflang' => array(), 'media' => array(), 'type' => array());
        $allowedtags['i'] = array('class' => array());
        $allowedtags['b'] = array();
        $allowedtags['u'] = array();
        $allowedtags['strong'] = array();
        $allowedtags['s'] = array();
        $allowedtags['p'] = array();
        $allowedtags['img'] = array('src' => array(), 'width' => array(), 'height' => array(), 'alt' => array(), 'title' => array());
        $allowedtags['blockquote'] = array('cite' => array());
        $allowedtags['ul'] = array();
        $allowedtags['li'] = array();
        $allowedtags['ol'] = array();
        $allowedtags['code'] = array();
        $allowedtags['em'] = array();
        $allowedtags['abbr'] = array('title' => array());
        $allowedtags['q'] = array('cite' => array());
        $allowedtags['acronym'] = array('title' => array());
        $allowedtags['cite'] = array();
        $allowedtags['strike'] = array();
        $allowedtags['del'] = array('datetime' => array());
        $allowedtags['span'] = array('id' => array(), 'class' => array(), 'title' => array());
        $allowedtags['pre'] = array();
        return apply_filters('wpdiscuz_allowedtags', $allowedtags);
    }

    public function filterCommentText($commentContent) {
        kses_remove_filters();
        remove_filter('comment_text', 'wp_kses_post');
        if (!current_user_can('unfiltered_html')) {
            $commentContent = wp_kses($commentContent, $this->filterKses());
        }
        return $commentContent;
    }

    public function dateDiff($datetime) {
        $text = '';
        if ($datetime) {
            $now = new DateTime();
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);
            if ($diff->y) {
                $text .= $diff->y . ' ';
                $text .= $diff->y > 1 ? $this->optionsSerialized->phrases['wc_year_text_plural'] : $this->optionsSerialized->phrases['wc_year_text'];
            } else if ($diff->m) {
                $text .= $diff->m . ' ';
                $text .= $diff->m > 1 ? $this->optionsSerialized->phrases['wc_month_text_plural'] : $this->optionsSerialized->phrases['wc_month_text'];
            } else if ($diff->d) {
                $text .= $diff->d . ' ';
                $text .= $diff->d > 1 ? $this->optionsSerialized->phrases['wc_day_text_plural'] : $this->optionsSerialized->phrases['wc_day_text'];
            } else if ($diff->h) {
                $text .= $diff->h . ' ';
                $text .= $diff->h > 1 ? $this->optionsSerialized->phrases['wc_hour_text_plural'] : $this->optionsSerialized->phrases['wc_hour_text'];
            } else if ($diff->i) {
                $text .= $diff->i . ' ';
                $text .= $diff->i > 1 ? $this->optionsSerialized->phrases['wc_minute_text_plural'] : $this->optionsSerialized->phrases['wc_minute_text'];
            } else if ($diff->s) {
                $text .= $diff->s . ' ';
                $text .= $diff->s > 1 ? $this->optionsSerialized->phrases['wc_second_text_plural'] : $this->optionsSerialized->phrases['wc_second_text'];
            }
            $text .= ($text) ? ' ' . $this->optionsSerialized->phrases['wc_ago_text'] : ' ' . $this->optionsSerialized->phrases['wc_right_now_text'];
        }
        return $text;
    }

    public function makeClickable($ret) {
        $ret = ' ' . $ret;
        $hook = '?';
        if (is_ssl() && $this->optionsSerialized->commentLinkFilter == 1) {
            $hook = '';
        }
        $ret = preg_replace_callback('#[^\"|\'](https' . $hook . ':\/\/[^\s]+(\.jpe?g|\.png|\.gif|\.bmp))#i', array(&$this, 'replaceUrlToImg'), $ret);
        // this one is not in an array because we need it to run last, for cleanup of accidental links within links
        $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
        $ret = trim($ret);
        return $ret;
    }

    public function replaceUrlToImg($matches) {
        $url = $matches[1];
        if (is_ssl() && $this->optionsSerialized->commentLinkFilter == 2 && !strstr($matches[1], 'https://')) {
            $url = str_replace('http://', 'https://', $url);
        }
        return '<a rel="nofollow" target="_blank" href="' . esc_url($url) . '"><img alt="comment image" src="' . esc_url($url) . '" /></a>';
    }

    /**
     * check if comment has been posted today or not
     * @param type $comment WP_Comment object or Datetime value
     * @return type
     */
    public static function isPostedToday($comment) {
        if ($comment && is_object($comment)) {
            return date('Ymd', strtotime(current_time('Ymd'))) <= date('Ymd', strtotime($comment->comment_date));
        } else {
            return date('Ymd', strtotime(current_time('Ymd'))) <= date('Ymd', strtotime($comment));
        }
    }

    /**
     * check if comment is still editable or not
     * return boolean
     */
    public function isCommentEditable($comment) {               
        $editableTimeLimit = isset($this->optionsSerialized->commentEditableTime) ? $this->optionsSerialized->commentEditableTime : 0;
        $commentTimestamp = strtotime($comment->comment_date);
        $timeDiff = (current_time('timestamp') - $commentTimestamp);
        $editableTimeLimit = ($editableTimeLimit == 'unlimit') ? $timeDiff + 1 : intval($editableTimeLimit);
        return $editableTimeLimit && ($timeDiff < $editableTimeLimit);
    }

    /**
     * checks if the current comment content is in min/max range defined in options
     */
    public function isContentInRange($commentContent) {
        $commentMinLength = intval($this->optionsSerialized->commentTextMinLength);
        $commentMaxLength = intval($this->optionsSerialized->commentTextMaxLength);
        $commentContent = trim(strip_tags($commentContent));
        $contentLength = function_exists('mb_strlen') ? mb_strlen($commentContent) : strlen($commentContent);
        return ($commentMinLength && $contentLength >= $commentMinLength) && ($commentMaxLength == 0 || $contentLength <= $commentMaxLength);
    }

    /**
     * return client real ip
     */
    public function getRealIPAddr() {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $ip = apply_filters('pre_comment_user_ip', $ip);

        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }
        return $ip;
    }

    public function getUIDData($uid) {
        $id_strings = explode('_', $uid);
        return $id_strings;
    }

    public function superSocializerFix() {
        if (function_exists('the_champ_login_button')) {
            ?>
            <div id="comments" style="width: 0;height: 0;clear: both;margin: 0;padding: 0;"></div>
            <div id="respond" class="comments-area">
            <?php } else { ?>
                <div id="comments" class="comments-area">
                    <div id="respond" style="width: 0;height: 0;clear: both;margin: 0;padding: 0;"></div>
                    <?php
                }
            }

            public function getCommentExcerpt($commentContent, $uniqueId) {
                $readMoreLink = '<span id="wpdiscuz-readmore-' . $uniqueId . '"><span class="wpdiscuz-hellip">&hellip;&nbsp;</span><span class="wpdiscuz-readmore" title="' . $this->optionsSerialized->phrases['wc_read_more'] . '">' . $this->optionsSerialized->phrases['wc_read_more'] . '</span></span>';
                return "<p>" . wp_trim_words($commentContent, $this->optionsSerialized->commentReadMoreLimit, $readMoreLink) . "</p>";
            }

            public function isLoadWpdiscuz($post) {
                if (!$post || !is_object($post) || (is_front_page() && !$this->optionsSerialized->isEnableOnHome)) {
                    return false;
                }
                $form = $this->wpdiscuzForm->getForm($post->ID);
                return $form->getFormID() && (comments_open($post) || $post->comment_count) && is_singular() && post_type_supports($post->post_type, 'comments');
            }

            public function replaceCommentContentCode($content) {
                if (is_ssl()) {
                    $content = preg_replace_callback('#<\s*?img[^>]*src*=*["\']?([^"\']*)[^>]+>#is', array(&$this, 'replaceImageToURL'), $content);
                }
                return preg_replace_callback('#`(.*?)`#is', array(&$this, 'replaceCodeContent'), stripslashes($content));
            }

            private function replaceImageToURL($matches) {
                if (!strstr($matches[1], 'https://') && $this->optionsSerialized->commentLinkFilter == 1) {
                    return "\r\n" . $matches[1] . "\r\n";
                } elseif (!strstr($matches[1], 'https://') && $this->optionsSerialized->commentLinkFilter == 2) {
                    return str_replace('http://', 'https://', $matches[0]);
                } else {
                    return $matches[0];
                }
            }

            private function replaceCodeContent($matches) {
                $codeContent = trim($matches[1]);
                $codeContent = str_replace(array('<', '>'), array('&lt;', '&gt;'), $codeContent);
                return '<code>' . $codeContent . '</code>';
            }

            public function spoiler($content) {
                return preg_replace_callback($this->spoilerPattern, array(&$this, '_spoiler'), $content);
            }

            private function _spoiler($matches) {
                $html = '<div class="wpdiscuz-spoiler-wrap">';
                $title = __('Spoiler', 'wpdiscuz');
                $matches[3] = str_replace(array('&#8221;', '&#8220;'), '"', $matches[3]);
                if (preg_match('@title[^\S]*=[^\S]*"*([^\"]+)"@is', $matches[3], $titleMatch)) {
                    $title = trim($titleMatch[1]) ? trim($titleMatch[1]) : __('Spoiler', 'wpdiscuz');
                }

                $html .= '<div class="wpdiscuz-spoiler wpdiscuz-spoiler-closed"><i class="fas fa-plus" aria-hidden="true"></i>' . $title . '</div>';
                $html .= '<div class="wpdiscuz-spoiler-content">' . $matches[5] . '</div>';
                $html .= '</div>';
                return $html;
            }

            public function getCurrentUserDisplayName($current_user) {
                $displayName = trim($current_user->display_name);
                if (!$displayName) {
                    $displayName = trim($current_user->user_nicename) ? trim($current_user->user_nicename) : trim($current_user->user_login);
                }
                return $displayName;
            }

            public function registerWpDiscuzStyle($version) {
                $templateDir = get_stylesheet_directory();
                $wpcTemplateStyleFile = $templateDir . DIRECTORY_SEPARATOR . 'wpdiscuz' . DIRECTORY_SEPARATOR . 'wpdiscuz.css';
                $wpdiscuzStyleURL = plugins_url(WPDISCUZ_DIR_NAME . '/assets/css/wpdiscuz.css');
                if (file_exists($wpcTemplateStyleFile)) {
                    $wpdiscuzStyleURL = get_stylesheet_directory_uri() . '/wpdiscuz/wpdiscuz.css';
                } elseif (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . 'wpdiscuz' . DIRECTORY_SEPARATOR . 'wpdiscuz.css')) {
                    $wpdiscuzStyleURL = get_template_directory_uri() . '/wpdiscuz/wpdiscuz.css';
                }
                wp_register_style('wpdiscuz-frontend-css', $wpdiscuzStyleURL, null, $version);
            }

            public function wpDiscuzSuperSocializerLogin($html, $theChampLoginOptions) {
                global $wp_current_filter;
                if (in_array('comment_form_top', $wp_current_filter) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && count($theChampLoginOptions['providers']) > 0) {
                    $html = '<style type="text/css">#wpcomm .wc_social_plugin_wrapper .wp-social-login-connect-with_by_the_champ{float:left;font-size:13px;padding:5px 7px 0 0;text-transform:uppercase}#wpcomm .wc_social_plugin_wrapper ul.wc_social_login_by_the_champ{list-style:none outside none!important;margin:0!important;padding-left:0!important}#wpcomm .wc_social_plugin_wrapper ul.wc_social_login_by_the_champ .theChampLogin{width:24px!important;height:24px!important}#wpcomm .wc-secondary-forms-social-content ul.wc_social_login_by_the_champ{list-style:none outside none!important;margin:0!important;padding-left:0!important}#wpcomm .wc-secondary-forms-social-content ul.wc_social_login_by_the_champ .theChampLogin{width:24px!important;height:24px!important}#wpcomm .wc-secondary-forms-social-content ul.wc_social_login_by_the_champ li{float:right!important}#wpcomm .wc_social_plugin_wrapper .theChampFacebookButton{ display:block!important; }#wpcomm .theChampTwitterButton{background-position:-4px -68px!important}#wpcomm .theChampGoogleButton{background-position:-36px -2px!important}#wpcomm .theChampVkontakteButton{background-position:-35px -67px!important}#wpcomm .theChampLinkedinButton{background-position:-34px -34px!important;}.theChampCommentingTabs #wpcomm li{ margin:0px 1px 10px 0px!important; }</style>';
                    $html .= '<div class="wp-social-login-widget">';
                    $html .= '<div class="wp-social-login-connect-with_by_the_champ">' . $this->optionsSerialized->phrases['wc_connect_with'] . ':</div>';
                    $html .= '<div class="wp-social-login-provider-list">';
                    if (isset($theChampLoginOptions['gdpr_enable'])) {
                        $html .= '<div class="heateor_ss_sl_optin_container"><label><input type="checkbox" class="heateor_ss_social_login_optin" value="1" />' . str_replace($theChampLoginOptions['ppu_placeholder'], '<a href="' . $theChampLoginOptions['privacy_policy_url'] . '" target="_blank">' . $theChampLoginOptions['ppu_placeholder'] . '</a>', wp_strip_all_tags($theChampLoginOptions['privacy_policy_optin_text'])) . '</label></div>';
                    }
                    $html .= '<ul class="wc_social_login_by_the_champ">';
                    foreach ($theChampLoginOptions['providers'] as $provider) {
                        $html .= '<li><i ';
                        if ($provider == 'google') {
                            $html .= 'id="theChamp' . ucfirst($provider) . 'Button" ';
                        }
                        $html .= 'class="theChampLogin theChamp' . ucfirst($provider) . 'Background theChamp' . ucfirst($provider) . 'Login" ';
                        $html .= 'alt="Login with ';
                        $html .= ucfirst($provider);
                        $html .= '" title="Login with ';
                        if ($provider == 'live') {
                            $html .= 'Windows Live';
                        } else {
                            $html .= ucfirst($provider);
                        }
                        $html .= '" onclick="theChampCommentFormLogin = true; theChampInitiateLogin(this)" >';
                        $html .= '<ss style="display:block" class="theChampLoginSvg theChamp' . ucfirst($provider) . 'LoginSvg"></ss></i></li>';
                    }
                    $html .= '</ul><div class="wpdiscuz_clear"></div></div></div>';
                }
                return $html;
            }

            public function getAuthorPostsUrl($author_id, $author_nicename = '') {
                $authorURL = '';
                $post_types = apply_filters('wpdiscuz_author_post_types', array('post'));
                if (count_user_posts($author_id, $post_types)) {
                    return get_author_posts_url($author_id, $author_nicename);
                }
                $authorURL = apply_filters('author_link', $authorURL, $author_id, $author_nicename);
                return $authorURL;
            }

            public static function getCurrentUser() {
                global $user_ID;
                if ($user_ID) {
                    $user = get_userdata($user_ID);
                } else {
                    $user = wp_set_current_user(0);
                }
                return $user;
            }

            public function canUserEditComment($comment, $currentUser, $commentListArgs = array()) {
                $currentIP = $this->getRealIPAddr();
                if (isset($commentListArgs['comment_author_email'])) {
                    $storedCookieEmail = $commentListArgs['comment_author_email'];
                } else {
                    $storedCookieEmail = isset($_COOKIE['comment_author_email_' . COOKIEHASH]) ? $_COOKIE['comment_author_email_' . COOKIEHASH] : '';
                }
                return ($storedCookieEmail == $comment->comment_author_email && $currentIP == $comment->comment_author_IP) || ($currentUser && $currentUser->ID && $currentUser->ID == $comment->user_id);
            }

            public function addCommentTypes($args) {
                $args[self::WPDISCUZ_STICKY_COMMENT] = __('Sticky', 'woodiscuz');
                return $args;
            }

            public function commentRowStickAction($actions, $comment) {
                if (!$comment->comment_parent) {
                    $stickText = $comment->comment_type == self::WPDISCUZ_STICKY_COMMENT ? $this->optionsSerialized->phrases['wc_unstick_comment'] : $this->optionsSerialized->phrases['wc_stick_comment'];
                    if ($comment->comment_karma) {
                        $closeText = $this->optionsSerialized->phrases['wc_open_comment'];
                        $closeIcon = 'fa-lock';
                    } else {
                        $closeText = $this->optionsSerialized->phrases['wc_close_comment'];
                        $closeIcon = 'fa-unlock';
                    }
                    $actions['stick'] = '<a data-comment="' . $comment->comment_ID . '" data-post="' . $comment->comment_post_ID . '" class="wc_stick_btn" href="#"> <i class="fas fa-thumbtack"></i> <span class="wc_stick_text">' . $stickText . '</span></a>';
                    $actions['close'] = '<a data-comment="' . $comment->comment_ID . '" data-post="' . $comment->comment_post_ID . '" class="wc_close_btn" href="#"> <i class="fas ' . $closeIcon . '"></i> <span class="wc_close_text">' . $closeText . '</span></a>';
                }
                return $actions;
            }

            public function wpdDeactivationReasonModal() {
                include_once 'deactivation-reason-modal.php';
            }

            public function disableAddonsDemo() {
                if (current_user_can('manage_options') && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'disableAddonsDemo') && isset($_GET['show'])) {
                    update_option(self::OPTION_SLUG_SHOW_DEMO, intval($_GET['show']));
                    wp_redirect(admin_url('edit-comments.php?page=' . WpdiscuzCore::PAGE_SETTINGS));
                }
            }

            public function getCommentDate($comment) {
                if ($this->optionsSerialized->simpleCommentDate) {
                    $dateFormat = $this->optionsSerialized->wordpressDateFormat;
                    $timeFormat = $this->optionsSerialized->wordpressTimeFormat;
                    if (self::isPostedToday($comment)) {
                        $postedDate = $this->optionsSerialized->phrases['wc_posted_today_text'] . ' ' . mysql2date($timeFormat, $comment->comment_date);
                    } else {
                        $postedDate = get_comment_date($dateFormat . ' ' . $timeFormat, $comment->comment_ID);
                    }
                } else {
                    $postedDate = $this->dateDiff($comment->comment_date_gmt);
                }
                return $postedDate;
            }

            public function getPostDate($post) {
                if ($this->optionsSerialized->simpleCommentDate) {
                    $dateFormat = $this->optionsSerialized->wordpressDateFormat;
                    $timeFormat = $this->optionsSerialized->wordpressTimeFormat;
                    if ($this->isPostPostedToday($post)) {
                        $postedDate = $this->optionsSerialized->phrases['wc_posted_today_text'] . ' ' . mysql2date($timeFormat, $post->post_date);
                    } else {
                        $postedDate = get_the_date($dateFormat . ' ' . $timeFormat, $post);
                    }
                } else {
                    $postedDate = $this->dateDiff($post->post_date_gmt);
                }
                return $postedDate;
            }

            public function getDate($comment) {
                if ($this->optionsSerialized->simpleCommentDate) {
                    $dateFormat = $this->optionsSerialized->wordpressDateFormat;
                    $timeFormat = $this->optionsSerialized->wordpressTimeFormat;
                    if (self::isPostedToday($comment)) {
                        $postedDate = $this->optionsSerialized->phrases['wc_posted_today_text'] . ' ' . mysql2date($timeFormat, $comment);
                    } else {
                        $postedDate = date($dateFormat . ' ' . $timeFormat, strtotime($comment));
                    }
                } else {
                    $postedDate = $this->dateDiff($comment);
                }
                return $postedDate;
            }

            private function isPostPostedToday($post) {
                return date('Ymd', strtotime(current_time('Ymd'))) <= date('Ymd', strtotime($post->post_date));
            }

            public function formBottom($isMain, $form, $currentUser, $commentsCount) {
                include_once 'form-bottom-statistics.php';
            }

            public function wpdGetInfo() {
                $response = '';
                $currentUser = self::getCurrentUser();
                if ($currentUser && $currentUser->ID) {
                    $currentUserId = $currentUser->ID;
                    $currentUserEmail = $currentUser->user_email;
                } else {
                    $currentUserId = 0;
                    $currentUserEmail = isset($_COOKIE['comment_author_email_' . COOKIEHASH]) ? $_COOKIE['comment_author_email_' . COOKIEHASH] : '';
                }

                if (is_user_logged_in()) {
                    $response .= "<div class='wpd-wrapper'>";
                    $response .= "<ul class='wpd-list'>";
                    $response .= $this->getActivityTitleHtml();
                    $response .= $this->getSubscriptionsTitleHtml();
                    $response .= $this->getFollowsTitleHtml();
                    $response .= "</ul>";
                    $response .= "<div class='wpd-content'>";
                    $response .= $this->getActivityContentHtml($currentUserId, $currentUserEmail);
                    $response .= $this->getSubscriptionsContentHtml($currentUserId, $currentUserEmail);
                    $response .= $this->getFollowsContentHtml($currentUserId, $currentUserEmail);
                    $response .= "</div>";
                    $response .= "<div class='wpd-user-email-delete-links-wrap'>";
                    $response .= "<a href='#' class='wpd-user-email-delete-links wpd-not-clicked'>";
                    $response .= $this->optionsSerialized->phrases['wc_user_settings_email_me_delete_links'];
                    $response .= "<span class='wpd-loading wpd-hide'><i class='fas fa-pulse fa-spinner'></i></span>";
                    $response .= "</a>";
                    $response .= "<div class='wpd-bulk-desc'>" . $this->optionsSerialized->phrases['wc_user_settings_email_me_delete_links_desc'] . "</div>";
                    $response .= "</div>";
                    $response .= "</div>";
                } else if ($currentUserEmail) {
                    $commentBtn = $this->getDeleteAllCommentsButton($currentUserEmail);
                    $subscribeBtn = $this->getDeleteAllSubscriptionsButton($currentUserEmail);
                    $cookieBtnClass = !$commentBtn && !$subscribeBtn ? 'wpd-show' : 'wpd-hide';
                    $response .= "<div class='wpd-wrapper wpd-guest-settings'>";
                    $response .= $commentBtn;
                    $response .= $subscribeBtn;
                    $response .= $this->deleteCookiesButton($currentUserEmail, $cookieBtnClass);
                    $response .= "</div>";
                } else {
                    $response .= "<div class='wpd-wrapper'>";
                    $response .= $this->optionsSerialized->phrases['wc_user_settings_no_data'];
                    $response .= "</div>";
                }
                wp_die($response);
            }

            private function getDeleteAllCommentsButton($email) {
                $html = '';
                if (!is_email($email)) {
                    return $html;
                }
                $commentCount = get_comments(array('author_email' => $email, 'count' => true));
                if ($commentCount) {
                    $html .= '<div class="wpd-user-settings-button-wrap">';
                    $html .= '<div class="wpd-user-settings-button wpd-delete-all-comments wpd-not-clicked" data-wpd-delete-action="deleteComments">';
                    $html .= $this->optionsSerialized->phrases['wc_user_settings_request_deleting_comments'];
                    $html .= '<span class="wpd-loading wpd-hide"><i class="fas fa-spinner fa-pulse"></i></span>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
                return $html;
            }

            private function getDeleteAllSubscriptionsButton($email) {
                $html = '';
                if (!is_email($email)) {
                    return $html;
                }
                $subscriptions = $this->dbManager->getSubscriptions($email, 1, 0);
                if ($subscriptions) {
                    $html .= '<div class="wpd-user-settings-button-wrap">';
                    $html .= '<div class="wpd-user-settings-button wpd-delete-all-subscriptions wpd-not-clicked" data-wpd-delete-action="deleteSubscriptions">';
                    $html .= $this->optionsSerialized->phrases['wc_user_settings_cancel_subscriptions'];
                    $html .= '<span class="wpd-loading wpd-hide"><i class="fas fa-spinner fa-pulse"></i></span>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
                return $html;
            }

            private function deleteCookiesButton($email, $cookieBtnClass) {
                $html = '';
                if (!is_email($email)) {
                    return $html;
                }
                $html .= '<div class="wpd-user-settings-button-wrap ' . $cookieBtnClass . '">';
                $html .= '<div class="wpd-user-settings-button wpd-delete-all-cookies wpd-not-clicked" data-wpd-delete-action="deleteCookies">';
                $html .= $this->optionsSerialized->phrases['wc_user_settings_clear_cookie'];
                $html .= '<span class="wpd-loading wpd-hide"><i class="fas fa-spinner fa-pulse"></i></span>';
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            }

            private function getActivityTitleHtml() {
                ob_start();
                include_once 'layouts/activity/title.php';
                return ob_get_clean();
            }

            private function getActivityContentHtml($currentUserId, $currentUserEmail) {
                $html = "<div id='wpd-content-item-1' class='wpd-content-item'>";
                include_once 'layouts/activity/content.php';
                $html .= "</div>";
                return $html;
            }

            public function getActivityPage() {
                ob_start();
                include_once 'layouts/activity/activity-page.php';
                $html = ob_get_clean();
                wp_die($html);
            }

            private function getSubscriptionsTitleHtml() {
                ob_start();
                include_once 'layouts/subscriptions/title.php';
                return ob_get_clean();
            }

            private function getSubscriptionsContentHtml($currentUserId, $currentUserEmail) {
                $html = "<div id='wpd-content-item-2' class='wpd-content-item'>";
                include_once 'layouts/subscriptions/content.php';
                $html .= "</div>";
                return $html;
            }

            public function getSubscriptionsPage() {
                ob_start();
                include_once 'layouts/subscriptions/subscriptions-page.php';
                $html = ob_get_clean();
                wp_die($html);
            }

            private function getFollowsTitleHtml() {
                ob_start();
                include_once 'layouts/follows/title.php';
                return ob_get_clean();
            }

            private function getFollowsContentHtml($currentUserId, $currentUserEmail) {
                $html = "<div id='wpd-content-item-3' class='wpd-content-item'>";
                include_once 'layouts/follows/content.php';
                $html .= "</div>";
                return $html;
            }

            public function getFollowsPage() {
                ob_start();
                include_once 'layouts/follows/follows-page.php';
                $html = ob_get_clean();
                wp_die($html);
            }

            public function hashVotesNote() {
                if ($this->dbManager->getNotHashedIpCount()) {
                    $page = isset($_GET['page']) ? $_GET['page'] : '';
                    if ($page != self::PAGE_TOOLS) {
                        $goToHashUrl = get_admin_url(WpdiscuzCore::$CURRENT_BLOG_ID, 'edit-comments.php?page=') . self::PAGE_TOOLS . '#toolsTab4';
                        $html = "<div class='error' style='padding:10px;'>";
                        $html .= "<p>" . __('Before using wpDiscuz you should update your data', $goToHashUrl) . "</p>";
                        $html .= "<a class='' href='$goToHashUrl'>" . __('Go to update data', 'wpdiscuz') . "</a>";
                        $html .= "</div>";
                        echo$html;
                    }
                }
            }

            public static function fixEmailFrom($domain) {
                $domain = strtolower($domain);
                if (substr($domain, 0, 4) == 'www.') {
                    $domain = substr($domain, 4);
                }
                return $domain;
            }

            public function fixLocalhostIp($ip) {
                if (trim($ip) == '::1') {
                    $ip = '127.0.0.1';
                }
                return $ip;
            }

        }
        