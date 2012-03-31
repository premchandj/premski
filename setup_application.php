<?php

//Addapplication
//DeleteApplication
//GetApplication
//AddBoard
//deleteBoard
//GetBoard
//AddMessage
//DeleteMessage
//GetMessage

//$new_app_name = $argv[1];
//$new_app_title = $argv[2];
//$new_app_description = $argv[3];


//create_update_application($new_app_name, $new_app_title, $new_app_description);
//delete_application("feedback");
//delete_application("cooking");
//$a = get_application($new_app_name);
//print_r($a);

//create_update_board(1, "sample question 1" , "sample question 1 title", "my board description");
//$b = get_board(1, "sample question 1");
//print_r($b);
//create_update_board(1, "sample question 2" , "sample question 1 title ", "my board description UPDATED");
//delete_board(1, "sample question 1");

//create_message(1, '5920ec862235f127a5b0d58640c3bd2a', 'message_title', 'message_link', 'message_description');
//update_message(1, 1, '5920ec862235f127a5b0d58640c3bd2a','new message_title', 'new message_link', 'new111 message_description');
//delete_message(3,1, '5920ec862235f127a5b0d58640c3bd2a');

//$a1 = get_board_messages(1, '5920ec862235f127a5b0d58640c3bd2a');
//$a1 = get_application_boards(1);
//$a1 = get_applications();
//print_r($a1);

//include "/home/y/share/htdocs/common.php";
//AddTagToBoard(1, '00b08be34c1da4976e0f9a079a161e87', 'prem');

function get_tagid_from_tagname($application_id, $tag_name)
{
   connect_db($link);

  $out_array = array();
   // Performing SQL query
   $query = "select tag_id from Tag where application_id='$application_id' and tag_name='$tag_name';";
   execute_query($query, $result);
   $went_inside = false;
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $went_inside = true;
      mysql_free_result($result);
      close_db($link);
      return $line['tag_id'];
   }
   if($went_inside){
      mysql_free_result($result);
   }
   close_db($link);
}

function GetTagsOfBoard($application_id, $board_id, &$out_array)
{
   connect_db($link);

   // Performing SQL query
   $query = "select B.tag_name from TagBoardMap as A, Tag as B where A.application_id=$application_id and  A.board_id='$board_id' and A.tag_id=B.tag_id;";
   execute_query($query, $result);

   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
   //print "YYY:".$line['tag_name'];
      array_push($out_array, $line['tag_name']);
   }
   if(count($out_array)!=0){
      mysql_free_result($result);
   }
   //close_db($link);
}

function GetBoardsWithTag($application_id, $tag, &$out_array, $start, $count)
{
   connect_db($link);

   // Performing SQL query
   $query = "select C.* from Tag as A, TagBoardMap as B, Board as C where A.tag_name='$tag' AND A.tag_id=B.tag_id AND B.board_id=C.board_id AND A.application_id=B.application_id AND A.application_id=C.application_id limit $start, $count";
   execute_query($query, $result);

   $count = 0;
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      ++$count;
      $line['tags'] = array();
      GetTagsOfBoard($application_id, $line['board_id'], $line['tags']);
      $out_array[$count] = $line;
   }
   if(count($out_array)!=0){
      mysql_free_result($result);
   }
   close_db($link);
}

function AddTagToBoard($application_id, $board_id, $tag_name)
{
   connect_db($link);

  $out_array = array();
   // Performing SQL query

   //Make sure the tag is present in the Tag table
   $final_tag_id = 0;
   $tag_exists = false;
   $query = "select * from Tag where application_id='$application_id' and tag_name='$tag_name';";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($line['tag_name']==$tag_name){
         $final_tag_id = $line['tag_id'];
         //tag already exists
         $tag_exists = true;
      }
   }

   if($tag_exists==false){
      $query = "select tag_id from Tag where application_id='$application_id';";
      execute_query($query, $result);
      $tag_id_hash = array();
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
         $tag_id_hash[$line['tag_id']] = $line['tag_id'];
      }

      for($i=1;$i<100000;++$i){
         if(!(array_key_exists($i, $tag_id_hash)==TRUE)){
            $final_tag_id = $i;
            break;
         }
      }
      if($final_tag_id!=0){
         $query = "insert into Tag(application_id, tag_id, tag_name) values($application_id, $final_tag_id, '$tag_name');";
         execute_query($query, $result);
      }
   }


   $query = "update Tag set tag_count=tag_count+1 where application_id='$application_id' and tag_id=$final_tag_id;";
   execute_query($query, $result);

   if($tag_exists){
      $tag_exists1 = false;
      $query = "select * from TagBoardMap where application_id='$application_id' and board_id='$board_id' and tag_id=$final_tag_id;";
      execute_query($query, $result);
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
         if($line['tag_id']==$final_tag_id){
            $final_tag_id = $line['tag_id'];
            //tag already exists
            $tag_exists1 = true;
         }
      }
      if($tag_exists1){
         //increment count
         $query = "update TagBoardMap set tag_count=tag_count+1 where application_id='$application_id' and board_id='$board_id' and tag_id=$final_tag_id;";
         execute_query($query, $result);
      }
      else{
         $query = "insert into TagBoardMap(application_id, board_id, tag_id) values($application_id, '$board_id', $final_tag_id);";
         execute_query($query, $result);
      }
   }
   else{
      $query = "insert into TagBoardMap(application_id, board_id, tag_id) values($application_id, '$board_id', $final_tag_id);";
      execute_query($query, $result);
   }


   close_db($link);
   return $out_array;
}

function DeleteTag($application_id, $tag_id)
{
   connect_db($link);

   //$out_array = array();
   // Performing SQL query
   //$query = "delete from TagBoardMap where application_id=$application_id and tag_id=$tag_id;";
   //execute_query($query, $result);

   $query = "delete from Tag where application_id=$application_id and tag_id=$tag_id;";
   execute_query($query, $result);
   close_db($link);
}

function get_application_id($application_name)
{
   $application = get_application($application_name);
   return $application['application_id'];
}

function get_applications($start=0, $count=10)
{
   connect_db($link);

  $out_array = array();

  if($count>MAX_APPLICATIONS_TO_GET){$count=MAX_APPLICATIONS_TO_GET;}
   // Performing SQL query
   $query = "select * from Application limit $start, $count;";
   execute_query($query, $result);
   $count = 0;
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      ++$count;
      $out_array[$count] = $line;
   }
   close_db($link);
   return $out_array;
}

function get_random_boards(&$application_id, &$exempt_array, $count=1)
{
   $not_in_string = "";
   foreach($exempt_array as $k=>$v)
   {
      $not_in_string = ($not_in_string=="")? '\''.$v['board_id'].'\'' : $not_in_string.' , \''.$v['board_id'].'\'';
   }
   
   if($not_in_string!=""){
      $not_in_string = " where board_id not in (".$not_in_string.") ";
   }
   connect_db($link);

   $out_array = array();

   // Performing SQL query
   $query = "SELECT board_id FROM Board $not_in_string ORDER BY RAND() LIMIT $count";
   execute_query($query, $result);
   $board_names = array();
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      array_push($board_names, $line['board_id']);
   }
   close_db($link);
   
   $board_attrs_array = array();
   foreach($board_names as $k=>$board_id){
      $loc_board_attrs_array = get_board($application_id, $board_id);
      array_push($board_attrs_array, $loc_board_attrs_array);
   }
   
   return $board_attrs_array;
}


function get_application_boards($application_id, $limit_on_user="", $start=0, $count=NO_OF_MESSAGES_PER_PAGE)
{
   $user_filter_string = "";
   if($limit_on_user!=""){
      $user_id = GetUserID($limit_on_user);
      if($user_id!=USER_DOES_NOT_EXISTS){
         $user_filter_string = "AND creator_id=$user_id ";
      }
   }


   $out_array = array();

   if($count>MAX_BOARDS_TO_GET){$count=MAX_BOARDS_TO_GET;}
   connect_db($link);
   // Performing SQL query
   $query = "select * from Board where application_id=$application_id  $user_filter_string ORDER BY create_time DESC limit $start, $count;";
   execute_query($query, $result);
   $count = 0;
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      ++$count;
      $line['tags'] = array();
      GetTagsOfBoard($application_id, $line['board_id'], $line['tags']);
      $out_array[$count] = $line;
   }
   close_db($link);
   return $out_array;
}


function get_board_messages($application_id, $board_id, $start=0, $count=10)
{
   connect_db($link);
   $out_array = array();
   if($count>MAX_MESSAGES_TO_GET){$count=MAX_MESSAGES_TO_GET;}
   // Performing SQL query
   $query = "select * from Message where application_id=$application_id AND board_id='$board_id'  ORDER BY create_date ASC limit $start, $count;";
   execute_query($query, $result);
   $count = 0;
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      ++$count;
      $out_array[$count] = $line;
   }
   $x = $out_array[6]['description'];
   //$x = stripslashes($x);
   //print "<html>".$x."</html>";exit(0);
   close_db($link);
   return $out_array;
}

function get_message($message_id, $application_id, $board_id)
{
   connect_db($link);

   // Performing SQL query
   $query = "select * from Message where application_id=$application_id AND board_id='$board_id' AND message_id=$message_id;";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      return $line;
   }

   close_db($link);
}

function delete_message($message_id, $application_id, $board_id)
{
   connect_db($link);

   // Performing SQL query
   $query = "delete from Message where application_id=$application_id AND board_id='$board_id' AND message_id=$message_id;";
   execute_query($query, $result);

   close_db($link);
   incr_decr_application_variable($application_id, "no_messages", true);
   incr_decr_board_variable($application_id, $board_id, "no_messages", true);
}


function update_message($message_id, $application_id, $board_id, $message_title, $message_link, $message_description, $is_approved="APPROVED")
{
   connect_db($link);

   $m_title_length = strlen($message_title);
   $m_link_length = strlen($message_link);
   $m_description_length = strlen($message_description);
   if(($m_title_length>MAX_TITLE_LENGTH) || ($m_link_length>MAX_LINK_LENGTH) || ($m_description_length>MAX_DESCRIPTION_LENGTH)){return MESSAGE_EXCEEDS_INPUT_LIMITS;}

   // Performing SQL query
   $query = "Update Message set application_id='$application_id', board_id='$board_id', message_id=$message_id, update_date=NOW(), title='$message_title', link='$message_link', description='$message_description', is_approved='$is_approved'  where application_id=$application_id AND board_id='$board_id' AND message_id=$message_id;";
   execute_query($query, $result);

   close_db($link);
}

function create_message($application_id, $board_id, $message_title, $message_link, $message_description,  $create_ip=0, $message_creator=PREMSKI_ANONYMOUS_USER)
{
   $m_title_length = strlen($message_title);
   $m_link_length = strlen($message_link);
   $m_description_length = strlen($message_description);
   $m_creator_length = strlen($message_creator);
   if($message_creator!=PREM_REAL_USER_NAME){
      if(($m_title_length>MAX_TITLE_LENGTH) || ($m_link_length>MAX_LINK_LENGTH) || ($m_description_length>MAX_DESCRIPTION_LENGTH) || ($m_creator_length>CREATOR_NAME_LENGTH)){return MESSAGE_EXCEEDS_INPUT_LIMITS;}
   }

   $is_approved = "APPROVED";
   $creator_id = PREMSKI_ANONYMOUS_USER_ID;
   if($message_creator != PREMSKI_ANONYMOUS_USER){
      $creator_id = GetUserID($message_creator);
   }

   connect_db($link);
   // Get all messages under application, board id combination
   $query = 'SELECT message_id FROM Message where application_id='.$application_id." and board_id='".$board_id."'";
   execute_query($query, $result);
   $message_id_hash = array();
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $message_id_hash[$line['message_id']] = $line['message_id'];
   }
   if(count($message_id_hash)){
      // Free resultset
      mysql_free_result($result);
   }
   $final_message_id = 0;
   for($i=1;$i<1000;++$i){
      if(!(array_key_exists($i, $message_id_hash)==TRUE)){
         $final_message_id = $i;
         break;
      }
   }

   $message_description = mysql_real_escape_string($message_description);
   //print "PREM2:$message_description,";exit(0);
   // Performing SQL query
$query = "INSERT into Message(application_id, board_id, message_id, create_date, update_date, title, link, description,creator_id, is_approved, create_ip) values($application_id,'".$board_id."', ".$final_message_id.", NOW(), NOW(), '".$message_title."', '".$message_link."', '".$message_description."',".$creator_id.", '".$is_approved."',".$create_ip.") ";
//print "<html><head><pre><br>".$message_description."<br></pre><br></head><br></html><br>";
//print "$query\n";
//exit(0);

execute_query($query, $result);
   close_db($link);
   //incr_decr_application_variable($app_id, $table, $var, $is_decrement=false)
   incr_decr_application_variable($application_id, "no_messages");
   incr_decr_board_variable($application_id, $board_id, "no_messages");
}


function get_board($application_id, $board_name, $do_md5=false)
{
   connect_db($link);

   $board_name_md5 = $board_name;
   if($do_md5){
      $board_name_md5 = md5($board_name);
   }
   // Performing SQL query
   $query = 'SELECT * FROM Board where application_id='.$application_id." and board_id='".$board_name_md5."'";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
       if(($line['application_id'] == $application_id) && ($line['board_id'] == $board_name_md5)){
         $line['tags'] = array();
         GetTagsOfBoard($application_id, $line['board_id'], $line['tags']);
         mysql_free_result($result);
         return $line;
      }
   }
   close_db($link);
}

function delete_board($application_id, $board_name, $do_md5=true)
{
   $board = get_board($application_id, $board_name, $do_md5);
   $out_array = array();
   GetTagsOfBoard($application_id, $board['board_id'], $out_array);
   foreach($out_array as $tag_name){
      $tag_id = get_tagid_from_tagname($application_id, $tag_name);
      incr_decr_tagboardmap_variable($application_id, $board['board_id'], $tag_id, true);
      incr_decr_tag_variable($application_id, $tag_id, true);
   }
   connect_db($link);
   $board_name_md5 = $board_name;
   if($do_md5){
      $board_name_md5 = md5($board_name_md5);
   }
   // Performing SQL query
   $query = "delete from Board where $application_id=$application_id and board_id='".$board_name_md5."'";
   execute_query($query, $result);

   // Closing connection
   close_db($link);
   incr_decr_application_variable($application_id, "no_boards", true);
}

function create_update_board($application_id, $board_name, $board_title, $board_description, $create_ip=0, $tags="", $add_timestamp_to_title=false, $creator = PREMSKI_ANONYMOUS_USER)
{
   $b_name_length = strlen($board_name);
   $b_title_length = strlen($board_title);
   $b_description_length = strlen($board_description);
//print "YYY:$board_name=$b_name_length\n$board_title=$b_title_length\n$board_description=$b_description_length\n";
   if($message_creator!=PREM_REAL_USER_NAME){
      if(($b_name_length>MAX_BOARD_NAME_LENGTH) || ($b_title_length>MAX_TITLE_LENGTH) || ($b_description_length>MAX_DESCRIPTION_LENGTH)){return BOARD_EXCEEDS_INPUT_LIMITS;}
   }

   $creator_id = PREMSKI_ANONYMOUS_USER_ID;
   if($creator != PREMSKI_ANONYMOUS_USER){
      $creator_id = GetUserID($creator);
      //print "$creator => $creator_id";
   }

   $board_name_md5 = "";
   if($add_timestamp_to_title){
      $board_name_md5 = md5($board_name.time());
   }
   else{
      $board_name_md5 = md5($board_name);
   }

   connect_db($link);
   // Performing SQL query
   $query = 'SELECT application_id,board_id FROM Board where application_id='.$application_id." and board_id='".$board_name_md5."'";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
       if(($line['application_id'] == $application_id) && ($line['board_id'] == $board_name_md5)){
         //echo "<!-- BOARD already exists. Updating title and description ->";
         $query = "UPDATE Board set board_title='$board_title', board_description='$board_description', mod_time=NOW() where board_id='$board_name_md5' and application_id=$application_id;";
         //execute_query($query, $result); //UPDATES BOARD - intentionally commenting this
         return;//UPDATES BOARD - intentionally commenting this
      }
   }
   //echo "<!--Creating NEW BOARD -->\n";
   // Free resultset
   mysql_free_result($result);

   // Performing SQL query
   $query = "INSERT into Board(application_id, board_id, board_name, board_title, board_description, create_time, mod_time, create_ip, creator_id) values($application_id,'".$board_name_md5."', '".$board_name."', '".$board_title."', '".$board_description."', NOW(), NOW(), $create_ip, $creator_id) ";
   execute_query($query, $result);
   
   $query = "update UserTable set user_board_count=user_board_count+1 where user_id=$creator_id;";
   execute_query($query, $result);
   
   close_db($link);
   incr_decr_application_variable($application_id, "no_boards");
   //add tags
   ModerateAndAddTagsToBoard($application_id, $board_name_md5, $tags);
}

function ModerateAndAddTagsToBoard(&$application_id, &$board_name_md5, &$tags)
{
   global $tag_blacklist_array;
   $count = 0;
   $tag_array = explode(TAG_DELIMITER, $tags);
   //Add all questions to "All" tag
   AddTagToBoard($application_id, $board_name_md5, "All");
   foreach($tag_array as $tag){
      $len = strlen($tag);
      if(   ($len<TAG_MIN_LENGTH)
         || ($len>TAG_MAX_LENGTH)
         || (array_key_exists($tag, $tag_blacklist_array))
      ){continue;}
      AddTagToBoard($application_id, $board_name_md5, $tag);
      ++$count;
      if($count==MAX_TAGS_IN_ONE_SHOT){break;}
   }
}

function incr_decr_application_variable($app_id, $var, $is_decrement=false)
{
   connect_db($link);
   // Connecting, selecting database
   $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD)  or die('Could not connect: ' . mysql_error());
   mysql_select_db(MY_DATABASE) or die('Could not select database');

   $str = ($is_decrement==true)? "$var=$var-1":"$var=$var+1";
   // Performing SQL query
   $query = "update Application set $str where application_id='$app_id';";
   execute_query($query, $result);
   close_db($link);
}

function incr_decr_board_variable($app_id, $board_id, $var, $is_decrement=false)
{
   connect_db($link);
   // Connecting, selecting database
   $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD)  or die('Could not connect: ' . mysql_error());
   mysql_select_db(MY_DATABASE) or die('Could not select database');

   $str = ($is_decrement==true)? "$var=$var-1":"$var=$var+1";
   // Performing SQL query
   $query = "update Board set $str where application_id='$app_id' and board_id='$board_id';";
   execute_query($query, $result);
   close_db($link);
}

function incr_decr_tagboardmap_variable($app_id, $board_id, $tag_id, $is_decrement=false)
{
   connect_db($link);
   // Connecting, selecting database
   $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD)  or die('Could not connect: ' . mysql_error());
   mysql_select_db(MY_DATABASE) or die('Could not select database');
   $var = 'tag_count';
   $str = ($is_decrement==true)? "$var=$var-1":"$var=$var+1";
   // Performing SQL query
   $query = "update TagBoardMap set $str where application_id=$app_id AND board_id='$board_id' AND tag_id=$tag_id";
   execute_query($query, $result);
   close_db($link);
}

function incr_decr_tag_variable($app_id, $tag_id, $is_decrement=false)
{
   connect_db($link);
   // Connecting, selecting database
   $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD)  or die('Could not connect: ' . mysql_error());
   mysql_select_db(MY_DATABASE) or die('Could not select database');
   $var = 'tag_count';
   $str = ($is_decrement==true)? "$var=$var-1":"$var=$var+1";
   // Performing SQL query
   $query = "update Tag set $str where application_id='$app_id' AND tag_id=$tag_id";
   execute_query($query, $result);
   close_db($link);
}

function get_application($app_name)
{
   connect_db($link);
   // Connecting, selecting database
   $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD)  or die('Could not connect: ' . mysql_error());
   mysql_select_db(MY_DATABASE) or die('Could not select database');

   // Performing SQL query
   $query = 'SELECT * from Application where application_name=\''.$app_name.'\';';
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($line['application_name'] == $app_name){
        return $line;
      }
   }

   // Free resultset
   mysql_free_result($result);
   close_db($link);
}


function delete_application($app_name)
{
   $app_data = get_application($app_name);

   connect_db($link);

   // Performing SQL query

   //$query = 'DELETE from Message where application_id=\''.$app_data['application_id'].'\';';
   //execute_query($query, $result);

   //$query = 'DELETE from Board where application_id=\''.$app_data['application_id'].'\';';
   //execute_query($query, $result);

   $query = 'DELETE from Application where application_name=\''.$app_name.'\';';
   execute_query($query, $result);

   // Free resultset
   //mysql_free_result($result);
   close_db($link);
}

function create_update_application($new_app_name, $new_app_title, $new_app_description)
{
   connect_db($link);

   // Performing SQL query
   $query = 'SELECT application_id,application_name FROM Application';
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
       if($line['application_name'] == $new_app_name){
         //echo "Application $new_app_name already exists. Updating title and description!\n";
         $query = "UPDATE Application set application_title='$new_app_title', application_description='$new_app_description', mod_time=NOW() where application_name='$new_app_name';";
         execute_query($query, $result);
         // Free resultset
         //mysql_free_result($result);
      }
   }

   // Free resultset
   mysql_free_result($result);

   //echo "Application $new_app_name does NOT exists. Attempting to create application\n";

   $query = "INSERT into Application(application_name, application_title, application_description, mod_time) values('$new_app_name', '$new_app_title', '$new_app_description', NOW());";

   execute_query($query, $result);

   close_db($link);
}

function VerifyUser($user_name, $incoming_verification_code)
{
   connect_db($link);
   $query = "select * from UserTable where user_name='$user_name'";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if(($line['user_name']==$user_name) && ($line['user_verification_key']==$incoming_verification_code)){
         mysql_free_result($result);

         $is_verified = "VERIFIED";
         $query = "update UserTable set is_verified='$is_verified' where user_name='$user_name'";
         execute_query($query, $result);

         close_db($link);
         return USER_VERIFY_SUCCESS;
      }
   }
   close_db($link);
   return USER_DOES_NOT_EXISTS;
}

function AddUser($user_name, $user_email, $user_password, $user_type=USER_TYPE_NORMAL, $is_verified='NOTVERIFIED')
{
   connect_db($link);
   $query = "select * from UserTable where user_name='$user_name'";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($line['user_name']==$user_name){
         mysql_free_result($result);
         return USER_ALREADY_EXISTS;
      }
   }
   $user_verification_key = generate_verification_code($user_name, $user_email);
   $query = "insert into UserTable(user_name,user_email,user_password,user_verification_key, is_verified, user_type)  values('$user_name', '$user_email','".md5($user_password)."','$user_verification_key', '$is_verified', '$user_type')";
   execute_query($query, $result);

   close_db($link);
   if($is_verified=='NOTVERIFIED'){
      send_email_verification($user_email, $user_name, $user_verification_key);
   }
   return $user_verification_key;
}

function ResetUserVerificationKey($user_name, $user_email)
{
   connect_db($link);
   $query = "select * from UserTable where user_name='$user_name'";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($line['user_name']==$user_name){
         mysql_free_result($result);
         $user_verification_key = generate_verification_code($user_name, $user_email);
         $is_verified = "NOTVERIFIED";
         $query = "update UserTable set user_verification_key='$user_verification_key' is_verified='$is_verified' where user_name='$user_name' and user_email='$user_email' and user_password='".md5($user_password)."'";
         execute_query($query, $result);
         close_db($link);
         send_email_verification($user_email, $user_name, $user_verification_key);
         return USER_VERIFICATIONKEY_RESET_SUCCESS;
      }
   }
   close_db($link);
   return $user_verification_key;
}

function BlacklistUser($user_name, $is_user_name = true)
{
   $user_id = $user_name;
   if($is_user_name){
      $user_id = GetUserID($user_id);
   }
   connect_db($link);
   $query = "insert into BlacklistedUsers(user_id) values($user_id)";
   execute_query($query, $result);
   close_db($link);
}

function UnBlacklistUser($user_name, $is_user_name = true)
{
   $user_id = $user_name;
   if($is_user_name){
      $user_id = GetUserID($user_id);
   }
   connect_db($link);
   $query = "delete from BlacklistedUsers where user_id=$user_id";
   execute_query($query, $result);
   close_db($link);
}

function is_user_blacklisted($user_name, $is_user_name = true)
{
   $user_id = $user_name;
   if($is_user_name){
      $user_id = GetUserID($user_id);
   }
   connect_db($link);
   // Performing SQL query
   $query = "select * from BlacklistedUsers where user_id=$user_id;";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      return ($line['user_id']==$user_id);
   }
   close_db($link);
   return 0;
}

function GetUserID($user_name)
{
   $arr = GetUser($user_name);
   return (is_array($arr) && array_key_exists('user_id', $arr))? $arr['user_id']:USER_DOES_NOT_EXISTS;
}

function GetUserFromID($user_id)
{
   connect_db($link);
   $query = "select * from UserTable where user_id=$user_id";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($line['user_id']==$user_id){
         mysql_free_result($result);
         close_db($link);
         return $line;
      }
   }
   close_db($link);
   return USER_DOES_NOT_EXISTS;
}

function GetUser($user_name)
{
   connect_db($link);
   $query = "select * from UserTable where user_name='$user_name'";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      if($line['user_name']==$user_name){
         mysql_free_result($result);
         close_db($link);
         return $line;
      }
   }
   close_db($link);
   return USER_DOES_NOT_EXISTS;
}

function DeleteUser($user_name)
{
   connect_db($link);
   $query = "delete from UserTable where user_name='$user_name'";
   execute_query($query, $result);
   close_db($link);
   return $out_array;
}

function IsValidUserCredentials($user_name, $user_password, $do_md5 = true)
{
   $arr = GetUser($user_name);
   //print_r($arr);
   if(is_array($arr)){
      if($arr['is_verified']=='VERIFIED'){
         $cmp_string = ($do_md5)? md5($user_password):$user_password;
         if(($arr['user_name']==$user_name) && ($arr['user_password']==$cmp_string)){
            return true;
         }
      }
   }
   return false;
}

function get_all_tags(&$out_tags_array)
{
   connect_db($link);

   // Performing SQL query
   $query = 'select tag_name,tag_count from Tag order by tag_count desc;';
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      //array_push($out_tags_array, $line['tag_name']);
      $out_tags_array[$line['tag_name']] = $line['tag_count'];
   }
   close_db($link);
}

function get_tag_count(&$tag)
{
   connect_db($link);

   // Performing SQL query
   $query = "select tag_count from Tag where tag_name='$tag';";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      return $line['tag_count'];
   }
   close_db($link);
   return 0;
}

function get_user_board_count(&$user)
{
   connect_db($link);

   // Performing SQL query
   $query = "select user_board_count from UserTable where user_name='$user';";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      return $line['user_board_count'];
   }
   close_db($link);
   return 0;
}

function get_application_board_count($application_name)
{
   $application = get_application($application_name);
   return $application['no_boards'];
}

function get_board_message_count($application_id, $board_id)
{
   connect_db($link);

   // Performing SQL query
   $query = "select no_messages from Board where application_id=$application_id and board_id='$board_id';";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      return $line['no_messages'];
   }
   close_db($link);
   return 0;
}

function add_ip_to_blacklist_table($application_id, $ip)
{
   connect_db($link);

   // Performing SQL query
   $query = "insert into BlacklistedIps(ip) values($ip);";
   execute_query($query, $result);
   close_db($link);
   return 0;
}

function delete_ip_from_blacklist_table($application_id, $ip)
{
   connect_db($link);

   // Performing SQL query
   $query = "delete from BlacklistedIps where ip=$ip;";
   execute_query($query, $result);
   close_db($link);
   return 0;
}

function is_ip_blacklisted($ip)
{
   connect_db($link);

   // Performing SQL query
   $query = "select * from BlacklistedIps where ip=$ip;";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      return ($line['ip']==$ip);
   }
   close_db($link);
   return 0;
}



function get_latest_n_boards_of_latest_messages($application_id, $start=0, $count=NO_OF_MESSAGES_PER_PAGE)
{
   $out_array = array();

   if($count>MAX_BOARDS_TO_GET){$count=MAX_BOARDS_TO_GET;}
   connect_db($link);
   
   // Performing SQL query
   $query = "select * from Board join (select distinct board_id brd_id from Message order by create_date desc) a on Board.board_id = a.brd_id limit $start,$count;";
   execute_query($query, $result);
   $count = 0;
   $in_string = "";
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      ++$count;
      $in_string .= ($in_string=="")? "'".$line['board_id']."'" :" , "."'".$line['board_id']."'";
      $line['tags'] = array();
      GetTagsOfBoard($application_id, $line['board_id'], $line['tags']);
      $out_array[$count] = $line;
   }
   close_db($link);
   return $out_array;
}

function subscribe_user_to_board($application_id, $user_id, $board_id)
{
   connect_db($link);
   
   // Performing SQL query
   $query = "insert into UserSubscriptions values($user_id, '$board_id')";
   execute_query($query, $result);
   close_db($link);
   return (is_user_subscribed_to_board($application_id, $user_id, $board_id))? $board_id:"";
}

function unsubscribe_user_from_board($application_id, $user_id, $board_id)
{
   connect_db($link);
   
   // Performing SQL query
   $query = "delete from UserSubscriptions where user_id=$user_id AND board_id='$board_id'";
   execute_query($query, $result);
   close_db($link);
   return (is_user_subscribed_to_board($application_id, $user_id, $board_id))? "":$board_id;
}

function is_user_subscribed_to_board($application_id, $user_id, $board_id)
{
   connect_db($link);
   
   // Performing SQL query
   $query = "select user_id,board_id from UserSubscriptions where user_id=$user_id AND board_id='$board_id'";
   execute_query($query, $result);
   while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      //return json_encode((($line['user_id']==$user_id) && ($line['board_id']==$board_id)));
      return ((($line['user_id']==$user_id) && ($line['board_id']==$board_id)));
   }
   close_db($link);
   //return json_encode(false);
   return false;
}

function get_user_subscribed_boards($application_id, $user_id, $start, $count)
{
   $board_attrs_array = array();
   if($user_id != 1){
      connect_db($link);
      
      // Performing SQL query
      $out_array = array();
      $query = "select board_id from UserSubscriptions where user_id=$user_id limit $start, $count";
      execute_query($query, $result);
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
         array_push($out_array, $line['board_id']);
      }
      close_db($link);
      foreach($out_array as $k=>$board_id){
         $loc_board_attrs_array = get_board($application_id, $board_id);
         array_push($board_attrs_array, $loc_board_attrs_array);
      }
   }
   else{
      if(array_key_exists('subscriptions', $_COOKIE) && $_COOKIE['subscriptions']){
         $c = 0;
         $c1 = 0;
         $current_subscriptions = explode("," , $_COOKIE['subscriptions']);
         foreach($current_subscriptions as $loc_board_id){
            if($c<$start){++$c; continue;}
            ++$c1;
            $loc_board_attrs_array = get_board($application_id, $loc_board_id);
            array_push($board_attrs_array, $loc_board_attrs_array);
            if($c1==$count){break;}
         }
      }
   }
   return $board_attrs_array;
}

?>
