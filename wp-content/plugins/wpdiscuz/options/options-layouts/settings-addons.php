<?php
if (!defined('ABSPATH')) {
    exit();
}
$isMuExists = class_exists('WpdiscuzMediaUploader');
$isUcmExists = class_exists('WpdiscuzUCM');
$isAlExists = class_exists('WpdiscuzVoters');
$isFemExists = class_exists('frontEndModeration');
$isCaiExists = class_exists('WpdiscuzCommentAuthorInfo');
$isRafExists = class_exists('wpDiscuzFlagComment');
$showDemos = get_option(WpDiscuzConstants::OPTION_SLUG_SHOW_DEMO, 1);
?>
<div>
    <h2 class="wpd-subtitle"><?php _e('Addons', 'wpdiscuz'); ?></h2>   
    <table class="wp-list-table widefat plugins" style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row">

                    <p style="padding:10px; font-style:italic;"><?php _e('Here you can find wpDiscuz Addons\' setting options in vertical subTabs with according addon titles. All wpDiscuz addons are listed on wpDiscuz', 'wpdiscuz'); ?> &gt; <a href="<?php echo admin_url('edit-comments.php?page=' . WpdiscuzCore::PAGE_ADDONS) ?>"><?php _e('Addons subMenu', 'wpdiscuz'); ?></a>. <?php _e('We\'ll add new free and paid addons with almost every wpDiscuz release. There will be dozens of very useful addons in near future. Currently wpDiscuz consists of about 70 free features/addons like "Live Update", "First comment redirection", "Comment sorting", "Simple CAPTCHA", "AJAX Pagination", "Lazy Load", "Comment Likes", "Comment Share" and dozens of other addons and there will be more. All new and free addons will be built-in with wpDiscuz plugin and all paid addons will be listed separately on', 'wpdiscuz'); ?> <a href="<?php echo admin_url('edit-comments.php?page=' . WpdiscuzCore::PAGE_ADDONS) ?>"><?php _e('Addons subMenu', 'wpdiscuz'); ?></a>.</p>

                    <div class="wpdxx" style="text-align: right;">
                        <div style="display: inline-block; padding: 0px 10px; font-size: 16px; color: #666;">Demo Addons </div>
                        <input type="checkbox" name="disable-demo-addons" value="1" id="wpd-disable-addons" <?php checked($showDemos); ?>/>
                        <label for="wpd-disable-addons" style="display: inline-block; margin-right: 30px;">&nbsp;</label>
                        <?php
                        $show = get_option(WpDiscuzConstants::OPTION_SLUG_SHOW_DEMO, 1);
                        $disableAddonsUrl = admin_url('admin-post.php?action=disableAddonsDemo&show=' . intval(!$showDemos));
                        ?>
                        <input type="hidden" value="<?php echo wp_nonce_url($disableAddonsUrl, 'disableAddonsDemo'); ?>" id="wpd-disable-addons-action" />
                    </div>

                    <hr style="margin-bottom:25px; border-color:#fff;" />
                    <div id="wpdiscuz-addons-options">
                        <ul class="resp-tabs-list wpdiscuz-addons-options">
                            <?php do_action('wpdiscuz_addon_tab_title'); ?>
                            <?php
                            if ($showDemos) {
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/mu/title.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/ucm/title.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/al/title.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/fem/title.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/cai/title.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/raf/title.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/more/title.php';
                            }
                            ?>
                        </ul>
                        <div class="resp-tabs-container wpdiscuz-addons-options">
                            <?php do_action('wpdiscuz_addon_tab_content'); ?>
                            <?php
                            if ($showDemos) {
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/mu/content.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/ucm/content.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/al/content.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/fem/content.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/cai/content.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/raf/content.php';
                                include_once WPDISCUZ_DIR_PATH . '/options/addons/more/content.php';
                            }
                            ?>
                        </div>
                    </div>
                </th>
            </tr>
        </tbody>
    </table>
</div>