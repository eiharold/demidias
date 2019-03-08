<?php
//Template Name: Pagina Vazia
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php the_content(); ?>

<?php endwhile; else : ?>
    <p><?php esc_html_e( 'Não foram encontrados resultados com esses critérios ):' ); ?></p>
<?php endif; ?>


<?php get_footer(); ?>