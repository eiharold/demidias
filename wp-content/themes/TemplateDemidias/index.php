<?php
//Template Name: Trabalhos
?>

<?php get_header(); ?>

<section class="bg-filtros">
	<div class="filtros">
		<div class="procurar-artista">
			<p class="texto-artista">Procurando por um artista específico?</p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>artistas"><div class="botao-artista">Encontre aqui</div></a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>artistas"><div class="botao-artista-mobile">Procurar artista</div></a>
		</div>
		<div class="area-filtros">
			<div class="menu-filtros">
					<div class="dropbtn cat">Categorias <span class="setinha">&#9662;</span></div>
			</div>
		</div></div>
	<div class="menu-oculto">
		<div class="menu-de-categorias">
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-globe"></i>Todos</a>
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/fotografia"><i class="fas fa-camera"></i>Fotografia</a>
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/ilustracao"><i class="fas fa-pencil-alt"></i>Ilustração</a>
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/video"><i class="fas fa-video"></i>Vídeo</a>
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/jogos">
						    <i class="fas fa-gamepad"></i>Jogos</a>
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/editoracao"><i class="fas fa-newspaper"></i></i>Editoração</a>
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/aplicativo"><i class="fas fa-tablet-alt"></i></i></i>Aplicativo</a>
						    <a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/web"><i class="far fa-window-restore"></i>Web</a>
						
						    <a class="categorias-baixo" href="<?php echo esc_url( home_url( '/' ) ); ?>category/audio"><i class="fas fa-headphones"></i>Áudio</a>
						    <a class="categorias-baixo" href="<?php echo esc_url( home_url( '/' ) ); ?>category/animacao"><i class="fas fa-dice"></i>Animação</a>
							<a class="categorias-baixo" href="<?php echo esc_url( home_url( '/' ) ); ?>/category/3d"><i class="fas fa-cubes"></i>3D</a>
							<a class="categorias-baixo" href="<?php echo esc_url( home_url( '/' ) ); ?>category/roteiro"><i class="fas fa-align-justify"></i></i>Roteiro</a>
							<a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/marketing"><i class="fas fa-chart-line"></i></i></i>Marketing</a>
							<a class="categorias-cima" href="<?php echo esc_url( home_url( '/' ) ); ?>category/infografia"><i class="fas fa-chart-area"></i></i>Infografia</a>
						    <a class="categorias-baixo" href="<?php echo esc_url( home_url( '/' ) ); ?>category/artigos"><i class="fas fa-font"></i>Artigos</a>
						    <a class="categorias-baixo" href="<?php echo esc_url( home_url( '/' ) ); ?>category/tccs"><i class="fas fa-file-alt"></i>TCCs</a>
	</div><br></div>
</section>

<section class="corpo">
	<div class="trabalhos are-images-unloaded" id="trabalhos">
		  <div class="grid__col-sizer"></div>
		  <div class="grid__gutter-sizer"></div>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


			<div class="trabalho">
				<a href="<?php the_permalink(); ?>" rel="modal:open" id="<?php global $post; $post_slug=$post->post_name;  echo $post_slug; ?>" onclick="window.location.hash='<?php global $post; $post_slug=$post->post_name;  echo $post_slug; ?>';"><div class="thumbnail overlay"><img src="<?php the_post_thumbnail_url('thumbnailPost'); ?>"></div></a>
				<a href="<?php the_permalink(); ?>" rel="modal:open"><h3><?php the_title(); ?></h3></a>
				<a href="/author/<?php the_author_meta(user_nicename); ?>"><h4><?php the_author(); ?></h4></a>
				<div class="info-post">
					<div class="contadores">
						<img style="display:inline-block; margin-bottom: -3px; height:18px; margin: 0 3px;" src="<?php echo get_stylesheet_directory_uri(); ?>/img/views.png">
         <?php echo getPostViews(get_the_ID()); ?>
						 &nbsp;&nbsp;<?php the_content(); ?></div>
					<div class="taxonomias"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/etiqueta-categoria.png"><a href="#4"><?php the_category( ', ' ); ?></a></div>
				</div>
			</div>

<?php endwhile; ?>

		</div>
		<div class="page-load-status">
	  <div class="loader-ellips infinite-scroll-request">
	    <span class="loader-ellips__dot"></span>
	    <span class="loader-ellips__dot"></span>
	    <span class="loader-ellips__dot"></span>
	    <span class="loader-ellips__dot"></span>
	  </div>
	  <p class="infinite-scroll-last">Fim dos trabalhos</p><br>
	  <p class="infinite-scroll-error">Não existem mais páginas a serem carregadas</p>
	</div>


	</div>
		<center>

			<nav class="navegacao"><?php echo paginate_links( $args ); ?></nav>

		</center><br>

<?php else : ?>
	<center><p><?php esc_html_e( 'Não foram encontrados resultados com esses critérios ):' ); ?></p></center>
<?php endif; ?>

</section>

<?php get_footer(); ?>