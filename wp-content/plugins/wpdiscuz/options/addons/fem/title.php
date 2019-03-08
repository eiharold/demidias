<?php
if (!defined('ABSPATH')) {
    exit();
}
if (!$isFemExists) {
    ?>
    <li><img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/demo.png'); ?>" style="vertical-align:bottom;" /> &nbsp; <?php _e('Frontend Moderation', 'wpdiscuz'); ?></li>
    <?php
}