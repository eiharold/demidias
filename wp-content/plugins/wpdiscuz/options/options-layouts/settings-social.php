<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 class="wpd-subtitle"><?php _e('Social Login &amp; Share', 'wpdiscuz'); ?> </h2>
    <table class="wp-list-table widefat plugins wpdxb" style="margin-top:10px; border:none;">
        <tbody>
        <tr valign="top">
            <th scope="row" style="width: 60%;">
                <label for="socialLoginAgreementCheckbox"><?php _e('User agreement prior to a social login action', 'wpdiscuz'); ?></label>
                <p class="wpd-desc" style="width: 93%;"><?php _e('If this option is enabled, all Social Login buttons become not-clickable until user accept automatic account creation process based on his/her Social Network Account shared information (email, name). This checkbox and appropriate information will be displayed when user click on a social login button, prior to the login process. This extra step is added to comply with the GDPR', 'wpdiscuz'); ?> <a href="https://gdpr-info.eu/art-22-gdpr/" target="_blank" rel="noreferrer">(Article 22)</a> <br><?php _e('The note text and the label of this checkbox can be managed in Comments > Phrases > Social Login tab.','wpdiscuz') ?></p>
            </th>
            <td style="padding-top: 20px;">
                <input type="checkbox" value="1" <?php checked($this->optionsSerialized->socialLoginAgreementCheckbox == 1) ?> name="socialLoginAgreementCheckbox" id="socialLoginAgreementCheckbox" />
                <label for="socialLoginAgreementCheckbox"></label>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/social-login-and-share/#agreement" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" style="width: 60%;">
                <label for="socialLoginInSecondaryForm"><?php _e('Display social login buttons on reply forms', 'wpdiscuz'); ?></label>
            </th>
            <td>
                <input type="checkbox" value="1" <?php checked($this->optionsSerialized->socialLoginInSecondaryForm == 1) ?> name="socialLoginInSecondaryForm" id="socialLoginInSecondaryForm" />
                <label for="socialLoginInSecondaryForm"></label>
                <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/social-login-and-share/#display_on_reply_forms" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="wp-list-table widefat plugins wpdxb wpd-social-login" style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th class="wpd-social-lable wpd-facebook" colspan="2" style="padding: 10px 10px 8px 10px;">
                    <img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/social-icons/fb-m.png'); ?>" style="vertical-align:bottom; height: 30px; margin-bottom: -2px; position: relative;" />&nbsp; <?php _e('Facebook','wpdiscuz');?>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="font-size: 14px; font-style: italic;">
                        <?php _e('To start using Facebook Login and Share Buttons you should get Facebook Application Key and Secret for your website. Please follow to this', 'wpdiscuz'); ?> <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/social-login-and-share/facebook-app-configuration/" target="_blank"><?php _e('instruction &raquo;','wpdiscuz');?></a><br>
                        <?php echo __('Valid OAuth Redirect URI','wpdiscuz') . ' : <code>' . admin_url('admin-ajax.php?action=wpd_login_callback&provider=facebook') . '</code>';?>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width: 60%">
                    <label for="wpd-enable-fb-login"><?php _e('Enable Login Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php  checked($this->optionsSerialized->enableFbLogin == 1); ?> value="1" name="enableFbLogin" id="wpd-enable-fb-login" />
                    <label for="wpd-enable-fb-login"></label>
                </td>
            </tr>
            <?php if( is_ssl() ): ?>
                <tr valign="top">
                    <th scope="row" style="width: 60%">
                        <label for="wpd-use-fb-oauth"><?php _e('Use Facebook OAuth2', 'wpdiscuz'); ?></label>
                        <p class="wpd-info"><?php _e('If you enable this option, please make sure you\'ve inserted the Valid OAuth Redirect URI in according field when you create Facebook Login App. Your website OAuth Redirect URI is displayed above.' , 'wpforo'); ?></p>
                    </th>
                    <td scope="row">
                        <input type="checkbox" <?php  checked($this->optionsSerialized->fbUseOAuth2 == 1); ?> value="1" name="fbUseOAuth2" id="wpd-use-fb-oauth" />
                        <label for="wpd-use-fb-oauth"></label>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <th scope="row">
                    <label for="wpd-enable-fb-share"><?php _e('Enable Share Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php checked($this->optionsSerialized->enableFbShare == 1); ?> value="1" name="enableFbShare" id="wpd-enable-fb-share" />
                    <label for="wpd-enable-fb-share"></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-fb-app-id"><?php _e('Aplication ID', 'wpdiscuz'); ?></label>
                </th>
                <td >
                    <input placeholder="<?php _e('Aplication ID', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->fbAppID;?>" name="fbAppID" id="wpd-fb-app-id" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-fb-app-secret"><?php _e('Aplication Secret', 'wpdiscuz'); ?></label>
                </th>
                <td >
                    <input placeholder="<?php _e('Aplication Secret', 'wpdiscuz'); ?>"  type="text" value="<?php echo $this->optionsSerialized->fbAppSecret;?>" name="fbAppSecret" id="wpd-fb-app-secret" /></td>
            </tr>


            <tr valign="top">
                <th class="wpd-social-lable wpd-twitter" colspan="2" style="padding: 10px 10px 8px 10px;">
                    <img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/social-icons/tw-m.png'); ?>" style="vertical-align:bottom; height: 30px; margin-bottom: -2px; position: relative;" />&nbsp; <?php _e('Twitter','wpdiscuz');?>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="font-size: 14px; font-style: italic;">
                        <?php _e('To start using Twitter Login Button you should get Consumer Key and Secret for your website. Please follow to this', 'wpdiscuz'); ?> <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/social-login-and-share/twitter-api-key-and-consumer-secret/" target="_blank"><?php _e('instruction &raquo;','wpdiscuz');?></a><br>
                        <?php echo __('Callback URL','wpdiscuz') . ' : <code>' . admin_url('admin-ajax.php') . '</code>';?>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th>
                    <label for="wpd-enable-twitter-login"><?php _e('Enable Login Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php  checked($this->optionsSerialized->enableTwitterLogin == 1); ?> value="1" name="enableTwitterLogin" id="wpd-enable-twitter-login" />
                    <label for="wpd-enable-twitter-login"></label>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="wpd-enable-twitter-share"><?php _e('Enable Share Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php checked($this->optionsSerialized->enableTwitterShare == 1); ?> value="1" name="enableTwitterShare" id="wpd-enable-twitter-share" />
                    <label for="wpd-enable-twitter-share"></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-twitter-app-id"><?php _e('Consumer Key (API Key)', 'wpdiscuz'); ?></label>
                </th>
                <td><input placeholder="<?php _e('Consumer Key (API Key)', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->twitterAppID;?>" name="twitterAppID" id="wpd-twitter-app-id" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-twitter-app-secret"><?php _e('Consumer Secret (API Secret)', 'wpdiscuz'); ?></label>
                </th>
                <td >
                    <input placeholder="<?php _e('Consumer Secret (API Secret)', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->twitterAppSecret;?>" name="twitterAppSecret" id="wpd-twitter-app-secret" />
                </td>
            </tr>



            <tr valign="top">
                <th class="wpd-social-lable wpd-google" colspan="2" style="padding: 10px 10px 8px 10px;">
                    <img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/social-icons/gg-m.png'); ?>" style="vertical-align:bottom; height: 30px; margin-bottom: -2px; position: relative;" />&nbsp; <?php _e('Google +','wpdiscuz');?>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="font-size: 14px; font-style: italic;">
                        <?php _e('To start using Google+ Login Button you should get Client ID for your website. Please follow to this', 'wpdiscuz'); ?> <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/social-login-and-share/google-client-id/" target="_blank"><?php _e('instruction &raquo;','wpdiscuz');?></a><br>
                        <?php echo __('Authorized JavaScript Sources / Permitted URI redirects','wpdiscuz') . ' : <code>' . home_url() . '</code>';?>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th>
                    <label for="wpd-enable-google-login"><?php _e('Enable Login Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php checked($this->optionsSerialized->enableGoogleLogin == 1); ?> value="1" name="enableGoogleLogin" id="wpd-enable-google-login" />
                    <label for="wpd-enable-google-login"></label>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="wpd-enable-google-share"><?php _e('Enable Share Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input placeholder="<?php _e('Enable Share Button', 'wpdiscuz'); ?>" type="checkbox" <?php checked($this->optionsSerialized->enableGoogleShare == 1); ?> value="1" name="enableGoogleShare" id="wpd-enable-google-share" />
                    <label for="wpd-enable-google-share"></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-google-app-id"><?php _e('Client ID', 'wpdiscuz'); ?></label>
                </th>
                <td ><input placeholder="<?php _e('Client ID', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->googleAppID;?>" name="googleAppID" id="wpd-google-app-id" /></td>
            </tr>



            <tr valign="top">
                <th class="wpd-social-lable wpd-vk" colspan="2" style="padding: 10px 10px 8px 10px;">
                    <img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/social-icons/vk-m.png'); ?>" style="vertical-align:bottom; height: 30px; margin-bottom: -2px; position: relative;" />&nbsp; <?php _e('VK','wpdiscuz');?>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="font-size: 14px; font-style: italic;">
                        <?php _e('To start using VK Login Button you should get Application ID and Secure Key. Please follow to this ', 'wpdiscuz'); ?> <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/social-login-and-share/vk-application-id-and-secure-key/" target="_blank"><?php _e('instruction &raquo;','wpdiscuz');?></a><br>
                        <?php echo __('Redirect URI','wpdiscuz') . ' : <code>' . admin_url('admin-ajax.php') . '</code>';?>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th>
                    <label for="wpd-enable-vk-login"><?php _e('Enable Login Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php  checked($this->optionsSerialized->enableVkLogin == 1); ?> value="1" name="enableVkLogin" id="wpd-enable-vk-login" />
                    <label for="wpd-enable-vk-login"></label>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="wpd-enable-vk-share"><?php _e('Enable Share Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php checked($this->optionsSerialized->enableVkShare == 1); ?> value="1" name="enableVkShare" id="wpd-enable-vk-share" />
                    <label for="wpd-enable-vk-share"></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-vk-app-id"><?php _e('Application ID', 'wpdiscuz'); ?></label>
                </th>
                <td ><input placeholder="<?php _e('Application ID', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->vkAppID;?>" name="vkAppID" id="wpd-vk-app-id" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-vk-app-secret"><?php _e('Secure Key', 'wpdiscuz'); ?></label>
                </th>
                <td ><input placeholder="<?php _e('Secure Key', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->vkAppSecret;?>" name="vkAppSecret" id="wpd-vk-app-secret" /></td>
            </tr>



            <tr valign="top">
                <th class="wpd-social-lable wpd-ok" colspan="2" style="padding: 10px 10px 8px 10px;">
                    <img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/social-icons/ok-m.png'); ?>" style="vertical-align:bottom; height: 30px; margin-bottom: -2px; position: relative;" />&nbsp; <?php _e('OK','wpdiscuz');?>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="font-size: 14px; font-style: italic;">
                        <?php _e('Getting started with','wpdiscuz');?> <a href="https://apiok.ru/en/ext/oauth/">OK API</a><br>
                        <?php _e('To get the Aplication ID, Key and Secret, you should create an app using one of the supported types (external, Android, iOS), use this', 'wpdiscuz'); ?> <a href="https://apiok.ru/en/dev/app/create" target="_blank"><?php _e('instruction &raquo;','wpdiscuz');?></a><br>
                        <?php echo __('Redirect URI','wpdiscuz') . ' : <code>' . admin_url('admin-ajax.php') . '</code>';?>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th>
                    <label for="wpd-enable-ok-login"><?php _e('Enable Login Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php  checked($this->optionsSerialized->enableOkLogin == 1); ?> value="1" name="enableOkLogin" id="wpd-enable-ok-login" />
                    <label for="wpd-enable-ok-login"></label>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="wpd-enable-ok-share"><?php _e('Enable Share Button', 'wpdiscuz'); ?></label>
                </th>
                <td scope="row">
                    <input type="checkbox" <?php checked($this->optionsSerialized->enableOkShare == 1); ?> value="1" name="enableOkShare" id="wpd-enable-ok-share" />
                    <label for="wpd-enable-ok-share"></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-ok-app-id"><?php _e('Aplication ID', 'wpdiscuz'); ?></label>
                </th>
                <td ><input placeholder="<?php _e('Aplication ID', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->okAppID;?>" name="okAppID" id="wpd-ok-app-id" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-ok-app-key"><?php _e('Aplication Key', 'wpdiscuz'); ?></label>
                </th>
                <td ><input placeholder="<?php _e('Aplication Key', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->okAppKey;?>" name="okAppKey" id="wpd-ok-app-key" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="wpd-ok-app-secret"><?php _e('Aplication Secret', 'wpdiscuz'); ?></label>
                </th>
                <td ><input placeholder="<?php _e('Aplication Secret', 'wpdiscuz'); ?>" type="text" value="<?php echo $this->optionsSerialized->okAppSecret;?>" name="okAppSecret" id="wpd-ok-app-secret" /></td>
            </tr>
        </tbody>
    </table>
</div>
