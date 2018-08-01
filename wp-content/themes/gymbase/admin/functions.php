<?php
function theme_admin_init()
{
	wp_register_script("theme-colorpicker", get_template_directory_uri() . "/admin/js/colorpicker.js", array("jquery"));
    wp_register_script("theme-jqueryui",   "//code.jquery.com/ui/1.11.4/jquery-ui.js", array("jquery"));
	wp_register_script("theme-admin", get_template_directory_uri() . "/admin/js/theme_admin.js", array("jquery", "colorpicker"));
	wp_register_script("jquery-bqq", get_template_directory_uri() . "/admin/js/jquery.ba-bbq.min.js", array("jquery"));
	wp_register_style("theme-colorpicker", get_template_directory_uri() . "/admin/style/colorpicker.css");
	wp_register_style("theme-admin-style", get_template_directory_uri() . "/admin/style/style.css");
}
add_action("admin_init", "theme_admin_init");

function theme_admin_print_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-bqq');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('theme-jqueryui');
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
    wp_enqueue_style("jquery_ui_css", "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
	wp_enqueue_style("google-font-open-sans", "http://fonts.googleapis.com/css?family=Open+Sans:400,600");
	
	$data = array(
		'img_url' =>  get_template_directory_uri() . "/images/",
		'admin_img_url' =>  get_template_directory_uri() . "/admin/images/"
	);
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-admin", "config", $params);
}

function theme_admin_print_scripts_colorpicker()
{	
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('theme-colorpicker');
	wp_enqueue_style('theme-colorpicker');
}

function theme_admin_print_scripts_all()
{
	wp_enqueue_style('theme-admin-style');
}

function theme_admin_menu_theme_options() 
{
	add_action("admin_print_scripts", "theme_admin_print_scripts_all");
	add_action("admin_print_scripts-post-new.php", "theme_admin_print_scripts");
	add_action("admin_print_scripts-post.php", "theme_admin_print_scripts");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "theme_admin_print_scripts");
	add_action("admin_print_scripts-widgets.php", "theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-post-new.php", "theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-post.php", "theme_admin_print_scripts_colorpicker");
}
add_action("admin_menu", "theme_admin_menu_theme_options");
?>