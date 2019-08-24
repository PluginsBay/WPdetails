<?php
function wpd_admin_activation() {
    
    global $wpdb;
    //add_option("wpd_admin_version", "1.0");
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wpdwid"
                 ."( UNIQUE KEY id (id),
          id int(100) NOT NULL AUTO_INCREMENT,
          session_id  VARCHAR( 255 )  NOT NULL,
          knp_date  DATE NOT NULL,
          knp_time  TIME NOT NULL,
          knp_ts  VARCHAR (50) NOT NULL,
          duration  TIME NOT NULL,
          userid  VARCHAR( 50 ) NOT NULL,
          event VARCHAR( 50 ) NOT NULL,
          browser VARCHAR( 50 ) NOT NULL,
          platform  VARCHAR( 50 ) NOT NULL,
          ip  VARCHAR( 20 ) NOT NULL,
          city  VARCHAR( 50 ) NOT NULL,
          region  VARCHAR( 50 ) NOT NULL,
          countryName VARCHAR( 50 ) NOT NULL,
          url_id  VARCHAR( 255 )  NOT NULL,
          url_term  VARCHAR( 255 )  NOT NULL,
          referer_doamin  VARCHAR( 255 )  NOT NULL,
          referer_url TEXT NOT NULL,
          screensize  VARCHAR( 50 ) NOT NULL,
          isunique  VARCHAR( 50 ) NOT NULL,
          landing VARCHAR( 10 ) NOT NULL

          )";
    //$wpdb->query($sql);
//  $wpdb->query($req);
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);

    
        $sql2 = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wpdwid_online"
                 ."( UNIQUE KEY id (id),
          id int(100) NOT NULL AUTO_INCREMENT,
          session_id VARCHAR( 255 ) NOT NULL,
          knp_time  DATETIME NOT NULL,
          knp_ts  VARCHAR (50) NOT NULL,
          userid  VARCHAR( 50 ) NOT NULL,
          url_id  VARCHAR( 255 )  NOT NULL,
          url_term  VARCHAR( 255 )  NOT NULL,
          city  VARCHAR( 50 ) NOT NULL,
          region  VARCHAR( 50 ) NOT NULL,
          countryName VARCHAR( 50 ) NOT NULL,
          browser VARCHAR( 50 ) NOT NULL,
          platform  VARCHAR( 50 ) NOT NULL,
          referer_doamin  VARCHAR( 255 )  NOT NULL,
          referer_url TEXT NOT NULL
          )";
    //$wpdb->query($sql2);
    dbDelta($sql2);
    


    //echo "<pre>"; 
    $settingsapi = new WPd_Settings_API_Test;
    $fields = $settingsapi->get_settings_fields();
    //print_r($fields);
    $arr = array();
    foreach ($fields['wpdids_options'] as $key => $value) {
        $arr[$value['name']] = $value['default'];
    }
    //print_r($arr);
    add_option( 'wpdids_options', '');
    update_option("wpdids_options",$arr);
    //die;
    //echo "</pre>";


}
function wpd_admin_deactivation() {

	delete_option( "wpdadmin_plugin_access");
	delete_option( "wpdadmin_plugin_page");
	delete_option( "wpdadmin_plugin_userid");
	delete_option( "wpdadmin_menumng_page");
	delete_option( "wpdadmin_admin_menumng_page");
	delete_option( "wpdadmin_admintheme_page");
	delete_option( "wpdadmin_logintheme_page");
	delete_option( "wpdadmin_master_theme");

       delete_option("wpdadmin_menuorder");
       delete_option("wpdadmin_submenuorder");
       delete_option("wpdadmin_menurename");
       delete_option("wpdadmin_submenurename");
       delete_option("wpdadmin_menudisable");
       delete_option("wpdadmin_submenudisable");


  delete_site_option( "wpdadmin_plugin_access");
  delete_site_option( "wpdadmin_plugin_page");
  delete_site_option( "wpdadmin_plugin_userid");
  delete_site_option( "wpdadmin_menumng_page");
  delete_site_option( "wpdadmin_admin_menumng_page");
  delete_site_option( "wpdadmin_admintheme_page");
  delete_site_option( "wpdadmin_logintheme_page");
  delete_site_option( "wpdadmin_master_theme");

       delete_site_option("wpdadmin_menuorder");
       delete_site_option("wpdadmin_submenuorder");
       delete_site_option("wpdadmin_menurename");
       delete_site_option("wpdadmin_submenurename");
       delete_site_option("wpdadmin_menudisable");
       delete_site_option("wpdadmin_submenudisable");

/*
       delete_option("wpdadmin_menuorder");
       delete_option("wpdadmin_submenuorder");
       delete_option("wpdadmin_menurename");
       delete_option("wpdadmin_submenurename");
       delete_option("wpdadmin_menudisable");
       delete_option("wpdadmin_submenudisable");
*/



    /* 	
      delete_option('wpd_admin_version');
     */
}

?>