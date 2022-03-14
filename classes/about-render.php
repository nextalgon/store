<?php
/**
* About Rencer Content.
*
* @package Store Lite
*/


$base_url = home_url();

$store_lite_panels_sections = array(

    'theme_general_settings' => array(

        'title' => esc_html__('General Settings','store-lite'),
        'sections' => array(

            array(
                'title' => esc_html__('Logo & Site Identity','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bcontrol%5D=custom_logo'),
                'icon'  => 'dashicons-format-image',
            ),
            array(
                'title' => esc_html__('Header Media','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=header_image'),
                'icon'  => 'dashicons-desktop',
            ),
            array(
                'title' => esc_html__('Background Image','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=background_image'),
                'icon'  => 'dashicons-desktop',
            ),
            array(
                'title' => esc_html__('Menu Settings','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bpanel%5D=nav_menus'),
                'icon'  => 'dashicons-menu',
            ),

        ),

    ),
    'theme_colors_panel' => array(

        'title' => esc_html__('Color Settings','store-lite'),
        'sections' => array(

            array(
                'title' => esc_html__('Color Options','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=colors'),
                'icon'  => 'dashicons-admin-customizer',
            ),  

        ),

    ),
    'static_front_page' => array(

        'title' => esc_html__('Homepage Settings','store-lite'),
        'sections' => array(

            array(
                'title' => esc_html__('Homepages Settings','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=static_front_page'),
                'icon'  => 'dashicons-admin-generic',
            ),

        ),

    ),
    'theme_option_panel' => array(

        'title' => esc_html__('Theme Options','store-lite'),
        'sections' => array(

            array(
                'title' => esc_html__('Header Settings','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=header_section_settings'),
                'icon'  => 'dashicons-align-center',
            ),
            array(
                'title' => esc_html__('Pagination Settings','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=pagination_section'),
                'icon'  => 'dashicons-ellipsis',
            ),
            array(
                'title' => esc_html__('Main Banner Section','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=main_banner_section_settings'),
                'icon'  => 'dashicons-admin-settings',
            ),
            array(
                'title' => esc_html__('Single Post Settings','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=single_page_section_Settings'),
                'icon'  => 'dashicons-welcome-write-blog',
            ),
            array(
                'title' => esc_html__('Layout Settings','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=theme_option_section_settings'),
                'icon'  => 'dashicons-layout',
            ),
            array(
                'title' => esc_html__('Footer Setting','store-lite'),
                'url'   => esc_url( $base_url.'/wp-admin/customize.php?autofocus%5Bsection%5D=footer_settings'),
                'icon'  => 'dashicons-admin-generic',
            ),

        ),

    ),

);

include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
$rec_plugins = Store_Lite_Getting_started::store_lite_recommended_plugins();
$theme_version = wp_get_theme()->get( 'Version' );
$theme_info      = wp_get_theme();
$theme_name            = $theme_info->__get( 'Name' );
?>
<div class="twp-about-main">

    <div class="about-page-header">
        <div class="about-wrapper">
            <div class="about-wrapper-inner">
                <div class="about-header-left">
                    <h1 class="about-theme-title">
                        <a href="<?php echo esc_url( 'https://www.themeinwp.com/theme/store-lite' ); ?>">
                            <img src="<?php echo esc_url( get_template_directory_uri().'/assets/images/store-lite-logo.png' ); ?>" class="about-theme-logo">
                            <span class="theme-version"><?php echo esc_html( $theme_version ); ?></span>
                        </a>
                    </h1>
                </div>
                <div class="about-header-right">
                    <p><?php esc_html_e('Eye-catching, Lightweight, and Highly Customizable WordPress Theme','store-lite'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="about-page-content">
        <div class="about-wrapper">
            <div class="about-wrapper-inner">

                <div class="about-content-left">

                    <?php
                    foreach( $store_lite_panels_sections as $panels ){ ?>

                        <div class="about-content-panel">

                            <?php if( isset( $panels['title'] ) && $panels['title'] ){ ?>

                                <h2 class="about-panel-title"><?php echo esc_html( $panels['title'] );  ?></h2>

                            <?php } ?>
                            <div class="about-panel-items about-panel-2-columns">
                            <?php

                            if( isset( $panels['sections'] ) && $panels['sections'] ){

                                foreach( $panels['sections'] as $section ){ ?>


                                    <div class="about-items-wrap">
                                        <?php if( isset( $section['icon'] ) && $section['icon'] ){ ?>
                                            <span class="about-items-icon dashicons <?php echo esc_attr( $section['icon'] ); ?>"></span>
                                        <?php } ?>

                                        <?php if( isset( $section['title'] ) && $section['title'] && isset( $section['url'] ) && $section['url'] ){ ?>
                                            <span class="about-items-title">
                                                <a href="<?php echo esc_url( $section['url'] ); ?>"><?php echo esc_html( $section['title'] ); ?></a>
                                            </span>
                                        <?php } ?>
                                    </div>


                            <?php }

                            } ?>
                            </div>
                        </div>

                    <?php } ?>

                    <div class="about-content-panel">

                        <h2 class="about-panel-title"><?php esc_html_e('Recommended Plugins','store-lite'); ?></h2>

                        <div class="about-panel-items about-panel-1-columns">

                            <?php foreach ($rec_plugins as $key => $plugin) {

                                $plugin_info = plugins_api(
                                    'plugin_information',
                                    array(
                                        'slug' => sanitize_key(wp_unslash($key)),
                                        'fields' => array(
                                            'sections' => false,
                                        ),
                                    )
                                );

                                $plugin_status = Store_Lite_Getting_started::store_lite_plugin_status($plugin['class'], $key, $plugin['PluginFile']); ?>

                                <div id="<?php echo 'store-lite-' . esc_attr($key); ?>" class="about-items-wrap">
                                    <div class="theme-recommended-plugin <?php if ($plugin_status['status'] == 'active') { echo 'recommended-plugin-active'; } ?>">

                                        <?php if (isset($plugin_info->name)) { ?>
                                            <a href="javascript:void(0)"><?php echo esc_html($plugin_info->name); ?></a>
                                        <?php } ?>

                                        <?php if (isset($plugin_status['status']) && isset($plugin_status['string'])) { ?>

                                            <a class="recommended-plugin-status <?php echo 'twp-plugin-' . esc_attr($plugin_status['status']); ?>"
                                               plugin-status="<?php echo esc_attr($plugin_status['status']); ?>"
                                               plugin-file="<?php echo esc_attr($plugin['PluginFile']); ?>"
                                               plugin-folder="<?php echo esc_attr($key); ?>"
                                               plugin-slug="<?php echo esc_attr($key); ?>"
                                               plugin-class="<?php echo esc_attr($plugin['class']); ?>"
                                               href="javascript:void(0)"><?php echo esc_html($plugin_status['string']); ?></a>

                                        <?php } ?>

                                    </div>

                                </div>

                            <?php } ?>

                        </div>

                    </div>

                </div>

                <div class="about-content-right">

                    <div class="about-content-panel">
                        <h2 class="about-panel-title"><span class="dashicons dashicons-sos"></span> <?php esc_html_e('Looking for help?','store-lite'); ?></h2>
                        <div class="about-content-info">
                            <p><?php esc_html_e('We have some resources available to help you in the right direction.','store-lite'); ?></p>
                            <ul>
                                <li>
                                    <a href="<?php echo esc_url( 'https://www.themeinwp.com/support/' ); ?>" target="_blank" rel="noopener"><?php esc_html_e('Create a Ticket','store-lite'); ?> &#187;</a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url( 'https://www.themeinwp.com/knowledgebase/' ); ?>" target="_blank" rel="noopener"><?php esc_html_e('Knowledge Base','store-lite'); ?> &#187;</a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url( 'https://docs.themeinwp.com/docs/store-lite' ); ?>" target="_blank" rel="noopener"><?php esc_html_e('Theme Documentation','store-lite'); ?> &#187;</a>
                                </li>
                            </ul>
                            <p><?php esc_html_e('Behind every single customer support question stands a real person ready to fix the problem in real-time and guide you through.','store-lite'); ?></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="about-wrapper">
            <div class="about-wrapper-inner">
                <div class="about-content-full">
                    <div class="about-wrapper-footer">
                        <h2 class="about-panel-title"><?php printf( __( 'Unlock all the Features with %1$s Pro', 'store-lite' ), esc_html( $theme_name ) ); ?></h2>
                        <div class="about-footer-leftside">
                            <ul>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('Color Options','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('800+ Font Families','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('More Custom Widgets','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('More Customizer controls','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('More page/post meta options','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('Webmaster Tools','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('Remove Footer Attribution (copyright)','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-yes"></span><?php esc_html_e('VIP priority Support','store-lite'); ?></li>
                                <li><span class="dashicons dashicons-plus"></span><?php esc_html_e('much more stuff...','store-lite'); ?></li>
                            </ul>
                        </div>
                        <div class="about-footer-rightside">
                            <div class="about-footer-upgrade">
                                <h3 class="footer-upgrade-title">
                                    <?php esc_html_e('Upgrade to Pro','store-lite'); ?>
                                </h3>
                                <div class="footer-upgrade-price">
                                    <sup><?php esc_html_e('$','store-lite'); ?></sup>
                                    <span><?php esc_html_e('59','store-lite'); ?></span>
                                </div>
                                <div class="footer-upgrade-link">
                                    <a target="_blank" class="button button-primary button-primary-upgrade" href="<?php echo esc_url( 'https://www.themeinwp.com/theme/store-pro/' ); ?>"><?php esc_html_e('Upgrade to Pro','store-lite'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>