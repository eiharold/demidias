<?php

namespace wpdFormAttr\Field;

class ColorField extends Field {

    protected function dashboardForm() {
        ?>
        <div class="wpd-field-body" style="display: <?php echo $this->display; ?>">
            <div class="wpd-field-option wpdiscuz-item">
                <input class="wpd-field-type" type="hidden" value="<?php echo $this->type; ?>" name="<?php echo $this->fieldInputName; ?>[type]" />
                <label for="wpd-field-name"><?php _e('Name', 'wpdiscuz'); ?>:</label> 
                <input id="wpd-field-name" class="wpd-field-name" type="text" value="<?php echo $this->fieldData['name']; ?>" name="<?php echo $this->fieldInputName; ?>[name]" required />
                <p class="wpd-info"><?php _e('Also used for field placeholder', 'wpdiscuz'); ?></p>
            </div>
            <div class="wpd-field-option">
                <label for="wpd-field-desc"><?php _e('Description', 'wpdiscuz'); ?>:</label> 
                <input id="wpd-field-desc" type="text" value="<?php echo $this->fieldData['desc']; ?>" name="<?php echo $this->fieldInputName; ?>[desc]" />
                <p class="wpd-info"><?php _e('Field specific short description or some rule related to inserted information.', 'wpdiscuz'); ?></p>
            </div>
            <div class="wpd-field-option">
                <div class="input-group">
                    <label for="wpd-field-color"><span class="input-group-addon"></span> <?php _e('Field icon', 'wpdiscuz'); ?>:</label>
                    <input id="wpd-field-color" data-placement="bottom" class="icp icp-auto" value="<?php echo $this->fieldData['icon']; ?>" type="text" name="<?php echo $this->fieldInputName; ?>[icon]"/>
                </div>
                <p class="wpd-info"><?php _e('Font-awesome icon library.', 'wpdiscuz'); ?></p>
            </div>
            <div class="wpd-field-option">
                <label for="wpd-field-is-required"><?php _e('Field is required', 'wpdiscuz'); ?>:</label> 
                <input id="wpd-field-is-required" type="checkbox" value="1" <?php checked($this->fieldData['required'], 1, true); ?> name="<?php echo $this->fieldInputName; ?>[required]" />
            </div>
            <div class="wpd-field-option">
                <label><?php _e('Display on reply form', 'wpdiscuz'); ?>:</label> 
                <input type="checkbox" value="1" <?php checked($this->fieldData['is_show_sform'], 1, true); ?> name="<?php echo $this->fieldInputName; ?>[is_show_sform]" />
            </div>
            <div class="wpd-field-option">
                <label for="wpd-field-is-show-on-comment"><?php _e('Display on comment', 'wpdiscuz'); ?>:</label> 
                <input id="wpd-field-is-show-on-comment" type="checkbox" value="1" <?php checked($this->fieldData['is_show_on_comment'], 1, true); ?> name="<?php echo $this->fieldInputName; ?>[is_show_on_comment]" />
            </div>
            <div class="wpd-advaced-options wpd-field-option">
                <small class="wpd-advaced-options-title"><?php _e('Advanced Options', 'wpdiscuz'); ?></small>
                <div class="wpd-field-option wpd-advaced-options-cont">
                    <div class="wpd-field-option">
                        <label for="wpd-field-meta-key"><?php _e('Meta Key', 'wpdiscuz'); ?>:</label> 
                        <input id="wpd-field-meta-key" type="text" value="<?php echo $this->name; ?>"  name="<?php echo $this->fieldInputName; ?>[meta_key]"  required="required"/>
                    </div>
                    <div class="wpd-field-option">
                        <label for="wpd-field-old-meta-key"><?php _e('Replace old meta key', 'wpdiscuz'); ?>:</label> 
                        <input id="wpd-field-old-meta-key" type="checkbox" value="1" checked="checked"  name="<?php echo $this->fieldInputName; ?>[meta_key_replace]" />
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <?php
    }

    public function editCommentHtml($key, $value, $data, $comment) {
        if ($comment->comment_parent && !$data['is_show_sform']) {
            return '';
        }
        $html = '<tr><td class="first">';
        $html .= '<label for = "' . $key . '">' . $data['name'] . ': </label>';
        $html .= '</td><td>';
        $html .= '<div class="wpdiscuz-item">';
        $required = $data['required'] ? 'required="required"' : '';
        $html .= '<input  ' . $required . ' class="wpd-field wpd-field-color" type="color" id="' . $key . '" value="' . $value . '"  name="' . $key . '" pattern="^\#[A-Za-z0-9]{6}$" title="#ff8040">';
        $html .= '</div>';
        $html .= '</td></tr >';
        return $html;
    }

    public function frontFormHtml($name, $args, $options, $currentUser, $uniqueId, $isMainForm) {
        if (!$isMainForm && !$args['is_show_sform']) {
            return;
        }
        $hasIcon = $args['icon'] ? true : false;
        $hasDesc = $args['desc'] ? true : false;
        ?>
        <div class="wpdiscuz-item wpd-field-color <?php echo $hasIcon ? 'wpd-has-icon' : '' ?> <?php echo $hasDesc ? 'wpd-has-desc' : '' ?>">
            <div class="wpd-field-title">
                <?php echo $args['name']; ?>
            </div>
            <?php if ($hasIcon) { ?>
                <div class="wpd-field-icon"><i style="opacity: 0.8;" class="<?php echo strpos(trim($args['icon']), ' ') ? $args['icon'] : 'fas '.$args['icon']; ?>"></i></div>
            <?php } ?>
            <?php $required = $args['required'] ? 'required="required"' : ''; ?>
            <input <?php echo $required; ?> class="<?php echo $name; ?> wpd-field wpd-field-color" type="color" name="<?php echo $name; ?>" value="" placeholder="#ff8040"  pattern="^\#[A-Za-z0-9]{6}$" title="#ff8040">
            <?php if ($args['desc']) { ?>
                <div class="wpd-field-desc"><i class="far fa-question-circle" aria-hidden="true"></i><span><?php echo $args['desc']; ?></span></div>
                    <?php } ?>
        </div>
        <?php
    }

    public function frontHtml($value, $args) {
        if (!$args['is_show_on_comment']) {
            return '';
        }
        $html = '<div class="wpd-custom-field wpd-cf-color">';
        $html .= '<div class="wpd-cf-label">' . $args['name'] . '</div> <div class="wpd-cf-value" style="background:' . $value . ';"> ' . apply_filters('wpdiscuz_custom_field_color', $value, $args) . ' </div>';
        $html .= '</div>';
        return $html;
    }

    public function validateFieldData($fieldName, $args, $options, $currentUser) {
        if (!$this->isCommentParentZero() && !$args['is_show_sform']) {
            return '';
        }
        $value = trim(filter_input(INPUT_POST, $fieldName, FILTER_SANITIZE_STRING));
        if ($value && !preg_match('@^\#[A-Za-z0-9]{6}$@is', $value)) {
            $value = '';
        }
        if (!$value && $args['required']) {
            wp_die(__($args['name'], 'wpdiscuz') . ' : ' . __('field is required!', 'wpdiscuz'));
        }
        return $value;
    }

}
