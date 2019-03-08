<?php
if (!defined('ABSPATH')) {
    exit();
}
if (!$isAlExists) {
    ?>
    <li><img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/demo.png'); ?>" style="vertical-align:bottom;" /> &nbsp; <?php _e('Advanced Likers', 'wpdiscuz'); ?></li>
    <?php
}