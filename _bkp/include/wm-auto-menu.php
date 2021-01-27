<?php
if( !function_exists( 'wm_auto_menu' ) ){

    function wm_auto_menu( $args ) {

        global $wp;

        // see wp-includes/nav-menu-template.php for available arguments
        extract( $args );

        $link = $link_before;

        // Is the user on the home page?
        if( get_home_url() == home_url( add_query_arg( array(), $wp->request ) ) ){
            $link .= '<li class="wm-active"><span class="wm-nav-item"><a href="' . get_home_url() . '">Home</a></span></li>';
        } else {
            $link .= '<li><span class="wm-nav-item"><a href="' . get_home_url() . '">Home</a></span></li>';
        }

        $link .= '<li><span class="wm-nav-item"><a href="' . wp_login_url() . '">Login</a></span></li>';

        // Only show the warning to add a primary menu to admin users
        if ( current_user_can( 'manage_options' ) ){
            $link .= '<li><span class="wm-nav-item"><a href="' . admin_url( 'nav-menus.php' ) . '"><strong>Warning:</strong> No primary menu has been choosen for your site. Click here to add a menu.</a></span></li>';
        }

        $link .= $link_after;

        $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
        if ( !empty ( $container ) ){
            $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
        }

        if ( $echo ){
            echo $output;
        }

        return $output;
    }
}
?>
