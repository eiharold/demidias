<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<a id='wpdDeactivationReasonAnchor' style='display:none;' rel='#wpdDeactivationReason' data-wpd-lity>&nbsp;</a>
<div id='wpdDeactivationReason' style='overflow:auto;background:#FDFDF6;padding:20px;width:600px;max-width:100%;border-radius:6px' class='lity-hide'>
    <div class="wpd-deactivation-reason-wrap">
        <form method="post" action="" class="wpd-deactivation-reason-form">
            <h2 class="wpd-deactivation-reason-modal-title"><?php _e('Plugin Usage Feedback', 'wpdiscuz'); ?></h2>            
            <div class="wpd-deactivation-reason-desc">
                <p class="wpdiscuz-desc">
                    <strong><?php _e('Please let us know why you are deactivating. Choosing one of the options below you will help us make it better for you and for other users.', 'wpdiscuz'); ?></strong>
                </p>
            </div>
            <div class="wpd-deactivation-reasons">
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="I'll reactivate it later" name="deactivation_reason" id="reactivate_later" class="wpd-deactivation-reason"/>
                    <label for="reactivate_later"><?php _e('I\'ll reactivate it later', 'wpdiscuz'); ?></label>
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="The plugin is not working" name="deactivation_reason" id="not_working" class="wpd-deactivation-reason"/>
                    <label for="not_working"><?php _e('The plugin is not working', 'wpdiscuz'); ?></label>
                    <div class="wpd-deactivation-reason-more-info"><textarea class="dr_more_info" required="required" name="deactivation_reason_desc" rows="3" placeholder="<?php _e('What kind of problems do you have?', 'wpdiscuz'); ?>"></textarea></div>
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="It's not what I was looking for" name="deactivation_reason" id="not_what_i_looking_for" class="wpd-deactivation-reason"/>
                    <label for="not_what_i_looking_for"><?php _e('It\'s not what I was looking for', 'wpdiscuz'); ?></label>                    
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="I couldn't understand how to make it work" name="deactivation_reason" id="how_to_make_it_work" class="wpd-deactivation-reason"/>
                    <label for="how_to_make_it_work"><?php _e('I couldn\'t understand how to make it work', 'wpdiscuz'); ?></label>
                    <div class="wpd-deactivation-reason-more-info"><textarea class="dr_more_info" required="required" name="deactivation_reason_desc" rows="3" placeholder="<?php _e('What type of features you want to be in the plugin?', 'wpdiscuz'); ?>"></textarea></div>
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="The plugin is great, but I need specific features" name="deactivation_reason" id="need_specific_features" class="wpd-deactivation-reason"/>
                    <label for="need_specific_features"><?php _e('The plugin is great, but I need specific features', 'wpdiscuz'); ?></label>
                    <div class="wpd-deactivation-reason-more-info"><textarea class="dr_more_info" required="required" name="deactivation_reason_desc" rows="3" placeholder="<?php _e('What type of features you want to be in the plugin?', 'wpdiscuz'); ?>"></textarea></div>
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="I didn't like plugin design" name="deactivation_reason" id="did_not_like_design" class="wpd-deactivation-reason"/>
                    <label for="did_not_like_design"><?php _e('I didn\'t like plugin design', 'wpdiscuz'); ?></label>
                    <div class="wpd-deactivation-reason-more-info"><textarea class="dr_more_info" required="required" name="deactivation_reason_desc" rows="3" placeholder="<?php _e('What part of design you don\'t like or want to change?', 'wpdiscuz'); ?>"></textarea></div>
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="The plugin works very slow" name="deactivation_reason" id="works_very_slow" class="wpd-deactivation-reason"/>
                    <label for="works_very_slow"><?php _e('The plugin works very slow', 'wpdiscuz'); ?></label>
                    <div class="wpd-deactivation-reason-more-info"><textarea class="dr_more_info" required="required" name="deactivation_reason_desc" rows="3" placeholder="<?php _e('Could you please describe which features of the plugin slows down your website?', 'wpdiscuz'); ?>"></textarea></div>
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="I found a better plugin" name="deactivation_reason" id="found_better" class="wpd-deactivation-reason"/>
                    <label for="found_better"><?php _e('I found a better plugin', 'wpdiscuz'); ?></label>
                    <div class="wpd-deactivation-reason-more-info"><textarea class="dr_more_info" required="required" name="deactivation_reason_desc" rows="3" placeholder="<?php _e('Please provide a plugin name or URL', 'wpdiscuz'); ?>"></textarea></div>
                </div>
                <div class="wpd-deactivation-reason-item">
                    <input type="radio" value="Other" name="deactivation_reason" id="other" class="wpd-deactivation-reason"/>
                    <label for="other"><?php _e('Other', 'wpdiscuz'); ?></label>
                    <div class="wpd-deactivation-reason-more-info"><textarea class="dr_more_info" name="deactivation_reason_desc" rows="3" placeholder="<?php _e('Please provide more information', 'wpdiscuz'); ?>"></textarea></div>
                </div>                
            </div>
            <div class="wpd-deactivation-reasons-actions">
                <button type="button" class="button button-secondary wpd-dismiss wpd-deactivate"><?php _e('Dismiss and never show again', 'wpdiscuz'); ?></button>
                <button type="button" class="button button-primary wpd-submit wpd-deactivate"><?php _e('Submit &amp; Deactivate'); ?><i class="fas fa-pulse fa-spinner wpd-loading wpdiscuz-hidden"></i></button>
            </div>
        </form>
        <h2 class="wpdiscuz-thankyou wpdiscuz-hidden"><?php _e('Thank you for your feedback!', 'wpdiscuz'); ?></h2>
    </div>
</div>