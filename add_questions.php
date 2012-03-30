<?php

include "common.php";
include "setup_application.php";

//include "/home/y/share/htdocs/common.php";
//include "/home/y/share/htdocs/setup_application.php";

global $prem_email, $left_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

$ip = get_client_ip_address();
$title="";
$description = "";
$lno=0;
$add_timestamp_to_title = true;
//$creator = PREMSKI_ANONYMOUS_USER;
$tags = "";
$creator = 'prem';

$puzzles_application = get_application(PUZZLES_APPLICATION_NAME);

$stdin = fopen('php://stdin', 'r');

while (! feof($stdin)){
   $buffer = fgets($stdin);
   $buffer = trim($buffer, "\r\n");
   if($buffer == "==="){
      if($title!=""){
         //$title = htmlentities($title);
         //$description = htmlentities($description);
         //$tags = htmlentities($tags);
         //$creator = htmlentities($creator);
      //function create_update_board($application_id, $board_name, $board_title, $board_description, $create_ip, $tags="", $add_timestamp_to_title=false, $creator = PREMSKI_ANONYMOUS_USER)
      
      
      //print "XXX: create_update_board(\"".$puzzles_application['application_id']."\",\"$title\", \"$title\", \"$description\", $ip, \"$tags\", \"$add_timestamp_to_title\", \"$creator\")\n";
         create_update_board($puzzles_application['application_id'], $title, $title, $description, $ip, $tags, $add_timestamp_to_title, $creator);
         //print "tags=\"$tags\"\n";
         //return;
      }
      $tags = "";
      $title="";
      $description = "";
      $lno=0;
   }
   else{
      ++$lno;
      if($lno==1){
         $title = $buffer;
      }
      else if($lno==2){
         $tags = $buffer;
      }
      else{
         $description .= ($description=="")? $buffer:"<br>".$buffer;
      }
   }
}
fclose($stdin);
?>
