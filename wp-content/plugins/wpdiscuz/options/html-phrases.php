<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div class="wrap wpdiscuz_options_page">
    <div style="float:left; width:50px; height:55px; margin:10px 10px 20px 0px;">
        <img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/plugin-icon/plugin-icon-48.png'); ?>" style="border:2px solid #fff;"/>
    </div>
    <h1 style="padding-bottom:20px; padding-top:15px;"><?php _e('wpDiscuz Front-end Phrases', 'wpdiscuz'); ?></h1>
    <br style="clear:both" />
    <?php settings_errors('wpdiscuz'); ?>
    <form action="<?php echo admin_url(); ?>edit-comments.php?page=<?php echo WpdiscuzCore::PAGE_PHRASES; ?>" method="post" name="<?php echo WpdiscuzCore::PAGE_PHRASES; ?>" class="wc-phrases-settings-form wc-form">
        <?php
        if (function_exists('wp_nonce_field')) {
            wp_nonce_field('wc_phrases_form');
        }
        ?>
        <div id="phrasesTab">
            <ul class="resp-tabs-list phrases_tab_id">
                <li><?php _e('General', 'wpdiscuz'); ?></li>
                <li><?php _e('Form', 'wpdiscuz'); ?></li>
                <li><?php _e('Comment', 'wpdiscuz'); ?></li>
                <li><?php _e('Date/Time', 'wpdiscuz'); ?></li>
                <li><?php _e('Email', 'wpdiscuz'); ?></li>
                <li><?php _e('Notification', 'wpdiscuz'); ?></li>
                <li><?php _e('Follow', 'wpdiscuz'); ?></li>
                <li><?php _e('Social Login', 'wpdiscuz'); ?></li>
                <li><?php _e('User Settings', 'wpdiscuz'); ?></li>
                <li><?php _e('Errors', 'wpdiscuz'); ?></li>
            </ul>
            <div class="resp-tabs-container phrases_tab_id">
                <?php include 'phrases-layouts/phrases-general.php'; ?>
                <?php include 'phrases-layouts/phrases-form.php'; ?>
                <?php include 'phrases-layouts/phrases-comment.php'; ?>
                <?php include 'phrases-layouts/phrases-datetime.php'; ?>
                <?php include 'phrases-layouts/phrases-email.php'; ?>
                <?php include 'phrases-layouts/phrases-notification.php'; ?>
                <?php include 'phrases-layouts/phrases-follow.php'; ?>
                <?php include 'phrases-layouts/phrases-social-login.php'; ?>
                <?php include 'phrases-layouts/phrases-user-settings.php'; ?>
                <?php include 'phrases-layouts/phrases-error.php'; ?>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                var width = 0;
                var phrasesTabsType = 'default';
                $('#phrasesTab ul.resp-tabs-list.phrases_tab_id li').each(function () {
                    width += $(this).outerWidth(true);
                });

                if (width > $('#phrasesTab').innerWidth()) {
                    phrasesTabsType = 'vertical';
                }
                $('#phrasesTab').wpdiscuzEasyResponsiveTabs({
                    type: phrasesTabsType, //Types: default, vertical, accordion
                    width: 'auto', //auto or any width like 600px
                    fit: true, // 100% fit in a container
                    tabidentify: 'phrases_tab_id' // The tab groups identifier
                });
                $(document).delegate('.phrases_tab_id .resp-tab-item', 'click', function () {
                    var activeTabIndex = $('.resp-tabs-list.phrases_tab_id li.resp-tab-active').index();
                    Cookies.set('phrasesActiveTabIndex', activeTabIndex, {expires: 30});
                });
                var savedIndex = Cookies.get('phrasesActiveTabIndex') >= 0 ? Cookies.get('phrasesActiveTabIndex') : 0;
                $('.resp-tabs-list.phrases_tab_id li').removeClass('resp-tab-active');
                $('.resp-tabs-container.phrases_tab_id > div').removeClass('resp-tab-content-active');
                $('.resp-tabs-container.phrases_tab_id > div').css('display', 'none');
                $('.resp-tabs-list.phrases_tab_id li').eq(savedIndex).addClass('resp-tab-active');
                $('.resp-tabs-container.phrases_tab_id > div').eq(savedIndex).addClass('resp-tab-content-active');
                $('.resp-tabs-container.phrases_tab_id > div').eq(savedIndex).css('display', 'block');
            });
        </script>
        <table class="form-table wc-form-table">
            <tbody>
                <tr valign="top">
                    <td colspan="4">
                        <p class="submit">
                            <?php $resetPhrasesUrl = admin_url('admin-post.php?action=resetPhrases'); ?>
                            <a id="wpdiscuz-reset-phrases" href="<?php echo wp_nonce_url($resetPhrasesUrl, 'reset_phrases_nonce'); ?>" class="button button-secondary" style="margin-left: 5px;"><?php _e('Reset Phrases', 'wpdiscuz'); ?></a>
                            <input type="submit" class="button button-primary" name="wc_submit_phrases" value="<?php _e('Save Changes', 'wpdiscuz'); ?>" style="float: right;" />
                        </p>
                    </td>
                </tr>
            <input type="hidden" name="action" value="update" />
            </tbody>
        </table>
    </form>
</div>