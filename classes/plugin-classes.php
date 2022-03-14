<?php
if ( !class_exists('Store_Lite_Getting_started') ):

    class Store_Lite_Getting_started
    {   

        function __construct()
        {	

	        add_action( 'wp_ajax_store_lite_install_plugins', array( $this, 'store_lite_install_plugins' ) );

            // Include required libs for installation
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
            require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
        }

        // Check Plugins Status
        public static function store_lite_plugin_status($plugin_class, $plugin_folder, $plugin_file){

            if( class_exists( $plugin_class ) ){

                return array('status' => 'active','string' => esc_html__('Deactivate','store-lite') );

            }else{

                $path = WP_PLUGIN_DIR.'/'.esc_attr( $plugin_folder ).'/'.esc_attr( $plugin_file );

                if( file_exists( $path ) ) {

                    return array('status' => 'deactivate','string' => esc_html__('Activate','store-lite') );
                }else{

                    return array('status' => 'not-install','string' => esc_html__('Install & Active','store-lite') );

                }

            }

            return;

        }

        public static function store_lite_recommended_plugins(){

            return $plugin_lists = array(
                'woocommerce' => array(
                    'PluginFile' => 'woocommerce.php',
                    'class' => 'WooCommerce',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=woocommerce' ),
                ),
                'demo-import-kit' => array(
                    'PluginFile' => 'demo-import-kit.php',
                    'class' => 'Demo_Import_Kit_Class',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=demo-import-kit' ),
                ),
                'booster-extension' => array(
                    'PluginFile' => 'booster-extension.php',
                    'class' => 'Booster_Extension_Class',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=booster-extension' ),
                ),
                'themeinwp-import-companion' => array(
                    'PluginFile' => 'themeinwp-import-companion.php',
                    'class' => 'Themeinwp_Import_Companion',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=demo-import-kit' ),
                ),
                'mailchimp-for-wp' => array(
                    'PluginFile' => 'mailchimp-for-wp.php',
                    'class' => 'MC4WP_Admin',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/admin.php?page=mailchimp-for-wp' ),
                ),
                'seo-friendly-urls-for-woocommerce' => array(
                    'PluginFile' => 'seo-friendly-urls-for-woocommerce.php',
                    'class' => 'Seo_Friendly_Urls_For_Woocommerce',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/admin.php?page=seo-friendly-urls-for-woocommerce' ),
                ),
                'woocommerce-currency-switcher' => array(
                    'PluginFile' => 'index.php',
                    'class' => 'WOOCS_STARTER',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=wc-settings' ),
                ),

                'yith-woocommerce-quick-view' => array(
                    'PluginFile' => 'init.php',
                    'class' => 'YITH_WCQV',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=init' ),
                ),
                'yith-woocommerce-compare' => array(
                    'PluginFile' => 'init.php',
                    'class' => 'YITH_Woocompare',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=init' ),
                ),
                'yith-woocommerce-wishlist' => array(
                    'PluginFile' => 'init.php',
                    'class' => 'YITH_WCWL',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=init' ),
                ),
            );

        }

        // Install Active Deactive
        public function store_lite_install_plugins(){
            
            $nonce = isset( $_POST["_wpnonce"] ) ? sanitize_text_field( wp_unslash( $_POST["_wpnonce"] ) ) : '';

            if ( ! current_user_can('install_plugins') ) {
                wp_die( esc_html__( 'Sorry, you are not allowed to install plugins on this site.', 'store-lite' ) );
            }

            // Check our nonce, if they don't match then bounce!
            if (! wp_verify_nonce( $nonce, 'store_lite_ajax_nonce' )) {

                wp_die( esc_html__( 'Error - unable to verify nonce, please try again.', 'store-lite') );

            }

            $plugin_lists = array();

            if( isset( $_POST['single'] ) ){
                
                if( isset( $_POST['PluginStatus'] ) && 
                    isset( $_POST['PluginSlug'] ) && 
                    isset( $_POST['PluginFile'] ) && 
                    isset( $_POST['PluginFolder'] ) && 
                    isset( $_POST['PluginName'] ) &&
                    isset( $_POST['pluginClass'] ) ){

                    $plugin_lists = array(

                        $_POST['PluginSlug'] => array(
                            'PluginFile' => sanitize_text_field( wp_unslash( $_POST['PluginFile'] ) ),
                            'class' => sanitize_text_field( wp_unslash( $_POST['pluginClass'] ) ),
                        )

                    );

                }

            }else{

                $plugin_lists = $this->store_lite_recommended_plugins();

            }

            foreach( $plugin_lists as $key => $plugin ){

                if( isset( $_POST['single'] ) ){

                    $PluginStatus = sanitize_text_field( wp_unslash( $_POST['PluginStatus'] ) );

                }else{

                    $pluginstatus   = $this->store_lite_plugin_status( $plugin['class'],$key,$plugin['PluginFile'] );
                    $PluginStatus = $pluginstatus['status'];

                }
                
                $plugin_file    = $plugin['PluginFile'];
                $plugin_dir     = ABSPATH . 'wp-content/plugins/'.esc_html( $key ).'/'.esc_html( $plugin_file );

                if( isset( $_POST['single'] ) && $PluginStatus == 'active' ) {

                    deactivate_plugins( $plugin_dir );
                    esc_html_e('Deactivated' , 'store-lite');
                    die();

                }elseif( $PluginStatus == 'deactivate' && file_exists($plugin_dir) ) {

                    activate_plugin($plugin_dir);

                    if( isset( $_POST['single'] ) ) {

                        esc_html_e('Activated' , 'store-lite');
                        die();

                    }

                }elseif( $PluginStatus == 'not-install' ){

                    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

                    $plugin_info = plugins_api(
                        'plugin_information',
                        array(
                            'slug'   => sanitize_key( wp_unslash( $key ) ),
                            'fields' => array(
                                'sections' => false,
                            ),
                        )
                    );

                    $skin     = new WP_Ajax_Upgrader_Skin();
                    $upgrader = new Plugin_Upgrader( $skin );
                    $upgrader->install($plugin_info->download_link);
                    $plugin_file = esc_html($key).'/'.esc_html($plugin_file);
                    
                    if( file_exists($plugin_dir) ) {

                        activate_plugin($plugin_dir);

                        if( isset( $_POST['single'] ) ) {
                            esc_html_e('Installed & Activated' , 'store-lite');
                            die();
                        }

                    }

                    if( isset( $_POST['single'] ) ) {

                        esc_html_e('Failed' , 'store-lite');
                        die();

                    }

                }else{

                    if( isset( $_POST['single'] ) ) {

                        esc_html_e('Failed' , 'store-lite');
                        die();

                    }

                }

            }

            if( !isset( $_POST['single'] ) ) {
                echo esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=store-lite-about' );
            }

            die();

        }

    }

    new Store_Lite_Getting_started();

endif;