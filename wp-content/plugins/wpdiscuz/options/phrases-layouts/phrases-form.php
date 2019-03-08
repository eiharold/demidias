<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Form Template Phrases', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="wc_comment_start_text"><?php _e('Comment Field Start', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_comment_start_text']; ?>" name="wc_comment_start_text" id="wc_comment_start_text" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_comment_join_text"><?php _e('Comment Field Join', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_comment_join_text']; ?>" name="wc_comment_join_text" id="wc_comment_join_text" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_comment_threads"><?php _e('Comment threads', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_comment_threads']; ?>" name="wc_comment_threads" id="wc_comment_threads" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_thread_replies"><?php _e('Thread replies', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_thread_replies']; ?>" name="wc_thread_replies" id="wc_thread_replies" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_followers"><?php _e('Followers', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_followers']; ?>" name="wc_followers" id="wc_followers" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_most_reacted_comment"><?php _e('Most reacted comment', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_most_reacted_comment']; ?>" name="wc_most_reacted_comment" id="wc_most_reacted_comment" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_hottest_comment_thread"><?php _e('Hottest comment thread', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_hottest_comment_thread']; ?>" name="wc_hottest_comment_thread" id="wc_hottest_comment_thread" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_comment_authors"><?php _e('Comment authors', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_comment_authors']; ?>" name="wc_comment_authors" id="wc_comment_authors" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_recent_comment_authors"><?php _e('Recent comment authors', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_recent_comment_authors']; ?>" name="wc_recent_comment_authors" id="wc_recent_comment_authors" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_email_text"><?php _e('Email Field', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_email_text']; ?>" name="wc_email_text" id="wc_email_text" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_subscribe_anchor"><?php _e('Subscribe', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_subscribe_anchor']; ?>" name="wc_subscribe_anchor" id="wc_subscribe_anchor" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_notify_of"><?php _e('Notify of', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_notify_of']; ?>" name="wc_notify_of" id="wc_notify_of" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_notify_on_new_comment"><?php _e('Notify on new comments', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_notify_on_new_comment']; ?>" name="wc_notify_on_new_comment" id="wc_notify_on_new_comment" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_notify_on_all_new_reply"><?php _e('Notify on all new replies', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_notify_on_all_new_reply']; ?>" name="wc_notify_on_all_new_reply" id="wc_notify_on_all_new_reply" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_notify_on_new_reply"><?php _e('Notify on new replies to this comment', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_notify_on_new_reply']; ?>" name="wc_notify_on_new_reply" id="wc_notify_on_new_reply" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_sort_by"><?php _e('Sort by', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_sort_by']; ?>" name="wc_sort_by" id="wc_sort_by" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_newest"><?php _e('newest', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_newest']; ?>" name="wc_newest" id="wc_newest" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_oldest"><?php _e('oldest', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_oldest']; ?>" name="wc_oldest" id="wc_oldest" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_most_voted"><?php _e('most voted', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_most_voted']; ?>" name="wc_most_voted" id="wc_most_voted" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_subscribed_on_comment"><?php _e('Subscribed on this comment replies', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><textarea name="wc_subscribed_on_comment" id="wc_subscribed_on_comment"><?php echo $this->optionsSerialized->phrases['wc_subscribed_on_comment']; ?></textarea></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_subscribed_on_all_comment"><?php _e('Subscribed on all your comments replies', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><textarea name="wc_subscribed_on_all_comment" id="wc_subscribed_on_all_comment"><?php echo $this->optionsSerialized->phrases['wc_subscribed_on_all_comment']; ?></textarea></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_subscribed_on_post"><?php _e('Subscribed on this post', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><textarea name="wc_subscribed_on_post" id="wc_subscribed_on_post"><?php echo $this->optionsSerialized->phrases['wc_subscribed_on_post']; ?></textarea></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_form_subscription_submit"><?php _e('Form subscription button', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><input type="text" value="<?php echo $this->optionsSerialized->phrases['wc_form_subscription_submit']; ?>" name="wc_form_subscription_submit" id="wc_form_subscription_submit" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="wc_invisible_antispam_note"><?php _e('Invisible Antispam Protection note', 'wpdiscuz'); ?></label></th>
                <td colspan="3"><textarea name="wc_invisible_antispam_note" id="wc_invisible_antispam_note" ><?php echo $this->optionsSerialized->phrases['wc_invisible_antispam_note']; ?></textarea></td>
            </tr>
        </tbody>
    </table>
</div>