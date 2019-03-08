<?php

if (!defined('ABSPATH')) {
    exit();
}

class WpdiscuzHelperOptimization implements WpDiscuzConstants {

    private $optionsSerialized;
    private $dbManager;
    private $helperEmail;
    private $wpdiscuzForm;

    public function __construct($optionsSerialized, $dbManager, $helperEmail, $wpdiscuzForm) {
        $this->optionsSerialized = $optionsSerialized;
        $this->dbManager = $dbManager;
        $this->helperEmail = $helperEmail;
        $this->wpdiscuzForm = $wpdiscuzForm;
        add_action('comment_post', array(&$this, 'updateStatistics'), 11, 1);
        add_action('delete_comment', array(&$this, 'updateStatistics'), 11, 2);
        add_action('deleted_comment', array(&$this, 'cleanCommentRelatedRows'));
        add_action('delete_user', array(&$this, 'deleteUserRelatedData'), 11, 2);
    }

    /**
     * recursively get new comments tree
     * return array of comments' ids
     */
    public function getTreeByParentId($commentId, &$tree) {
        $children = $this->dbManager->getCommentsByParentId($commentId);
        if ($children && is_array($children)) {
            foreach ($children as $child) {
                if (!in_array($child, $tree)) {
                    $tree[] = $child;
                    $this->getTreeByParentId($child, $tree);
                }
            }
        }
        return $tree;
    }

    public function isReplyInAuthorTree($commentId, $authorComments) {
        $comment = get_comment($commentId);
        if (in_array($comment->comment_parent, $authorComments)) {
            return true;
        }
        if ($comment->comment_parent) {
            return $this->isReplyInAuthorTree($comment->comment_parent, $authorComments);
        } else {
            return false;
        }
    }

    /**
     * add new comment id in comment meta if status is approved
     * @param type $newStatus the comment new status
     * @param type $oldStatus the comment old status
     * @param type $comment current comment object
     */
    public function statusEventHandler($newStatus, $oldStatus, $comment) {
        $this->updateStatistics($comment->comment_ID, $comment);
        if ($newStatus != $oldStatus && $newStatus == 'approved') {
            $this->notifyOnApprove($comment);
            if ($this->optionsSerialized->isNotifyOnCommentApprove) {
                $this->helperEmail->notifyOnApproving($comment);
            }
        }
    }

    /**
     * get the current comment root comment
     * @param type $commentId the current comment id
     * @return type comment
     */
    public function getCommentRoot($commentId) {
        $comment = get_comment($commentId);
        if ($comment && $comment->comment_parent) {
            return $this->getCommentRoot($comment->comment_parent);
        } else {
            return $comment;
        }
    }

    public function getCommentDepth($commentId, &$depth = 1) {
        $comment = get_comment($commentId);
        if ($comment->comment_parent && ($depth < $this->optionsSerialized->wordpressThreadCommentsDepth)) {
            $depth++;
            return $this->getCommentDepth($comment->comment_parent, $depth);
        } else {
            return $depth;
        }
    }

    private function notifyOnApprove($comment) {
        $postId = $comment->comment_post_ID;
        $commentId = $comment->comment_ID;
        $email = $comment->comment_author_email;
        $parentComment = get_comment($comment->comment_parent);
        $this->helperEmail->notifyPostSubscribers($postId, $commentId, $email);
        if ($parentComment) {
            $parentCommentEmail = $parentComment->comment_author_email;
            if ($parentCommentEmail != $email) {
                $this->helperEmail->notifyAllCommentSubscribers($postId, $commentId, $email);
                $this->helperEmail->notifyCommentSubscribers($parentComment->comment_ID, $commentId, $email);
            }
        }
    }

    public function removeVoteData() {
        if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'remove_vote_data') && current_user_can('manage_options')) {
            $this->dbManager->removeVotes();
            wp_redirect(admin_url('edit-comments.php?page=' . self::PAGE_SETTINGS));
        }
    }

    public function resetPhrases() {
        if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'reset_phrases_nonce') && current_user_can('manage_options')) {
            $this->dbManager->deletePhrases();
            wp_redirect(admin_url('edit-comments.php?page=' . self::PAGE_PHRASES));
        }
    }

    public function cleanCommentRelatedRows($commentId) {
        $this->dbManager->deleteSubscriptions($commentId);
        $this->dbManager->deleteVotes($commentId);
    }

    public function updateStatistics($commentId, $comment = null) {
        if (!$comment && $commentId) {
            $comment = get_comment($commentId);
        }
        if ($comment) {
            $threads = $this->dbManager->getThreadsCount($comment->comment_post_ID, false);
            $replies = $this->dbManager->getRepliesCount($comment->comment_post_ID, false);
//            $followers = $this->dbManager->getAllSubscriptionsCount($comment->comment_post_ID, false);
            $authors = $this->dbManager->getAuthorsCount($comment->comment_post_ID, false);
            $authorsLimit = apply_filters('wpdiscuz_recent_authors_limit', 5);
            $recentAuthors = $this->dbManager->getRecentAuthors($comment->comment_post_ID, $authorsLimit, false);
            $stat = array(
                self::POSTMETA_THREADS => $threads,
                self::POSTMETA_REPLIES => $replies,
//              self::POSTMETA_FOLLOWERS => $followers,
                self::POSTMETA_AUTHORS => $authors,
                self::POSTMETA_RECENT_AUTHORS => $recentAuthors
            );
            update_post_meta($comment->comment_post_ID, self::POSTMETA_STATISTICS, $stat);
        }
    }

    public function onProfileUpdate($userId, $oldUser) {
        $user = get_user_by('id', $userId);
        if ($user && $oldUser) {
            $this->dbManager->updateUserInfo($user, $oldUser);
        }
    }

    public function deleteUserRelatedData($id, $reassign) {
        $user = get_user_by('id', $id);
        if ($user && $user->user_email) {
            $this->dbManager->deleteFollowsByEmail($user->user_email);
        }
    }

}
