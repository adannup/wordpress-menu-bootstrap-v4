<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" >
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	 <title> <?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php  wp_title(); } ?> </title>
</head>
<body>
	<div class="container">

		<?php
			//Funcion para mostrar el menu 
			create_bootstrap_menu('mainmenu');
		?>