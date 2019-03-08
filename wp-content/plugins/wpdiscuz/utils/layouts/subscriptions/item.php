<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div class="wpd-item">
    <div class="wpd-item-left">
        <div class="wpd-item-link wpd-comment-meta">
            <i class="fas fa-user"></i> <?php echo $author; ?> &nbsp; 
            <i class="fas fa-calendar-alt"></i> <?php echo $postedDate; ?>
        </div>
        <div class="wpd-item-link wpd-comment-item-link">
            <a class="wpd-comment-link" href="<?php echo $link; ?>" target="_blank" title="<?php echo $content; ?>">
                <?php echo $content; ?>
            </a>
        </div>
        <div class="wpd-item-link wpd-post-item-link">
            <i class="far fa-bell"></i> 
            <?php echo $sTypeInfo; ?>
        </div>
    </div>
    <div class="wpd-item-right">
        <a href="#" class="wpd-delete-content wpd-not-clicked" data-wpd-content-id="<?php echo $sId; ?>" data-wpd-delete-action="wpdCancelSubscription" title="<?php _e('Cancel this subscription', 'wpdiscuz'); ?>">
            <i class="far fa-bell-slash"></i>
        </a>
    </div>
    <div class="wpd-clear"></div>
</div>