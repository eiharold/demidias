<?php
if (!defined('ABSPATH')) {
    exit();
}
$notHashedDataCount = intval($this->dbManager->getNotHashedIpCount());

if ($notHashedDataCount) {
    $disabled = '';
    $notHasedStartId = intval($this->dbManager->getNotHashedStartId());
} else {
    $disabled = 'disabled="disabled"';
    $notHasedStartId = 0;
}
?>
<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Update vote data', 'wpdiscuz'); ?></h2>
    <p style="font-size:13px; color:#999999; width:90%; padding-left:0px; margin-left:10px;">
        <?php _e('We recommend use this tool to do one way hashing of commenter IP addresses to 32 bit strings, so you\'ll keep less personal information of your commenters. This tool only hashes voter IP addresses. You also can stop saving of commenter IP addresses in comments database table using this instruction ', 'wpdiscuz'); ?> <a href="http://www.wpbeginner.com/wp-tutorials/how-to-stop-storing-ip-address-in-wordpress-comments/" target="_blank">&gt;&gt;&gt;</a>
    </p>
    <form action="" method="post" class="wc-tools-settings-form wc-form">
        <?php wp_nonce_field('wc_tools_form'); ?>
        <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
            <tbody>                
                <tr>
                    <td>
                        <button type="submit" class="button button-secondary update-not-hashed-ips" <?php echo $disabled; ?> title="<?php _e('Start Hashing', 'wpdiscuz'); ?>">
                            <?php _e('Hash users IP addresses', 'wpdiscuz'); ?>&nbsp;
                            <i class="fas wc-hidden"></i>
                        </button>
                        <span class="import-progress">&nbsp;</span>
                        <input type="hidden" name="not-hashed-start-id" value="<?php echo --$notHasedStartId; ?>" class="not-hashed-start-id"/>
                        <input type="hidden" name="not-hashed-count" value="<?php echo $notHashedDataCount; ?>" class="not-hashed-count"/>
                        <input type="hidden" name="hashing-step" value="0" class="hashing-step"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>