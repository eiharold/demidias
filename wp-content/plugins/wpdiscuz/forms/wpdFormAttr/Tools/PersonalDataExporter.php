<?php

namespace wpdFormAttr\Tools;

use wpdFormAttr\FormConst\wpdFormConst;
use wpdFormAttr\Form;

class PersonalDataExporter implements wpdFormConst {

    private static $_instance = null;
    private $generalOptions;
    private $fields = array();

    private function __construct($options) {
        $this->generalOptions = $options;
        $this->initFormsFields();
        add_filter('wp_privacy_personal_data_exporters', array(&$this, 'wpdiscuzCommentsPersonalDataExport'), 13);
    }

    private function initFormsFields() {
        $forms = get_posts(array('numberposts' => -1, 'post_type' => self::WPDISCUZ_FORMS_CONTENT_TYPE));
        if ($forms) {
            foreach ($forms as $form) {
                $wpdiscuzForm = new Form($this->generalOptions, $form->ID);
                $wpdiscuzForm->initFormFields();
                $formFields = $wpdiscuzForm->getFormCustomFields();
                if ($formFields) {
                    $this->fields = array_merge($this->fields, $formFields);
                }
            }
        }
    }

    public function wpdiscuzCommentsPersonalDataExport($exporters) {
        $exporters['wpdiscuz'] = array(
            'exporter_friendly_name' => __('wpDiscuz Fields Data', 'wpdiscuz'),
            'callback' => array(&$this, 'customFieldsExport')
        );
        return $exporters;
    }

    public function customFieldsExport($email_address, $page = 1) {
        $number = 500; // Limit us to avoid timing out
        $page = (int) $page;
        $done = true;
        $export_items = array();

        $doExport = apply_filters('wpdiscuz_do_export_personal_data', false);
        
        if ($this->fields || $doExport) {
            $comments = get_comments(
                    array(
                        'author_email' => $email_address,
                        'number' => $number,
                        'paged' => $page,
                        'order_by' => 'comment_ID',
                        'order' => 'ASC',
                    )
            );


            foreach ((array) $comments as $comment) {
                $commentId = $comment->comment_ID;
                $data = array();
                $commentMeta = get_metadata('comment', $commentId);
                foreach ($this->fields as $key => $field) {
                    if (key_exists($key, $commentMeta)) {
                        $value = $this->generateFieldData($commentMeta[$key][0]);
                        if (empty($value)) {
                            continue;
                        }
                        $data[] = array(
                            'name' => $field['name'],
                            'value' => $value
                        );
                    }
                }
                $data = apply_filters('wpdiscuz_privacy_personal_data_export', $data, $commentId);
                if ($data) {
                    $export_items[] = array(
                        'group_id' => 'comments',
                        'group_label' => __('Comments'),
                        'item_id' => "comment-$commentId",
                        'data' => $data,
                    );
                }
            }
            $done = count($comments) < $number;
        }
        return array(
            'data' => $export_items,
            'done' => $done,
        );
    }

    private function generateFieldData($data) {
        $value = '';
        $data = maybe_unserialize($data);
        if (empty($data)) {
            return '';
        }
        if (is_array($data)) {
            $value = implode(', ', $data);
        } else {
            $value = $data;
        }
        return $value;
    }

    public static function getInstance($options) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }

}
