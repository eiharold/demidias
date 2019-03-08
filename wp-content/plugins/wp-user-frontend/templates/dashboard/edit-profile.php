<?php

global $current_user;
ob_start();

?>

<?php echo do_shortcode('[wpuf_profile type="profile" id="415"]'); ?>

<?php
    $output = ob_get_clean();

    echo apply_filters( 'wpuf_account_edit_profile_content', $output );
?>