<?php
if (!defined('ABSPATH')) {
    exit();
}
if (!$isMuExists) {
    ?>
    <li><img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/demo.png'); ?>" style="vertical-align:bottom;" /> &nbsp; <?php _e('Media Uploader', 'wpdiscuz'); ?></li>
    <?php
}