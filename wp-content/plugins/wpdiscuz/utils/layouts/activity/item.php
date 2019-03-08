<?php
if (!defined('ABSPATH')) {
    exit();
}
$title = get_the_title($item->comment_post_ID);
?>
<div class="wpd-item">
    <div class="wpd-item-left">
        <div class="wpd-item-link wpd-comment-meta">
            <i class="fas fa-user"></i>
            <?php echo $item->comment_author; ?> &nbsp; 
            <i class="fas fa-calendar-alt"></i> 
            <?php echo $this->getCommentDate($item); ?>
        </div>
        <div class="wpd-item-link wpd-comment-item-link">
            <a class="wpd-comment-link" href="<?php echo get_comment_link($item); ?>" target="_blank">
                <?php echo wp_trim_words($item->comment_content, 20, '&hellip;'); ?>
            </a>
        </div>
        <div class="wpd-item-link wpd-post-item-link">
            <span><?php echo $this->optionsSerialized->phrases['wc_user_settings_response_to']; ?></span>
            <a class="wpd-post-link" href="<?php echo get_permalink($item->comment_post_ID); ?>" target="_blank" title="<?php echo $title; ?>">
                <?php echo $title; ?>
            </a>
        </div>  
    </div>
    <div class="wpd-item-right">
        <a href="#" class="wpd-delete-content wpd-not-clicked" data-wpd-content-id="<?php echo $item->comment_ID; ?>" data-wpd-delete-action="wpdDeleteComment" title="<?php _e('Delete this comment', 'wpdiscuz'); ?>">
            <i class="fas fa-trash-alt"></i>
        </a>
    </div>
    <div class="wpd-clear"></div>
</div>