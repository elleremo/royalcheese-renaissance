<?php get_header(); ?>
	<div id="primary" class="content__area">
		<?php do_action('Royalcheese__theme-content-area-before');?>
		<div class="base__container">
			<?php do_action('Royalcheese__theme-main-before');?>
			<main id="main" class="site__main site__width" role="main">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'templates/grid' );
					endwhile;
				else : ?>
					<?php get_template_part( 'templates/empty' ); ?>
				<?php endif;
				?>
			</main>
			<?php do_action('Royalcheese__theme-main-after');?>
		</div>
		<?php do_action('Royalcheese__theme-content-area-after');?>
	</div>
<?php get_footer(); ?>
