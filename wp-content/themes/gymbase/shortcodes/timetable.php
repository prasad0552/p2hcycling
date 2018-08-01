<?php
//timetable
function theme_timetable($atts, $content)
{
	global $themename;
	extract(shortcode_atts(array(
		"class" => "",
		"classes_url" => get_home_url() . "/classes/",
		"filter_style" => "",
		"mode" => "",
		"hour_category" => ""
	), $atts));
	$classes_array = array_filter(array_map('trim', explode(",", $class)));

	$output .= '[raw]<div class="tabs page_margin_top">';
	if($filter_style=="dropdown_list")
	{
		$outputSelect = '<select class="timetable_dropdown_navigation">
						<option value="#all-classes">' . __("All Classes", 'gymbase') . '</option>';
	}
	$output .= '<ul class="clearfix tabs_navigation"' . ($filter_style=="dropdown_list" ? ' style="display: none;"' : '') . '>
			<li>
				<a href="#all-classes" title="' . __("All Classes", 'gymbase') . '">
					' . __("All Classes", 'gymbase') . '
				</a>
			</li>';
			$classes_array_count = count($classes_array);
			for($i=0; $i<$classes_array_count; $i++)
			{
				query_posts(array(
					"name" => $classes_array[$i],
					'post_type' => 'classes',
					'post_status' => 'publish'
				));
				if(have_posts())
				{
					the_post();
					if($filter_style=="dropdown_list")
						$outputSelect .= '<option value="#' . $classes_array[$i] . '">' . get_the_title() . '</option>';
					$output .= '<li>
						<a href="#' . $classes_array[$i] . '" title="' . esc_attr(get_the_title()) . '">
							' . get_the_title() . '
						</a>
					</li>';
				}
			}
	if($filter_style=="dropdown_list")
		$outputSelect .= '</select>';
	$output .= '</ul>';
	$output .= $outputSelect;
	$output .= '<div id="all-classes">' . get_timetable($classes_url, $classes_array, $mode, $hour_category) . '</div>';
	for($i=0; $i<$classes_array_count; $i++)
		$output .= '<div id="' . $classes_array[$i] . '">' . get_timetable($classes_url, $classes_array[$i], $mode, $hour_category) . '</div>';
	$output .= '</div>[/raw]';
	
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("timetable", "theme_timetable");

function hour_in_array($hour, $array)
{
	$array_count = count($array);
	for($i=0; $i<$array_count; $i++)
	{
		if((bool)$array[$i]["displayed"]!=true && (int)$array[$i]["start"]==(int)$hour)
			return true;
	}
	return false;
}
function get_rowspan_value($hour, $array, $rowspan)
{
	$array_count = count($array);
	$found = false;
	$hours = array();
	for($i=(int)$hour; $i<(int)$hour+$rowspan; $i++)
		$hours[] = $i;
	for($i=0; $i<$array_count; $i++)
	{
		if(in_array((int)$array[$i]["start"], $hours))
		{
			$end_explode = explode(".", $array[$i]["end"]);
			$end_hour = (int)$array[$i]["end"] + ((int)$end_explode[1]>0 ? 1 : 0);
			if($end_hour-(int)$hour>1 && $end_hour-(int)$hour>$rowspan)
			{
				$rowspan = $end_hour-(int)$hour;
				$found = true;
			}
		}
		
	}
	if(!$found)
		return $rowspan;
	else
		return get_rowspan_value($hour, $array, $rowspan);
}
function get_row_content($classes, $classes_url, $mode)
{
	global $themename;
	$content = "";
	
	$tooltip = "";
	foreach($classes as $key=>$details)
	{
		$color = "";
		$textcolor = ""; 
                $temp = explode('_',$key);
		$key = $temp[0]; 
		if(count($classes)>1)
		{
			$color = get_post_meta($details["id"], $themename . "_color", true);
		}
		$text_color = get_post_meta($details["id"], $themename . "_text_color", true);
		$content .= ($content!="" ? '<br /><br />' : '') . '<a' . ($color!="" || $text_color!="" ? ' style="' . ($color!="" ? 'background-color: #' . $color . ';' : '') . ($text_color!="" ? 'color: #' . $text_color . ';' : '') . '"': '') . ' href="' . $classes_url . '#' . urldecode($details["name"]) . '" title="' .  esc_attr($key) . '">' . $key . '</a>';
		$hours_count = count($details["hours"]);
		for($i=0; $i<$hours_count; $i++)
		{
			if($mode=="12h")
			{
				$hoursExplode = explode(" - ", $details["hours"][$i]);
				$details["hours"][$i] = date("h.i a", strtotime($hoursExplode[0])) . " - " . date("h.i a", strtotime($hoursExplode[1]));
			}
			$content .= ($i!=0 ? '<br />' : '');
			if($details["before_hour_text"][$i]!="")
				$content .= "<div class='before_hour_text'>" . $details["before_hour_text"][$i] . "</div>";
			$content .= $details["hours"][$i];
			if($details["after_hour_text"][$i]!="")
				$content .= "<div class='after_hour_text'>" . $details["after_hour_text"][$i] . "</div>";
			if($details["trainers"][$i]!="")
				$content .= "<div class='class_trainers'>" . $details["trainers"][$i] . "</div>";	
			$tooltip .= ($tooltip!="" && $details["tooltip"][$i]!="" ? '<br />' : '' ) . $details["tooltip"][$i];
		}
	}
	if($tooltip!="")
		$content .= '<div class="tooltip_text"><div class="tooltip_content">' . $tooltip . '</div></div>';	
	return $content;
}
function get_timetable($classes_url, $class = null, $mode = null, $hour_category = null)
{
	global $themename;
	global $blog_id;
	global $wpdb;
	if($hour_category!=null)
		$hour_category = explode(",", $hour_category);
	$output = ""; 
	$query = "SELECT TIME_FORMAT(t1.start, '%H.%i') AS start, TIME_FORMAT(t1.end, '%H.%i') AS end, t1.tooltip AS tooltip, t1.before_hour_text AS before_hour_text, t1.after_hour_text AS after_hour_text, t1.trainers AS trainers, t2.ID AS class_id, t2.post_title AS class_title, t2.post_name AS post_name, t3.post_title, t3.menu_order FROM ".$wpdb->prefix."class_hours AS t1 
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.class_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID 
			WHERE 
			t2.post_type='classes'
			AND t2.post_status='publish'";
	if(is_array($class) && count($class))
		$query .= "
			AND t2.post_name IN('" . join("','", $class) . "')";
	else if($class!=null)
		$query .= "
			AND t2.post_name='" . strtolower(urlencode($class)) . "'";
	if($hour_category!=null)
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='" . $themename . "_weekdays'
			ORDER BY FIELD(t3.menu_order,2,3,4,5,6,7,1), t1.start, t1.end";
	$class_hours = $wpdb->get_results($query);
	$class_hours_tt = array();
	foreach($class_hours as $class_hour)
	{
		$trainersString = "";
		if($class_hour->trainers!="")
		{
			query_posts(array( 
				'post__in' => explode(",", $class_hour->trainers),
				'post_type' => 'trainers',
				'posts_per_page' => '-1',
				'post_status' => 'publish',
				'orderby' => 'post_title', 
				'order' => 'DESC'
			));
			while(have_posts()): the_post();
				$trainersString .= get_the_title() . ", ";
			endwhile;
			if($trainersString!="")
				$trainersString = substr($trainersString, 0, -2);
		}
		$class_hours_tt[($class_hour->menu_order>1 ? $class_hour->menu_order-1 : 7)][] = array(
			"start" => $class_hour->start,
			"end" => $class_hour->end,
			"tooltip" => $class_hour->tooltip,
			"before_hour_text" => $class_hour->before_hour_text,
			"after_hour_text" => $class_hour->after_hour_text,
			"trainers" => $trainersString,
			"tooltip" => $class_hour->tooltip,
			"id" => $class_hour->class_id,
			"title" => $class_hour->class_title,
			"name" => $class_hour->post_name
		);
	}
	
	$output .= '<table class="timetable">
				<thead>
					<tr>
						<th></th>';
	//get weekdays
	$query = "SELECT post_title, menu_order FROM {$wpdb->posts}
			WHERE 
			post_type='" . $themename . "_weekdays'
			AND post_status='publish'
			ORDER BY FIELD(menu_order,2,3,4,5,6,7,1)";
	$weekdays = $wpdb->get_results($query);
	foreach($weekdays as $weekday)
	{
		$output .= '	<th>' . strtoupper($weekday->post_title) . '</th>';
	}
	$output .= '	</tr>
				</thead>
				<tbody>';
	//get min anx max hour
	$query = "SELECT min(TIME_FORMAT(t1.start, '%H.%i')) AS min, max(REPLACE(TIME_FORMAT(t1.end, '%H.%i'), '00.00', '24.00')) AS max FROM ".$wpdb->prefix."class_hours AS t1
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.class_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID 
			WHERE 
			t2.post_type='classes'
			AND t2.post_status='publish'";
	if(is_array($class) && count($class))
		$query .= "
			AND t2.post_name IN('" . join("','", $class) . "')";
	else if($class!=null)
		$query .= "
			AND t2.post_name='" . strtolower(urlencode($class)) . "'";
	if($hour_category!=null)
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='" . $themename . "_weekdays'";
	$hours = $wpdb->get_row($query);
	$drop_columns = array();
	$l = 0;
	$max_explode = explode(".", $hours->max);
	$max_hour = (int)$hours->max + ((int)$max_explode[1]>0 ? 1 : 0);
	for($i=(int)$hours->min; $i<$max_hour; $i++)
	{
		$start = str_pad($i, 2, '0', STR_PAD_LEFT) . '.00';
		$end = str_replace("24", "00", str_pad($i+1, 2, '0', STR_PAD_LEFT)) . '.00';
		if($mode=="12h")
		{
			$start = date("h.i a", strtotime($start));
			$end = date("h.i a", strtotime($end));
		}
		$output .= '<tr class="row_' . ($l+1) . ($l%2==0 ? ' row_gray' : '') . '">
						<td>
							' . $start . ' - ' . $end . '
						</td>';
						for($j=1; $j<=count($weekdays); $j++)
						{
							if(!in_array($j, (array)$drop_columns[$i]["columns"]))
							{
								if(hour_in_array($i, $class_hours_tt[$j]))
								{
									$rowspan = get_rowspan_value($i, $class_hours_tt[$j], 1);
									if($rowspan>1)
									{
										for($k=1; $k<$rowspan; $k++)
											$drop_columns[$i+$k]["columns"][] = $j;	
									}
									$array_count = count($class_hours_tt[$j]);
									$hours = array();
									for($k=(int)$i; $k<(int)$i+$rowspan; $k++)
										$hours[] = $k;
									$classes = array();
									for($k=0; $k<$array_count; $k++)
									{
										if(in_array((int)$class_hours_tt[$j][$k]["start"], $hours))
										{
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["name"] = $class_hours_tt[$j][$k]["name"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["tooltip"][] = $class_hours_tt[$j][$k]["tooltip"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["before_hour_text"][] = $class_hours_tt[$j][$k]["before_hour_text"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["after_hour_text"][] = $class_hours_tt[$j][$k]["after_hour_text"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["trainers"][] = $class_hours_tt[$j][$k]["trainers"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["id"] = $class_hours_tt[$j][$k]["id"];
											$classes[$class_hours_tt[$j][$k]["title"].'_'.$k]["hours"][] = $class_hours_tt[$j][$k]["start"] . " - " . $class_hours_tt[$j][$k]["end"];
											$class_hours_tt[$j][$k]["displayed"] = true;
										}
									}
									$color = "";
									$text_color = "";
									if(count($classes)==1)
									{
										$color = get_post_meta($classes[key($classes)]["id"], $themename . "_color", true);
										$text_color = get_post_meta($classes[key($classes)]["id"], $themename . "_text_color", true);
									}
									$output .= '<td' . ($color!="" || $text_color!="" ? ' style="' . ($color!="" ? 'background-color: #' . $color . ';' : '') . ($text_color!="" ? 'color: #' . $text_color . ';' : '') . '"': '') . ' class="event' . (count(array_filter(array_values($classes[key($classes)]['tooltip']))) ? ' tooltip' : '' ) . '"' . ($rowspan>1 ? ' rowspan="' . $rowspan . '"' : '') . '>';
									$output .= get_row_content($classes, $classes_url, $mode);
									$output .= '</td>';
								}
								else
									$output .= '<td></td>';
							}
						}
		$output .= '</tr>';
		$l++;
	}
	$output .= '	<tr>
						<td colspan="8" class="last">
							<div class="tip">
								' . __("Click on the class name to get additional info", 'gymbase') . '
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="timetable small">';
	$l = 0;
	foreach($weekdays as $weekday)
	{
		$weekday_fixed_number = ($weekday->menu_order>1 ? $weekday->menu_order-1 : 7);
		if(isset($class_hours_tt[$weekday_fixed_number]))
		{
			$output .= '<h3 class="box_header' . ($l>0 ? ' page_margin_top' : '') . '">
				' . $weekday->post_title . '
			</h3>
			<ul class="items_list dark opening_hours">';
				$class_hours_count = count($class_hours_tt[$weekday_fixed_number]);
					
				for($i=0; $i<$class_hours_count; $i++)
				{
					if($mode=="12h")
					{
						$class_hours_tt[$weekday_fixed_number][$i]["start"] = date("h.i a", strtotime($class_hours_tt[$weekday_fixed_number][$i]["start"]));
						$class_hours_tt[$weekday_fixed_number][$i]["end"] = date("h.i a", strtotime($class_hours_tt[$weekday_fixed_number][$i]["end"]));
					}
					$output .= '<li class="icon_clock_green">
							<a href="' . $classes_url . '#' . urldecode($class_hours_tt[$weekday_fixed_number][$i]["name"]) . '" title="' . $class_hours_tt[$weekday_fixed_number][$i]["title"] . '">
								' . $class_hours_tt[$weekday_fixed_number][$i]["title"] . '
							</a>
							<div class="value">
								' . $class_hours_tt[$weekday_fixed_number][$i]["start"] . ' - ' . $class_hours_tt[$weekday_fixed_number][$i]["end"] . '
							</div>
						</li>';
				}
			$output .= '</ul>';
			$l++;
		}
	}
	$output .= '</div>';
	return $output;
}
?>