<?php
/**
 * Cardio Theme Customizer
 *
 * @package Cardio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cardio_customize_register( $wp_customize ) {

function cardio_format_for_editor( $text, $default_editor = null ) {
    if ( $text ) {
        $text = htmlspecialchars( $text, ENT_NOQUOTES, get_option( 'blog_charset' ) );
    }
 
    /**
     * Filter the text after it is formatted for the editor.
     *
     * @since 4.3.0
     *
     * @param string $text The formatted text.
     */
    return apply_filters( 'cardio_format_for_editor', $text, $default_editor );
}

//Add a class for titles
    class cardio_info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
			<h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->remove_control('header_textcolor');
	
	$wp_customize->add_section(
        'logo_sec',
        array(
            'title' => __('Logo (PRO Version)', 'cardio'),
            'priority' => 1,
            'description' => __('<strong>Logo Settings available in</strong>','cardio').' <a href="'.esc_url(cardio_pro_theme_url).'" target="_blank">'.__('PRO Version','cardio').'</a>.',
        )
    );  
    $wp_customize->add_setting('cardio_options[font-info]', array(
			'sanitize_callback' => 'sanitize_text_field',
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
        )
    );
    $wp_customize->add_control( new cardio_info( $wp_customize, 'logo_section', array(
        'section' => 'logo_sec',
        'settings' => 'cardio_options[font-info]',
        'priority' => null
        ) )
    );
	
	$wp_customize->add_setting('color_scheme', array(
		'default' => '#e25050',
		'sanitize_callback'	=> 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => __('Color Scheme','cardio'),
			'description'	=> __('<strong>More color options in</strong>','cardio'). '<a href="'.esc_url(cardio_pro_theme_url).'" target="_blank">PRO version</a>',
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	
	$wp_customize->add_section('services_sec',array(
		'title'	=> __('Services Box Sections','cardio'),
		'description'	=> __('Add services box sections code here. More sections available in ','cardio').'<a href="'.esc_url(cardio_pro_theme_url).'" target="_blank">PRO Version</a>',
	));
	
	$wp_customize->add_setting('section1_title',array(
		'default'	=> __('Welcome to Cardio','cardio'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('section1_title',array(
		'label'	=> __('Add section title here','cardio'),
		'section'	=> 'services_sec',
		'type'	=> 'text'
	));
	
	$wp_customize->add_setting('section1',array(
		'default'	=> '<div id="welcome-box">
				<div class="welcome-icon"><i class="fa fa-calendar-o fa-3x"></i></div>
				<h3>strength training</h3><p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p></div><div id="welcome-box"><div class="welcome-icon"><i class="fa fa-heartbeat fa-3x"></i></div><h3>Cardio Fitness</h3><p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p></div><div id="welcome-box"><div class="welcome-icon"><i class="fa fa-bitbucket fa-3x"></i></div><h3>Aquatic</h3><p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p></div><div id="welcome-box"><div class="welcome-icon"><i class="fa fa-users fa-3x"></i></div><h3>Mind & Body</h3><p>Maecenas mattis vitae tellus vel interdum. Quisque lacinia mauris id convallis pretium. Aliquam id odio sit amet mauris porttitor iaculis a eu dui.</p></div>',
		'sanitize_callback'	=> 'cardio_format_for_editor'
	));
	
	$wp_customize->add_control('section1',array(
		'label'	=> __('Add content for section 1','cardio'),
		'section'	=> 'services_sec',
		'setting'	=> 'section1',
		'type'		=> 'textarea'
	));
	
	$wp_customize->add_section('slider_section',array(
		'title'	=> __('Slider Settings','cardio'),
		'description'	=> __('Add slider images here. <br><strong>More slider settings available in</strong>','cardio'). '<a href="'.esc_url(cardio_pro_theme_url).'" target="_blank">PRO version</a>.',
		'priority'		=> null
	));
	
	// Slide Image 1
	$wp_customize->add_setting('slide_image1',array(
		'default'	=> get_template_directory_uri().'/images/slides/slider1.jpg',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'slide_image1',
        array(
            'label' => __('Slide Image 1 (1420x567)','cardio'),
            'section' => 'slider_section',
            'settings' => 'slide_image1'
        )
    )
);

	$wp_customize->add_setting('slide_title1',array(
		'default'	=> __('Welcome to Cardio','cardio'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	
	$wp_customize->add_control('slide_title1',array(
		'label'	=> __('Slide Title 1','cardio'),
		'section'	=> 'slider_section',
		'type'	=> 'text'
	));
	
	$wp_customize->add_setting('slide_desc1',array(
		'default'	=> __('This is description for slider one.','cardio'),
		'sanitize_callback'	=> 'cardio_format_for_editor',
	));
	
	$wp_customize->add_control('slide_desc1',array(
				'label' => __('Slide Description 1','cardio'),
				'section' => 'slider_section',
				'setting'	=> 'slide_desc1',
				'type'	=> 'textarea'
		)
	);
	
	$wp_customize->add_setting('slide_link1',array(
		'default'	=> '#link1',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control('slide_link1',array(
		'label'	=> __('Slide Link 1','cardio'),
		'section'	=> 'slider_section',
		'type'		=> 'text'
	));
	
	// Slide Image 2
	$wp_customize->add_setting('slide_image2',array(
		'default'	=> get_template_directory_uri().'/images/slides/slider2.jpg',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'slide_image2',
        array(
            'label' => __('Slide Image 2 (1420x567)','cardio'),
            'section' => 'slider_section',
            'settings' => 'slide_image2'
        )
    )
);

	$wp_customize->add_setting('slide_title2',array(
		'default'	=> __('Dental care for life','cardio'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	
	$wp_customize->add_control('slide_title2',array(
		'label'	=> __('Slide Title 2','cardio'),
		'section'	=> 'slider_section',
		'type'	=> 'text'
	));
	
	$wp_customize->add_setting('slide_desc2',array(
		'default'	=> __('This is description for slide two','cardio'),
		'sanitize_callback'	=> 'cardio_format_for_editor',
	));
	
	$wp_customize->add_control('slide_desc2',array(
				'label' => __('Slide Description 2','cardio'),
				'section' => 'slider_section',
				'setting'	=> 'slide_desc2',
				'type'		=> 'textarea'
		)
	);
	
	$wp_customize->add_setting('slide_link2',array(
		'default'	=> '#link2',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control('slide_link2',array(
		'label'	=> __('Slide Link 2','cardio'),
		'section'	=> 'slider_section',
		'type'		=> 'text'
	));
	
	// Slide Image 3
	$wp_customize->add_setting('slide_image3',array(
		'default'	=> get_template_directory_uri().'/images/slides/slider3.jpg',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'slide_image3',
        array(
            'label' => __('Slide Image 3 (1420x567)','cardio'),
            'section' => 'slider_section',
            'settings' => 'slide_image3'
        )
    )
);

	$wp_customize->add_setting('slide_title3',array(
		'default'	=> __('Elegant Design','cardio'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	
	$wp_customize->add_control('slide_title3',array(
		'label'	=> __('Slide Title 3','cardio'),
		'section'	=> 'slider_section',
		'type'	=> 'text'
	));
	
	$wp_customize->add_setting('slide_desc3',array(
		'default'	=> __('This is description for slide three','cardio'),
		'sanitize_callback'	=> 'cardio_format_for_editor',
	));
	
	$wp_customize->add_control('slide_desc3',array(
				'label' => __('Slide Description 3','cardio'),
				'section' => 'slider_section',
				'setting'	=> 'slide_desc3',
				'type'		=> 'textarea'
		)
	);
	
	$wp_customize->add_setting('slide_link3',array(
		'default'	=> '#link3',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control('slide_link3',array(
		'label'	=> __('Slide Link 3','cardio'),
		'section'	=> 'slider_section',
		'type'		=> 'text'
	));
	
	$wp_customize->add_section('footer_section',array(
		'title'	=> __('Footer Text','cardio'),
		'description'	=> __('Add some text for footer like copyright etc.','cardio'),
		'priority'	=> null
	));
	
	$wp_customize->add_setting('footer_copy',array(
		'default'	=> __('Cardio 2015 | All Rights Reserved.','cardio'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	
	$wp_customize->add_control('footer_copy',array(
		'label'	=> __('Copyright Text','cardio'),
		'section'	=> 'footer_section',
		'type'		=> 'text'
	));
	
	$wp_customize->add_setting('cardio_options[credit-info]', array(
			'sanitize_callback' => 'sanitize_text_field',
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
        )
    );
    $wp_customize->add_control( new cardio_info( $wp_customize, 'cred_section', array(
        'section' => 'footer_section',
		'label'	=> __('To remove credit link upgrade to pro','cardio'),
        'settings' => 'cardio_options[credit-info]',
        ) )
    );
	
	$wp_customize->add_section(
        'theme_layout_sec',
        array(
            'title' => __('Layout Settings (PRO Version)', 'cardio'),
            'priority' => null,
            'description' => __('<strong>Layout Settings available in</strong>','cardio'). '<a href="'.esc_url(cardio_pro_theme_url).'" target="_blank">'.__('PRO Version','cardio').'</a>.',
        )
    );  
    $wp_customize->add_setting('cardio_options[layout-info]', array(
			'sanitize_callback' => 'sanitize_text_field',
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
        )
    );
    $wp_customize->add_control( new cardio_info( $wp_customize, 'layout_section', array(
        'section' => 'theme_layout_sec',
        'settings' => 'cardio_options[layout-info]',
        'priority' => null
        ) )
    );
	
	$wp_customize->add_section(
        'theme_font_sec',
        array(
            'title' => __('Fonts Settings (PRO Version)', 'cardio'),
            'priority' => null,
            'description' => __('<strong>Font Settings available in</strong>','cardio'). '<a href="'.esc_url(cardio_pro_theme_url).'" target="_blank">'.__('PRO Version','cardio').'</a>.',
        )
    );  
    $wp_customize->add_setting('cardio_options[font-info]', array(
			'sanitize_callback' => 'sanitize_text_field',
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
        )
    );
    $wp_customize->add_control( new cardio_info( $wp_customize, 'font_section', array(
        'section' => 'theme_font_sec',
        'settings' => 'cardio_options[font-info]',
        'priority' => null
        ) )
    );
	
    $wp_customize->add_section(
        'cardio_theme_doc',
        array(
            'title' => __('Documentation &amp; Support', 'cardio'),
            'priority' => null,
            'description' => __('For documentation and support check this link :','cardio'). '<a href="'.esc_url(cardio_theme_doc).'" target="_blank">Cardio Documentation</a>',
        )
    );  
    $wp_customize->add_setting('cardio_options[info]', array(
			'sanitize_callback' => 'sanitize_text_field',
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
        )
    );
    $wp_customize->add_control( new cardio_info( $wp_customize, 'doc_section', array(
        'section' => 'cardio_theme_doc',
        'settings' => 'cardio_options[info]',
        'priority' => 10
        ) )
    );
	
	
}
add_action( 'customize_register', 'cardio_customize_register' );

//Integer
function cardio_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}	

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cardio_customize_preview_js() {
	wp_enqueue_script( 'cardio_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'cardio_customize_preview_js' );

function cardio_css(){
		?>
        <style>
				a, 
				.tm_client strong,
				.postmeta a:hover,
				#sidebar ul li a:hover,
				.blog-post h3.entry-title,
				.woocommerce ul.products li.product .price,
				.top-social a:hover,
				.footer-menu ul li a:hover{
					color:<?php echo esc_html(get_theme_mod('color_scheme','#e25050')); ?>;
				}
				a.blog-more:hover,
				.pagination ul li .current, 
				.pagination ul li a:hover,
				#commentform input#submit,
				input.search-submit,
				.nivo-controlNav a.active,
				.top-right .social-icons a:hover,
				.blog-date .date,
				#appoint,
				#services-box:hover,
				a.read-more:hover,
				.main-nav ul li a:hover,
				#slider .top-bar h2,
				.welcome-icon,
				.entry-content p input[type="submit"]{
					background-color:<?php echo esc_html(get_theme_mod('color_scheme','#e25050')); ?>;
				}
				#welcome-box{
					border:1px solid <?php echo esc_html(get_theme_mod('color_scheme','#e25050')); ?>;
				}
				.top-social a:hover .fa{ border:1px solid <?php echo esc_html(get_theme_mod('color_scheme','#e25050')); ?>;}
				@media screen and (min-width:1025px){
					.main-nav ul li:hover ul{background-color:<?php echo esc_html(get_theme_mod('color_scheme','#e25050')); ?>;}
				}
		</style>
	<?php }
add_action('wp_head','cardio_css');

function cardio_custom_customize_enqueue() {
	wp_enqueue_script( 'cardio-custom-customize', get_template_directory_uri() . '/js/custom.customize.js', array( 'jquery', 'customize-controls' ), false, true );
}
add_action( 'customize_controls_enqueue_scripts', 'cardio_custom_customize_enqueue' );