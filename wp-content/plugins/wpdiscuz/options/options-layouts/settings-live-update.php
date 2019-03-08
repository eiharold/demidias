<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 class="wpd-subtitle"><?php _e('Live Update', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins wpdxb" style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <label><?php _e('Live update options', 'wpdiscuz'); ?></label>
                    <p class="wpd-desc"><?php _e('wpDiscuz live update is very light and doesn\'t overload your server. However we recommend to monitor your server resources if you\'re on a Shared hosting plan. There are some very weak hosting plans which may not be able to perform very frequently live update requests. If you found some issue you can set the option below 30 seconds or more.', 'wpdiscuz'); ?></p>
                </th>
                <th>
                    <fieldset class="wc_comment_list_update_type">
                        <?php $wc_comment_list_update_type = isset($this->optionsSerialized->commentListUpdateType) ? $this->optionsSerialized->commentListUpdateType : 1; ?>
                        <label title="<?php _e('Never update', 'wpdiscuz') ?>">
                            <input type="radio" value="0" <?php checked('0' == $wc_comment_list_update_type); ?> name="wc_comment_list_update_type" id="wc_comment_list_update_never" /> 
                            <span><?php _e('Turn off "Live Update" function', 'wpdiscuz') ?></span>
                        </label> &nbsp;<br/>
                        <label title="<?php _e('Show new comment/reply buttons to update manualy', 'wpdiscuz') ?>">
                            <input type="radio" value="2" <?php checked('2' == $wc_comment_list_update_type); ?> name="wc_comment_list_update_type" id="wc_comment_list_update_new" /> 
                            <span><?php _e('Always check for new comments and show update buttons', 'wpdiscuz') ?></span>
                        </label><br>    
                        <label title="<?php _e('Always update', 'wpdiscuz') ?>">
                            <input type="radio" value="1" <?php checked('1' == $wc_comment_list_update_type); ?> name="wc_comment_list_update_type" id="wc_comment_list_update_always" /> 
                            <span><?php _e('Always check for new comments and update automatically', 'wpdiscuz') ?></span>
                        </label> &nbsp;<br/>          
                    </fieldset>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/live-update/" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wc_live_update_guests"><?php _e('Disable live update for guests', 'wpdiscuz'); ?></label>
                </th>
                <td>   
                    <input type="checkbox" <?php checked($this->optionsSerialized->liveUpdateGuests == 1) ?> value="1" name="wc_live_update_guests" id="wc_live_update_guests" />
                    <label for="wc_live_update_guests"></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wc_comment_list_update_timer"><?php _e('Update comment list every', 'wpdiscuz'); ?></label>
                </th>
                <td>
                    <select id="wc_comment_list_update_timer" name="wc_comment_list_update_timer">
                        <?php $wc_comment_list_update_timer = isset($this->optionsSerialized->commentListUpdateTimer) ? $this->optionsSerialized->commentListUpdateTimer : 30; ?>
                        <option value="10" <?php selected($wc_comment_list_update_timer, '10'); ?>>10 <?php _e('Seconds', 'wpdiscuz'); ?></option>
                        <option value="20" <?php selected($wc_comment_list_update_timer, '20'); ?>>20 <?php _e('Seconds', 'wpdiscuz'); ?></option>
                        <option value="30" <?php selected($wc_comment_list_update_timer, '30'); ?>>30 <?php _e('Seconds', 'wpdiscuz'); ?></option>
                        <option value="60" <?php selected($wc_comment_list_update_timer, '60'); ?>>1 <?php _e('Minute', 'wpdiscuz'); ?></option>
                        <option value="180" <?php selected($wc_comment_list_update_timer, '180'); ?>>3 <?php _e('Minutes', 'wpdiscuz'); ?></option>
                        <option value="300" <?php selected($wc_comment_list_update_timer, '300'); ?>>5 <?php _e('Minutes', 'wpdiscuz'); ?></option>
                        <option value="600" <?php selected($wc_comment_list_update_timer, '600'); ?>>10 <?php _e('Minutes', 'wpdiscuz'); ?></option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>