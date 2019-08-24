<?php
function wpd_core(){


            //echo get_locale();
            load_plugin_textdomain( 'wpdlang', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages/' );
            //echo dirname( plugin_basename( __FILE__ ) ) . '/../languages/';
            //die;
            $wpdadmin = wpdadmin_network();
    
            $GLOBALS['wpdadmin'] = $wpdadmin;
    
            add_action('admin_enqueue_scripts', 'wpd_scripts', 1);
         
            global $pagenow;
            if($pagenow == "index.php"){
                add_action("admin_enqueue_scripts","wpdwid_init_scripts");
            }
            add_action("wp_enqueue_scripts","wpdwid_init_scripts_frontend");

            add_action('admin_init', 'wpd_load_dashboard_widgets', 1);         

            add_action('admin_enqueue_scripts', 'wpd_admin_css', 99);

}


function wpdadmin_network(){

        if(is_multisite() && wpd_network_active()){

                    global $blog_id;
                    $current_blog_id = $blog_id;
                    switch_to_blog(1);
                    $site_specific_wpdadmin = get_option("wpdids_options");
                    $wpdadmin = $site_specific_wpdadmin;
                    switch_to_blog($current_blog_id);
                    //echo "hello";
        } else {
            $wpdadmin = wpd_get_option("wpdids_options","");
        }

    //print_r($wpdadmin);

    if(isset($wpdadmin['dashboard-widget-colors'])){
        $exp = explode(",", $wpdadmin['dashboard-widget-colors']);
        $wpdadmin['dashboard-widget-colors'] = array_unique(array_filter($exp));
    }


        return $wpdadmin;
}



function wpd_scripts(){
   // global $wpdadmin;

    global $wp_version;
    $plug = trim(get_current_screen()->id);
    // echo "<div style='float:right;'>".$plug."</div>"; 

    if (isset($plug) && $plug == "dashboard"){
        $url = plugins_url('/', __FILE__).'../js/echarts-all.js';
        wp_deregister_script('wpd-echarts-js');
        wp_register_script('wpd-echarts-js', $url);
        wp_enqueue_script('wpd-echarts-js','jquery');

    }

        wp_localize_script('wpd-scripts-js', 'wpd_vars', array(
            'wpd_nonce' => wp_create_nonce('wpd-nonce')
                )
        );

}


function wpd_admin_css()
{
    /*

    $url = plugins_url('/', __FILE__).'../css/wpd-admin.min.css';
    wp_deregister_style('wpd-admin', $url);
    wp_register_style('wpd-admin', $url);
    wp_enqueue_style('wpd-admin');

    */
}



function wpd_multisite_allsites(){

    $arr = array();
                        //echo "<pre>";
                        // get all blogs
                        $blogs = get_sites();
                          // print_r($blogs);
                        //echo "</pre>";
                       //die();

                        if ( 0 < count( $blogs ) ) :
                            foreach( $blogs as $blog ) : 
                                $getblogid = $blog -> blog_id;
                               // echo "id:". $getblogid;
                            //die();
                                switch_to_blog( $getblogid );

                                if ( get_theme_mod( 'show_in_home', 'on' ) !== 'on' ) {
                                    continue;
                                }

                                $blog_details = get_blog_details( $getblogid );
                                //print_r($blog_details);
                                
                                //echo "<div style='height:200px; overflow:auto;width:100%;'>"; print_r(get_blog_option( $getblogid, 'wpd_demo' )); echo "</div>";

                                $id = $getblogid;
                                $name = $blog_details->blogname;
                                $arr[$id] = $name;

                            endforeach;
                        endif;

                        return $arr;
}


function wpd_network_active(){

        if ( ! function_exists( 'is_plugin_active_for_network' ) ){
            require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        }

        // Makes sure the plugin is defined before trying to use it
            if ( is_plugin_active_for_network( 'graphical_dashboard_widgets/wpd-core.php' )){
                return true;
            }

            return false;
}


function wpd_add_option($variable,$default){
    if(wpd_network_active()){
        add_site_option($variable,$default);
    } else {
        add_option($variable,$default);
    }
}

function wpd_get_option($variable,$default){
    if(wpd_network_active()){
        //echo "networkactive";
        return get_site_option($variable,$default);
    } else {
        //echo "individualactive";
        return get_option($variable,$default);
    }
}

function wpd_update_option($variable,$default){
    if(wpd_network_active()){
        update_site_option($variable,$default);
    } else {
        update_option($variable,$default);
    }
}

function wpd_load_dashboard_widgets(){

    //$wpdadmin = wpdadmin_network();   
    global $wpdadmin;
    //echo "<pre>"; print_r($wpdadmin); echo "</pre>"; die;

    $element = "dashboard-widgets";

    $widgetid = "wpd_visitors_type";
    if( isset($wpdadmin[$element][$widgetid]) && $wpdadmin[$element][$widgetid] == $widgetid){
    add_action( 'wp_dashboard_setup', $widgetid );
    }

    $widgetid = "wpd_browser_type";
    if( isset($wpdadmin[$element][$widgetid]) && $wpdadmin[$element][$widgetid] == $widgetid){
    add_action( 'wp_dashboard_setup', $widgetid );
    }

    $widgetid = "wpd_platform_type";
    if( isset($wpdadmin[$element][$widgetid]) && $wpdadmin[$element][$widgetid] == $widgetid){
    add_action( 'wp_dashboard_setup', $widgetid );
    }

    $widgetid = "wpd_country_type";
    if( isset($wpdadmin[$element][$widgetid]) && $wpdadmin[$element][$widgetid] == $widgetid){
    add_action( 'wp_dashboard_setup', $widgetid );
    }

    $widgetid = "wpd_commentstats_add_dashboard";
    if( isset($wpdadmin[$element][$widgetid]) && $wpdadmin[$element][$widgetid] == $widgetid){
    add_action( 'wp_dashboard_setup', $widgetid );
    }

    $widgetid = "wpd_poststats_add_dashboard";
    if( isset($wpdadmin[$element][$widgetid]) && $wpdadmin[$element][$widgetid] == $widgetid){
    add_action( 'wp_dashboard_setup', $widgetid );
    }

    $element = "dashboard-default-widgets";

    $widgetid = "welcome_panel";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_action( 'welcome_panel', 'wp_welcome_panel' );
    }

    $widgetid = "dashboard_primary";
    
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    }

    $widgetid = "dashboard_quick_press";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    }

    $widgetid = "dashboard_recent_drafts";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    }

    $widgetid = "dashboard_recent_comments";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    }

    $widgetid = "dashboard_right_now";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    }

    $widgetid = "dashboard_activity";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
    }

    $widgetid = "dashboard_incoming_links";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    }

    $widgetid = "dashboard_plugins";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    }

    $widgetid = "dashboard_secondary";
    if( !isset($wpdadmin[$element][$widgetid])){
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    }


}



function wpd_dashboard_widget_color(){

    //$wpdadmin = wpdadmin_network();
    global $wpdadmin;
   
    $blue_colors = array();
    $blue_colors[0] = "#7986CB";
    $blue_colors[1] = "#4dd0e1";
    $blue_colors[2] = "#9575CD";
    $blue_colors[3] = "#4FC3F7";
    $blue_colors[4] = "#64B5F6";
    $blue_colors[5] = "#4DB6AC";

    $red_colors = array();
    $red_colors[0] = "#E57373";
    $red_colors[1] = "#FFD54F";
    $red_colors[2] = "#F06292";
    $red_colors[3] = "#FFB74D";
    $red_colors[4] = "#FF8A65";
    $red_colors[5] = "#FFF176";

    $green_colors = array();
    $green_colors[0] = "#81C784";
    $green_colors[1] = "#DCE775";
    $green_colors[2] = "#AED581";
    $green_colors[3] = "#9CCC65";
    $green_colors[4] = "#00E676";
    $green_colors[5] = "#C0CA33";

    $getcolor = array();
    if(isset($wpdadmin['dashboard-widget-colors']) && sizeof($wpdadmin['dashboard-widget-colors']) > 5){
        $getcolor = $wpdadmin['dashboard-widget-colors'];
        //print_r($getcolor);
    } else {
        $getcolor = $blue_colors;
    }

   // print_r($getcolor);

    return $getcolor;

}
/*
if(!function_exists(print_pre)){
function print_pre($arr){
    echo "<pre>"; print_r($arr); echo "</pre>";
}
    
}*/

?>