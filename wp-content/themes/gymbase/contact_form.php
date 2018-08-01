<?php
//contact form
function theme_contact_form_shortcode($atts)
{
	global $themename;
	$output = "";
	$output .= '<form class="contact_form" id="contact_form" method="post" action="">
		<fieldset class="left">
			<div class="block">
				<input class="text_input" name="name" type="text" value="' . __('Your name', 'gymbase') . '" placeholder="' . __('Your name', 'gymbase') . '" />
			</div>
			<div class="block">
				<input class="text_input" name="email" type="text" value="' . __('Your email', 'gymbase') . '" placeholder="' . __('Your email', 'gymbase') . '" />
			</div>
			<div class="block">
				<input class="text_input" name="website" type="text" value="' . __('Website (optional)', 'gymbase') . '" placeholder="' . __('Website (optional)', 'gymbase') . '" />
			</div>
		</fieldset>
		<fieldset class="right">
			<div class="block">
				<textarea name="message" placeholder="' . __('Message', 'gymbase') . '">' . __('Message', 'gymbase') . '</textarea>
			</div>
			<input name="submit" type="submit" value="' . __('Send', 'gymbase') . '" />
			<input type="hidden" name="action" value="theme_contact_form" />
		</fieldset>
	</form>';
	return $output;
}
add_shortcode($themename . "_contact_form", "theme_contact_form_shortcode");

//contact form submit
function theme_contact_form()
{
	global $theme_options;
	global $themename;

    require_once("phpMailer/class.phpmailer.php");

    $result = array();
	$result["isOk"] = true;
	if($_POST["name"]!="" && $_POST["name"]!=__("Your name", 'gymbase') && $_POST["email"]!="" && $_POST["email"]!=__("Your email", 'gymbase') && preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$#", $_POST["email"]) && $_POST["message"]!="" && $_POST["message"]!=__("Message", 'gymbase'))
	{
		$values = array(
			"name" => $_POST["name"],
			"email" => $_POST["email"],
			"website" => $_POST["website"],
			"message" => $_POST["message"]
		);
		if((bool)ini_get("magic_quotes_gpc")) 
			$values = array_map("stripslashes", $values);
		$values = array_map("htmlspecialchars", $values);

		$mail=new PHPMailer();

		$mail->CharSet='UTF-8';

		$mail->SetFrom($values["email"], $values["name"]);
		$mail->AddAddress($theme_options["cf_admin_email"], $theme_options["cf_admin_name"]);

		$smtp = $theme_options["cf_smtp_host"];
		if(!empty($smtp))
		{
			$mail->IsSMTP();
			$mail->SMTPAuth = true; 
			$mail->Host = $theme_options["cf_smtp_host"];
			$mail->Username = $theme_options["cf_smtp_username"];
			$mail->Password = $theme_options["cf_smtp_password"];
			if((int)$theme_options["cf_smtp_port"]>0)
				$mail->Port = (int)$theme_options["cf_smtp_port"];
			$mail->SMTPSecure = $theme_options["cf_smtp_secure"];
		}

		$mail->Subject = $theme_options["cf_email_subject"];
		$body = $theme_options["cf_template"];
		$body = str_replace("[name]", $values["name"], $body);
		$body = str_replace("[email]", $values["email"], $body); 
		$body = str_replace("[website]", $values["website"], $body);
		$body = str_replace("[message]", $values["message"], $body);
		$mail->MsgHTML($body);

		if($mail->Send())
			$result["submit_message"] = __("Thank you for contacting us", 'gymbase');
		else
		{
			$result["isOk"] = false;
			$result["submit_message"] = __("Sorry, we can't send this message", 'gymbase');
		}
	}
	else
	{
		$result["isOk"] = false;
		if($_POST["name"]=="" || $_POST["name"]==__("Your name", 'gymbase'))
			$result["error_name"] = __("Please enter your name", 'gymbase');
		if($_POST["email"]=="" || $_POST["email"]==__("Your email", 'gymbase') || !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$#", $_POST["email"]))
			$result["error_email"] = __("Please enter valid e-mail", 'gymbase');
		if($_POST["message"]=="" || $_POST["message"]==__("Message", 'gymbase'))
			$result["error_message"] = __("Please enter your message", 'gymbase');
	}
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_theme_contact_form", "theme_contact_form");
add_action("wp_ajax_nopriv_theme_contact_form", "theme_contact_form");
?>