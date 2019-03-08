<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 class="wpd-subtitle"><?php _e('General Settings', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins wpdxb"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width:50%;"><label for="isEnableOnHome"><?php _e('Enable wpdiscuz on home page', 'wpdiscuz'); ?> </label></th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->isEnableOnHome == 1) ?> value="1" name="isEnableOnHome" id="isEnableOnHome" /><label for="isEnableOnHome"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/general-settings/#wpdiscuz_on_home_page" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="isUserByEmail"><?php _e('Use guest email to detect registered account', 'wpdiscuz'); ?> </label>
                    <p class="wpd-desc">
                        <?php _e('Sometimes registered users comment as guest using the same email address. wpDiscuz can detect the account role using guest email and display commenter label correctly.', 'wpdiscuz'); ?>
                    </p>
                </th>
                <td>
                    <input type="checkbox" <?php checked($this->optionsSerialized->isUserByEmail == 1) ?> value="1" name="isUserByEmail" id="isUserByEmail" /><label for="isUserByEmail"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/general-settings/#guest_email_to_detect_account" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
			<?php if(is_ssl()){?>
            <tr valign="top">
                <th scope="row"><?php _e('Secure comment content in HTTPS protocol.', 'wpdiscuz'); ?>
                    <p class="wpd-desc">
                        <?php _e('This option detects images and other contents with non-https source URLs and fix according to your selected logic.', 'wpdiscuz'); ?>
                    </p>
                </th>
                <th>
                    <fieldset class="commentLinkFilter">
                        <?php $commentLinkFilter = isset($this->optionsSerialized->commentLinkFilter) ? $this->optionsSerialized->commentLinkFilter : 1; ?>
                        <label>
                            <input  type="radio" value="1" <?php checked('1' == $commentLinkFilter); ?> name="commentLinkFilter" id="http-to-link" />
                            <span style="display: inline;"><?php _e('Replace non-https content to simple link URLs', 'wpdiscuz') ?></span>
                        </label> &nbsp;<br/>
                        <label>
                            <input type="radio" value="2" <?php checked('2' == $commentLinkFilter); ?> name="commentLinkFilter" id="http-to-https" /> 
                            <span style="display: inline;"><?php _e('Just replace http protocols to https (https may not be supported by content provider)', 'wpdiscuz') ?></span>
                        </label><br>   
                        <label>
                            <input type="radio" value="3" <?php checked('3' == $commentLinkFilter); ?> name="commentLinkFilter" id="ignore-https" /> 
                            <span style="display: inline;"><?php _e('Ignore non-https content', 'wpdiscuz') ?></span>
                        </label><br> 
                    </fieldset>
                </td>
            </tr>
            <?php }?>
            <tr valign="top">
                <th scope="row">
                    <label><?php _e('Redirect first commenter to', 'wpdiscuz'); ?></label>
                </th>
                <td>
                    <?php
                    wp_dropdown_pages(array(
                        'name' => 'wpdiscuz_redirect_page',
                        'selected' => isset($this->optionsSerialized->redirectPage) ? $this->optionsSerialized->redirectPage : 0,
                        'show_option_none' => __('Do not redirect', 'wpdiscuz'),
                        'option_none_value' => 0
                    ));
                    ?>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/general-settings/#redirect_on_first_comment_to" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wc_simple_comment_date"><?php _e('Use WordPress Date/Time format', 'wpdiscuz'); ?> </label>
                    <p class="wpd-desc"><?php _e('wpDiscuz shows Human Readable date format. If you check this option it\'ll show the date/time format set in WordPress General Settings.', 'wpdiscuz'); ?></p>
                </th>
                <td>                                
                    <input type="checkbox" <?php checked($this->optionsSerialized->simpleCommentDate == 1) ?> value="1" name="wc_simple_comment_date" id="wc_simple_comment_date" /><label for="wc_simple_comment_date"></label><br>
                    <span style="font-size:13px; color:#999999; padding-left:0px; margin-left:0px; line-height:15px">
                        <?php echo date(get_option('date_format')); ?> / <?php echo date(get_option('time_format')); ?><br />
                        <?php _e('Current Wordpress date/time format', 'wpdiscuz'); ?>
                    </span>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/general-settings/#wordPress_date_time_format" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" >
                    <label for="wc_is_use_po_mo"><?php _e('Use Plugin .PO/.MO files', 'wpdiscuz'); ?> </label>
                    <p class="wpd-desc"><?php _e('wpDiscuz phrase system allows you to translate all front-end phrases. However if you have a multi-language website it\'ll not allow you to add more than one language translation. The only way to get it is the plugin translation files (.PO / .MO). If wpDiscuz has the languages you need you should check this option to disable phrase system and it\'ll automatically translate all phrases based on language files according to current language.', 'wpdiscuz'); ?></p>
                </th>
                <td colspan="3">
                    <input type="checkbox" <?php checked($this->optionsSerialized->isUsePoMo == 1) ?> value="1" name="wc_is_use_po_mo" id="wc_is_use_po_mo" /><label for="wc_is_use_po_mo"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/general-settings/#use-po-files" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" >
                    <label for="wc_show_plugin_powerid_by">
                        <?php _e('Help wpDiscuz to grow allowing people to recognize which comment plugin you use', 'wpdiscuz'); ?>
                    </label>
                    <p class="wpd-desc"><?php _e('Please check this option on to help wpDiscuz get more popularity as your thank to the hard work we do for you totally free. This option adds a very small (16x16px) icon under the comment section which will allow your site visitors recognize the name of comment solution you use.', 'wpdiscuz'); ?></p>
                </th>
                <th colspan="3">                                
                    <label for="wc_show_plugin_powerid_by">
                        <input type="checkbox" <?php checked($this->optionsSerialized->showPluginPoweredByLink == 1) ?> value="1" name="wc_show_plugin_powerid_by" id="wc_show_plugin_powerid_by" />
                        <span id="wpdiscuz_thank_you" style="color:#006600; font-size:13px;"> &nbsp;<?php _e('Thank you!', 'wpdiscuz'); ?></span>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</div>