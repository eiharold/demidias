<?php

/**
* Generate Invoice on payments
*
* @since 2.5.6
*/
class WPUF_Pro_invoice {

    private static $_instance;

    function __construct() {
        require_once WPUF_PRO_INCLUDES . '/libs/invoicr/invoicr.php';

        add_action( 'wpuf_payment_received', array( $this, 'generate_invoice' ), 10, 2 );
        add_filter( 'wpuf_settings_sections', array( $this, 'wpuf_pro_settings_tab' ) );
        add_filter( 'wpuf_settings_fields', array( $this, 'wpuf_pro_settings_content' ) );
        // date_default_timezone_set(get_option('timezone_string'));
    }

    public static function init() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    function wpuf_pro_settings_tab ( $settings ) {

        $settings2 = array(
            array(
                'id'    => 'wpuf_payment_invoices',
                'title' => __( 'Invoices', 'wpuf' )
            )
        );

        return array_merge( $settings, $settings2);
    }

    function wpuf_pro_settings_content ( $settings_fields ) {

        $settings_fields2 = array(
            'wpuf_payment_invoices' => array(
                array(
                    'name'    => 'show_invoices',
                    'label'   => __( 'Show Invoices and Billing Address', 'wpuf-pro' ),
                    'desc'    => __( 'Show Billing Address and Invoices option in dashboard', 'wpuf-pro' ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => __( 'Yes', 'wpuf' ),
                        'no'  => __( 'No', 'wpuf' )
                    )
                ),
                array(
                    'name'     => 'set_logo',
                    'label'    => __( 'Set Invoice Logo', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the company Logo to be used in Invoice', 'wpuf-pro' ),
                    'type'     => 'file',
                    'default'  => false,
                ),
                array(
                    'name'     => 'set_color',
                    'label'    => __( 'Set Invoice Color', 'wpuf-pro' ),
                    'desc'     => __( 'Set color code to be used in invoice', 'wpuf-pro' ),
                    'type'     => 'text',
                    'default'  => '#e435226',
                ),
                array(
                    'name'       => 'set_from_address',
                    'label'    => __( 'From Address', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the payment information title of the Invoice', 'wpuf-pro' ),
                    'type'     => 'textarea',
                ),
                array(
                    'name'       => 'set_title',
                    'label'    => __( 'Invoice Title', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the payment information title of the Invoice', 'wpuf-pro' ),
                    'type'     => 'text',
                ),
                array(
                    'name'       => 'set_paragraph',
                    'label'    => __( 'Invoice Paragraph', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the payment information paragraph of the Invoice', 'wpuf-pro' ),
                    'type'     => 'textarea',
                ),
                array(
                    'name'       => 'set_footernote',
                    'label'    => __( 'Invoice Footer', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the fotter of the Invoice', 'wpuf-pro' ),
                    'type'     => 'text',
                ),
                array(
                    'name'       => 'set_filename',
                    'label'    => __( 'Invoice Filename Prefix', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the filename prefix of the Invoice', 'wpuf-pro' ),
                    'type'     => 'text',
                ),
                array(
                    'name'       => 'set_mail_sub',
                    'label'    => __( 'Set Invoice Mail Subject', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the mail subject of the Invoice', 'wpuf-pro' ),
                    'type'     => 'text',
                ),
                array(
                    'name'       => 'set_mail_body',
                    'label'    => __( 'Set Invoice Mail Body', 'wpuf-pro' ),
                    'desc'     => __( 'This sets the mail body of the Invoice', 'wpuf-pro' ),
                    'type'     => 'textarea',
                )
            )
        );

        return array_merge( $settings_fields, $settings_fields2 );
    }

    public function generate_invoice ( $data, $recurring ) {

        $show_invoice     = wpuf_get_option( 'show_invoices', 'wpuf_payment_invoices' );
        $inv_logo         = wpuf_get_option( 'set_logo', 'wpuf_payment_invoices' );
        $inv_color        = wpuf_get_option( 'set_color', 'wpuf_payment_invoices' );
        $inv_from_addr    = wpuf_get_option( 'set_from_address', 'wpuf_payment_invoices' );
        $add_fields       = get_user_meta( $data['user_id'], 'address_fields', false );
        if ( !empty( $add_fields ) ) {
            $inv_to_addr      = implode(',', $add_fields[0]);
        }
        $inv_title        = wpuf_get_option( 'set_title', 'wpuf_payment_invoices' );
        $inv_para         = wpuf_get_option( 'set_paragraph', 'wpuf_payment_invoices' );
        $inv_foot         = wpuf_get_option( 'set_footernote', 'wpuf_payment_invoices' );
        $inv_filename     = wpuf_get_option( 'set_filename', 'wpuf_payment_invoices' );
        $inv_u_id         = $data['user_id'];
        $inv_status       = $data['status'];
        $inv_cost         = $data['cost'];
        $inv_pack         = $data['pack_id'];
        $inv_u_fname      = $data['payer_first_name'];
        $inv_u_lname      = $data['payer_last_name'];
        $inv_u_email      = $data['payer_email'];
        $inv_payment_type = $data['payment_type'];
        $inv_id           = $data['transaction_id'];
        $inv_dt           = $data['created'];
        $inv_dt           = new DateTime($inv_dt);
        $inv_date         = $inv_dt->format('Y-m-d');

        $invoice = new invoicr("A4","USD","EN");

        $invoice->setNumberFormat('.',',');
        if ( !$inv_logo ) {
            $inv_logo = WPUF_PRO_INCLUDES . '/libs/invoicr/req/dummy_logo.jpg';
            $invoice->setLogo( $inv_logo, 100, 88 );
        } else {
            $invoice->setLogo( $inv_logo, 100, 88 );
        }
        $invoice->setColor($inv_color);
        $invoice->setType("Invoice");
        $invoice->setReference($inv_id);
        $invoice->setDate($inv_date);
        $invoice->setFrom(array($inv_from_addr));
        $invoice->setTo(array($inv_to_addr));
        $invoice->addItem($inv_pack,false,$inv_cost,false,$inv_cost,false,$inv_cost);
        $invoice->addTotal("Total",$inv_cost);
        $invoice->addTotal("Payment Type",$inv_payment_type);
        $invoice->addTotal("Total due",$inv_cost,true);
        $invoice->addBadge($inv_status);
        $invoice->addTitle($inv_title);
        $invoice->addParagraph($inv_para);
        $invoice->setFooternote($inv_foot);

        $inv_dir = WP_CONTENT_DIR .'/uploads/wpuf-invoices/';
        if (!file_exists( $inv_dir ) ) {
            mkdir( $inv_dir , 0777, true );
        }

        $pdf_file = $inv_dir . "{$inv_u_id}_{$inv_filename}_{$inv_id}.pdf";

        $dl_link = content_url() . '/uploads/wpuf-invoices/' . "{$inv_u_id}_{$inv_filename}_{$inv_id}.pdf";

        update_user_meta( $inv_u_id, '_invoice_link' . $inv_id, $dl_link );

        if ( $pdf_file ) {
            $invoice->render( $pdf_file, 'F');
            $this->send_invoice ( $pdf_file, $inv_u_email );

        } else {
            $invoice->render( 'invoice.pdf', 'F');
            $this->send_invoice ( 'invoice.pdf', $inv_u_email );
        }

    }

    function send_invoice ( $pdf_file, $inv_u_email ) {

        if ( !file_exists ( $pdf_file ) ) {
            return false;
        }

        $attach     = array();

        $to         = $inv_u_email;
        $subj       = 'Invoice for your payment';
        $def_body   = "Dear Subscriber,\r\nPlease, check attachment for the invoice of your transaction.";

        $text_body  = wpuf_get_option( 'set_mail_sub', 'wpuf_payment_invoices' , $sub );
        $text_body  = wpuf_get_option( 'set_mail_body', 'wpuf_payment_invoices' , $def_body );

        $headers    = array('Content-Type: text/html; charset=UTF-8');
        $headers   .= "MIME-Version: 1.0". $eol;
        $headers   .= "Content-Type: multipart/mixed; boundary=\"". $separator . "\"" . $eol;
        $headers   .= "Content-Transfer-Encoding: 7bit". $eol;

        $attach     = $pdf_file;

        wp_mail( $to, $subj, $text_body, $headers, $attach );

        //unlink( $pdf_file );

    }

}

