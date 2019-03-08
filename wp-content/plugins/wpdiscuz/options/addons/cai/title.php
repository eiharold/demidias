<?php
if (!defined('ABSPATH')) {
    exit();
}
if (!$isCaiExists) {
    ?>
    <li><img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/demo.png'); ?>" style="vertical-align:bottom;" /> &nbsp; <?php _e('Comment Author', 'wpdiscuz'); ?></li>
    <?php
}