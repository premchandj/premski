<?php
//GLOBALS
$prem_email = "pcj_1 at yahoo dot com";
//$menu_bar_color = "YellowGreen";
//$menu_bar_color = "#FFFF99";
$menu_bar_color = "gold";

//$left_left_color = "#996666";
//$left_left_color = "#FFFFFF";//white
//$left_left_color = "#FFFF99";//light yellow
$left_left_color = "YellowGreen";

$middle_color = "#c6c2f5";
//$right_color = "#c6c2f5";
$right_color = "white";
//$overall_color = "gold";
$overall_color = "LemonChiffon";
//$top_banner_color = "000033";
$top_banner_color = "olive";
$top_banner_content= "http://premski.com";
$development = 1;
$debug = 0;
$NO_OF_GOOGLE_ADS = 3;
$NO_OF_RANDOM_PUZZLES = 2;
//COLOR CHART: http://www.immigration-usa.com/html_colors.html

$global_category_array = array(
     'Google interview'
   , 'Yahoo interview'
   , 'Microsoft interview'
   , ''
);

/*
		+ ->26b17225b626fb9238849fd60eabdf60
		- ->336d5ebc5436534e61d16e63ddfca327
		X ->02129bb861061d1a052c592e2dc6b383
//*/
$global_math_operator_array = array(
     'images/26b17225b626fb9238849fd60eabdf60.jpg'
   , 'images/336d5ebc5436534e61d16e63ddfca327.jpg'
   , 'images/02129bb861061d1a052c592e2dc6b383.jpg'
);


/*
1->c4ca4238a0b923820dcc509a6f75849b
2->c81e728d9d4c2f636f067f89cc14862c
3->eccbc87e4b5ce2fe28308fd9f2a7baf3
4->a87ff679a2f3e71d9181a67b7542122c
5->e4da3b7fbbce2345d7772b0674a318d5
6->1679091c5a880faf6fb5e6087eb1b2dc
7->8f14e45fceea167a5a36dedd4bea2543
8->c9f0f895fb98ab9159f51fd0297e236d
9->45c48cce2e2d7fbdea1afc51c7c6ad26
//*/
$global_numbers_array = array(
     1 => 'images/c4ca4238a0b923820dcc509a6f75849b.jpg'
   , 2 => 'images/c81e728d9d4c2f636f067f89cc14862c.jpg'
   , 3 => 'images/eccbc87e4b5ce2fe28308fd9f2a7baf3.jpg'
   , 4 => 'images/a87ff679a2f3e71d9181a67b7542122c.jpg'
   , 5 => 'images/e4da3b7fbbce2345d7772b0674a318d5.jpg'
   , 6 => 'images/1679091c5a880faf6fb5e6087eb1b2dc.jpg'
   , 7 => 'images/8f14e45fceea167a5a36dedd4bea2543.jpg'
   , 8 => 'images/c9f0f895fb98ab9159f51fd0297e236d.jpg'
   , 9 => 'images/45c48cce2e2d7fbdea1afc51c7c6ad26.jpg'
);

//NO NEED TO ADD 1 letter words to this blacklist
$tag_blacklist_array = array(
       'is', 'an', 'in', 'we'
     , 'the', 'are', 'was'
     , 'this', 'when', 'what', 'when'
);
/////////////PASSWORDS///////////////////////////////////
define("MYSQL_USER", 'prem_prem');
define("MYSQL_PASSWORD", 'v3lovejs');
define("MY_DATABASE", 'prem_premjayamohanDB');
///*
define("HOST_NAME", 'premski.com');
//*/
/*
define("HOST_NAME", 'prem.bangalore.corp.yahoo.com');
//*/
/*
define("HOST_NAME", '127.0.0.1');
//*/
/////////////PASSWORDS///////////////////////////////////

define("TABLE_BORDER", 0);
define("TABLE_BORDER1", 0);
define("CELL_SPACING", 0);



///*
define("ITEM_ENTIRE_TABLE_COLOR", '#2d4f88');//#7c6ccd
define("ITEM_TITLE_TEXT_COLOR", '#ffffff');//#ffffff
define("ITEM_TITLE_BGCOLOR", '#000000');
define("ITEM_DESCRIPTION_TEXT_COLOR", '#000000');//#000000
define("ITEM_DESCRIPTION_BGCOLOR", '#ffffff');//#ffffff
define("ITEM_DESCRIPTION_TR_BGCOLOR", '#ffffff');//#ffffff
define("ITEM_LINK_BGCOLOR", '#aaaaaa');//#eef0fd
define("ITEM_PUBDATE_TEXT_COLOR", '#ffffff');//#eef0fd
//*/


/*
define("ITEM_ENTIRE_TABLE_COLOR", '#7c6ccd');//#7c6ccd
define("ITEM_TITLE_TEXT_COLOR", '#ffffff');//#ffffff
define("ITEM_TITLE_BGCOLOR", '#000000');
define("ITEM_DESCRIPTION_TEXT_COLOR", '#000000');//#000000
define("ITEM_DESCRIPTION_BGCOLOR", '#ffffff');//#ffffff
define("ITEM_DESCRIPTION_TR_BGCOLOR", '#ffffff');//#ffffff
define("ITEM_LINK_BGCOLOR", '#eef0fd');//#eef0fd
define("ITEM_PUBDATE_TEXT_COLOR", '#ffffff');//#eef0fd
//*/

define("TAG_DELIMITER", ',');
define("TAG_MIN_LENGTH", 2);
define("TAG_MAX_LENGTH", 20);
define("MAX_TAGS_IN_ONE_SHOT", 1000);

define("TABLE_NUM_OF_SPACES", 0);
define("TEXTAREA_COLS_PERCENTAGE", 45);



define("PREM_REAL_USER_NAME", 'prem');
define("PREM_REAL_USER_PASSWORD", '');
define("PREM_REAL_EMAIL", 'pcj_1@yahoo.com');

define("USER_TYPE_NORMAL", 'NORMAL');
define("USER_TYPE_ADMIN", 'ADMIN');
define("USER_TYPE_TAGGER", 'TAGGER');

define("REPLY_TYPE_URL", 'reply_type_url');
define("REPLY_TYPE_BUTTON", 'reply_type_button');


define("BLOG_BOARD_NAME", 'Blog');
define("FEEBDACK_BOARD_NAME", 'Feedback');
define("RESOURCE_BOARD_NAME", 'Resources');

define("BLOG_BOARD_ID", 'be8df1f28c0abc85a0ed0c6860e5d832');
define("FEEDBACK_BOARD_ID", 'bea4c2c8eb82d05891ddd71584881b56');
define("RESOURCE_BOARD_ID", 'ddcf50c29294d4414f3f7c1bbc892cb5');

define("NO_OF_MESSAGES_PER_PAGE", 10);
define("MAX_BOARDS_TO_GET", 10);

define("APPLICATION_NAME_MAX_LENGTH", 128);
define("APPLICATION_TITLE_MAX_LENGTH", 128);
define("BOARD_ID_MAX_LENGTH", 128);
define("BOARD_NAME_MAX_LENGTH", 128);
define("BOARD_TITLE_MAX_LENGTH", 128);
define("MESSAGE_TITLE_MAX_LENGTH", 128);
define("MESSAGE_LINK_MAX_LENGTH", 128);
define("MAX_INDIVIDUAL_TAG_LENGTH", 30);
define("MAX_USER_NAME_LENGTH", 50);
define("MAX_USER_PASSWORD_LENGTH", 50);
define("MAX_EMAIL_LENGTH", 50);
define("MAX_VERIFICATION_KEY_LENGTH", 128);

define("COOKIE_EXPIRY_DAYS", 5);
define("COOKIE_SUBSCRIPTION_EXPIRY_DAYS", 1000);

define("APPLICATION_ID_SQL_TYPE", 'TINYINT');
define("MESSAGE_ID_SQL_TYPE", 'MEDIUMINT');
define("USER_ID_SQL_TYPE", 'INT');
define("TAG_ID_SQL_TYPE", 'INT');
define("DESCRIPTION_SQL_TYPE", 'blob');
define("RATING_SQL_TYPE", 'DOUBLE');

define("PUZZLES_APPLICATION_NAME", 'puzzles');
define("FEEDBACK_APPLICATION_NAME", 'feedback');

define("PREMSKI_RESIGTERED_USER", 'PremskiRegisteredUser');
define("PREMSKI_ANONYMOUS_USER", 'PremskiAnonymousUser');
//define("PREMSKI_ANONYMOUS_USER_DISPLAY", 'Anonymous');
define("PREMSKI_ANONYMOUS_USER_DISPLAY", 'Anon');
define("PREMSKI_ANONYMOUS_USER_ID", 1);


define("PUZZLES_FROM_EMAIL_ADDRESS", 'pcj_1 at yahoo dot com');
define("PUZZLES_EMAIL_VERIFICATION_SUBJECT", 'http://premski.com - Email VERIFICATION');

define("MYSQL_HOST", 'localhost');

define("FORM_VAR_NAME", 'form_name');
define("FORM_VAR_NAME1", '_form_name');

define("NEXT_URL_VAR_NAME", 'next_url');
define("NEXT_URL_VAR_NAME1", '_next_url');

define("PUZZLE_QUESTION_POST_FORM_NAME", "puzzles_post_question");
define("PUZZLE_REPLY_FORM_NAME", "puzzles_reply_question");
define("TESTIMONIAL_FORM_NAME", "Feedback");
define("PUZZLES_TESTIMONIAL_FORM_NAME", "PuzzlesFeedback");
define("NEW_USER_FORM_NAME", "NewUserSignUp");
define("USER_LOGIN_FORM_NAME", "LoginPage");


define("SECRET_STRING", "The Lord is my shepherd i shall not want. Yea though i walk thru.");

define("PUZZLES_APPLICATION_ID", 1);
define("TESTIMONIAL_APPLICATION_ID", 2);

//LIMITS
define("MAX_APPLICATIONS_TO_GET", 10);
define("MAX_MESSAGES_TO_GET", 10);
define("MAX_TITLE_LENGTH", 100);
define("MAX_APPLICATION_NAME_LENGTH", 40);
define("MAX_BOARD_NAME_LENGTH", 80);
define("CREATOR_NAME_LENGTH", 40);
define("MAX_LINK_LENGTH", 1000);
//define("MAX_DESCRIPTION_LENGTH", 4096);
define("MAX_DESCRIPTION_LENGTH", 10000);
define("MAX_TAG_LENGTH", 100);

define("PREV_FIRST_NEXT_ALIGN", 'center');


//ERROR CODES
define("BOARD_EXCEEDS_INPUT_LIMITS", 10);
define("MESSAGE_EXCEEDS_INPUT_LIMITS", 20);
define("TAG_ALREADY_EXISTS", 30);
define("USER_ALREADY_EXISTS", 40);
define("USER_DOES_NOT_EXISTS", 41);
define("USER_VERIFY_SUCCESS", 42);
define("USER_VERIFICATIONKEY_RESET_SUCCESS", 43);


function execute_query(&$q, &$result)
{
   global $development, $debug;
   if($debug){print "\tEXECUTING: \"$q\"\n";}
   $result = mysql_query($q) or die('Query failed: ' . mysql_error());
}

function connect_db(&$link)
{
   $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD)  or die('Could not connect: ' . mysql_error());
   mysql_select_db(MY_DATABASE) or die('Could not select database');
}

function close_db(&$link)
{
   mysql_close($link);
}

function get_client_ip_address()
{
   $create_ip = getenv('REMOTE_ADDR');
   $create_ip_int = sprintf("%u", ip2long($create_ip));
   return $create_ip_int;
}

function generate_verification_code($user_name, $user_email)
{
   $user_verification_key = md5($user_name.$user_email.SECRET_STRING.time());
   return $user_verification_key;
}

function email_user($from_email_address, $to_user, $to_email_address, $subject, $body)
{
   // To send HTML mail, the Content-type header must be set
   $headers  = 'MIME-Version: 1.0' . "\r\n";
   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

   // Additional headers
   $headers .= "To: $to_user <$to_email_address>" . "\r\n";
   $headers .= "From: Premski.com <noreply@premski.com>" . "\r\n";

   $status = mail($to_email_address, $subject, $body, $headers);
   if($status==TRUE){
      //print "MAIL SUCCESSFULLY SENT";
   }
   else{
      //print "MAIL NOT SENT";
   }
}

function send_email_verification($to_email_address, $user, $verification_code)
{
   $body = "<html><br>Thank you for registering with premski.com.<br>";
   $body .= "Please click <a href=http://premski.com/page_gen.php?user=$user&code=$verification_code>HERE</a> to verify.<br></html>";
   $body .= "If you have been mailed wrongly, please delete this mail & sorry for the inconvenience.";
   email_user(PUZZLES_FROM_EMAIL_ADDRESS, $user, $to_email_address, PUZZLES_EMAIL_VERIFICATION_SUBJECT, $body);
}

function delete_premski_cookies()
{
   $expiry_time = time()+60*60*24*COOKIE_EXPIRY_DAYS;
   $stat1 = setcookie('user', "", time()-3600);
   $stat2 = setcookie('key', "", time()-3600);
}

function set_premski_cookies($user_name, $user_password)
{
   $expiry_time = time()+60*60*24*COOKIE_EXPIRY_DAYS;
   delete_premski_cookies();
   $stat3 = setcookie('user', $user_name, $expiry_time);
   $stat4 = setcookie('key', md5($user_password), $expiry_time);
}

function get_user_name(&$HTTP_COOKIE_VARS_COPY)
{
   $user = PREMSKI_ANONYMOUS_USER;
   if(is_array($HTTP_COOKIE_VARS_COPY)){
      if(array_key_exists('user', $HTTP_COOKIE_VARS_COPY) && array_key_exists('key', $HTTP_COOKIE_VARS_COPY)){
         $stat = IsValidUserCredentials($HTTP_COOKIE_VARS_COPY['user'], $HTTP_COOKIE_VARS_COPY['key'], false);
         if($stat){
            $user = $HTTP_COOKIE_VARS_COPY['user'];
         }
      }
   }
   return $user;
}

function sanitize_input_string_no_mysql_connect(&$str)
{
   $str = htmlentities($str);
   $str = mysql_real_escape_string($str);
}

function sanitize_input_string(&$str)
{
   connect_db($link);
   sanitize_input_string_no_mysql_connect($str);
   close_db($link);
}

function sanitize_input(&$str)
{
   connect_db($link);
   if(is_array($str)){
      foreach($str as $array_element)
      {
         sanitize_input_string_no_mysql_connect($array_element);
      }
   }
   else{
      sanitize_input_string_no_mysql_connect($str);
   }
   close_db($link);
}

function unescape_text(&$str)
{
   $ret_str = "";
   $ret_str = html_entity_decode($str);
   //asdasdasd $ret_str = stripslashes($ret_str);
   //$ret_str  = str_replace('\r\n', '<br>', $ret_str);
   //$ret_str  = str_replace('\n', '<br>', $ret_str);
   return $ret_str;
}

function print_as_rss(&$arr)
{
   global $prem_email;
   $loc_str1 = "";
   $loc_str1 .= '<?xml version="1.0" encoding="utf-8"?>';
   $loc_str1 .= '<rss version="2.0">';
   $loc_str1 .= '<channel>';
   $loc_str1 .= '<title>Premski - Puzzle Corner</title>';
   $loc_str1 .= '<link>http://www.premski.com/puzzles</link>';
   $loc_str1 .= '<description>Computer Science Interview Questions</description>';;
   $loc_str1 .= '<language>en-us</language>';
   $loc_str1 .= '<webMaster>'.$prem_email.'</webMaster>';
   //print '<pubDate>Tue, 10 Jun 2003 04:00:00 GMT</pubDate>';
   //print '<lastBuildDate>Tue, 10 Jun 2003 09:41:01 GMT</lastBuildDate>';
   
   $loc_str2 = "";
   foreach($arr as $array_element)
   {
      if($loc_str2 == ""){
         $loc_str1 .= '<pubDate>'.$array_element['create_time'].'</pubDate>';
         $loc_str1 .= '<lastBuildDate>'.$array_element['create_time'].'</lastBuildDate>';
      }
      $loc_str2 .= '<item>';
      $loc_str2 .= '<title>'.$array_element['board_title'].'</title>';
      $link_url = 'http://'.HOST_NAME.'/page_gen.php?id='.$array_element['board_id'];
      $answer_url = $link_url.'&mode=reply';
      $loc_str2 .= '<link>'.$link_url.'</link>';
      $board_description = str_replace('<br>', "\n", $array_element['board_description']);
      $board_description .= " Click <a href=".$answer_url.">HERE</a> to answer this question!";
      sanitize_input_string($board_description);
      $loc_str2 .= '<description>'.$board_description."</description>";
      $loc_str2 .= '<pubDate>'.$array_element['create_time'].'</pubDate>';
      $loc_str2 .= '</item>';
   }
   print $loc_str1;
   print $loc_str2;
   print '</channel>';
   print '</rss>';
}

function get_operator(&$operator_jpg_image_location)
{
	/*
		+ ->26b17225b626fb9238849fd60eabdf60
		- ->336d5ebc5436534e61d16e63ddfca327
		X ->02129bb861061d1a052c592e2dc6b383
	//*/
	if($operator_jpg_image_location=='images/26b17225b626fb9238849fd60eabdf60.jpg')
	{return '+';}
	if($operator_jpg_image_location=='images/336d5ebc5436534e61d16e63ddfca327.jpg')
	{return '-';}
	if($operator_jpg_image_location=='images/02129bb861061d1a052c592e2dc6b383.jpg')
	{return '*';}
	return '';
}

function get_number_from_img($img_location)
{
	/*
	1->c4ca4238a0b923820dcc509a6f75849b
	2->c81e728d9d4c2f636f067f89cc14862c
	3->eccbc87e4b5ce2fe28308fd9f2a7baf3
	4->a87ff679a2f3e71d9181a67b7542122c
	5->e4da3b7fbbce2345d7772b0674a318d5
	6->1679091c5a880faf6fb5e6087eb1b2dc
	7->8f14e45fceea167a5a36dedd4bea2543
	8->c9f0f895fb98ab9159f51fd0297e236d
	9->45c48cce2e2d7fbdea1afc51c7c6ad26
	//*/
	if($img_location=='images/c4ca4238a0b923820dcc509a6f75849b.jpg')
	{return 1;}
	if($img_location=='images/c81e728d9d4c2f636f067f89cc14862c.jpg')
	{return 2;}
	if($img_location=='images/eccbc87e4b5ce2fe28308fd9f2a7baf3.jpg')
	{return 3;}
	if($img_location=='images/a87ff679a2f3e71d9181a67b7542122c.jpg')
	{return 4;}
	if($img_location=='images/e4da3b7fbbce2345d7772b0674a318d5.jpg')
	{return 5;}
	if($img_location=='images/1679091c5a880faf6fb5e6087eb1b2dc.jpg')
	{return 6;}
	if($img_location=='images/8f14e45fceea167a5a36dedd4bea2543.jpg')
	{return 7;}
	if($img_location=='images/c9f0f895fb98ab9159f51fd0297e236d.jpg')
	{return 8;}
	if($img_location=='images/45c48cce2e2d7fbdea1afc51c7c6ad26.jpg')
	{return 9;}
}

function do_math_operation(&$a, &$b, &$op1)
{
	$res = ($op1=='+')? ($a+$b) : (($op1=='-')? ($a-$b):($a*$b));
	return $res;
}

function get_captcha_string_and_answer(&$out_captcha_string)
{
	global $global_math_operator_array, $global_numbers_array;
	$sz_global_math_operator_array = sizeof($global_math_operator_array);
	$sz_global_numbers_array  = sizeof($global_numbers_array);
	//SIGNATURE (A <OPERATOR> B) <OPERATOR> C
	$operator1 = rand(0,$sz_global_math_operator_array-1);
	$operator2 = rand(0,$sz_global_math_operator_array-1);
	$value_a = rand(1,5);
	$value_b = rand(1,5);
	$value_c = rand(1,5);
	$op1 = get_operator($global_math_operator_array[$operator1]);
	$op2 = get_operator($global_math_operator_array[$operator2]);
	
	//$captcha_answer = do_math_operation(do_math_operation($value_a, $value_b, $op1), $value_c, $op2);
	
	$captcha_raw_string = "";
	
	$out_captcha_string = "<img src=images/leftbr.jpg>";$captcha_raw_string = "images/leftbr.jpg".",";
	$out_captcha_string .= "<img src=".$global_numbers_array[$value_a].">";$captcha_raw_string .= $global_numbers_array[$value_a].",";
	$out_captcha_string .= "<img src=".$global_math_operator_array[$operator1].">";$captcha_raw_string .= $global_math_operator_array[$operator1].",";
	$out_captcha_string .= "<img src=".$global_numbers_array[$value_b].">";$captcha_raw_string .= $global_numbers_array[$value_b].",";
	$out_captcha_string .= "<img src=images/rightbr.jpg>";$captcha_raw_string .= "images/rightbr.jpg".",";
	$out_captcha_string .= "<img src=".$global_math_operator_array[$operator2].">";$captcha_raw_string .= $global_math_operator_array[$operator2].",";
	$out_captcha_string .= "<img src=".$global_numbers_array[$value_c].">";$captcha_raw_string .= $global_numbers_array[$value_c].",";
	$out_captcha_string .= "<img src=images/equal.jpg>";$captcha_raw_string .= "images/equal.jpg";
	
	return $captcha_raw_string;
}

function verify_captcha($captcha_question_string, $captcha_answer)
{
	list($leftbr, $a_img, $op1_img, $b_img, $rightbr, $op2_img, $c_img) = split("\,", $captcha_question_string, 8);
	$op1 = get_operator($op1_img);	
	$op2 = get_operator($op2_img);
	$a = get_number_from_img($a_img);
	$b = get_number_from_img($b_img);
	$c = get_number_from_img($c_img);
	//print "$a, $op1, $b, $op2, $c ==> $captcha_answer";
	$correct_captcha_answer = do_math_operation(do_math_operation($a, $b, $op1), $c, $op2);
	return ($correct_captcha_answer==$captcha_answer);
}

?>
