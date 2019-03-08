<?php
/*
  If you would like to edit this file, copy it to your current theme's directory and edit it there.
  WPUF will always look in your theme's directory first, before using this default template.
 */
?>

<div class="login" id="wpuf-login-form">

    <?php

    $message = apply_filters( 'login_message', '' );
    if ( ! empty( $message ) ) {
        echo $message . "\n";
    }
    ?>

    <?php wpuf()->login->show_errors(); ?>
    <?php wpuf()->login->show_messages(); ?>

    <form name="loginform" class="wpuf-login-form" id="loginform" action="<?php echo $action_url; ?>" method="post">
        <p>
            <label for="wpuf-user_login"><?php _e( 'Usuário ou Email', 'wp-user-frontend' ); ?></label>
            <input type="text" name="log" id="wpuf-user_login" class="input" value="" size="20" />
        </p>
        <p>
            <label for="wpuf-user_pass"><?php _e( 'Senha', 'wp-user-frontend' ); ?></label>
            <input type="password" name="pwd" id="wpuf-user_pass" class="input" value="" size="20" />
        </p>

        <?php $recaptcha = wpuf_get_option( 'login_form_recaptcha', 'wpuf_profile', 'off'); ?>
        <?php if( $recaptcha == 'on' ) : ?>
            <p>
                <div class="wpuf-fields">
                    <?php echo recaptcha_get_html( wpuf_get_option( 'recaptcha_public', 'wpuf_general' ), true, null, is_ssl() ); ?>
                </div>
            </p>
        <?php endif; ?>

        <p class="forgetmenot">
            <input name="rememberme" type="checkbox" id="wpuf-rememberme" value="forever" />
            <label for="wpuf-rememberme"><?php esc_attr_e( 'Lembrar', 'wp-user-frontend' ); ?></label>
        </p>

        <center><p class="submit">
            <input type="submit" name="wp-submit" id="wp-submit" value="<?php esc_attr_e( 'Entrar', 'wp-user-frontend' ); ?>" />
            <input type="hidden" name="redirect_to" value="<?php echo wp_get_referer() ?>" />
            <input type="hidden" name="wpuf_login" value="true" />
            <input type="hidden" name="action" value="login" />
            <?php wp_nonce_field( 'wpuf_login_action' ); ?>
        </p>
        <p>
            <?php do_action( 'wpuf_login_form_bottom' ); ?>
        </p>
    </form>

    <?php echo wpuf()->login->get_action_links( array( 'login' => false ) ); ?>

<br><br><br>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><div class="btn-voltar">Voltar para Home</div></a></center><br>
</div>
