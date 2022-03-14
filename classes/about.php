<?php

/**
 * Store Lite About Page
 * @package Store Lite
 *
*/

if( !class_exists('Store_Lite_About_page') ):

	class Store_Lite_About_page{

		function __construct(){

			add_action('admin_menu', array($this, 'store_lite_backend_menu'),999);

		}

		// Add Backend Menu
        function store_lite_backend_menu(){

            add_theme_page(esc_html__( 'Store Lite Options','store-lite' ), esc_html__( 'Store Lite Options','store-lite' ), 'activate_plugins', 'store-lite-about', array($this, 'store_lite_main_page'));

        }

        // Settings Form
        function store_lite_main_page(){

            require get_template_directory() . '/classes/about-render.php';

        }

	}

	new Store_Lite_About_page();

endif;