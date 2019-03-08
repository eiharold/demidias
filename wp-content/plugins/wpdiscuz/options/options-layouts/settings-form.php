<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 class="wpd-subtitle"><?php _e('Comment Form Settings', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins wpdxb" style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width: 50%;">
                    <label for="wc_header_text_show_hide"><?php _e('Hide Header Text', 'wpdiscuz'); ?></label>
        <p class="wpd-desc"><?php _e('This option hides "Leave Reply" header text on top of comment form. You can change this text in Comments > Forms admin page.', 'wpdiscuz'); ?></p>
        </th>
        <td>
            <input type="checkbox" <?php checked($this->optionsSerialized->headerTextShowHide == 1) ?> value="1" name="wc_header_text_show_hide" id="wc_header_text_show_hide" />
            <label for="wc_header_text_show_hide"></label>
            <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#hide_header_text" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="wc_show_hide_loggedin_username"><?php _e('Show logged-in user name and logout link on top of main form', 'wpdiscuz'); ?></label>
            </th>
            <td>
                <input type="checkbox" <?php checked($this->optionsSerialized->showHideLoggedInUsername == 1) ?> value="1" name="wc_show_hide_loggedin_username" id="wc_show_hide_loggedin_username" />
                <label for="wc_show_hide_loggedin_username"></label>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#user_name_and_logout_link" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="comment_form_components"><?php _e('Comment Form components', 'wpdiscuz'); ?></label>
        <p class="wpd-desc"><?php _e('These components can be found on the main comment form. The "My Content and Settings" button is located on the top left side, under the "Leave Reply" header text. The "Discussion Statistic" and "Recent Comment Authors" sections are located under the main comment form fields ont the left and right sides accordingly.', 'wpdiscuz'); ?></p>
        </th>
        <td>
            <fieldset>
                <div class="wpd-subopt" style="float: none; padding: 5px 0px;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" <?php checked($this->optionsSerialized->hideLoginLinkForGuests == 1) ?> value="1" name="hideLoginLinkForGuests" id="hideLoginLinkForGuests" />
                        <label for="hideLoginLinkForGuests"></label>
                    </div> &nbsp;
                    <span for="hideLoginLinkForGuests"><?php _e('Hide "Please login to comment" text', 'wpdiscuz'); ?></span>
                </div>
                <div class="wpd-subopt" style="float: none; padding: 5px 0px;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" value="1" <?php checked($this->optionsSerialized->hideUserSettingsButton == 1) ?> name="hideUserSettingsButton" id="hideUserSettingsButton" />
                        <label for="hideUserSettingsButton"></label>
                    </div> &nbsp;
                    <span data-target="hideUserSettingsButton" style="display: inline-block"><?php _e('Hide "My Content and Settings" button', 'wpdiscuz'); ?></span>
                </div>
                <div class="wpd-subopt" style="float: none; padding: 5px 0px;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" value="1" <?php checked($this->optionsSerialized->hideDiscussionStat == 1) ?> name="hideDiscussionStat" id="hideDiscussionStat" />
                        <label for="hideDiscussionStat"></label>
                    </div> &nbsp;
                    <span data-target="hideDiscussionStat" style="display: inline-block"><?php _e('Hide "Discussion Statistic" section', 'wpdiscuz'); ?></span>
                </div>
                <div class="wpd-subopt" style="float: none; padding: 5px 0px;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" value="1" <?php checked($this->optionsSerialized->hideRecentAuthors == 1) ?> name="hideRecentAuthors" id="hideRecentAuthors" />
                        <label for="hideRecentAuthors"></label>
                    </div> &nbsp;
                    <span data-target="hideRecentAuthors" style="display: inline-block;"><?php _e('Hide "Recent Comment Authors" section', 'wpdiscuz'); ?></span>
                </div>
                <div style="clear: both;"></div>
            </fieldset>
            <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#components" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="storeCommenterData"><?php _e('Keep guest commenter credentials in browser cookies for x days', 'wpdiscuz'); ?></label>
        <p class="wpd-desc">
            <?php _e('wpDiscuz uses WordPress function to keep guest Name, Email and Website information in cookies to fill according fields of comment form on next commenting time.', 'wpdiscuz'); ?><br /> 
            <?php _e('Set this option value -1 to make it unlimited.', 'wpdiscuz'); ?><br /> 
            <?php _e('Set this option value 0 to clear those data when user closes browser.', 'wpdiscuz'); ?>
        </p>
        </th>
        <td>
            <input type="number" value="<?php echo isset($this->optionsSerialized->storeCommenterData) ? $this->optionsSerialized->storeCommenterData : -1; ?>" name="storeCommenterData" id="storeCommenterData" style="width:100px;" />
            <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#guest_commenter_credentials" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label><?php _e('Comment author name length (for guests only)', 'wpdiscuz'); ?></label>
            </th>
            <td>                                
                <span for="commenterNameMinLength">
                    <?php _e('Min', 'wpdiscuz'); ?>: <input type="number" value="<?php echo $this->optionsSerialized->commenterNameMinLength; ?>" name="commenterNameMinLength" id="commenterNameMinLength" style="width:70px;" />
                </span>
                <span for="commenterNameMaxLength">
                    &nbsp; <?php _e('Max', 'wpdiscuz'); ?>: <input type="number" value="<?php echo $this->optionsSerialized->commenterNameMaxLength; ?>" name="commenterNameMaxLength" id="commenterNameMaxLength" style="width:70px;" />
                </span>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#comment_author_name_length" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label><?php _e('Comment text length', 'wpdiscuz'); ?></label>
        <p class="wpd-desc"><?php _e('Allows to set minimum and maximum number of chars can be inserted in comment textarea. Leave the max value empty to remove the limit.', 'wpdiscuz'); ?></p>
        </th>
        <td>
            <span for="wc_comment_text_min_length">
                <?php _e('Min', 'wpdiscuz'); ?>: <input type="number" value="<?php echo isset($this->optionsSerialized->commentTextMinLength) ? $this->optionsSerialized->commentTextMinLength : 10; ?>" name="wc_comment_text_min_length" id="wc_comment_text_min_length" style="width:70px;" />
            </span>
            <span for="wc_comment_text_max_length">
                &nbsp; <?php _e('Max', 'wpdiscuz'); ?>: <input type="number" value="<?php echo isset($this->optionsSerialized->commentTextMaxLength) ? $this->optionsSerialized->commentTextMaxLength : ''; ?>" name="wc_comment_text_max_length" id="wc_comment_text_max_length" style="width:70px;" />
            </span>
            <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#comment_text_length" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label><?php _e('Captcha generation type', 'wpdiscuz'); ?></label>
            </th>
            <th>
                <?php $isCaptchaInSession = isset($this->optionsSerialized->isCaptchaInSession) ? $this->optionsSerialized->isCaptchaInSession : 0; ?>
        <div class="wpd-switch-field">
            <input type="radio" value="0" <?php checked('0' == $isCaptchaInSession); ?> name="isCaptchaInSession" id="captchaByImageFile" /><label for="captchaByImageFile"><?php _e('File system', 'wpdiscuz') ?></label> &nbsp;
            <input type="radio" value="1" <?php checked('1' == $isCaptchaInSession); ?> name="isCaptchaInSession" id="captchaInSession" /><label for="captchaInSession"><?php _e('WP Session', 'wpdiscuz') ?></label>
        </div>
        <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#captcha_generation_type" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </th>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="antispamKey"><?php _e('Invisible Spam Protection', 'wpdiscuz'); ?></label>
        <p class="wpd-desc">
            <?php _e('You should purge caches after each key generation otherwise the plugin may work not correctly', 'wpdiscuz'); ?>
        </p>
        <p class="wpd-desc">
            <?php _e('Leave the field empty if you don\'t want to use this feature', 'wpdiscuz'); ?>
        </p>
        </th>
        <th>
            <input type="text" value="<?php echo $this->optionsSerialized->antispamKey ?>" name="antispamKey" id="antispamKey" style="padding: 3px 5px;" size="35"/>
            <button type="button" id="generateAntispamKey" class="button button-secondary"><?php _e('Generate', 'wpdiscuz') ?></button>
            <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#invisible_spam_protection" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </th>
        </tr>
        <tr valign="top">
            <th scope="row" style="width:55%;">
                <label for="displayAntispamNote"><?php _e('Display note about Invisible Spam Protection', 'wpdiscuz'); ?></label>
        <p class="wpd-desc"><?php _e('wpDiscuz has built-in invisible antispam protection based on server side and front-end unique key comparation. By default wpDiscuz display a small note in simple CAPTCHA area, saying the comment form is under antispam protection. The note text can be managed in Comments > Phrases > Form tab.', 'wpdiscuz'); ?></p>
        </th>
        <td>
            <input type="checkbox" value="1" <?php checked($this->optionsSerialized->displayAntispamNote == 1) ?> name="displayAntispamNote" id="displayAntispamNote" />
            <label for="displayAntispamNote"></label>
            <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#note_about_spam_protection" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row" style="width:55%;">
                <label for="wc_quick_tags"><?php _e('Enable Quicktags', 'wpdiscuz'); ?></label>
        <p class="wpd-desc"><?php _e('Quicktag is a on-click button that inserts HTML in to comment textarea. For example the "b" Quicktag will insert the HTML bold tags < b > < /b >.', 'wpdiscuz'); ?></p>
        </th>
        <td>
            <input type="checkbox" <?php checked($this->optionsSerialized->isQuickTagsEnabled == 1) ?> value="1" name="wc_quick_tags" id="wc_quick_tags" />
            <label for="wc_quick_tags"></label>
            <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#quicktags" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="enableImageConversion"><?php _e('Enable automatic image URL to image HTML conversion', 'wpdiscuz'); ?></label>
            </th>
            <td>
                <input type="checkbox" <?php checked($this->optionsSerialized->enableImageConversion == 1) ?> value="1" name="enableImageConversion" id="enableImageConversion" />
                <label for="enableImageConversion"></label>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#image-embed" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label><?php _e('Edit Button - Allow comment editing for', 'wpdiscuz'); ?></label>
            </th>
            <td>
                <select id="wc_comment_editable_time" name="wc_comment_editable_time">
                    <?php $wc_comment_editable_time = isset($this->optionsSerialized->commentEditableTime) ? $this->optionsSerialized->commentEditableTime : 0; ?>
                    <option value="0" <?php selected($wc_comment_editable_time, '0'); ?>><?php _e('Do not allow', 'wpdiscuz'); ?></option>
                    <option value="900" <?php selected($wc_comment_editable_time, '900'); ?>>15 <?php _e('Minutes', 'wpdiscuz'); ?></option>
                    <option value="1800" <?php selected($wc_comment_editable_time, '1800'); ?>>30 <?php _e('Minutes', 'wpdiscuz'); ?></option>
                    <option value="3600" <?php selected($wc_comment_editable_time, '3600'); ?>>1 <?php _e('Hour', 'wpdiscuz'); ?></option>
                    <option value="10800" <?php selected($wc_comment_editable_time, '10800'); ?>>3 <?php _e('Hours', 'wpdiscuz'); ?></option>
                    <option value="86400" <?php selected($wc_comment_editable_time, '86400'); ?>>24 <?php _e('Hours', 'wpdiscuz'); ?></option>
                    <option value="unlimit" <?php selected($wc_comment_editable_time, 'unlimit'); ?>><?php _e('Unlimit', 'wpdiscuz'); ?></option>
                </select>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#allow_editing" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" style="width: 50%;">
                <label for="enableStickButton"><?php _e('Stick Button - Stick a comment thread', 'wpdiscuz'); ?></label>
            </th>
            <td>
                <input type="checkbox" <?php checked($this->optionsSerialized->enableStickButton == 1) ?> value="1" name="enableStickButton" id="enableStickButton" />
                <label for="enableStickButton"></label>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#stick_comment" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" style="width: 50%;">
                <label for="enableCloseButton"><?php _e('Close Button - Close a comment thread', 'wpdiscuz'); ?></label>
            </th>
            <td>
                <input type="checkbox" <?php checked($this->optionsSerialized->enableCloseButton == 1) ?> value="1" name="enableCloseButton" id="enableCloseButton" />
                <label for="enableCloseButton"></label>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#close_comment" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="enableDropAnimation"><?php _e('Enable drop animation for comment form and subscription bar', 'wpdiscuz'); ?></label>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->enableDropAnimation == 1) ?> value="1" name="enableDropAnimation" id="enableDropAnimation" />
                    <label for="enableDropAnimation"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/comment-form/#drop_animation" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>