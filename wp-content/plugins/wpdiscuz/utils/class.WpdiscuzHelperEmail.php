<?php

if (!defined('ABSPATH')) {
    exit();
}

class WpdiscuzHelperEmail implements WpDiscuzConstants {

    private $optionsSerialized;
    private $dbManager;

    public function __construct($optionsSerialized, $dbManager) {
        $this->optionsSerialized = $optionsSerialized;
        $this->dbManager = $dbManager;
    }

    public function addSubscription() {
        global $wp_rewrite;
        $currentUser = WpdiscuzHelper::getCurrentUser();
        $subscribeFormNonce = filter_input(INPUT_POST, 'wpdiscuz_subscribe_form_nonce');
        $httpReferer = filter_input(INPUT_POST, '_wp_http_referer');
        $subscriptionType = filter_input(INPUT_POST, 'wpdiscuzSubscriptionType');
        $postId = filter_input(INPUT_POST, 'wpdiscuzSubscriptionPostId');
        $showSubscriptionBarAgreement = filter_input(INPUT_POST, 'show_subscription_agreement', FILTER_SANITIZE_NUMBER_INT);
        $form = wpDiscuz()->wpdiscuzForm->getForm($postId);
        if ($currentUser && $currentUser->ID) {
            $email = $currentUser->user_email;
        } else {
            $email = filter_input(INPUT_POST, 'wpdiscuzSubscriptionEmail');
        }
        if (!$currentUser->exists() && $form->isShowSubscriptionBarAgreement() && !$showSubscriptionBarAgreement && ($subscriptionType == WpdiscuzCore::SUBSCRIPTION_POST || $subscriptionType == WpdiscuzCore::SUBSCRIPTION_ALL_COMMENT)) {
            $email = '';
        }
        $success = 0;
        if (wp_verify_nonce($subscribeFormNonce, 'wpdiscuz_subscribe_form_nonce_action') && $email && filter_var($email, FILTER_VALIDATE_EMAIL) !== false && in_array($subscriptionType, array(self::SUBSCRIPTION_POST, self::SUBSCRIPTION_ALL_COMMENT)) && $postId) {
            $noNeedMemberConfirm = ($currentUser->ID && $this->optionsSerialized->disableMemberConfirm);
            $noNeedGuestsConfirm = (!$currentUser->ID && $this->optionsSerialized->disableGuestsConfirm);
            if ($noNeedMemberConfirm || $noNeedGuestsConfirm) {
                $confirmData = $this->dbManager->addEmailNotification($postId, $postId, $email, $subscriptionType, 1);
                if ($confirmData) {
                    $success = 1;
                }
            } else {
                $confirmData = $this->dbManager->addEmailNotification($postId, $postId, $email, $subscriptionType, 0);
                if ($confirmData) {
                    $success = $this->confirmEmailSender($confirmData['id'], $confirmData['activation_key'], $postId, $email) ? 1 : -1;
                    if ($success < 0) {
                        $this->dbManager->unsubscribe($confirmData['id'], $confirmData['activation_key']);
                    }
                }
            }
        }
        $httpReferer .= $wp_rewrite->using_permalinks() ? "?wpdiscuzUrlAnchor&subscriptionSuccess=$success&subscriptionID=" . $confirmData['id'] . "#wc_unsubscribe_message" : "&wpdiscuzUrlAnchor&subscriptionSuccess=$success#wc_unsubscribe_message";
        wp_redirect($httpReferer);
        exit();
    }

    public function confirmEmailSender($id, $activationKey, $postId, $email) {
        $subject = $this->optionsSerialized->phrases['wc_confirm_email_subject'];
        $message = $this->optionsSerialized->phrases['wc_confirm_email_message'];
        $confirm_url = $this->dbManager->confirmLink($id, $activationKey, $postId);
        $unsubscribe_url = $this->dbManager->unsubscribeLink($postId, $email);
        $siteUrl = get_site_url();
        $blogTitle = get_option('blogname');
        $postTitle = get_the_title($postId);
        if (strpos($message, '[SITE_URL]') !== false) {
            $message = str_replace('[SITE_URL]', $siteUrl, $message);
        }
        if (strpos($message, '[POST_URL]') !== false) {
            $postPermalink = get_permalink($postId);
            $message = str_replace('[POST_URL]', $postPermalink, $message);
        }
        if (strpos($message, '[BLOG_TITLE]') !== false) {
            $message = str_replace('[BLOG_TITLE]', $blogTitle, $message);
        }
        if (strpos($message, '[POST_TITLE]') !== false) {
            $message = str_replace('[POST_TITLE]', $postTitle, $message);
        }
        if (strpos($subject, '[BLOG_TITLE]') !== false) {
            $subject = str_replace('[BLOG_TITLE]', $blogTitle, $subject);
        }
        if (strpos($subject, '[POST_TITLE]') !== false) {
            $subject = str_replace('[POST_TITLE]', $postTitle, $subject);
        }

        if (strpos($message, '[CONFIRM_URL]') === false) {
            $message .= "<br/><br/><a href='$confirm_url'>" . $this->optionsSerialized->phrases['wc_confirm_email'] . "</a>";
        } else {
            $message = str_replace('[CONFIRM_URL]', $confirm_url, $message);
        }

        if (strpos($message, '[CANCEL_URL]') === false) {
            $message .= "<br/><br/><a href='$unsubscribe_url'>" . $this->optionsSerialized->phrases['wc_ignore_subscription'] . "</a>";
        } else {
            $message = str_replace('[CANCEL_URL]', $unsubscribe_url, $message);
        }


        $headers = array();
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

    /**
     * send email
     */
    public function emailSender($emailData, $commentId, $subject, $message, $subscriptionType) {
        global $wp_rewrite;
        $comment = get_comment($commentId);
        $post = get_post($comment->comment_post_ID);
        $postAuthor = get_userdata($post->post_author);

        if ($emailData['email'] == $postAuthor->user_email) {
            if (get_option('moderation_notify') && !$comment->comment_approved) {
                return;
            } else if (get_option('comments_notify') && $comment->comment_approved) {
                return;
            }
        }
        $sendMail = apply_filters('wpdiscuz_email_notification', true, $emailData, $comment);
        if ($sendMail) {
            $unsubscribeUrl = !$wp_rewrite->using_permalinks() ? get_permalink($comment->comment_post_ID) . "&" : get_permalink($comment->comment_post_ID) . "?";
            $unsubscribeUrl .= "wpdiscuzUrlAnchor&wpdiscuzSubscribeID=" . $emailData['id'] . "&key=" . $emailData['activation_key'] . '&#wc_unsubscribe_message';


            $siteUrl = get_site_url();
            $blogTitle = get_option('blogname');
            $postTitle = get_the_title($comment->comment_post_ID);
            if (strpos($message, '[SITE_URL]') !== false) {
                $message = str_replace('[SITE_URL]', $siteUrl, $message);
            }
            if (strpos($message, '[POST_URL]') !== false) {
                $postPermalink = get_permalink($comment->comment_post_ID);
                $message = str_replace('[POST_URL]', $postPermalink, $message);
            }
            if (strpos($message, '[BLOG_TITLE]') !== false) {
                $message = str_replace('[BLOG_TITLE]', $blogTitle, $message);
            }
            if (strpos($message, '[POST_TITLE]') !== false) {
                $message = str_replace('[POST_TITLE]', $postTitle, $message);
            }
            if (strpos($message, '[COMMENT_URL]') !== false) {
                $commentPermalink = get_comment_link($commentId);
                $message = str_replace('[COMMENT_URL]', $commentPermalink, $message);
            }

            if ((strpos($message, '[COMMENT_AUTHOR]') !== false) && ($subscriptionType == self::SUBSCRIPTION_COMMENT)) {
                $parentComment = get_comment($comment->comment_parent);
                $commentAuthor = $parentComment && $parentComment->comment_author ? $parentComment->comment_author : '';
                $message = str_replace('[COMMENT_AUTHOR]', $commentAuthor, $message);
            } else {
                if ((strpos($message, '[SUBSCRIBER_NAME]') !== false) && ($subscriptionType == self::SUBSCRIPTION_ALL_COMMENT || $subscriptionType == self::SUBSCRIPTION_POST)) {
                    $user = get_user_by('email', $emailData['email']);
                    $commentAuthor = $user && $user->display_name ? $user->display_name : '';
                    $message = str_replace('[SUBSCRIBER_NAME]', $commentAuthor, $message);
                }
            }
            if (strpos($message, '[COMMENT_CONTENT]') !== false) {
                $message = str_replace('[COMMENT_CONTENT]', $comment->comment_content, $message);
            }
            if (strpos($subject, '[BLOG_TITLE]') !== false) {
                $subject = str_replace('[BLOG_TITLE]', $blogTitle, $subject);
            }
            if (strpos($subject, '[POST_TITLE]') !== false) {
                $subject = str_replace('[POST_TITLE]', $postTitle, $subject);
            }

            if (strpos($message, '[UNSUBSCRIBE_URL]') === false) {
                $message .= "<br/><br/><a href='$unsubscribeUrl'>" . $this->optionsSerialized->phrases['wc_unsubscribe'] . "</a>";
            } else {
                $message = str_replace('[UNSUBSCRIBE_URL]', $unsubscribeUrl, $message);
            }

            $headers = array();
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
            wp_mail($emailData['email'], $subject, do_shortcode($message), $headers);
        }
    }

    /**
     * Check notification type and send email to post new comments subscribers
     */
    public function checkNotificationType() {
        $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
        $commentId = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $isParent = isset($_POST['isParent']) ? intval($_POST['isParent']) : '';
        $currentUser = WpdiscuzHelper::getCurrentUser();
        if ($currentUser && $currentUser->user_email) {
            $email = $currentUser->user_email;
        }
        if ($commentId && $email && $postId) {
            $this->notifyPostSubscribers($postId, $commentId, $email);
            $this->notifyFollowers($postId, $commentId, $email);
            if (!$isParent) {
                $comment = get_comment($commentId);
                $parentCommentId = $comment->comment_parent;
                $parentComment = get_comment($parentCommentId);
                $parentCommentEmail = $parentComment->comment_author_email;
                if ($parentCommentEmail != $email) {
                    $this->notifyAllCommentSubscribers($postId, $commentId, $email);
                    $this->notifyCommentSubscribers($parentCommentId, $comment->comment_ID, $email);
                }
            }
        }
        wp_die();
    }

    /**
     * Send notifications for new comments on the post (including replies)
     *
     * @param $postId      int
     * @param $commentId   int
     * @param $email       string
     */
    public function notifyPostSubscribers($postId, $commentId, $email) {
        $emailsArray = $this->dbManager->getPostNewCommentNotification($postId, $email);
        $subject = $this->optionsSerialized->phrases['wc_email_subject'];
        $message = $this->optionsSerialized->phrases['wc_email_message'];
        foreach ($emailsArray as $eRow) {
            $subscriberUserId = $eRow['id'];
            $subscriberEmail = $eRow['email'];
            $this->emailSender($eRow, $commentId, $subject, $message, self::SUBSCRIPTION_POST);
            do_action('wpdiscuz_notify_post_subscribers', $postId, $commentId, $subscriberUserId, $subscriberEmail);
        }
    }

    /**
     * Send notifications for new comments on the post (including replies)
     *
     * @param $postId           int
     * @param $newCommentId     int
     * @param $email            string
     */
    public function notifyAllCommentSubscribers($postId, $newCommentId, $email) {
        $emailsArray = $this->dbManager->getAllNewCommentNotification($postId, $email);
        $subject = $this->optionsSerialized->phrases['wc_all_comment_new_reply_subject'];
        $message = $this->optionsSerialized->phrases['wc_all_comment_new_reply_message'];
        foreach ($emailsArray as $eRow) {
            $subscriberUserId = $eRow['id'];
            $subscriberEmail = $eRow['email'];
            $this->emailSender($eRow, $newCommentId, $subject, $message, self::SUBSCRIPTION_ALL_COMMENT);
            do_action('wpdiscuz_notify_all_comment_subscribers', $postId, $newCommentId, $subscriberUserId, $subscriberEmail);
        }
    }

    /**
     * Send notifications for new replies to an individual comment
     * (includes all replies)
     *
     * @param $parentCommentId    int
     * @param $newCommentId       int
     * @param $email              string  email address to exclude (the comment author email)
     */
    public function notifyCommentSubscribers($parentCommentId, $newCommentId, $email) {
        $emailsArray = $this->dbManager->getNewReplyNotification($parentCommentId, $email);
        $subject = $this->optionsSerialized->phrases['wc_new_reply_email_subject'];
        $message = $this->optionsSerialized->phrases['wc_new_reply_email_message'];
        foreach ($emailsArray as $eRow) {
            $subscriberUserId = $eRow['id'];
            $subscriberEmail = $eRow['email'];
            $this->emailSender($eRow, $newCommentId, $subject, $message, self::SUBSCRIPTION_COMMENT);
            do_action('wpdiscuz_notify_comment_subscribers', $parentCommentId, $newCommentId, $subscriberUserId, $subscriberEmail);
        }
    }

    /**
     * When a comment is approved from the admin comments.php or posts.php... notify the subscribers
     *
     * @param $commentId       int
     * @param $approved        bool
     */
    public function notificationFromDashboard($commentId, $approved) {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $comment = get_comment($commentId);
        $commentsPage = strpos($referer, 'edit-comments.php') !== false;
        $postCommentsPage = (strpos($referer, 'post.php') !== false) && (strpos($referer, 'action=edit') !== false);
        if ($approved == 1 && ($commentsPage || $postCommentsPage) && $comment) {
            $postId = $comment->comment_post_ID;
            $email = $comment->comment_author_email;
            $parentComment = $comment->comment_parent ? get_comment($comment->comment_parent) : 0;
            $this->notifyPostSubscribers($postId, $commentId, $email);
            if ($parentComment) {
                $parentCommentEmail = $parentComment->comment_author_email;
                if ($parentCommentEmail != $email) {
                    $this->notifyAllCommentSubscribers($postId, $commentId, $email);
                    $this->notifyCommentSubscribers($parentComment->comment_ID, $commentId, $email);
                }
            }
        }
    }

    /**
     * When a comment is approved (after being held for moderation)... notify the author
     *
     * @param $comment  WP_Comment
     */
    public function notifyOnApproving($comment) {
        if ($comment) {
            $user = $comment->user_id ? get_userdata($comment->user_id) : null;
            if ($user) {
                $email = $user->user_email;
            } else {
                $email = $comment->comment_author_email;
            }

            $subject = $this->optionsSerialized->phrases['wc_comment_approved_email_subject'];
            $message = $this->optionsSerialized->phrases['wc_comment_approved_email_message'];
            $siteUrl = get_site_url();
            $blogTitle = get_option('blogname');
            $postTitle = get_the_title($comment->comment_post_ID);
            if (strpos($message, '[SITE_URL]') !== false) {
                $message = str_replace('[SITE_URL]', $siteUrl, $message);
            }
            if (strpos($message, '[POST_URL]') !== false) {
                $postPermalink = get_permalink($comment->comment_post_ID);
                $message = str_replace('[POST_URL]', $postPermalink, $message);
            }
            if (strpos($message, '[BLOG_TITLE]') !== false) {
                $message = str_replace('[BLOG_TITLE]', $blogTitle, $message);
            }
            if (strpos($message, '[POST_TITLE]') !== false) {
                $message = str_replace('[POST_TITLE]', $postTitle, $message);
            }
            if (strpos($message, '[COMMENT_URL]') !== false) {
                $commentPermalink = get_comment_link($comment->comment_ID);
                $message = str_replace('[COMMENT_URL]', $commentPermalink, $message);
            }
            if (strpos($message, '[COMMENT_AUTHOR]') !== false) {
                $message = str_replace('[COMMENT_AUTHOR]', $comment->comment_author, $message);
            }
            if (strpos($message, '[COMMENT_CONTENT]') !== false) {
                $message = str_replace('[COMMENT_CONTENT]', $comment->comment_content, $message);
            }
            if (strpos($subject, '[BLOG_TITLE]') !== false) {
                $subject = str_replace('[BLOG_TITLE]', $blogTitle, $subject);
            }
            if (strpos($subject, '[POST_TITLE]') !== false) {
                $subject = str_replace('[POST_TITLE]', $postTitle, $subject);
            }
            $headers = array();
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
            wp_mail($email, $subject, do_shortcode($message), $headers);
        }
    }

    public function followConfirmEmail($postId, $id, $key, $email) {
        $subject = $this->optionsSerialized->phrases['wc_follow_confirm_email_subject'];
        $message = $this->optionsSerialized->phrases['wc_follow_confirm_email_message'];
        $confirmUrl = $this->dbManager->followConfirmLink($postId, $id, $key);
        $cancelUrl = $this->dbManager->followCancelLink($postId, $id, $key);
        $siteUrl = get_site_url();
        $blogTitle = get_option('blogname');
        $postTitle = get_the_title($postId);
        if (strpos($message, '[SITE_URL]') !== false) {
            $message = str_replace('[SITE_URL]', $siteUrl, $message);
        }
        if (strpos($message, '[POST_URL]') !== false) {
            $postPermalink = get_permalink($postId);
            $message = str_replace('[POST_URL]', $postPermalink, $message);
        }
        if (strpos($message, '[BLOG_TITLE]') !== false) {
            $message = str_replace('[BLOG_TITLE]', $blogTitle, $message);
        }
        if (strpos($message, '[POST_TITLE]') !== false) {
            $message = str_replace('[POST_TITLE]', $postTitle, $message);
        }
        if (strpos($subject, '[BLOG_TITLE]') !== false) {
            $subject = str_replace('[BLOG_TITLE]', $blogTitle, $subject);
        }
        if (strpos($subject, '[POST_TITLE]') !== false) {
            $subject = str_replace('[POST_TITLE]', $postTitle, $subject);
        }

        if (strpos($message, '[CONFIRM_URL]') === false) {
            $message .= "<br/><br/><a href='$confirmUrl'>" . $this->optionsSerialized->phrases['wc_follow_confirm'] . "</a>";
        } else {
            $message = str_replace('[CONFIRM_URL]', $confirmUrl, $message);
        }

        if (strpos($message, '[CANCEL_URL]') === false) {
            $message .= "<br/><br/><a href='$cancelUrl'>" . $this->optionsSerialized->phrases['wc_follow_cancel'] . "</a>";
        } else {
            $message = str_replace('[CANCEL_URL]', $cancelUrl, $message);
        }


        $headers = array();
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

    public function notifyFollowers($postId, $commentId, $email) {
        $followersData = $this->dbManager->getUserFollowers($email);
        $comment = get_comment($commentId);
        $post = get_post($comment->comment_post_ID);
        $postAuthor = get_userdata($post->post_author);
        $moderationNotify = get_option('moderation_notify');
        $commentsNotify = get_option('comments_notify');

        $siteUrl = get_site_url();
        $blogTitle = get_option('blogname');
        $postTitle = get_the_title($post);
        $postUrl = get_permalink($post);
        $commentUrl = get_comment_link($comment);

        // TODO send emails
        $subject = $this->optionsSerialized->phrases['wc_follow_email_subject'];
        $message = $this->optionsSerialized->phrases['wc_follow_email_message'];

        if (strpos($subject, '[BLOG_TITLE]') !== false) {
            $subject = str_replace('[BLOG_TITLE]', $blogTitle, $subject);
        }
        if (strpos($subject, '[POST_TITLE]') !== false) {
            $subject = str_replace('[POST_TITLE]', $postTitle, $subject);
        }
        $subject = html_entity_decode($subject, ENT_QUOTES);

        if (strpos($message, '[SITE_URL]') !== false) {
            $message = str_replace('[SITE_URL]', $siteUrl, $message);
        }
        if (strpos($message, '[POST_URL]') !== false) {
            $message = str_replace('[POST_URL]', $postUrl, $message);
        }
        if (strpos($message, '[BLOG_TITLE]') !== false) {
            $message = str_replace('[BLOG_TITLE]', $blogTitle, $message);
        }
        if (strpos($message, '[POST_TITLE]') !== false) {
            $message = str_replace('[POST_TITLE]', $postTitle, $message);
        }
        if (strpos($message, '[COMMENT_URL]') !== false) {
            $message = str_replace('[COMMENT_URL]', $commentUrl, $message);
        }
        if (strpos($message, '[COMMENT_CONTENT]') !== false) {
            $message = str_replace('[COMMENT_CONTENT]', $comment->comment_content, $message);
        }
        global $wp_rewrite;
        $cancelLink = !$wp_rewrite->using_permalinks() ? $postUrl . "&" : $postUrl . "?";
        $fromName = apply_filters('wp_mail_from_name', $blogTitle);
        $fromName = html_entity_decode($fromName, ENT_QUOTES);
        $parsedUrl = parse_url($siteUrl);
        $domain = isset($parsedUrl['host']) ? WpdiscuzHelper::fixEmailFrom($parsedUrl['host']) : '';
        $fromEmail = 'no-reply@' . $domain;
        $fromEmail = apply_filters('wp_mail_from', $fromEmail);
        $mailContentType = apply_filters('wp_mail_content_type', 'text/html');
        $data = array(
            'site_url' => $siteUrl,
            'blog_title' => $blogTitle,
            'from_name' => $fromName,
            'from_email' => $fromEmail,
            'content_type' => $mailContentType,
        );

        foreach ($followersData as $followerData) {
            if (($followerData['follower_email'] == $postAuthor->user_email) && (($moderationNotify && !$comment->comment_approved) || ($commentsNotify && $comment->comment_approved))) {
                return;
            }
            if (strpos($message, '[FOLLOWER_NAME]') !== false) {
                $message = str_replace('[FOLLOWER_NAME]', $followerData['follower_name'], $message);
            }
            $this->emailToFollower($followerData, $comment, $subject, $message, $cancelLink, $data);
            do_action('wpdiscuz_notify_followers', $comment, $followerData);
        }
    }

    private function emailToFollower($followerData, $comment, $subject, $message, $cancelLink, $data) {
        $sendMail = apply_filters('wpdiscuz_follow_email_notification', true, $followerData, $comment);
        if ($sendMail) {
            $cancelLink .= "wpdiscuzUrlAnchor&wpdiscuzFollowID={$followerData['id']}&wpdiscuzFollowKey={$followerData['activation_key']}&wpDiscuzComfirm=0#wc_follow_message";
            if (strpos($message, '[CANCEL_URL]') === false) {
                $message .= "<br/><br/><a href='$cancelLink'>" . __('Cancel Follow', 'wpdiscuz') . "</a>";
            } else {
                $message = str_replace('[CANCEL_URL]', $cancelLink, $message);
            }
            $headers = array();
            $mailContentType = $data['content_type'];
            $fromName = $data['from_name'];
            $fromEmail = $data['from_email'];
            $headers[] = "Content-Type:  $mailContentType; charset=UTF-8";
            $headers[] = "From: " . $fromName . " <" . $fromEmail . "> \r\n";
            $subject = html_entity_decode($subject, ENT_QUOTES);
            $message = html_entity_decode($message, ENT_QUOTES);
            wp_mail($followerData['follower_email'], $subject, do_shortcode($message), $headers);            
        }
    }

}
