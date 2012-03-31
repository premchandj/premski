<?php

include "common.php";
include "setup_application.php";

//include "/home/y/share/htdocs/common.php";
//include "/home/y/share/htdocs/setup_application.php";

global $prem_email, $left_color, $middle_color, $right_color, $overall_color, $top_banner_color, $top_banner_content, $development, $debug;

$ip = get_client_ip_address();
///*
/////////////////CREATE APPLICATIONS/////////////////////////////////
create_update_application('puzzles', "CS Zone", "<p>Hi! My name is Prem, and I work with Yahoo! Inc as a software developer. I have been working in the software field for over 10 years, and have enjoyed every bit of it. Mainly the challenges it offers. <a href=page_gen.php?resume>Here</a> is my bio. </p> <br><p>This collection of puzzles, Algorithm & programming questions have been taken from a lot of sources on the internet, and also from my interviews with tech companies of various sizes, from startups to the gorillas. Lot of care has been taken to add only quality questions(IMHO) and not to add trivial questions. Most questions here don\'t have a set answer, but usually the interviewer is interested in how you approach the problem, rather than coming up with the right answer (Well, at least that what they say!!). I would encourage you to try to solve the problems yourself, before asking others for answers. Just remember, if you come up with the most obvious answer, it mostly is not the answer the interviewer is looking for.</p><br>Rules for posting questions:<br>1. It should pertain to computer science<br>2. No language/database specific questions should be added(exceptions are C++, mysql & other technology questions which are usually asked in interviews)<br>3. Profanities will not be tolerated(in questions or comments)<br>4. Moderator\'s(prem) decision is final. I reserve the right to add/delete/blacklist any content in this site<br><br> Lastly, a word of advice. These questions only give you a flavor of what to expect in interviews in most tech companies, and so are not the real questions themselves. Please do not memorize the answers, as the goal of this website is to make you into a better thinker, problem solver, and to help you fulfill your dreams");
///*
//create_update_application('feedback', "Feedback", "Please send in your comments on what you like/dislike about this site, and I will do my best to make it better. Thanks for visiting");

//create_update_application('cooking', "Cooking", "Cooking by Preeti");

//ADD USER ANONYMOUS AS NORMAL USER
AddUser(PREMSKI_ANONYMOUS_USER, '', '', 'NORMAL','VERIFIED');

//ADD USER PREM AS ADMIN USER
AddUser(PREM_REAL_USER_NAME, PREM_REAL_EMAIL, PREM_REAL_USER_PASSWORD, USER_TYPE_ADMIN,'VERIFIED');


//*/
/////////////////CREATE BLOG & FEEDBACK BOARDS UNDER PUZZLE/////////////////////////////////
$puzzles_application = get_application(PUZZLES_APPLICATION_NAME);
create_update_board($puzzles_application['application_id'], FEEBDACK_BOARD_NAME, FEEBDACK_BOARD_NAME, "<b>Hi! Thanks for visiting this site. My goal is to make this site simple, and powerful, for you to be able to expand your CS knowledge & prepare for interviews. Please send in your comments on what you like/dislike about this site, and I will do my best to make it better. Thanks again for visiting.</b>", $ip, "", false, 'prem');
create_update_board($puzzles_application['application_id'], BLOG_BOARD_NAME, BLOG_BOARD_NAME, "<b>Hi! Checkout this page for the latest enhancements to this site.</b>", $ip, "", false, 'prem');
create_update_board($puzzles_application['application_id'], RESOURCE_BOARD_NAME, RESOURCE_BOARD_NAME, "<b>Please post links to freely available online resources(ebooks, job sites,...) .</b>", $ip, "",  false, 'prem');

/////////////////DEFAULT LIST OF PUZZLES/////////////////////////////////
?>
