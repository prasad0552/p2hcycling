<?php
//contact info
function theme_contact_info($atts, $content)
{
	return '<div class="contact_details page_margin_top">' . do_shortcode($content) . '</div>';
}
add_shortcode("contact_info", "theme_contact_info");

//google map details
function theme_contact_details($atts, $content)
{
	global $theme_options;
	
	$output = '<div class="contact_details_about">';
	if($theme_options["contact_logo_first_part_text"]!="")
		$output .= '<span class="logo_left">' . $theme_options["contact_logo_first_part_text"] . '</span>';
	if($theme_options["contact_logo_second_part_text"]!="")
		$output .= '<span class="logo_right">' . $theme_options["contact_logo_second_part_text"] . '</span>';
	$output .= do_shortcode(apply_filters('the_content', $content));
	if($theme_options["contact_phone"]!="" || $theme_options["contact_fax"]!="" || $theme_options["contact_email"]!="")
		$output .= '
		<ul class="contact_data">'
			. ($theme_options["contact_phone"]!="" ? '<li class="phone">' . $theme_options["contact_phone"] . '</li>' : '')
			. ($theme_options["contact_fax"]!="" ? '<li class="fax">' . $theme_options["contact_fax"] . '</li>' : '')		
			. ($theme_options["contact_email"]!="" ? '<li class="email">' . $theme_options["contact_email"] . '</li>' : '')				
		. '</ul>';
	$output .= '</div>';
	return $output;
}
add_shortcode("contact_details", "theme_contact_details");

//google map
function theme_map_shortcode($atts)
{
	extract(shortcode_atts(array(
		"id" => "map",
		"class" => "contact_details_map",
		"map_type" => "ROADMAP",
		"lat" => "-37.732304",
		"lng" => "144.868641",
		"marker_lat" => "-37.732304",
		"marker_lng" => "144.868641",
		"zoom" => "12",
		"streetviewcontrol" => "false",
		"maptypecontrol" => "false",
		"icon_url" => get_template_directory_uri() . "/images/map_pointer.png",
		"icon_width" => 29,
		"icon_height" => 38,
		"icon_anchor_x" => 14,
		"icon_anchor_y" => 37
	), $atts));
	$output = "<div id='" . $id . "' class='" . $class . "'></div>
	<script type='text/javascript'>
	var map_$id = null;
	var coordinate_$id;
	try
    {
        coordinate_$id=new google.maps.LatLng($lat, $lng);
        var mapOptions= 
        {
            zoom:$zoom,
            center:coordinate_$id,
            mapTypeId:google.maps.MapTypeId.$map_type,
			streetViewControl:$streetviewcontrol,
			mapTypeControl:$maptypecontrol
        };
        var map_$id = new google.maps.Map(document.getElementById('$id'),mapOptions);";
	if($marker_lat!="" && $marker_lng!="")
	{
	$output .= "
		var marker_$id = new google.maps.Marker({
			position: new google.maps.LatLng($marker_lat, $marker_lng),
			map: map_$id" . ($icon_url!="" ? ", icon: new google.maps.MarkerImage('$icon_url', new google.maps.Size($icon_width, $icon_height), null, new google.maps.Point($icon_anchor_x, $icon_anchor_y))" : "") . "
		});";
		/*var infowindow = new google.maps.InfoWindow();
		infowindow.setContent('<p style=\'color:#000;\'>your html content</p>');
		infowindow.open(map_$id,marker_$id);*/
	}
	$output .= "
    }
    catch(e) {};
	jQuery(document).ready(function($){
		$(window).resize(function(){
			if(map_$id!=null)
				map_$id.setCenter(coordinate_$id);
		});
	});
	</script>";
	return $output;
}
add_shortcode($themename . "_map", "theme_map_shortcode");
?>