<?php
//admin menu
function theme_admin_menu() 
{
	global $themename;
	add_submenu_page("themes.php", ucfirst('gymbase'), "Theme Options", "edit_theme_options", "ThemeOptions", $themename . "_options");
}
add_action("admin_menu", "theme_admin_menu");

function theme_stripslashes_deep($value)
{
	$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);

	return $value;
}

function gymbase_save_options()
{
	global $themename;
	$theme_options = array(
		"logo_url" => $_POST["logo_url"],
		"logo_first_part_text" => $_POST["logo_first_part_text"],
		"logo_second_part_text" => $_POST["logo_second_part_text"],
		"footer_text_left" => $_POST["footer_text_left"],
		"footer_text_right" => $_POST["footer_text_right"],
		"home_page_top_hint" => $_POST["home_page_top_hint"],
		"responsive" => (int)$_POST["responsive"],
		"slider_image_url" => array_filter($_POST["slider_image_url"]),
		"slider_image_title" => array_filter($_POST["slider_image_title"]),
		"slider_image_subtitle" => array_filter($_POST["slider_image_subtitle"]),
		"slider_image_link" => array_filter($_POST["slider_image_link"]),
		"slider_autoplay" => $_POST["slider_autoplay"],
		"slide_interval" => (int)$_POST["slide_interval"],
		"slider_effect" => $_POST["slider_effect"],
		"slider_transition" => $_POST["slider_transition"],
		"slider_transition_speed" => (int)$_POST["slider_transition_speed"],
		"footer_text_left" => $_POST["footer_text_left"],
		"footer_text_right" => $_POST["footer_text_right"],
		"cf_admin_name" => $_POST["cf_admin_name"],
		"cf_admin_email" => $_POST["cf_admin_email"],
		"cf_smtp_host" => $_POST["cf_smtp_host"],
		"cf_smtp_username" => $_POST["cf_smtp_username"],
		"cf_smtp_password" => $_POST["cf_smtp_password"],
		"cf_smtp_port" => $_POST["cf_smtp_port"],
		"cf_smtp_secure" => $_POST["cf_smtp_secure"],
		"cf_email_subject" => $_POST["cf_email_subject"],
		"cf_template" => $_POST["cf_template"],
		"contact_logo_first_part_text" => $_POST["contact_logo_first_part_text"],
		"contact_logo_second_part_text" => $_POST["contact_logo_second_part_text"],
		"contact_phone" => $_POST["contact_phone"],
		"contact_fax" => $_POST["contact_fax"],
		"contact_email" => $_POST["contact_email"],
		"header_background_color" => $_POST["header_background_color"],
		"body_background_color" => $_POST["body_background_color"],
		"footer_background_color" => $_POST["footer_background_color"],
		"link_color" => $_POST["link_color"],
		"link_hover_color" => $_POST["link_hover_color"],
		"body_headers_color" => $_POST["body_headers_color"],
		"body_headers_border_color" => $_POST["body_headers_border_color"],
		"body_text_color" => $_POST["body_text_color"],
		"body_text2_color" => $_POST["body_text2_color"],
		"footer_headers_color" => $_POST["footer_headers_color"],
		"footer_headers_border_color" => $_POST["footer_headers_border_color"],
		"footer_text_color" => $_POST["footer_text_color"],
		"timeago_label_color" => $_POST["timeago_label_color"],
		"sentence_color" => $_POST["sentence_color"],
		"logo_first_part_text_color" => $_POST["logo_first_part_text_color"],
		"logo_second_part_text_color" => $_POST["logo_second_part_text_color"],
		"body_button_color" => $_POST["body_button_color"],
		"body_button_hover_color" => $_POST["body_button_hover_color"],
		"body_button_border_color" => $_POST["body_button_border_color"],
		"body_button_border_hover_color" => $_POST["body_button_border_hover_color"],
		"footer_button_color" => $_POST["footer_button_color"],
		"footer_button_hover_color" => $_POST["footer_button_hover_color"],
		"footer_button_border_color" => $_POST["footer_button_border_color"],
		"footer_button_border_hover_color" => $_POST["footer_button_border_hover_color"],
		"menu_link_color" => $_POST["menu_link_color"],
		"menu_link_border_color" => $_POST["menu_link_border_color"],
		"menu_active_color" => $_POST["menu_active_color"],
		"menu_active_border_color" => $_POST["menu_active_border_color"],
		"menu_hover_color" => $_POST["menu_hover_color"],
		"menu_hover_border_color" => $_POST["menu_hover_border_color"],
		"submenu_background_color" => $_POST["submenu_background_color"],
		"submenu_hover_background_color" => $_POST["submenu_hover_background_color"],
		"submenu_color" => $_POST["submenu_color"],
		"submenu_hover_color" => $_POST["submenu_hover_color"],
		"form_hint_color" => $_POST["form_hint_color"],
		"form_field_text_color" => $_POST["form_field_text_color"],
		"form_field_border_color" => $_POST["form_field_border_color"],
		"form_field_active_border_color" => $_POST["form_field_active_border_color"],
		"date_box_color" => $_POST["date_box_color"],
		"date_box_text_color" => $_POST["date_box_text_color"],
		"date_box_comments_number_text_color" => $_POST["date_box_comments_number_text_color"],
		"date_box_comments_number_border_color" => $_POST["date_box_comments_number_border_color"],
		"date_box_comments_number_hover_border_color" => $_POST["date_box_comments_number_hover_border_color"],
		"gallery_box_color" => $_POST["gallery_box_color"],
		"gallery_box_text_first_line_color" => $_POST["gallery_box_text_first_line_color"],
		"gallery_box_text_second_line_color" => $_POST["gallery_box_text_second_line_color"],
		"gallery_box_hover_color" => $_POST["gallery_box_hover_color"],
		"gallery_box_hover_text_first_line_color" => $_POST["gallery_box_hover_text_first_line_color"],
		"gallery_box_hover_text_second_line_color" => $_POST["gallery_box_hover_text_second_line_color"],
		"timetable_box_color" => $_POST["timetable_box_color"],
		"timetable_box_hover_color" => $_POST["timetable_box_hover_color"],
		"gallery_details_box_border_color" => $_POST["gallery_details_box_border_color"],
		"bread_crumb_border_color" => $_POST["bread_crumb_border_color"],
		"accordion_item_border_color" => $_POST["accordion_item_border_color"],
		"accordion_item_border_hover_color" => $_POST["accordion_item_border_hover_color"],
		"accordion_item_border_active_color" => $_POST["accordion_item_border_active_color"],
		"copyright_area_border_color" => $_POST["copyright_area_border_color"],
		"top_hint_background_color" => $_POST["top_hint_background_color"],
		"top_hint_text_color" => $_POST["top_hint_text_color"],
		"comment_reply_button_color" => $_POST["comment_reply_button_color"],
		"post_author_link_color" => $_POST["post_author_link_color"],
		"contact_details_box_background_color" => $_POST["contact_details_box_background_color"],
		"header_font" => $_POST["header_font"],
		"subheader_font" => $_POST["subheader_font"]
	);
	update_option($themename . "_options", $theme_options);
	echo json_encode($_POST);
	exit();
}
add_action('wp_ajax_' . $themename . '_save', $themename . '_save_options');

function gymbase_options() 
{
	global $themename;
	if($_POST["action"]==$themename . "_save")
	{
		$theme_options = (array)get_option($themename . "_options");
		if($_POST[$themename . "_submit"]=="Save Main Options")
		{
			$theme_options_main = array(
				"logo_url" => $_POST["logo_url"],
				"logo_first_part_text" => $_POST["logo_first_part_text"],
				"logo_second_part_text" => $_POST["logo_second_part_text"],
				"footer_text_left" => $_POST["footer_text_left"],
				"footer_text_right" => $_POST["footer_text_right"],
				"home_page_top_hint" => $_POST["home_page_top_hint"],
				"responsive" => (int)$_POST["responsive"]
			);
			update_option($themename . "_options", array_merge($theme_options, $theme_options_main));
			$selected_tab = 0;
		}
		else if($_POST[$themename . "_submit"]=="Save Slider Options")
		{
			$theme_options_backgrounds = array(
				"slider_image_url" => array_filter($_POST["slider_image_url"]),
				"slider_image_title" => array_filter($_POST["slider_image_title"]),
				"slider_image_subtitle" => array_filter($_POST["slider_image_subtitle"]),
				"slider_image_link" => array_filter($_POST["slider_image_link"]),
				"slider_autoplay" => $_POST["slider_autoplay"],
				"slide_interval" => (int)$_POST["slide_interval"],
				"slider_effect" => $_POST["slider_effect"],
				"slider_transition" => $_POST["slider_transition"],
				"slider_transition_speed" => (int)$_POST["slider_transition_speed"]
			);
			update_option($themename . "_options", array_merge($theme_options, $theme_options_backgrounds));
			$selected_tab = 1;
		}
		else if($_POST[$themename . "_submit"]=="Save Contact Form Options")
		{
			$theme_options_contact_form = array(
				"cf_admin_name" => $_POST["cf_admin_name"],
				"cf_admin_email" => $_POST["cf_admin_email"],
				"cf_smtp_host" => $_POST["cf_smtp_host"],
				"cf_smtp_username" => $_POST["cf_smtp_username"],
				"cf_smtp_password" => $_POST["cf_smtp_password"],
				"cf_smtp_port" => $_POST["cf_smtp_port"],
				"cf_smtp_secure" => $_POST["cf_smtp_secure"],
				"cf_email_subject" => $_POST["cf_email_subject"],
				"cf_template" => $_POST["cf_template"]
			);
			update_option($themename . "_options", array_merge($theme_options, $theme_options_contact_form));
			$selected_tab = 2;
		}
		else if($_POST[$themename . "_submit"]=="Save Contact Details Options")
		{
			$theme_options_contact_details = array(
				"contact_logo_first_part_text" => $_POST["contact_logo_first_part_text"],
				"contact_logo_second_part_text" => $_POST["contact_logo_second_part_text"],
				"contact_phone" => $_POST["contact_phone"],
				"contact_fax" => $_POST["contact_fax"],
				"contact_email" => $_POST["contact_email"]
			);
			update_option($themename . "_options", array_merge($theme_options, $theme_options_contact_details));
			$selected_tab = 3;
		}
		else if($_POST[$themename . "_submit"]=="Save Colors Options")
		{
			$theme_options_colors = array(
				"header_background_color" => $_POST["header_background_color"],
				"body_background_color" => $_POST["body_background_color"],
				"footer_background_color" => $_POST["footer_background_color"],
				"link_color" => $_POST["link_color"],
				"link_hover_color" => $_POST["link_hover_color"],
				"body_headers_color" => $_POST["body_headers_color"],
				"body_headers_border_color" => $_POST["body_headers_border_color"],
				"body_text_color" => $_POST["body_text_color"],
				"body_text2_color" => $_POST["body_text2_color"],
				"footer_headers_color" => $_POST["footer_headers_color"],
				"footer_headers_border_color" => $_POST["footer_headers_border_color"],
				"footer_text_color" => $_POST["footer_text_color"],
				"timeago_label_color" => $_POST["timeago_label_color"],
				"sentence_color" => $_POST["sentence_color"],
				"logo_first_part_text_color" => $_POST["logo_first_part_text_color"],
				"logo_second_part_text_color" => $_POST["logo_second_part_text_color"],
				"body_button_color" => $_POST["body_button_color"],
				"body_button_hover_color" => $_POST["body_button_hover_color"],
				"body_button_border_color" => $_POST["body_button_border_color"],
				"body_button_border_hover_color" => $_POST["body_button_border_hover_color"],
				"footer_button_color" => $_POST["footer_button_color"],
				"footer_button_hover_color" => $_POST["footer_button_hover_color"],
				"footer_button_border_color" => $_POST["footer_button_border_color"],
				"footer_button_border_hover_color" => $_POST["footer_button_border_hover_color"],
				"menu_link_color" => $_POST["menu_link_color"],
				"menu_link_border_color" => $_POST["menu_link_border_color"],
				"menu_active_color" => $_POST["menu_active_color"],
				"menu_active_border_color" => $_POST["menu_active_border_color"],
				"menu_hover_color" => $_POST["menu_hover_color"],
				"menu_hover_border_color" => $_POST["menu_hover_border_color"],
				"submenu_background_color" => $_POST["submenu_background_color"],
				"submenu_hover_background_color" => $_POST["submenu_hover_background_color"],
				"submenu_color" => $_POST["submenu_color"],
				"submenu_hover_color" => $_POST["submenu_hover_color"],
				"form_hint_color" => $_POST["form_hint_color"],
				"form_field_text_color" => $_POST["form_field_text_color"],
				"form_field_border_color" => $_POST["form_field_border_color"],
				"form_field_active_border_color" => $_POST["form_field_active_border_color"],
				"date_box_color" => $_POST["date_box_color"],
				"date_box_text_color" => $_POST["date_box_text_color"],
				"date_box_comments_number_text_color" => $_POST["date_box_comments_number_text_color"],
				"date_box_comments_number_border_color" => $_POST["date_box_comments_number_border_color"],
				"date_box_comments_number_hover_border_color" => $_POST["date_box_comments_number_hover_border_color"],
				"gallery_box_color" => $_POST["gallery_box_color"],
				"gallery_box_text_first_line_color" => $_POST["gallery_box_text_first_line_color"],
				"gallery_box_text_second_line_color" => $_POST["gallery_box_text_second_line_color"],
				"gallery_box_hover_color" => $_POST["gallery_box_hover_color"],
				"gallery_box_hover_text_first_line_color" => $_POST["gallery_box_hover_text_first_line_color"],
				"gallery_box_hover_text_second_line_color" => $_POST["gallery_box_hover_text_second_line_color"],
				"timetable_box_color" => $_POST["timetable_box_color"],
				"timetable_box_hover_color" => $_POST["timetable_box_hover_color"],
				"gallery_details_box_border_color" => $_POST["gallery_details_box_border_color"],
				"bread_crumb_border_color" => $_POST["bread_crumb_border_color"],
				"accordion_item_border_color" => $_POST["accordion_item_border_color"],
				"accordion_item_border_hover_color" => $_POST["accordion_item_border_hover_color"],
				"accordion_item_border_active_color" => $_POST["accordion_item_border_active_color"],
				"copyright_area_border_color" => $_POST["copyright_area_border_color"],
				"top_hint_background_color" => $_POST["top_hint_background_color"],
				"top_hint_text_color" => $_POST["top_hint_text_color"],
				"comment_reply_button_color" => $_POST["comment_reply_button_color"],
				"post_author_link_color" => $_POST["post_author_link_color"],
				"contact_details_box_background_color" => $_POST["contact_details_box_background_color"]
			);
			update_option($themename . "_options", array_merge($theme_options, $theme_options_colors));
			$selected_tab = 4;
		}
		else if($_POST[$themename . "_submit"]=="Save Fonts Options")
		{
			$theme_options_fonts = array(
				"header_font" => $_POST["header_font"],
				"subheader_font" => $_POST["subheader_font"]
			);
			update_option($themename . "_options", array_merge($theme_options, $theme_options_fonts));
			$selected_tab = 5;
		}
		else
		{
			$theme_options = array(
				"logo_url" => $_POST["logo_url"],
				"logo_first_part_text" => $_POST["logo_first_part_text"],
				"logo_second_part_text" => $_POST["logo_second_part_text"],
				"footer_text_left" => $_POST["footer_text_left"],
				"footer_text_right" => $_POST["footer_text_right"],
				"home_page_top_hint" => $_POST["home_page_top_hint"],
				"responsive" => (int)$_POST["responsive"],
				"slider_image_url" => array_filter($_POST["slider_image_url"]),
				"slider_image_title" => array_filter($_POST["slider_image_title"]),
				"slider_image_subtitle" => array_filter($_POST["slider_image_subtitle"]),
				"slider_image_link" => array_filter($_POST["slider_image_link"]),
				"slider_autoplay" => $_POST["slider_autoplay"],
				"slide_interval" => (int)$_POST["slide_interval"],
				"slider_effect" => $_POST["slider_effect"],
				"slider_transition" => $_POST["slider_transition"],
				"slider_transition_speed" => (int)$_POST["slider_transition_speed"],
				"footer_text_left" => $_POST["footer_text_left"],
				"footer_text_right" => $_POST["footer_text_right"],
				"cf_admin_name" => $_POST["cf_admin_name"],
				"cf_admin_email" => $_POST["cf_admin_email"],
				"cf_smtp_host" => $_POST["cf_smtp_host"],
				"cf_smtp_username" => $_POST["cf_smtp_username"],
				"cf_smtp_password" => $_POST["cf_smtp_password"],
				"cf_smtp_port" => $_POST["cf_smtp_port"],
				"cf_smtp_secure" => $_POST["cf_smtp_secure"],
				"cf_email_subject" => $_POST["cf_email_subject"],
				"cf_template" => $_POST["cf_template"],
				"contact_logo_first_part_text" => $_POST["contact_logo_first_part_text"],
				"contact_logo_second_part_text" => $_POST["contact_logo_second_part_text"],
				"contact_phone" => $_POST["contact_phone"],
				"contact_fax" => $_POST["contact_fax"],
				"contact_email" => $_POST["contact_email"],
				"header_background_color" => $_POST["header_background_color"],
				"body_background_color" => $_POST["body_background_color"],
				"footer_background_color" => $_POST["footer_background_color"],
				"link_color" => $_POST["link_color"],
				"link_hover_color" => $_POST["link_hover_color"],
				"body_headers_color" => $_POST["body_headers_color"],
				"body_headers_border_color" => $_POST["body_headers_border_color"],
				"body_text_color" => $_POST["body_text_color"],
				"body_text2_color" => $_POST["body_text2_color"],
				"footer_headers_color" => $_POST["footer_headers_color"],
				"footer_headers_border_color" => $_POST["footer_headers_border_color"],
				"footer_text_color" => $_POST["footer_text_color"],
				"timeago_label_color" => $_POST["timeago_label_color"],
				"sentence_color" => $_POST["sentence_color"],
				"logo_first_part_text_color" => $_POST["logo_first_part_text_color"],
				"logo_second_part_text_color" => $_POST["logo_second_part_text_color"],
				"body_button_color" => $_POST["body_button_color"],
				"body_button_hover_color" => $_POST["body_button_hover_color"],
				"body_button_border_color" => $_POST["body_button_border_color"],
				"body_button_border_hover_color" => $_POST["body_button_border_hover_color"],
				"footer_button_color" => $_POST["footer_button_color"],
				"footer_button_hover_color" => $_POST["footer_button_hover_color"],
				"footer_button_border_color" => $_POST["footer_button_border_color"],
				"footer_button_border_hover_color" => $_POST["footer_button_border_hover_color"],
				"menu_link_color" => $_POST["menu_link_color"],
				"menu_link_border_color" => $_POST["menu_link_border_color"],
				"menu_active_color" => $_POST["menu_active_color"],
				"menu_active_border_color" => $_POST["menu_active_border_color"],
				"menu_hover_color" => $_POST["menu_hover_color"],
				"menu_hover_border_color" => $_POST["menu_hover_border_color"],
				"submenu_background_color" => $_POST["submenu_background_color"],
				"submenu_hover_background_color" => $_POST["submenu_hover_background_color"],
				"submenu_color" => $_POST["submenu_color"],
				"submenu_hover_color" => $_POST["submenu_hover_color"],
				"form_hint_color" => $_POST["form_hint_color"],
				"form_field_text_color" => $_POST["form_field_text_color"],
				"form_field_border_color" => $_POST["form_field_border_color"],
				"form_field_active_border_color" => $_POST["form_field_active_border_color"],
				"date_box_color" => $_POST["date_box_color"],
				"date_box_text_color" => $_POST["date_box_text_color"],
				"date_box_comments_number_text_color" => $_POST["date_box_comments_number_text_color"],
				"date_box_comments_number_border_color" => $_POST["date_box_comments_number_border_color"],
				"date_box_comments_number_hover_border_color" => $_POST["date_box_comments_number_hover_border_color"],
				"gallery_box_text_first_line_color" => $_POST["gallery_box_text_first_line_color"],
				"gallery_box_text_second_line_color" => $_POST["gallery_box_text_second_line_color"],
				"gallery_box_hover_color" => $_POST["gallery_box_hover_color"],
				"gallery_box_hover_text_first_line_color" => $_POST["gallery_box_hover_text_first_line_color"],
				"gallery_box_hover_text_second_line_color" => $_POST["gallery_box_hover_text_second_line_color"],
				"timetable_box_color" => $_POST["timetable_box_color"],
				"timetable_box_hover_color" => $_POST["timetable_box_hover_color"],
				"gallery_details_box_border_color" => $_POST["gallery_details_box_border_color"],
				"bread_crumb_border_color" => $_POST["bread_crumb_border_color"],
				"accordion_item_border_color" => $_POST["accordion_item_border_color"],
				"accordion_item_border_hover_color" => $_POST["accordion_item_border_hover_color"],
				"accordion_item_border_active_color" => $_POST["accordion_item_border_active_color"],
				"copyright_area_border_color" => $_POST["copyright_area_border_color"],
				"top_hint_background_color" => $_POST["top_hint_background_color"],
				"top_hint_text_color" => $_POST["top_hint_text_color"],
				"comment_reply_button_color" => $_POST["comment_reply_button_color"],
				"post_author_link_color" => $_POST["post_author_link_color"],
				"contact_details_box_background_color" => $_POST["contact_details_box_background_color"],
				"header_font" => $_POST["header_font"],
				"subheader_font" => $_POST["subheader_font"]
			);
			update_option($themename . "_options", $theme_options);
			$selected_tab = 0;
		}
	}
	$theme_options = theme_stripslashes_deep(get_option($themename . "_options"));
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2><?php echo ucfirst('gymbase');?> Options</h2>
	</div>
	<?php 
	if($_POST["action"]==$themename . "_save")
	{
	?>
	<div class="updated"> 
		<p>
			<strong>
				<?php _e('Options saved', 'gymbase'); ?>
			</strong>
		</p>
	</div>
	<?php
	}
	//get google fonts
	$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB4_VClnbxilxqjZd7NbysoHwAXX1ZGdKQ';
	$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
	$fontsArray = json_decode($fontsJson);

	//$fontsJson = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB4_VClnbxilxqjZd7NbysoHwAXX1ZGdKQ');
	//$fontsArray = json_decode($fontsJson);
	?>
	<form class="theme_options" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="theme-options-panel">
		<div class="header">
			<div class="header_left">
				<h3>
					<a href="http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs" title="QuanticaLabs">
						QuanticaLabs
					</a>
				</h3>
				<h5>Theme Options</h5>
			</div>
			<div class="header_right">
				<div class="description">
					<h3>
						<a href="http://themeforest.net/item/gymbase-responsive-gym-fitness-wordpress-theme/2732248?ref=quanticalabs" title="GymBase - Responsive Gym Fitness WordPress Theme">
							Gymbase
						</a>
					</h3>
					<h5>Responsive Gym Fitness WordPress Theme</h5>
				</div>
				<a class="logo" href="http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs" title="QuanticaLabs">
					&nbsp;
				</a>
			</div>
		</div>
		<div class="content clearfix">
			<ul class="menu">
				<li>
					<a href='#tab-main' class="selected">
						<?php _e('Main', 'gymbase'); ?>
						<span class="general"></span>
					</a>
				</li>
				<li>
					<a href="#tab-slider">
						<?php _e('Slider', 'gymbase'); ?>
						<span class="plugin"></span>
					</a>
				</li>
				<li>
					<a href="#tab-contact-form">
						<?php _e('Contact Form', 'gymbase'); ?>
						<span class="plugin"></span>
					</a>
				</li>
				<li>
					<a href="#tab-contact-details">
						<?php _e('Contact Details', 'gymbase'); ?>
						<span class="plugin"></span>
					</a>
				</li>
				<li>
					<a href="#tab-colors">
						<?php _e('Colors', 'gymbase'); ?>
						<span class="general"></span>
					</a>
					<ul class="submenu">
						<li>
							<a href="#tab-colors_general">
								<?php _e('General', 'gymbase'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_text">
								<?php _e('Text', 'gymbase'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_buttons">
								<?php _e('Buttons', 'gymbase'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_menu">
								<?php _e('Menu', 'gymbase'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_forms">
								<?php _e('Forms', 'gymbase'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_miscellaneous">
								<?php _e('Miscellaneous', 'gymbase'); ?>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#tab-fonts">
						<?php _e('Fonts', 'gymbase'); ?>
						<span class="font"></span>
					</a>
				</li>
			</ul>
			<div id="tab-main" class="settings" style="display: block;">
				<h3><?php _e('Main', 'gymbase'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="logo_url"><?php _e('LOGO URL', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_url"]); ?>" id="logo_url" name="logo_url">
							<input type="button" class="button" name="<?php echo $themename;?>_upload_button" id="logo_url_upload_button" value="<?php _e('Insert logo', 'gymbase'); ?>" />
						</div>
					</li>
					<li>
						<label for="logo_first_part_text"><?php _e('LOGO FIRST PART TEXT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_first_part_text"]); ?>" id="logo_first_part_text" name="logo_first_part_text">
						</div>
					</li>
					<li>
						<label for="logo_second_part_text"><?php _e('LOGO SECOND PART TEXT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_second_part_text"]); ?>" id="logo_second_part_text" name="logo_second_part_text">
						</div>
					</li>
					<li>
						<label for="footer_text_left"><?php _e('FOOTER TEXT LEFT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["footer_text_left"]); ?>" id="footer_text_left" name="footer_text_left">
						</div>
					</li>
					<li>
						<label for="footer_text_right"><?php _e('FOOTER TEXT RIGHT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["footer_text_right"]); ?>" id="footer_text_right" name="footer_text_right">
						</div>
					</li>
					<li>
						<label for="home_page_top_hint"><?php _e('HOME PAGE TOP HINT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["home_page_top_hint"]); ?>" id="home_page_top_hint" name="home_page_top_hint">
						</div>
					</li>
					<li>
						<label for="responsive"><?php _e('RESPONSIVE', 'gymbase'); ?></label>
						<div>
							<select id="responsive" name="responsive">
								<option value="1"<?php echo ((int)$theme_options["responsive"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'gymbase'); ?></option>
								<option value="0"<?php echo ((int)$theme_options["responsive"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'gymbase'); ?></option>
							</select>
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-slider" class="settings">
				<h3><?php _e('Slider', 'gymbase'); ?></h3>
				<ul class="form_field_list">
					<?php
					$slides_count = count($theme_options["slider_image_url"]);
					if($slides_count==0)
						$slides_count = 3;
					for($i=0; $i<$slides_count; $i++)
					{
					?>
					<li class="slider_image_url_row">
						<label><?php _e('SLIDER IMAGE URL', 'gymbase'); echo " " . ($i+1); ?></label>
						<div>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_url_<?php echo ($i+1); ?>" name="slider_image_url[]" value="<?php echo esc_attr($theme_options["slider_image_url"][$i]); ?>" />
							<input type="button" class="button" name="<?php echo $themename;?>_upload_button" id="<?php echo $themename;?>_slider_image_url_button_<?php echo ($i+1); ?>" value="<?php _e('Browse', 'gymbase'); ?>" />
						</div>
					</li>
					<li class="slider_image_title_row">
						<label><?php _e('SLIDER IMAGE TITLE', 'gymbase'); echo " " . ($i+1); ?></label>
						<div>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_title_<?php echo ($i+1); ?>" name="slider_image_title[]" value="<?php echo esc_attr($theme_options["slider_image_title"][$i]); ?>" />
						</div>
					</li>
					<li class="slider_image_subtitle_row">
						<label><?php _e('SLIDER IMAGE SUBTITLE', 'gymbase'); echo " " . ($i+1); ?></label>
						<div>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_subtitle_<?php echo ($i+1); ?>" name="slider_image_subtitle[]" value="<?php echo esc_attr($theme_options["slider_image_subtitle"][$i]); ?>" />
						</div>
					</li>
					<li class="slider_image_link_row">
						<label><?php _e('SLIDER IMAGE LINK', 'gymbase'); echo " " . ($i+1); ?></label>
						<div>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_link_<?php echo ($i+1); ?>" name="slider_image_link[]" value="<?php echo esc_attr($theme_options["slider_image_link"][$i]); ?>" />
						</div>
					</li>
					<?php
					}
					?>
					<li>
						<input type="button" class="button" name="<?php echo $themename;?>_add_new_button" id="<?php echo $themename;?>_add_new_button" value="<?php _e('Add slider image', 'gymbase'); ?>" />
					</li>
					<li>
						<label><?php _e('AUTOPLAY', 'gymbase'); ?></label>
						<div>
							<select id="slider_autoplay" name="slider_autoplay">
								<option value="true"<?php echo ($theme_options["slider_autoplay"]=="true" ? " selected='selected'" : "") ?>><?php _e('yes', 'gymbase'); ?></option>
								<option value="false"<?php echo ($theme_options["slider_autoplay"]=="false" ? " selected='selected'" : "") ?>><?php _e('no', 'gymbase'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="slide_interval"><?php _e('SLIDE INTERVAL:', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" id="slide_interval" name="slide_interval" value="<?php echo (int)esc_attr($theme_options["slide_interval"]); ?>" />
						</div>
					</li>
					<li>
						<label for="slider_effect"><?php _e('EFFECT:', 'gymbase'); ?></label>
						<div>
							<select id="slider_effect" name="slider_effect">
								<option value="scroll"<?php echo ($theme_options["slider_effect"]=="scroll" ? " selected='selected'" : "") ?>><?php _e('scroll', 'gymbase'); ?></option>
								<option value="none"<?php echo ($theme_options["slider_effect"]=="none" ? " selected='selected'" : "") ?>><?php _e('none', 'gymbase'); ?></option>
								<option value="directscroll"<?php echo ($theme_options["slider_effect"]=="directscroll" ? " selected='selected'" : "") ?>><?php _e('directscroll', 'gymbase'); ?></option>
								<option value="fade"<?php echo ($theme_options["slider_effect"]=="fade" ? " selected='selected'" : "") ?>><?php _e('fade', 'gymbase'); ?></option>
								<option value="crossfade"<?php echo ($theme_options["slider_effect"]=="crossfade" ? " selected='selected'" : "") ?>><?php _e('crossfade', 'gymbase'); ?></option>
								<option value="cover"<?php echo ($theme_options["slider_effect"]=="cover" ? " selected='selected'" : "") ?>><?php _e('cover', 'gymbase'); ?></option>
								<option value="uncover"<?php echo ($theme_options["slider_effect"]=="uncover" ? " selected='selected'" : "") ?>><?php _e('uncover', 'gymbase'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="slider_transition"><?php _e('TRANSITION:', 'gymbase'); ?></label>
						<div>
							<select id="slider_transition" name="slider_transition">
								<option value="swing"<?php echo ($theme_options["slider_transition"]=="swing" ? " selected='selected'" : "") ?>><?php _e('swing', 'gymbase'); ?></option>
								<option value="linear"<?php echo ($theme_options["slider_transition"]=="linear" ? " selected='selected'" : "") ?>><?php _e('linear', 'gymbase'); ?></option>
								<option value="easeInQuad"<?php echo ($theme_options["slider_transition"]=="easeInQuad" ? " selected='selected'" : "") ?>><?php _e('easeInQuad', 'gymbase'); ?></option>
								<option value="easeOutQuad"<?php echo ($theme_options["slider_transition"]=="easeOutQuad" ? " selected='selected'" : "") ?>><?php _e('easeOutQuad', 'gymbase'); ?></option>
								<option value="easeInOutQuad"<?php echo ($theme_options["slider_transition"]=="easeInOutQuad" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuad', 'gymbase'); ?></option>
								<option value="easeInCubic"<?php echo ($theme_options["slider_transition"]=="easeInCubic" ? " selected='selected'" : "") ?>><?php _e('easeInCubic', 'gymbase'); ?></option>
								<option value="easeOutCubic"<?php echo ($theme_options["slider_transition"]=="easeOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeOutCubic', 'gymbase'); ?></option>
								<option value="easeInOutCubic"<?php echo ($theme_options["slider_transition"]=="easeInOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeInOutCubic', 'gymbase'); ?></option>
								<option value="easeInOutCubic"<?php echo ($theme_options["slider_transition"]=="easeInOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeInOutCubic', 'gymbase'); ?></option>
								<option value="easeInQuart"<?php echo ($theme_options["slider_transition"]=="easeInQuart" ? " selected='selected'" : "") ?>><?php _e('easeInQuart', 'gymbase'); ?></option>
								<option value="easeOutQuart"<?php echo ($theme_options["slider_transition"]=="easeOutQuart" ? " selected='selected'" : "") ?>><?php _e('easeOutQuart', 'gymbase'); ?></option>
								<option value="easeInOutQuart"<?php echo ($theme_options["slider_transition"]=="easeInOutQuart" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuart', 'gymbase'); ?></option>
								<option value="easeInSine"<?php echo ($theme_options["slider_transition"]=="easeInSine" ? " selected='selected'" : "") ?>><?php _e('easeInSine', 'gymbase'); ?></option>
								<option value="easeOutSine"<?php echo ($theme_options["slider_transition"]=="easeOutSine" ? " selected='selected'" : "") ?>><?php _e('easeOutSine', 'gymbase'); ?></option>
								<option value="easeInOutSine"<?php echo ($theme_options["slider_transition"]=="easeInOutSine" ? " selected='selected'" : "") ?>><?php _e('easeInOutSine', 'gymbase'); ?></option>
								<option value="easeInExpo"<?php echo ($theme_options["slider_transition"]=="easeInExpo" ? " selected='selected'" : "") ?>><?php _e('easeInExpo', 'gymbase'); ?></option>
								<option value="easeOutExpo"<?php echo ($theme_options["slider_transition"]=="easeOutExpo" ? " selected='selected'" : "") ?>><?php _e('easeOutExpo', 'gymbase'); ?></option>
								<option value="easeInOutExpo"<?php echo ($theme_options["slider_transition"]=="easeInOutExpo" ? " selected='selected'" : "") ?>><?php _e('easeInOutExpo', 'gymbase'); ?></option>
								<option value="easeInQuint"<?php echo ($theme_options["slider_transition"]=="easeInQuint" ? " selected='selected'" : "") ?>><?php _e('easeInQuint', 'gymbase'); ?></option>
								<option value="easeOutQuint"<?php echo ($theme_options["slider_transition"]=="easeOutQuint" ? " selected='selected'" : "") ?>><?php _e('easeOutQuint', 'gymbase'); ?></option>
								<option value="easeInOutQuint"<?php echo ($theme_options["slider_transition"]=="easeInOutQuint" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuint', 'gymbase'); ?></option>
								<option value="easeInCirc"<?php echo ($theme_options["slider_transition"]=="easeInCirc" ? " selected='selected'" : "") ?>><?php _e('easeInCirc', 'gymbase'); ?></option>
								<option value="easeOutCirc"<?php echo ($theme_options["slider_transition"]=="easeOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeOutCirc', 'gymbase'); ?></option>
								<option value="easeInOutCirc"<?php echo ($theme_options["slider_transition"]=="easeInOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeInOutCirc', 'gymbase'); ?></option>
								<option value="easeInElastic"<?php echo ($theme_options["slider_transition"]=="easeInElastic" ? " selected='selected'" : "") ?>><?php _e('easeInElastic', 'gymbase'); ?></option>
								<option value="easeOutElastic"<?php echo ($theme_options["slider_transition"]=="easeOutElastic" ? " selected='selected'" : "") ?>><?php _e('easeOutElastic', 'gymbase'); ?></option>
								<option value="easeInOutElastic"<?php echo ($theme_options["slider_transition"]=="easeInOutElastic" ? " selected='selected'" : "") ?>><?php _e('easeInOutElastic', 'gymbase'); ?></option>
								<option value="easeInBack"<?php echo ($theme_options["slider_transition"]=="easeInBack" ? " selected='selected'" : "") ?>><?php _e('easeInBack', 'gymbase'); ?></option>
								<option value="easeOutBack"<?php echo ($theme_options["slider_transition"]=="easeOutBack" ? " selected='selected'" : "") ?>><?php _e('easeOutBack', 'gymbase'); ?></option>
								<option value="easeInOutBack"<?php echo ($theme_options["slider_transition"]=="easeOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeInOutBack', 'gymbase'); ?></option>
								<option value="easeInBounce"<?php echo ($theme_options["slider_transition"]=="easeInBounce" ? " selected='selected'" : "") ?>><?php _e('easeInBounce', 'gymbase'); ?></option>
								<option value="easeOutBounce"<?php echo ($theme_options["slider_transition"]=="easeOutBounce" ? " selected='selected'" : "") ?>><?php _e('easeOutBounce', 'gymbase'); ?></option>
								<option value="easeInOutBounce"<?php echo ($theme_options["slider_transition"]=="easeInOutBounce" ? " selected='selected'" : "") ?>><?php _e('easeInOutBounce', 'gymbase'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="slider_transition_speed"><?php _e('TRANSITION SPEED:', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" id="slider_transition_speed" name="slider_transition_speed" value="<?php echo (int)esc_attr($theme_options["slider_transition_speed"]); ?>" />
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-contact-form" class="settings">
				<h3><?php _e('Contact Form', 'gymbase'); ?></h3>
				<h4><?php _e('ADMIN EMAIL CONFIG', 'gymbase');	?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_admin_name"><?php _e('NAME', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_name"]); ?>" id="cf_admin_name" name="cf_admin_name">
						</div>
					</li>
					<li>
						<label for="cf_admin_email"><?php _e('EMAIL', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_email"]); ?>" id="cf_admin_email" name="cf_admin_email">
						</div>
					</li>
				</ul>
				<h4><?php _e('ADMIN SMTP CONFIG (OPTIONAL)', 'gymbase'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_smtp_host"><?php _e('HOST', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_host"]); ?>" id="cf_smtp_host" name="cf_smtp_host">
						</div>
					</li>
					<li>
						<label for="cf_smtp_username"><?php _e('USERNAME', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_username"]); ?>" id="cf_smtp_username" name="cf_smtp_username">
						</div>
					</li>
					<li>
						<label for="cf_smtp_password"><?php _e('PASSWORD', 'gymbase'); ?></label>
						<div>
							<input type="password" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_password"]); ?>" id="cf_smtp_password" name="cf_smtp_password">
						</div>
					</li>
					<li>
						<label for="cf_smtp_port"><?php _e('PORT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_port"]); ?>" id="cf_smtp_port" name="cf_smtp_port">
						</div>
					</li>
					<li>
						<label for="cf_smtp_secure"><?php _e('SMTP SECURE', 'gymbase'); ?></label>
						<div>
							<select id="cf_smtp_secure" name="cf_smtp_secure">
								<option value=""<?php echo ($theme_options["cf_smtp_secure"]=="" ? " selected='selected'" : "") ?>>-</option>
								<option value="ssl"<?php echo ($theme_options["cf_smtp_secure"]=="ssl" ? " selected='selected'" : "") ?>><?php _e('ssl', 'gymbase'); ?></option>
								<option value="tls"<?php echo ($theme_options["cf_smtp_secure"]=="tls" ? " selected='selected'" : "") ?>><?php _e('tls', 'gymbase'); ?></option>
							</select>
						</div>
					</li>
				</ul>
				<h4><?php _e('EMAIL CONFIG', 'gymbase'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_email_subject"><?php _e('EMAIL SUBJECT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_email_subject"]); ?>" id="cf_email_subject" name="cf_email_subject">
						</div>
					</li>
					<li>
						<label for="cf_template"><?php _e('TEMPLATE', 'gymbase'); ?></label>
						<div>
							<?php wp_editor($theme_options["cf_template"], "cf_template");?>
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-contact-details" class="settings">
				<h3><?php _e('Contact Details', 'gymbase'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="contact_logo_first_part_text"><?php _e('CONTACT LOGO FIRST PART TEXT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_logo_first_part_text"]); ?>" id="contact_logo_first_part_text" name="contact_logo_first_part_text">
						</div>
					</li>
					<li>
						<label for="contact_logo_second_part_text"><?php _e('CONTACT LOGO SECOND PART TEXT', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_logo_second_part_text"]); ?>" id="contact_logo_second_part_text" name="contact_logo_second_part_text">
						</div>
					</li>
					<li>
						<label for="contact_phone"><?php _e('CONTACT PHONE', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_phone"]); ?>" id="contact_phone" name="contact_phone">
						</div>
					</li>
					<li>
						<label for="contact_fax"><?php _e('CONTACT FAX', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_fax"]); ?>" id="contact_fax" name="contact_fax">
						</div>
					</li>
					<li>
						<label for="contact_email"><?php _e('CONTACT EMAIL', 'gymbase'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_email"]); ?>" id="contact_phone" name="contact_email">
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-colors" class="settings">
				<h3><?php _e('Colors', 'gymbase'); ?></h3>
				<div id="tab-colors_general" class="subsettings">
					<h4><?php _e('GENERAL', 'gymbase'); ?></h4>
					<ul class="form_field_list">
						<li>
							<label for="header_background_color"><?php _e('Header background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["header_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["header_background_color"]); ?>" id="header_background_color" name="header_background_color">
							</div>
						</li>
						<li>
							<label for="body_background_color"><?php _e('Body background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_background_color"]); ?>" id="body_background_color" name="body_background_color">
							</div>
						</li>
						<li>
							<label for="footer_background_color"><?php _e('Footer background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_background_color"]); ?>" id="footer_background_color" name="footer_background_color">
							</div>
						</li>
						<li>
							<label for="link_color"><?php _e('Link color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["link_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["link_color"]); ?>" id="link_color" name="link_color">
							</div>
						</li>
						<li>
							<label for="link_hover_color"><?php _e('Link hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["link_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["link_hover_color"]); ?>" id="link_hover_color" name="link_hover_color">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_text" class="subsettings">
					<h4><?php _e('TEXT', 'gymbase'); ?></h4>
					<ul class="form_field_list">
						<li>
							<label for="body_headers_color"><?php _e('Body headers color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_headers_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_headers_color"]); ?>" id="body_headers_color" name="body_headers_color">
							</div>
						</li>
						<li>
							<label for="body_headers_border_color"><?php _e('Body headers border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_headers_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_headers_border_color"]); ?>" id="body_headers_border_color" name="body_headers_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="body_text_color"><?php _e('Body text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_text_color"]); ?>" id="body_text_color" name="body_text_color">
							</div>
						</li>
						<li>
							<label for="body_text2_color"><?php _e('Body text 2 color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_text2_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_text2_color"]); ?>" id="body_text2_color" name="body_text2_color">
							</div>
						</li>
						<li>
							<label for="footer_headers_color"><?php _e('Footer headers color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_headers_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_headers_color"]); ?>" id="footer_headers_color" name="footer_headers_color">
							</div>
						</li>
						<li>
							<label for="footer_headers_border_color"><?php _e('Footer headers border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_headers_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_headers_border_color"]); ?>" id="footer_headers_border_color" name="footer_headers_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="footer_text_color"><?php _e('Footer text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_text_color"]); ?>" id="footer_text_color" name="footer_text_color">
							</div>
						</li>
						<li>
							<label for="timeago_label_color"><?php _e('Timeago label color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["timeago_label_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["timeago_label_color"]); ?>" id="timeago_label_color" name="timeago_label_color">
							</div>
						</li>
						<li>
							<label for="sentence_color"><?php _e('Sentence color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["sentence_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["sentence_color"]); ?>" id="sentence_color" name="sentence_color">
							</div>
						</li>
						<li>
							<label for="logo_first_part_text_color"><?php _e('Logo first part text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["logo_first_part_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["logo_first_part_text_color"]); ?>" id="logo_first_part_text_color" name="logo_first_part_text_color">
							</div>
						</li>
						<li>
							<label for="logo_second_part_text_color"><?php _e('Logo second part text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["logo_second_part_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["logo_second_part_text_color"]); ?>" id="logo_second_part_text_color" name="logo_second_part_text_color">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_buttons" class="subsettings">
					<h4><?php _e('BUTTONS', 'gymbase');?></h4>
					<ul class="form_field_list">
						<li>
							<label for="body_button_color"><?php _e('Body button text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_button_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_color"]); ?>" id="body_button_color" name="body_button_color">
							</div>
						</li>
						<li>
							<label for="body_button_hover_color"><?php _e('Body button text hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_button_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_hover_color"]); ?>" id="body_button_hover_color" name="body_button_hover_color">
							</div>
						</li>
						<li>
							<label for="body_button_border_color"><?php _e('Body button border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_button_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_border_color"]); ?>" id="body_button_border_color" name="body_button_border_color">
							</div>
						</li>
						<li>
							<label for="body_button_border_hover_color"><?php _e('Body button border hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["body_button_border_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_border_hover_color"]); ?>" id="body_button_border_hover_color" name="body_button_border_hover_color">
							</div>
						</li>
						<li>
							<label for="footer_button_color"><?php _e('Footer button text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_button_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_color"]); ?>" id="footer_button_color" name="footer_button_color">
							</div>
						</li>
						<li>
							<label for="footer_button_hover_color"><?php _e('Footer button text hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_button_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_hover_color"]); ?>" id="footer_button_hover_color" name="footer_button_hover_color">
							</div>
						</li>
						<li>
							<label for="footer_button_border_color"><?php _e('Footer button border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_button_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_border_color"]); ?>" id="footer_button_border_color" name="footer_button_border_color">
							</div>
						</li>
						<li>
							<label for="footer_button_border_hover_color"><?php _e('Footer button border hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["footer_button_border_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_border_hover_color"]); ?>" id="footer_button_border_hover_color" name="footer_button_border_hover_color">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_menu" class="subsettings">
					<h4><?php _e('MENU', 'gymbase');?></h4>
					<ul class="form_field_list">
						<li>
							<label for="menu_link_color"><?php _e('Link color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["menu_link_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_link_color"]); ?>" id="menu_link_color" name="menu_link_color">
							</div>
						</li>
						<li>
							<label for="menu_link_border_color"><?php _e('Link border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["menu_link_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_link_border_color"]); ?>" id="menu_link_border_color" name="menu_link_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="menu_active_color"><?php _e('Active color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["menu_active_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_active_color"]); ?>" id="menu_active_color" name="menu_active_color">
							</div>
						</li>
						<li>
							<label for="menu_active_border_color"><?php _e('Active border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["menu_active_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_active_border_color"]); ?>" id="menu_active_border_color" name="menu_active_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="menu_hover_color"><?php _e('Hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["menu_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_hover_color"]); ?>" id="menu_hover_color" name="menu_hover_color">
							</div>
						</li>
						<li>
							<label for="menu_hover_border_color"><?php _e('Hover border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["menu_hover_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_hover_border_color"]); ?>" id="menu_hover_border_color" name="menu_hover_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="submenu_background_color"><?php _e('Submenu background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["submenu_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_background_color"]); ?>" id="submenu_background_color" name="submenu_background_color">
							</div>
						</li>
						<li>
							<label for="submenu_hover_background_color"><?php _e('Submenu hover background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["submenu_hover_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_hover_background_color"]); ?>" id="submenu_hover_background_color" name="submenu_hover_background_color">
							</div>
						</li>
						<li>
							<label for="submenu_color"><?php _e('Submenu link color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["submenu_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_color"]); ?>" id="submenu_color" name="submenu_color">
							</div>
						</li>
						<li>
							<label for="submenu_hover_color"><?php _e('Submenu hover link color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["submenu_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_hover_color"]); ?>" id="submenu_color" name="submenu_hover_color">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_forms" class="subsettings">
					<h4><?php _e('FORMS', 'gymbase');?></h4>
					<ul class="form_field_list">
						<li>
							<label for="form_hint_color"><?php _e('Form hint color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["form_hint_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_hint_color"]); ?>" id="form_hint_color" name="form_hint_color">
							</div>
						</li>
						<li>
							<label for="form_field_text_color"><?php _e('Form field text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["form_field_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_field_text_color"]); ?>" id="form_field_text_color" name="form_field_text_color">
							</div>
						</li>
						<li>
							<label for="form_field_border_color"><?php _e('Form field border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["form_field_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_field_border_color"]); ?>" id="form_field_border_color" name="form_field_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="form_field_active_border_color"><?php _e('Form field active border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["form_field_active_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_field_active_border_color"]); ?>" id="form_field_active_border_color" name="form_field_active_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_miscellaneous" class="subsettings">
					<h4><?php _e('MISCELLANEOUS', 'gymbase'); ?></h4>
					<ul class="form_field_list">
						<li>
							<label for="date_box_color"><?php _e('Date box background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["date_box_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_color"]); ?>" id="date_box_color" name="date_box_color">
							</div>
						</li>
						<li>
							<label for="date_box_text_color"><?php _e('Date box text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["date_box_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_text_color"]); ?>" id="date_box_text_color" name="date_box_text_color">
							</div>
						</li>
						<li>
							<label for="date_box_comments_number_text_color"><?php _e('Date box comments number text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["date_box_comments_number_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_comments_number_text_color"]); ?>" id="date_box_comments_number_text_color" name="date_box_comments_number_text_color">
							</div>
						</li>
						<li>
							<label for="date_box_comments_number_border_color"><?php _e('Date box comments number border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["date_box_comments_number_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_comments_number_border_color"]); ?>" id="date_box_comments_number_border_color" name="date_box_comments_number_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="date_box_comments_number_hover_border_color"><?php _e('Date box comments number hover border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["date_box_comments_number_hover_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_comments_number_hover_border_color"]); ?>" id="date_box_comments_number_hover_border_color" name="date_box_comments_number_hover_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="gallery_box_color"><?php _e('Gallery box color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_box_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_color"]); ?>" id="gallery_box_color" name="gallery_box_color">
							</div>
						</li>
						<li>
							<label for="gallery_box_text_first_line_color"><?php _e('Gallery box text first line color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_box_text_first_line_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_text_first_line_color"]); ?>" id="gallery_box_text_first_line_color" name="gallery_box_text_first_line_color">
							</div>
						</li>
						<li>
							<label for="gallery_box_text_second_line_color"><?php _e('Gallery box text second line color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_box_text_second_line_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_text_second_line_color"]); ?>" id="gallery_box_text_second_line_color" name="gallery_box_text_second_line_color">
							</div>
						</li>
						<li>
							<label for="gallery_box_hover_color"><?php _e('Gallery box hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_box_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_hover_color"]); ?>" id="gallery_box_hover_color" name="gallery_box_hover_color">
							</div>
						</li>
						<li>
							<label for="gallery_box_hover_text_first_line_color"><?php _e('Gallery box hover text first line color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_box_hover_text_first_line_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_hover_text_first_line_color"]); ?>" id="gallery_box_hover_text_first_line_color" name="gallery_box_hover_text_first_line_color">
							</div>
						</li>
						<li>
							<label for="gallery_box_hover_text_second_line_color"><?php _e('Gallery box hover text second line color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_box_hover_text_second_line_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_hover_text_second_line_color"]); ?>" id="gallery_box_hover_text_second_line_color" name="gallery_box_hover_text_second_line_color">
							</div>
						</li>
						<li>
							<label for="timetable_box_color"><?php _e('Timetable box color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["timetable_box_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["timetable_box_color"]); ?>" id="timetable_box_color" name="timetable_box_color">
							</div>
						</li>
						<li>
							<label for="timetable_box_hover_color"><?php _e('Timetable box hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["timetable_box_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["timetable_box_hover_color"]); ?>" id="timetable_box_hover_color" name="timetable_box_hover_color">
							</div>
						</li>
						<li>
							<label for="gallery_details_box_border_color"><?php _e('Gallery details box border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_details_box_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_details_box_border_color"]); ?>" id="gallery_details_box_border_color" name="gallery_details_box_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="bread_crumb_border_color"><?php _e('Bread crumb border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["bread_crumb_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["bread_crumb_border_color"]); ?>" id="bread_crumb_border_color" name="bread_crumb_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="accordion_item_border_color"><?php _e('Accordion item border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["accordion_item_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_color"]); ?>" id="accordion_item_border_color" name="accordion_item_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="accordion_item_border_hover_color"><?php _e('Accordion item border hover color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["accordion_item_border_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_hover_color"]); ?>" id="accordion_item_border_hover_color" name="accordion_item_border_hover_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="accordion_item_border_active_color"><?php _e('Accordion item border active color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["accordion_item_border_active_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_active_color"]); ?>" id="accordion_item_border_active_color" name="accordion_item_border_active_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="copyright_area_border_color"><?php _e('Copyright area border color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["copyright_area_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["copyright_area_border_color"]); ?>" id="copyright_area_border_color" name="copyright_area_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
							</div>
						</li>
						<li>
							<label for="top_hint_background_color"><?php _e('Top hint background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["top_hint_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["top_hint_background_color"]); ?>" id="top_hint_background_color" name="top_hint_background_color">
							</div>
						</li>
						<li>
							<label for="top_hint_text_color"><?php _e('Top hint text color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["top_hint_text_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["top_hint_text_color"]); ?>" id="top_hint_text_color" name="top_hint_text_color">
							</div>
						</li>
						<li>
							<label for="comment_reply_button_color"><?php _e('Comment reply button color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["comment_reply_button_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["comment_reply_button_color"]); ?>" id="comment_reply_button_color" name="comment_reply_button_color">
							</div>
						</li>
						<li>
							<label for="post_author_link_color"><?php _e('Post author link color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["post_author_link_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["post_author_link_color"]); ?>" id="post_author_link_color" name="post_author_link_color">
							</div>
						</li>
						<li>
							<label for="contact_details_box_background_color"><?php _e('Contact details box background color', 'gymbase'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["contact_details_box_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["contact_details_box_background_color"]); ?>" id="contact_details_box_background_color" name="contact_details_box_background_color">
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div id="tab-fonts" class="settings">
				<h3><?php _e('Fonts', 'gymbase'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="header_font"><?php _e('Header font', 'gymbase'); ?></label>
						<div>
							<select id="header_font" name="header_font">
								<option<?php echo ($theme_options["header_font"]=="" ? " selected='selected'" : ""); ?>  value=""><?php _e("Default", 'gymbase'); ?></option>
								<?php
								$fontsCount = count($fontsArray->items);
								for($i=0; $i<$fontsCount; $i++)
								{
								?>
									
									<?php
									$variantsCount = count($fontsArray->items[$i]->variants);
									if($variantsCount>1)
									{
										for($j=0; $j<$variantsCount; $j++)
										{
										?>
											<option<?php echo ($theme_options["header_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
										<?php
										}
									}
									else
									{
									?>
									<option<?php echo ($theme_options["header_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family; ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
									<?php
									}
								}
								?>
							</select>
						</div>
					</li>
					<li>
						<label for="subheader_font"><?php _e('Subheader font', 'gymbase'); ?></label>
						<div>
							<select id="subheader_font" name="subheader_font">
								<option<?php echo ($theme_options["subheader_font"]=="" ? " selected='selected'" : ""); ?>  value=""><?php _e("Default", 'gymbase'); ?></option>
								<?php
								$fontsCount = count($fontsArray->items);
								for($i=0; $i<$fontsCount; $i++)
								{
								?>
									
									<?php
									$variantsCount = count($fontsArray->items[$i]->variants);
									if($variantsCount>1)
									{
										for($j=0; $j<$variantsCount; $j++)
										{
										?>
											<option<?php echo ($theme_options["subheader_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
										<?php
										}
									}
									else
									{
									?>
									<option<?php echo ($theme_options["subheader_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family; ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
									<?php
									}
								}
								?>
							</select>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="footer">
			<div class="footer_left">
				<ul class="social-list">
					<li><a target="_blank" href="http://www.facebook.com/QuanticaLabs/" class="social-list-facebook" title="Facebook"></a></li>
					<li><a target="_blank" href="https://twitter.com/quanticalabs" class="social-list-twitter" title="Twitter"></a></li>
					<li><a target="_blank" href="http://www.flickr.com/photos/76628486@N03" class="social-list-flickr" title="Flickr"></a></li>
					<li><a target="_blank" href="http://themeforest.net/user/QuanticaLabs?ref=QuanticaLabs" class="social-list-envato" title="Envato"></a></li>
					<li><a target="_blank" href="http://quanticalabs.tumblr.com/" class="social-list-tumblr" title="Tumblr"></a></li>
					<li><a target="_blank" href="http://quanticalabs.deviantart.com/" class="social-list-deviantart" title="Deviantart"></a></li>
				</ul>
			</div>
			<div class="footer_right">
				<input type="hidden" name="action" value="<?php echo $themename; ?>_save" />
				<input type="submit" name="submit" value="Save Options" />
				<img id="theme_options_preloader" src="<?php echo get_template_directory_uri();?>/admin/images/ajax-loader.gif" />
				<img id="theme_options_tick" src="<?php echo get_template_directory_uri();?>/admin/images/tick.png" />
			</div>
		</div>
	</form>
	<?php
	//print_r($fontsArray->items);
	/*
	?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="<?php echo $themename; ?>-options-tabs">
		<ul class="nav-tabs">
			<li class="nav-tab">
				<a href="#tab-main">
					<?php _e('Main', 'gymbase'); ?>
				</a>
			</li>
			<li class="nav-tab">
				<a href="#tab-slider">
					<?php _e('Slider', 'gymbase'); ?>
				</a>
			</li>
			<li class="nav-tab">
				<a href="#tab-contact-form">
					<?php _e('Contact Form', 'gymbase'); ?>
				</a>
			</li>
			<li class="nav-tab">
				<a href="#tab-contact-details">
					<?php _e('Contact Details', 'gymbase'); ?>
				</a>
			</li>
			<li class="nav-tab">
				<a href="#tab-colors">
					<?php _e('Colors', 'gymbase'); ?>
				</a>
			</li>
			<li class="nav-tab">
				<a href="#tab-fonts">
					<?php _e('Fonts', 'gymbase'); ?>
				</a>
			</li>
		</ul>
		<div id="tab-main">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php _e('Main', 'gymbase'); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="logo_url"><?php _e('Logo url', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_url"]); ?>" id="logo_url" name="logo_url">
							<input type="button" class="button" name="<?php echo $themename;?>_upload_button" id="logo_url_upload_button" value="<?php _e('Insert logo', 'gymbase'); ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="logo_first_part_text"><?php _e('Logo first part text', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_first_part_text"]); ?>" id="logo_first_part_text" name="logo_first_part_text">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="logo_second_part_text"><?php _e('Logo second part text', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_second_part_text"]); ?>" id="logo_second_part_text" name="logo_second_part_text">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_text_left"><?php _e('Footer text left', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["footer_text_left"]); ?>" id="footer_text_left" name="footer_text_left">
							<span class="description"><?php _e('Can be text or any html', 'gymbase'); ?>.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_text_right"><?php _e('Footer text right', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["footer_text_right"]); ?>" id="footer_text_right" name="footer_text_right">
							<span class="description"><?php _e('Can be text or any html', 'gymbase'); ?>.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="home_page_top_hint"><?php _e('Home page top hint', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["home_page_top_hint"]); ?>" id="home_page_top_hint" name="home_page_top_hint">
							<span class="description"><?php _e('Can be text or any html', 'gymbase'); ?>.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="responsive"><?php _e('Responsive', 'gymbase'); ?></label>
						</th>
						<td>
							<select id="responsive" name="responsive">
								<option value="1"<?php echo ((int)$theme_options["responsive"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'gymbase'); ?></option>
								<option value="0"<?php echo ((int)$theme_options["responsive"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'gymbase'); ?></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" value="<?php _e('Save Main Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
			</p>
		</div>
		<div id="tab-slider">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php _e('Slider', 'gymbase'); ?>
						</th>
					</tr>
					<?php
					$slides_count = count($theme_options["slider_image_url"]);
					if($slides_count==0)
						$slides_count = 3;
					for($i=0; $i<$slides_count; $i++)
					{
					?>
					<tr class="slider_image_url_row">
						<td>
							<label><?php _e('Slider image url', 'gymbase'); echo " " . ($i+1); ?></label>
						</td>
						<td>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_url_<?php echo ($i+1); ?>" name="slider_image_url[]" value="<?php echo esc_attr($theme_options["slider_image_url"][$i]); ?>" />
							<input type="button" class="button" name="<?php echo $themename;?>_upload_button" id="<?php echo $themename;?>_slider_image_url_button_<?php echo ($i+1); ?>" value="<?php _e('Browse', 'gymbase'); ?>" />
						</td>
					</tr>
					<tr class="slider_image_title_row">
						<td>
							<label><?php _e('Slider image title', 'gymbase'); echo " " . ($i+1); ?></label>
						</td>
						<td>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_title_<?php echo ($i+1); ?>" name="slider_image_title[]" value="<?php echo esc_attr($theme_options["slider_image_title"][$i]); ?>" />
						</td>
					</tr>
					<tr class="slider_image_subtitle_row">
						<td>
							<label><?php _e('Slider image subtitle', 'gymbase'); echo " " . ($i+1); ?></label>
						</td>
						<td>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_subtitle_<?php echo ($i+1); ?>" name="slider_image_subtitle[]" value="<?php echo esc_attr($theme_options["slider_image_subtitle"][$i]); ?>" />
						</td>
					</tr>
					<tr class="slider_image_link_row">
						<td>
							<label><?php _e('Slider image link', 'gymbase'); echo " " . ($i+1); ?></label>
						</td>
						<td>
							<input class="regular-text" type="text" id="<?php echo $themename;?>_slider_image_link_<?php echo ($i+1); ?>" name="slider_image_link[]" value="<?php echo esc_attr($theme_options["slider_image_link"][$i]); ?>" />
						</td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td></td>
						<td>
							<input type="button" class="button" name="<?php echo $themename;?>_add_new_button" id="<?php echo $themename;?>_add_new_button" value="<?php _e('Add slider image', 'gymbase'); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label><?php _e('Autoplay', 'gymbase'); ?></label>
						</td>
						<td>
							<select id="slider_autoplay" name="slider_autoplay">
								<option value="true"<?php echo ($theme_options["slider_autoplay"]=="true" ? " selected='selected'" : "") ?>><?php _e('yes', 'gymbase'); ?></option>
								<option value="false"<?php echo ($theme_options["slider_autoplay"]=="false" ? " selected='selected'" : "") ?>><?php _e('no', 'gymbase'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label for="slide_interval"><?php _e('Slide interval:', 'gymbase'); ?></label>
						</td>
						<td>
							<input type="text" class="regular-text" id="slide_interval" name="slide_interval" value="<?php echo (int)esc_attr($theme_options["slide_interval"]); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="slider_effect"><?php _e('Effect:', 'gymbase'); ?></label>
						</td>
						<td>
							<select id="slider_effect" name="slider_effect">
								<option value="scroll"<?php echo ($theme_options["slider_effect"]=="scroll" ? " selected='selected'" : "") ?>><?php _e('scroll', 'gymbase'); ?></option>
								<option value="none"<?php echo ($theme_options["slider_effect"]=="none" ? " selected='selected'" : "") ?>><?php _e('none', 'gymbase'); ?></option>
								<option value="directscroll"<?php echo ($theme_options["slider_effect"]=="directscroll" ? " selected='selected'" : "") ?>><?php _e('directscroll', 'gymbase'); ?></option>
								<option value="fade"<?php echo ($theme_options["slider_effect"]=="fade" ? " selected='selected'" : "") ?>><?php _e('fade', 'gymbase'); ?></option>
								<option value="crossfade"<?php echo ($theme_options["slider_effect"]=="crossfade" ? " selected='selected'" : "") ?>><?php _e('crossfade', 'gymbase'); ?></option>
								<option value="cover"<?php echo ($theme_options["slider_effect"]=="cover" ? " selected='selected'" : "") ?>><?php _e('cover', 'gymbase'); ?></option>
								<option value="uncover"<?php echo ($theme_options["slider_effect"]=="uncover" ? " selected='selected'" : "") ?>><?php _e('uncover', 'gymbase'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label for="slider_transition"><?php _e('Transition:', 'gymbase'); ?></label>
						</td>
						<td>
							<select id="slider_transition" name="slider_transition">
								<option value="swing"<?php echo ($theme_options["slider_transition"]=="swing" ? " selected='selected'" : "") ?>><?php _e('swing', 'gymbase'); ?></option>
								<option value="linear"<?php echo ($theme_options["slider_transition"]=="linear" ? " selected='selected'" : "") ?>><?php _e('linear', 'gymbase'); ?></option>
								<option value="easeInQuad"<?php echo ($theme_options["slider_transition"]=="easeInQuad" ? " selected='selected'" : "") ?>><?php _e('easeInQuad', 'gymbase'); ?></option>
								<option value="easeOutQuad"<?php echo ($theme_options["slider_transition"]=="easeOutQuad" ? " selected='selected'" : "") ?>><?php _e('easeOutQuad', 'gymbase'); ?></option>
								<option value="easeInOutQuad"<?php echo ($theme_options["slider_transition"]=="easeInOutQuad" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuad', 'gymbase'); ?></option>
								<option value="easeInCubic"<?php echo ($theme_options["slider_transition"]=="easeInCubic" ? " selected='selected'" : "") ?>><?php _e('easeInCubic', 'gymbase'); ?></option>
								<option value="easeOutCubic"<?php echo ($theme_options["slider_transition"]=="easeOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeOutCubic', 'gymbase'); ?></option>
								<option value="easeInOutCubic"<?php echo ($theme_options["slider_transition"]=="easeInOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeInOutCubic', 'gymbase'); ?></option>
								<option value="easeInOutCubic"<?php echo ($theme_options["slider_transition"]=="easeInOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeInOutCubic', 'gymbase'); ?></option>
								<option value="easeInQuart"<?php echo ($theme_options["slider_transition"]=="easeInQuart" ? " selected='selected'" : "") ?>><?php _e('easeInQuart', 'gymbase'); ?></option>
								<option value="easeOutQuart"<?php echo ($theme_options["slider_transition"]=="easeOutQuart" ? " selected='selected'" : "") ?>><?php _e('easeOutQuart', 'gymbase'); ?></option>
								<option value="easeInOutQuart"<?php echo ($theme_options["slider_transition"]=="easeInOutQuart" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuart', 'gymbase'); ?></option>
								<option value="easeInSine"<?php echo ($theme_options["slider_transition"]=="easeInSine" ? " selected='selected'" : "") ?>><?php _e('easeInSine', 'gymbase'); ?></option>
								<option value="easeOutSine"<?php echo ($theme_options["slider_transition"]=="easeOutSine" ? " selected='selected'" : "") ?>><?php _e('easeOutSine', 'gymbase'); ?></option>
								<option value="easeInOutSine"<?php echo ($theme_options["slider_transition"]=="easeInOutSine" ? " selected='selected'" : "") ?>><?php _e('easeInOutSine', 'gymbase'); ?></option>
								<option value="easeInExpo"<?php echo ($theme_options["slider_transition"]=="easeInExpo" ? " selected='selected'" : "") ?>><?php _e('easeInExpo', 'gymbase'); ?></option>
								<option value="easeOutExpo"<?php echo ($theme_options["slider_transition"]=="easeOutExpo" ? " selected='selected'" : "") ?>><?php _e('easeOutExpo', 'gymbase'); ?></option>
								<option value="easeInOutExpo"<?php echo ($theme_options["slider_transition"]=="easeInOutExpo" ? " selected='selected'" : "") ?>><?php _e('easeInOutExpo', 'gymbase'); ?></option>
								<option value="easeInQuint"<?php echo ($theme_options["slider_transition"]=="easeInQuint" ? " selected='selected'" : "") ?>><?php _e('easeInQuint', 'gymbase'); ?></option>
								<option value="easeOutQuint"<?php echo ($theme_options["slider_transition"]=="easeOutQuint" ? " selected='selected'" : "") ?>><?php _e('easeOutQuint', 'gymbase'); ?></option>
								<option value="easeInOutQuint"<?php echo ($theme_options["slider_transition"]=="easeInOutQuint" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuint', 'gymbase'); ?></option>
								<option value="easeInCirc"<?php echo ($theme_options["slider_transition"]=="easeInCirc" ? " selected='selected'" : "") ?>><?php _e('easeInCirc', 'gymbase'); ?></option>
								<option value="easeOutCirc"<?php echo ($theme_options["slider_transition"]=="easeOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeOutCirc', 'gymbase'); ?></option>
								<option value="easeInOutCirc"<?php echo ($theme_options["slider_transition"]=="easeInOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeInOutCirc', 'gymbase'); ?></option>
								<option value="easeInElastic"<?php echo ($theme_options["slider_transition"]=="easeInElastic" ? " selected='selected'" : "") ?>><?php _e('easeInElastic', 'gymbase'); ?></option>
								<option value="easeOutElastic"<?php echo ($theme_options["slider_transition"]=="easeOutElastic" ? " selected='selected'" : "") ?>><?php _e('easeOutElastic', 'gymbase'); ?></option>
								<option value="easeInOutElastic"<?php echo ($theme_options["slider_transition"]=="easeInOutElastic" ? " selected='selected'" : "") ?>><?php _e('easeInOutElastic', 'gymbase'); ?></option>
								<option value="easeInBack"<?php echo ($theme_options["slider_transition"]=="easeInBack" ? " selected='selected'" : "") ?>><?php _e('easeInBack', 'gymbase'); ?></option>
								<option value="easeOutBack"<?php echo ($theme_options["slider_transition"]=="easeOutBack" ? " selected='selected'" : "") ?>><?php _e('easeOutBack', 'gymbase'); ?></option>
								<option value="easeInOutBack"<?php echo ($theme_options["slider_transition"]=="easeOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeInOutBack', 'gymbase'); ?></option>
								<option value="easeInBounce"<?php echo ($theme_options["slider_transition"]=="easeInBounce" ? " selected='selected'" : "") ?>><?php _e('easeInBounce', 'gymbase'); ?></option>
								<option value="easeOutBounce"<?php echo ($theme_options["slider_transition"]=="easeOutBounce" ? " selected='selected'" : "") ?>><?php _e('easeOutBounce', 'gymbase'); ?></option>
								<option value="easeInOutBounce"<?php echo ($theme_options["slider_transition"]=="easeInOutBounce" ? " selected='selected'" : "") ?>><?php _e('easeInOutBounce', 'gymbase'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label for="slider_transition_speed"><?php _e('Transition speed:', 'gymbase'); ?></label>
						</td>
						<td>
							<input type="text" class="regular-text" id="slider_transition_speed" name="slider_transition_speed" value="<?php echo (int)esc_attr($theme_options["slider_transition_speed"]); ?>" />
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" value="<?php _e('Save Slider Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
			</p>
		</div>
		<div id="tab-contact-form">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Admin email config', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_admin_name"><?php _e('Name', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_name"]); ?>" id="cf_admin_name" name="cf_admin_name">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_admin_email"><?php _e('Email', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_email"]); ?>" id="cf_admin_email" name="cf_admin_email">
						</td>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<br />
						</th>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Admin SMTP config (optional)', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_smtp_host"><?php _e('Host', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_host"]); ?>" id="cf_smtp_host" name="cf_smtp_host">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_smtp_username"><?php _e('Username', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_username"]); ?>" id="cf_smtp_username" name="cf_smtp_username">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_smtp_password"><?php _e('Password', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="password" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_password"]); ?>" id="cf_smtp_password" name="cf_smtp_password">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_smtp_port"><?php _e('Port', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_port"]); ?>" id="cf_smtp_port" name="cf_smtp_port">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_smtp_secure"><?php _e('SMTP Secure', 'gymbase'); ?></label>
						</th>
						<td>
							<select id="cf_smtp_secure" name="cf_smtp_secure">
								<option value=""<?php echo ($theme_options["cf_smtp_secure"]=="" ? " selected='selected'" : "") ?>>-</option>
								<option value="ssl"<?php echo ($theme_options["cf_smtp_secure"]=="ssl" ? " selected='selected'" : "") ?>><?php _e('ssl', 'gymbase'); ?></option>
								<option value="tls"<?php echo ($theme_options["cf_smtp_secure"]=="tls" ? " selected='selected'" : "") ?>><?php _e('tls', 'gymbase'); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<br />
						</th>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php _e('Email config', 'gymbase'); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_email_subject"><?php _e('Email subject', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_email_subject"]); ?>" id="cf_email_subject" name="cf_email_subject">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="cf_template"><?php _e('Template', 'gymbase'); ?></label>
						</th>
						<td></td>
					</tr>
					<tr valign="top">
						<td colspan="2">
							<?php the_editor($theme_options["cf_template"], "cf_template");?>
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" value="<?php _e('Save Contact Form Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
			</p>
		</div>
		<div id="tab-contact-details">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Contact Details', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="contact_logo_first_part_text"><?php _e('Contact logo first part text', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_logo_first_part_text"]); ?>" id="contact_logo_first_part_text" name="contact_logo_first_part_text">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="contact_logo_second_part_text"><?php _e('Contact logo second part text', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_logo_second_part_text"]); ?>" id="contact_logo_second_part_text" name="contact_logo_second_part_text">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="contact_phone"><?php _e('Contact phone', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_phone"]); ?>" id="contact_phone" name="contact_phone">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="contact_fax"><?php _e('Contact fax', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_fax"]); ?>" id="contact_fax" name="contact_fax">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="contact_email"><?php _e('Contact email', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["contact_email"]); ?>" id="contact_phone" name="contact_email">
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" value="<?php _e('Save Contact Details Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
			</p>
		</div>
		<div id="tab-colors">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('General', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="header_background_color"><?php _e('Header background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["header_background_color"]); ?>" id="header_background_color" name="header_background_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_background_color"><?php _e('Body background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_background_color"]); ?>" id="body_background_color" name="body_background_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_background_color"><?php _e('Footer background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_background_color"]); ?>" id="footer_background_color" name="footer_background_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link_color"><?php _e('Link color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["link_color"]); ?>" id="link_color" name="link_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link_hover_color"><?php _e('Link hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["link_hover_color"]); ?>" id="link_hover_color" name="link_hover_color">
						</td>
					</tr>
					<tr>
						<td style="padding: 0;">
							<p>
								<input type="submit" value="<?php _e('Save Colors Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Text', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_headers_color"><?php _e('Body headers color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_headers_color"]); ?>" id="body_headers_color" name="body_headers_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_headers_border_color"><?php _e('Body headers border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_headers_border_color"]); ?>" id="body_headers_border_color" name="body_headers_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_text_color"><?php _e('Body text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_text_color"]); ?>" id="body_text_color" name="body_text_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_text2_color"><?php _e('Body text 2 color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_text2_color"]); ?>" id="body_text2_color" name="body_text2_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_headers_color"><?php _e('Footer headers color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_headers_color"]); ?>" id="footer_headers_color" name="footer_headers_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_headers_border_color"><?php _e('Footer headers border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_headers_border_color"]); ?>" id="footer_headers_border_color" name="footer_headers_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_text_color"><?php _e('Footer text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_text_color"]); ?>" id="footer_text_color" name="footer_text_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="timeago_label_color"><?php _e('Timeago label color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["timeago_label_color"]); ?>" id="timeago_label_color" name="timeago_label_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="sentence_color"><?php _e('Sentence color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["sentence_color"]); ?>" id="sentence_color" name="sentence_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="logo_first_part_text_color"><?php _e('Logo first part text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["logo_first_part_text_color"]); ?>" id="logo_first_part_text_color" name="logo_first_part_text_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="logo_second_part_text_color"><?php _e('Logo second part text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["logo_second_part_text_color"]); ?>" id="logo_second_part_text_color" name="logo_second_part_text_color">
						</td>
					</tr>
					<tr>
						<td style="padding: 0;">
							<p>
								<input type="submit" value="<?php _e('Save Colors Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Buttons', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_button_color"><?php _e('Body button text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_color"]); ?>" id="body_button_color" name="body_button_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_button_hover_color"><?php _e('Body button text hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_hover_color"]); ?>" id="body_button_hover_color" name="body_button_hover_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_button_border_color"><?php _e('Body button border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_border_color"]); ?>" id="body_button_border_color" name="body_button_border_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="body_button_border_hover_color"><?php _e('Body button border hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["body_button_border_hover_color"]); ?>" id="body_button_border_hover_color" name="body_button_border_hover_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_button_color"><?php _e('Footer button text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_color"]); ?>" id="footer_button_color" name="footer_button_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_button_hover_color"><?php _e('Footer button text hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_hover_color"]); ?>" id="footer_button_hover_color" name="footer_button_hover_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_button_border_color"><?php _e('Footer button border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_border_color"]); ?>" id="footer_button_border_color" name="footer_button_border_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="footer_button_border_hover_color"><?php _e('Footer button border hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["footer_button_border_hover_color"]); ?>" id="footer_button_border_hover_color" name="footer_button_border_hover_color">
						</td>
					</tr>
					<tr>
						<td style="padding: 0;">
							<p>
								<input type="submit" value="<?php _e('Save Colors Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Menu', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="menu_link_color"><?php _e('Link color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_link_color"]); ?>" id="menu_link_color" name="menu_link_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="menu_link_border_color"><?php _e('Link border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_link_border_color"]); ?>" id="menu_link_border_color" name="menu_link_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="menu_active_color"><?php _e('Active color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_active_color"]); ?>" id="menu_active_color" name="menu_active_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="menu_active_border_color"><?php _e('Active border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_active_border_color"]); ?>" id="menu_active_border_color" name="menu_active_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="menu_hover_color"><?php _e('Hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_hover_color"]); ?>" id="menu_hover_color" name="menu_hover_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="menu_hover_border_color"><?php _e('Hover border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["menu_hover_border_color"]); ?>" id="menu_hover_border_color" name="menu_hover_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="submenu_background_color"><?php _e('Submenu background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_background_color"]); ?>" id="submenu_background_color" name="submenu_background_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="submenu_hover_background_color"><?php _e('Submenu hover background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_hover_background_color"]); ?>" id="submenu_hover_background_color" name="submenu_hover_background_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="submenu_color"><?php _e('Submenu link color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_color"]); ?>" id="submenu_color" name="submenu_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="submenu_hover_color"><?php _e('Submenu hover link color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["submenu_hover_color"]); ?>" id="submenu_color" name="submenu_hover_color">
						</td>
					</tr>
					<tr>
						<td style="padding: 0;">
							<p>
								<input type="submit" value="<?php _e('Save Colors Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Forms', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="form_hint_color"><?php _e('Form hint color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_hint_color"]); ?>" id="form_hint_color" name="form_hint_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="form_field_text_color"><?php _e('Form field text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_field_text_color"]); ?>" id="form_field_text_color" name="form_field_text_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="form_field_border_color"><?php _e('Form field border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_field_border_color"]); ?>" id="form_field_border_color" name="form_field_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="form_field_active_border_color"><?php _e('Form field active border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["form_field_active_border_color"]); ?>" id="form_field_active_border_color" name="form_field_active_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Miscellaneous', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="date_box_color"><?php _e('Date box background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_color"]); ?>" id="date_box_color" name="date_box_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="date_box_text_color"><?php _e('Date box text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_text_color"]); ?>" id="date_box_text_color" name="date_box_text_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="date_box_comments_number_text_color"><?php _e('Date box comments number text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_comments_number_text_color"]); ?>" id="date_box_comments_number_text_color" name="date_box_comments_number_text_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="date_box_comments_number_border_color"><?php _e('Date box comments number border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_comments_number_border_color"]); ?>" id="date_box_comments_number_border_color" name="date_box_comments_number_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="date_box_comments_number_hover_border_color"><?php _e('Date box comments number hover border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["date_box_comments_number_hover_border_color"]); ?>" id="date_box_comments_number_hover_border_color" name="date_box_comments_number_hover_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="gallery_box_color"><?php _e('Gallery box color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_color"]); ?>" id="gallery_box_color" name="gallery_box_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="gallery_box_hover_color"><?php _e('Gallery box hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_box_hover_color"]); ?>" id="gallery_box_hover_color" name="gallery_box_hover_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="timetable_box_color"><?php _e('Timetable box color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["timetable_box_color"]); ?>" id="timetable_box_color" name="timetable_box_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="timetable_box_hover_color"><?php _e('Timetable box hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["timetable_box_hover_color"]); ?>" id="timetable_box_hover_color" name="timetable_box_hover_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="gallery_details_box_border_color"><?php _e('Gallery details box border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_details_box_border_color"]); ?>" id="gallery_details_box_border_color" name="gallery_details_box_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="bread_crumb_border_color"><?php _e('Bread crumb border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["bread_crumb_border_color"]); ?>" id="bread_crumb_border_color" name="bread_crumb_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="accordion_item_border_color"><?php _e('Accordion item border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_color"]); ?>" id="accordion_item_border_color" name="accordion_item_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="accordion_item_border_hover_color"><?php _e('Accordion item border hover color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_hover_color"]); ?>" id="accordion_item_border_hover_color" name="accordion_item_border_hover_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="accordion_item_border_active_color"><?php _e('Accordion item border active color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_active_color"]); ?>" id="accordion_item_border_active_color" name="accordion_item_border_active_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="copyright_area_border_color"><?php _e('Copyright area border color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["copyright_area_border_color"]); ?>" id="copyright_area_border_color" name="copyright_area_border_color">
							<span class="description"><?php _e('Enter \'none\' for no border', 'gymbase'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="top_hint_background_color"><?php _e('Top hint background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["top_hint_background_color"]); ?>" id="top_hint_background_color" name="top_hint_background_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="top_hint_text_color"><?php _e('Top hint text color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["top_hint_text_color"]); ?>" id="top_hint_text_color" name="top_hint_text_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="comment_reply_button_color"><?php _e('Comment reply button color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["comment_reply_button_color"]); ?>" id="comment_reply_button_color" name="comment_reply_button_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="post_author_link_color"><?php _e('Post author link color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["post_author_link_color"]); ?>" id="post_author_link_color" name="post_author_link_color">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="contact_details_box_background_color"><?php _e('Contact details box background color', 'gymbase'); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["contact_details_box_background_color"]); ?>" id="contact_details_box_background_color" name="contact_details_box_background_color">
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" value="<?php _e('Save Colors Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
			</p>
		</div>
		<div id="tab-fonts">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th colspan="2" scope="row" style="font-weight: bold;">
							<?php
							_e('Fonts', 'gymbase');
							?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="header_font"><?php _e('Header font', 'gymbase'); ?></label>
						</th>
						<td>
							<select id="header_font" name="header_font">
								<option<?php echo ($theme_options["header_font"]=="" ? " selected='selected'" : ""); ?>  value=""><?php _e("Default", 'gymbase'); ?></option>
								<?php
								$fontsCount = count($fontsArray->items);
								for($i=0; $i<$fontsCount; $i++)
								{
								?>
									
									<?php
									$variantsCount = count($fontsArray->items[$i]->variants);
									if($variantsCount>1)
									{
										for($j=0; $j<$variantsCount; $j++)
										{
										?>
											<option<?php echo ($theme_options["header_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
										<?php
										}
									}
									else
									{
									?>
									<option<?php echo ($theme_options["header_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family; ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
									<?php
									}
								}
								?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="subheader_font"><?php _e('Subheader font', 'gymbase'); ?></label>
						</th>
						<td>
							<select id="subheader_font" name="subheader_font">
								<option<?php echo ($theme_options["subheader_font"]=="" ? " selected='selected'" : ""); ?>  value=""><?php _e("Default", 'gymbase'); ?></option>
								<?php
								$fontsCount = count($fontsArray->items);
								for($i=0; $i<$fontsCount; $i++)
								{
								?>
									
									<?php
									$variantsCount = count($fontsArray->items[$i]->variants);
									if($variantsCount>1)
									{
										for($j=0; $j<$variantsCount; $j++)
										{
										?>
											<option<?php echo ($theme_options["subheader_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
										<?php
										}
									}
									else
									{
									?>
									<option<?php echo ($theme_options["subheader_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo $fontsArray->items[$i]->family; ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
									<?php
									}
								}
								?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="submit" value="<?php _e('Save Fonts Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
			</p>
		</div>
		<p>
			<input type="hidden" name="action" value="<?php echo $themename; ?>_save" />
			<input type="submit" value="<?php _e('Save All Options', 'gymbase'); ?>" class="button-primary" name="<?php echo $themename; ?>_submit">
		</p>
		<input type="hidden" id="<?php echo $themename; ?>-selected-tab" value="<?php echo $selected_tab;?>" />
	</form>
<?php
	*/
}
?>