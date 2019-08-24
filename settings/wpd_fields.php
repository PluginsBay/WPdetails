<?php
if ( !class_exists('WPd_Settings_API_Test' ) ):
class WPd_Settings_API_Test {
    private $settings_api;
    function __construct() {
        $this->settings_api = new WPd_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }
    function admin_init() {
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );
        $this->settings_api->admin_init();
    }
    function admin_menu() {
       }
    function get_settings_sections() {
        $sections = array(
            /*array(
                'id'    => 'wpdids_basics',
                'title' => __( 'Basic Settings', 'wpdlang' )
            ),*/
            array(
                'id'    => 'wpdids_options',
                'title' => __( 'Advanced Settings', 'wpdlang' )
            )
        );
        return $sections;
    }
    function get_settings_fields() {
        $settings_fields = array(
            /*'wpdids_basics' => array(
                
            ),*/
            'wpdids_options' => array(
                /*array(
                    'name'              => 'text_val',
                    'label'             => __( 'Text Input', 'wpdlang' ),
                    'desc'              => __( 'Text input description', 'wpdlang' ),
                    'placeholder'       => __( 'Text Input placeholder', 'wpdlang' ),
                    'type'              => 'text',
                    'default'           => 'Title',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'              => 'number_input',
                    'label'             => __( 'Number Input', 'wpdlang' ),
                    'desc'              => __( 'Number field with validation callback `floatval`', 'wpdlang' ),
                    'placeholder'       => __( '1.99', 'wpdlang' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '0.01',
                    'type'              => 'number',
                    'default'           => 'Title',
                    'sanitize_callback' => 'floatval'
                ),
                array(
                    'name'        => 'textarea',
                    'label'       => __( 'Textarea Input', 'wpdlang' ),
                    'desc'        => __( 'Textarea description', 'wpdlang' ),
                    'placeholder' => __( 'Textarea placeholder', 'wpdlang' ),
                    'type'        => 'textarea'
                ),
                array(
                    'name'        => 'html',
                    'desc'        => __( 'HTML area description. You can use any <strong>bold</strong> or other HTML elements.', 'wpdlang' ),
                    'type'        => 'html'
                ),
                array(
                    'name'    => 'selectbox',
                    'label'   => __( 'A Dropdown', 'wpdlang' ),
                    'desc'    => __( 'Dropdown description', 'wpdlang' ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'    => 'password',
                    'label'   => __( 'Password', 'wpdlang' ),
                    'desc'    => __( 'Password description', 'wpdlang' ),
                    'type'    => 'password',
                    'default' => ''
                ),
                array(
                    'name'    => 'file',
                    'label'   => __( 'File', 'wpdlang' ),
                    'desc'    => __( 'File description', 'wpdlang' ),
                    'type'    => 'file',
                    'default' => '',
                    'options' => array(
                        'button_label' => 'Choose Image'
                    )
                ),
                array(
                    'name'    => 'color',
                    'label'   => __( 'Color', 'wpdlang' ),
                    'desc'    => __( 'Color description', 'wpdlang' ),
                    'type'    => 'color',
                    'default' => ''
                ),

                array(
                    'name'  => 'checkbox',
                    'label' => __( 'Checkbox', 'wpdlang' ),
                    'desc'  => __( 'Checkbox Label', 'wpdlang' ),
                    'type'  => 'checkbox'
                ),*/

                array(
                    'name'    => 'dashboard-widget-colors',
                    'label'   => __( 'Pick Dashboard Widget Colors', 'wpdlang' ),
                    'desc'    => __( 'Pick colors for dashboard widgets. Pick <strong>minimum 6</strong> colors, else default plugin colors will be used.', 'wpdlang' ),
                    'type'    => 'text_color',
                    'default' => '#7986CB,#4dd0e1,#9575CD,#4FC3F7,#64B5F6,#4DB6AC'
                ),
                array(
                    'name'    => 'front-usertracking',
                    'label'   => __( 'Enable User Location Tracking', 'wpdlang' ),
                    'desc'    => __( 'Check ON to enable user tracking based on IP. This option records user IP, country, city and region etc., OFF to disable.', 'wpdlang' ),
                    'type'    => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes' => __('Yes', 'wpdlang' ),
                        'no'  => __('No', 'wpdlang' )
                    )
                ),/*
                array(
                    'name'    => 'password',
                    'label'   => __( 'Password', 'wpdlang' ),
                    'desc'    => __( 'Password description', 'wpdlang' ),
                    'type'    => 'password',
                    'default' => ''
                ),
                array(
                    'name'    => 'wysiwyg',
                    'label'   => __( 'Advanced Editor', 'wpdlang' ),
                    'desc'    => __( 'WP_Editor description', 'wpdlang' ),
                    'type'    => 'wysiwyg',
                    'default' => ''
                ),*/
                array(
                    'name'    => 'dashboard-widgets',
                    'label'   => __( 'Enable Dashboard Widgets', 'wpdlang' ),
                    'desc'    => __( 'Select the widgets to display on dashboard. These widgets are added by this plugin.', 'wpdlang' ),
                    'type'    => 'multicheck',
                    "default" => array(
                            "wpd_visitors_type" => "wpd_visitors_type",
                            "wpd_user_type" => "wpd_user_type",
                            "wpd_browser_type" => "wpd_browser_type",
                            "wpd_platform_type" => "wpd_platform_type",
                            "wpd_country_type" => "wpd_country_type",
                            "wpd_pagestats_add_dashboard" => "wpd_pagestats_add_dashboard",
                            "wpd_poststats_add_dashboard" => "wpd_poststats_add_dashboard",
                            "wpd_commentstats_add_dashboard" => "wpd_commentstats_add_dashboard",
                            "wpd_browser_type" => "wpd_browser_type",
                        ),
                    'options' => array(
                            'wpd_visitors_type' => __('Visitors','wpdlang'),
                            'wpd_browser_type' => __('Browsers','wpdlang'),
                            'wpd_platform_type' => __('Devices','wpdlang'),
                            'wpd_country_type' => __('Countries','wpdlang'),
                            'wpd_poststats_add_dashboard' => __('Posts','wpdlang'),
                            'wpd_commentstats_add_dashboard' => __('Comments','wpdlang'),
                    )
                ),



                array(
                    'name'    => 'dashboard-default-widgets',
                    'label'   => __( 'Check Default Dashboard Widgets', 'wpdlang' ),
                    'desc'    => __( 'Select the widgets to display on dashboard. This includes default dashboard widgets<br>Some default widgets might not be found in your current wordpress version.', 'wpdlang' ),
                    'type'    => 'multicheck',
                    "default" => array(
                            'welcome_panel' => 'welcome_panel',
                            'dashboard_primary' => 'dashboard_primary',
                            'dashboard_quick_press' => 'dashboard_quick_press',
                            'dashboard_recent_drafts' => 'dashboard_recent_drafts',
                            'dashboard_recent_comments' => 'dashboard_recent_comments',
                            'dashboard_right_now' => 'dashboard_right_now',
                            'dashboard_activity' => 'dashboard_activity',
                            'dashboard_incoming_links' => 'dashboard_incoming_links',
                            'dashboard_plugins' => 'dashboard_plugins',
                            'dashboard_secondary' => 'dashboard_secondary'
                        ),
                    'options' => array(
                            'welcome_panel' => __('Welcome Panel', 'wpdlang' ),
                            'dashboard_primary' => __('WordPress News', 'wpdlang' ),
                            'dashboard_quick_press' => __('Quick Draft', 'wpdlang' ),
                            'dashboard_recent_drafts' => __('Recent Drafts', 'wpdlang' ),
                            'dashboard_recent_comments' => __('Recent Comments', 'wpdlang' ),
                            'dashboard_right_now' => __('At a Glance', 'wpdlang' ),
                            'dashboard_activity' => __('Activity', 'wpdlang' ),
                            'dashboard_incoming_links' => __('Incoming Links', 'wpdlang' ),
                            'dashboard_plugins' => __('Plugins Widget', 'wpdlang' ),
                            'dashboard_secondary' => __('Secondary Widget', 'wpdlang' )
                    )
                ),
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
