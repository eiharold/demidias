<?php
class WPUF_pro_subscription_element extends WPUF_Subscription {

    public static function add_subscription_element( $sub_meta, $hidden_recurring_class, $hidden_trial_class, $obj ) {

        ?>
        <tr valign="top">
            <th><label><?php _e( 'Recurring', 'wpuf-pro' ); ?></label></th>
            <td>
                <label for="wpuf-recuring-pay">
                    <input type="checkbox" <?php checked( $sub_meta['recurring_pay'], 'yes' ); ?> size="20" style="" id="wpuf-recuring-pay" value="yes" name="recurring_pay" />
                    <?php _e( 'Enable Recurring Payment', 'wpuf-pro' ); ?>
                </label>
            </td>
        </tr>

        <tr valign="top" class="wpuf-recurring-child" style="display: <?php echo $hidden_recurring_class; ?>;">
            <th><label for="wpuf-billing-cycle-number"><?php _e( 'Billing cycle:', 'wpuf-pro' ); ?></label></th>
            <td>
                <select id="wpuf-billing-cycle-number" name="billing_cycle_number">
                    <?php echo $obj->lenght_type_option( $sub_meta['billing_cycle_number'] ); ?>
                </select>

                <select id="cycle_period" name="cycle_period">
                    <?php echo $obj->option_field( $sub_meta['cycle_period'] ); ?>
                </select>
                <div><span class="description"></span></div>
            </td>
        </tr>

        <tr valign="top" class="wpuf-recurring-child" style="display: <?php echo $hidden_recurring_class; ?>;">
            <th><label for="wpuf-billing-limit"><?php _e( 'Billing cycle stop', 'wpuf-pro' ); ?></label></td>
                <td>
                    <select id="wpuf-billing-limit" name="billing_limit">
                        <option value=""><?php _e( 'Never', 'wpuf-pro' ); ?></option>
                        <?php echo $obj->lenght_type_option( $sub_meta['billing_limit'] ); ?>
                    </select>
                    <div><span class="description"><?php _e( 'After how many cycles should billing stop?', 'wpuf-pro' ); ?></span></div>
                </td>
            </th>
        </tr>

        <tr valign="top" class="wpuf-recurring-child" style="display: <?php echo $hidden_recurring_class; ?>;">
            <th><label for="wpuf-trial-status"><?php _e( 'Trial', 'wpuf-pro' ); ?></label></th>
            <td>
                <label for="wpuf-trial-status">
                    <input type="checkbox" size="20" style="" id="wpuf-trial-status" <?php checked( $sub_meta['trial_status'], 'yes' ); ?> value="yes" name="trial_status" />
                    <?php _e( 'Enable trial period', 'wpuf-pro' ); ?>
                </label>
            </td>
        </tr>

        <tr class="wpuf-trial-child" style="display: <?php echo $hidden_trial_class; ?>;">
            <th><label for="wpuf-trial-duration"><?php _e( 'Trial period', 'wpuf-pro' ); ?></label></th>
            <td>
                <select id="wpuf-trial-duration" name="trial_duration">
                    <?php echo $obj->lenght_type_option( $sub_meta['trial_duration'] ); ?>
                </select>
                <select id="trial-duration-type" name="trial_duration_type">
                    <?php echo $obj->option_field( $sub_meta['trial_duration_type'] ); ?>
                </select>
                <span class="description"><?php _e( 'Define the trial period', 'wpuf-pro' ); ?></span>
            </td>
        </tr>

        <tr valign="top">
            <th><label><?php _e( 'Enable Post Number Rollback', 'wpuf-pro' ); ?></label></th>
            <td>
                <label>
                    <input type="checkbox" size="20" style="" id="wpuf-postnum-rollback" <?php checked( $sub_meta['postnum_rollback_on_delete'], 'yes' ); ?> value="yes" name="postnum_rollback_on_delete" />
                    <?php _e( 'If enabled, number of posts will be restored if the post is deleted.', 'wpuf-pro' ); ?>
                </label>
            </td>
        </tr>
    <?php

    }

    /**
     * update the meta data of subscription pack
     */
    public static function update_subcription_data( $subscription_id, $post ) {
        update_post_meta( $subscription_id, 'postnum_rollback_on_delete', ( isset( $post['postnum_rollback_on_delete'] ) ? $post['postnum_rollback_on_delete'] : '' ) );
    }

    /**
     * get subscription meta data
     */
    public static function get_subscription_metadata( $meta, $subscription_id ) {
        $meta['postnum_rollback_on_delete'] = get_post_meta( $subscription_id, 'postnum_rollback_on_delete', true );

        return $meta;
    }


    /**
     * restore number of posts allowed to post when the post is deleted
     */
    function restore_post_numbers( $post_id ) {

        global $current_user;

        $post_type = get_post_type($post_id);
        $post_to_delete = get_post( $post_id );

        if ( in_array( 'administrator', $current_user->roles ) || get_post_field( 'post_author' , $post_id ) == $current_user->ID ) {

            $user_subpack_data = get_user_meta( $post_to_delete->post_author, '_wpuf_subscription_pack', true );

            if ( isset ( $user_subpack_data['postnum_rollback_on_delete'] ) && $user_subpack_data['postnum_rollback_on_delete'] == 'yes'  ) {

                $main_subpack_data = WPUF_Subscription::get_subscription( $user_subpack_data['pack_id'] );

                if ( isset ( $main_subpack_data->meta_value['post_type_name'][ $post_type ] )
                    && isset ( $user_subpack_data['posts'][ $post_type ] )
                    &&  $user_subpack_data['posts'][ $post_type ] < $main_subpack_data->meta_value['post_type_name'][ $post_type ] ) {

                    $user_subpack_data['posts'][ $post_type ]++;
                    update_user_meta( $post_to_delete->post_author, '_wpuf_subscription_pack', $user_subpack_data );

                }
            }
        }
    }


    /**
     * @param $user_meta
     * @param $user_id
     * @param $pack_id
     * @param $recurring
     * @return mixed
     */
    public static function set_subscription_meta_to_user( $user_meta, $user_id, $pack_id, $recurring ) {

        $subscription = parent::get_subscription( $pack_id );
        $user_meta['postnum_rollback_on_delete'] = isset( $subscription->meta_value['postnum_rollback_on_delete'] ) ? $subscription->meta_value['postnum_rollback_on_delete'] : '';
        return $user_meta;
    }

}