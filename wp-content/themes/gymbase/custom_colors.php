<!--custom style-->
<style type="text/css">
	<?php if($theme_options["header_background_color"]!=""): ?>
	.header_container
	{
		background-color: #<?php echo $theme_options["header_background_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_background_color"]!=""): ?>
	body
	{
		background-color: #<?php echo $theme_options["body_background_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_background_color"]!=""): ?>
	.footer_container
	{
		background-color: #<?php echo $theme_options["footer_background_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_headers_color"]!=""): ?>
	h1, h2, h3, h4, h5,
	h1 a, h2 a, h3 a, h4 a, h5 a
	{
		color: #<?php echo $theme_options["body_headers_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_headers_border_color"]!=""): ?>
	.box_header
	{
		<?php if($theme_options["body_headers_border_color"]=="none"): ?>
		border-bottom: none;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["body_headers_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["body_text_color"]!=""): ?>
	p,
	.post_content .text,
	#comments_list .comment_details p,
	.accordion .ui-accordion-content,
	.timetable,
	.gallery_item_details_list .details_box p,
	.gallery_item_details_list .details_box .list,
	.scrolling_list li,
	.scrolling_list li a
	{
		color: #<?php echo $theme_options["body_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_text2_color"]!=""): ?>
	.bread_crumb li,
	.accordion .ui-accordion-header h5,
	#comments_list .comment_details .posted_by,
	.header_top_sidebar 
	{
		color: #<?php echo $theme_options["body_text2_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_headers_color"]!=""): ?>
	.footer h1, .footer h2, .footer h3, .footer h4, .footer h5,
	.footer h1 a, .footer h2 a, .footer h3 a, .footer h4 a, .footer h5 a
	{
		color: #<?php echo $theme_options["footer_headers_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_headers_border_color"]!=""): ?>
	.footer .box_header
	{
		<?php if($theme_options["footer_headers_border_color"]=="none"): ?>
		border-bottom: none;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["footer_headers_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["footer_text_color"]!=""): ?>
	.footer_contact_info_row,
	.copyright_area,
	.copyright_right .scroll_top,
	.footer .scrolling_list li,
	.footer .scrolling_list li a
	{
		color: #<?php echo $theme_options["footer_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["timeago_label_color"]!=""): ?>
	.timeago, .trainers .value
	{
		color: #<?php echo $theme_options["timeago_label_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["sentence_color"]!=""): ?>
	.sentence,
	.info_green,
	.gallery_item_details_list .details_box .subheader
	{
		color: #<?php echo $theme_options["sentence_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["logo_first_part_text_color"]!=""): ?>
	.logo_left
	{
		color: #<?php echo $theme_options["logo_first_part_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["logo_second_part_text_color"]!=""): ?>
	.logo_right
	{
		color: #<?php echo $theme_options["logo_second_part_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_button_color"]!=""): ?>
	.more,
	.ui-tabs-nav li a,
	.tabs_navigation li a,
	.scrolling_list li .number,
	.categories li, .widget_categories li,
	.categories li a, .widget_categories li a,
	.pagination li a, .pagination li span
	{
		color: #<?php echo $theme_options["body_button_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_button_hover_color"]!="" || $theme_options["body_button_border_hover_color"]!=""): ?>
	.more:hover,
	.categories li a:hover,
	.widget_categories li a:hover,
	li.current-cat a,
	.scrolling_list_control_left:hover, 
	.scrolling_list_control_right:hover,
	.search input[type='submit']:hover,
	.comment_form input[type='submit']:hover,
	.contact_form input[type='submit']:hover,
	.pagination li a:hover,
	.pagination li.selected a,
	.pagination li.selected span,
	.scrolling_list li a:hover .number,
	.ui-tabs-nav li a:hover,
	.ui-tabs-nav li.ui-tabs-active a,
	.tabs_navigation li a:hover,
	.tabs_navigation li a.selected
	{
		<?php if($theme_options["body_button_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["body_button_hover_color"]; ?>;
		<?php endif;
		if($theme_options["body_button_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["body_button_border_hover_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["body_button_border_color"]!=""): ?>
	.more,
	.categories li a,
	.widget_categories li a,
	.scrolling_list_control_left, 
	.scrolling_list_control_right,
	.pagination li a,
	.pagination li span,
	.scrolling_list li .number,
	.ui-tabs-nav li a,
	.tabs_navigation li a,
	.categories li.posted_by
	{
		border-color: #<?php echo $theme_options["body_button_border_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_button_color"]!=""): ?>
	.footer .ui-tabs-nav li a,
	.footer .tabs_navigation li a,
	.footer .scrolling_list li .number,
	.footer .categories li, .widget_categories li,
	.footer .categories li a, .widget_categories li a
	{
		color: #<?php echo $theme_options["footer_button_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_button_hover_color"]!="" || $theme_options["footer_button_border_hover_color"]!=""): ?>
	.footer .more:hover,
	.footer .categories li a:hover,
	.footer .widget_categories li a:hover,
	.footer li.current-cat a,
	.footer .scrolling_list_control_left:hover, 
	.footer .scrolling_list_control_right:hover,
	.footer .scrolling_list li a:hover .number,
	.footer .ui-tabs-nav li a:hover,
	.footer .ui-tabs-nav li.ui-tabs-selected a,
	.footer .tabs_navigation li a:hover,
	.footer .tabs_navigation li a.selected
	{
		<?php if($theme_options["footer_button_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["footer_button_hover_color"]; ?>;
		<?php endif;
		if($theme_options["footer_button_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["footer_button_border_hover_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["footer_button_border_color"]!=""): ?>
	.footer .more,
	.footer .categories li a,
	.footer .widget_categories li a,
	.footer .scrolling_list_control_left, 
	.footer .scrolling_list_control_right,
	.footer .scrolling_list li .number,
	.footer .ui-tabs-nav li a,
	.footer .tabs_navigation li a
	{
		border-color: #<?php echo $theme_options["footer_button_border_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["menu_link_color"]!=""): ?>
	.sf-menu li a, .sf-menu li a:visited
	{
		color: #<?php echo $theme_options["menu_link_color"] ?>;
	}
	<?php endif; 
	if($theme_options["menu_link_border_color"]!=""): ?>
	.sf-menu li a, .sf-menu li a:visited
	{
		border-bottom: 2px solid #<?php echo $theme_options["menu_link_border_color"] ?>;
	}
	<?php endif; 
	if($theme_options["menu_active_color"]!="" || $theme_options["menu_active_border_color"]!=""): ?>
	.sf-menu li.selected a, .sf-menu li.current-menu-item a
	{
		<?php if($theme_options["menu_active_color"]!=""): ?>
		color: #<?php echo $theme_options["menu_active_color"] ?>;
		<?php endif; 
		if($theme_options["menu_active_border_color"]!=""):
			if($theme_options["menu_active_border_color"]=="none"): ?>
			border-bottom: none;
			<?php else: ?>
			border-bottom: 2px solid #<?php echo $theme_options["menu_active_border_color"] ?>;
			<?php endif;
		endif;?>
	}
	<?php endif;
	if($theme_options["menu_hover_color"]!=""): ?>
	.sf-menu li:hover a
	{
		color: #<?php echo $theme_options["menu_hover_color"] ?>;
	}
	<?php endif; 
	if($theme_options["menu_hover_border_color"]!=""): ?>
	.sf-menu li:hover a
	{
		<?php if($theme_options["menu_hover_border_color"]=="none"): ?>
		border-bottom: none;
		<?php else: ?>
		border-bottom: 2px solid #<?php echo $theme_options["menu_hover_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["submenu_background_color"]!=""): ?>
	.sf-menu li ul li,
	.sf-menu li ul li a
	{
		background-color: #<?php echo $theme_options["submenu_background_color"] ?>;
	}
	<?php endif; 
	if($theme_options["submenu_hover_background_color"]!=""): ?>
	.sf-menu li ul li a:hover, .sf-menu li ul li.selected a
	{
		background-color: #<?php echo $theme_options["submenu_hover_background_color"] ?>;
	}
	<?php endif; 
	if($theme_options["submenu_color"]!=""): ?>
	.sf-menu li ul li a, .sf-menu li:hover ul li a
	{
		color: #<?php echo $theme_options["submenu_color"] ?>;
	}
	<?php endif; 
	if($theme_options["submenu_hover_color"]!=""): ?>
	.sf-menu li ul li a:hover, .sf-menu li ul li.selected a
	{
		color: #<?php echo $theme_options["submenu_hover_color"] ?>;
	}
	<?php endif; 
	if($theme_options["form_hint_color"]!=""): ?>
	input[type='text'].hint, textarea.hint
	{
		color: #<?php echo $theme_options["form_hint_color"]; ?> !important;
	}
	<?php endif; 
	if($theme_options["form_field_text_color"]!=""): ?>
	.search input,
	.comment_form input, .comment_form textarea,
	.contact_form input, .contact_form textarea
	{
		color: #<?php echo $theme_options["form_field_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["form_field_border_color"]!=""): ?>
	.search input,
	.comment_form input, .comment_form textarea,
	.contact_form input, .contact_form textarea
	{
		<?php if($theme_options["form_field_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border: 1px solid #<?php echo $theme_options["form_field_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["form_field_active_border_color"]!=""): ?>
	.search .search_input:focus,
	.comment_form .text_input:focus, .comment_form textarea:focus,
	.contact_form .text_input:focus, .contact_form textarea:focus
	{
		<?php if($theme_options["form_field_active_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border: 1px solid #<?php echo $theme_options["form_field_active_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["link_color"]!=""): ?>
	a,
	.scrolling_list.latest_tweets li a,
	.items_list a,
	.scrolling_list li a,
	.footer .scrolling_list li a
	{
		color: #<?php echo $theme_options["link_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["link_hover_color"]!=""): ?>
	a:hover,
	.scrolling_list.latest_tweets li a:hover,
	.scrolling_list li a:hover,
	.footer .scrolling_list li a:hover
	{
		color: #<?php echo $theme_options["link_hover_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["date_box_color"]!="" || $theme_options["date_box_text_color"]!="") : ?>
	.comment_box .first_row
	{
		<?php if($theme_options["date_box_color"]!=""): ?>
		background-color: #<?php echo $theme_options["date_box_color"]; ?>;
		<?php endif;
		if($theme_options["date_box_text_color"]!=""): ?>
		color: #<?php echo $theme_options["date_box_text_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["date_box_comments_number_text_color"]!=""): ?>
	.comment_box .comments_number
	{
		color: #<?php echo $theme_options["date_box_comments_number_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["date_box_comments_number_border_color"]!=""): ?>
	.comment_box .comments_number
	{
		<?php if($theme_options["date_box_comments_number_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["date_box_comments_number_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["date_box_comments_number_hover_border_color"]!=""): ?>
	.comment_box .comments_number:hover
	{
		<?php if($theme_options["date_box_comments_number_hover_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["date_box_comments_number_hover_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["gallery_box_color"]!=""): ?>
	.gallery_box .description
	{
		background-color: #<?php echo $theme_options["gallery_box_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_text_first_line_color"]!=""): ?>
	.gallery_box h3
	{
		color: #<?php echo $theme_options["gallery_box_text_first_line_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_text_second_line_color"]!=""): ?>
	.gallery_box .description h5
	{
		color: #<?php echo $theme_options["gallery_box_text_second_line_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_hover_color"]!=""): ?>
	.gallery_box:hover .description
	{
		background-color: #<?php echo $theme_options["gallery_box_hover_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_hover_text_first_line_color"]!=""): ?>
	.gallery_box:hover h3
	{
		color: #<?php echo $theme_options["gallery_box_hover_text_first_line_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_hover_text_second_line_color"]!=""): ?>
	.gallery_box:hover .description h5
	{
		color: #<?php echo $theme_options["gallery_box_hover_text_second_line_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["timetable_box_color"]!=""): ?>
	.timetable .event
	{
		background-color: #<?php echo $theme_options["timetable_box_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["timetable_box_hover_color"]!=""): ?>
	.timetable .event:hover
	{
		background-color: #<?php echo $theme_options["timetable_box_hover_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_details_box_border_color"]!=""): ?>
	.gallery_item_details_list .details_box
	{
		<?php if($theme_options["gallery_details_box_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-top: 2px solid #<?php echo $theme_options["gallery_details_box_border_color"] ?>;
		border-bottom: 2px solid #<?php echo $theme_options["gallery_details_box_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["bread_crumb_border_color"]!=""): ?>
	.bread_crumb
	{
		<?php if($theme_options["bread_crumb_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-top: 1px solid #<?php echo $theme_options["bread_crumb_border_color"] ?>;
		border-bottom: 1px solid #<?php echo $theme_options["bread_crumb_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["accordion_item_border_color"]!=""): ?>
	.accordion .ui-accordion-header,
	.ui-accordion-header
	{
		<?php if($theme_options["accordion_item_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["accordion_item_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["accordion_item_border_hover_color"]!=""): ?>
	.accordion .ui-accordion-header.ui-state-hover,
	.ui-accordion-header.ui-state-hover
	{
		<?php if($theme_options["accordion_item_border_hover_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["accordion_item_border_hover_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["accordion_item_border_active_color"]!=""): ?>
	.accordion .ui-accordion-header.ui-state-active,
	.ui-accordion-header.ui-state-active
	{
		<?php if($theme_options["accordion_item_border_active_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-bottom: 2px solid #<?php echo $theme_options["accordion_item_border_active_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["copyright_area_border_color"]!=""): ?>
	.copyright_area
	{
		<?php if($theme_options["copyright_area_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-top: 1px solid #<?php echo $theme_options["copyright_area_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["top_hint_background_color"]!=""): ?>
	.top_hint
	{
		background-color: #<?php echo $theme_options["top_hint_background_color"]; ?>;
	}
	<?php endif;
	if($theme_options["top_hint_text_color"]!=""): ?>
	.top_hint
	{
		color: #<?php echo $theme_options["top_hint_text_color"]; ?>;
	}
	<?php endif;
	if($theme_options["comment_reply_button_color"]!=""): ?>
	#comments_list .reply_button
	{
		color: #<?php echo $theme_options["comment_reply_button_color"]; ?>;
	}
	<?php endif;
	if($theme_options["post_author_link_color"]!=""): ?>
	.categories li.posted_by .author,
	#comments_list .comment_details .posted_by a
	{
		color: #<?php echo $theme_options["post_author_link_color"]; ?>;
	}
	<?php endif;
	if($theme_options["contact_details_box_background_color"]!=""): ?>
	.contact_details_about
	{
		background-color: #<?php echo $theme_options["contact_details_box_background_color"]; ?>;
	}
	<?php endif;
	if($theme_options["header_font"]!=""): $header_font_explode = explode(":", $theme_options["header_font"]); ?>
	h1, h2, h3, h4, h5,
	.header_left a, .logo_left, .logo_right
	{
		font-family: '<?php echo $header_font_explode[0]; ?>';
	}
	<?php endif;
	if($theme_options["subheader_font"]!=""): $subheader_font_explode = explode(":", $theme_options["subheader_font"]); ?>
	.sentence,
	.info_green, .info_white,
	.page_header h4,
	.slider_content .subtitle,
	.home_box h3,
	.accordion .ui-accordion-header h5,
	.gallery_box .description h5,
	.gallery_item_details_list .details_box .subheader,
	.footer_banner_box h3
	{
		font-family: '<?php echo $subheader_font_explode[0]; ?>';
	}
	<?php endif; ?>
</style>