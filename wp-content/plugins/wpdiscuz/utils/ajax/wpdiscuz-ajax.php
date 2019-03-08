<?php

//mimic the actuall admin-ajax
define('DOING_AJAX', true);

if (!isset($_POST['action'])) {
    die('-1');
}

require_once('../../../../../wp-load.php');

header('Content-Type: text/html');
send_nosniff_header();

header('Cache-Control: no-cache');
header('Pragma: no-cache');

$action = esc_attr(trim($_POST['action']));
$allowedActions = array('mostActiveThread', '');

add_action('wpdiscuz_wpdMostActiveThread', 'wpdMostActiveThread');
add_action('wpdiscuz_nopriv_wpdMostActiveThread', 'wpdMostActiveThread');

add_action('wpdiscuz_wpdMostReactedComment', 'wpdMostReactedComment');
add_action('wpdiscuz_nopriv_wpdMostReactedComment', 'wpdMostReactedComment');

if (in_array($ac, $allowedActions)) {
    if (is_user_logged_in()) {
        do_action('wpdiscuz_' . $action);
    } else {
        do_action('wpdiscuz_nopriv_' . $action);
    }
} else {
    die('-1');
}

function wpdMostActiveThread() {
    $wpdiscuz = wpDiscuz();
    $response = array('code' => 0);
    $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
    if ($postId) {
        $parentCommentIds = $wpdiscuz->dbManager->getParentCommentsHavingReplies($postId);
        $childCount = 0;
        $hottestCommentId = 0;
        $hottestChildren = array();
        foreach ($parentCommentIds as $parentCommentId) {
            $tree = array();
            $children = $wpdiscuz->dbManager->getHottestTree($parentCommentId);
            $tmpCount = count($children);
            if ($childCount < $tmpCount) {

                $childCount = $tmpCount;
                $hottestCommentId = $parentCommentId;
                $hottestChildren = $children;
            }
        }

        if ($hottestCommentId && $hottestChildren) {
            $currentUser = WpdiscuzHelper::getCurrentUser();
            $parentComment = $wpdiscuz->helperOptimization->getCommentRoot($hottestCommentId);
            $tree = $parentComment->get_children(array(
                'format' => 'flat',
                'status' => $wpdiscuz->commentsArgs['status'],
                'orderby' => $wpdiscuz->commentsArgs['orderby']
            ));
            $comments = array_merge(array($parentComment), $tree);
            $commentListArgs = $wpdiscuz->getCommentListArgs($postId);
            $commentListArgs['isSingle'] = true;
            $commentListArgs['new_loaded_class'] = 'wc-new-loaded-comment';
            $commentListArgs['current_user'] = $currentUser;
            $wpdiscuz->form = $wpdiscuz->wpdiscuzForm->getForm($postId);
            $commentListArgs['can_user_comment'] = $wpdiscuz->form ? $wpdiscuz->form->isUserCanComment($currentUser, $postId) : true;
            $response['code'] = 1;
            $response['message'] = wp_list_comments($commentListArgs, $comments);
            $response['commentId'] = $hottestCommentId;
        }
    }
    wp_die(json_encode($response));
}

function wpdMostReactedComment() {
    $wpdiscuz = wpDiscuz();
    $response = array('code' => 0);
    $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
    if ($postId) {
        $commentId = $wpdiscuz->dbManager->getMostReactedCommentId($postId);
        $comment = get_comment($commentId);
        if ($comment && $comment->comment_post_ID == $postId) {
            $currentUser = WpdiscuzHelper::getCurrentUser();
            $parentComment = $wpdiscuz->helperOptimization->getCommentRoot($commentId);
            $tree = $parentComment->get_children(array(
                'format' => 'flat',
                'status' => $wpdiscuz->commentsArgs['status'],
                'orderby' => $wpdiscuz->commentsArgs['orderby']
            ));
            $comments = array_merge(array($parentComment), $tree);
            $commentListArgs = $wpdiscuz->getCommentListArgs($postId);
            $commentListArgs['isSingle'] = true;
            $commentListArgs['new_loaded_class'] = 'wc-new-loaded-comment';
            $commentListArgs['current_user'] = $currentUser;
            $wpdiscuz->form = $wpdiscuz->wpdiscuzForm->getForm($postId);
            $commentListArgs['can_user_comment'] = $wpdiscuz->form ? $wpdiscuz->form->isUserCanComment($currentUser, $postId) : true;
            $response['code'] = 1;
            $response['message'] = wp_list_comments($commentListArgs, $comments);
            $response['commentId'] = $commentId;
            $response['parentCommentID'] = $parentComment->comment_ID;
        }
    }
    wp_die(json_encode($response));
}
