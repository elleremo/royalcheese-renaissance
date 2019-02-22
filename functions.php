<?php

class RoyalCheese {
	public static $version = '1.0.0';

	private function __clone() {
	}

	private function __construct() {
	}

	public static function run() {

		new \RoyalCheese\Main\Favicon();
		new \RoyalCheese\Main\Viewport();

		self::service();

		add_action( 'after_setup_theme', [ __CLASS__, 'after_setup_theme' ], 10 );

		add_filter( 'excerpt_more', function ( $more ) {
			return '';
		}, 10, 1 );

		add_filter( 'excerpt_length', function ( $length ) {
			return 36;
		}, 10, 1 );

	}

	public static function after_setup_theme() {
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

//			add_action( 'wp_enqueue_scripts', function () {
//				wp_enqueue_script(
//					'jquery_fitvids',
//					get_template_directory_uri() . '/js/vendor/FitVids_js/jquery.fitvids.min.js',
//					[ 'jquery' ],
//					self::$version,
//					true
//				);
//
//				wp_enqueue_script(
//					'theme-single-content-change',
//					get_template_directory_uri() . '/js/single-text-blocks.min.js',
//					[ 'jquery', 'jquery_fitvids' ],
//					self::$version,
//					true
//				);
//			} );

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

}


RoyalCheese::run();

require_once( get_theme_file_path( "autoloder/Autoloader.php" ) );

use Royalcheese\Autoloader;

try {
	new Autoloader( __FILE__, 'RoyalCheese' );
} catch ( Exception $e ) {
	if ( function_exists( 'd' ) ) {
		d( $e->getMessage() );
	}
}
