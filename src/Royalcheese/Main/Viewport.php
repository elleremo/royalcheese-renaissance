<?php
/**
 * User: vladimir rambo petrozavodsky
 */

namespace Royalcheese\Main;


class Viewport {

	public function __construct() {
		add_action( 'wp_head', [ __CLASS__, 'addViewport' ], 0 );
	}

	public function addViewport(){
		echo "<meta name='viewport' content='width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no'> \r\n";
	}
}
