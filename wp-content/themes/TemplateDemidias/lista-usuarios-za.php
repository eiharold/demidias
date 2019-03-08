<?php
//Template Name: Lista de Usuarios ZA
?>

<?php get_header(); ?>
<section class="bg-filtros">
     <div class="filtros">
          <b>Alunos Cadastrados</b>
          <b><a class="ordemza" href="<?php echo esc_url( home_url( '/' ) ); ?>artistas">Ordem A-Z <span class="setinha">&#9662;</span></a></b>
     </div>
</section>
<div class="corpo">
<div class="autores">
<?php
     $display_admins = false;
     $order_by = 'display_name'; // 'nicename', 'email', 'url', 'registered', 'display_name', or 'post_count'
     $order = 'DESC';
     $role = ''; // 'subscriber', 'contributor', 'editor', 'author' - leave blank for 'all'
     $avatar_size = 96;
     $hide_empty = false; // hides authors with zero posts
 
     if(!empty($display_admins)) {
          $blogusers = get_users('orderby='.$order_by.'&role='.$role);
     } else {
 
     $admins = get_users('role=administrator');
     $exclude = array();
     
     foreach($admins as $ad) {
          $exclude[] = $ad->ID;
     }
 
     $exclude = implode(',', $exclude);
     $blogusers = get_users('exclude='.$exclude.'&orderby='.$order_by.'&order='.$order.'&role='.$role);
     }
 
     $authors = array();
     foreach ($blogusers as $bloguser) {
     $user = get_userdata($bloguser->ID);
 
     if(!empty($hide_empty)) {
          $numposts = count_user_posts($user->ID);
          if($numposts < 1) continue;
          }
          $authors[] = (array) $user;
     }
 
     echo '<ul id="grid-contributors">';
     foreach($authors as $author) {
          $display_name = $author['data']->display_name;
          $avatar = get_avatar($author['ID'], $avatar_size);
          $author_profile_url = get_author_posts_url($author['ID']);
          $site_do_autor = get_the_author_meta ( user_url,$author['ID'] );

 
          echo '<li class="autor">';
          echo '<center><div class="container-autor" style="height:170px;"><div class="author-gravatar"><a href="', $author_profile_url, '">', $avatar , '</a></div>';
          echo '<div class="author-name"><h4><a href="', $author_profile_url, '" class="contributor-link">', $display_name, '</a></h4></div>';
          echo '<div class="quantidade-trabalhos"><a href="', $author_profile_url, '" class="contributor-link">', count_user_posts($author['ID']), ' trabalho(s)</a></h4></div></div>';
          echo '<div class="botao-contato-autor"><a href="', $site_do_autor, '">Contato</a></div></li>';        }
          echo '</ul>';
?>
<center><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><div class="botao-voltar-home">Voltar para Home</div></a></center>
</div>
</div>
<?php get_footer(); ?>

