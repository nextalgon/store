<?php
/**
* Sidebar Metabox.
*
* @package Store Lite
*/
 
add_action( 'add_meta_boxes', 'store_lite_metabox' );

if( ! function_exists( 'store_lite_metabox' ) ):


    function  store_lite_metabox() {
        
        add_meta_box(
            'store_lite_post_metabox',
            esc_html__( 'Single Post/Page Settings', 'store-lite' ),
            'store_lite_post_metafield_callback',
            'post', 
            'normal', 
            'high'
        );
        add_meta_box(
            'store_lite_page_metabox',
            esc_html__( 'Single Post/Page Settings', 'store-lite' ),
            'store_lite_post_metafield_callback',
            'page',
            'normal', 
            'high'
        ); 
    }

endif;


$store_lite_post_image_fields = array(
    'global-image' => array(
                    'id'        => 'post-global-image',
                    'value' => 'global-image',
                    'label' => esc_html__( 'Global image', 'store-lite' ),
                ),
    'enable-image' => array(
                    'id'        => 'post-enable-image',
                    'value' => 'enable-image',
                    'label' => esc_html__( 'Enable image', 'store-lite' ),
                ),
    'disable-image' => array(
                    'id'        => 'post-disable-image',
                    'value'     => 'disable-image',
                    'label'     => esc_html__( 'Disable image', 'store-lite' ),
                ),
);

$store_lite_post_sidebar_fields = array(
    'global-sidebar' => array(
                    'id'        => 'post-global-sidebar',
                    'value' => 'global-sidebar',
                    'label' => esc_html__( 'Global sidebar', 'store-lite' ),
                ),
    'right-sidebar' => array(
                    'id'        => 'post-left-sidebar',
                    'value' => 'right-sidebar',
                    'label' => esc_html__( 'Right sidebar', 'store-lite' ),
                ),
    'left-sidebar' => array(
                    'id'        => 'post-right-sidebar',
                    'value'     => 'left-sidebar',
                    'label'     => esc_html__( 'Left sidebar', 'store-lite' ),
                ),
    'no-sidebar' => array(
                    'id'        => 'post-no-sidebar',
                    'value'     => 'no-sidebar',
                    'label'     => esc_html__( 'No sidebar', 'store-lite' ),
                ),
);

/**
 * Callback function for post option.
*/
if( ! function_exists( 'store_lite_post_metafield_callback' ) ):
    function store_lite_post_metafield_callback() {
        global $post, $store_lite_post_sidebar_fields, $store_lite_post_image_fields;
        $post_type = get_post_type( $post->ID );
        wp_nonce_field( basename( __FILE__ ), 'store_lite_post_meta_nonce' );
        $default = store_lite_get_default_theme_options();
        $global_sidebar_layout = esc_html( get_theme_mod( 'global_sidebar_layout',$default['global_sidebar_layout'] ) );
        $store_lite_post_sidebar = esc_html( get_post_meta( $post->ID, 'store_lite_post_sidebar_option', true ) ); 
        if( $store_lite_post_sidebar == '' ){ $store_lite_post_sidebar = 'global-sidebar'; }
        ?>

        <div class="store-tab-main">

            <div class="store-metabox-tab">
                <ul>
                    <li>
                        <a id="twp-tab-sidebar" class="twp-tab-active" href="javascript:void(0)"><?php esc_html_e('Layout Settings', 'store-lite'); ?></a>
                    </li>
                </ul>
            </div>

            <div class="store-tab-content">
                
                <div id="twp-tab-sidebar-content" class="store-content-wrap store-tab-content-active">

                    <div class="store-meta-panels">

                        <div class="store-opt-wrap store-opt-wrap-alt">

                            <label><b><?php esc_html_e( 'Sidebar Layout','store-lite' ); ?></b></label>

                            <select name="store_lite_post_sidebar_option">

                                <?php
                                foreach ( $store_lite_post_sidebar_fields as $store_lite_post_sidebar_field) { ?>
                                    
                                    <option value="<?php echo esc_attr( $store_lite_post_sidebar_field['value'] ); ?>" <?php if( $store_lite_post_sidebar_field['value'] == $store_lite_post_sidebar ){ echo "selected";} if( empty( $store_lite_post_sidebar ) && $store_lite_post_sidebar_field['value']=='right-sidebar' ){ echo "selected"; } ?> >
                                        <?php echo esc_html( $store_lite_post_sidebar_field['label'] ); ?> 
                                    </option>

                                <?php } ?>


                            </select>

                        </div>

                        <div class="store-opt-wrap store-opt-wrap-alt">

                            <?php
                            $store_lite_post_image = esc_html( get_post_meta( $post->ID, 'store_lite_post_image_option', true ) ); 
                            if( $store_lite_post_image == '' ){ $store_lite_post_image = 'global-image'; }
                            ?>
                            <label><b><?php esc_html_e( 'Image Setting','store-lite' ); ?></b></label>

                            <select name="store_lite_post_image_option">

                                <?php
                                foreach ( $store_lite_post_image_fields as $store_lite_post_image_field) { ?>
                                        
                                        <option value="<?php echo esc_attr( $store_lite_post_image_field['value'] ); ?>" <?php if( $store_lite_post_image_field['value'] == $store_lite_post_image ){ echo "selected";} if( empty( $store_lite_post_image ) && $store_lite_post_image_field['value']=='right-sidebar' ){ echo "selected"; } ?> >
                                            <?php echo esc_html( $store_lite_post_image_field['label'] ); ?> 
                                        </option>
                                        
                                <?php } ?>


                            </select>

                        </div>


                    </div>
                </div>

            </div>
        </div>

    <?php }
endif;

// Save metabox value.
add_action( 'save_post', 'store_lite_save_post_meta' );

if( ! function_exists( 'store_lite_save_post_meta' ) ):

function store_lite_save_post_meta( $post_id ) {

    global $post;
    $post_type = '';
    if (isset($post->ID)) {
        $post_type = get_post_type($post->ID);
    }
    
    if ( !isset( $_POST[ 'store_lite_post_meta_nonce' ] ) || !wp_verify_nonce( wp_unslash( $_POST['store_lite_post_meta_nonce'] ), basename( __FILE__ ) ) )
        return;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
        
    if ( 'page' == wp_unslash( $_POST['post_type'] ) ) {  
        if ( !current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif ( !current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }
    
    

    $store_lite_post_sidebar_option_old = esc_html( get_post_meta( $post_id, 'store_lite_post_sidebar_option', true ) ); 
    $store_lite_post_sidebar_option_new = store_lite_sanitize_sidebar_option( wp_unslash( $_POST['store_lite_post_sidebar_option'] ) );
    if ( $store_lite_post_sidebar_option_new && $store_lite_post_sidebar_option_new != $store_lite_post_sidebar_option_old ) {  
        update_post_meta ( $post_id, 'store_lite_post_sidebar_option', $store_lite_post_sidebar_option_new );  
    } elseif ( '' == $store_lite_post_sidebar_option_new && $store_lite_post_sidebar_option_old ) {  
        delete_post_meta( $post_id,'store_lite_post_sidebar_option', $store_lite_post_sidebar_option_old );  
    }

    $store_lite_post_image_option_old = esc_html( get_post_meta( $post_id, 'store_lite_post_image_option', true ) ); 
    $store_lite_post_image_option_new = store_lite_sanitize_image_option( wp_unslash( $_POST['store_lite_post_image_option'] ) );
    if ( $store_lite_post_image_option_new && $store_lite_post_image_option_new != $store_lite_post_image_option_old ) {  
        update_post_meta ( $post_id, 'store_lite_post_image_option', $store_lite_post_image_option_new );  
    } elseif ( '' == $store_lite_post_image_option_new && $store_lite_post_image_option_old ) {  
        delete_post_meta( $post_id,'store_lite_post_image_option', $store_lite_post_image_option_old );  
    }


}
endif;   