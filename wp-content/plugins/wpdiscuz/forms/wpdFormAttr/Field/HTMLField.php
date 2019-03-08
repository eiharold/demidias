<?php

namespace wpdFormAttr\Field;

class HTMLField extends Field {

    protected function dashboardForm() {
        ?>
        <div class="wpd-field-body" style="display: <?php echo $this->display; ?>">
            <div class="wpd-field-option wpdiscuz-item">
                <input class="wpd-field-type" type="hidden" value="<?php echo $this->type; ?>" name="<?php echo $this->fieldInputName; ?>[type]" />
                <label><?php _e('Name', 'wpdiscuz'); ?>:</label> 
                <input class="wpd-field-name" type="text" value="<?php echo $this->fieldData['name']; ?>" name="<?php echo $this->fieldInputName; ?>[name]" required />
            </div>
            <div class="wpd-field-option wpdiscuz-item">
                <?php $value = isset($this->fieldData['value']) ? $this->fieldData['value'] : ''; ?>
                <label for="wpd-field-value"><?php _e('HTML Code', 'wpdiscuz'); ?>:</label> 
                <textarea id="wpd-field-value" required name="<?php echo $this->fieldInputName; ?>[value]" ><?php echo $value; ?></textarea>
            </div>
            <div class="wpd-field-option">
                <label for="wpd-field-is-show-sform"><?php _e('Display on reply form', 'wpdiscuz'); ?>:</label> 
                <input id="wpd-field-is-show-sform" type="checkbox" value="1" <?php checked($this->fieldData['is_show_sform'], 1, true); ?> name="<?php echo $this->fieldInputName; ?>[is_show_sform]" />
            </div>
            <div style="clear:both;"></div>
        </div>
        <?php
    }

    public function frontFormHtml($name, $args, $options, $currentUser, $uniqueId, $isMainForm) {
        if (!$isMainForm && !$args['is_show_sform'])
            return;
        echo $args['value'];
    }

    public function sanitizeFieldData($data) {
        $cleanData = array();
        $cleanData['type'] = $data['type'];
        if (isset($data['name'])) {
            $name = trim(strip_tags($data['name']));
            $cleanData['name'] = $name ? $name : $this->fieldDefaultData['name'];
        }
        if (isset($data['value'])) {
            $cleanData['value'] = trim($data['value']);
        }
        return wp_parse_args($cleanData, $this->fieldDefaultData);
    }

    protected function initDefaultData() {
        $this->fieldDefaultData = array(
            'name' => '',
            'desc' => '',
            'value' => '',
            'required' => '0',
            'loc' => 'top',
            'is_show_on_comment' => '0',
            'is_show_sform' => '1',
            'no_insert_meta' => '1'
        );
    }

    public function editCommentHtml($key, $value, $data, $comment) {
        
    }

    public function frontHtml($value, $args) {
        
    }

    public function validateFieldData($fieldName, $args, $options, $currentUser) {
        
    }

}
