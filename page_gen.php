<?php
////////////////////////////////////////PROGRAM START///////////////////////////////
require 'include1.php';
require 'include2.php';
include "common.php";
include "setup_application.php";

$user = PREMSKI_ANONYMOUS_USER;
if(array_key_exists('user', $_COOKIE) && array_key_exists('key', $_COOKIE)){
   $loc_user = $_COOKIE['user'];sanitize_input_string($loc_user);
   $loc_key = $_COOKIE['key'];sanitize_input_string($loc_key);
   $stat = IsValidUserCredentials($loc_user, $loc_key, false);
   if($stat){
      $user = $loc_user;
   }
}

global $prem_email, $top_banner_content, $development, $debug, $NO_OF_RANDOM_PUZZLES;
$left_content = "";
$right_content = "";
$middle_content= "";
$puzzle_site = 0;
$title = "";

//JSON API's
if(array_key_exists('toggle_user_subscription_to_puzzle', $_GET) && array_key_exists('id', $_GET)){
   if($user != PREMSKI_ANONYMOUS_USER){
      $loc_user_id = GetUserID($user);
      $application = get_application(PUZZLES_APPLICATION_NAME);
      if(is_user_subscribed_to_board($application['application_id'], $loc_user_id, $_GET['id'])){
         $ret = unsubscribe_user_from_board($application['application_id'], $loc_user_id, $_GET['id']);
         if($ret != ""){print "unsubscribed_".$ret;}
      }
      else{
         $ret = subscribe_user_to_board($application['application_id'], $loc_user_id, $_GET['id']);
         if($ret != ""){print "subscribed_".$ret;}
      }
   }
   else{//ANONYMOUS USER - use cookies
      $expiry_time = time()+60*60*24*COOKIE_SUBSCRIPTION_EXPIRY_DAYS;
      if(array_key_exists('subscriptions', $_COOKIE)){
         $current_subscriptions = explode("," , $_COOKIE['subscriptions']);
         $board_existed_in_subscription = false;
         $final_cookie_string = "";
         foreach($current_subscriptions as $loc_board_id){
            if($loc_board_id==$_GET['id']){
               $board_existed_in_subscription = true;
            }
            else{
               $final_cookie_string .= ($final_cookie_string=="")? $loc_board_id:",".$loc_board_id;
            }
         }
         if(!$board_existed_in_subscription){$final_cookie_string .= ",".$_GET['id'];}
         $stat = setcookie('subscriptions', $final_cookie_string, $expiry_time);
         print (($board_existed_in_subscription)? "unsubscribed_":"subscribed_").$_GET['id'];
      }
      else{
         $stat = setcookie('subscriptions', $_GET['id'], $expiry_time);
         print "subscribed_".$_GET['id'];
      }
   }
   return;
}



if(count($_GET)){
   //GET REQUEST
   if($debug){print_r($_GET);}
   if(array_key_exists('id', $_GET)){
      $puzzle_site = 1;
      if(array_key_exists('mode', $_GET) && $_GET['mode']=="reply"){
         //REPLY TO SINGLE PUZZLE LINK
         print_puzzles_left_right_content($left_content, $right_content);

         $application = get_application(PUZZLES_APPLICATION_NAME);
         $loc_id = $_GET['id'];sanitize_input_string($loc_id);
         $puzzle = get_board($application['application_id'], $loc_id);

         $out_string = "";
         $temp = "";
         print_puzzle_items_questions_only($application['application_id'], false, $_GET, $user, $puzzle, $out_string, false, true, false, true, true, REPLY_TYPE_BUTTON);
         $middle_content .= $out_string;
      }
      else{
         //DISPLAY SINGLE PUZZLE PAGE LINK
         $start = 0;
         $count = NO_OF_MESSAGES_PER_PAGE;
         if(array_key_exists('start', $_GET)){$start = $_GET['start'];sanitize_input_string($start);}
         if(array_key_exists('count', $_GET)){$count = $_GET['count'];sanitize_input_string($count);}
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $loc_id = $_GET['id'];sanitize_input_string($loc_id);
         $puzzle = get_board($application['application_id'], $loc_id);
         $out_string = "";
         $temp = "";
         $reply_text = "Answer";
         $display_feedback_and_blog_items = false;
         $show_answer_button=true;
         if(($_GET['id']==BLOG_BOARD_ID) || ($_GET['id']==FEEDBACK_BOARD_ID) || ($_GET['id']==RESOURCE_BOARD_ID)){
            $display_feedback_and_blog_items = true;
            $reply_text="Add Comment";
            if(($_GET['id']==BLOG_BOARD_ID) && ($user!="prem")){$show_answer_button=false;} else{$show_answer_button=true;}
         }
         print_puzzle_items_questions_only($application['application_id'], false, $_GET, $user, $puzzle, $out_string, false, true, $display_feedback_and_blog_items, $show_answer_button, false, REPLY_TYPE_BUTTON, $reply_text);
         $middle_content .= $out_string;

         $out_string = "";
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $loc_board_message_count = get_board_message_count($application['application_id'], $loc_id);
         $replies = get_board_messages($application['application_id'], $loc_id, $start, $count);
         $x = count($replies);
         if(count($replies)){
            $middle_content .= "<h3>Answers:</h3>";
            $middle_content .= "<hr>";
            print_puzzle_items_answer($application['application_id'], false, $loc_board_message_count, $_GET, $user, $temp, $replies, $out_string, $loc_id, $start, $count);
            $middle_content .= $out_string;
         }

         //$top_banner_content = "Puzzle Corner";
         $top_banner_content = "Puzzle Corner";

         $tags_title_str = "";
         if(array_key_exists('tags', $puzzle)){
            foreach ($puzzle['tags'] as $i){
               if($i != "All"){ $tags_title_str .= " ".$i; }
            }
         }
         $title = "Premski.com - ".$puzzle['board_title']." - $tags_title_str";
      }
   }
   else{
      if(array_key_exists('tag_questions', $_GET) && array_key_exists('tag', $_GET)){
         $loc_tag = $_GET['tag'];sanitize_input_string($loc_tag);
         $tag_count = get_tag_count($loc_tag);
         //print "XXX:$tag_count<br>";
         $puzzle_site = 1;
         //PUZZLES LINK
         $start = 0;
         $count = NO_OF_MESSAGES_PER_PAGE;
         if(array_key_exists('start', $_GET)){$start = $_GET['start'];sanitize_input_string($start);}
         if(array_key_exists('count', $_GET)){$count = $_GET['count'];sanitize_input_string($count);}
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         //$puzzles = get_application_boards($application['application_id'], $_GET['user'], $start, $count);
         $puzzles = array();
         
         GetBoardsWithTag($application['application_id'], $loc_tag, $puzzles, $start, $count);
         $top_banner_content= $application['application_title'];
         $out_string = "";
         $top_str = "";
         //print_r($puzzles);
         
         $random_puzzles = get_random_boards($application['application_id'], $puzzles, $NO_OF_RANDOM_PUZZLES);
         
         print_puzzle_items($application['application_id'], $random_puzzles, $tag_count, $_GET, $user, $top_str, $puzzles, $out_string, $start, $count, true, "tag_questions&tag=".$loc_tag);
         $middle_content .= $out_string;
         $title = "Premski.com - Questions tagged \"$loc_tag\"";
      }
      if(array_key_exists('author_questions', $_GET) && array_key_exists('user', $_GET)){
         $puzzle_site = 1;
         $loc_user = $_GET['user'];sanitize_input_string($loc_user);
         $user_board_count = get_user_board_count($loc_user);
         
         //PUZZLES LINK
         $start = 0;
         $count = NO_OF_MESSAGES_PER_PAGE;
         if(array_key_exists('start', $_GET)){$start = $_GET['start'];sanitize_input_string($start);}
         if(array_key_exists('count', $_GET)){$count = $_GET['count'];sanitize_input_string($count);}
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         
         $puzzles = get_application_boards($application['application_id'], $loc_user, $start, $count);
         $top_banner_content= $application['application_title'];
         $out_string = "";
         $top_str = "";
         
         $random_puzzles = get_random_boards($application['application_id'], $puzzles, $NO_OF_RANDOM_PUZZLES);
         
         print_puzzle_items($application['application_id'], $random_puzzles, $user_board_count, $_GET, $user, $top_str, $puzzles, $out_string, $start, $count, true, "author_questions&user=".$loc_user);
         $middle_content .= $out_string;
         $title = "Premski.com - Questions posted by user:$loc_user";
      }
      if(array_key_exists('invalid_login', $_GET)){
         $puzzle_site = 1;
         $top_banner_content = "Puzzle Corner";
         print_puzzles_left_right_content($left_content, $right_content);
         $middle_content .= "INVALID Login. Click <a href=page_gen.php?user_login>here</a> to try again";
      }
      if(array_key_exists('new_user_sign_up', $_GET)){
         $puzzle_site = 1;
         $top_banner_content = "Puzzle Corner";
         print_puzzles_left_right_content($left_content, $right_content);
         user_signup_form_helper_function($middle_content, $_GET, $middle_content);
         $title = "Premski.com - Signup";
      }
      if(array_key_exists('user_login', $_GET)){
         $puzzle_site = 1;
         //print_r($HTTP_POST_VARS);
         $prev_url = "";
         $next_url = "";
         $top_banner_content = "Puzzle Corner";
         print_puzzles_left_right_content($left_content, $right_content);
         user_login_form_helper_function($middle_content, $_GET, $middle_content, "", "www.yahoo.com");
         $title = "Premski.com - Login";
      }
      if(array_key_exists('signout', $_GET)){
         //clear cookies
         $stat1 = setcookie('user', "", time()-3600);
         $stat2 = setcookie('key', "", time()-3600);
      
         //load home page
         $puzzle_site = 1;
         //PUZZLES LINK
         $start = 0;
         $count = NO_OF_MESSAGES_PER_PAGE;
         if(array_key_exists('start', $_GET)){$start = $_GET['start'];sanitize_input_string($start);}
         if(array_key_exists('count', $_GET)){$count = $_GET['count'];sanitize_input_string($count);}
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $puzzles = get_application_boards($application['application_id'], "", $start, $count);
         $top_banner_content= $application['application_title'];
         $out_string = "";
         $top_str = "";
         $random_puzzles = get_random_boards($application['application_id'], $puzzles, $NO_OF_RANDOM_PUZZLES);
         print_puzzle_items($application['application_id'], $random_puzzles, $application['no_boards'], $_GET, $user, $top_str, $puzzles, $out_string, $start, $count);
         $middle_content .= $out_string;
         $title = "Premski.com - Signout";
      }
//xxxx
      if(array_key_exists('user', $_GET) && array_key_exists('code', $_GET)){
         $puzzle_site = 1;
         //USER EMAIL VERIFICATION - WHEN USER CLICKS ON EMAIL VERIFICATION LINK
         $top_banner_content = "Puzzle Corner";
         print_puzzles_left_right_content($left_content, $right_content);
         //user_signup_form_helper_function($middle_content, $_GET, $middle_content);
         $loc_user = $_GET['user'];sanitize_input_string($loc_user);
         $loc_code = $_GET['code'];sanitize_input_string($loc_code);
         $status = VerifyUser($loc_user, $loc_code);
         if($status==USER_VERIFY_SUCCESS){
            $middle_content .= "Your email has been SUCCESSFULLY verified. Please click <a href=page_gen.php?puzzles>here</a> to continue";
         }
         if($status==USER_DOES_NOT_EXISTS){
            $middle_content .= "Sorry! Email verification FAILURE.";
         }
         $title = "Premski.com - User verification";
      }
      if(array_key_exists('puzzles', $_GET)){
         $puzzle_site = 1;
         //PUZZLES LINK
         $start = 0;
         $count = NO_OF_MESSAGES_PER_PAGE;
         if(array_key_exists('start', $_GET)){$start = $_GET['start'];sanitize_input_string($start);}
         if(array_key_exists('count', $_GET)){$count = $_GET['count'];sanitize_input_string($count);}
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $puzzles = get_application_boards($application['application_id'], "", $start, $count);
         $top_banner_content= $application['application_title'];
         $out_string = "";
         $top_str = "";
         
         $random_puzzles = get_random_boards($application['application_id'], $puzzles, $NO_OF_RANDOM_PUZZLES);
         
         //print_random_puzzle_items($_GET, $user, 'random', $random_puzzles, $out_string);
         print_puzzle_items($application['application_id'], $random_puzzles, $application['no_boards'], $_GET, $user, $top_str, $puzzles, $out_string, $start, $count);
         //print_puzzle_items($application['application_id'], $application['no_boards'], $_GET, $user, 'puzzles', $puzzles, $out_string, $start, $count);
         $middle_content .= $out_string;
      }
      if(array_key_exists('starred_questions', $_GET)){
         $puzzle_site = 1;
         //PUZZLES LINK
         $start = 0;
         $count = NO_OF_MESSAGES_PER_PAGE;
         if(array_key_exists('start', $_GET)){$start = $_GET['start'];sanitize_input_string($start);}
         if(array_key_exists('count', $_GET)){$count = $_GET['count'];sanitize_input_string($count);}
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $loc_user_id = GetUserID($user);
         $puzzles = get_user_subscribed_boards($application['application_id'], $loc_user_id, $start, $count);
         $top_banner_content= $application['application_title'];
         $out_string = "";
         $top_str = "";
         if(count($puzzles)){
            print_puzzle_items($application['application_id'], $puzzles1, $application['no_boards'], $_GET, $user, $top_str, $puzzles, $out_string, $start, $count, true, "starred_questions");
         }
         //print_puzzle_items($application['application_id'], $application['no_boards'], $_GET, $user, 'puzzles', $puzzles, $out_string, $start, $count);
         $middle_content .= $out_string;
         $title = "Premski.com - Your starred questions";
      }
      if(array_key_exists('about_puzzles', $_GET)){
         $puzzle_site = 1;
         //ABOUT PUZZLES LINK
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $top_banner_content= $application['application_title'];
         $middle_content .= "<h4>".$application['application_description']."</h4>";
         $title = "Premski.com - About";
      }
      if(array_key_exists('add_puzzle_question', $_GET)){
         $puzzle_site = 1;
         //ADD PUZZLES LINK
         print_puzzles_left_right_content($left_content, $right_content);
         $name = PUZZLE_QUESTION_POST_FORM_NAME;
         form_helper_function($user, $name, $middle_content, $_GET, true, true, true);
         $title = "Premski.com - Add a question to the site";
      }
      if(array_key_exists('rss', $_GET)){
         $puzzle_site = 1;
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $puzzles = get_application_boards($application['application_id'], "", 0, 20);
         print_as_rss($puzzles);
         return;
      }
      if(array_key_exists('commentsrss', $_GET)){
         $puzzle_site = 1;
         $application = get_application(PUZZLES_APPLICATION_NAME);
         $puzzles = get_latest_n_boards_of_latest_messages($application['application_id'], 0, 20);
         print_as_rss($puzzles);
         return;
      }
      if(array_key_exists('puzzles_abc', $_GET)){
         $puzzle_site = 1;
         //PUZZLES LINK
         $start = 0;
         $count = NO_OF_MESSAGES_PER_PAGE;
         if(array_key_exists('start', $_GET)){$start = $_GET['start'];sanitize_input_string($start);}
         if(array_key_exists('count', $_GET)){$count = $_GET['count'];sanitize_input_string($count);}
         print_puzzles_left_right_content($left_content, $right_content);
         $application = get_application(PUZZLES_APPLICATION_NAME);
         //$puzzles = get_application_boards($application['application_id'], "", $start, $count);
         $puzzles = get_latest_n_boards_of_latest_messages($application['application_id'], $start, $count);
         $top_banner_content= $application['application_title'];
         $out_string = "";
         $top_str = "";
                  
         //print_random_puzzle_items($_GET, $user, 'random', $random_puzzles, $out_string);
         print_puzzle_items($application['application_id'], $random_puzzles, $application['no_boards'], $_GET, $user, $top_str, $puzzles, $out_string, $start, $count, true, "puzzles_abc");
         //print_puzzle_items($application['application_id'], $application['no_boards'], $_GET, $user, 'puzzles', $puzzles, $out_string, $start, $count);
         $middle_content .= $out_string;
      }
      if(array_key_exists('delete_board', $_GET) && array_key_exists('board_id', $_GET)){
         $puzzle_site = 1;
         print_puzzles_left_right_content($left_content, $right_content);

         $application = get_application(PUZZLES_APPLICATION_NAME);
         delete_board($application['application_id'], $_GET['board_id'], false);
         $middle_content .= "QUESTION DELETED";
         $title = "Premski.com - Question deleted";
      }
      if(array_key_exists('delete_message', $_GET) && array_key_exists('board_id', $_GET) && array_key_exists('message_id', $_GET)){
         $puzzle_site = 1;
         print_puzzles_left_right_content($left_content, $right_content);

         $application = get_application(PUZZLES_APPLICATION_NAME);
         delete_message($_GET['message_id'], $application['application_id'], $_GET['board_id']);
         $middle_content .= "COMMENT DELETED";
      }
      if(array_key_exists('update_board', $_GET) && array_key_exists('board_id', $_GET)){
         //http://127.0.0.1/page_gen.php?update_board&board_id=f01fd00246e0c7baa6466a4c286014ef;
print "b";
      }
      if(array_key_exists('blacklist_user', $_GET) && array_key_exists('user_id', $_GET)){
         $puzzle_site = 1;
         print_puzzles_left_right_content($left_content, $right_content);
         BlacklistUser($_GET['user_id'], false);
         $middle_content .= "User BLACKLISTED SUCCESSFULLY";
      }
      if(array_key_exists('blacklist_ip', $_GET) && array_key_exists('ip', $_GET)){
         $puzzle_site = 1;
         print_puzzles_left_right_content($left_content, $right_content);

         $application = get_application(PUZZLES_APPLICATION_NAME);
         add_ip_to_blacklist_table($application['application_id'], $_GET['ip']);
         $middle_content .= "IP:".$_GET['ip']." BLACKLISTED SUCCESSFULLY";
      }
      $name = "";
      if($development==1){
         $name = (array_key_exists('index', $_GET))? 'index':$name;
         $name = (array_key_exists('home', $_GET))? 'home':$name;
         $name = (array_key_exists('prem', $_GET))? 'prem':$name;
         $name = (array_key_exists('preeti', $_GET))? 'preeti':$name;
         $name = (array_key_exists('alisha', $_GET))? 'alisha':$name;
         $name = (array_key_exists('ashish', $_GET))? 'ashish':$name;
         $name = (array_key_exists('other', $_GET))? 'other':$name;
      }
      $name = (array_key_exists('me', $_GET))? 'me':$name;
      $name = (array_key_exists('resume', $_GET))? 'resume':$name;
      $name = (array_key_exists('puzzles1', $_GET))? 'puzzles1':$name;
      $name = (array_key_exists('prem_generate_sql', $_GET))? 'prem_generate_sql':$name;
      create_page_by_name($name, $left_content, $right_content, $middle_content, $top_banner_content, $prem_email);
   }
}
else{
   //BATCH PROCESSING
   $name = $argv[1];
   create_page_by_name($name, $left_content, $right_content, $middle_content, $top_banner_content, $prem_email);
}
print_website($puzzle_site, $left_content, $middle_content, $right_content, $top_banner_content, $user, $title);

////////////////////////////////////////PROGRAM END///////////////////////////////



function create_page_by_name(&$name, &$left_content, &$right_content, &$middle_content, &$top_banner_content, &$prem_email)
{
   if($name==""){return;}
   print_standard_left_right_content($left_content, $right_content);
 /*
   POSSIBLE VALUES OF $name ARE
      prem
      preeti
      alisha
      ashish
      other
      me
      index OR home
      puzzles
      resume
      feedback - NOT IMPLEMENTED
      donotclickhere - NOT IMPLEMENTED
   */
if($name=='prem_generate_sql'){
   print_sql($middle_content);
   print $middle_content;
   exit(0);
}
if(($name=="index") || ($name=="home")){
         $feed = "http://premj.livejournal.com/data/rss";
         $parsed_feed =& new XML_RSS($feed);
         $parsed_feed -> parse();
         $channel_info = $parsed_feed->getChannelInfo();
         print_all_livejournal_items($channel_info['title'], $parsed_feed->getItems(), $middle_content);
      }
      else if($name=="me"){
         $middle_content .= '<span style="display: none;">Premchand Jayamohan puzzles microsoft interview questions software developer "http://premchandj.tripod.com"</span>';
         $middle_content .= '<a href="./index.html" target=_parent style="display: none;position: fixed"><button  style="background-color: light green;">Back</button></a>';
         $middle_content .= '<head>';
         $middle_content .= '<script language="JavaScript" src="./all.js"></script>';
         $middle_content .= '<script>';
         $middle_content .= '<script>set_bg_color("#c6c2f5");</script>';
         $middle_content .= '</script>';
         $middle_content .= '<body>';
         $middle_content .= '<p>';
         $middle_content .= '<img src="./images/prem.gif">';
         $middle_content .= '</p>';
         $middle_content .= '<p style="font-family:courier">';
         $middle_content .= '<HTML>My name is <b>Premchand Jayamohan</b> (call me <b>Prem</b>).I was born in ';

         $middle_content .= '<a href="http://www.chennaionline.com" TARGET=_blank><b>Chennai</b></a>(Madras),';

         $middle_content .= '<b>India</b>, spent most of my early years there at ';

         $middle_content .= '<a href="http://www.tambaram.net" TARGET=_blank><b>Tambaram</b></a>.';

         $middle_content .= 'I did my schooling at <b>Christ King Primary School</b> and ';

         $middle_content .= '<a href="http://www.infophil.com/India/Alumni/MCCHS/" TARGET=_blank><b>MCCHSS(Madras Christian College Higher Secondary School, Chetput)</b></a>.';

         $middle_content .= 'I did my bachelors from ';

         $middle_content .= '<a href="http://www.psgtech.edu" TARGET=_blank><b>PSG College of Technology</b></a>.';

         $middle_content .= ', Coimbatore, in Electrical Engineering, and finished my M.S in ';

         $middle_content .= 'Electrical & Computer Engineering at ';

         $middle_content .= '<a href="http://www.clarkson.edu" TARGET=_blank><b>Clarkson University</b></a>.';

         $middle_content .= ', Potsdam, NY. I got married to my beautiful and loving wife, ';

         $middle_content .= 'Preeti in the summer of 1999. ';

         $middle_content .= '<a href="http://photos.yahoo.com/pcj_1"><b>Here</b></a>.';

         $middle_content .= 'are our engagement and wedding pictures. Of all the people who have made a lasting ';

         $middle_content .= 'impact on my life, there is one special person to whom I owe it all. It is my Lord ';

         $middle_content .= 'and Savior Jesus Christ, Who saved me from a life of sin, and showed me the real ';

         $middle_content .= 'purpose in life. Click ';

         $middle_content .= '<a href="http://billygraham.org/SH_StepsToPeace.asp" TARGET="c22"><b>here</b></a>.';

         $middle_content .= 'if you would like to know more on what it means to be saved.';

         $middle_content .= 'My hobbies include playing around with computers, music (Call me whatever you want,';

         $middle_content .= 'but my favorite is Classical music), playing the piano, reading and working outÂ
..';
         $middle_content .= '</p>';
         //$middle_content .= '<script>increment_counter ("me.html")</script>';
      }

      else if(
               ($name=="prem")
            || ($name=="preeti")
            || ($name=="alisha")
            || ($name=="ashish")
            || ($name=="other")
            )
      {
         # create a new api object
         $API_KEY = '360a2a5fb97cad954d1af8b915d91be1';
         $API_SECRET = '21de2db47357738b';

         $frob = '4452753-dfa263b362f1dcd4';
         $token = '1312226-a05eab73003d10a6';
         $FLICKR_PREM_ID = '74746291@N00';

         $endpoint = 'http://www.flickr.com/services/rest/';
         $upload_endpoint = 'http://api.flickr.com/services/upload/';
         $auth_endpoint = 'http://www.flickr.com/services/auth/?';
         $conn_timeout = 5;
         $io_timeout = 5;


         $api =& new Flickr_API(array(
               'api_key'  => $API_KEY,
               'api_secret'  => $API_SECRET,
            ));

         if(0){
            $response = $api->callMethod('flickr.auth.getFrob');
            //print_r($response)."\n";
            $frob = '';
            if ($response){
               $frob = $response->children[0]->content;
               $arr1 = array(
                        //'method' => 'flickr.auth.get'
                        'api_key'	=> $API_KEY,
                        'perms'	=> 'write',
                        'frob'	=> $frob
                     );
               $api_sig = signArgs1($arr1);
               $redirect_url = "http://flickr.com/services/auth/?api_key=360a2a5fb97cad954d1af8b915d91be1&perms=write&frob=$frob&api_sig=$api_sig";
                  print "go to this url:$redirect_url\n";
               sleep(60);
               # response is an XML_Tree root object
               //print $response."\n====\n";
            }else{
               # fetch the error
               $code = $api->getErrorCode();
               $message = $api->getErrorMessage();
            }
            $response1 = $api->callMethod('flickr.auth.getToken', array('frob' => $frob));
         }


         $alisha_pics = array();
         $ashish_pics = array();
         $preeti_pics = array();
         $prem_pics = array();
         $other_pics = array();

         $current_page = 1;
         $no_of_pages = 2;
         while($current_page <= $no_of_pages){
            $response = $api->callMethod('flickr.people.getPublicPhotos', array('user_id' => $FLICKR_PREM_ID,'extras' => 'tags', 'page' => $current_page));//
            if ($response){
               ++$current_page;
               $no_of_pages = $response->children[0]->attributes['pages'];
               if(1){
               foreach (($response->children[0]->children) as $xml_photo_object){
                  if($xml_photo_object->attributes['tags'] != ""){
                     $printed = 0;
                     if(strpos($xml_photo_object->attributes['tags'],'alisha') !== false){
                        array_push($alisha_pics, $xml_photo_object);$printed = 1;
                     }
                     if(strpos($xml_photo_object->attributes['tags'],'ashish') !== false){
                        array_push($ashish_pics, $xml_photo_object);$printed = 1;
                     }
                     if(strpos($xml_photo_object->attributes['tags'],'preeti') !== false){
                        array_push($preeti_pics, $xml_photo_object);$printed = 1;
                     }
                     if(strpos($xml_photo_object->attributes['tags'],'prem') !== false){
                        array_push($prem_pics, $xml_photo_object);$printed = 1;
                     }
                        if($printed == 0){
                           array_push($other_pics, $xml_photo_object);
                        }
                  }
               }
            }
            }//endif of if(0)
         }

         $img_url = "";
         $display_name = "";
         if($name == 'alisha'){
            print_flickr_array_as_html($alisha_pics, $name, $middle_content);
            $img_url = "http://static.flickr.com/112/261234656_65543d1534_t.jpg";
            $display_name = "Alisha";
         }
         if($name == 'ashish'){
            print_flickr_array_as_html($ashish_pics, $name, $middle_content);
            $img_url = "http://static.flickr.com/85/261231610_24ebec7b47_t.jpg";
            $display_name = "Ashish";
         }
         if($name == 'preeti'){
            print_flickr_array_as_html($preeti_pics, $name, $middle_content);
            $img_url = "http://static.flickr.com/47/131605343_0d2da09d9c_t.jpg";
            $display_name = "Preeti";
         }
         if($name == 'prem'){
            print_flickr_array_as_html($prem_pics, $name, $middle_content);
            $img_url = "http://static.flickr.com/104/283153742_087557df90_t.jpg";
            $display_name = "Prem";
         }
         if($name == 'other'){print_flickr_array_as_html($other_pics, $name, $middle_content);}

         format_top_banner_content($top_banner_content, $display_name, $img_url);
      }
      else if($name=="resume")
      {
         print_resume($middle_content);
         $right_content = "";
      }
}
?>
