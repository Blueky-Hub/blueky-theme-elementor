<?php
if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
});

require_once dirname(__FILE__) . '/tgmpa/class-tgm-plugin-activation.php';

function my_theme_tgmpa_register_languages() {
    $locale = determine_locale();
    $locale = apply_filters('plugin_locale', $locale, 'tgmpa');

    $mofile = dirname(__FILE__) . '/tgmpa/languages/tgmpa-' . $locale . '.mo';

    load_textdomain('tgmpa', $mofile);
}
add_action('init', 'my_theme_tgmpa_register_languages');

/**
 * Đăng ký các plugin cần thiết cho theme Blueky Child
 */
function my_theme_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => '1. Blockera',
            'slug'      => 'blockera',
            'required'  => false,
        ),
        array(
            'name'      => '2. Fluent Forms',
            'slug'      => 'fluentform',
            'required'  => false,
        ),
        array(
            'name'      => '3. All-in-One WP Migration',
            'slug'      => 'all-in-one-wp-migration',
            'required'  => false,
        ),
        array(
            'name'      => '4. Tối ưu quản trị và trang web (ASE)',
            'slug'      => 'admin-site-enhancements',
            'required'  => false,
        ),
        array(
            'name'      => '5. Slim SEO',
            'slug'      => 'slim-seo',
            'required'  => false,
        ),
	array(
            'name'      => '6. Google Site Kit',
            'slug'      => 'google-site-kit',
            'required'  => false,
        ),
    );

    $config = array(
        'id'           => 'tgmpa',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
		'dismiss_msg'  => '',
        'is_automatic' => true,
		'message'      => '',
		'strings'      => array(
			'page_title'   => __( 'Giao diện Blueky Theme đề xuất cài đặt các plugin tốt nhất', 'theme-slug' ),
			'menu_title'   => __( 'Cài Plugin đề xuất', 'theme-slug' ),
			'dismiss'  => __( 'Tắt thông báo', 'tgmpa' ),
			// 'notice_can_install_recommended'  => _n_noop(
            //     'Giao diện Blueky Child yêu cầu cài đặt plugin sau: %1$s.',
            //     'Giao diện Blueky Child yêu cầu cài đặt plugin sau: %1$s.'
            // ),
		)
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'my_theme_register_required_plugins');

// Funnelkit cron check
define( 'BWF_CHECK_CRON_SCHEDULE', true );

// Tắt chế độ toàn màn hình của Editor
function jba_disable_editor_fullscreen_by_default() {
	$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
	wp_add_inline_script( 'wp-blocks', $script );
}
