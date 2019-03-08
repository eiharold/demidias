<?php
$post_status_selected = isset( $form_settings['edit_post_status'] ) ? $form_settings['edit_post_status'] : 'publish';
$redirect_to          = isset( $form_settings['edit_redirect_to'] ) ? $form_settings['edit_redirect_to'] : 'same';
$update_message       = isset( $form_settings['update_message'] ) ? $form_settings['update_message'] : __( 'Post updated successfully', 'wp-user-frontend' );
$page_id              = isset( $form_settings['edit_page_id'] ) ? $form_settings['edit_page_id'] : 0;
$url                  = isset( $form_settings['edit_url'] ) ? $form_settings['edit_url'] : '';
$update_text          = isset( $form_settings['update_text'] ) ? $form_settings['update_text'] : __( 'Update', 'wp-user-frontend' );
$subscription         = isset( $form_settings['subscription'] ) ? $form_settings['subscription'] : null;
?>
<table class="form-table">

    <tr class="wpuf-post-status">
        <th><?php _e( 'Set Post Status to', 'wp-user-frontend' ); ?></th>
        <td>
            <select name="wpuf_settings[edit_post_status]">
                <?php
                $statuses = get_post_statuses();

                foreach ($statuses as $status => $label) {
                    printf('<option value="%s"%s>%s</option>', $status, selected( $post_status_selected, $status, false ), $label );
                }

                printf( '<option value="_nochange"%s>%s</option>', selected( $post_status_selected, '_nochange', false ), __( 'No Change', 'wp-user-frontend' ) );
                ?>
            </select>
        </td>
    </tr>

    <tr class="wpuf-redirect-to">
        <th><?php _e( 'Redirect To', 'wp-user-frontend' ); ?></th>
        <td>
            <select name="wpuf_settings[edit_redirect_to]">
                <?php
                $redirect_options = array(
                    'post' => __( 'Newly created post', 'wp-user-frontend' ),
                    'same' => __( 'Same Page', 'wp-user-frontend' ),
                    'page' => __( 'To a page', 'wp-user-frontend' ),
                    'url' => __( 'To a custom URL', 'wp-user-frontend' )
                );

                foreach ($redirect_options as $to => $label) {
                    printf('<option value="%s"%s>%s</option>', $to, selected( $redirect_to, $to, false ), $label );
                }
                ?>
            </select>
            <p class="description">
                <?php _e( 'After successfull submit, where the page will redirect to', $domain = 'wp-user-frontend' ) ?>
            </p>
        </td>
    </tr>

    <tr class="wpuf-same-page">
        <th><?php _e( 'Post Update Message', 'wp-user-frontend' ); ?></th>
        <td>
            <textarea rows="3" cols="40" name="wpuf_settings[update_message]"><?php echo esc_textarea( $update_message ); ?></textarea>
        </td>
    </tr>

    <tr class="wpuf-page-id">
        <th><?php _e( 'Page', 'wp-user-frontend' ); ?></th>
        <td>
            <select name="wpuf_settings[edit_page_id]">
                <?php
                $pages = get_posts(  array( 'numberposts' => -1, 'post_type' => 'page') );

                foreach ($pages as $page) {
                    printf('<option value="%s"%s>%s</option>', $page->ID, selected( $page_id, $page->ID, false ), esc_attr( $page->post_title ) );
                }
                ?>
            </select>
        </td>
    </tr>

    <tr class="wpuf-url">
        <th><?php _e( 'Custom URL', 'wp-user-frontend' ); ?></th>
        <td>
            <input type="url" name="wpuf_settings[edit_url]" value="<?php echo esc_attr( $url ); ?>">
        </td>
    </tr>

    <tr class="wpuf-subscription-pack" style="display: none;">
        <th><?php _e( 'Subscription Title', 'wp-user-frontend'); ?></th>
        <td>
            <select id="wpuf-subscription-list" name="wpuf_settings[subscription]">
                <?php $this->subscription_dropdown( $subscription ); ?>
            </select>
        </td>
    </tr>

    <tr class="wpuf-update-text">
        <th><?php _e( 'Update Post Button text', 'wp-user-frontend' ); ?></th>
        <td>
            <input type="text" name="wpuf_settings[update_text]" value="<?php echo esc_attr( $update_text ); ?>">
        </td>
    </tr>
</table>