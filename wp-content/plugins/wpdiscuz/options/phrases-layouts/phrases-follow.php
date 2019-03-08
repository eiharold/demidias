<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Follow Users Phrases', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_user"><?php _e('Follow this user', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_user']; ?>" name="wc_follow_user" id="wc_follow_user" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_unfollow_user"><?php _e('Unfollow this user', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_unfollow_user']; ?>" name="wc_unfollow_user" id="wc_unfollow_user" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_success"><?php _e('You started following this comment author', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_success']; ?>" name="wc_follow_success" id="wc_follow_success" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_canceled"><?php _e('You stopped following this comment author', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_canceled']; ?>" name="wc_follow_canceled" id="wc_follow_canceled" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_email_confirm"><?php _e('Please check your email and confirm the follow', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_email_confirm']; ?>" name="wc_follow_email_confirm" id="wc_follow_email_confirm" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_email_confirm_fail"><?php _e('Sorry, we couldn\'t send confirmation email', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_email_confirm_fail']; ?>" name="wc_follow_email_confirm_fail" id="wc_follow_email_confirm_fail" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_login_to_follow"><?php _e('Please login to follow users', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_login_to_follow']; ?>" name="wc_follow_login_to_follow" id="wc_follow_login_to_follow" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_impossible"><?php _e('We are sorry, following this user is impossible', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_impossible']; ?>" name="wc_follow_impossible" id="wc_follow_impossible" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_not_added"><?php _e('We are sorry, following failed. Please try again later.', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_not_added']; ?>" name="wc_follow_not_added" id="wc_follow_not_added" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_confirm"><?php _e('Confirm following link text', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_confirm']; ?>" name="wc_follow_confirm" id="wc_follow_confirm" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_follow_cancel"><?php _e('Cancel following link text', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_follow_cancel']; ?>" name="wc_follow_cancel" id="wc_follow_cancel" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wc_confirm_email_subject"><?php _e('Follow confirmation email subject', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc"><?php _e('Available shortcodes', 'wpdiscuz'); ?>:
                    <div class="wc_available_variables">
                        <div class="wc_available_variable">[BLOG_TITLE]</div>
                        <div class="wc_available_variable">[POST_TITLE]</div>
                    </div>
                </th>
                <td colspan="3"><input type="text" name="wc_follow_confirm_email_subject" id="wc_follow_confirm_email_subject" value="<?php echo $this->optionsSerialized->phrases['wc_follow_confirm_email_subject']; ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wc_follow_confirm_email_message"><?php _e('Follow confirmation email content', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc"><?php _e('Available shortcodes', 'wpdiscuz'); ?>:
                    <div class="wc_available_variables">                                                
                        <div class="wc_available_variable">[SITE_URL]</div>
                        <div class="wc_available_variable">[POST_URL]</div>
                        <div class="wc_available_variable">[BLOG_TITLE]</div>
                        <div class="wc_available_variable">[POST_TITLE]</div>
                        <div class="wc_available_variable">[CONFIRM_URL]</div>
                        <div class="wc_available_variable">[CANCEL_URL]</div>
                    </div>
                    </p>
                </th>
                <td colspan="3"><?php wp_editor($this->optionsSerialized->phrases['wc_follow_confirm_email_message'], "wc_follow_confirm_email_message", array('textarea_rows' => 10, 'teeny' => true)); ?></td>
            </tr>            
            <tr valign="top">
                <th scope="row">
                    <label for="wc_follow_email_subject"><?php _e('Following email subject', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc"><?php _e('Available shortcodes', 'wpdiscuz'); ?>:
                    <div class="wc_available_variables">
                        <div class="wc_available_variable">[BLOG_TITLE]</div>
                        <div class="wc_available_variable">[POST_TITLE]</div>
                    </div>
                </th>
                <td colspan="3"><input type="text" name="wc_follow_email_subject" id="wc_follow_email_subject" value="<?php echo $this->optionsSerialized->phrases['wc_follow_email_subject']; ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wc_follow_email_message"><?php _e('Follow email content', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc"><?php _e('Available shortcodes', 'wpdiscuz'); ?>:
                    <div class="wc_available_variables">                                                
                        <div class="wc_available_variable">[SITE_URL]</div>
                        <div class="wc_available_variable">[POST_URL]</div>
                        <div class="wc_available_variable">[BLOG_TITLE]</div>
                        <div class="wc_available_variable">[POST_TITLE]</div>
                        <div class="wc_available_variable">[COMMENT_URL]</div>
                        <div class="wc_available_variable">[FOLLOWER_NAME]</div>                        
                        <div class="wc_available_variable">[COMMENT_CONTENT]</div>
                        <div class="wc_available_variable">[CANCEL_URL]</div>
                    </div>
                    </p>
                </th>
                <td colspan="3"><?php wp_editor($this->optionsSerialized->phrases['wc_follow_email_message'], "wc_follow_email_message", array('textarea_rows' => 10, 'teeny' => true)); ?></td>
            </tr>
        </tbody>
    </table>
</div>