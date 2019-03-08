<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 class="wpd-subtitle"><?php _e('Custom Fields', 'wpdiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins wpdxb" style="margin-top:10px; border:none;">
        <tbody>            
            <tr valign="top">
                <th colspan="2">
                    <span class="wpdiscuz-option-title"><?php _e('Google Map API Key', 'wpdiscuz'); ?></span>
                </th>
                <td>
                    <?php $googleMapsApiKey = isset($this->optionsSerialized->googleMapsApiKey) ? $this->optionsSerialized->googleMapsApiKey : ''; ?>
                    <input type="text"  value="<?php echo $googleMapsApiKey; ?>" id="wcf_google_map_api_key" name="wcf_google_map_api_key"/>                    
                </td>                
            </tr>
        </tbody>
    </table>
</div>
