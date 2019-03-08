<?php
//Template Name: Liked Order
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
			<ul class="menu-filtros">
				<li>
					<div class="dropdown">
					  <button class="dropbtn">Categorias <span class="setinha">&#9662;</span></button>
					  <div class="dropdown-content">
					    <div class="categorias-esquerda">
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Todos</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/web">Web</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/fotografia">Fotografia</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/ilustracao">Ilustração</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/video">Vídeo</a>
						</div>
						<div class="categorias-direita">
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/audio">Áudio</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/animacao">Animação</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/texto">Texto</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/artigos">Artigos</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>/category/tccs">TCCs</a>
						</div>
					  </div>
					</div>
				</li>
				<li class="filtros-visiveis">
					<div class="dropdown">
					  <button class="dropbtn">Ordenar por <span class="setinha">&#9662;</span></button>
					  <div class="dropdown-content" id="ordens">
						  	<div class="ordem">
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Mais recentes</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>?order=asc">Mais antigos</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>mais-visualizados">Mais visualizados</a>
						    <a href="<?php echo esc_url( home_url( '/' ) ); ?>mais-curtidos">Mais curtidos</a>
					  </div>
					  </div>
					</div>
				</li>
				<li class="filtros-mobile">
					<div class="dropdown">
					  <button class="dropbtn">Filtros <span class="setinha">&#9662;</span></button>
					  <div class="dropdown-content" id="ordens">
						  	<div class="ordem">
						    <a href="#">Mais visualizados</a>
						    <a href="#">Mais curtidos</a>
						    <a href="#">Mais recentes</a>
						    <a href="#">Mais antigos</a>
					  </div>
					  </div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</section>

<section class="corpo">
	<div class="trabalhos are-images-unloaded" id="trabalhos">
		  <div class="grid__col-sizer"></div>
		  <div class="grid__gutter-sizer"></div>

<?php 
$the_query = new WP_Query(array(
	'post_status' => 'published',
	'post_type' => 'post',
	'orderby' => 'meta_value_num',
	'meta_key' => '_liked',
	'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
)); ?>

<?php if ( have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

	
			<div class="trabalho">
				<a href="<?php the_permalink(); ?>" rel="modal:open" id="<?php global $post; $post_slug=$post->post_name;  echo $post_slug; ?>" onclick="window.location.hash='<?php global $post; $post_slug=$post->post_name;  echo $post_slug; ?>';"><div class="thumbnail overlay"><img src="<?php the_post_thumbnail_url('thumbnailPost'); ?>"></div></a>
				<a href="<?php the_permalink(); ?>" rel="modal:open"><h3><?php the_title(); ?></h3></a>
				<a href="/autores/<?php the_author(); ?>" rel="modal:open"><h4><?php the_author(); ?></h4></a>
				<div class="info-post">
					<div class="contadores">
						<img style="display:inline-block; margin-bottom: -3px; height:18px; margin: 0 3px;" src="<?php echo get_stylesheet_directory_uri(); ?>/img/views.png">
         <?php echo getPostViews(get_the_ID()); ?>
						<?php the_content(); ?></div>
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

<?php wp_reset_postdata(); ?>

<?php else : ?>
	<center><p><?php esc_html_e( 'Não foram encontrados trabalhos com esses critérios ):' ); ?></p></center>
<?php endif; ?>

</section>

<?php get_footer(); ?>