<?php
/**
 * User: vladimir rambo petrozavodsky
 */

namespace RoyalCheese\Royalcheese\Main;


class bodyClass {

	public function __construct() {
		add_filter( 'body_class', [ $this, 'bodyClass' ] );
	}

	public  function bodyClass( $classes ) {

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

}
