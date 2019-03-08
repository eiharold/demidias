<?php
if (!defined('ABSPATH')) {
    exit();
}
global $post;
$postId = isset($post->ID) ? intval($post->ID) : 0;
if ($isMain && $commentsCount && $postId) {
    $stat = get_post_meta($postId, self::POSTMETA_STATISTICS, true);
    ?>
    <div class="wpdiscuz-form-bottom-bar">
        <?php if (!$form->wpdOptions->hideDiscussionStat) { ?>
            <div class="wpdiscuz-fbb-left">
                <?php $isShowThreadsCount = apply_filters('wpdiscuz_show_threads_count', true, $currentUser); ?>
                <?php if ($isShowThreadsCount) { ?>
                    <?php
                    if (isset($stat[self::POSTMETA_THREADS])) {
                        $threads = $stat[self::POSTMETA_THREADS];
                    } else {
                        $threads = $this->dbManager->getThreadsCount($postId);
                    }
                    ?>
                    <div class="wpdiscuz-stat wpd-stat-threads wpd-tooltip-left">
                        <i class="fas fa-align-left fa-rotate-180" data-fa-transform="rotate-180"></i><span class="wpd-stat-threads-count"><?php echo $threads; ?></span>
                        <wpdtip><?php echo $form->wpdOptions->phrases['wc_comment_threads']; ?></wpdtip>
                    </div>
                <?php } ?>
                <?php $isShowRepliesCount = apply_filters('wpdiscuz_show_replies_count', true, $currentUser); ?>
                <?php if ($isShowRepliesCount) { ?>
                    <?php
                    if (isset($stat[self::POSTMETA_REPLIES])) {
                        $replies = $stat[self::POSTMETA_REPLIES];
                    } else {
                        $replies = $this->dbManager->getRepliesCount($postId);
                    }
                    ?>
                    <div class="wpdiscuz-stat wpd-stat-replies wpd-tooltip-left">
                        <i class="far fa-comments"></i><span class="wpd-stat-replies-count"><?php echo $replies; ?></span>
                        <wpdtip><?php echo $form->wpdOptions->phrases['wc_thread_replies']; ?></wpdtip>
                    </div>
                <?php } ?>
                <?php $isShowFollowersCount = apply_filters('wpdiscuz_show_followers_count', true, $currentUser); ?>
                <?php if ($isShowFollowersCount) { ?>
                    <?php $followers = $this->dbManager->getAllSubscriptionsCount($postId, false); ?>
                    <div class="wpdiscuz-stat wpd-stat-subscribers wpd-tooltip-left">
                        <i class="fas fa-rss"></i><span><?php echo $followers; ?></span>
                        <wpdtip><?php echo $form->wpdOptions->phrases['wc_followers']; ?></wpdtip>
                    </div>&nbsp;
                <?php } ?>
                <?php $isShowMostReacted = apply_filters('wpdiscuz_show_most_reacted_comment', true, $currentUser); ?>
                <?php if ($isShowMostReacted) { ?>                    
                    <div class="wpdiscuz-stat wpd-stat-reacted wpd-tooltip">
                        <i class="fas fa-bolt"></i>
                        <wpdtip><?php echo $form->wpdOptions->phrases['wc_most_reacted_comment']; ?></wpdtip>
                    </div>
                <?php } ?>
                <?php $isShowHottestReacted = apply_filters('wpdiscuz_show_hottest_comment', true, $currentUser); ?>
                <?php if ($isShowHottestReacted) { ?>
                    <div class="wpdiscuz-stat wpd-stat-hot wpd-tooltip">
                        <i class="fab fa-hotjar"></i>
                        <wpdtip><?php echo $form->wpdOptions->phrases['wc_hottest_comment_thread']; ?></wpdtip>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (!$form->wpdOptions->hideRecentAuthors) { ?>
            <?php $isShowAuthorsCount = apply_filters('wpdiscuz_show_authors_count', true); ?>
            <div class="wpdiscuz-fbb-right">
                <?php if ($isShowAuthorsCount) { ?>
                    <?php
                    if (isset($stat[self::POSTMETA_AUTHORS])) {
                        $authorsCount = $stat[self::POSTMETA_AUTHORS];
                    } else {
                        $authorsCount = $this->dbManager->getAuthorsCount($postId);
                    }
                    ?>
                    <?php ?>
                    <div class="wpdiscuz-stat wpd-stat-users wpd-tooltip">
                        <i class="fas fa-user-circle"></i> <span class="wpd-stat-authors-count"><?php echo $authorsCount; ?></span>
                        <wpdtip><?php echo $form->wpdOptions->phrases['wc_comment_authors']; ?></wpdtip>
                    </div>
                <?php } ?>
                <?php $isShowRecentAuthors = apply_filters('wpdiscuz_show_recent_authors', true); ?>
                <?php if ($isShowAuthorsCount && $this->optionsSerialized->wordpressShowAvatars) { ?>
                    <?php $authorsLimit = apply_filters('wpdiscuz_recent_authors_limit', 5); ?>
                    <?php
                    if (isset($stat[self::POSTMETA_RECENT_AUTHORS])) {
                        $recentAuthors = $stat[self::POSTMETA_RECENT_AUTHORS];
                    } else {
                        $recentAuthors = $this->dbManager->getRecentAuthors($postId, $authorsLimit);
                    }
                    ?>
                    <div class="wpdiscuz-users wpd-tooltip-right">
                        <?php
                        $gravatarSize = apply_filters('wpdiscuz_gravatar_size', 64);
                        foreach ($recentAuthors as $recentAuthor) {
                            $authorAvatarField = apply_filters('wpdiscuz_author_avatar_field', $recentAuthor->comment_author_email, $recentAuthor, null, '');
                            $gravatarArgs = array(
                                'wpdiscuz_gravatar_field' => $authorAvatarField,
                                'wpdiscuz_gravatar_size' => $gravatarSize,
                                'wpdiscuz_gravatar_user_id' => $recentAuthor->user_id,
                                'wpdiscuz_gravatar_user_email' => $recentAuthor->comment_author_email,
                                'extra_attr' => "title='{$recentAuthor->comment_author}'",
                            );
                            $authorAvatar = get_avatar($authorAvatarField, $gravatarSize, '', $recentAuthor->comment_author, $gravatarArgs);
                            echo $authorAvatar;
                        }
                        ?>
                        <wpdtip><?php echo $form->wpdOptions->phrases['wc_recent_comment_authors']; ?></wpdtip>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="wpd-clear"></div>
    </div>
    <?php
}