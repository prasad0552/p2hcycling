<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<?php global $theme_options; ?>
	<head>
		<title><?php bloginfo('name'); ?> | <?php is_home() || is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
		<!--meta-->
		<meta charset="<?php bloginfo("charset"); ?>" />
		<meta name="generator" content="WordPress <?php bloginfo("version"); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="description" content="<?php bloginfo('description'); ?>" />
        	<meta name="google-site-verification" content="qbhERsB39ZHXcV-DsGRJSQmgVs9pTOvpvaz00wyTIR4" />
		<!--style-->
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo("rss2_url"); ?>" />
		<link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />
		<?php
		wp_head(); 
		?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
		<?php include("custom_colors.php"); ?>
	</head>
	<body <?php body_class(); ?>>
		<div class="header_container">
			<div class="header clearfix">
				<?php
				if(is_active_sidebar('header-top')):
				?>
				<div class="header_top_sidebar clearfix">
				<?php
				get_sidebar('header-top');
				?>
				</div>
				<?php
				endif;
				?>
				<div class="header_left">
					<a href="<?php echo get_home_url(); ?>" title="<?php bloginfo("name"); ?>">
						<?php if($theme_options["logo_url"]!=""): ?>
						<img src="<?php echo $theme_options["logo_url"]; ?>" alt="logo" />
						<?php endif; ?>
						<?php if($theme_options["logo_first_part_text"]!=""): ?>
						<span class="logo_left"><?php echo $theme_options["logo_first_part_text"]; ?></span>
						<?php 
						endif;
						if($theme_options["logo_second_part_text"]!=""):
						?>
						<span class="logo_right"><?php echo $theme_options["logo_second_part_text"]; ?></span>
						<?php endif; ?>
					</a>
				</div>
				<?php 
				//Get menu object
				$locations = get_nav_menu_locations();
				$main_menu_object = get_term($locations["main-menu"], "nav_menu");
				if(has_nav_menu("main-menu") && $main_menu_object->count>0) 
				{
					wp_nav_menu(array(
						"theme_location" => "main-menu",
						"menu_class" => "sf-menu header_right"
					));
                    
					wp_nav_menu(array(
						'container_class' => 'mobile_menu',
						'theme_location' => 'main-menu', // your theme location here
						'walker'         => new Walker_Nav_Menu_Dropdown(),
						'items_wrap'     => '<select>%3$s</select>',
					));
                    					/*
					<select>
						<option value="-">-</option>
						<?php
						$menu_items = wp_get_nav_menu_items($main_menu_object->term_id);
						print_r($menu_items);
						foreach((array)$menu_items as $key => $menu_item ) 
						{
							?>
							<option value="<?php echo $menu_item->url; ?>"><?php echo $menu_item->title; ?></option>
							<?php
						}
						echo count($menu_items);
						?>
					</select>*/
				}
				?>
			</div>
		</div>
	<!-- /Header -->
