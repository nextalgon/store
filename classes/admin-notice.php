<?php
if ( !class_exists('Store_Lite_Dashboard_Notice') ):

    class Store_Lite_Dashboard_Notice
    {
        function __construct()
        {	
            global $pagenow;

        	if( $this->store_lite_show_hide_notice() ){

	            if( is_multisite() ){

                  add_action( 'network_admin_notices',array( $this,'store_lite_admin_notiece' ) );

                } else {

                  add_action( 'admin_notices',array( $this,'store_lite_admin_notiece' ) );
                }
	        }
	        add_action( 'wp_ajax_store_lite_notice_dismiss', array( $this, 'store_lite_notice_dismiss' ) );
			add_action( 'switch_theme', array( $this, 'store_lite_notice_clear_cache' ) );
            
            if( isset( $_GET['page'] ) && $_GET['page'] == 'store-lite-about' ){
                add_action('in_admin_header', array( $this,'store_lite_notice_remove' ),1000 );
            }

        }
        
        function store_lite_notice_remove(){

            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');
        }
        
        public static function store_lite_show_hide_notice( $status = false ){

            if( $status ){

                if( (class_exists( 'Demo_Import_Kit_Class' ) ) || get_option('twp_store_lite_admin_notice') ){

                    return false;

                }else{

                    return true;

                }

            }

            // Check If current Page 
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'store-lite-about'  ) {
                return false;
            }

        	// Hide if dismiss notice
        	if( get_option('twp_store_lite_admin_notice') ){
				return false;
			}
            // Hide if all plugin active
            if (class_exists( 'Booster_Extension_Class' ) && class_exists( 'Demo_Import_Kit_Class' ) && class_exists( 'Themeinwp_Import_Companion' ) && class_exists( 'WooCommerce' ) && class_exists( 'YITH_WCQV' ) && class_exists( 'YITH_Woocompare' ) && class_exists( 'YITH_WCWL' )) {
                return false;
            }
			// Hide On TGMPA pages
			if ( ! empty( $_GET['tgmpa-nonce'] ) ) {
				return false;
			}
			// Hide if user can't access
        	if ( current_user_can( 'manage_options' ) ) {
				return true;
			}
			
        }

        // Define Global Value
        public static function store_lite_admin_notiece(){ ?>

            <div class="updated notice is-dismissible twp-store-lite-notice">

                <h3><?php esc_html_e('Quick Setup','store-lite'); ?></h3>

                <p><strong><?php esc_html_e('Storer is now installed and ready to use. Are you looking for a better experience to set up your site?','store-lite'); ?></strong></p>

                <small><?php esc_html_e("We've prepared a unique onboarding process through our",'store-lite'); ?> <a href="<?php echo esc_url( admin_url().'themes.php?page='.get_template().'-about') ?>"><?php esc_html_e('Getting started','store-lite'); ?></a> <?php esc_html_e("page. It helps you get started and configure your upcoming website with ease. Let's make it shine!",'store-lite'); ?></small>

                <p>
                    <a class="button button-primary twp-install-active" href="javascript:void(0)"><?php esc_html_e('Install and activate recommended plugins','store-lite'); ?></a>
                    <span class="quick-loader-wrapper"><span class="quick-loader"></span></span>
                    <a target="_blank" class="button button-primary button-primary-upgrade" href="<?php echo esc_url( 'https://www.themeinwp.com/theme/store-lite-pro/' ); ?>"><?php esc_html_e('Upgrade to Pro','store-lite'); ?></a>

                    <a class="btn-dismiss twp-custom-setup" href="javascript:void(0)"><?php esc_html_e('Dismiss this notice.','store-lite'); ?></a>

                </p>

            </div>

        <?php
        }

        public function store_lite_notice_dismiss(){

        	if ( isset( $_POST[ '_wpnonce' ] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ '_wpnonce' ] ) ), 'store_lite_ajax_nonce' ) ) {

	        	update_option('twp_store_lite_admin_notice','hide');

	        }

            die();

        }

        public function store_lite_notice_clear_cache(){

        	update_option('twp_store_lite_admin_notice','');

        }

    }
    new Store_Lite_Dashboard_Notice();
endif;