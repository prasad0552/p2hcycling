<?php
//items list
function theme_items_list($atts, $content)
{
	extract(shortcode_atts(array(
		"class" => "",
		"color" => "",
		"type" => ""
	), $atts));
	
	$output .= '
	<ul class="' . ($type!='simple' ? 'items_': '') . 'list' . ($color!='' ? ' ' . $color : '') . ($class!='' ? ' ' . $class : '') . '">
		' . do_shortcode($content) . '
	</ul>';
	return $output;
}
add_shortcode("items_list", "theme_items_list");
?>