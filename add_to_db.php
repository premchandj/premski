<?php

include "common.php";
include "setup_application.php";
global $prem_email, $left_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

$redirect = 1;
//print "<html><br><head><br><pre><br>".$_POST['question']."<br></pre><br></head><br></html><br>";
//exit(0);
//$debug = 1;
if($debug){
   $redirect = 0;
   print "HTTP_POST_VARS<br>";
   print_r($_POST);
   print "<br><br>";
   print "HTTP_GET_VARS<br>";
   print_r($_GET);
   print "<br><br>";
   print "HTTP_COOKIE_VARS<br>";
   print_r($_COOKIE);
   print "<br><br>";
}

$create_ip = get_client_ip_address();
$user_name = PREMSKI_ANONYMOUS_USER;
$redirect_url = "http://premski.com";
$ppp = is_ip_blacklisted($create_ip);

if((!is_ip_blacklisted($create_ip)) && (!is_user_blacklisted($user_name)) ){
   $use_cookie_credentials = true;
   $do_action_if_authenticated = false;
   if(array_key_exists('logingroup', $_POST)){
      if($_POST['logingroup']==PREMSKI_RESIGTERED_USER){
         //MEANS USER WANTS CREDENTIALS VALIDATED
         $user_name = $_POST['user_name'];sanitize_input_string($user_name);
         $user_password = $_POST['user_password'];sanitize_input_string($user_password);
         if(($user_name!="") && ($user_password!=""))
         {
            $stat = IsValidUserCredentials($user_name, $user_password);
            if($stat==true){
               $use_cookie_credentials = false;
               $user_name = "$user_name";
               $do_action_if_authenticated = true;
               if(array_key_exists('login_check_box', $_POST)){
                  //MEANS USER WANTS TO LOGIN TOO
                  set_premski_cookies($user_name, $user_password);
               }
               //$redirect_url = $_POST[NEXT_URL_VAR_NAME1];
            }
            else{
               //INVALID LOGIN
               $redirect_url = "./page_gen.php?invalid_login";
            }
         }
      }
      else{
         $do_action_if_authenticated = true;
      }
   }
   else{
      $do_action_if_authenticated = true;
   }
   if(array_key_exists(FORM_VAR_NAME1, $_POST)){
   if(($_POST[FORM_VAR_NAME1]==PUZZLE_QUESTION_POST_FORM_NAME) ||
   ($_POST[FORM_VAR_NAME1]==PUZZLE_REPLY_FORM_NAME)
   ){
      $captcha_correct = true;
      if(($do_action_if_authenticated==1)&&($user_name == PREMSKI_ANONYMOUS_USER)){
        $captcha_question_string = $_POST['captcha_question_string'];
        $captcha_answer = $_POST['captcha_answer'];
        $captcha_correct = verify_captcha($captcha_question_string, $captcha_answer);
      }
      
      $final_tag_string = "";
      $question_tags = "";
      $out_tags_array = array();
      get_all_tags($out_tags_array);
      foreach($out_tags_array as $local_tag=>$local_count){
         $local_tag1 = urlencode($local_tag);
         if(array_key_exists($local_tag1, $_POST)){
            $question_tags = ($question_tags=="")? $local_tag:$question_tags.",".$local_tag;
         }
      }
      sanitize_input_string($question_tags);
      
      $question_title = $_POST['question_title'];sanitize_input_string($question_title);
      $question = $_POST['question'];sanitize_input_string($question);
      if(($question_title=="") && ($question=="")){$captcha_correct=false;}
   
      //connect_db($link);
      //$question_title = htmlentities($question_title);
      //$question_title = mysql_real_escape_string($question_title);
   
      //$question = htmlentities($question);
      //$question = mysql_real_escape_string($question);
   
      //$question_tags = htmlentities($question_tags);
      //$question_tags = mysql_real_escape_string($question_tags);
      //close_db($link);
      
      if($_POST[FORM_VAR_NAME1]==PUZZLE_QUESTION_POST_FORM_NAME){
         if($do_action_if_authenticated){
            $application_id = get_application_id(PUZZLES_APPLICATION_NAME);
            $board_name = $question_title.time();
            $board_title = $question_title;
            $board_description = $question;
            if($use_cookie_credentials){
               $user_name = get_user_name($_COOKIE);
            }
            if($captcha_correct){
              $ret_val = create_update_board($application_id, $board_name, $board_title, $board_description, $create_ip, $question_tags, true, $user_name);
            }
            $redirect_url = "./page_gen.php?puzzles";
         }
      }
   
      if($_POST[FORM_VAR_NAME1]==PUZZLE_REPLY_FORM_NAME){
         //print "<html><br><head><br><pre><br>".$question."<br></pre><br></head><br></html><br>";exit(0);
         if($do_action_if_authenticated){
            $application_id = get_application_id(PUZZLES_APPLICATION_NAME);
            $board_name = $_POST['_bn'];sanitize_input_string($board_name);
            if($use_cookie_credentials){
               $user_name = get_user_name($_COOKIE);
            }
            if($captcha_correct){
            //print "<html><br><head><br><pre><br>".$question."<br></pre><br></head><br></html><br>";exit(0);
              create_message($application_id, $board_name,$question_title,'dummy link', $question, $create_ip, $user_name);
              //$redirect_url = "page_gen.php?id=".$_POST['_bn'];
            }
            $redirect_url = "page_gen.php?id=".$board_name;
         }
      }
   
      if($_POST[FORM_VAR_NAME1]==TESTIMONIAL_FORM_NAME){
         if($do_action_if_authenticated){
            $application_id = get_application_id(FEEDBACK_APPLICATION_NAME);
            $board_name = $question_title.time();
            $board_title = $question_title;
            $board_description = $question;
            if($captcha_correct){
              $ret_val = create_update_board($application_id, $board_name, $board_title, $board_description, $create_ip);
            }
            $redirect_url = "./page_gen.php?feedback";
         }
      }
      if($_POST[FORM_VAR_NAME1]==PUZZLES_TESTIMONIAL_FORM_NAME){
         if($do_action_if_authenticated){
            $application_id = get_application_id(FEEDBACK_APPLICATION_NAME);
            $board_name = $question_title.time();
            $board_title = $question_title;
            $board_description = $question;
            if($captcha_correct){
              $ret_val = create_update_board($application_id, $board_name, $board_title, $board_description, $create_ip);
            }
            $redirect_url = "./page_gen.php?puzzles_feedback";
         }
      }
      //mail("prem@yahoo-inc.com", "test mail from Premski.com", "test mail from Premski.com text", "From: pc@premski.com");
      //if($redirect){echo "<META http-equiv='refresh' content='0;URL=".$redirect_url."'>";}
   }
   if(($_POST[FORM_VAR_NAME1]==NEW_USER_FORM_NAME)){
      $user_name = $_POST['user_name'];sanitize_input_string($user_name);
      $user_email = $_POST['user_email'];sanitize_input_string($user_email);
      $user_password = $_POST['user_password'];sanitize_input_string($user_password);
      if(($user_name!="") && ($user_email!="") && ($user_password!=""))
      {//PREM
         AddUser($user_name, $user_email, $user_password);
      }
      $redirect_url = "./page_gen.php?invalid_login";
      //echo "<META http-equiv='refresh' content='0;URL=".$redirect_url."'>";
   }
   if(($_POST[FORM_VAR_NAME1]==USER_LOGIN_FORM_NAME)){
      $user_name = $_POST['user_name'];sanitize_input_string($user_name);
      $user_password = $_POST['user_password'];sanitize_input_string($user_password);
      if(($user_name!="") && ($user_password!=""))
      {
         $stat = IsValidUserCredentials($user_name, $user_password);
         if($stat==true){
            $expiry_time = time()+60*60*24*COOKIE_EXPIRY_DAYS;
            //PREM
            //Write cookie
            $stat1 = setcookie('user', "", time()-3600);
            $stat2 = setcookie('key', "", time()-3600);
   
            //$stat3 = setcookie('user', $user_name, $expiry_time,'/', 'premski.com');
            //$stat4 = setcookie('key', md5($user_password), $expiry_time,'/', 'premski.com');
            $stat3 = setcookie('user', $user_name, $expiry_time);
            $stat4 = setcookie('key', md5($user_password), $expiry_time);
   
            //$redirect_url = $_POST[NEXT_URL_VAR_NAME1];
            $redirect_url = "./page_gen.php?puzzles";
         }
         else{
            //INVALID LOGIN
            $redirect_url = "./page_gen.php?invalid_login";
         }
      }
      //if($redirect){echo "<META http-equiv='refresh' content='0;URL=".$redirect_url."'>";}
   }
   }
   else{
      $redirect_url = "./page_gen.php?puzzles";
      //if($redirect){echo "<META http-equiv='refresh' content='0;URL=".$redirect_url."'>";}
   }
   if($redirect){echo "<META http-equiv='refresh' content='0;URL=".$redirect_url."'>";}
}
else{
   echo "<META http-equiv='refresh' content='0;URL=".$redirect_url."'>";
}

?>
