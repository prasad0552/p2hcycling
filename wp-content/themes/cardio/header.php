 <?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Cardio Care
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
		<div id="header">
            <div class="container">	
                   	<div class="logo">
							<a href="<?php echo home_url('/'); ?>">
									<h1><?php bloginfo('name'); ?></h1>
							</a>
									<p><?php bloginfo('description'); ?></p>
						</div>		
						<div class="toggle">
							<a class="toggleMenu" href="#"><?php _e('Menu','cardio'); ?></a>
						</div> 						
						<div class="main-nav">
							<?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>							
						</div>						
				<div class="clear"></div>
            </div><!--container-->               
		</div><!-- header -->	
			
    <div class="slider-main">
       <?php
			$slideimage = '';
			$slideimage = array(
					'1'	=>	get_template_directory_uri().'/images/slides/slider1.jpg',
					'2'	=>  get_template_directory_uri().'/images/slides/slider2.jpg',
					'3'	=>  get_template_directory_uri().'/images/slides/slider3.jpg',
			);
			$slAr = array();
			$m = 0;
			for ($i=1; $i<4; $i++) {
				if ( get_theme_mod('slide_image'.$i, true) != "" ) {
					$imgSrc 	= esc_url(get_theme_mod('slide_image'.$i, $slideimage[$i]));
					$imgTitle	= esc_attr(get_theme_mod('slide_title'.$i, true));
					$imgDesc	= esc_attr(get_theme_mod('slide_desc'.$i, true));
					$imglink	= esc_url(get_theme_mod('slide_link'.$i, true));
					if ( strlen($imgSrc) > 4 ) {
						$slAr[$m]['image_src'] = esc_url(get_theme_mod('slide_image'.$i, $slideimage[$i]));
						$slAr[$m]['image_title'] = esc_attr(get_theme_mod('slide_title'.$i, true));
						$slAr[$m]['image_desc'] = esc_attr(get_theme_mod('slide_desc'.$i, true));
						$slAr[$m]['image_url'] = esc_url(get_theme_mod('slide_link'.$i, true));
						$m++;
					}
				}
			}
			$slideno = array();
			if( $slAr > 0 ){
				$n = 0;?>
                <div id="slider" class="nivoSlider">
                <?php 
                foreach( $slAr as $sv ){
                    $n++; ?><img src="<?php echo esc_url($sv['image_src']); ?>" alt="<?php echo esc_attr($sv['image_title']);?>" title="<?php if ( ($sv['image_title']!='') && ($sv['image_desc']!='')) { echo '#slidecaption'.$n ; } ?>"/><?php
                    $slideno[] = $n;
                }
                ?>
                </div><?php
                foreach( $slideno as $sln ){ ?>
                    <div id="slidecaption<?php echo $sln; ?>" class="nivo-html-caption">
                    <div class="top-bar">
                        <?php if( get_theme_mod('slide_title'.$sln, true) != '' ){ ?>
                            <h2><?php echo esc_attr(get_theme_mod('slide_title'.$sln, __('Slide Title ','cardio').$sln)); ?></h2>
                        <?php } ?>
                        <?php if( get_theme_mod('slide_desc'.$sln, true) != '' ){ ?>
                            <p><?php echo esc_attr(get_theme_mod('slide_desc'.$sln, __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vitae est at dolor auctor faucibus. Aenean hendrerit lorem eget nisi vulputate,','cardio'))); ?></p>
                        <?php } ?>
						<?php if( get_theme_mod('slide_link'.$sln, true) != ''){ ?>
                        	<a class="read-more" href="<?php echo esc_url(get_theme_mod('slide_link'.$sln,'#')); ?>"><?php _e('Read More','cardio'); ?></a>
                        <?php } ?>
                    </div>
                    </div><?php 
                } ?>
                </div>
                <div class="clear"></div><?php 
			}
            ?>
        </div>
      </div><!-- slider -->


      <div class="main-container">
      <?php if(is_home() || is_front_page()) { ?>
      	<section>
            	<div class="container">
                    <div class="welcome">
                         <h2 class="section-title"><?php echo get_theme_mod('section1_title','Welcome to Cardio'); ?></h2>
                         <?php echo get_theme_mod('section1','<div class="" id="welcome-box">
				<div class="welcome-icon"><i class="fa fa-calendar-o fa-3x"></i></div>
				<h3>strength training</h3>				
				<p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p>
				</div><div class="" id="welcome-box">
				<div class="welcome-icon"><i class="fa fa-heartbeat fa-3x"></i></div>
				<h3>Cardio Fitness</h3>				
				<p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p>
				</div><div class="" id="welcome-box">
				<div class="welcome-icon"><i class="fa fa-bitbucket fa-3x"></i></div>
				<h3>Aquatic</h3>				
				<p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p>
				</div><div class="wellast" id="welcome-box">
				<div class="welcome-icon"><i class="fa fa-users fa-3x"></i></div>
				<h3>Mind &amp; Body</h3>				
				<p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p>
				</div>'); ?>
                     </div><!-- middle-align -->
                    <div class="clear"></div>
                    </div><!-- container -->
            </section>
         <?php } ?>   
            
         <?php if( function_exists('is_woocommerce') && is_woocommerce() ) { ?>
		 	<div class="content-area">
                <div class="middle-align content_sidebar">
                	<div id="sitemain" class="site-main">
         <?php } ?>