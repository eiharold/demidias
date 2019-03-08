<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Notification Phrases', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="wc_subscribed_to"><?php _e('You\'re subscribed to', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_subscribed_to']; ?>" name="wc_subscribed_to" id="wc_subscribed_to" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_subscribe_message"><?php _e('You\'ve successfully subscribed.', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><textarea name="wc_subscribe_message" id="wc_subscribe_message"><?php echo $this->optionsSerialized->phrases['wc_subscribe_message']; ?></textarea></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_unsubscribe_message"><?php _e('You\'ve successfully unsubscribed.', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><textarea name="wc_unsubscribe_message" id="wc_unsubscribe_message"><?php echo $this->optionsSerialized->phrases['wc_unsubscribe_message']; ?></textarea></td>
            </tr>
            <?php if (class_exists('Prompt_Comment_Form_Handling') && $this->optionsSerialized->usePostmaticForCommentNotification) { ?>
                <tr valign="top">
                    <th scope="row"><label for="wc_postmatic_subscription_label"><?php _e("Postmatic subscription label", 'wpdiscuz'); ?></label></th>
                    <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_postmatic_subscription_label']; ?>" name="wc_postmatic_subscription_label" id="wc_postmatic_subscription_label" /></td>
                </tr>
            <?php } ?>
            <tr valign="top">
                <th scope="row"><label for="wc_log_in"><?php _e('Login', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_log_in']; ?>" name="wc_log_in" id="wc_log_in" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_login_please"><?php _e('Please %s to comment', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_login_please']; ?>" name="wc_login_please" id="wc_login_please" /></td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="wc_you_must_be_text"><?php _e('You must be', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_you_must_be_text']; ?>" name="wc_you_must_be_text" id="wc_you_must_be_text" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_logged_in_text"><?php _e('Logged In', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_logged_in_text']; ?>" name="wc_logged_in_text" id="wc_logged_in_text" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_to_post_comment_text"><?php _e('To post a comment', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_to_post_comment_text']; ?>" name="wc_to_post_comment_text" id="wc_to_post_comment_text" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_logged_in_as"><?php _e('Logged in as', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_logged_in_as']; ?>" name="wc_logged_in_as" id="wc_logged_in_as" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_log_out"><?php _e('Log out', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_log_out']; ?>" name="wc_log_out" id="wc_log_out" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_vote_counted"><?php _e('Vote Counted', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_vote_counted']; ?>" name="wc_vote_counted" id="wc_vote_counted" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_login_to_vote"><?php _e('Login To Vote', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_login_to_vote']; ?>" name="wc_login_to_vote" id="wc_login_to_vote" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_held_for_moderate"><?php _e('Comment waiting moderation', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_held_for_moderate']; ?>" name="wc_held_for_moderate" id="wc_held_for_moderate" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_msg_required_fields"><?php _e('Message if commenting disabled by user role', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_roles_cannot_comment_message']; ?>" name="wc_roles_cannot_comment_message" id="wc_roles_cannot_comment_message" /></td>
            </tr>
        </tbody>
    </table>
</div>