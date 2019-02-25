<!DOCTYPE html >
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<div class="site__wrapper">
	<div class="site__wrap">

		<?php do_action('Royalcheese__theme-header-before');?>
		<header class="site__header">
			<div class="base__container">

				<div class="site__header-content site__width">
					<?php do_action('Royalcheese__theme-header-content-before');?>
					<div class="site__header-logo-wrap">
						<a href="<?php echo home_url(); ?>" class="site__header-logo"></a>
					</div>
					<?php do_action('Royalcheese__theme-header-content-after');?>
				</div>

			</div>
		</header>

<?php do_action('Royalcheese__theme-header-after');?>
