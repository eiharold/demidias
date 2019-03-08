<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div class="wrap wpdiscuz_tools_page">
    <div style="float:left; width:50px; height:55px; margin:10px 10px 20px 0px;">
        <img src="<?php echo plugins_url(WPDISCUZ_DIR_NAME . '/assets/img/plugin-icon/plugin-icon-48.png'); ?>" style="border:2px solid #fff;"/>
    </div>
    <h1 style="padding-bottom:20px; padding-top:15px;"><?php _e('wpDiscuz Tools', 'wpdiscuz'); ?></h1>
    <br style="clear:both" />
    <?php settings_errors('wpdiscuz'); ?>
    <div id="toolsTab">
        <ul class="resp-tabs-list tools_tab_id">
            <li><?php _e('Export options', 'wpdiscuz'); ?></li>
            <li><?php _e('Import options', 'wpdiscuz'); ?></li>
            <li><?php _e('Import subscriptions', 'wpdiscuz'); ?></li>            
            <li><?php _e('Other', 'wpdiscuz'); ?></li>
        </ul>
        <div class="resp-tabs-container tools_tab_id">
            <?php
            include 'tools-layouts/options-export.php';
            include 'tools-layouts/options-import.php';
            include 'tools-layouts/subscriptions-import.php';
            include 'tools-layouts/tools-other.php';
            ?>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            var width = 0;
            var toolsTabsType = 'default';
            $('#toolsTab ul.resp-tabs-list.tools_tab_id li').each(function () {
                width += $(this).outerWidth(true);
            });

            if (width > $('#toolsTab').innerWidth()) {
                toolsTabsType = 'vertical';
            }

            //Horizontal Tab
            $('#toolsTab').wpdiscuzEasyResponsiveTabs({
                type: toolsTabsType, //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true, // 100% fit in a container
                tabidentify: 'tools_tab_id' // The tab groups identifier
            });
        });
    </script>
</div>