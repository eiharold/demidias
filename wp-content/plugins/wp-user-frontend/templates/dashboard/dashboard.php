<p><?php
    global $current_user;

    printf(
        __( '<strong>Olá, %1$s!</strong><br> (Você está logado. Deseja <b><a href="%2$s">deslogar</a></b>?)<br><br>', 'wp-user-frontend' ),
         esc_html( $current_user->display_name ),
        esc_url( wp_logout_url( get_permalink() ) )
    );
?></p>

<p><?php
    printf(
        __( 'Através do Painel de Controle, você pode gerenciar seus <a href="%1$s">trabalhos publicados</a> <br> e <a href="%3$s">editar sua senha e perfil</a>.', 'wp-user-frontend' ),
        esc_url( add_query_arg( array( 'section' => 'posts' ), get_permalink() ) ),
        esc_url( add_query_arg( array( 'section' => 'subscription' ), get_permalink() ) ),
        esc_url( add_query_arg( array( 'section' => 'edit-profile' ), get_permalink() ) )
    );
?></p>

<br><br>
<center><b><a class="botao-pm" href="<?php echo esc_url( home_url( '/' ) ); ?>">Página inicial</a></b><br><br><br></center>