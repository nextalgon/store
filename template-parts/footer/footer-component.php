<?php
/**
 * Template for Footer Components
 * @since store-lite 1.0.0
 */
$default = store_lite_get_default_theme_options();
$ed_scroll_top_button = absint( get_theme_mod('ed_scroll_top_button', $default['ed_scroll_top_button'] ) );
?>

<?php if ( is_active_sidebar('store-lite-offcanvas-widget') ): ?>
    
    <div id="sidr-nav">
        <a class="skip-link-offcanvas-sidr-start" href="javascript:void(0)"></a>
        <a class="sidr-class-sidr-button-close" href="#sidr-nav"><?php echo esc_html__('Close','store-lite'); ?> <i class="ion-ios-close"></i></a>
        <div class="sidr-area">
            <?php dynamic_sidebar('store-lite-offcanvas-widget'); ?>
        </div>
    </div>
    <a class="skip-link-offcanvas-sidr-end" href="javascript:void(0)"></a>
<?php endif; ?>

<?php if( is_singular('post') ):
    // Single Posts Related Posts.
    store_lite_related_posts();
endif; ?>

<?php if( $ed_scroll_top_button ){ ?>
    <div class="scroll-up">
        <i class="ion ion-ios-arrow-up"></i>
    </div>
<?php } ?>

<?php
$ed_after_add_to_cart_popup = absint( get_theme_mod('ed_after_add_to_cart_popup', $default['ed_after_add_to_cart_popup'] ) );
?>

<?php if( class_exists( 'WooCommerce' ) && $ed_after_add_to_cart_popup ){ ?>
    <div id="twp-popup-addtocart">
        <a id="twp-close-popup" href="javascript:void(0)">
            <i class="ion ion-md-close"></i>
        </a>
        <h4><span></span><?php esc_html_e(' has been added to your cart','store-lite'); ?></h4>
        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ); ?>"><?php esc_html_e('View Cart','store-lite'); ?></a>
    </div>
<?php } ?>
