<?php 
add_theme_support( 'post-thumbnails' );

function my_function_admin_bar(){
    return false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

wp_unique_post_slug( $slug, $post_ID, $post_status, $post_type, $post_parent );

comments_template( '', true );

function admin_default_page() {
  return 'index.php';
}

add_filter('login_redirect', 'admin_default_page');

add_filter( 'fep_menu_buttons', 'fep_cus_fep_menu_buttons', 99 );

function fep_cus_fep_menu_buttons( $menu )
{
    unset( $menu['settings'] );
    unset( $menu['new_announcement'] );
    unset( $menu['new_announcement'] );
    unset( $menu['announcements'] );
    return $menu;
}

add_filter('wp_logout','redirect_me');

function redirect_me(){
	 
	 if(current_user_can('editor')) return;
	 
	 $logout_redirect_url = home_url();
	 if(!empty($_REQUEST['redirect_to'])) wp_safe_redirect($_REQUEST['redirect_to']);
	 else wp_redirect($logout_redirect_url);
	 exit();
	}


// Contador

	function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}