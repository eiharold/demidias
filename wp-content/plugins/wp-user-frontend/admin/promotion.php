<?php

/**
 * Promotional offer class
 */
class WPUF_Admin_Promotion {

    public function __construct() {
        add_action( 'admin_notices', array( $this, 'promotional_offer' ) );
        add_action( 'wp_ajax_wpuf-dismiss-promotional-offer-notice', array( $this, 'dismiss_promotional_offer' ) );
    }

    /**
     * Promotional offer notice
     *
     * @since 1.1.15
     *
     * @return void
     */
    public function promotional_offer() {
        // Show only to Admins
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // 2018-03-26 23:59:00
        if ( time() > 1522108740 ) {
            return;
        }

        // check if it has already been dismissed
        $hide_notice = get_option( 'wpuf_promotional_offer_notice', 'no' );

        if ( 'hide' == $hide_notice ) {
            return;
        }

        // $product_text = (  wpuf()->is_pro() ) ? __( 'Pro upgrade and all extensions, ', 'wpuf' ) : __( 'all extensions, ', 'wpuf' );

        // $offer_msg  = __( '<h2><span class="dashicons dashicons-awards"></span> weDevs 5th Birthday Offer</h2>', 'wpuf' );
        $offer_msg = sprintf( __( '<p>
                                        <strong class="highlight-text" style="font-size: 18px">It’s Our Birthday <span class="wpuf-cake" style="font-size: 20px"> &#x1F382;</span>
                                        But You Get The Present <span class="wpuf-gift" style="font-size: 20px"> &#x1F381;</span> </strong><br>
                                        Get 25&#37; Discount with coupon:
                                        <a target="_blank" href="%1$s"><strong> we25 </strong></a>
                                        <br>
                                        Offer ending soon!
                                    </p>', 'wp-user-frontend' ), 'https://wedevs.com/in/get-25-off' );

        ?>
            <div class="notice is-dismissible" id="wpuf-promotional-offer-notice">
                <table>
                    <tbody>
                        <tr>
                            <td class="image-container">
                                <img src="https://ps.w.org/wp-user-frontend/assets/icon-256x256.png" alt="">
                            </td>
                            <td class="message-container">
                                <?php echo $offer_msg; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <span class="dashicons dashicons-megaphone"></span>
                <a href="https://wedevs.com/in/get-25-off" class="button button-primary promo-btn" target="_blank"><?php _e( 'Get the Offer', 'wp-user-frontend' ); ?></a>
            </div><!-- #wpuf-promotional-offer-notice -->

            <style>
                #wpuf-promotional-offer-notice {
                    background-color: #4caf50;
                    border: 0px;
                    padding: 0;
                    opacity: 0;
                }

                .wrap > #wpuf-promotional-offer-notice {
                    opacity: 1;
                }

                #wpuf-promotional-offer-notice table {
                    border-collapse: collapse;
                    width: 100%;
                }

                #wpuf-promotional-offer-notice table td {
                    padding: 0;
                }

                #wpuf-promotional-offer-notice table td.image-container {
                    background-color: #fff;
                    vertical-align: middle;
                    width: 95px;
                }


                #wpuf-promotional-offer-notice img {
                    max-width: 100%;
                    max-height: 100px;
                    vertical-align: middle;
                }

                #wpuf-promotional-offer-notice table td.message-container {
                    padding: 0 10px;
                }

                #wpuf-promotional-offer-notice h2{
                    color: rgba(250, 250, 250, 0.77);
                    margin-bottom: 10px;
                    font-weight: normal;
                    margin: 16px 0 14px;
                    -webkit-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -moz-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -o-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                }


                #wpuf-promotional-offer-notice h2 span {
                    position: relative;
                    top: 0;
                }

                #wpuf-promotional-offer-notice p{
                    color: rgba(250, 250, 250, 0.77);
                    font-size: 14px;
                    margin-bottom: 10px;
                    -webkit-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -moz-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    -o-text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                    text-shadow: 0.1px 0.1px 0px rgba(250, 250, 250, 0.24);
                }

                #wpuf-promotional-offer-notice p strong.highlight-text{
                    color: #fff;
                }

                #wpuf-promotional-offer-notice p a {
                    color: #fafafa;
                }

                #wpuf-promotional-offer-notice .notice-dismiss:before {
                    color: #fff;
                }

                #wpuf-promotional-offer-notice span.dashicons-megaphone {
                    position: absolute;
                    bottom: 46px;
                    right: 248px;
                    color: rgba(253, 253, 253, 0.29);
                    font-size: 96px;
                    transform: rotate(-21deg);
                }

                #wpuf-promotional-offer-notice a.promo-btn{
                    background: #fff;
                    border-color: #fafafa #fafafa #fafafa;
                    box-shadow: 0 1px 0 #fafafa;
                    color: #4caf4f;
                    text-decoration: none;
                    text-shadow: none;
                    position: absolute;
                    top: 30px;
                    right: 26px;
                    height: 40px;
                    line-height: 40px;
                    width: 130px;
                    text-align: center;
                    font-weight: 600;
                }

            </style>

            <script type='text/javascript'>
                jQuery('body').on('click', '#wpuf-promotional-offer-notice .notice-dismiss', function(e) {
                    e.preventDefault();

                    wp.ajax.post('wpuf-dismiss-promotional-offer-notice', {
                        dismissed: true
                    });
                });
            </script>
        <?php
    }


   /**
    * Dismiss promotion notice
    *
    * @since  2.5
    *
    * @return void
    */
   public function dismiss_promotional_offer() {
        if ( ! empty( $_POST['dismissed'] ) ) {
            $offer_key = 'wpuf_promotional_offer_notice';
            update_option( $offer_key, 'hide' );
        }
    }
}
