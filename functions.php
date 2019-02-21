<?php

class RoyalCheese {
	public static $version = '1.0.0';

	private function __clone() {
	}

	private function __construct() {
	}

	public static function run() {

		self::service();
		self::helpers();
		add_action( 'after_setup_theme', [ __CLASS__, 'after_setup_theme' ], 10 );

		add_filter( 'excerpt_more', function ( $more ) {
			return '';
		}, 10, 1 );

		add_filter( 'excerpt_length', function ( $length ) {
			return 36;
		}, 10, 1 );

		add_action( 'wp_head', [ __CLASS__, 'favicon' ] );
		add_action( 'login_head', [ __CLASS__, 'favicon' ] );
		add_action( 'admin_head', [ __CLASS__, 'favicon' ] );

	}

	public static function after_setup_theme() {
		add_filter( 'body_class', [ __CLASS__, 'body_class' ] );
		add_action( 'wp_head', [ __CLASS__, 'add_viewport' ], 0 );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
		add_action( 'template_redirect', [ __CLASS__, 'add_chunks' ] );
	}


	public static function add_chunks() {

		$chunks_path = get_template_directory_uri() . '/css/less/';

		add_action( 'wp_enqueue_scripts', function () {
			wp_enqueue_style(
				'theme-stylesheet',
				get_stylesheet_uri(),
				[],
				self::$version
			);
		} );


		if ( is_front_page() ) {
			add_action( 'wp_enqueue_scripts', function () use ( $chunks_path ) {
				wp_enqueue_style(
					'theme-stylesheet__front',
					$chunks_path . 'front/style.css', [],
					self::$version
				);
			} );

			wp_register_script(
				'tiny-slider',
				get_template_directory_uri() . '/js/vendor/tiny-slider/dist/min/tiny-slider.js',
				[],
				'2.0',
				true
			);

			wp_register_style(
				'tiny-slider',
				get_template_directory_uri() . '/js/vendor/tiny-slider/dist/tiny-slider.css',
				[],
				'2.0',
				'all'
			);

			wp_register_script(
				'tiny-slider-init',
				get_template_directory_uri() . '/js/tiny-slider-init.min.js',
				[ 'tiny-slider' ],
				self::$version,
				true
			);

		}

		if ( is_archive() || is_search() ) {
			add_action( 'wp_enqueue_scripts', function () use ( $chunks_path ) {
				wp_enqueue_style(
					'theme-stylesheet__archive',
					$chunks_path . 'archive/style.css', [],
					self::$version
				);
			} );
		}

		if ( is_singular() ) {
			add_action( 'wp_enqueue_scripts', function () use ( $chunks_path ) {
				wp_enqueue_style(
					'theme-stylesheet__single',
					$chunks_path . 'single/style.css', [],
					self::$version
				);
			} );

			add_action( 'wp_enqueue_scripts', function () {
				wp_enqueue_script(
					'jquery_fitvids',
					get_template_directory_uri() . '/js/vendor/FitVids_js/jquery.fitvids.min.js',
					[ 'jquery' ],
					self::$version,
					true
				);

				wp_enqueue_script(
					'theme-single-content-change',
					get_template_directory_uri() . '/js/single-text-blocks.min.js',
					[ 'jquery', 'jquery_fitvids' ],
					self::$version,
					true
				);
			} );

		}

		if ( 0 <= $GLOBALS['wp_query']->post_count && ( is_404() || is_search() || is_archive() ) ) {

			add_action( 'wp_enqueue_scripts', function () use ( $chunks_path ) {
				wp_enqueue_style(
					'theme-stylesheet__404',
					$chunks_path . '404/style.css',
					[],
					self::$version
				);
			}, 0 );
		}

		add_action( 'wp_footer', function () use ( $chunks_path ) {
			wp_enqueue_style(
				'theme-stylesheet__common_deffer',
				$chunks_path . 'common_deffer/style.css',
				[],
				self::$version
			);
		}, 0 );

	}

	public static function enqueue_scripts() {

	}


 	public static function helpers() {


	}

	public static function service() {
		add_editor_style();

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		register_nav_menus(
			[
				'header-menu' => 'Header Menu',
				'footer-menu' => 'Footer Menu',
			]
		);
		add_theme_support(
			'html5',
			[
				'automatic-feed-links',
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption'
			]
		);
	}

	public static function add_viewport() {
		echo "<meta name='viewport' content='width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no'> \r\n";
	}

	public static function body_class( $classes ) {

		if ( is_singular() ) {
			$classes[] = 'singular';
			if ( get_post_meta( $GLOBALS['wp_query']->queried_object_id, '_advert_post', true ) == 'on' ) {
				$classes[] = 'singular-advert-post';
			}

			if ( is_user_logged_in() ) {
				if ( get_user_meta( get_current_user_id(), 'wooden_bg', true ) ) {
					$classes[] = 'wooden_bg';
				}
			}


		}

		if ( is_home() ) {
			$classes[] = 'grid';
		}

		return $classes;
	}


	public static function favicon() {

		echo '<link rel="icon" type="image/x-icon" href="' . get_bloginfo( 'stylesheet_directory' ) . '/images/favicons/favicon.ico" />' . "\n";

		echo '<link rel="shortcut icon" href="' . get_bloginfo( 'stylesheet_directory' ) . '/images/favicons/favicon.ico" type="image/x-icon">' . "\n";

		if ( function_exists( 'get_site_icon_url' ) ) {

			echo sprintf( '<link rel="apple-touch-icon-precomposed" href="%s">', esc_url( get_site_icon_url( 180 ) ) ) . "\n";

			echo sprintf( '<link rel="apple-touch-icon-precomposed" sizes= "76x76" href="%s">', esc_url( get_site_icon_url( 76 ) ) ) . "\n";

			echo sprintf( '<link rel="apple-touch-icon-precomposed" sizes="120x120" href="%s">', esc_url( get_site_icon_url( 120 ) ) ) . "\n";

			echo sprintf( '<link rel="apple-touch-icon-precomposed" sizes="152x152" href="%s">', esc_url( get_site_icon_url( 152 ) ) ) . "\n";

			echo sprintf( '<meta name="msapplication-TileImage" content="%s">', esc_url( get_site_icon_url( 270 ) ) ) . "\n";
		}
		echo '<meta name="msapplication-TileColor" content="#efefef">';

		echo '<meta name="theme-color" content="#ffffff">';

	}

}

RoyalCheese::run();
