	
	<?php wp_head(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>

	<div class="titulo-single">
			<h2><?php the_title(); ?></h2>
		<p class="autoria-trabalho">Feito por <a href="<?php echo esc_url( home_url( '/' ) ); ?>author/<?php the_author_meta(user_nicename); ?>"><?php the_author(); ?></a> em <?php the_time('j \d\e F \d\e Y') ?></a></p>
	</div>
<div class="janela-de-trabalhos">
	<div class="coluna-job">
		<center><div class="espaco-thumb-video">
		<?php 
		$link_audiovisual = get_post_meta( $post->ID, 'link_de_video', true );
		if (empty($link_audiovisual)) {
		echo '<center><img src="', the_post_thumbnail_url('thumbnailPost'), '"></center>';
			} else {
		echo wp_oembed_get( $link_audiovisual, $args );
			} ?>
		</div></center>
		<div class="descricao-do-trab"><?php the_excerpt(); ?>
	</div>
		<hr><p> <?php comments_template() ?>
		 </p>
	</div>
	<div class="coluna-infos">
		<div class="estatisticas-post">
			<br><div class="contadores-single">
				<img style="display:inline-block; margin-bottom: -3px; height:18px; margin: 0 3px" src="<?php echo get_stylesheet_directory_uri(); ?>/img/views.png">
         <?php echo getPostViews(get_the_ID()); ?>
				&nbsp;&nbsp;<?php the_content(); ?><br><br></div>
			<div><?php
          	setPostViews(get_the_ID());
				?>
				</div>
		</div><br><div class="estatisticas-post">
			<div class="taxonomias"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/etiqueta-categoria.png"><a href="#4"><?php the_category( ', ' ); ?></a></div>
				<div class="softwares-utilizados"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/etiqueta-softwares.png"> <?php echo get_post_meta( $post->ID, 'softwares_utilizados', true ); ?></div>
		</div>
		<div class="autoria">
			<center>
				<?php
					$user_id = get_the_author_meta( ID );
					echo get_avatar( $user_id, $size_avatar, $default_avatar );
				?>
			</center>
			<h4><?php the_author(); ?></h4>
			<div class="descricao-autor"><?php the_author_meta( description ); ?> </div>
			<div><?php echo do_shortcode('[wpuf-meta name="instagram"]'); ?></div>
			<br>
			<center><a href="<?php the_author_meta( user_url ); ?>"><div class="estilo-botao-padrao" style="max-width: 120px; text-align: center;">Contato</div></a><br></center>
		</div>
		<hr><br>
		<div class="mais-do-autor">
			<center><b>Mais de <?php the_author(); ?></b></center><br>
		</div>
		<div class="mais-trabalhos-do-autor">
			<?php 
				$author = get_the_author_meta('ID');
				$postID = get_the_ID();
			   // the query
			   $the_query = new WP_Query( array(
			   	  'author' => $author,
			      'posts_per_page' => 3,
			      'post__not_in' => array($postID),
			   )); 
			?>

			<?php if ( $the_query->have_posts() ) : ?>
			  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			  	<a href="<?php echo esc_url( home_url( '/' ) ); ?>author/<?php the_author_meta(user_nicename); ?>">
			  		<div class="unidade-trabalho-autor">
			    <center><img style="max-width: 100%; border-radius: 4px;" src="<?php the_post_thumbnail_url('thumbnailPost'); ?>">
			    <br><b style="color: #333"><?php the_title(); ?></b>
				</div></a></center><br>
			  <?php endwhile; ?>
			  <?php wp_reset_postdata(); ?>

			<?php else : ?>
			<?php endif; ?>

		</div>

<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Não foram encontrados resultados com esses critérios ):' ); ?></p>
<?php endif; ?>

</div>

<?php wp_footer(); ?>
