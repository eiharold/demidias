<?php

if (!defined('ABSPATH')) {
    exit();
}

class WpdiscuzHelperAjax implements WpDiscuzConstants {

    private $optionsSerialized;
    private $dbManager;
    private $helper;
    private $helperEmail;

    public function __construct($optionsSerialized, $dbManager, $helper, $helperEmail) {
        $this->optionsSerialized = $optionsSerialized;
        $this->dbManager = $dbManager;
        $this->helper = $helper;
        $this->helperEmail = $helperEmail;
        add_filter('wp_update_comment_data', array(&$this, 'commentDataArr'), 10, 3);
        add_action('wp_ajax_wpdStickComment', array(&$this, 'stickComment'));
        add_action('wp_ajax_wpdCloseThread', array(&$this, 'closeThread'));
        add_action('wp_ajax_wpdDeactivate', array(&$this, 'deactivate'));
        add_action('wp_ajax_wpdImportSTCR', array(&$this, 'importSTCR'));
        add_action('wp_ajax_wpdHashVoteIps', array(&$this, 'hashVoteIps'));
        add_action('wp_ajax_wpdFollowUser', array(&$this, 'followUser'));
    }

    public function commentDataArr($data, $comment, $commentarr) {
        if (isset($data['wpdiscuz_comment_update']) && $data['wpdiscuz_comment_update']) {
            $data['comment_date'] = $comment['comment_date'];
            $data['comment_date_gmt'] = $comment['comment_date_gmt'];
        }
        return $data;
    }

    public function stickComment() {
        $response = array('code' => 0, 'data' => '');
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $commentId = isset($_POST['commentId']) ? intval($_POST['commentId']) : 0;
        if ($postId && $commentId) {
            $comment = get_comment($commentId);
            $userCanStickComment = current_user_can('moderate_comments');
            if (!$userCanStickComment) {
                $post = get_post($postId);
                $currentUser = WpdiscuzHelper::getCurrentUser();
                $userCanStickComment = $post && isset($post->post_author) && $currentUser && isset($currentUser->ID) && $post->post_author == $currentUser->ID;
            }
            if ($userCanStickComment && $comment && isset($comment->comment_ID) && $comment->comment_ID && !$comment->comment_parent) {
                $commentarr = array('comment_ID' => $commentId);
                if ($comment->comment_type == self::WPDISCUZ_STICKY_COMMENT) {
                    $commentarr['comment_type'] = '';
                    $response['data'] = $this->optionsSerialized->phrases['wc_stick_comment'];
                } else {
                    $commentarr['comment_type'] = self::WPDISCUZ_STICKY_COMMENT;
                    $response['data'] = $this->optionsSerialized->phrases['wc_unstick_comment'];
                }
                $commentarr['wpdiscuz_comment_update'] = true;
                if (wp_update_comment(wp_slash($commentarr))) {
                    $response['code'] = 1;
                }
            }
        }
        wp_die(json_encode($response));
    }

    public function closeThread() {
        $response = array('code' => 0, 'data' => '');
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $commentId = isset($_POST['commentId']) ? intval($_POST['commentId']) : 0;
        if ($postId && $commentId) {
            $comment = get_comment($commentId);
            $userCanCloseComment = current_user_can('moderate_comments');
            if (!$userCanCloseComment) {
                $post = get_post($postId);
                $currentUser = WpdiscuzHelper::getCurrentUser();
                $userCanCloseComment = $post && isset($post->post_author) && $currentUser && isset($currentUser->ID) && $post->post_author == $currentUser->ID;
            }
            if ($userCanCloseComment && $comment && isset($comment->comment_ID) && $comment->comment_ID && !$comment->comment_parent) {
                $children = $comment->get_children(array(
                    'format' => 'flat',
                    'status' => 'all',
                ));

                if (absint($comment->comment_karma)) {
                    $response['data'] = $this->optionsSerialized->phrases['wc_close_comment'];
                    $response['icon'] = 'fa-unlock';
                } else {
                    $response['data'] = $this->optionsSerialized->phrases['wc_open_comment'];
                    $response['icon'] = 'fa-lock';
                }
                $commentarr = array(
                    'comment_ID' => $comment->comment_ID,
                    'comment_karma' => !(boolval($comment->comment_karma)),
                    'wpdiscuz_comment_update' => true,
                );
                if (wp_update_comment(wp_slash($commentarr))) {
                    $response['code'] = 1;
                    if ($children && is_array($children)) {
                        foreach ($children as $child) {
                            $commentarr['comment_ID'] = $child->comment_ID;
                            wp_update_comment($commentarr);
                        }
                    }
                }
            }
        }
        wp_die(json_encode($response));
    }

    public function deactivate() {
        $response = array('code' => 0);
        $json = filter_input(INPUT_POST, 'deactivateData');
        if ($json) {
            parse_str($json, $data);
            if (isset($data['never_show']) && ($v = intval($data['never_show']))) {
                update_option(self::OPTION_SLUG_DEACTIVATION, $v);
                $response['code'] = 'dismiss_and_deactivate';
            } else if (isset($data['deactivation_reason']) && ($reason = trim($data['deactivation_reason']))) {
                $pluginData = get_plugin_data(WPDISCUZ_DIR_PATH . "/class.WpdiscuzCore.php");
                $blogTitle = get_option('blogname');
                $to = 'feedback@wpdiscuz.com';
                $subject = '[wpDiscuz Feedback - ' . $pluginData['Version'] . '] - ' . $reason;
                $headers = array();
                $contentType = 'text/html';
                $fromName = apply_filters('wp_mail_from_name', $blogTitle);
                $fromName = html_entity_decode($fromName, ENT_QUOTES);
                $siteUrl = get_site_url();
                $parsedUrl = parse_url($siteUrl);
                $domain = isset($parsedUrl['host']) ? WpdiscuzHelper::fixEmailFrom($parsedUrl['host']) : '';
                $fromEmail = 'no-reply@' . $domain;
                $headers[] = "Content-Type:  $contentType; charset=UTF-8";
                $headers[] = "From: " . $fromName . " <" . $fromEmail . "> \r\n";
                $message = "<strong>Deactivation reason:</strong> " . $reason . "\r\n" . "<br/>";
                if (isset($data['deactivation_reason_desc']) && ($reasonDesc = trim($data['deactivation_reason_desc']))) {
                    $message .= "<strong>Deactivation reason description:</strong> " . $reasonDesc . "\r\n" . "<br/>";
                }
                $subject = html_entity_decode($subject, ENT_QUOTES);
                $message = html_entity_decode($message, ENT_QUOTES);
                $sent = wp_mail($to, $subject, do_shortcode($message), $headers);
                $response['code'] = 'send_and_deactivate';
            }
        }
        wp_die(json_encode($response));
    }

    public function importSTCR() {
        $response = array('progress' => 0);
        $stcrData = isset($_POST['stcrData']) ? $_POST['stcrData'] : '';
        if ($stcrData) {
            parse_str($stcrData, $data);
            $limit = 50;
            $step = isset($data['stcr-step']) ? intval($data['stcr-step']) : 0;
            $stcrSubscriptionsCount = isset($data['stcr-subscriptions-count']) ? intval($data['stcr-subscriptions-count']) : 0;
            $nonce = isset($data['_wpnonce']) ? trim($data['_wpnonce']) : '';
            if (wp_verify_nonce($nonce, 'wc_tools_form') && $stcrSubscriptionsCount) {
                $offset = $limit * $step;
                if ($limit && $offset >= 0) {
                    $subscriptions = $this->dbManager->getStcrSubscriptions($limit, $offset);
                    if ($subscriptions) {
                        $this->dbManager->addStcrSubscriptions($subscriptions);
                        ++$step;
                        $response['step'] = $step;
                        $progress = $offset ? $offset * 100 / $stcrSubscriptionsCount : $limit * 100 / $stcrSubscriptionsCount;
                        $response['progress'] = intval($progress);
                    } else {
                        $response['progress'] = 100;
                    }
                }
            }
        }
        wp_die(json_encode($response));
    }

    public function hashVoteIps() {
        $response = array('progress' => 0);
        $notHashedData = isset($_POST['notHashedData']) ? $_POST['notHashedData'] : '';
        if ($notHashedData) {
            parse_str($notHashedData, $data);
            $limit = 200;
            $step = isset($data['hashing-step']) ? intval($data['hashing-step']) : 0;
            $notHashedCount = isset($data['not-hashed-count']) ? intval($data['not-hashed-count']) : 0;
            $notHashedStartId = isset($data['not-hashed-start-id']) ? intval($data['not-hashed-start-id']) : 0;
            $nonce = isset($data['_wpnonce']) ? trim($data['_wpnonce']) : '';
            if (wp_verify_nonce($nonce, 'wc_tools_form') && $notHashedCount && $notHashedStartId >= 0) {
                $notHashedVoteData = $this->dbManager->getNotHashedVoteData($notHashedStartId, $limit);
                if ($notHashedVoteData) {
                    $this->dbManager->hashVoteIps($notHashedVoteData);
                    ++$step;
                    $progress = $step * $limit * 100 / $notHashedCount;
                    $response['progress'] = ($p = intval($progress)) > 100 ? 100 : $p;
                    $response['startId'] = $notHashedVoteData[count($notHashedVoteData) - 1];
                } else {
                    $response['progress'] = 100;
                    $response['startId'] = 0;
                }
                $response['step'] = $step;
            }
        }
        wp_die(json_encode($response));
    }

    public function deleteComment() {
        $commentId = isset($_POST['id']) ? intval($_POST['id']) : 0;
        wp_delete_comment($commentId, true);
        $this->helper->getActivityPage();
    }

    public function deleteSubscription() {
        $subscriptionId = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $this->dbManager->unsubscribeById($subscriptionId);
        $this->helper->getSubscriptionsPage();
    }

    public function deleteFollow() {
        $followId = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $this->dbManager->unfollowById($followId);
        $this->helper->getFollowsPage();
    }

    public function emailDeleteLinks() {
        global $wp_rewrite;
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $post = get_post($postId);
        $currentUser = WpdiscuzHelper::getCurrentUser();
        if ($post && $currentUser->exists()) {
            $currentUserEmail = $currentUser->user_email;

            if ($currentUserEmail) {
                $siteUrl = get_site_url();
                $blogTitle = html_entity_decode(get_option('blogname'), ENT_QUOTES);
                $hashValue = $this->generateUserActionHash($currentUserEmail);
                $mainUrl = !$wp_rewrite->using_permalinks() ? get_permalink($post) . "&" : get_permalink($post) . "?";
                $deleteCommentsUrl = $mainUrl . "wpdiscuzUrlAnchor&deleteComments=$hashValue";
                $unsubscribeUrl = $mainUrl . "wpdiscuzUrlAnchor&deleteSubscriptions=$hashValue";
                $unfollowUrl = $mainUrl . "wpdiscuzUrlAnchor&deleteFollows=$hashValue";

                $subject = $this->optionsSerialized->phrases['wc_user_settings_delete_links'];
                $message = $this->optionsSerialized->phrases['wc_user_settings_delete_all_comments_message'];

                if (strpos($message, '[SITE_URL]') !== false) {
                    $message = str_replace('[SITE_URL]', $siteUrl, $message);
                }

                if (strpos($message, '[BLOG_TITLE]') !== false) {
                    $message = str_replace('[BLOG_TITLE]', $blogTitle, $message);
                }

                if (strpos($message, '[DELETE_COMMENTS_URL]') !== false) {
                    $message = str_replace('[DELETE_COMMENTS_URL]', $deleteCommentsUrl, $message);
                }

                $message .= $this->optionsSerialized->phrases['wc_user_settings_delete_all_subscriptions_message'];

                if (strpos($message, '[DELETE_SUBSCRIPTIONS_URL]') !== false) {
                    $message = str_replace('[DELETE_SUBSCRIPTIONS_URL]', $unsubscribeUrl, $message);
                }

                $message .= $this->optionsSerialized->phrases['wc_user_settings_delete_all_follows_message'];

                if (strpos($message, '[DELETE_FOLLOWS_URL]') !== false) {
                    $message = str_replace('[DELETE_FOLLOWS_URL]', $unfollowUrl, $message);
                }

                $this->userActionMail($currentUserEmail, $subject, $message);
            }
        }
        wp_die();
    }

    public function guestAction() {
        global $wp_rewrite;
        $guestEmail = isset($_COOKIE['comment_author_email_' . COOKIEHASH]) ? $_COOKIE['comment_author_email_' . COOKIEHASH] : '';
        $guestAction = filter_input(INPUT_POST, 'guestAction', FILTER_SANITIZE_STRING);
        $postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);
        $post = get_post($postId);
        $response = array(
            'code' => 0,
            'message' => '<div class="wpd-guest-action-message wpd-guest-action-error">' . $this->optionsSerialized->phrases['wc_user_settings_email_error'] . '</div>'
        );
        if ($post && $guestEmail) {
            $hashValue = $this->generateUserActionHash($guestEmail);
            $mainUrl = !$wp_rewrite->using_permalinks() ? get_permalink($post) . "&" : get_permalink($post) . "?";
            $link = '';
            $message = '';
            $siteUrl = get_site_url();
            $blogTitle = html_entity_decode(get_option('blogname'), ENT_QUOTES);
            if ($guestAction == 'deleteComments') {
                $link = $mainUrl . "wpdiscuzUrlAnchor&deleteComments=$hashValue";
                $subject = $this->optionsSerialized->phrases['wc_user_settings_delete_all_comments'];
                $message = $this->optionsSerialized->phrases['wc_user_settings_delete_all_comments_message'];
                if (strpos($message, '[DELETE_COMMENTS_URL]') !== false) {
                    $message = str_replace('[DELETE_COMMENTS_URL]', $link, $message);
                }
            } elseif ($guestAction == 'deleteSubscriptions') {
                $subject = $this->optionsSerialized->phrases['wc_user_settings_delete_all_subscriptions'];
                $link = $mainUrl . "wpdiscuzUrlAnchor&deleteSubscriptions=$hashValue";
                $message = $this->optionsSerialized->phrases['wc_user_settings_delete_all_subscriptions_message'];
                if (strpos($message, '[DELETE_SUBSCRIPTIONS_URL]') !== false) {
                    $message = str_replace('[DELETE_SUBSCRIPTIONS_URL]', $link, $message);
                }
            }

            if (strpos($subject, '[SITE_URL]') !== false) {
                $subject = str_replace('[SITE_URL]', $siteUrl, $subject);
            }

            if (strpos($subject, '[BLOG_TITLE]') !== false) {
                $subject = str_replace('[BLOG_TITLE]', $blogTitle, $subject);
            }

            if (strpos($message, '[SITE_URL]') !== false) {
                $message = str_replace('[SITE_URL]', $siteUrl, $message);
            }

            if (strpos($message, '[BLOG_TITLE]') !== false) {
                $message = str_replace('[BLOG_TITLE]', $blogTitle, $message);
            }

            if ($this->userActionMail($guestEmail, $subject, $message)) {
                $response['code'] = 1;
                $parts = explode('@', $guestEmail);
                $guestEmail = substr($parts[0], 0, min(1, strlen($parts[0]) - 1)) . str_repeat('*', max(1, strlen($parts[0]) - 1)) . '@' . $parts[1];
                $response['message'] = '<div class="wpd-guest-action-message wpd-guest-action-success">' . $this->optionsSerialized->phrases['wc_user_settings_check_email'] . " ($guestEmail)" . '</div>';
            }
        }
        wp_die(json_encode($response));
    }

    private function generateUserActionHash($email) {
        $hashedEmail = hash_hmac('sha256', $email, get_option(self::OPTION_SLUG_HASH_KEY));
        $hashKey = self::TRS_USER_HASH . $hashedEmail;
        $hashExpire = apply_filters('wpdiscuz_delete_all_content', 3 * DAY_IN_SECONDS);
        set_transient($hashKey, $email, $hashExpire);
        return $hashedEmail;
    }

    private function userActionMail($email, $subject, $message) {
        $siteUrl = get_site_url();
        $blogTitle = get_option('blogname');
        $mailContentType = apply_filters('wp_mail_content_type', 'text/html');
        $fromName = apply_filters('wp_mail_from_name', $blogTitle);
        $fromName = html_entity_decode($fromName, ENT_QUOTES);
        $parsedUrl = parse_url($siteUrl);
        $domain = isset($parsedUrl['host']) ? WpdiscuzHelper::fixEmailFrom($parsedUrl['host']) : '';
        $fromEmail = 'no-reply@' . $domain;
        $fromEmail = apply_filters('wp_mail_from', $fromEmail);
        $headers[] = "Content-Type:  $mailContentType; charset=UTF-8";
        $headers[] = "From: " . $fromName . " <" . $fromEmail . "> \r\n";
        $subject = html_entity_decode($subject, ENT_QUOTES);
        $message = html_entity_decode($message, ENT_QUOTES);
        return wp_mail($email, $subject, do_shortcode($message), $headers);
    }

    public function followUser() {
        $response = array('code' => '', 'data' => array());
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $commentId = isset($_POST['commentId']) ? intval($_POST['commentId']) : 0;
        if ($postId && $commentId) {
            $comment = get_comment($commentId);
            if ($comment && $comment->comment_author_email) {
                $currentUser = WpdiscuzHelper::getCurrentUser();
                if ($currentUser && $currentUser->ID) {
                    $args = array(
                        'post_id' => $comment->comment_post_ID,
                        'user_id' => $comment->user_id,
                        'user_email' => $comment->comment_author_email,
                        'user_name' => $comment->comment_author,
                        'follower_id' => $currentUser->ID,
                        'follower_email' => $currentUser->user_email,
                        'follower_name' => $currentUser->display_name,
                        'confirm' => $this->optionsSerialized->disableFollowConfirmForUsers,
                    );
                    $followExists = $this->dbManager->isFollowExists($comment->comment_author_email, $currentUser->user_email);
                    if ($followExists) {
                        if (intval($followExists['confirm'])) { // confirmed follow already exists
                            $response['code'] = 'wc_follow_canceled';
                            $this->dbManager->cancelFollow($followExists['id'], $followExists['activation_key']);
                            $response['data']['followTip'] = $this->optionsSerialized->phrases['wc_follow_user'];
                        } else { // follow exists but not confirmed yet, send confirm email again if neccessary
                            if ($this->optionsSerialized->disableFollowConfirmForUsers) {
                                $this->dbManager->confirmFollow($followExists['id'], $followExists['activation_key']);
                                $response['code'] = 'wc_follow_success';
                                $response['data']['followClass'] = 'wc-follow-active';
                                $response['data']['followTip'] = $this->optionsSerialized->phrases['wc_unfollow_user'];
                            } else {
                                $this->followConfirmAction($response, $comment->comment_post_ID, $followExists['id'], $followExists['activation_key'], $args['follower_email']);
                            }
                        }
                    } else {
                        $followData = $this->dbManager->addNewFollow($args);
                        if ($followData) {
                            if ($this->optionsSerialized->disableFollowConfirmForUsers) {
                                $response['code'] = 'wc_follow_success';
                                $response['data']['followClass'] = 'wc-follow-active';
                                $response['data']['followTip'] = $this->optionsSerialized->phrases['wc_unfollow_user'];
                            } else {
                                $this->followConfirmAction($response, $comment->comment_post_ID, $followData['id'], $followData['activation_key'], $args['follower_email']);
                            }
                        } else {
                            $response['code'] = 'wc_follow_not_added';
                        }
                    }
                } else {
                    $response['code'] = 'wc_follow_login_to_follow';
                }
            } else {
                $response['code'] = 'wc_follow_impossible';
            }
        }
        wp_die(json_encode($response));
    }

    private function followConfirmAction(&$response, $postId, $id, $key, $email) {
        $send = $this->helperEmail->followConfirmEmail($postId, $id, $key, $email);
        if ($send) {
            $response['code'] = 'wc_follow_email_confirm';
        } else {
            $response['code'] = 'wc_follow_email_confirm_fail';
            $this->dbManager->cancelFollow($id, $key);
        }
    }

}
