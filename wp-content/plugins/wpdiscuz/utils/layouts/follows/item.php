<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div class="wpd-item">
    <div class="wpd-item-left">
        <div class="wpd-item-link wpd-comment-meta">
            <i class="fas fa-user"></i> <?php echo $fName; ?> &nbsp; 
            <i class="fas fa-calendar-alt"></i> <?php echo $postedDate; ?>
        </div>
    </div>
    <div class="wpd-item-right">
        <a href="#" class="wpd-delete-content wpd-not-clicked" data-wpd-content-id="<?php echo $fId; ?>" data-wpd-delete-action="wpdCancelFollow" title="<?php _e('Cancel this follow', 'wpdiscuz'); ?>">
            <i class="fas fa-trash-alt"></i>
        </a>
    </div>
    <div class="wpd-clear"></div>
</div>