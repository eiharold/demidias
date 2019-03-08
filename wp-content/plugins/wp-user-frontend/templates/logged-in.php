<style>
body {background: #1f1f1f;}
a {color: #ce6b01;}
</style>
<center>
	<div class="wpuf-user-loggedin">

		<span class="wpuf-user-avatar">
			<?php echo get_avatar( $user->ID ); ?>
		</span>

	    <br>
	    <h3 style="color: #fff;"> <?php printf( __( 'Olá, %s!', 'wp-user-frontend' ), $user->display_name ); ?> </h3>

	    <?php printf( __( 'Você está logado. %s?', 'wp-user-frontend' ), wp_loginout( '', false ) ) ?>

	    <a href="<?php echo esc_url( home_url( '/' ) ); ?>account"><div class="botao-painel">Painel de Controle</div></a>
	</div>
</center>
