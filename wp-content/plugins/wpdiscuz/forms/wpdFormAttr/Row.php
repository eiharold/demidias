<?php

namespace wpdFormAttr;

use wpdFormAttr\FormConst\wpdFormConst;

class Row {

    public function dashboardForm($id, $args) {
        $defaultArgs = array(
            'column_type' => 'full',
            'row_order' => 0
        );
        $data = wp_parse_args($args, $defaultArgs);
        $columnType = $data['column_type'];
        $rowOrder = $data['row_order'];
        ?>
        <div class="wpd-form-row-wrap" id="<?php echo $id; ?>">
            <input type="hidden" name="<?php echo wpdFormConst::WPDISCUZ_META_FORMS_STRUCTURE; ?>[<?php echo $id; ?>][column_type]" class="column_type" value="<?php echo $columnType; ?>"  />
            <input type="hidden" name="<?php echo wpdFormConst::WPDISCUZ_META_FORMS_STRUCTURE; ?>[<?php echo $id; ?>][row_order]" class="row_order" value="<?php echo $rowOrder; ?>" />
            <div class="wpd-form-row-head">
                <div class="wpd-form-row-actions">
                    <i title="<?php _e('Two column', 'wpdiscuz'); ?>" class="fas fa-columns wpd-form-columns-<?php echo $columnType; ?>"></i>
                    |<i class="fas fa-trash-alt" title="<?php _e('Delete', 'wpdiscuz'); ?>"></i>
                    |<i class="fas fa-arrows-alt" aria-hidden="true" title="<?php _e('Move', 'wpdiscuz'); ?>"></i>
                </div>
            </div>
            <div class="wpd-form-row">
                <?php $this->renderRow($id, $data); ?>
            </div>
        </div>
        <?php
    }

    private function renderRow($id, $args) {
        $isTwoCol = $args['column_type'] == 'two' ? true : false;
        ?>
        <div class="wpd-form-row-body <?php echo $isTwoCol ? 'two-col' : ''; ?>">
            <?php
            if ($isTwoCol) {
                $leftData = isset($args['left']) ? $args['left'] : array();
                $rightData = isset($args['right']) ? $args['right'] : array();
                $this->renderCol($id, 'left', $leftData);
                $this->renderCol($id, 'right', $rightData);
            } else {
                $fullData = $args['full'];
                $this->renderCol($id, 'full', $fullData);
            }
            ?>
        </div>
        <?php
    }

    private function renderCol($id, $colName, $fields) {
        ?>
        <div class="wpd-form-col <?php echo $colName; ?>-col">
            <div class="col-body">
                <?php
                if ($fields) {
                    foreach ($fields as $name => $fieldData) {
                        $fieldType = $fieldData['type'];
                        $field = call_user_func($fieldType . '::getInstance');
                        $field->dashboardFormHtml($id, $colName, $name, $fieldData);
                    }
                }
                ?>
            </div>
            <div class="wpd-form-add-filed">
                <i title="<?php _e('Add Field', 'wpdiscuz'); ?>" class="fas fa-plus"></i>
            </div>
        </div>
        <?php
    }

    public function renderFrontFormRow($args, $options, $currentUser, $uniqueId, $isMainForm) {
        ?>
        <div class="wpd-form-row">
            <?php
            if ($args['column_type'] == 'two') {
                $left = $args['left'];
                $right = $args['right'];
                $this->renderFrontFormCol('left', $left, $options, $currentUser, $uniqueId, $isMainForm);
                $this->renderFrontFormCol('right', $right, $options, $currentUser, $uniqueId, $isMainForm);
            } else {
                $full = $args['full'];
                $this->renderFrontFormCol('full', $full, $options, $currentUser, $uniqueId, $isMainForm);
            }
            ?>
            <div class="clearfix"></div>
        </div>
        <?php
    }

    private function renderFrontFormCol($colName, $fields, $options, $currentUser, $uniqueId, $isMainForm) {
        ?>
        <div class="wpd-form-col-<?php echo $colName; ?>">
            <?php
            foreach ($fields as $fieldName => $fieldData) {
                $fieldType = $fieldData['type'];
                $field = call_user_func($fieldType . '::getInstance');
                $field->frontFormHtml($fieldName, $fieldData, $options, $currentUser, $uniqueId, $isMainForm);
            }
            ?>
        </div>
        <?php
    }

    public function sanitizeRowData($data, &$fields) {
        if (isset($data['full'])) {
            $data['full'] = is_array($data['full']) ? $data['full'] : array();
            $data['full'] = $this->callFieldSanitize($data['full'], $fields);
            $data['column_type'] = 'full';
        } else if (isset($data['left']) || isset($data['right'])) {
            $data['left'] = isset($data['left']) && is_array($data['left']) ? $data['left'] : array();
            $data['right'] = isset($data['right']) && is_array($data['right']) ? $data['right'] : array();
            $data['left'] = $this->callFieldSanitize($data['left'], $fields);
            $data['right'] = $this->callFieldSanitize($data['right'], $fields);
            $data['column_type'] = 'two';
        } else {
            return null;
        }
        if (isset($data['row_order'])) {
            $data['row_order'] = intval($data['row_order']);
        } else {
            $data['row_order'] = '0';
        }
        return $data;
    }

    private function callFieldSanitize($args, &$fields) {
        foreach ($args as $fieldName => $fieldData) {
            if (!isset($fieldData['type']) && !$fieldData['type']) {
                continue;
            }
            $callableClass = str_replace('\\\\', '\\', $fieldData['type']);
            if (is_callable($callableClass . '::getInstance')) {
                $field = call_user_func($callableClass . '::getInstance');
                $fieldNewName = $this->changeFieldName($fieldName, $fieldData);
                if ($fieldNewName != $fieldName) {
                    $args = $this->chageArrayKey($args, $fieldName, $fieldNewName);
                    $args[$fieldNewName] = $field->sanitizeFieldData($fieldData);
                    $fields[$fieldNewName] = $field->sanitizeFieldData($fieldData);
                } else {
                    $args[$fieldName] = $field->sanitizeFieldData($fieldData);
                    $fields[$fieldName] = $field->sanitizeFieldData($fieldData);
                }
            }
        }
        return $args;
    }

    private function changeFieldName($fieldName, $fieldData) {
        if (isset($fieldData['meta_key'])) {
            $metaKey = trim($fieldData['meta_key']);
            if ($metaKey && $fieldName != $metaKey) {
                $newName = str_replace('-', '_', sanitize_title($metaKey));
                $this->replaceMetaKeyInDB($fieldName, $newName, $fieldData);
                $this->chagePostRatingKey($fieldName, $newName, $fieldData);
                $fieldName = $newName;
            }
        }
        return $fieldName;
    }

    private function chagePostRatingKey($oldName, $newName, $fieldData) {
        if (str_replace('\\\\', '\\', $fieldData['type']) == 'wpdFormAttr\Field\RatingField' && isset($fieldData['meta_key_replace']) && $fieldData['meta_key_replace']) {
            if ($wpdiscuzRatingCount = $this->getPostRatingMeta()) {
                foreach ($wpdiscuzRatingCount as $row) {
                    $metaData = maybe_unserialize($row['meta_value']);
                    if (is_array($metaData) && key_exists($oldName, $metaData)) {
                        $metaData = $this->chageArrayKey($metaData, $oldName, $newName);
                        update_post_meta($row['post_id'], wpdFormConst::WPDISCUZ_RATING_COUNT, $metaData);
                    }
                }
            }
        }
    }

    private function replaceMetaKeyInDB($oldKey, $newKey, $fieldData) {
        global $wpdb;
        if (isset($fieldData['meta_key_replace']) && $fieldData['meta_key_replace']) {
            $sql = $wpdb->prepare("UPDATE `{$wpdb->commentmeta}` SET `meta_key` = %s WHERE `meta_key` = %s", $newKey, $oldKey);
            $wpdb->query($sql);
        }
    }

    private function getPostRatingMeta() {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT `post_id`,`meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s",wpdFormConst::WPDISCUZ_RATING_COUNT);
        return $wpdb->get_results($sql, ARRAY_A);
    }

    private function chageArrayKey($array, $oldKey, $newKey) {
        $keys = array_keys($array);
        $values = array_values($array);
        $oldKeyIndex = array_search($oldKey, $keys);
        if (is_numeric($oldKeyIndex)) {
            $keys[$oldKeyIndex] = $newKey;
            $array = array_combine($keys, $values);
        }
        return $array;
    }

}
