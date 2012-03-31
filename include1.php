<?php

//ALL FUNCTIONS THAT ARE SPECIFIC & COMMON TO PREMSKI.COM

function print_website($is_puzzle_site, &$left_content, &$middle_content, &$right_content, $top_banner_content = "http://premski.com", $user=PREMSKI_ANONYMOUS_USER, $title)
{
   global $prem_email, $menu_bar_color, $left_left_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $style = 1;
   global $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color;

   if($title==""){$title = "Premski.com - tough interview questions";}
   if($style==1){
      print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
      print "\n";
      print "<html>\n";
      print "<head>\n";

      //print '	<title>Premski.com - tough puzzles and technical interview questions</title>'."\n";
      print '	<title>'.$title.'</title>'."\n";
      print '	<meta name="keywords" content="premchand jayamohan, prem jayamohan, prem,technical interview,interview questions,brain teasers,brain stumpers,quizzles,t,algorithms,coding,databases,microsoft interview questions,google interview questions,amazon interview questions">'."\n";
      print '	<meta name="description" content="A website dedicated to technical interview questions, to enhance the knowledge of the serious software engineer.">'."\n";
      print '	<meta name="robots" content="index, follow">'."\n";
      print '	<meta name="GOOGLEBOT" content="INDEX, FOLLOW">'."\n";
      print '	<meta name="copyright" content="Copyright 2007 Premchand Jayamohan">'."\n";
      print "	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n"."\n";
      print "	<script language=\"JavaScript\" src=\"./all.js\"></script>\n";
      print "	<script language=\"JavaScript\" src=\"./md5.js\"></script>\n";
      print "	<script language=\"JavaScript\" src=\"./bloglines.js\"></script>\n";
      print "</head>\n";
      print "<body>	  \n";
      print '<script>set_bg_color("'.$overall_color.'");</script>';
      print "\n";

      $user_login_str = "";
      if($user==PREMSKI_ANONYMOUS_USER){
         $user_login_str = "<a href=page_gen.php?user_login>Sign In</a>";
      }
      else{
         $user_login_str = "Hi $user<br>[<a href=page_gen.php?signout>Sign Out</a>]";
      }

      print "<table align=center border=\"".TABLE_BORDER."\" width=100% CELLSPACING=".CELL_SPACING."><td>";
      //PRINT BANNER
      print "<table border=\"".TABLE_BORDER."\" width=100% CELLSPACING=".CELL_SPACING.">";
      print "<tr>";
      
      print "<td align=center bgcolor=$top_banner_color width=85%>";
      //print "	<tr height=70><TH colspan=1 bgcolor=$top_banner_color><font color=white face=arial size=18>$top_banner_content</font></tr>";
      //print "</td>";
      
      //print "  <TH  bgcolor=$top_banner_color><font color=white face=arial size=18>$top_banner_content</font>";
      print "  <font color=white face=arial size=18>$top_banner_content</font>";
      print "</td>";
      
      print "<td align=right bgcolor=$top_banner_color  width=15%>";
      //print "  <tr height=70><TH colspan=1 bgcolor=$top_banner_color>$user_login_str</tr>";
      //print "  <TH colspan=1 bgcolor=$top_banner_color>$user_login_str";
      print "$user_login_str";
      print "</td>";
      
      
      print "</tr>";
      print "</table>";
      
      if($is_puzzle_site)
      {
         //PRINT MENU BAR
         //xxx hardcoding urls - need to become dynamic
//xxxxx
         $menu_bar_array = array(
             "Home" => "/page_gen.php?puzzles"
//	        , "Post question" => "./page_gen.php?add_puzzle_question"
	        , "Feedback" => "./page_gen.php?id=bea4c2c8eb82d05891ddd71584881b56"
	        , "Blog" => "./page_gen.php?id=be8df1f28c0abc85a0ed0c6860e5d832"
	        , "Resources" => "./page_gen.php?id=ddcf50c29294d4414f3f7c1bbc892cb5"
           , "About" => "./page_gen.php?about_puzzles"
           , "<img src=./images/rssfeed.gif>" => "./rss"
	        //, $user_login_str => "./page_gen.php?user_login"
	     );
         //print "<table border=\"".TABLE_BORDER."\" width=100%>";
         print "<table border=\"".TABLE_BORDER1."\" CELLSPACING=".CELL_SPACING.">";
         print "<tr>";
         foreach($menu_bar_array as $disp_name=>$url){
            //print "<p>";
            if($disp_name==$user_login_str){
               print "<td width=2% align=right bgcolor=$menu_bar_color>";
            }
            else{
               print "<td width=2% align=center bgcolor=$menu_bar_color>";
            }
            print "<a href=$url style='text-decoration:none;'><b>$disp_name</b></a>";
            print "</td>";
            //print "</p>";
         }
         print "</tr>";
         print "</table>";
      }
      
      if($is_puzzle_site){
         $left_content = "";
         $out_tags_array = array();
         $left_content .= "<table cellspacing=0>";
         /*
         $left_content .= "<tr><td align=center bgcolor=$top_banner_color>";
         $left_content .= "<b><font color=black>Categories</font></b>";
         $left_content .= "</td></tr>";
         //*/
         
         
         //"<input type='image' src=\"$img1\" onClick=\"star_Function('$board_id');\" border=\"0\" id=\"$img_element_id\">"
         //"<img src=\"images/star_active.png\" border=\"0\">"
         $left_content .= "<font color=white face=arial size=3>"."<a href=/page_gen.php?starred_questions style='text-decoration:none;'><img src=\"images/star_active.png\" border=\"0\">Starred</a></font>"."<hr><a href=\"./page_gen.php?add_puzzle_question\" style='text-decoration:none;color:red'><b>Add Question</b></a><hr>";
//"Post question" => "./page_gen.php?add_puzzle_question"
//xxxxx
         
         
         
         
         $left_content .= "<tr><td align=center>";
         get_all_tags($out_tags_array);

         $left_content .= "<table border=0>";
         foreach($out_tags_array as $tag_name=>$tag_count){
            $left_content .= "<tr>";

            //$left_content .= "<td><font color=white face=arial size=3>"."<a href=/page_gen.php?tag_questions&tag=".urlencode($tag_name)."  style='text-decoration:none;'><b><div style=\"text-align:right;\">".$tag_name."</div></b></a></font></td>";
            //$left_content .= "<td><div style=\"text-align:left;\">($tag_count)</div></td>";

            $left_content .= "<td><font color=white face=arial size=3>"."<a href=/page_gen.php?tag_questions&tag=".urlencode($tag_name)."  style='text-decoration:none;'><b><div style=\"text-align:center;\">".$tag_name." ($tag_count)</div></b></a></font></td>";
            //$left_content .= "<td><div style=\"text-align:left;\">($tag_count)</div></td>";

            //$left_content .= "<b><font color=white face=arial size=3>"."<a href=/page_gen.php?tag_questions&tag=".urlencode($tag_name)."  style='text-decoration:none;'>".$tag_name."</a></font></b> ($tag_count)"."<br>";


            $left_content .= "</tr>";
            $left_content .= "<tr></tr>";
            $left_content .= "<tr></tr>";
         }
         $left_content .= "</table>";
         $left_content .= "</td></tr>";
         $left_content .= "</table>";
      }
      //PRINT CONTENT
      print "<table border=\"".TABLE_BORDER1."\" width=100% CELLSPACING=".CELL_SPACING.">";
      print "<tr>";
      print "<td width=18% valign=top bgcolor=$left_left_color align=center valign=top>";
      print "$left_content\n";
      print "</td>";
      print "<td width=65% bgcolor=".$middle_color." valign=top>";
      print "$middle_content\n";
      print "</td>";
      print "<td width=17% bgcolor=".$right_color." align=center valign=top>";
      print "$right_content";
      print "</td>";
      print "</tr>";
      print "</table>";
      print "<table border=\"".TABLE_BORDER1."\" width=100% CELLSPACING=".CELL_SPACING.">";
      print "<tr ><td align=center>Created by <a href=./page_gen.php?resume>Premchand Jayamohan</a></td></tr>";
      print "</table>";

      print "</td></table>";
   }
   if($style==0){
      print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
      print "\n";
      print "<html>\n";
      print "<head>\n";

      print "	<title>Premski.com</title>\n";
      print "	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
      print "	<script language=\"JavaScript\" src=\"./all.js\"></script>\n";
      print "	<script language=\"JavaScript\" src=\"./bloglines.js\"></script>\n";
      print "</head>\n";
      print "<body>	  \n";
      print '<script>set_bg_color("'.$overall_color.'");</script>';
      print "\n";

      $user_login_str = "";
      if($user==PREMSKI_ANONYMOUS_USER){
         $user_login_str = "<a href=page_gen.php?user_login>Sign In";
      }
      else{
         $user_login_str = "Hi $user<br>[<a href=page_gen.php?signout>Sign Out</a>]";
      }

      print "<table border=\"".TABLE_BORDER."\" width=100%>
      <tr>
      $user_login_str
      </tr>
      <tr>
      <td colspan=\"3\" align=center>";
      print "	<tr height=70><TH colspan=\"3\" bgcolor=".$top_banner_color."><font color=\"white\" face=\"arial\" size=18>$top_banner_content</font></tr>";
      print "</td>
      </tr>
      <tr>
      <td width=15% valign=top bgcolor=\"".$menu_bar_color."\" align=center valign=top>";
      print "$left_content\n";
      //print "row 2, cell 1";
      print "</td>
      <td width=70% bgcolor=\"".$middle_color."\" valign=top>";
      print "$middle_content\n";
      print "</td>
      <td width=15% bgcolor=\"".$right_color."\" align=center valign=top>";
      print "$right_content";
      print "</td>
      </tr>
      <tr colspan=3>
      <td>Created by <a href=./index.html>Premchand Jayamohan</a></td>
      </tr>
      </table>";
   }
   if($style==2){
      print "	<title>Premski.com</title>\n";
      print "	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
      print "	<script language=\"JavaScript\" src=\"./all.js\"></script>\n";
      print "	<script language=\"JavaScript\" src=\"./bloglines.js\"></script>\n";
      print "</head>\n";
      print "<body>	  \n";
      print '<script>set_bg_color("'.$overall_color.'");</script>';
      print "\n";
      print "<table class=\"main\" cellspacing=0>\n";
      print "	<tr height=70><TH colspan=\"5\" bgcolor=".$top_banner_color."><font color=\"white\" face=\"arial\" size=8>$top_banner_content</font></tr>";
      print "\n";
      print "<tr></tr>";
      print "<tr valign=\"top\">\n";
      print "<td width=175 bgcolor=".$menu_bar_color." align=center>\n";
      print "$left_content\n";
      print "</td>\n";
      print "\n";
      print "<td >&nbsp;</td>\n";
      print "<td bgcolor=".$middle_color.">\n";
      print "$middle_content\n";
      print "\n";
      print "<p><table align=\"left\" >\n";
      print "<tr>\n";
      print "</tr>\n";
      print "\n";
      print "\n";
      print "</table>\n";
      print "\n";
      print "\n";
      print "<!-- end page content -->\n";
      print "\n";
      print "\n";
      print "\n";
      print "\n";
      print "</td>\n";
      print "<td >&nbsp;</td>\n";
      print "<td >\n";
      print "\n";
      print "<table cellspacing=0><tr><td bgcolor=".$right_color.">\n";
      print "$right_content\n";
      print "</td></tr>\n";
      print "</table>";
      print "</table>";//prem
   }
   print_google_analytics_code();
   print "</body>\n";
   print "</html>\n";
}

function print_google_analytics_code()
{
   print '<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">';
   print '</script>';
   print '<script type="text/javascript">';
   print '_uacct = "UA-2538715-1";';
   print 'urchinTracker();';
   print '</script>';
}

function format_top_banner_content(&$top_banner_content, &$name, &$img_url)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   if(!(($name=="") && ($img_url==""))){
      $top_banner_content = "<table border=".TABLE_BORDER." width=100% valign=center>";
      $top_banner_content .= "<tr>";
      $top_banner_content .= "<td width=33%>";
      $top_banner_content .= "</td>";
      $top_banner_content .= "<td width=33% align=center>";
      $top_banner_content .= "<font color=\"white\" face=\"arial\" size=18 align=center>";
      $top_banner_content .= $name;
      $top_banner_content .= "</font>";
      $top_banner_content .= "</td>";
      $top_banner_content .= "<td width=33% align=right>";
      $top_banner_content .= "<img src=\"".$img_url."\">";
      $top_banner_content .= "</td>";
      $top_banner_content .= "</tr>";
      $top_banner_content .= "</table>";
   }
}

function print_tagged_puzzle_items($HTTP_GET_VARS1, $user, $title, $arr, &$out_string, $start=0, $count=NO_OF_MESSAGES_PER_PAGE, $print_prev_first_next = true, $get_puzzles_by="puzzles", $tag="")
{
   //USED TO DISPLAY ALL PUZZLE QUESTIONS
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

   $out_string .= "<h3>".$title."</h3>";
   $out_string .=  "<table cellpadding=\"13\" align=\"center\" width=\"100%\" border=\"".TABLE_BORDER."\">";

   if($print_prev_first_next){
      print_prev_first_next($out_string, $start, $count, $get_puzzles_by);
   }

   $count = 0;
   foreach ($arr as $item)
   {
      print_puzzle_items_questions_only(true, $HTTP_GET_VARS1, $user, $item, $out_string, true, false, false, true, false, REPLY_TYPE_URL);
   }
   if($print_prev_first_next){
      $out_string .= "<hr>";
      print_prev_first_next($out_string, $start, $count, $get_puzzles_by);
   }
}

function print_puzzle_items1($tag_count, $HTTP_GET_VARS1, $user, $title, $arr, &$out_string, $start=0, $count=NO_OF_MESSAGES_PER_PAGE, $print_prev_first_next = true, $get_puzzles_by="puzzles")
{
   //USED TO DISPLAY ALL PUZZLE QUESTIONS
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

   $out_string .= "<h3>".$title."</h3>";
   $out_string .=  "<table cellpadding=\"13\" align=\"center\" width=\"100%\" border=\"".TABLE_BORDER."\">";

   if($print_prev_first_next){
      print_prev_first_next($out_string, $start, $count, $get_puzzles_by, $tag_count);
   }

   $count = 0;
   foreach ($arr as $item)
   {
      print_puzzle_items_questions_only(true, $HTTP_GET_VARS1, $user, $item, $out_string, true, false, false, true, false, REPLY_TYPE_URL);
   }
   if($print_prev_first_next){
      $out_string .= "<hr>";
      print_prev_first_next($out_string, $start, $count, $get_puzzles_by, $tag_count);
   }
}

function print_puzzle_items($application_id, &$random_array, $tag_count, $HTTP_GET_VARS1, $user, $title, $arr, &$out_string, $start=0, $count=NO_OF_MESSAGES_PER_PAGE, $print_prev_first_next = true, $get_puzzles_by="puzzles")
{
   //USED TO DISPLAY ALL PUZZLE QUESTIONS
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

//print_puzzle_items_questions_only
   if($print_prev_first_next){
      print_prev_first_next($out_string, $start, $count, $get_puzzles_by, $tag_count);
   }
   
   if(count($random_array)){
      $out_string .= '<fieldset style="margin-left:15px; margin-right:15px;border: 2px dashed #FFFFCC;">';
      $out_string .= '<legend ><b><i>Random</i></b></legend>';
      $out_string .= '<div style="float:centre;">';
      foreach ($random_array as $item)
      {
         print_puzzle_items_questions_only($application_id, true, $HTTP_GET_VARS1, $user, $item, $out_string, true, false, false, true, false, REPLY_TYPE_URL);
      }
      $out_string .= '</div>';
      $out_string .= '</fieldset>';
   }
   
   $out_string .= "<h3>".$title."</h3>";
   $out_string .=  "<table cellpadding=\"13\" align=\"center\" width=\"100%\" border=\"".TABLE_BORDER."\">";
   foreach ($arr as $item)
   {
      print_puzzle_items_questions_only($application_id, true, $HTTP_GET_VARS1, $user, $item, $out_string, true, false, false, true, false, REPLY_TYPE_URL);
   }
   if($print_prev_first_next){
      $out_string .= "<hr>";
      print_prev_first_next($out_string, $start, $count, $get_puzzles_by, $tag_count);
   }
   //$out_string .= "</table>";
}


//CURRENTLY NOT USED
function print_random_puzzle_items($HTTP_GET_VARS1, $user, $title, $arr, &$out_string)
{
   //USED TO DISPLAY ALL PUZZLE QUESTIONS
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

   
   $out_string .= "<div title=$title style=\"outline-color:blue;outline-style: groove;\">";
   //$out_string .= "<div title=$title style=\"outline-style: ridge;\">";
   
   
   //$out_string .= "<h3>".$title."</h3>";
   //$out_string .=  "<table cellpadding=\"13\" align=\"center\" width=\"100%\" border=\"".TABLE_BORDER."\">";

   //$count = 0;
   foreach ($arr as $item)
   {
      print_puzzle_items_questions_only(true, $HTTP_GET_VARS1, $user, $item, $out_string, true, false, false, true, false, REPLY_TYPE_URL);
   }
   //$out_string .= "</tr>";
   //$out_string .= "</td>";
   //$out_string .= "</table>";
   $out_string .= "</div>";
   
}

function print_puzzle_items_questions_only($application_id, $show_link_icon, &$HTTP_GET_VARS1, $user, &$item, &$out_string, $print_link = true, $print_answer_form=true, $display_feedback_and_blog_items=false, $print_answer_comments=true, $div_show=false, $print_answer_type=REPLY_TYPE_URL, $answer_string = "Answer")
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   if($display_feedback_and_blog_items==false){
      if(($item['board_id']==BLOG_BOARD_ID) || ($item['board_id']==FEEDBACK_BOARD_ID) || ($item['board_id']==RESOURCE_BOARD_ID)){return;}
   }

   $author_id = $item['creator_id'];
   $id = $item['board_id'];
   $div_name = "answer_puzzle_div_".$id;
   $temp = "page_gen.php?id=$id";
   $logged_in_user_id = GetUserID($user);
   if(!array_key_exists('tags', $item)){$item['tags']=array();}
   $delete_link = "./page_gen.php?delete_board&board_id=$id";
   $update_link = "./page_gen.php?update_board&board_id=$id";
   print_blog_item2($application_id, $item['board_id'], $show_link_icon, $item['create_ip'], $update_link, $delete_link, $logged_in_user_id, $item['tags'], $author_id, $div_name, $HTTP_GET_VARS1, $user, $item['board_title'], $item['no_messages'], $item['create_time'], $item['board_description'], $temp, $out_string, "", "", "", $answer_string, $print_link, $print_answer_comments, true, $print_answer_type, $div_show);
   $out_string .=  "<br>";
}

function print_puzzle_items_answer($application_id, $show_link_icon, $tag_count, $HTTP_GET_VARS1, $user, $title, $arr, &$out_string, $id, &$start, &$count)
{
   //USED TO DISPLAY ALL ANSWERS FOR ONE QUESTION
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $out_string .= "<h3>".$title."</h3>";
   print_prev_first_next($out_string, $start, $count, "id=$id", $tag_count);
   foreach ($arr as $k=>$item)
   {
      $temp = "";
      $temp2 = -1;
      $author_id = $item['creator_id'];
      $logged_in_user_id = GetUserID($user);
      if(!array_key_exists('tags',$item)){$item['tags']='';}
      $delete_link = "./page_gen.php?delete_message&board_id=".$item['board_id']."&message_id=".$item['message_id'];
      $update_link = "./page_gen.php?update_message&board_id=".$item['board_id']."&message_id=".$item['message_id'];
      //print $item['description'];
      print_blog_item2($application_id, $item['board_id'], $show_link_icon, $item['create_ip'], $update_link, $delete_link, $logged_in_user_id, $item['tags'], $author_id, "",$HTTP_GET_VARS1, $user, $item['title'], $temp2, $item['create_date'], $item['description'], $temp, $out_string, "", "", "", "", false, false);
      $out_string .=  "<br>";
   }
   print_prev_first_next($out_string, $start, $count, "id=$id", $tag_count);
}

function print_prev_first_next(&$out_string, &$start, &$count, $get_param_to_paginate, $tag_count)
{
   $param_array = explode('&', $get_param_to_paginate);
   //print_r($param_array);
   $get_param_to_paginate = "";
   foreach($param_array as $index=>$value){
      $assignment_array = explode('=', $value);
      if(count($assignment_array)>1){
         $tmp_str = $assignment_array[0].'='.urlencode($assignment_array[1]);
         $get_param_to_paginate .= ($get_param_to_paginate=="")? $tmp_str:'&'.$tmp_str;
      }
      else{
         $get_param_to_paginate .= ($get_param_to_paginate=="")? $value:'&'.$value;
      }
   }
   $prev_url = "";
   if($start!=0){
      if($start<NO_OF_MESSAGES_PER_PAGE){
         $prev_url = "page_gen.php?".$get_param_to_paginate."&start=0&count=".MAX_BOARDS_TO_GET;
      }
      else{
         $prev_url = "page_gen.php?".$get_param_to_paginate."&start=".($start-NO_OF_MESSAGES_PER_PAGE)."&count=".MAX_BOARDS_TO_GET;
      }
   }


   $first_url = "page_gen.php?".$get_param_to_paginate."&start=0&count=".MAX_BOARDS_TO_GET;

   $next_url = "page_gen.php?".$get_param_to_paginate."&start=".($start+NO_OF_MESSAGES_PER_PAGE)."&count=".MAX_BOARDS_TO_GET;

   $tmp_bool = 0;
   $out_string .= "<p align=".PREV_FIRST_NEXT_ALIGN.">";
   if($prev_url != ""){
      $out_string .= "<b><a href=$prev_url  style='text-decoration:none;'>&laquo; previous</a></b>";
      $tmp_bool = 1;
   }
   if(!($start<NO_OF_MESSAGES_PER_PAGE)){
      if($tmp_bool){$out_string .= " | ";}
      $out_string .= "<b><a href=$first_url style='text-decoration:none;'>first</a></b>";
   }
   if(!($start+NO_OF_MESSAGES_PER_PAGE>=$tag_count)){
      if($tmp_bool){$out_string .= " |  ";}
      $out_string .= "<b><a href=$next_url  style='text-decoration:none;'>next &raquo;</a></p></b>";
   }
}

function print_all_livejournal_items($title, $arr, &$out_string)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $out_string .= "<h1>".$title."  <a href=http://premj.livejournal.com/rss><img src=images/rssfeed.gif alt=RSS feed></a></h1>";
   $out_string .=  "<table cellpadding=\"13\" align=\"center\" width=\"100%\" border=\"".TABLE_BORDER."\">";
   $count = 0;
   foreach ($arr as $item)
   {
      print_blog_item($item['title'], $item['pubdate'], $item['description'], $item['link'], $out_string);
   }
   $out_string .= "<p align=center>Click <a href=http://premj.livejournal.com>here</a> to view my entire blog</p>";
}

function print_blog_item(&$title, &$pubdate, &$description, &$link, &$out_string)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $out_string .= "<table width = 600 cellpadding='2' cellspacing='2' align=\"center\">";

   $out_string .= "<tr><td align='top'>";
   $out_string .= "<table width='600' cellpadding='2' cellspacing='0'>";
   $out_string .= "<tr align='left'><td bgcolor=\"#7c6ccd\" align=\"center\">";


   $out_string .= "<tr align='left'><td bgcolor=\"#7c6ccd\" align=\"center\">";
   $out_string .= "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"0\" border=\"".TABLE_BORDER."\" summary=\"\">";
   $out_string .= "<tr align='left'><td style=\"color: #ffffff\">";
   $out_string .= "<b>".$title."</b>";
   $out_string .= "</td><td align=\"right\" style=\"font-size: 8pt; color: #ffffff\">";
   $out_string .= $pubdate;
   $out_string .= "</b>]</td></tr>";
   $out_string .= "<tr align='left'>";
   $out_string .= "<td colspan=\"2\" bgcolor=\"#ffffff\" style='color: #000000'>";
   $out_string .= "<p>".$description."</p>";
   $out_string .= "</td></tr>";
   $out_string .= "<tr bgcolor=\"#eef0fd\"><td align='left' class='style: font-size: 8pt'>";
   $out_string .= "<a style='text-decoration:none;color: #0000ff' href=\"".$link."\">link</a>";
   $out_string .= "</td><td align='right' style='font-size: 8pt'>";
   $out_string .= "<a href=".$link."?mode=reply style='text-decoration:none;color:#0000ff'>post comment</a>";
   $out_string .= "</td></tr></table>";
   $out_string .= "</td></tr></table>";
   $out_string .= "</td></tr></table>";
}


function print_blog_item2($application_id, $board_id, $show_link_icon, $ip, $update_link_url, $remove_link_url, $logged_in_user_id, $author_tags_array, $author_id, $div_name, $HTTP_GET_VARS1, $user, &$title, &$no_comments, &$pubdate, &$description, &$link, &$out_string, $alternate_link_url="", $alternate_link_text="", $alternate_reply_url="", $alternate_reply_text="", $print_link=true, $print_reply=true, $print_no_comments=true, $reply_answer_type=REPLY_TYPE_URL, $div_show=false)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

   $author_name = PREMSKI_ANONYMOUS_USER_DISPLAY;
   if($author_id!=PREMSKI_ANONYMOUS_USER_ID){
      $author_array = GetUserFromID($author_id);
      $author_name = $author_array['user_name'];
   }
   $author_string = '<b>Author</b>:';
   if($author_name == PREMSKI_ANONYMOUS_USER_DISPLAY){
      $author_string .= "$author_name";
   }
   else{
      $local_title = "Click to view questions posted by ".$author_name;
      $author_string .= "<a href=page_gen.php?author_questions&user=$author_name title=\"$local_title\" style='text-decoration:none;'>$author_name</a>";
   }

   $ITEM_ENTIRE_TABLE_COLOR = '#2d4f88';
   $ITEM_TITLE_TEXT_COLOR = '#ffffff';
   $ITEM_TITLE_BGCOLOR = '#000000';
   $ITEM_DESCRIPTION_TEXT_COLOR = '#000000';
   $ITEM_DESCRIPTION_BGCOLOR = '#ffffff';
   $ITEM_DESCRIPTION_TR_BGCOLOR = '#ffffff';
   $ITEM_LINK_BGCOLOR = '#aaaaaa';
   $ITEM_PUBDATE_TEXT_COLOR = '#ffffff';

   {
      $ITEM_ENTIRE_TABLE_COLOR = '#7c6ccd';
      $ITEM_TITLE_TEXT_COLOR = '#ffffff';
      $ITEM_TITLE_BGCOLOR = '#7c6ccd';
      $ITEM_DESCRIPTION_TEXT_COLOR = '#000000';
      $ITEM_DESCRIPTION_BGCOLOR = '#ffffff';
      $ITEM_DESCRIPTION_TR_BGCOLOR = '#ffffff';
      $ITEM_LINK_BGCOLOR = '#eef0fd';
      $ITEM_PUBDATE_TEXT_COLOR = '#ffffff';
   }


   $final_link_url = ($alternate_link_url=="")? $link: $alternate_link_url;
   $final_link_text = ($alternate_link_text=="")? "link":$alternate_link_text;
   $link_string = "<a href=$final_link_url style='text-decoration:none;color:#0000ff'>$final_link_text</a>";
   if($print_link==false){$link_string="";}
   $final_reply_url = ($alternate_reply_url=="")? $final_link_url."&mode=reply": $alternate_reply_url;
   $final_reply_text = ($alternate_reply_text=="")? "post comment":$alternate_reply_text;

   $tag_string = "";
   //print_r($author_tags_array);
   if(is_array($author_tags_array)){
      foreach($author_tags_array as $tag){
         if($tag!="All"){
            $local_title = "Click to view other '$tag' questions";
            if($tag_string==""){
               $tag_string .= "<a href=page_gen.php?tag_questions&tag=".urlencode($tag)." title=\"$local_title\" style='text-decoration:none;color:#0000ff'>$tag</a>";
            }
            else{
               $tag_string .= " | <a href=page_gen.php?tag_questions&tag=".urlencode($tag)." title=\"$local_title\" style='text-decoration:none;color:#0000ff'>$tag</a>";
            }
         }
      }
   }
   if($tag_string!=""){$tag_string = "<b>Tags</b>: ".$tag_string;}
   $tag_style = "style=\"font-size: 10pt;color: #000000\"";
   $answer_style = "style=\"font-size: 12pt;color: #000000\"";
   $comment_style = "style=\"font-size: 10pt;color: #00000\"";
   $username_style = "style=\"font-size: 10pt;color: #000000\"";

   $comment_string = "";
   if($print_no_comments==true){
      if(($no_comments!= -1) && ($no_comments!= 0)){
         $comment_string .= "<a href=$final_link_url style='text-decoration:none;'>$no_comments Comment".(($no_comments>1)? "s":"")."</a>";
      }
   }

   $div_style_string = ($div_show)? "":"style=\"display:none;padding-left:45px;\"";

   $answer_string = "";
   if($print_reply){
      if($reply_answer_type==REPLY_TYPE_URL){$answer_string = "<a href=".$final_reply_url." style='text-decoration:none;color:#0000ff'>".$final_reply_text."</a>";}
      if($reply_answer_type==REPLY_TYPE_BUTTON){
         $answer_string = "<p style=\"text-align:right;\"><input type=\"submit\" value=\"".$final_reply_text."\" onClick=\"javascript: toggle_show_hide_div('$div_name')\"></p>";
      }
   }

   //START DISPLAY
   $out_string .= "<table width=98% cellpadding='2' cellspacing='2' align=\"center\">";
      $out_string .= "<tr>";
         $out_string .= "<td bgcolor=\"".$ITEM_ENTIRE_TABLE_COLOR."\" align=\"center\">";


            $out_string .= "<table width = 100% cellpadding='2' cellspacing='0' align=\"center\" border=".TABLE_BORDER.">";
               $out_string .= "<tr bgcolor=\"".$ITEM_TITLE_BGCOLOR."\">";
                  
                  $out_string .= "<td width=50% colspan=3 align=left style=\"color: ".$ITEM_TITLE_TEXT_COLOR."\">";
                  //TITLE
                  $loc_title = unescape_text($title);
                  //if($logged_in_user_id != 1){
                  
                  if(1){
                     $is_user_subscribed = false;
                     if($logged_in_user_id == 1){
                        if(array_key_exists('subscriptions', $_COOKIE)){
                           $current_subscriptions = explode("," , $_COOKIE['subscriptions']);
                           foreach($current_subscriptions as $loc_board_id){
                              if($loc_board_id==$board_id){
                                 $is_user_subscribed = true;
                                 break;
                              }
                           }
                        }
                     }
                     else{
                        $is_user_subscribed = is_user_subscribed_to_board($application_id, $logged_in_user_id, $board_id);
                     }
                     $img1 = ($is_user_subscribed)? "images/star_active.png":"images/star_inactive.png";
                     $local_title = "star this puzzle";
                     $local_url = "http://".HOST_NAME."/page_gen.php?toggle_user_subscription_to_puzzle&id=".$board_id;
                     $img_element_id = "m_".$board_id."_id";
                     if($logged_in_user_id == 1){
                        $out_string .= "<input type='image' src=\"$img1\" onClick=\"star_Function('$board_id');\" border=\"0\" id=\"$img_element_id\"> ";
                     }
                     else{
                        $out_string .= "<input type='image' src=\"$img1\" onClick=\"star_ajaxFunction('$local_url');\" border=\"0\" id=\"$img_element_id\"> ";
                     }
                  }
                  $out_string .= "<b>".$loc_title."</b>";
                  $out_string .= "</td>";
                  
                  //$out_string .= "<td width=50% colspan=1 align=right style=\"font-size: 8pt;color: ".$ITEM_PUBDATE_TEXT_COLOR."\">";
                  //PUBDATE
                  //$out_string .= "<a href=\"$final_link_url\"><img src=\"goto.gif\" border=\"0\"></a> ";
                  //$out_string .= "</td>";
                  
                  $out_string .= "<td width=50% colspan=2 align=right style=\"font-size: 8pt;color: ".$ITEM_PUBDATE_TEXT_COLOR."\">";
                  //PUBDATE
                  $out_string .= "[<b>$pubdate</b>]";
                  if($show_link_icon){
                     $local_title = "link";
                     $out_string .= "&nbsp&nbsp&nbsp<a href=\"$final_link_url\" title=\"$local_title\"><img src=\"images/goto.jpg\" border=\"0\"></a> ";
                  }

                  $out_string .= "</td>";
                  
                  
                  
                  
               $out_string .= "</tr>";

               $out_string .= "<tr bgcolor=\"".$ITEM_DESCRIPTION_TR_BGCOLOR."\" align='left'>";
                  //$out_string .= "<td width=100% colspan=5 bgcolor=\"".$ITEM_DESCRIPTION_BGCOLOR."\" style='color: ".$ITEM_DESCRIPTION_TEXT_COLOR."'><pre width=100%><font color=black face=times size=5>";
                  $out_string .= "<td width=100% colspan=5 bgcolor=\"".$ITEM_DESCRIPTION_BGCOLOR."\" style='color: ".$ITEM_DESCRIPTION_TEXT_COLOR."'><font color=black face=times size=5>";
                  //DESCRIPTION
		  //print $description;
		  $loc_description = $description;
        $loc_description = unescape_text($loc_description);
                  //$loc_description = html_entity_decode($description);
                  //$loc_description = stripslashes($loc_description);
                    //$out_string .= "<p>".$loc_description."</p>";
                    $out_string .= $loc_description;
                  //$out_string .= "<p><pre>".$loc_description."</pre></p>";
		  //$out_string .= $loc_description;
                  $out_string .= "</font></td>";
               $out_string .= "</tr>";

               $out_string .= "<tr bgcolor=\"".$ITEM_LINK_BGCOLOR."\">";
                  //Link
                  //$out_string .= "<td width=20% align=left>";
                  $out_string .= "<td width=10% align=left>";
                     $out_string .= $link_string;
                  $out_string .= "</td>";

                  //User;
                  //$out_string .= "<td width=20% align=left $username_style>";
                  $out_string .= "<td width=15% align=left $username_style>";
                  $out_string .= $author_string;
                  $out_string .= "</td>";

                  //Tags
                  $out_string .= "<td width=45% align=left $tag_style>";
                     $out_string .= $tag_string;
                  $out_string .= "</td>";

                  //No of COMMENTS
                  $out_string .= "<td width=20% align=right $comment_style>";
                     $out_string .= $comment_string;
                  $out_string .= "</td>";

                  //ANSWER string/BUTTON
                  $out_string .= "<td width=10% align=right $answer_style>";
                     $out_string .= $answer_string;
                  $out_string .= "</td>"
                  ;
               $out_string .= "</tr>";
            if($reply_answer_type==REPLY_TYPE_BUTTON){
               $out_string .= "<tr>";
                  $out_string .= "<td width=100% colspan=5 align=center>";
                  $out_string .= "<div $div_style_string id=$div_name>";
                  $str = PUZZLE_REPLY_FORM_NAME;
                  form_helper_function($user, $str, $out_string, $HTTP_GET_VARS1, true, true, false, true, true, true, "xxxx", true);
                  $out_string .= "</div>";
                  $out_string .= "</td>";
               $out_string .= "</tr>";
            }

$logged_in_user_array = GetUserFromID($logged_in_user_id);

if($logged_in_user_array['user_type']=='ADMIN'){
$blacklist_user_link_url = "./page_gen.php?blacklist_user&user_id="."$author_id";
$blacklist_ip_link_url = "./page_gen.php?blacklist_ip&ip=$ip";
   $remove_link_string = "<a href=$remove_link_url style='text-decoration:none;color:#0000ff'>delete</a>";
   $update_link_string = "<a href=$update_link_url style='text-decoration:none;color:#0000ff'>update</a>";
   $blacklist_user_link_string = "<a href=$blacklist_user_link_url style='text-decoration:none;color:#0000ff'>Blacklist User</a>";
   $blacklist_ip_link_string = "<a href=$blacklist_ip_link_url style='text-decoration:none;color:#0000ff'>Blacklist IP</a>";

   $out_string .= "<tr bgcolor=\"".$ITEM_LINK_BGCOLOR."\">";
      $out_string .= "<td width=10% align=left>";
         $out_string .= $remove_link_string;
      $out_string .= "</td>";
      $out_string .= "<td width=10% align=left>";
         $out_string .= $update_link_string;
      $out_string .= "</td>";
      $out_string .= "<td width=10% align=left>";
         $out_string .= $blacklist_user_link_string;
      $out_string .= "</td>";
      $out_string .= "<td width=10% align=left>";
         $out_string .= $blacklist_ip_link_string;
      $out_string .= "</td>";
      $out_string .= "<td width=10% align=left>";
         $out_string .= "---";
      $out_string .= "</td>";
   $out_string .= "</tr>";
}
   $out_string .= "</table>";
   $out_string .= "</td>";
   $out_string .= "</tr>";
   $out_string .= "</table>";

}

function print_google_ads(&$out_string)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $out_string .= '<script type="text/javascript"><!--';$out_string .= "\n";
   //$out_string .= 'google_ad_client = "pub-3408947597456708";';$out_string .= "\n";
   $out_string .= 'google_ad_client = "pub-0836153465677314";';$out_string .= "\n";
   $out_string .= 'google_ad_width = 120;';$out_string .= "\n";
   $out_string .= 'google_ad_height = 600;';$out_string .= "\n";
   $out_string .= 'google_ad_format = "120x600_as";';$out_string .= "\n";
   $out_string .= 'google_ad_type = "text_image";';$out_string .= "\n";
   $out_string .= 'google_ad_channel = "";';$out_string .= "\n";
   $out_string .= '//--></script>';$out_string .= "\n";
   $out_string .= '<script type="text/javascript"';$out_string .= "\n";
   $out_string .= 'src="http://pagead2.googlesyndication.com/pagead/show_ads.js">';$out_string .= "\n";
   $out_string .= '</script>';$out_string .= "<br>";
}

function print_realmedia_ads(&$out_string)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $out_string .= '<!-- BEGIN TAG - 160x600 - www.premski.com - DO NOT MODIFY -->';$out_string .= "\n";
   $out_string .= '<script type="text/javascript" src="http://optimizedby.rmxads.com/st?ad_type=ad&ad_size=160x600&section=263616"></script>';$out_string .= "\n";
   $out_string .= '<!-- END TAG -->';$out_string .= "<br>";
}

function print_standard_left_content(&$left_content)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $left_content = "<script language=javascript>\n";
   $left_content .= "	var top_menu_array = Array(\n";
if($development){
      $left_content .=  "		',<br><br><br><br><b>Home</b>,page_gen.php?index,font-family:Times New Roman;font-size:100%;'\n";
      $left_content .=  "		,',<b>About</b>,page_gen.php?me,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,',<b>My Pictures</b>,,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Prem</b>,page_gen.php?prem,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Preeti</b>,page_gen.php?preeti,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Alisha</b>,page_gen.php?alisha,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Ashish</b>,page_gen.php?ashish,font-family::Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Other</b>,page_gen.php?other,font-family::Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,',<br><b>Resume</b>,page_gen.php?resume,font-family:Times New Roman;font-size:100%;'\n";
   }
   else{
      $left_content .=  "		',<br><br><br><br><b>Home</b>,index.html,font-family:Times New Roman;font-size:100%;'\n";
      //$left_content .=  "		,',<b>About</b>,me.html,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,',<b>About</b>,page_gen.php?me,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,',<b>My Pictures</b>,,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Prem</b>,prem.html,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Preeti</b>,preeti.html,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Alisha</b>,alisha.html,font-family:Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Ashish</b>,ashish.html,font-family::Times New Roman;font-size:125%;'\n";
      $left_content .=  "		,' ,<b>Other</b>,other_pics.html,font-family::Times New Roman;font-size:125%;'\n";
      //$left_content .=  "		,',<br><b>Resume</b>,resume_redirector.html,font-family:Times New Roman;font-size:100%;'\n";
      $left_content .=  "		,',<br><b>Resume</b>,page_gen.php?resume,font-family:Times New Roman;font-size:100%;'\n";
   }
   //$left_content .=  "		,',<b>Puzzles</b>,puzzles.html,font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>Puzzles</b>,page_gen.php?puzzles,font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>Feedback</b>,page_gen.php?id=bea4c2c8eb82d05891ddd71584881b56,font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',,,font-family:Times New Roman;font-size:125%;'\n";
   //$left_content .=  "		,',<b>Don\'t click here</b>,dont_click_here.html,font-family:Times New Roman;font-size:100%;color:ff0000'\n";
   //$left_content .=  "	,',Feedback,feedback.html,font-family:Times New Roman;font-size:100%;'\n";
   $left_content .=  "	);\n";
   $left_content .=  "\n";
   $left_content .=  "	print_menus_sub(top_menu_array,0,0,1);\n";
   $left_content .=  "\n";
   $left_content .=  "	print_menus_sub_external(bloglines_menu_array,0,0,1);\n";
   $left_content .=  "</script>\n";
}

function print_puzzles_left_content(&$left_content)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $left_content = "<script language=javascript>\n";
   $left_content .= "	var top_menu_array = Array(\n";
   if($development){
      $left_content .=  "		',<br><br><br><br><b>Personal</b>,page_gen.php?index,font-family:Times New Roman;font-size:125%;'\n";
   }
   else{
      $left_content .=  "		',<br><br><br><br><b>Personal</b>,index.html,font-family:Times New Roman;font-size:125%;'\n";
   }
   //$left_content .=  "		,',<b>Puzzles</b>,puzzles.html,font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>Home</b>,page_gen.php?puzzles,font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>Post question</b>,page_gen.php?add_puzzle_question,font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>Feedback</b>,page_gen.php?id=".FEEDBACK_BOARD_ID.",font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>Blog</b>,page_gen.php?id=".BLOG_BOARD_ID.",font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>Resources</b>,page_gen.php?id=".RESOURCE_BOARD_ID.",font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',<b>About</b>,page_gen.php?about_puzzles,font-family:Times New Roman;font-size:125%;'\n";
   $left_content .=  "		,',,,font-family:Times New Roman;font-size:125%;'\n";
   //$left_content .=  "		,',<b>Don\'t click here</b>,dont_click_here.html,font-family:Times New Roman;font-size:100%;color:ff0000'\n";
   //$left_content .=  "	,',Feedback,feedback.html,font-family:Times New Roman;font-size:100%;'\n";
   $left_content .=  "	);\n";
   $left_content .=  "\n";
   $left_content .=  "	print_menus_sub(top_menu_array,0,0,1);\n";
   $left_content .=  "\n";
   //$left_content .=  "	print_menus_sub_external(bloglines_menu_array,0,0,1);\n";
   $left_content .=  "</script>\n";
}

function print_standard_right_content(&$right_content)
{
   global $NO_OF_GOOGLE_ADS;
   for($i=1;$i<=$NO_OF_GOOGLE_ADS;++$i){
      //print_google_ads($right_content);
	print_realmedia_ads($right_content);
   }
}

function print_standard_left_right_content(&$left_content, &$right_content)
{
    print_standard_left_content($left_content);
    print_standard_right_content($right_content);
}

function print_puzzles_left_right_content(&$left_content, &$right_content)
{
    print_puzzles_left_content($left_content);
    print_standard_right_content($right_content);
}

function print_flickr_array_as_html(&$arr, $name, &$out_string)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $out_string .= "<a href=\"http://flickr.com/photos/premj/tags/".$name."/show/\">Slideshow(Flash required)</a><br/>";
   $count = 0;
   foreach ($arr as $photo_object)
   {
      ++$count;
      $photo_prepend = "http://static.flickr.com/".$photo_object->attributes['server']."/".$photo_object->attributes['id']."_".$photo_object->attributes['secret'];
      $thumbnail_photo = $photo_prepend."_t.jpg";
      //$small_photo = $photo_prepend."_s.jpg";
      //$large_photo = $photo_prepend."_b.jpg";
      $flickr_photo_page = "http://www.flickr.com/photos/premj/".$photo_object->attributes['id'];
      $str = "<a href=\"$flickr_photo_page\"><img src=\"$thumbnail_photo\"></a>";
      $out_string .= "$str";
      if(!($count%4)){$out_string .= "<br>";}
   }
}
function print_resume(&$middle_content)
{
global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
 $num_years_experience = (int)((time()/31536000)-(1997-1970));

/*$middle_content .= 'xmlns:o="urn:schemas-microsoft-com:office:office"
';$middle_content .= 'xmlns:w="urn:schemas-microsoft-com:office:word"
';$middle_content .= 'xmlns:st1="urn:schemas-microsoft-com:office:smarttags"
';$middle_content .= 'xmlns="http://www.w3.org/TR/REC-html40">
';*/
$middle_content .= '
';$middle_content .= '<head>
';$middle_content .= '<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
';$middle_content .= '<meta name=ProgId content=Word.Document>
';$middle_content .= '<meta name=Generator content="Microsoft Word 10">
';$middle_content .= '<meta name=Originator content="Microsoft Word 10">
';$middle_content .= '<link rel=File-List href="resume_files/filelist.xml">
';$middle_content .= '<title>Premchand Jayamohan</title>
';$middle_content .= '<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
';$middle_content .= ' name="PlaceType"/>
';$middle_content .= '<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
';$middle_content .= ' name="PlaceName"/>
';$middle_content .= '<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
';$middle_content .= ' name="country-region"/>
';$middle_content .= '<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
';$middle_content .= ' name="State"/>
';$middle_content .= '<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
';$middle_content .= ' name="City"/>
';$middle_content .= '<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
';$middle_content .= ' name="place"/>
';$middle_content .= '<!--[if gte mso 9]><xml>
';$middle_content .= ' <o:DocumentProperties>
';$middle_content .= '  <o:Author>Preferred Customer</o:Author>
';$middle_content .= '  <o:Template>Normal</o:Template>
';$middle_content .= '  <o:LastAuthor>prem</o:LastAuthor>
';$middle_content .= '  <o:Revision>2</o:Revision>
';$middle_content .= '  <o:TotalTime>3</o:TotalTime>
';$middle_content .= '  <o:Last$middle_content .=ed>2001-10-29T23:01:00Z</o:Last$middle_content .=ed>
';$middle_content .= '  <o:Created>2005-05-06T10:28:00Z</o:Created>
';$middle_content .= '  <o:LastSaved>2005-05-06T10:28:00Z</o:LastSaved>
';$middle_content .= '  <o:Pages>1</o:Pages>
';$middle_content .= '  <o:Words>1210</o:Words>
';$middle_content .= '  <o:Characters>6901</o:Characters>
';$middle_content .= '  <o:Company>God\'s Concentration Camp</o:Company>
';$middle_content .= '  <o:Lines>57</o:Lines>
';$middle_content .= '  <o:Paragraphs>16</o:Paragraphs>
';$middle_content .= '  <o:CharactersWithSpaces>8095</o:CharactersWithSpaces>
';$middle_content .= '  <o:Version>10.2625</o:Version>
';$middle_content .= ' </o:DocumentProperties>
';$middle_content .= '</xml><![endif]--><!--[if gte mso 9]><xml>
';$middle_content .= ' <w:WordDocument>
';$middle_content .= '  <w:SpellingState>Clean</w:SpellingState>
';$middle_content .= '  <w:GrammarState>Clean</w:GrammarState>
';$middle_content .= '  <w:DisplayHorizontalDrawingGridEvery>0</w:DisplayHorizontalDrawingGridEvery>
';$middle_content .= '  <w:DisplayVerticalDrawingGridEvery>0</w:DisplayVerticalDrawingGridEvery>
';$middle_content .= '  <w:UseMarginsForDrawingGridOrigin/>
';$middle_content .= '  <w:Compatibility>
';$middle_content .= '   <w:Use$middle_content .=erMetrics/>
';$middle_content .= '   <w:WW6BorderRules/>
';$middle_content .= '   <w:FootnoteLayoutLikeWW8/>
';$middle_content .= '   <w:ShapeLayoutLikeWW8/>
';$middle_content .= '   <w:AlignTablesRowByRow/>
';$middle_content .= '   <w:ForgetLastTabAlignment/>
';$middle_content .= '   <w:LayoutRawTableWidth/>
';$middle_content .= '   <w:LayoutTableRowsApart/>
';$middle_content .= '  </w:Compatibility>
';$middle_content .= '  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
';$middle_content .= ' </w:WordDocument>
';$middle_content .= '</xml><![endif]--><!--[if !mso]><object
';$middle_content .= ' classid="clsid:38481807-CA0E-42D2-BF39-B33AF135CC4D" id=ieooui></object>
';$middle_content .= '<style>
';$middle_content .= 'st1\:*{behavior:url(#ieooui) }
';$middle_content .= '</style>
';$middle_content .= '<![endif]-->
';$middle_content .= '<style>
';$middle_content .= '<!--
';$middle_content .= ' /* Font Definitions */
';$middle_content .= ' @font-face
';$middle_content .= '	{font-family:Times;
';$middle_content .= '	panose-1:2 2 6 3 5 4 5 2 3 4;
';$middle_content .= '	mso-font-charset:0;
';$middle_content .= '	mso-generic-font-family:roman;
';$middle_content .= '	mso-font-pitch:variable;
';$middle_content .= '	mso-font-signature:536902279 -2147483648 8 0 511 0;}
';$middle_content .= '@font-face
';$middle_content .= '	{font-family:"Americana BT";
';$middle_content .= '	mso-font-alt:"Bookman Old Style";
';$middle_content .= '	mso-font-charset:0;
';$middle_content .= '	mso-generic-font-family:auto;
';$middle_content .= '	mso-font-pitch:variable;
';$middle_content .= '	mso-font-signature:7 0 0 0 17 0;}
';$middle_content .= '@font-face
';$middle_content .= '	{font-family:Verdana;
';$middle_content .= '	panose-1:2 11 6 4 3 5 4 4 2 4;
';$middle_content .= '	mso-font-charset:0;
';$middle_content .= '	mso-generic-font-family:swiss;
';$middle_content .= '	mso-font-pitch:variable;
';$middle_content .= '	mso-font-signature:536871559 0 0 0 415 0;}
';$middle_content .= ' /* Style Definitions */
';$middle_content .= ' p.MsoNormal, li.MsoNormal, div.MsoNormal
';$middle_content .= '	{mso-style-parent:"";
';$middle_content .= '	margin:0in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	mso-fareast-font-family:"Times New Roman";}
';$middle_content .= 'h1
';$middle_content .= '	{mso-style-next:Normal;
';$middle_content .= '	margin-top:0in;
';$middle_content .= '	margin-right:0in;
';$middle_content .= '	margin-bottom:0in;
';$middle_content .= '	margin-left:1.5in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	page-break-after:avoid;
';$middle_content .= '	mso-outline-level:1;
';$middle_content .= '	font-size:12.0pt;
';$middle_content .= '	mso-bidi-font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	mso-font-kerning:0pt;
';$middle_content .= '	font-weight:normal;}
';$middle_content .= 'h2
';$middle_content .= '	{mso-style-next:Normal;
';$middle_content .= '	margin:0in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	page-break-after:avoid;
';$middle_content .= '	mso-outline-level:2;
';$middle_content .= '	tab-stops:-22.5pt 1.5in;
';$middle_content .= '	font-size:12.0pt;
';$middle_content .= '	mso-bidi-font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	font-weight:normal;}
';$middle_content .= 'h3
';$middle_content .= '	{mso-style-next:Normal;
';$middle_content .= '	margin:0in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	page-break-after:avoid;
';$middle_content .= '	mso-outline-level:3;
';$middle_content .= '	tab-stops:-22.5pt 0in;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:Arial;
';$middle_content .= '	mso-bidi-font-family:"Times New Roman";
';$middle_content .= '	font-weight:normal;
';$middle_content .= '	font-style:italic;
';$middle_content .= '	mso-bidi-font-style:normal;}
';$middle_content .= 'h4
';$middle_content .= '	{mso-style-next:Normal;
';$middle_content .= '	margin:0in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	page-break-after:avoid;
';$middle_content .= '	mso-outline-level:4;
';$middle_content .= '	tab-stops:-22.5pt 1.5in;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	mso-bidi-font-weight:normal;}
';$middle_content .= 'h5
';$middle_content .= '	{mso-style-next:Normal;
';$middle_content .= '	margin:0in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	text-indent:49.7pt;
';$middle_content .= '	mso-pagination:none;
';$middle_content .= '	page-break-after:avoid;
';$middle_content .= '	mso-outline-level:5;
';$middle_content .= '	tab-stops:1.25in;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";}
';$middle_content .= 'h6
';$middle_content .= '	{mso-style-next:Normal;
';$middle_content .= '	margin-top:0in;
';$middle_content .= '	margin-right:.1pt;
';$middle_content .= '	margin-bottom:0in;
';$middle_content .= '	margin-left:81.0pt;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	text-align:justify;
';$middle_content .= '	text-indent:4.5pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	page-break-after:avoid;
';$middle_content .= '	mso-outline-level:6;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	font-weight:normal;
';$middle_content .= '	font-style:italic;
';$middle_content .= '	mso-bidi-font-style:normal;}
';$middle_content .= 'p.MsoHeading7, li.MsoHeading7, div.MsoHeading7
';$middle_content .= '	{mso-style-next:Normal;
';$middle_content .= '	margin-top:0in;
';$middle_content .= '	margin-right:0in;
';$middle_content .= '	margin-bottom:0in;
';$middle_content .= '	margin-left:.5in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	text-indent:.5in;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	page-break-after:avoid;
';$middle_content .= '	mso-outline-level:7;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	mso-fareast-font-family:"Times New Roman";
';$middle_content .= '	font-style:italic;
';$middle_content .= '	mso-bidi-font-style:normal;}
';$middle_content .= 'p.MsoTitle, li.MsoTitle, div.MsoTitle
';$middle_content .= '	{margin:0in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	text-align:center;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	border:none;
';$middle_content .= '	mso-border-bottom-alt:solid windowtext 2.25pt;
';$middle_content .= '	padding:0in;
';$middle_content .= '	mso-padding-alt:0in 0in 1.0pt 0in;
';$middle_content .= '	font-size:18.0pt;
';$middle_content .= '	mso-bidi-font-size:10.0pt;
';$middle_content .= '	font-family:"Americana BT";
';$middle_content .= '	mso-fareast-font-family:"Times New Roman";
';$middle_content .= '	mso-bidi-font-family:"Times New Roman";
';$middle_content .= '	font-weight:bold;
';$middle_content .= '	mso-bidi-font-weight:normal;}
';$middle_content .= 'p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
';$middle_content .= '	{margin-top:0in;
';$middle_content .= '	margin-right:0in;
';$middle_content .= '	margin-bottom:6.0pt;
';$middle_content .= '	margin-left:0in;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	mso-fareast-font-family:"Times New Roman";}
';$middle_content .= 'p.MsoBodyTextIndent, li.MsoBodyTextIndent, div.MsoBodyTextIndent
';$middle_content .= '	{margin-top:0in;
';$middle_content .= '	margin-right:0in;
';$middle_content .= '	margin-bottom:0in;
';$middle_content .= '	margin-left:1.5in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	mso-fareast-font-family:"Times New Roman";}
';$middle_content .= 'p.MsoBodyTextIndent2, li.MsoBodyTextIndent2, div.MsoBodyTextIndent2
';$middle_content .= '	{margin-top:0in;
';$middle_content .= '	margin-right:0in;
';$middle_content .= '	margin-bottom:0in;
';$middle_content .= '	margin-left:13.5pt;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	text-indent:.5in;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	font-size:9.0pt;
';$middle_content .= '	mso-bidi-font-size:10.0pt;
';$middle_content .= '	font-family:Verdana;
';$middle_content .= '	mso-fareast-font-family:"Times New Roman";
';$middle_content .= '	mso-bidi-font-family:"Times New Roman";}
';$middle_content .= 'p.MsoBlockText, li.MsoBlockText, div.MsoBlockText
';$middle_content .= '	{margin-top:0in;
';$middle_content .= '	margin-right:.1pt;
';$middle_content .= '	margin-bottom:0in;
';$middle_content .= '	margin-left:49.5pt;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:none;
';$middle_content .= '	tab-stops:99.0pt 5.75in 6.15in 6.45in 499.5pt;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";
';$middle_content .= '	mso-fareast-font-family:"Times New Roman";}
';$middle_content .= 'a:link, span.MsoHyperlink
';$middle_content .= '	{color:blue;
';$middle_content .= '	text-decoration:underline;
';$middle_content .= '	text-underline:single;}
';$middle_content .= 'a:visited, span.MsoHyperlinkFollowed
';$middle_content .= '	{color:purple;
';$middle_content .= '	text-decoration:underline;
';$middle_content .= '	text-underline:single;}
';$middle_content .= 'pre
';$middle_content .= '	{margin:0in;
';$middle_content .= '	margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Courier New";
';$middle_content .= '	mso-fareast-font-family:"Courier New";
';$middle_content .= '	mso-bidi-font-family:"Times New Roman";}
';$middle_content .= 'span.SpellE
';$middle_content .= '	{mso-style-name:"";
';$middle_content .= '	mso-spl-e:yes;}
';$middle_content .= 'span.GramE
';$middle_content .= '	{mso-style-name:"";
';$middle_content .= '	mso-gram-e:yes;}
';$middle_content .= '@page Section1
';$middle_content .= '	{size:612.1pt 792.1pt;
';$middle_content .= '	margin:.25in .25in 36.7pt .25in;
';$middle_content .= '	mso-header-margin:.5in;
';$middle_content .= '	mso-footer-margin:.5in;
';$middle_content .= '	mso-paper-source:0;}
';$middle_content .= 'div.Section1
';$middle_content .= '	{page:Section1;}
';$middle_content .= ' /* List Definitions */
';$middle_content .= ' @list l0
';$middle_content .= '	{mso-list-id:1286080260;
';$middle_content .= '	mso-list-type:hybrid;
';$middle_content .= '	mso-list-template-ids:-1268758858 704686142 -513125184 -1421549812 -1951918622 -897814142 -22241504 754194286 1447350050 -83829544;}
';$middle_content .= '@list l0:level1
';$middle_content .= '	{mso-level-number-format:bullet;
';$middle_content .= '	mso-level-text:\F0B7;
';$middle_content .= '	mso-level-tab-stop:85.5pt;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	margin-left:85.5pt;
';$middle_content .= '	text-indent:-.25in;
';$middle_content .= '	font-family:Symbol;}
';$middle_content .= '@list l0:level2
';$middle_content .= '	{mso-level-tab-stop:1.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l0:level3
';$middle_content .= '	{mso-level-tab-stop:1.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l0:level4
';$middle_content .= '	{mso-level-tab-stop:2.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l0:level5
';$middle_content .= '	{mso-level-tab-stop:2.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l0:level6
';$middle_content .= '	{mso-level-tab-stop:3.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l0:level7
';$middle_content .= '	{mso-level-tab-stop:3.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l0:level8
';$middle_content .= '	{mso-level-tab-stop:4.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l0:level9
';$middle_content .= '	{mso-level-tab-stop:4.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l1
';$middle_content .= '	{mso-list-id:1459301712;
';$middle_content .= '	mso-list-type:hybrid;
';$middle_content .= '	mso-list-template-ids:620820914 868267934 -961098820 1676945054 -352405932 1623119342 -1302048814 -2090835546 -1877836960 -1950990522;}
';$middle_content .= '@list l1:level1
';$middle_content .= '	{mso-level-number-format:bullet;
';$middle_content .= '	mso-level-text:\F0B7;
';$middle_content .= '	mso-level-tab-stop:85.5pt;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	margin-left:85.5pt;
';$middle_content .= '	text-indent:-.25in;
';$middle_content .= '	font-family:Symbol;}
';$middle_content .= '@list l1:level2
';$middle_content .= '	{mso-level-number-format:bullet;
';$middle_content .= '	mso-level-text:o;
';$middle_content .= '	mso-level-tab-stop:121.5pt;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	margin-left:121.5pt;
';$middle_content .= '	text-indent:-.25in;
';$middle_content .= '	font-family:"Courier New";
';$middle_content .= '	mso-bidi-font-family:"Times New Roman";}
';$middle_content .= '@list l1:level3
';$middle_content .= '	{mso-level-tab-stop:1.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l1:level4
';$middle_content .= '	{mso-level-tab-stop:2.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l1:level5
';$middle_content .= '	{mso-level-tab-stop:2.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l1:level6
';$middle_content .= '	{mso-level-tab-stop:3.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l1:level7
';$middle_content .= '	{mso-level-tab-stop:3.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l1:level8
';$middle_content .= '	{mso-level-tab-stop:4.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l1:level9
';$middle_content .= '	{mso-level-tab-stop:4.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2
';$middle_content .= '	{mso-list-id:1846632368;
';$middle_content .= '	mso-list-type:hybrid;
';$middle_content .= '	mso-list-template-ids:1971249022 -1839826668 2033762470 634549836 -1430106846 -1857783472 -1850694796 1016349846 -1844927734 505175608;}
';$middle_content .= '@list l2:level1
';$middle_content .= '	{mso-level-number-format:bullet;
';$middle_content .= '	mso-level-text:\F0B7;
';$middle_content .= '	mso-level-tab-stop:85.5pt;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	margin-left:85.5pt;
';$middle_content .= '	text-indent:-.25in;
';$middle_content .= '	font-family:Symbol;}
';$middle_content .= '@list l2:level2
';$middle_content .= '	{mso-level-tab-stop:1.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2:level3
';$middle_content .= '	{mso-level-tab-stop:1.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2:level4
';$middle_content .= '	{mso-level-tab-stop:2.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2:level5
';$middle_content .= '	{mso-level-tab-stop:2.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2:level6
';$middle_content .= '	{mso-level-tab-stop:3.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2:level7
';$middle_content .= '	{mso-level-tab-stop:3.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2:level8
';$middle_content .= '	{mso-level-tab-stop:4.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l2:level9
';$middle_content .= '	{mso-level-tab-stop:4.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l3
';$middle_content .= '	{mso-list-id:1893154341;
';$middle_content .= '	mso-list-type:hybrid;
';$middle_content .= '	mso-list-template-ids:620820914 -178498186 430861910 1818006050 -1891705648 -1265587494 -294599946 145889774 735985802 2019580288;}
';$middle_content .= '@list l3:level1
';$middle_content .= '	{mso-level-number-format:bullet;
';$middle_content .= '	mso-level-text:o;
';$middle_content .= '	mso-level-tab-stop:103.5pt;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	margin-left:103.5pt;
';$middle_content .= '	text-indent:-.25in;
';$middle_content .= '	font-family:"Courier New";
';$middle_content .= '	mso-bidi-font-family:"Times New Roman";}
';$middle_content .= '@list l3:level2
';$middle_content .= '	{mso-level-number-format:bullet;
';$middle_content .= '	mso-level-text:\F0B7;
';$middle_content .= '	mso-level-tab-stop:139.5pt;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	margin-left:139.5pt;
';$middle_content .= '	text-indent:-.25in;
';$middle_content .= '	font-family:Symbol;}
';$middle_content .= '@list l3:level3
';$middle_content .= '	{mso-level-tab-stop:1.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l3:level4
';$middle_content .= '	{mso-level-tab-stop:2.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l3:level5
';$middle_content .= '	{mso-level-tab-stop:2.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l3:level6
';$middle_content .= '	{mso-level-tab-stop:3.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l3:level7
';$middle_content .= '	{mso-level-tab-stop:3.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l3:level8
';$middle_content .= '	{mso-level-tab-stop:4.0in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= '@list l3:level9
';$middle_content .= '	{mso-level-tab-stop:4.5in;
';$middle_content .= '	mso-level-number-position:left;
';$middle_content .= '	text-indent:-.25in;}
';$middle_content .= 'ol
';$middle_content .= '	{margin-bottom:0in;}
';$middle_content .= 'ul
';$middle_content .= '	{margin-bottom:0in;}
';$middle_content .= '-->
';$middle_content .= '</style>
';$middle_content .= '<!--[if gte mso 10]>
';$middle_content .= '<style>
';$middle_content .= ' /* Style Definitions */
';$middle_content .= ' table.MsoNormalTable
';$middle_content .= '	{mso-style-name:"Table Normal";
';$middle_content .= '	mso-tstyle-rowband-size:0;
';$middle_content .= '	mso-tstyle-colband-size:0;
';$middle_content .= '	mso-style-noshow:yes;
';$middle_content .= '	mso-style-parent:"";
';$middle_content .= '	mso-padding-alt:0in 5.4pt 0in 5.4pt;
';$middle_content .= '	mso-para-margin:0in;
';$middle_content .= '	mso-para-margin-bottom:.0001pt;
';$middle_content .= '	mso-pagination:widow-orphan;
';$middle_content .= '	font-size:10.0pt;
';$middle_content .= '	font-family:"Times New Roman";}
';$middle_content .= '</style>
';$middle_content .= '<![endif]--><!--[if gte mso 9]><xml>
';$middle_content .= ' <o:shapedefaults v:ext="edit" spidmax="3074"/>
';$middle_content .= '</xml><![endif]--><!--[if gte mso 9]><xml>
';$middle_content .= ' <o:shapelayout v:ext="edit">
';$middle_content .= '  <o:idmap v:ext="edit" data="1"/>
';$middle_content .= ' </o:shapelayout></xml><![endif]-->
';$middle_content .= '</head>
';$middle_content .= '
';$middle_content .= '<body lang=EN-US link=blue vlink=purple style=\'tab-interval:.5in\'>
';$middle_content .= '
';$middle_content .= '<div class=Section1>
';$middle_content .= '
';$middle_content .= '<div style=\'border:none;border-bottom:solid windowtext 2.25pt;padding:0in 0in 1.0pt 0in\'>
';$middle_content .= '
';$middle_content .= '<p class=MsoTitle style=\'tab-stops:495.0pt 499.5pt\'><span class=SpellE><span
';$middle_content .= 'style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Times New Roman"\'>Premchand</span></span><span
';$middle_content .= 'style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Times New Roman"\'>
';$middle_content .= '<span class=SpellE>Jayamohan</span><o:p></o:p></span></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal align=center style=\'text-align:center;border:none;
';$middle_content .= 'mso-border-bottom-alt:solid windowtext 2.25pt;padding:0in;mso-padding-alt:0in 0in 1.0pt 0in\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><a
';$middle_content .= 'href="mailto:".$prem_email."?subject=Re:%20Resume"><span
';$middle_content .= 'class=SpellE><span class=GramE>prem</span></span> at <span class=SpellE>clarksonalumni</span>
';$middle_content .= 'dot com<o:p></o:p></a></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal align=center style=\'text-align:center;border:none;
';$middle_content .= 'mso-border-bottom-alt:solid windowtext 2.25pt;padding:0in;mso-padding-alt:0in 0in 1.0pt 0in\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'>http://premchandj.tripod.com<o:p></o:p></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'border:none;mso-border-bottom-alt:solid windowtext 2.25pt;
';$middle_content .= 'padding:0in;mso-padding-alt:0in 0in 1.0pt 0in\'><i style=\'mso-bidi-font-style:
';$middle_content .= 'normal\'><span style=\'font-family:Arial;mso-bidi-font-family:"Times New Roman"\'><o:p>&nbsp;</o:p></span></i></p>
';$middle_content .= '
';$middle_content .= '</div>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:178.35pt;text-indent:-106.35pt;
';$middle_content .= 'tab-stops:76.5pt\'><span style=\'font-family:Arial;mso-bidi-font-family:"Times New Roman"\'><o:p>&nbsp;</o:p></span></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:81.1pt;margin-bottom:
';$middle_content .= '0in;margin-left:117.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:
';$middle_content .= '-67.5pt;tab-stops:81.0pt 103.5pt 117.0pt 130.5pt 463.5pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>OBJECTIVE</b>:</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:81.1pt;margin-bottom:
';$middle_content .= '0in;margin-left:117.0pt;margin-bottom:.0001pt;text-align:justify;tab-stops:
';$middle_content .= '81.0pt 103.5pt 117.0pt 130.5pt 463.5pt\'>To be a part of an ambitious and
';$middle_content .= 'fast-growing company, which can utilize a highly motivated, and goal oriented
';$middle_content .= 'Individual <span class=GramE>With</span> dynamic problem solving, technical
';$middle_content .= 'leadership and charismatic people skills.<o:p></o:p></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:106.35pt;text-align:justify;text-indent:
';$middle_content .= '-56.85pt;tab-stops:106.35pt\'><b style=\'mso-bidi-font-weight:normal\'>SUMMARY</b>:</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:117.0pt;tab-stops:45.0pt 51.75pt 94.5pt 2.0in 193.5pt\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>'.$num_years_experience.'+ years of professional experience in software
';$middle_content .= 'development</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:117.0pt;tab-stops:45.0pt 51.75pt 94.5pt 2.0in 193.5pt\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>Extensive experience in object oriented design
';$middle_content .= '&amp; development</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:117.0pt;tab-stops:45.0pt 51.75pt 94.5pt 2.0in 193.5pt\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>Have good experience leading development teams</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.0pt;tab-stops:45.0pt 51.75pt 94.5pt 2.0in 193.5pt\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>Has lots of energy, a clear sense of urgency
';$middle_content .= 'and direction</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.35pt;tab-stops:1.75in 2.0in\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>Highly focused on doing everything simpler and
';$middle_content .= 'faster</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.35pt;tab-stops:1.75in 2.0in 402.75pt\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>Pursue stretch goals to drive aggressive growth</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.35pt;tab-stops:1.75in 2.0in\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>Demands aggressive personal growth and sets
';$middle_content .= 'challenging performance standards</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.35pt;tab-stops:1.75in 2.0in\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'font-family:Times;mso-bidi-font-family:
';$middle_content .= '"Times New Roman"\'></span></i>A result oriented team player</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:49.5pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>EDUCATION</b>:<b style=\'mso-bidi-font-weight:normal\'><span
';$middle_content .= 'style=\'font-size:11.0pt;mso-bidi-font-size:10.0pt\'><span style=\'mso-tab-count:
';$middle_content .= '1\'> </span><o:p></o:p></span></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:58.5pt;text-indent:58.5pt\'><st1:place><st1:PlaceName><b
';$middle_content .= '  style=\'mso-bidi-font-weight:normal\'>Clarkson</b></st1:PlaceName><b
';$middle_content .= ' style=\'mso-bidi-font-weight:normal\'> </b><st1:PlaceType><b style=\'mso-bidi-font-weight:
';$middle_content .= '  normal\'>University</b></st1:PlaceType></st1:place><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'> </b>(<st1:place><st1:City>Potsdam</st1:City>, <st1:State>NY</st1:State></st1:place>;
';$middle_content .= '8/95 to 5/97)</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.0pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>M.S</b> in Electrical Engineering</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal><o:p>&nbsp;</o:p></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:1.0in;text-indent:45.0pt\'><st1:place><st1:PlaceName><b
';$middle_content .= '  style=\'mso-bidi-font-weight:normal\'>PSG</b></st1:PlaceName><b
';$middle_content .= ' style=\'mso-bidi-font-weight:normal\'> </b><st1:PlaceType><b style=\'mso-bidi-font-weight:
';$middle_content .= '  normal\'>College</b></st1:PlaceType></st1:place><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'> of Technology </b>(<st1:place><st1:City><span class=SpellE>Coimbatore</span></st1:City>,
';$middle_content .= ' <st1:country-region>India</st1:country-region></st1:place>; 8/91 to 5/95)</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.0pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>B.S</b> in Electrical and Electronics Engineering</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.35pt;tab-stops:1.75in 2.0in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'><o:p>&nbsp;</o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:49.5pt;text-align:justify\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>COMPUTER SKILLS</b>:</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l2 level1 lfo2;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>C, C++, Win32 SDK, Java, Perl, Pascal, Fortran,
';$middle_content .= 'COBOL, Assembly (8086/88, 8085, Z80), Sockets</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l2 level1 lfo2;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Visual C++, MFC, COM/DCOM, ATL, XML, STL, UML,
';$middle_content .= 'Rational Rose, Visual Basic, ODBC, HTML, JavaScript</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l2 level1 lfo2;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>ATM, TCP/IP, Ethernet, <span class=SpellE>xDSL</span>,
';$middle_content .= '<span class=SpellE>VoATM</span>, SNMP, WBEM, CIMOM</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l2 level1 lfo2;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Windows NT/2000, Linux, UNIX, FreeBSD</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l2 level1 lfo2;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Access, Oracle 7.2, SQL, FoxPro, <span
';$middle_content .= 'class=SpellE>BoundsChecker</span>, <span class=SpellE>Clearcase</span>, <span
';$middle_content .= 'class=SpellE>Continuus</span>, CVS, Doors</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l2 level1 lfo2;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Carrier networking equipment from vendors
';$middle_content .= 'including Marconi, Cisco, Nortel, Lucent, Accelerated, </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-align:justify;text-indent:
';$middle_content .= '4.5pt\'><span class=SpellE>Jetstream</span>, <span class=SpellE>Redback</span>,
';$middle_content .= 'Turnstone, Alcatel, and <span class=SpellE>Newbridge</span></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'><o:p>&nbsp;</o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify;text-indent:49.5pt;mso-pagination:
';$middle_content .= 'none;tab-stops:1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>WORK EXPERIENCE</b>:</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:13.5pt;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>Technical Lead, Yahoo! Software Development
';$middle_content .= 'India Pvt Ltd </b>(<st1:place><st1:City>Bangalore</st1:City>, <st1:country-region>India</st1:country-region></st1:place>;
';$middle_content .= '9/03 to present)</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Currently working as a Technical Lead in the
';$middle_content .= 'Market Innovation Group, which is the wing of Yahoo! </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt\'><span style=\'mso-tab-count:1\'>  </span><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>      </span><span class=GramE>involved</span> in
';$middle_content .= 'rapid prototyping of new market ideas. This involved activities anywhere from understanding
';$middle_content .= '</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt\'><span style=\'mso-tab-count:1\'>  </span><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>      </span><span class=GramE>market</span> &amp;
';$middle_content .= 'user needs to leading the entire engineering efforts involved to getting a
';$middle_content .= 'working prototype up and </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt\'><span style=\'mso-tab-count:1\'>  </span><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>      </span><span class=GramE>running</span> for
';$middle_content .= 'market testing.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Actively involved, in a leadership role, in
';$middle_content .= 'transitioning developmental projects from Yahoo! USA to </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:49.5pt;text-indent:.5in\'>Yahoo! India.
';$middle_content .= 'This involved knowledge transfer between the teams in either countries, and
';$middle_content .= 'interaction </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt\'><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>        </span><span class=GramE>with</span> producers
';$middle_content .= 'in the <st1:country-region><st1:place>USA</st1:place></st1:country-region>, to
';$middle_content .= 'successfully take full ownership of live production systems.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Extensively involved in the design and
';$middle_content .= 'development of Yahoo! Data Warehouse/Tools and Internal </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>Reporting <span style=\'mso-spacerun:yes\'> </span>Products</span>. Involved
';$middle_content .= 'in development of parallelized architecture for processing and loading </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>data</span> logs into Yahoo! Warehouse.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Developed processes to aggregate the data in the
';$middle_content .= 'warehouse for business critical reports.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Efficiently managed the coordination of
';$middle_content .= 'development activities between different functional groups.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Involved in screening and interviewing potential
';$middle_content .= 'candidates.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:.5in;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>LANGUAGES, <span class=GramE>PLATFORMS ,</span>
';$middle_content .= 'TOOLS &amp; TECHNOLOGIES: <o:p></o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify;text-indent:49.5pt;mso-pagination:
';$middle_content .= 'none;tab-stops:1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>          </span><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>    </span>C++, FreeBSD, Perl, STL<span class=GramE>,UML</span>,
';$middle_content .= 'CVS, HTML, JavaScript</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify;text-indent:49.5pt;mso-pagination:
';$middle_content .= 'none;tab-stops:1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><o:p>&nbsp;</o:p></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:13.5pt;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>Senior Software Engineer, Union Switch
';$middle_content .= '&amp; Signal </b>(<st1:place><st1:City>Pittsburgh</st1:City>, <st1:State>PA</st1:State>,
';$middle_content .= ' <st1:country-region>USA</st1:country-region></st1:place>; 1/02 to 6/03)</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Conducted R&amp;D of the Optimized Traffic
';$middle_content .= 'Planner (OTP). OTP is a planning component of the US&amp;S </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt\'><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>        </span>Computer <span class=GramE>Aided<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>Dispatching</span> (CAD) system. OTP uses
';$middle_content .= 'sophisticated AI techniques to optimize real-time </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt\'><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>        </span><span class=GramE>train</span> traffic
';$middle_content .= 'inside extensive railroad networks</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Was extensively involved in the design of the
';$middle_content .= 'new product, after the prototype functionality was proved</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Was actively involved in requirements gathering
';$middle_content .= 'for OTP. It involved creation of scope documents, prioritizing </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>requirements</span>, peer reviews, coming up with software requirements
';$middle_content .= 'specifications<span style=\'mso-spacerun:yes\'>  </span>&amp; requirement
';$middle_content .= 'validation.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Led a team of four developers in implementing
';$middle_content .= 'the dispatcher module for the OTP. Responsibilities included </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>coordinating<span style=\'mso-spacerun:yes\'>  </span>team</span>
';$middle_content .= 'tasks, interaction with other teams, coming up with time estimates and tracking
';$middle_content .= 'and reporting </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>of</span> project status.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Evaluated constraint satisfaction approach to
';$middle_content .= 'the optimized traffic planning</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Developed the OTP test framework</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Designed and implemented OTP movement model and
';$middle_content .= 'speed restriction profile libraries</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Researched improvements for the OTP agent and
';$middle_content .= 'dispatcher components<b style=\'mso-bidi-font-weight:normal\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><o:p></o:p></i></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Analyzed OTP code and designed the
';$middle_content .= 'transformation from static to dynamic and real-time planning </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Actively involved in demonstrating the product
';$middle_content .= 'to potential customers for both static and dynamic planning.</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:.5in;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>LANGUAGES, <span class=GramE>PLATFORMS ,</span>
';$middle_content .= 'TOOLS &amp; TECHNOLOGIES: <o:p></o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoHeading7><span style=\'mso-spacerun:yes\'>    </span>C++, Linux,
';$middle_content .= 'Perl, STL<span class=GramE>,UML</span>, Rational Rose, <span class=SpellE>Clearcase</span>,
';$middle_content .= 'CVS,<span style=\'mso-spacerun:yes\'>  </span>Doors, GDB</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify;text-indent:49.5pt;mso-pagination:
';$middle_content .= 'none;tab-stops:1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><o:p>&nbsp;</o:p></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:13.5pt;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>Software Development Engineer, <span
';$middle_content .= 'class=SpellE>CoManage</span> Corporation </b>(<st1:place><st1:City>Wexford</st1:City>,
';$middle_content .= ' <st1:State>PA</st1:State>, <st1:country-region>USA</st1:country-region></st1:place>;
';$middle_content .= '5/00 to 12/01)</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Implemented NEM (Network Element Model)
';$middle_content .= 'support<span style=\'mso-spacerun:yes\'>  </span>in the Integrated Service
';$middle_content .= 'manager (ISM) product for</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:103.5pt;text-indent:-.25in;mso-list:l3 level1 lfo6;
';$middle_content .= 'tab-stops:list 103.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Cisco 7200 VXR</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:103.5pt;text-indent:-.25in;mso-list:l3 level1 lfo6;
';$middle_content .= 'tab-stops:list 103.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Lucent PSAX 2300</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Technically responsible for all aspects of NEM
';$middle_content .= 'development, including</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:121.5pt;text-indent:-.25in;mso-list:l1 level2 lfo4;
';$middle_content .= 'tab-stops:list 121.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>NEM Architecture and development environment</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:121.5pt;text-indent:-.25in;mso-list:l1 level2 lfo4;
';$middle_content .= 'tab-stops:list 121.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Updated the WBEM infrastructure for the devices,
';$middle_content .= 'including MOF files to define CIM elements, to</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:117.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'style=\'mso-spacerun:yes\'> </span><span class=GramE>integrate</span> into ISM</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:121.5pt;text-indent:-.25in;mso-list:l1 level2 lfo4;
';$middle_content .= 'tab-stops:list 121.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Management of interactions with other
';$middle_content .= 'development teams</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:121.5pt;text-indent:-.25in;mso-list:l1 level2 lfo4;
';$middle_content .= 'tab-stops:list 121.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Tracking and reporting of project status</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:121.5pt;text-indent:-.25in;mso-list:l1 level2 lfo4;
';$middle_content .= 'tab-stops:list 121.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Oversight and participation in requirements,
';$middle_content .= 'design, and code reviews</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:121.5pt;text-indent:-.25in;mso-list:l1 level2 lfo4;
';$middle_content .= 'tab-stops:list 121.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Developed NEM design templates and implementation
';$middle_content .= 'guides</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:121.5pt;text-indent:-.25in;mso-list:l1 level2 lfo4;
';$middle_content .= 'tab-stops:list 121.5pt\'><![if !supportLists]><span style=\'font-family:"Courier New";
';$middle_content .= 'mso-fareast-font-family:"Courier New"\'><span style=\'mso-list:Ignore\'>o<span
';$middle_content .= 'style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Leveraged vendor, customer, and partner
';$middle_content .= 'relationships to gain deeper understanding of networking </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:117.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>equipment</span> and the network management marketplace</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Added support for multiple device mediation
';$middle_content .= 'protocols to ISM</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Technical mentor for four incoming development
';$middle_content .= 'engineers</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Developed and executed end-to-end testing
';$middle_content .= 'procedures for ISM</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Made various improvements to the core of the ISM
';$middle_content .= 'product<b style=\'mso-bidi-font-weight:normal\'><i style=\'mso-bidi-font-style:
';$middle_content .= 'normal\'><o:p></o:p></i></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-indent:-.25in;mso-list:l1 level1 lfo4;
';$middle_content .= 'tab-stops:list 85.5pt\'><![if !supportLists]><span style=\'font-family:Symbol;
';$middle_content .= 'mso-fareast-font-family:Symbol;mso-bidi-font-family:Symbol\'><span
';$middle_content .= 'style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Active member<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>of<span style=\'mso-spacerun:yes\'>  </span>the<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>recruiting<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>board,<span style=\'mso-spacerun:yes\'>  </span>responsible<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>for screening candidates and was heavily
';$middle_content .= 'involved <b style=\'mso-bidi-font-weight:normal\'><i style=\'mso-bidi-font-style:
';$middle_content .= 'normal\'><o:p></o:p></i></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>in</span> interviewing prospective candidates</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:.5in;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>LANGUAGES, <span class=GramE>PLATFORMS ,</span>
';$middle_content .= 'TOOLS &amp; TECHNOLOGIES: <o:p></o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoHeading7 style=\'margin-left:81.75pt;text-indent:0in\'><span
';$middle_content .= 'class=GramE>Visual<span style=\'mso-spacerun:yes\'>  </span>C</span>++, Windows
';$middle_content .= 'NT/ 95/2000,<span style=\'mso-spacerun:yes\'>  </span>ATM, Java, <span
';$middle_content .= 'class=SpellE>VoATM</span>, SNMP, WBEM, CIMOM, ATL, COM, STL SQL Server,</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoHeading7><span style=\'mso-spacerun:yes\'>   </span><span
';$middle_content .= 'style=\'mso-spacerun:yes\'> </span><span class=SpellE>BoundsChecker</span>, XML,
';$middle_content .= 'UML, <span class=SpellE>Continuus</span></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify;text-indent:49.5pt\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'><i style=\'mso-bidi-font-style:normal\'><o:p>&nbsp;</o:p></i></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:13.5pt;text-align:justify;text-indent:
';$middle_content .= '.5in\'><b style=\'mso-bidi-font-weight:normal\'><i style=\'mso-bidi-font-style:
';$middle_content .= 'normal\'>Software Architect, Team Systems</i></b><i style=\'mso-bidi-font-style:
';$middle_content .= 'normal\'> (</i><st1:place><st1:City><i style=\'mso-bidi-font-style:normal\'>Pittsburgh</i></st1:City><i
';$middle_content .= ' style=\'mso-bidi-font-style:normal\'>, </i><st1:State><i style=\'mso-bidi-font-style:
';$middle_content .= '  normal\'>PA</i></st1:State><i style=\'mso-bidi-font-style:normal\'>, </i><st1:country-region><i
';$middle_content .= '  style=\'mso-bidi-font-style:normal\'>USA</i></st1:country-region></st1:place><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'>; 6/97 to 4/00)<o:p></o:p></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Designed<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>and<span style=\'mso-spacerun:yes\'>  </span>implemented<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>95/NT-based<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>suite<span style=\'mso-spacerun:yes\'>  </span>of<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>equity<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>modeling<span style=\'mso-spacerun:yes\'>  </span>and<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>research<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>tools<i style=\'mso-bidi-font-style:normal\'><o:p></o:p></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Utilized<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>advanced<span style=\'mso-spacerun:yes\'>  </span>Win32<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>techniques ,<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>including<span style=\'mso-spacerun:yes\'>   </span>security,<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>threads<span style=\'mso-spacerun:yes\'>
';$middle_content .= '</span>and<span style=\'mso-spacerun:yes\'>  </span>synchronization, and IPC
';$middle_content .= '(shared<i style=\'mso-bidi-font-style:normal\'><o:p></o:p></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:81.0pt;text-align:justify;text-indent:
';$middle_content .= '4.5pt\'><span class=GramE>memory</span>,<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>named<span style=\'mso-spacerun:yes\'>   </span>pipes, <span
';$middle_content .= 'style=\'mso-spacerun:yes\'> </span>sockets)<i style=\'mso-bidi-font-style:normal\'><o:p></o:p></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Implemented<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>both<span style=\'mso-spacerun:yes\'>  </span>standalone<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>as<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>well<span style=\'mso-spacerun:yes\'>  </span>as client-server<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>versions<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>in<span style=\'mso-spacerun:yes\'>  </span>a<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>single<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>code<span style=\'mso-spacerun:yes\'>  </span>base<i style=\'mso-bidi-font-style:
';$middle_content .= 'normal\'><o:p></o:p></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Developed an<span style=\'mso-spacerun:yes\'>  
';$middle_content .= '</span>OO library employed<span style=\'mso-spacerun:yes\'>  </span>by<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>all<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>of<span style=\'mso-spacerun:yes\'>  </span>the<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>firm\'s<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>applications, resulting<span style=\'mso-spacerun:yes\'>  </span>in nearly
';$middle_content .= '80% LOC reuse<i style=\'mso-bidi-font-style:normal\'><o:p></o:p></i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:85.5pt;margin-bottom:.0001pt;text-align:justify;text-indent:-.25in;
';$middle_content .= 'mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Researched<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>and<span style=\'mso-spacerun:yes\'>  </span>implemented<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>an<span style=\'mso-spacerun:yes\'>  </span>in
';$middle_content .= '-house<span style=\'mso-spacerun:yes\'>  </span>database,<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>which<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>had significant performance, advantages over</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:81.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>other<span style=\'mso-spacerun:yes\'>  </span>commercially</span><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>available<span style=\'mso-spacerun:yes\'>
';$middle_content .= '</span>database packages. This served as the core database on which the entire</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:81.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>software</span> was based</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:85.5pt;margin-bottom:.0001pt;text-align:justify;text-indent:-.25in;
';$middle_content .= 'mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Managed<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>technical<span style=\'mso-spacerun:yes\'>  </span>staff, including
';$middle_content .= 'recruiting, defining<span style=\'mso-spacerun:yes\'>   </span>tasks,
';$middle_content .= 'scheduling,<span style=\'mso-spacerun:yes\'>  </span>and motivating team members</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:85.5pt;margin-bottom:.0001pt;text-align:justify;text-indent:-.25in;
';$middle_content .= 'mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Trained<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>new employees, customers, and<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>sales staff in the design, use and benefits of the product</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:85.5pt;margin-bottom:.0001pt;text-align:justify;text-indent:-.25in;
';$middle_content .= 'mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Collaborated with marketing on product
';$middle_content .= 'management, including market analysis, feature set, look and feel,</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:81.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>pricing</span>, and development of<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>marketing<span style=\'mso-spacerun:yes\'>   </span>materials</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:85.5pt;margin-bottom:.0001pt;text-align:justify;text-indent:-.25in;
';$middle_content .= 'mso-list:l0 level1 lfo8;tab-stops:list 85.5pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Presented the product to prospects and serviced
';$middle_content .= 'existing customers. Two large organizations<span style=\'mso-spacerun:yes\'>
';$middle_content .= '</span>(approached</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-top:0in;margin-right:.1pt;margin-bottom:0in;
';$middle_content .= 'margin-left:81.0pt;margin-bottom:.0001pt;text-align:justify;text-indent:4.5pt\'><span
';$middle_content .= 'class=GramE>as</span> potential<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>clients)<span style=\'mso-spacerun:yes\'>  </span>were<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>so impressed<span style=\'mso-spacerun:yes\'>
';$middle_content .= '</span>with<span style=\'mso-spacerun:yes\'>  </span>products that they offered
';$middle_content .= 'to buy the company</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:.5in;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>LANGUAGES, <span class=GramE>PLATFORMS ,</span>
';$middle_content .= 'TOOLS &amp; TECHNOLOGIES: <o:p></o:p></b></p>
';$middle_content .= '
';$middle_content .= '<h6><span style=\'mso-spacerun:yes\'> </span><span class=GramE>Visual<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>C</span>++, Windows NT, Windows 95, MFC,
';$middle_content .= 'ODBC,SQL, Access<span style=\'font-style:normal\'>, </span><span
';$middle_content .= 'style=\'mso-spacerun:yes\'> </span>HTML, <span class=SpellE>Codebase</span>,
';$middle_content .= 'Pervasive</h6>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:49.7pt;mso-pagination:none;tab-stops:
';$middle_content .= '1.25in\'><o:p>&nbsp;</o:p></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify;text-indent:49.5pt;mso-pagination:
';$middle_content .= 'none;tab-stops:1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>Software Developer, CAISE, </b><st1:place><st1:PlaceName><b
';$middle_content .= '  style=\'mso-bidi-font-weight:normal\'>Clarkson</b></st1:PlaceName><b
';$middle_content .= ' style=\'mso-bidi-font-weight:normal\'> </b><st1:PlaceType><b style=\'mso-bidi-font-weight:
';$middle_content .= '  normal\'>University</b></st1:PlaceType></st1:place> (<st1:place><st1:City>Potsdam</st1:City>,
';$middle_content .= ' <st1:State>NY</st1:State>, <st1:country-region>USA</st1:country-region></st1:place>;
';$middle_content .= '8/95 to 5/97)</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-pagination:none;mso-list:l0 level1 lfo8;tab-stops:list 85.5pt left 1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Designed<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>and<span style=\'mso-spacerun:yes\'>  </span>developed a suite<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>of<span style=\'mso-spacerun:yes\'>
';$middle_content .= '</span>tools for the interactive simulation and analysis of various engineering
';$middle_content .= '</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt;text-align:justify;mso-pagination:
';$middle_content .= 'none;tab-stops:1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>        </span><span class=GramE>problems</span> used
';$middle_content .= 'to aid students in undergraduate courses </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-pagination:none;mso-list:l0 level1 lfo8;tab-stops:list 85.5pt left 1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Lead a team of six programmers thru the entire
';$middle_content .= 'software development cycle</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:85.5pt;text-align:justify;text-indent:
';$middle_content .= '-.25in;mso-pagination:none;mso-list:l0 level1 lfo8;tab-stops:list 85.5pt left 1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><![if !supportLists]><span
';$middle_content .= 'style=\'font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:
';$middle_content .= 'Symbol\'><span style=\'mso-list:Ignore\'>·<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';$middle_content .= '</span></span></span><![endif]>Developed<span style=\'mso-spacerun:yes\'>  
';$middle_content .= '</span>tools<span style=\'mso-spacerun:yes\'>  </span>for<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>   </span>Computational<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>( Numeric &amp; Symbolic )<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>simulation<span style=\'mso-spacerun:yes\'> 
';$middle_content .= '</span>activities<span style=\'mso-spacerun:yes\'>  </span>involved<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>in<span style=\'mso-spacerun:yes\'>  </span>the<span
';$middle_content .= 'style=\'mso-spacerun:yes\'>  </span>stress </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:67.5pt;text-align:justify;mso-pagination:
';$middle_content .= 'none;tab-stops:1.25in 121.5pt 1.75in 166.5pt 171.0pt\'><span
';$middle_content .= 'style=\'mso-spacerun:yes\'>        </span><span class=GramE>analysis</span>
';$middle_content .= 'of<span style=\'mso-spacerun:yes\'>  </span>beams and electric circuits</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:.5in;text-indent:.5in\'><b
';$middle_content .= 'style=\'mso-bidi-font-weight:normal\'>LANGUAGES, <span class=GramE>PLATFORMS ,</span>
';$middle_content .= 'TOOLS &amp; TECHNOLOGIES: <o:p></o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-align:justify;mso-pagination:none;tab-stops:
';$middle_content .= '85.5pt 121.5pt 1.75in 166.5pt 171.0pt\'><b style=\'mso-bidi-font-weight:normal\'><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'mso-tab-count:1\'>                                      </span></i></b><i
';$middle_content .= 'style=\'mso-bidi-font-style:normal\'><span style=\'mso-spacerun:yes\'> </span><span
';$middle_content .= 'class=GramE>Visual<span style=\'mso-spacerun:yes\'>  </span>C</span>++, Windows
';$middle_content .= 'NT, Windows 95, MFC, Maple IV</i></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal><b style=\'mso-bidi-font-weight:normal\'><o:p>&nbsp;</o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:49.5pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>MERIT AWARDS &amp; ACTIVITIES:<o:p></o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:1.0in;text-indent:.5in\'> Was a member of
';$middle_content .= 'the team that won <b style=\'mso-bidi-font-weight:normal\'>IEEE Vincent <span
';$middle_content .= 'class=SpellE>Bendix</span> <span class=GramE>Award<span style=\'font-weight:
';$middle_content .= 'normal\'><span style=\'mso-spacerun:yes\'>  </span>for</span></span></b> the best
';$middle_content .= 'project for the </p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:117.0pt\'><span class=GramE>year</span>
';$middle_content .= '1993-94</p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'margin-left:1.0in;text-indent:.5in\'> Undergraduate
';$middle_content .= 'class representative for the year<b style=\'mso-bidi-font-weight:normal\'>
';$middle_content .= '1993-94</b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'text-indent:49.5pt\'><b style=\'mso-bidi-font-weight:
';$middle_content .= 'normal\'>REFERENCES<o:p></o:p></b></p>
';$middle_content .= '
';$middle_content .= '<p class=MsoNormal style=\'tab-stops:-22.5pt 1.5in\'><span style=\'mso-tab-count:
';$middle_content .= '1\'>                                                </span>Available upon
';$middle_content .= 'request</p>
';$middle_content .= '
';$middle_content .= '</div>
';$middle_content .= '
';$middle_content .= '</body>
';$middle_content .= '
';
}

function form_helper_function($user, &$name, &$middle_content, &$HTTP_GET_VARS1, $display_heading=true, $display_title=true, $display_tags=true, $display_comment=true, $display_submit_button=true, $display_login=true, $next_url="xxxx", $show_div=false)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;
   $heading1 = ($name==PUZZLE_QUESTION_POST_FORM_NAME)? "Post Question:":(($name==PUZZLE_REPLY_FORM_NAME)? "Answer:":TESTIMONIAL_FORM_NAME);

   $hidden_var_name = ($name==PUZZLE_QUESTION_POST_FORM_NAME)? PUZZLE_QUESTION_POST_FORM_NAME:(($name==PUZZLE_REPLY_FORM_NAME)? PUZZLE_REPLY_FORM_NAME:(($name==TESTIMONIAL_FORM_NAME)? TESTIMONIAL_FORM_NAME:PUZZLES_TESTIMONIAL_FORM_NAME));

   $heading2 = ($name==PUZZLE_QUESTION_POST_FORM_NAME)? "Title:":(($name==PUZZLE_REPLY_FORM_NAME)? "Title:":"Subject");

   //$top_banner_content= ($name==PUZZLE_QUESTION_POST_FORM_NAME)? "Puzzle Corner":(($name==PUZZLE_REPLY_FORM_NAME)? "Puzzle Corner":"http://premski.com");
   
   $top_banner_content= ($name==PUZZLE_QUESTION_POST_FORM_NAME)? "Puzzle Corner":(($name==PUZZLE_REPLY_FORM_NAME)? "Puzzle Corner":"http://premski.com");

   $heading3 = ($name==PUZZLE_QUESTION_POST_FORM_NAME)? "Question:":(($name==PUZZLE_REPLY_FORM_NAME)? "Comment:":"Body:");

   $captcha_question_string = "";
   $captcha_answer = get_captcha_string_and_answer($captcha_question_string);
   $check_captcha = ($user==PREMSKI_ANONYMOUS_USER);
   $check_captcha = 0;
   
   $middle_content .= "<form name = \"prem_form\" onsubmit=\"return validate_captcha(this, $captcha_answer, $check_captcha)\" action=\"add_to_db.php\" method=\"POST\" >";

   $middle_content .= "<table border=\"".TABLE_BORDER."\" width=80% align=center>";
      $middle_content .= "<tr>";
      if($display_heading){
         $middle_content .= "<td colspan=2>";
         $middle_content .= "<h2>$heading1</h2>";
         $middle_content .= "</td>";
      }
      $middle_content .= "<td>";
      $middle_content .= "</td>";
      $middle_content .= "</tr>";

      if($user!=PREMSKI_ANONYMOUS_USER){
         $display_login = 0;
         $middle_content .= "<tr>";
         $middle_content .= "<td valign=top align=right>";
         $middle_content .= "<b>From: </b>";
         $middle_content .= "</td>";
         $middle_content .= "<td>";
         $middle_content .= "<b>$user</b>";
         $middle_content .= "</td>";
         $middle_content .= "</tr>";
         $middle_content .= "<input type=\"hidden\" name=\".".FORM_VAR_NAME."\" value=\"".$hidden_var_name."\"/>";
      }
      if($display_login){
      $middle_content .= "<tr>";
         //CELL 1,1
         $middle_content .= "<td valign=top align=right>";
         $middle_content .= "<b>From:</b>";
         $middle_content .= "</td>";

         //CELL 1,2
         $middle_content .= "<td>";
            $middle_content .= "<input type=\"hidden\" name=\".".FORM_VAR_NAME."\" value=\"".$hidden_var_name."\"/>";

            //UNDER CELL (1,2)
            $middle_content .= "<input type=\"radio\" name=\"logingroup\" value=\"".PREMSKI_ANONYMOUS_USER."\" onClick=\"javascript: hide_div('login_credentials_form_id')\", checked> ".PREMSKI_ANONYMOUS_USER_DISPLAY."<br>";
            $middle_content .= "<input type=\"radio\" name=\"logingroup\" value=\"".PREMSKI_RESIGTERED_USER."\" onClick=\"javascript: show_div('login_credentials_form_id')\"> Registered User(Click <a href=page_gen.php?new_user_sign_up>here</a> if you are a new user)<br>";

            $middle_content .=  "<tr>";
               $middle_content .=  "<td>";
               $middle_content .=  "</td>";

               $middle_content .=  "<td>";
               if($show_div){
                  //$middle_content .= "<div style=\"display:block;padding-left:45px;\" id=login_credentials_form_id>";
                  //print "aaa";
                  $middle_content .= '<div id=login_credentials_form_id style="display:none;">';
               }
               else{
                  $middle_content .= "<div style=\"display:none;padding-left:45px;\" id=login_credentials_form_id>";
               }
               $middle_content .=  "<table >";
                  $middle_content .=  "<tr>";
                  $middle_content .=  "<td>";
                  $middle_content .= "<b>User name</b>";
                  $middle_content .=  "</td>";

                  $middle_content .=  "<td>";
                  $middle_content .= "<input type=\"text\" name=\"user_name\" MAXLENGTH=".MAX_USER_NAME_LENGTH.">";
                  $middle_content .= "";
                  $middle_content .=  "</td>";
                  $middle_content .=  "</tr>";



                  $middle_content .=  "<tr>";
                  $middle_content .=  "<td>";
                  $middle_content .= "<b>Password</b>";
                  $middle_content .=  "</td>";
                  $middle_content .=  "<td>";
                  $middle_content .= "<input type=\"password\" name=\"user_password\" MAXLENGTH=".MAX_USER_PASSWORD_LENGTH.">";
                  $middle_content .= "";
                  $middle_content .=  "</td>";
                  $middle_content .=  "</tr>";



                  $middle_content .=  "<tr>";
                  $middle_content .=  "<td>";
                  $middle_content .=  "</td>";
                  $middle_content .=  "<td>";
                  $middle_content .= "<input type=\"checkbox\" name=\"login_check_box\" value=\"login_check_box\"> Login<br>";
                  $middle_content .=  "</td>";
                  $middle_content .=  "</tr>";
               $middle_content .=  "</table>";
               $middle_content .= "</div>";
               $middle_content .= "</td>";
            $middle_content .= "</tr>";
         $middle_content .= "</td>";
      $middle_content .= "</tr>";
      }//$display_login

      if(array_key_exists('id', $HTTP_GET_VARS1)){
         $middle_content .= "<input type=\"hidden\" name=\".bn\" value=\"".$HTTP_GET_VARS1['id']."\"/>";//xxxx
      }
      $middle_content .= "<input type=\"hidden\" name=\".submitted\" value=\"true\"/>";
      //qweqweqwe
      $middle_content .= "<input type=\"hidden\" name=\"captcha_question_string\" value=\"$captcha_answer\"/>";
      if($display_title){
         $middle_content .= "<tr>";
         $middle_content .= "<td valign=top align=right>";
         $middle_content .= "<b>$heading2</b>";
         $middle_content .= "</td>";
         $middle_content .= "<td>";
         $middle_content .= "<input type=\"text\" name=\"question_title\" MAXLENGTH=".MAX_TITLE_LENGTH.">";
         $middle_content .= "</td>";
         $middle_content .= "</tr>";
      }
      
      
      if($user==PREMSKI_ANONYMOUS_USER){
		 // IF ANONYMOUS USER, DISPLAY CAPTCHA
		 
		 
		 $middle_content .= "<tr>";
         $middle_content .= "<td valign=top align=right>";
         $middle_content .= "<b>$captcha_question_string</b>";
         $middle_content .= "</td>";
         $middle_content .= "<td>";
         $middle_content .= "<input type=\"text\" name=\"captcha_answer\" MAXLENGTH=10> (numbers only)";
         $middle_content .= "</td>";
         $middle_content .= "</tr>";
      }

      if($display_tags){
	$middle_content .= "<tr>";
	$middle_content .= "<td valign=top align=right>";
	$middle_content .= "<b>Tags:</b>";
	$middle_content .= "</td>";
	$middle_content .= "<td>";
	$middle_content .= "<table>";
	$out_tags_array = array();
	get_all_tags($out_tags_array);
	$middle_content .= "<form method=\"post\" name=ABC>";
        $middle_content .= '<fieldset style="margin-left:0px; margin-right:15px;border: 2px dashed #FFFFCC;">';
	foreach ($out_tags_array as $tag=>$count){
            if($tag != "All"){
               $middle_content .= "<LABEL FOR=\"$tag\">";
               $tag1 = urlencode($tag);
               $middle_content .= "<input type=\"checkbox\" name=\"$tag1\" value=\"$tag\" ID=\"$tag\">$tag&nbsp;&nbsp;&nbsp;";
               $middle_content .= "</LABEL>";
            }
	}
	$middle_content .= "</fieldset>";
        $middle_content .= "</form>";
	$middle_content .= "</table>";
	$middle_content .= "</tr>";
      }      

      if($display_comment){
         $middle_content .= "<tr>";
         $middle_content .= "<td valign=top align=right>";
         $middle_content .= "<b>$heading3</b>";
         $middle_content .= "</td>";
         $middle_content .= "<td valign=top align=left>";
         $middle_content .= "<textarea name=\"question\" COLS=".TEXTAREA_COLS_PERCENTAGE."% ROWS=10 MAXLENGTH=".MAX_DESCRIPTION_LENGTH."></textarea>";
         $middle_content .= "</td>";
         $middle_content .= "</tr>";
      }
      if($display_submit_button){
         $middle_content .= "<tr>";
         //$middle_content .= "<td valign=top align=right>";
         //$middle_content .= "</td>";
         $middle_content .= "<td colspan=2>";
         $middle_content .= "<p style=\"text-align:right;\"><input type=\"submit\" value=\"Submit\"></p>";
         $middle_content .= "</form>";
         $middle_content .= "</td>";
         $middle_content .= "</tr>";
      }
   $middle_content .= "</table>";
}

function user_signup_form_helper_function(&$middle_content, &$HTTP_GET_VARS1, &$middle_content)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

   $middle_content .= "<table border=\"".TABLE_BORDER."\" width=40% align=center>";
   $middle_content .= "<h2>Sign Up:</h2>";
   $middle_content .= "<form action=\"add_to_db.php\" method=\"POST\">";
   $middle_content .= "<input type=\"hidden\" name=\".".FORM_VAR_NAME."\" value=\"".NEW_USER_FORM_NAME."\"/>";
   $middle_content .=  "<tr>";
   $middle_content .=  "<td>";
   $middle_content .= "<b>User name</b>";
   $middle_content .=  "</td>";
   $middle_content .=  "<td>";
   $middle_content .= "<input type=\"text\" name=\"user_name\" MAXLENGTH=".MAX_USER_NAME_LENGTH.">";
   $middle_content .= "";
   $middle_content .=  "</td>";
   $middle_content .=  "</tr>";

   $middle_content .=  "<tr>";
   $middle_content .=  "<td>";
   $middle_content .= "<b>Password</b>";
   $middle_content .=  "</td>";
   $middle_content .=  "<td>";
   $middle_content .= "<input type=\"password\" name=\"user_password\" MAXLENGTH=".MAX_USER_PASSWORD_LENGTH.">";
   $middle_content .= "";
   $middle_content .=  "</td>";
   $middle_content .=  "</tr>";

   $middle_content .=  "<tr>";
   $middle_content .=  "<td>";
   $middle_content .= "<b>Email</b>";
   $middle_content .=  "</td>";
   $middle_content .=  "<td>";
   $middle_content .= "<input type=\"text\" name=\"user_email\" MAXLENGTH=".MAX_EMAIL_LENGTH.">";
   $middle_content .= "";
   $middle_content .=  "</td>";
   $middle_content .=  "</tr>";

   $middle_content .=  "<tr>";
   $middle_content .=  "<td>";
   $middle_content .= "<b></b>";
   $middle_content .=  "</td>";
   $middle_content .=  "<td>";
   $middle_content .= "<p style=\"text-align:right;\"><input type=\"submit\" value=\"Submit\"></p>";
   $middle_content .= "";
   $middle_content .=  "</td>";
   $middle_content .=  "</tr>";

   $middle_content .= "</form>";
   $middle_content .= "</table>";
}

function user_login_form_helper_function(&$middle_content, &$HTTP_GET_VARS1, &$middle_content, $next_url)
{
   global $prem_email, $menu_bar_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

   //$next_url = $HTTP_GET_VARS1[NEXT_URL_VAR_NAME];
   $middle_content .= "<table border=\"".TABLE_BORDER."\" width=40% align=center>";
   $middle_content .= "<h2>Login:</h2>";
   $middle_content .= "<form action=\"add_to_db.php\" method=\"POST\">";
   $middle_content .= "<input type=\"hidden\" name=\".".FORM_VAR_NAME."\" value=\"".USER_LOGIN_FORM_NAME."\"/>";
   $middle_content .= "<input type=\"hidden\" name=\".".NEXT_URL_VAR_NAME."\" value=\"".$next_url."\"/>";
   $middle_content .=  "<tr>";
   $middle_content .=  "<td>";
   $middle_content .= "<b>User name</b>";
   $middle_content .=  "</td>";
   $middle_content .=  "<td>";
   $middle_content .= "<input type=\"text\" name=\"user_name\" MAXLENGTH=".MAX_USER_NAME_LENGTH.">";
   $middle_content .= "";
   $middle_content .=  "</td>";
   $middle_content .=  "</tr>";

   $middle_content .=  "<tr>";
   $middle_content .=  "<td>";
   $middle_content .= "<b>Password</b>";
   $middle_content .=  "</td>";
   $middle_content .=  "<td>";
   $middle_content .= "<input type=\"password\" name=\"user_password\" MAXLENGTH=".MAX_USER_PASSWORD_LENGTH.">";
   $middle_content .= "";
   $middle_content .=  "</td>";
   $middle_content .=  "</tr>";

   $middle_content .=  "<tr>";
   $middle_content .=  "<td>";
   $middle_content .= "<b></b>";
   $middle_content .=  "</td>";
   $middle_content .=  "<td>";
   $middle_content .= "<p style=\"text-align:right;\"><input type=\"submit\" value=\"Submit\"></p>";
   $middle_content .= "";
   $middle_content .=  "</td>";
   $middle_content .=  "</tr>";

   $middle_content .= "</form>";
   $middle_content .= "</table>";
   $middle_content .= "<h4>Click <a href=page_gen.php?new_user_sign_up>here</a> to signup for a free account</h4>";
}

function print_sql(&$out_string)
{
   $eol = "<br>";
   $eol = "\n";
   $out_string .= "DROP DATABASE IF EXISTS ".MY_DATABASE.";$eol";
   $out_string .= "CREATE DATABASE ".MY_DATABASE.";$eol";
   $out_string .= "use ".MY_DATABASE.";$eol";
   $out_string .= "$eol";
   $out_string .= "CREATE TABLE Application$eol";
   $out_string .= "($eol";
   $out_string .= "     application_id ".APPLICATION_ID_SQL_TYPE." AUTO_INCREMENT PRIMARY KEY$eol";
   $out_string .= "   , application_name VARCHAR(".APPLICATION_NAME_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , application_title VARCHAR(".APPLICATION_TITLE_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , application_description ".DESCRIPTION_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , rating ".RATING_SQL_TYPE." NOT NULL DEFAULT 0.0$eol";
   $out_string .= "   , mod_time TIMESTAMP$eol";
   $out_string .= "   , no_boards INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , no_messages INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , INDEX application_name_idx (application_name)$eol";
   $out_string .= ") TYPE=INNODB;$eol";
   $out_string .= "$eol";
   $out_string .= "CREATE TABLE UserTable$eol";
   $out_string .= "($eol";
   $out_string .= "     user_id ".USER_ID_SQL_TYPE." AUTO_INCREMENT PRIMARY KEY$eol";
   $out_string .= "   , user_name VARCHAR(".MAX_USER_NAME_LENGTH.") NOT NULL$eol";
   $out_string .= "   , user_email VARCHAR(".MAX_EMAIL_LENGTH.") NOT NULL$eol";
   $out_string .= "   , user_password VARCHAR(".MAX_USER_PASSWORD_LENGTH.") NOT NULL$eol";
   $out_string .= "   , user_verification_key VARCHAR(".MAX_VERIFICATION_KEY_LENGTH.") NOT NULL$eol";
   $out_string .= "   , user_board_count INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , is_verified ENUM('NOTVERIFIED', 'VERIFIED') NOT NULL$eol";
   $out_string .= "   , user_type ENUM('".USER_TYPE_NORMAL."','".USER_TYPE_TAGGER."', '".USER_TYPE_ADMIN."') NOT NULL$eol";
   //$out_string .= "   , PRIMARY KEY (user_id)$eol";
   $out_string .= "   , INDEX user_namex (user_name)$eol";
   $out_string .= ") TYPE=INNODB;$eol";
   $out_string .= "$eol";
   $out_string .= "/*************************************************************$eol";
   $out_string .= "****  The max length of a tag is 30 characters    .       ****$eol";
   $out_string .= "****                                                      ****$eol";
   $out_string .= "****                                                      ****$eol";
   $out_string .= "*************************************************************/$eol";
   $out_string .= "CREATE TABLE Tag$eol";
   $out_string .= "($eol";
   $out_string .= "     application_id ".APPLICATION_ID_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , tag_id ".TAG_ID_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , tag_name VARCHAR(".MAX_INDIVIDUAL_TAG_LENGTH.") NOT NULL$eol";
   $out_string .= "   , tag_count INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , is_approved ENUM('NOTAPPROVED', 'APPROVED') NOT NULL$eol";
   $out_string .= "   , PRIMARY KEY (application_id, tag_id)$eol";
   $out_string .= "   , FOREIGN KEY (application_id) REFERENCES Application(application_id) ON DELETE CASCADE$eol";
   $out_string .= "   , INDEX tagname_idx (tag_name)$eol";
   $out_string .= "   , INDEX tag_idx (tag_id)$eol";
   $out_string .= ") TYPE=INNODB;$eol";
   $out_string .= "$eol";
   $out_string .= "CREATE TABLE Board$eol";
   $out_string .= "($eol";
   $out_string .= "     application_id ".APPLICATION_ID_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , board_id varchar(".BOARD_ID_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , board_name VARCHAR(".BOARD_NAME_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , board_title VARCHAR(".BOARD_TITLE_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , board_description ".DESCRIPTION_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , creator_id ".USER_ID_SQL_TYPE." NOT NULL DEFAULT ".PREMSKI_ANONYMOUS_USER_ID."$eol";
   $out_string .= "   , is_approved ENUM('NOTAPPROVED', 'APPROVED') NOT NULL$eol";
   //$out_string .= "   , rating ".RATING_SQL_TYPE." NOT NULL DEFAULT 0.0$eol";
   //$out_string .= "   , no_ratings INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , no_messages INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , create_time DATETIME NOT NULL$eol";
   $out_string .= "   , mod_time DATETIME NOT NULL$eol";
   $out_string .= "   , create_ip BIGINT NOT NULL$eol";
   $out_string .= "   , PRIMARY KEY (application_id, board_id)$eol";
   $out_string .= "   , FOREIGN KEY (application_id) REFERENCES Application(application_id) ON DELETE CASCADE$eol";
   $out_string .= "   , FOREIGN KEY (creator_id) REFERENCES UserTable(user_id) ON DELETE CASCADE$eol";
   $out_string .= "   , INDEX boardid_idx (board_id)$eol";
   $out_string .= ") TYPE=INNODB;$eol";
   $out_string .= "$eol";
   $out_string .= "/*************************************************************$eol";
   $out_string .= "****  There can be only 128 messages under a board.       ****$eol";
   $out_string .= "****  If you need bigger range, use SMALLINT, MEDIUMINT   ****$eol";
   $out_string .= "****  or INT for message_id                               ****$eol";
   $out_string .= "*************************************************************/$eol";
   $out_string .= "CREATE TABLE Message$eol";
   $out_string .= "($eol";
   $out_string .= "     application_id  ".APPLICATION_ID_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , board_id VARCHAR(".BOARD_ID_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , message_id ".MESSAGE_ID_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , create_date DATETIME NOT NULL$eol";
   $out_string .= "   , update_date DATETIME NOT NULL$eol";
   $out_string .= "   , title VARCHAR(".MESSAGE_TITLE_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , link VARCHAR(".MESSAGE_LINK_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , description ".DESCRIPTION_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , creator_id ".USER_ID_SQL_TYPE." NOT NULL DEFAULT ".PREMSKI_ANONYMOUS_USER_ID."$eol";
   $out_string .= "   , is_approved ENUM('NOTAPPROVED', 'APPROVED') NOT NULL$eol";
   $out_string .= "   , rating ".RATING_SQL_TYPE." NOT NULL DEFAULT 0.0$eol";
   $out_string .= "   , no_ratings INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , create_ip BIGINT NOT NULL$eol";
   $out_string .= "   , PRIMARY KEY (application_id, board_id, message_id)$eol";
   $out_string .= "   , FOREIGN KEY (application_id) REFERENCES Application(application_id)$eol";
   $out_string .= "   , FOREIGN KEY (board_id) REFERENCES Board(board_id)$eol";
   $out_string .= "   , FOREIGN KEY (creator_id) REFERENCES UserTable(user_id) ON DELETE CASCADE$eol";
   $out_string .= ") TYPE=INNODB;$eol";
   $out_string .= "$eol";
   $out_string .= "CREATE TABLE TagBoardMap$eol";
   $out_string .= "($eol";
   $out_string .= "     application_id ".APPLICATION_ID_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , board_id VARCHAR(".BOARD_ID_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , tag_id ".TAG_ID_SQL_TYPE." NOT NULL$eol";
   $out_string .= "   , tag_count INT NOT NULL DEFAULT 1$eol";
   $out_string .= "   , PRIMARY KEY (application_id, board_id, tag_id)$eol";
   $out_string .= "   , FOREIGN KEY (application_id) REFERENCES Application(application_id) ON DELETE CASCADE$eol";
   $out_string .= "   , FOREIGN KEY (board_id) REFERENCES Board(board_id) ON DELETE CASCADE$eol";
   $out_string .= "   , FOREIGN KEY (tag_id) REFERENCES  Tag(tag_id) ON DELETE CASCADE$eol";
   $out_string .= "   , INDEX tag_idx (tag_id)$eol";
   $out_string .= ") TYPE=INNODB;$eol";
   
   
   $out_string .= "$eol";
   $out_string .= "CREATE TABLE BoardRating$eol";
   $out_string .= "($eol";
   $out_string .= "     board_id VARCHAR(".BOARD_ID_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , rating ".RATING_SQL_TYPE." NOT NULL DEFAULT 0.0$eol";
   $out_string .= "   , no_ratings INT NOT NULL DEFAULT 0$eol";
   $out_string .= "   , PRIMARY KEY (board_id)$eol";
   $out_string .= "   , FOREIGN KEY (board_id) REFERENCES Board(board_id) ON DELETE CASCADE$eol";
   $out_string .= ") TYPE=INNODB;$eol";

   $out_string .= "$eol";
   $out_string .= "CREATE TABLE BlacklistedIps$eol";
   $out_string .= "($eol";
   $out_string .= "   ip BIGINT NOT NULL$eol";
   $out_string .= "   , PRIMARY KEY (ip)$eol";
   $out_string .= ") TYPE=INNODB;$eol";


   $out_string .= "$eol";
   $out_string .= "CREATE TABLE BlacklistedUsers$eol";
   $out_string .= "($eol";
   $out_string .= "     user_id ".USER_ID_SQL_TYPE."$eol";
   $out_string .= "   , PRIMARY KEY (user_id)$eol";
   $out_string .= "   , FOREIGN KEY (user_id) REFERENCES UserTable(user_id) ON DELETE CASCADE$eol";
   $out_string .= ") TYPE=INNODB;$eol";


   $out_string .= "$eol";
   $out_string .= "CREATE TABLE UserSubscriptions$eol";
   $out_string .= "($eol";
   $out_string .= "     user_id ".USER_ID_SQL_TYPE."$eol";
   $out_string .= "   , board_id VARCHAR(".BOARD_ID_MAX_LENGTH.") NOT NULL$eol";
   $out_string .= "   , PRIMARY KEY (user_id, board_id)$eol";
   $out_string .= "   , FOREIGN KEY (user_id) REFERENCES UserTable(user_id) ON DELETE CASCADE$eol";
   $out_string .= "   , FOREIGN KEY (board_id) REFERENCES Board(board_id) ON DELETE CASCADE$eol";
   $out_string .= "   , INDEX board_idx (board_id)$eol";
   $out_string .= ") TYPE=INNODB;$eol";



}


?>
