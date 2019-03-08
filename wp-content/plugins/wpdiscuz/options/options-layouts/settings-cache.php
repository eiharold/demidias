<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>    
    <table class="wp-list-table widefat plugins wpdxb" style="margin-top:10px; border:none;">
        <tbody>
            <tr>
                <td><h2 class="wpd-subtitle"><?php _e('Gravatar Cache', 'wpdiscuz'); ?></h2></td>
                <td></td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width: 45%;">
                    <label for="isGravatarCacheEnabled"><?php _e('Enable Gravatar caching', 'wpdiscuz'); ?></label>
                    <?php if (!$this->optionsSerialized->isFileFunctionsExists) { ?>
                        <p class="desc"><?php _e('It seems on of important functions ("file_get_contents", "file_put_contents") of php is not exists.<br/> Please enable these functions in your server settings to use gravatar caching feature.', 'wpdiscuz'); ?></p>
                    <?php } ?>
                </th>
                <td>   
                    <input type="checkbox" <?php checked($this->optionsSerialized->isGravatarCacheEnabled == 1) ?> value="1" name="isGravatarCacheEnabled" id="isGravatarCacheEnabled" />
                    <label for="isGravatarCacheEnabled"></label>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/cache/#grvatar_caching" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="gravatarCacheMethod"><?php _e('Caching method', 'wpdiscuz'); ?></label></th>
                <th>   
                    <div class="wpd-switch-field">
                        <input type="radio" <?php checked($this->optionsSerialized->gravatarCacheMethod == 'runtime') ?> value="runtime" name="gravatarCacheMethod" id="gravatarCacheMethodRuntime" /><label for="gravatarCacheMethodRuntime"><?php _e('Runtime', 'wpdiscuz'); ?></label> 
                        <input type="radio" <?php checked($this->optionsSerialized->gravatarCacheMethod == 'cronjob') ?> value="cronjob" name="gravatarCacheMethod" id="gravatarCacheMethodCronjob" /><label for="gravatarCacheMethodCronjob"><?php _e('Cron job', 'wpdiscuz'); ?></label>
                    </div>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/cache/#caching_method" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="gravatarCacheTimeout"><?php _e('Cache avatars for "X" days', 'wpdiscuz'); ?></label></th>
                <td>
                    <?php $gravatarCacheTimeout = isset($this->optionsSerialized->gravatarCacheTimeout) && ($days = absint($this->optionsSerialized->gravatarCacheTimeout)) ? $days : 10; ?>
                    <input type="number" id="gravatarCacheTimeout" name="gravatarCacheTimeout" value="<?php echo $gravatarCacheTimeout; ?>"/>
                    <a href="https://wpdiscuz.com/docs/wpdiscuz-documentation/settings/cache/#cache_avatars_for_days" title="<?php _e('Read the documentation', 'wpdiscuz') ?>" target="_blank"><i class="far fa-question-circle"></i></a>
                </td>
            </tr>
            <tr>
                <th><?php _e('Purge expired caches', 'wpdiscuz'); ?></th>
                <td>
                    <?php $expiredCacheUrl = admin_url('admin-post.php?action=purgeExpiredGravatarsCaches'); ?>
                    <a id="wpdiscuz-purge-expired-gravatars-cache" href="<?php echo wp_nonce_url($expiredCacheUrl, 'purgeExpiredGravatarsCaches'); ?>" class="button button-secondary" style="margin-left: 5px;"><?php _e('Purge expired caches', 'wpdiscuz'); ?></a>
                </td>
            </tr>
            <tr>
                <th><?php _e('Purge all caches', 'wpdiscuz'); ?></th>
                <td>
                    <?php $allCacheUrl = admin_url('admin-post.php?action=purgeGravatarsCaches'); ?>
                    <a id="wpdiscuz-purge-gravatars-cache" href="<?php echo wp_nonce_url($allCacheUrl, 'purgeGravatarsCaches'); ?>" class="button button-secondary" style="margin-left: 5px;"><?php _e('Purge all caches', 'wpdiscuz'); ?></a>
                </td>
            </tr>
            <tr>
                <td><h2 class="wpd-subtitle"><?php _e('Statistics Cache', 'wpdiscuz'); ?></h2></td>
                <td></td>
            </tr>
            <tr>
                <th><?php _e('Purge statistics caches', 'wpdiscuz'); ?></th>
                <td>
                    <?php $statCacheUrl = admin_url('admin-post.php?action=purgeStatisticsCache'); ?>
                    <a id="wpdiscuz-purge-statistics-cache" href="<?php echo wp_nonce_url($statCacheUrl, 'purgeStatisticsCache'); ?>" class="button button-secondary" style="margin-left: 5px;"><?php _e('Purge statistics caches', 'wpdiscuz'); ?></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>