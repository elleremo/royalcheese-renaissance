<?php

namespace RoyalCheese\Main;


class Favicon {

	public function __construct() {
		d($this);
		add_action( 'wp_head', [ $this, 'favicon' ] );
		add_action( 'login_head', [ $this, 'favicon' ] );
		add_action( 'admin_head', [ $this, 'favicon' ] );
	}

	public function favicon() {
		$directory = get_stylesheet_directory_uri();

		echo sprintf(
			     "<link rel='icon' type='image/x-icon' href='%s/images/favicons/favicon.ico' />",
			     $directory
		     ) . PHP_EOL;

		echo sprintf(
			     "<link rel='shortcut icon' href='%s/images/favicons/favicon.ico' type='image/x-icon'>",
			     $directory
		     ) . PHP_EOL;

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
