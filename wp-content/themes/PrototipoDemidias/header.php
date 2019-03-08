<!DOCTYPE html>
<html>
<head>
	<title><?php bloginfo('name'); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
	<link href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
	<!-- Fonte Google -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
	<!-- Estilo JQuery Modal -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/jquery.modal.min.css"/>
	<!-- Estilo DEMIDIAS -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">

	
	<?php wp_head(); ?>
</head>
<body>

<header>
	<div class="bg-barra-topo">
		<div class="barra-topo">
			<div class="logo-topo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-demidias.png"></a>
			</div>
			<div class="botoes-topo">
				<?php if ( is_user_logged_in() ): ?>
					<div class="icone-usuario">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>account">
						<?php
							$user_id = get_current_user_id();
							echo get_avatar( $user_id, $size_avatar, $default_avatar );
						?>
					</a>
				</div>
				<?php endif; ?>
				<?php if ( !is_user_logged_in() ): ?>
						<div class="botao-logar-topo">
							Fazer Login
						</div>
						<iframe id="iframeLogin" scrolling="no" src="<?php echo esc_url( home_url( '/' ) ); ?>login-interno"></iframe>
				<?php endif; ?>
				<?php if ( is_user_logged_in() ): ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>submeter-trabalho">
					<div class="botao-submeter-topo">
						Submeter Trabalho
					</div>
				</a>
				<?php endif; ?>
				<div class="botao-lupa"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/lupa-mobile.jpg"></div>
				<div class="bg-pesquisar"></div>
				<div class="input-pesquisar">
					<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div>
							<input type="text" value=""  placeholder="Pesquisar" name="s" id="s" />
							<input type="submit" id="searchsubmit" value="" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-cabecalho">
		<div class="titulo-cabecalho">
			<h1><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/titulo-demidias.png"></h1>
		</div>
	</div>
	<div class="barra-preta">
	</div>
	<div class="barra-laranja">
	</div>
</header>
