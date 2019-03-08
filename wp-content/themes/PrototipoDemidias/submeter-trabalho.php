<?php
//Template Name: Submeter Trabalho
?>

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


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div class="titulo-single">
        <center><h2>Publicar trabalho</h2></center><br>
    </div>

    <div class="esconder-contadores"><?php the_content(); ?></div>

<?php endwhile; else : ?>
    <p><?php esc_html_e( 'Não foram encontrados trabalhos com esses critérios ):' ); ?></p>
<?php endif; ?>


<?php wp_footer(); ?>

</body>
</html>