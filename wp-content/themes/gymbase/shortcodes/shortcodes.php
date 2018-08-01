<?php
//slider
require_once("slider.php");
//home box
require_once("home_box.php");
//latest_news
require_once("latest_news.php");
//scrolling_list
require_once("scrolling_list.php");
//items_list
require_once("items_list.php");
//item
require_once("item.php");
//columns
require_once("columns.php");
//timetable
require_once("timetable.php");
//map
require_once("map.php");
//accordion
require_once("accordion.php");
//tabs
require_once("tabs.php");
//social icons
require_once("social_icons.php");

//page layout
function theme_page_layout($atts, $content)
{
	return '<div class="page_layout clearfix">' . do_shortcode($content) . '</div>';
}
add_shortcode("page_layout", "theme_page_layout");

//page left
function theme_page_left($atts, $content)
{
	if(is_active_sidebar('left-top'))
	{
		ob_start();
		get_sidebar('left-top');
		$sidebar_left_top = ob_get_contents();
		ob_end_clean();
	}
	return '<div class="page_left">' . $sidebar_left_top . do_shortcode($content) . '</div>';
}
add_shortcode("page_left", "theme_page_left");

//page right
function theme_page_right($atts, $content)
{
	if(is_active_sidebar('right-top'))
	{
		ob_start();
		get_sidebar('right-top');
		$sidebar_right_top = ob_get_contents();
		ob_end_clean();
	}
	return '<div class="page_right">' . $sidebar_right_top . do_shortcode($content) . '</div>';
}
add_shortcode("page_right", "theme_page_right");

//button more
function theme_button_more($atts, $content)
{
	extract(shortcode_atts(array(
		"color" => "black",
		"arrow" => "margin_right_white",
		"href" => "#",
		"title" => "More"
	), $atts));
	
	return '<a class="more ' . $color . ($arrow!="" ? ' icon_small_arrow ' . $arrow : '') . '" href="' . $href . '" title="' . $title . '">' . do_shortcode($content) . '</a>';
}
add_shortcode("button_more", "theme_button_more");

//box_header
function theme_box_header($atts, $content)
{
	return '<h3 class="box_header">' . do_shortcode($content) . '</h3>';
}
add_shortcode("box_header", "theme_box_header");

//show all
function theme_show_all_button($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"url" => "blog",
		"title" => __("Show all", 'gymbase')
	), $atts));
	return '<div class="show_all"><a class="more icon_small_arrow margin_right_white" href="' . $url . '" title="' . $title . '">' . $title . '</a></div>';
}
add_shortcode("show_all_button", "theme_show_all_button");

//sidebar box
function theme_sidebar_box($atts, $content)
{
	extract(shortcode_atts(array(
		"first" => false
	), $atts));
	return '<div class="sidebar_box' . ($first ? ' first' : '') . '">' . do_shortcode($content) . '</div>';
}
add_shortcode("sidebar_box", "theme_sidebar_box");

//scroll top
function theme_scroll_top($atts, $content)
{
	extract(shortcode_atts(array(
		"title" => "Scroll to top",
		"label" => "Top"
	), $atts));
	
	return '<a class="scroll_top icon_small_arrow top_white" href="#top" title="' . esc_attr($title) . '">' . esc_attr($label) . '</a>';
}
add_shortcode("scroll_top", "theme_scroll_top");

//box_header
function theme_info_text($atts, $content)
{
	extract(shortcode_atts(array(
		"color" => "white",
		"class" => ""
	), $atts));
	return '<h4 class="info_' . $color . ' ' . $class . '">' . do_shortcode($content) . '</h4>';
}
add_shortcode("info_text", "theme_info_text");
?>