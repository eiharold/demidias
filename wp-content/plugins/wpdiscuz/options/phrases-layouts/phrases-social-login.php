<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Social Login', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="wc_connect_with"><?php _e('Connect with', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_connect_with']; ?>" name="wc_connect_with" id="wc_connect_with" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_social_login_agreement_label"><?php _e('Social login agreement label', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_social_login_agreement_label']; ?>" name="wc_social_login_agreement_label" id="wc_social_login_agreement_label" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_social_login_agreement_desc"><?php _e('Social login agreement  description', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><textarea id="wc_social_login_agreement_desc" name="wc_social_login_agreement_desc"><?php echo $this->optionsSerialized->phrases['wc_social_login_agreement_desc']; ?></textarea></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_agreement_button_disagree"><?php _e('Disagree', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" id="wc_agreement_button_disagree" name="wc_agreement_button_disagree" value="<?php echo $this->optionsSerialized->phrases['wc_agreement_button_disagree']; ?>"></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_agreement_button_agree"><?php _e('Agree', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" id="wc_agreement_button_agree" name="wc_agreement_button_agree" value="<?php echo $this->optionsSerialized->phrases['wc_agreement_button_agree']; ?>"></td>
            </tr>
        </tbody>
    </table>
</div>