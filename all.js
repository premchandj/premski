var my_email_address = "pcj_1 at yahoo dot com";

function redirect (redirect_location){
	//var loc_string = '<img src="http://prem.bangalore.corp.yahoo.com/cgi-bin/setcounter.pl?q='+counter_name+'" style="hidden;width:0px;height:0px">';
	//document.write(loc_string);
	//document.write('<img src="http://prem.bangalore.corp.yahoo.com/cgi-bin/setcounter.pl?q=overall" style="hidden;width:0px;height:0px">');
	//increment_counter (counter_name);
	setTimeout(go_now(redirect_location),0);
}

function go_now (redirect_location){window.location.href = redirect_location;}

function increment_counter (counter_name)
{
	var loc_string = '<img src="http://prem.bangalore.corp.yahoo.com/cgi-bin/setcounter.pl?q='+counter_name+'" style="hidden;width:0px;height:0px">';
	document.write(loc_string);
	document.write('<img src="http://prem.bangalore.corp.yahoo.com/cgi-bin/setcounter.pl?q=overall" style="hidden;width:0px;height:0px">');
}

function print_date_time()
{
    var d = new Date()
    var date_str = d.getDate();
    var month_str = d.getMonth()+1;
    var year_str = d.getFullYear();
    var hours_str = d.getHours();
    	var AM_or_PM = (hours_str<12)? "AM":"PM";
	if(hours_str>12){hours_str = hours_str -12;}
    var mins_str = d.getMinutes();
    var secs_str = d.getSeconds();

    var out_str= (month_str==1)? "Jan":(month_str==2)? "Feb":(month_str==3)? "Mar":(month_str==4)? "Apr":(month_str==5)? "May":(month_str==6)? "Jun":(month_str==7)? "Jul":(month_str==8)? "Aug":(month_str==9)? "Sep":(month_str==10)? "Oct":(month_str==11)? "Nov":(month_str==12)? "Dec":"";
    document.write(out_str);
    document.write(" ")
    document.write(date_str)
    document.write(", ")
    document.write(year_str)
/*
    document.write(" ")
    if(hours_str<10){document.write("0")}
    document.write(hours_str)
    document.write(":")
    if(mins_str<10){document.write("0")}
    document.write(mins_str)
    document.write(":")
    if(secs_str<10){document.write("0")}
    document.write(secs_str)
    document.write(" ")
    document.write(AM_or_PM)
*/
}

function print_search_combo(SearchEnginehash, num)
{
	if(!num){
		document.write('<fORM TARGET="c22" name=search style="background-color:transparent;>');
		document.write('<input type=hidden name=ie value=UTF-8>');
		document.write('<input type=hidden name=oe value=UTF-8>');
		document.write('<TABLE bgcolor="#FFFFFF"><tr><td>');
		document.write('<INPUT TYPE=text name=q size=12 maxlength=255 value="">');
		document.write('<select name="search_combo">');
		for (SearchEngineName in SearchEnginehash){
			document.write('        <option value="'+SearchEngineName+'">'+SearchEngineName+'</option>');
		}
		document.write('</select>');
		document.write('<INPUT type=submit name=btnG VALUE="Search" onClick="javascript:print_search_combo(SearchEnginehash, 1); return false;">');
		document.write('<font size=-1></font>');
		document.write('</td></tr>');
		document.write('</TABLE>');
		document.write('</FORM>');
	}
	else{
		parent.frames['c22'].location.href = SearchEnginehash[document.search.search_combo.options[document.search.search_combo.options.selectedIndex].value] + document.search.q.value;
		return false;
	}
}



function display_table(name)
{
	if (document.getElementById(name).style.display == "none")
		document.getElementById(name).style.display = "block";
	else
		document.getElementById(name).style.display = "none";
}


function toggle_show_hide_div(who) {
	if (document.getElementById(who).style.display == "none")
		document.getElementById(who).style.display = "block";
	else
		document.getElementById(who).style.display = "none";
}

function hide_div(who) {
		document.getElementById(who).style.display = "none";
}

function show_div(who) {
		document.getElementById(who).style.display = "block";
}

function load_url_in_iframe(frame_name, url)
{
	frames[frame_name].location.href=url;
}

function print_puzzles_qa(questions, answers) {
	var spaces_before_mailme = "";
	for(var ii=0;ii<50;++ii){spaces_before_mailme += '&nbsp';}
	document.write('<ol>');
	for (var i=0; i<questions.length; i++) {
		document.write('<LI>' + questions[i]+'<br>');
		//document.write('<input type="button" value="Answer" onClick="javascript: toggle_show_hide_div(\'div' + i + '\')">');
      //xxxx
		document.write('<button  style="background-color: light green;" onClick="javascript: toggle_show_hide_div(\'div' + i + '\')">Answer</button>');
		//document.write('<div border=1 style="display:none;padding-left:45px;" id="div' + i + '">');
		//document.write('<div border=1 style="display:none;padding-left:45px;color:green" id="div' + i + '">');
		document.write('<div border=1 style="display:none;padding-left:45px;" id="div' + i + '">');
		var answer_str = "";
		if(answers[i]){
			answer_str = answers[i];
		}
		var ans_betterans = (answer_str)? "Better answers?":"Be the first to answer this.";
		//document.write(answer_str+'<br><font align:"right" style:"color:red">'+spaces_before_mailme+' <a href="mailto:'+my_email_address+'">'+ans_betterans+' Mail me</a></font>');
		document.write('<blockquote>'+answer_str+'</blockquote><a href="mailto:'+my_email_address+'?subject=Re: Problem '+(i+1)+'" > <p align=right><FONT COLOR="maroon">'+ans_betterans+' Mail me</font></p></a>');
		//document.write('<br>');
		document.write('</div>');
		document.write('</LI>');
		document.write('<br>');
	}
	document.write('</ol>');
}

function get_num_initial_delimiters(s /*string*/, delimiter /*single character*/)
{
	var num_delimiters=0;
	for(var i=0;i<s.length;++i){
		if(s.charAt(i) != delimiter){
			return num_delimiters;
		}
		else{ ++num_delimiters;}
	}
	return num_delimiters;
}

var openImg = new Image();
openImg.src = "./images/open.gif";
var closedImg = new Image();
closedImg.src = "./images/closed.gif";

function swapFolder(img){
	objImg = document.getElementById(img);
	//if(objImg.src.indexOf('./images/closed.gif')>-1){
	if(objImg.src.indexOf('closed.gif')>-1){
		objImg.src = openImg.src;
	}
	else{
		objImg.src = closedImg.src;	
	}
}

//////////////////////////////////////////////////////////////
/*
This function is used to draw menus. Here is an example
var menu_array = Array(
 ',Companies'
,' ,Software'
,'  ,Internet'
,'   ,Yahoo!,http://www.yahoo.com'
,'   ,Google,http://www.google.com'
,'   ,Search'
,'    ,Y! Search,http://search.yahoo.com'
,'    ,Google Search,http://search.google.com'
,'  ,Services'
,'   ,Computer associates,http://www.ca.com'
' ,hardware'
'  ,Intel,http://www.intel.com'
);

The array has multiple elements. Each element has comma seperated values
value 1 = number of spaces(indicating the tree depth level)
value 2 = Display value
value 3 = url
value 4 = style(default is "color:green")

The above is used to implement this menu hierarchy

Companies
|
----->Software
        |
        ----->Internet
        |        |
        |        ----->Yahoo
        |        |
        |        ----->Google
        |        |
        |        ----->Search
        |                 |
        |                  -----> Y! search
        |                 |
        |                  -----> Google search
        |
        ----->Services
----->Hardware
        |
        ----->Intel

//////////////////////////////////////////////////////////////
*/
///*
var NoOfSubfolders = 0;
function print_menus_sub(arrayRef, startIndex, noOfDelimiters, parentID) {
	var delimiter = "";
	for (var j=0;j<noOfDelimiters;++j){
		delimiter = delimiter + "&nbsp&nbsp&nbsp&nbsp";
	}

	for (var i=startIndex; i<(arrayRef.length)-1; i++) {
		var numSpacesInCurrentMenuitem = get_num_initial_delimiters(arrayRef[i], ' ');
		if(numSpacesInCurrentMenuitem == noOfDelimiters){
			var loc_array = arrayRef[i].split(',');
			var style = (loc_array[3])? loc_array[3]:"color:green";
			var track_link = (loc_array[4])? 1:0;
			var track_link_str = "";
			if(track_link==1){
				track_link_str = '<form onClick="http://prem.bangalore.corp.yahoo.com/cgi-bin/setcounter.pl?q='+loc_array[1] +'.lnk" method="post">';
			}
			var numSpacesInNextMenuitem = get_num_initial_delimiters(arrayRef[i+1], ' ');
			if(numSpacesInNextMenuitem <= noOfDelimiters){
				//var document_write_str = delimiter+'<a href="'+loc_array[2]+'" TARGET="c22" style="'+style+'">'+loc_array[1]+'</a><br>';
                                var document_write_str = delimiter+'<a href="'+loc_array[2]+'" style="'+style+'">'+loc_array[1]+'</a><br>';
				document.write(document_write_str);
				if(noOfDelimiters==0){
					document.write('<br>');
				}
				if(numSpacesInNextMenuitem < noOfDelimiters){
					return i;
				}
			}
			else{
				++NoOfSubfolders;
				var div_name = "div_" + NoOfSubfolders + "_" + (noOfDelimiters + 1);
				var document_write_str = '<span style="'+style+'" onClick="toggle_show_hide_div(\'' + div_name + '\');swapFolder(\'folder'+NoOfSubfolders+'\') ">'+delimiter+'<img src="./images/closed.gif" border="0" id=\'folder'+NoOfSubfolders+'\'>'+loc_array[1]+'</span><br>';
				document.write(document_write_str);
				document.write('<span style="display: none;color:green" id="' + div_name + '">');
				i = print_menus_sub(arrayRef, i+1, noOfDelimiters+1, parentID+1);
				document.write('</span>');
			}
		}
		else{
			return --i;
		}
	}
}

function print_menus_sub_external(arrayRef, startIndex, noOfDelimiters, parentID) {
	var delimiter = "";
	for (var j=0;j<noOfDelimiters;++j){
		delimiter = delimiter + "&nbsp&nbsp&nbsp&nbsp";
	}

	for (var i=startIndex; i<(arrayRef.length)-1; i++) {
		var numSpacesInCurrentMenuitem = get_num_initial_delimiters(arrayRef[i], ' ');
		if(numSpacesInCurrentMenuitem == noOfDelimiters){
			var loc_array = arrayRef[i].split(',');
			var style = (loc_array[3])? loc_array[3]:"color:green";
			var track_link = (loc_array[4])? 1:0;
			var track_link_str = "";
			if(track_link==1){
				track_link_str = '<form onClick="http://prem.bangalore.corp.yahoo.com/cgi-bin/setcounter.pl?q='+loc_array[1] +'.lnk" method="post">';
			}
			var numSpacesInNextMenuitem = get_num_initial_delimiters(arrayRef[i+1], ' ');
			if(numSpacesInNextMenuitem <= noOfDelimiters){
				//var document_write_str = delimiter+'<a href="'+loc_array[2]+'" TARGET="c22" style="'+style+'">'+loc_array[1]+'</a><br>';
                                var document_write_str = delimiter+'<a href="'+loc_array[2]+'" style="'+style+'" target="UNKNOWN">'+loc_array[1]+'</a><br>';
				document.write(document_write_str);
				if(noOfDelimiters==0){
					document.write('<br>');
				}
				if(numSpacesInNextMenuitem < noOfDelimiters){
					return i;
				}
			}
			else{
				++NoOfSubfolders;
				var div_name = "div_" + NoOfSubfolders + "_" + (noOfDelimiters + 1);
				var document_write_str = '<span style="'+style+'" onClick="toggle_show_hide_div(\'' + div_name + '\');swapFolder(\'folder'+NoOfSubfolders+'\') ">'+delimiter+'<img src="./images/closed.gif" border="0" id=\'folder'+NoOfSubfolders+'\'>'+loc_array[1]+'</span><br>';
				document.write(document_write_str);
				document.write('<span style="display: none;color:green" id="' + div_name + '">');
				i = print_menus_sub(arrayRef, i+1, noOfDelimiters+1, parentID+1);
				document.write('</span>');
			}
		}
		else{
			return --i;
		}
	}
}

function get_random(mod)
{
    var ranNum= Math.round(Math.random()*mod);
    return ranNum;
}

function get_random_image()
{
	var image_array = Array(
		"./images/bgimages/1280x960_Sheephead.jpg"
		,"./images/bgimages/FuryCow_1200.jpg"
		,"./images/bgimages/IrishWolf1280x960.jpg"
		,"./images/bgimages/WorldNF_1280x960.jpg"
		,"./images/bgimages/asleep1600x1200.jpg"
		,"./images/bgimages/autumn1600x1200.gif"
		,"./images/bgimages/captain1_1600.jpg"
		,"./images/bgimages/evergreen.jpg"
		,"./images/bgimages/hellolove_1024.jpg"
		,"./images/bgimages/img15xl_1280x960.jpg"
		,"./images/bgimages/ipodlounge_holiday2004_1920.gif"
		,"./images/bgimages/lemon_1600.jpg"
		,"./images/bgimages/mintymilk_1024.gif"
		,"./images/bgimages/pigpup2_1600.jpg"
		,"./images/bgimages/spiritella_valent_1280.jpg"
		,"./images/bgimages/twice_dead_1024.jpg"
	);
	return image_array[get_random(image_array.length-1)];
}

function set_bg_img(img)
{
	var style_str = "";
	style_str += '<STYLE type="text/css">';
	style_str += 'BODY { background: url("'+img+'")}';
	style_str += '</STYLE>';
	document.write(style_str);
}

function set_random_bg_img()
{
	set_bg_img(get_random_image());
}

function get_random_color()
{
	//var color_array = Array("#FFFFFF","#FFFFCC","#FFFF99","#FFFF66","#FFFF33","#FFFF00","#FFCCFF","#FFCCCC","#FFCC99","#FFCC66","#FFCC33","#FFCC00","#FF99FF","#FF99CC","#FF9999","#FF9966","#FF9933","#FF9900","#FF66FF","#FF66CC","#FF6699","#FF6666","#FF6633","#FF6600","#FF33FF","#FF33CC","#FF3399","#FF3366","#FF3333","#FF3300","#FF00FF","#FF00CC","#FF0099","#FF0066","#FF0033","#FF0000","#66FFFF","#66FFCC","#66FF99","#66FF66","#66FF33","#66FF00","#66CCFF","#66CCCC","#66CC99","#66CC66","#66CC33","#66CC00","#6699FF","#6699CC","#669999","#669966","#669933","#669900","#6666FF","#6666CC","#666699","#666666","#666633","#666600","#6633FF","#6633CC","#663399","#663366","#663333","#663300","#6600FF","#6600CC","#660099","#660066","#660033","#660000","#CCFFFF","#CCFFCC","#CCFF99","#CCFF66","#CCFF33","#CCFF00","#CCCCFF","#CCCCCC","#CCCC99","#CCCC66","#CCCC33","#CCCC00","#CC99FF","#CC99CC","#CC9999","#CC9966","#CC9933","#CC9900","#CC66FF","#CC66CC","#CC6699","#CC6666","#CC6633","#CC6600","#CC33FF","#CC33CC","#CC3399","#CC3366","#CC3333","#CC3300","#CC00FF","#CC00CC","#CC0099","#CC0066","#CC0033","#CC0000","#33FFFF","#33FFCC","#33FF99","#33FF66","#33FF33","#33FF00","#33CCFF","#33CCCC","#33CC99","#33CC66","#33CC33","#33CC00","#3399FF","#3399CC","#339999","#339966","#339933","#339900","#3366FF","#3366CC","#336699","#336666","#336633","#336600","#3333FF","#3333CC","#333399","#333366","#333333","#333300","#3300FF","#3300CC","#330099","#330066","#330033","#330000","#99FFFF","#99FFCC","#99FF99","#99FF66","#99FF33","#99FF00","#99CCFF","#99CCCC","#99CC99","#99CC66","#99CC33","#99CC00","#9999FF","#9999CC","#999999","#999966","#999933","#999900","#9966FF","#9966CC","#996699","#996666","#996633","#996600","#9933FF","#9933CC","#993399","#993366","#993333","#993300","#9900FF","#9900CC","#990099","#990066","#990033","#990000","#00FFFF","#00FFCC","#00FF99","#00FF66","#00FF33","#00FF00","#00CCFF","#00CCCC","#00CC99","#00CC66","#00CC33","#00CC00","#0099FF","#0099CC","#009999","#009966","#009933","#009900","#0066FF","#0066CC","#006699","#006666","#006633","#006600","#0033FF","#0033CC","#003399","#003366","#003333","#003300","#0000FF","#0000CC","#000099","#000066","#000033","#000000");
	var color_array = Array("AliceBlue","AntiqueWhite","Aquamarine","Azure","Beige","Bisque","BlanchedAlmond","Brown","BurlyWood","CadetBlue","Chocolate","Coral","CornflowerBlue","Cornsilk","DarkCyan","DarkGoldenRod","DarkGray","DarkGreen","DarkKhaki","DarkOliveGreen","Darkorange","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DimGray","DodgerBlue","Feldspar","FloralWhite","ForestGreen","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","HoneyDew","HotPink","IndianRed","Ivory","Khaki","Lavender","LavenderBlush","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateBlue","LightSlateGray","LightSteelBlue","LightYellow","Linen","MediumAquaMarine","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumTurquoise","MediumVioletRed","MintCream","MistyRose","Moccasin","NavajoWhite","OldLace","Olive","OliveDrab","Orange","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","Snow","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","VioletRed","Wheat","White","WhiteSmoke","YellowGreen");
	return color_array[get_random(color_array.length-1)];
}

function set_bg_color(col)
{
	var style_str = "";
	style_str += '<STYLE type="text/css">';
	style_str += 'BODY { background:'+col+'}';
	style_str += '</STYLE>';
	document.write(style_str);
}

function set_random_bg_color()
{
	set_bg_color(get_random_color());
}

function print_puzzles()
{
var questions = Array(
/*1*/'Puzzle: You are given 9 billiard balls. All of them are equal weight except for one, which is heavier than the rest. You are given a weighing balance (no standard weights to compare it with, can only compare it with other balls). What is the minimum number of weightings to find out the heavier ball.'
/*2*/,'Puzzle: You are given 12 billiard balls. All of them are equal weight except for one, which is heavier than the rest. You are given a weighing balance (no standard weights to compare it with, can only compare it with other balls). What is the minimum number of weightings to find out the heavier ball.'
/*3*/,'Puzzle: There are twelve identical-looking balls, but one is either heavier or lighter than the other eleven. How can you determine which is the odd ball and find out whether this ball is heavier or lighter than the others using only three weighings with a balance?'
/*4*/,'Puzzle: A man has to get a fox, a chicken, and a sack of corn across a river. He has a rowboat, and it can only carry him and one other thing. If the fox and the chicken are left together, the fox will eat the chicken. If the chicken and the corn is left together, the chicken will eat the corn. How does the man do it?'
/*5*/,'Puzzle: In your cellar there are three light switches in the OFF position. Each switch controls 1 of 3 light bulbs on floor above. You may move any of the switches but you may only go upstairs to inspect the bulbs one time. How can you determine the switch for each bulb with one inspection??'
/*6*/,'Puzzle: There are 3 black hats and 2 white hats in a box. Three men (we will call them A\, B\, \& C) each reach into the box and place one of the hats on his own head. They cannot see what color hat they have chosen. The men are situated in a way that A can see the hats on B \& C\'s heads\, B can only see the hat on C\'s head and C cannot see any hats. When A is asked if he knows the color of the hat he is wearing, he says no. When B is asked if he knows the color of the hat he is wearing he says no. When C is asked if he knows the color of the hat he is wearing he says yes and he is correct. What color hat and how can this be? There is no play on words and there are no tricks. If I used had instead of has it is purely accidental.'
/*7*/,'Puzzle: You are ill and travelling down a road to the hospital. You reach a fork in the road and find a pair of identical twin boys standing there. One of the twins always tells the truth and the other twin always lies. You are allowed to direct only one question to one of the twins, and as such you will be assured of the correct road to the hospital. What is your question and to whom?'
/*8*/,'Puzzle: 8\, 5\, 4\, 9\, 1\, 7\, 6\, Whats next in the series?'
/*9*/,'Puzzle: You are given 10 baskets. 9 of the baskets each have 10 balls weighing 10kg per ball, however one basket has 10 balls weighing 9kg each. All the balls and baskets are identical in appearance. You are asked to determine which basket contains the 9kg balls. You have a suitable scale, but may only take a single measurement. No other measurements may be taken (like trying to determine by hand). You may remove balls from the baskets but may still only take one measurement. How do you do it?'
/*10*/,'Puzzle: You have two hourglasses--a 4-minute glass and a 7-minute glass. You want to measure 9 minutes. How do you do it?'
/*11*/,'Puzzle: Given a rectangular (cuboidal for the puritans) cake with a rectangular piece removed (any size or orientation), how would you cut the remainder of the cake into two equal halves with one straight cut of a knife?'
/*12*/,'Algorithm & Programming: You\'re given an array containing both positive and negative integers and required to find the subarray with the largest sum (O(N) a la KBL) Write a routine in C for the above'
/*13*/,'Algorithm & Programming: Given an array of size N in which every number is between 1 and N, determine if there are any duplicates in it. You are allowed to destroy the array if you like'
/*14*/,'Algorithm & Programming: Given only putchar (no sprintf, itoa, etc.) write a routine putlong that prints out an unsigned long in decimal. '
/*15*/,'Programming: Give a one-line C expression to test whether a number is a power of 2 '
/*16*/,'Algorithm & Programming: Given an array of characters which form a sentence of words, give an efficient algorithm to reverse the order of the words (not characters) in it.'
/*17*/,'Puzzle: How many points are there on the globe where by walking one mile south, one mile east and one mile north you reach the place where you started.'
/*18*/,'Algorithm & Programming: Give a very good method to count the number of ones in a 32 bit number.(caution: looping through testing each bit is not a solution).'
/*19*/,'Algorithm & Programming: In a X\'s and 0\'s game (i.e. TIC TAC TOE) if you write a program for this give a fast way to generate the moves by the computer. I mean this should be the fastest way possible. The answer is that you need to store all possible configurations of the board and the move that is associated with that. Then it boils down to just accessing the right element and getting the corresponding move for it. Do some analysis and do some more optimization in storage since otherwise it becomes infeasible to get the required storage in a DOS machine.'
/*20*/,'Programming: Give a fast way to multiply a number by 7. '
/*21*/,'Algorithm & Programming: Given two strings S1 and S2. Delete from S2 all those characters which occur in S1 also and finally create a clean S2 with the relevant characters deleted.'
/*22*/,'Algorithm & Programming: Given an array of characters. How would you reverse it. ? How would you reverse it without using indexing in the array.'
/*23*/,'Algorithm & Programming: Given a sequence of characters. How will you convert the lower case characters to upper case characters.'
/*24*/,'Puzzle: If you are on a boat and you throw out a suitcase, Will the level of water increase. '
/*25*/,'Puzzle: You\'ve got someone working for you for seven days and a gold bar to pay them. The gold bar is segmented into seven connected pieces. You must give them a piece of gold at the end of every day. If you are only allowed to make two breaks in the gold bar, how do you pay your worker?'
/*26*/,'Puzzle: One train leaves Los Angeles at 15mph heading for New York. Another train leaves from New York at 20mph heading for Los Angeles on the same track. If a bird, flying at 25mph, leaves from Los Angeles at the same time as the train and flies back and forth between the two trains until they collide, how far will the bird have traveled?'
/*27*/,'Puzzle: Imagine you are standing in front of a mirror, facing it. Raise your left hand. Raise your right hand. Look at your reflection. When you raise your left hand your reflection raises what appears to be his right hand. But when you tilt your head up, your reflection does too, and does not appear to tilt his/her head down. Why is it that the mirror appears to reverse left and right, but not up and down?'
/*28*/,'Puzzle: You have 4 jars of pills. Each pill is a certain weight, except for contaminated pills contained in one jar, where each pill is weight + 1. How could you tell which jar had the contaminated pills in just one measurement?'
/*29*/,'Puzzle: If you had an infinite supply of water and a 5 quart and 3 quart pail, how would you measure exactly 4 quarts?'
/*30*/,'Puzzle: 97 baseball teams participate in an annual state tournament. The way the champion is chosen for this tournament is by the same old elimination schedule. That is, the 97 teams are to be divided into pairs, and the two teams of each pair play against each other. After a team is eliminated from each pair, the winners would be again divided into pairs, etc. How many games must be played to determine a champion?'
/*31*/,'Puzzle: You want to send a valuable object to a friend. You have a box which is more than large enough to contain the object. You have several locks with keys. The box has a locking ring which is more than large enough to have a lock attached. But your friend does not have the key to any lock that you have. Note that you cannot send a key in an unlocked box, since it might be copied. How is this done?'
/*32*/,'Puzzle: A bookworm eats from the first page of an encyclopedia to the last page. The bookworm eats in a straight line. The encyclopedia consists of ten 1000-page volumes and is sitting on a bookshelf in the usual order. Not counting covers, title pages, etc., how many pages does the bookworm eat through? '
/*33*/,'Puzzle: There is a five letter word. It becomes shorter when you add 2 letters to it.'
/*34*/,'Puzzle: It is a dark and stormy night when three travelers must stop in hotel. They approach the front desk, where the front desk clerk informs them of the rate of \$30 for three men in one room. The men each hand over a \$10 bill for a total of \$30. They are given a key and go to their room. Moments later, the manager is informed of the transaction and reprimands the clerk, reminding him of the 3 men/1 room special of \$25 a night. The manager asks the clerk to refund the \$5 to the men. Taking five \$1 bills from the register, he goes to the men\'s room and knocks on the door. While he waits for the men to come to the door, he realizes a problem. How can he divide the 5 \$1 bills evenly among the men? When they answer the door, he tells them that there was a special that night and that the total bill only came to \$27. He gave them each \$1 as a refund, and the sneaky clerk made off with \$2 for himself. Though it seems everyone came out a winner, a problem occurs. In the beginning, \$30 was paid. In the end, however, the man had paid a collective \$27, and the clerk had \$2. \$27 + \$2 =\$29, not \$30. The question is: where is the extra dollar?'
/*35*/,'Puzzle: There are four men who would all like to cross a rickety old bridge. (Perhaps it is more accurate to say that they\'d like to get to the other side.) The old bridge will only support 2 men at a time, and it is night time, so every crossing must use the one flashlight that they all share. The four men each have different walking speeds; the fastest each of them can cross is 1 minute, 2 minutes, 5, minutes, and 10 minutes. If they pair up, since they must share the flashlight, they can only cross in the time that it would take the slower of the two. Given that the shortest time to get them all across is 17 minutes total, how should they all cross?'
/*36*/,'Puzzle: Say that we have a hallway with n lockers, numbered sequentialy from 1 to n. The lockers have two possible states, open and closed. Initially all the lockers are closed. The first kid who walks down the hallway flips every locker to the opposite state, that is, opens them all. The second kid flips the first locker door and every other locker door to the opposite state, that is, closes them. The third kid flips every third door, opening some, closing others. The fourth kid does every fourth door, etc. After n kids have passed down the hallway, which lockers are open, and which are closed?'
/*37*/,'Puzzle: Consider the sequence that begins with {1, 11, 21, 1211, 111221}.  Find a rule that describes the sequence, and give the next term.  Obviously, there are an unlimited number of rules that can describe the sequence.  '
/*38*/,'Puzzle: Let the letters: A, B, C, D, E, F, G, H, and I be representative of the numbers 1, 2, 3, 4, 5, 6, 7, 8, 9 in no particular order. If we let A+B+C=C+D+E=E+F+G=G+H+I=13, then what must E be?'
/*39*/,'Puzzle: Two brothers were running up an escalator which is moving up as well.  The older brother ran three times as quickly as his younger brother.  The older brother counted 75 step as he ran up while his brother counted 50 step.  How many steps in the visible part of the escalator?'
/*40*/,'Puzzle: There is a column of soldiers fifty feet long.  At the end of the line there is a dog. The dog begins to run forward at exactly the same time that the column begins to march forward.  The dog runs to the head of the column and then, without loosing any time he turns back and and runs towards the rear of the column. He gets to the end of the line of soldiers just as the column advances 50 feet. What is the distance covered by the dog? (Assume that both the dog and the soldiers travel at constant speeds.)'
/*41*/,'Puzzle: Two brothers were running up an escalator which is moving up as well.  The older brother ran three times as quickly as his younger brother.  The older brother counted 75 step as he ran up while his brother counted 50 step.  How many steps in the visible part of the escalator?'
/*42*/,'Puzzle: Bill Gates is about to give 3 distinct awards, 1 each, to 3 different distinguished developers. He needs to hand 1 award to each developer and then shake the developer\'s hand. However, all 4 people involved in this ceremony have a separate disease. If Bill shakes Developer 1\'s hand (without protection), Bill will contract Developer 1\'s disease and Developer 1 will contract Bill\'s disease (and so on for all of the others). The only protection Bill has available at this ceremony is a pair of normal, plain gloves. The ceremony cannot be delayed and Bill must think of a quick solution before he embarrasses himself. Given this information, how can Bill proceed?'
/*43*/,'Puzzle: How can you form 4 triangles with only 6 matches? You cannot light, bend, break, mutilate, etc... the matches. Nor can you overlap the matches.'
/*44*/,'Puzzle: There are two long wooden rods of arbitrary lengths.  Each takes an hour to burn and each burns at its constant rate.  Without measuring the length of the rods, how would you clock exact 45 min provided that you are given as many matchsticks as you need to burn the wood'
/*45*/,'Algorithm & Programming: Given an array of integers, find the contiguous subarray with the largest sum.'
/*46*/,'Algorithm & Programming: Given an array of length N containing integers between 1 and N, determine if it contains any duplicates.'
/*47*/,'Algorithm & Programming: Sort an array of size n containing integers between 1 and K, given a temporary scratch integer array of size K.'
/*48*/,'Algorithm & Programming: An array of size k contains integers between 1 and n. You are given an additional scratch array of size n. Compress the original array by removing duplicates in it. What if k << n?'
/*49*/,'Algorithm & Programming: An array of integers. The sum of the array is known not to overflow an integer. Compute the sum.  What if we know that integers are in 2\'s complement form?'
/*50*/,'Algorithm & Programming: An array of characters. Reverse the order of words in it.'
/*51*/,'Algorithm & Programming: An array of integers of size n. Generate a random permutation of the array, given a function rand_n() that returns an integer between 1 and n, both inclusive, with equal probability. What is the expected time of your algorithm?'
/*52*/,'Algorithm & Programming: An array of pointers to (very long) strings. Find pointers to the (lexicographically) smallest and largest strings.'
/*53*/,'Algorithm & Programming: Under what circumstances can one delete an element from a singly linked list in constant time?'
/*54*/,'Algorithm & Programming: Given a singly linked list, determine whether it contains a loop or not.'
/*55*/,'Algorithm & Programming: Given a singly linked list, print out its contents in reverse order. Can you do it without using any extra space?'
/*56*/,'Algorithm & Programming: Given a binary tree with  nodes, print out the values in pre-order/in-order/post-order without using any extra space.'
/*57*/,'Algorithm & Programming: Reverse a singly linked list recursively. The function prototype is node * reverse (node *) ; '
/*58*/,'Algorithm & Programming: Reverse the bits of an unsigned integer.'
/*59*/,'Algorithm & Programming: Compute the number of ones in an unsigned integer.'
/*60*/,'Algorithm & Programming: Compute the discrete log of an unsigned integer.'
/*61*/,'Programming: How do we test most simply if an unsigned integer is a power of two?'
/*62*/,'Programming: Set the highest significant bit of an unsigned integer to zero.'
/*63*/,'Algorithm & Programming: Let f(k) = y where k is the y-th number in the increasing sequence of non-negative integers with the same number of ones in its binary representation as y, e.g. f(0) = 1, f(1) = 1, f(2) = 2, f(3) = 1, f(4) = 3, f(5) = 2, f(6) = 3 and so on. Given k >= 0, compute f(k).'
/*64*/,'Algorithm & Programming: Write a function to check if two rectangles defined as below overlap or not.'
/*65*/,'Algorithm & Programming: Write a SetPixel(x, y) function, given a pointer to the bitmap. Each pixel is represented by 1 bit. There are 640 pixels per row. In each byte, while the bits are numbered right to left, pixels are numbered left to right. Avoid multiplications and divisions to improve performance.'
/*66*/,'Algorithm & Programming: You, a designer want to measure disk traffic i.e. get a histogram showing the relative frequency of I/O/second for each disk block. The buffer pool has b buffers and uses LRU replacement policy. The disk block size and buffer pool block sizes are the same. You are given a routine int lru_block_in_position (int i) which returns the block_id of the block in the i-th position in the list of blocks managed by LRU.  Assume position 0 is the hottest. You can repeatedly call this routine. How would you get the histogram you desire?'
/*67*/,'Algorithm & Programming: Implement a multiple-reader-single-writer lock given a compare-and-swap instruction. Readers cannot overtake waiting writers.'
/*68*/,'Puzzle: Given a rectangular (cuboidal for the puritans) cake with a rectangular piece removed (any size or orientation), how would you cut the remainder of the cake into two equal halves with one straight cut of a knife?'
/*69*/,'Algorithm & Programming: A character set has 1 and 2 byte characters. One byte characters have 0 as the first bit. You just keep accumulating the characters in a buffer. Suppose at some point the user types a backspace, how can you remove the character efficiently. (Note: You cant store the last character typed because the user can type in arbitrarily many backspaces)'
/*70*/,'Programming: What is the simples way to check if the sum of two unsigned integers has resulted in an overflow.'
/*71*/,'Algorithm & Programming: How do you represent an n-ary tree? Write a program to print the nodes of such a tree in breadth first order.'
/*72*/,'Algorithm & Programming: Write the \'tr\' program of UNIX. Invoked as tr -str1 -str2. It reads stdin and prints it out to stdout, replacing every occurance of str1[i] with str2[i].<br>e.g. tr -abc -xyz<br>"to be and not to be"<- input<br>"to ye xnd not to ye<- output'
/*73*/,'Algorithms: What\'s the difference between a linked list and an array?'
/*74*/,'Algorithms: Implement an algorithm to sort a linked list. Why did you pick the method you did?'
/*75*/,'Algorithms: Implement an algorithm to sort an array. Why did yo<br>u pick the method you did?'
/*76*/,'Algorithms: Implement strstr() , fprintf, printf(or some other string library function).'
/*77*/,'Algorithms: Reverse a string. Optimize for speed. Optimize for space.'
/*78*/,'Algorithms: Count the number of set bits in a number. Now optimize for speed. Now optimize for size.'
/*79*/,'Algorithms: How would you find a cycle in a linked list?'
/*80*/,'Algorithms: Give me an algorithm to shuffle a deck of cards, given that the cards are stored in an array of ints.'
/*81*/,'Algorithms: Write a function that takes in a string parameter and checks to see whether or not it is an integer, and if it is then return the integer value.'
/*82*/,'Algorithms: Write a function to print all of the permutations of a string.'
/*83*/,'Algorithms: Implement malloc.'
/*84*/,'Algorithms: Write a function to print the Fibonacci numbers.'
/*85*/,'Algorithms: Write a function to copy two strings, A and B. The last few bytes of string A overlap the first few bytes of string B.'
/*86*/,'Algorithms: How would you print out the data in a binary tree, level by level, starting at the top?'
/*87*/,'Puzzle & Programming: You are given a racing track(Formula I). Along the racing track are refueling stations(S<sub>0</sub> to S<sub>n-1</sub>). Each refueling station has 2 things.<br>&nbsp&nbsp&nbsp&nbsp 1. No of gallons available at that station AND <br>&nbsp&nbsp&nbsp&nbsp 2. No of miles to the next station.<br>Assuming the car you are driving travels M miles for every galon, you have to come up with a O(n) algorithm to pick the right starting point for your car, such that you will be able to complete a full lap(begin and end at the same station)'
/*88*/,'Algorithm & Programming: Given a non-verified BST(Binary search tree), write a C/C++ code to verify if the BST is a valid one or not(basic BST rule-->data of all nodes under left node <= data of current node <= data of all nodes under right node)'
/*89*/,'You are given a array, and a number M. Your goal is to find out which two numbers in the array when added up gives M'
);

var answers = Array(
/*1*/'9 balls 3[Set A] + 3[Set B] + 3 balls[Set C]<br>Compare A with B. It the pointer tilts one side, that corresponding set has the heavier ball, else C has the heavier ball. From whichever is the selected set, take 2 balls and compare them on the balance. If the pointer tilts, the corresponding ball is the heavier ball, or else the ball which was left out is the heavier one[Max 2 measurements]'
/*2*/,'Use same approach as above[3 measurements?]'
/*3*/,'Label the balls from 1 to 12 to identify them.Weigh 1, 2, 3, 4 against 5, 6, 7, 8:<br><br>1. If they balance, 9, 10, 11, 12 contain the odd ball.<br>\&nbsp\&nbsp\&nbsp\&nbsp Weigh 6, 7, 8 against 9, 10, 11.<br>\&nbsp\&nbsp\&nbsp\&nbsp 1. If they balance, 12 is the odd ball. Weigh 12 against any other ball to discover whether it is heavy or light.<br>\&nbsp\&nbsp\&nbsp\&nbsp 2. If 9, 10, 11 are heavy, they contain an odd heavy ball. Weigh 9 against 10. If they balance, 11 is the odd heavy ball, otherwise the heavier of 9 and 10 is the odd ball.<br>\&nbsp\&nbsp\&nbsp\&nbsp 3. If 9, 10, 11 are light, we use the same procedure to reach the same conclusion for the odd light ball.<br><br>2. If 5, 6, 7, 8 are heavy, either they contain an odd heavy ball or 1, 2, 3, 4 contain an odd light ball.<br>Weigh 1, 2, 5 against 3, 6, 10.<br>\&nbsp\&nbsp\&nbsp\&nbsp 1. If they balance, the odd ball is 4 (light) or 7 or 8 (heavy). Weigh 7 against 8. If they balance 4 is light, otherwise the heavier of 7 and 8 is the odd heavy ball.<br>\&nbsp\&nbsp\&nbsp\&nbsp 2. If 3, 6, 10 are heavy, the odd ball can be 6 (heavy) or 1 or 2 (light). Weigh 1 against 2. If they balance 6 is heavy, otherwise the lighter of 1 and 2 is the odd light ball.<br>\&nbsp\&nbsp\&nbsp\&nbsp 3. If 3, 6, 10 are light, the odd ball is 3 and light or 5 and heavy. We thus weigh 3 against 10. If they balance, 5 is heavy, otherwise 3 is light.<br><br>3. If 5, 6, 7, 8 are light we use a similar procedure to that in II.<br>'
//,<a href src="" onLoad="http://www.livejournal.com/users/premj/2770.html">
/*4*/,'Man + chicken <br>Man <br>Man + Fox <br>Man + chicken <br>Man + Sack of corn <br>Man <br>Man + chicken <br>6 trips'
/*5*/,'Switches[S1, S2, S3]<br>Put on S1 & S2<br>Wait for some time and turn off switch S2<br>Go upstairs, the bulb which is burning corresponds to switch S1. Touch the other two bulbs. The one, which is warmer, corresponds to switch S2 and the colder one to S3.'
/*6*/,'When A says NO it means one of the following<br>B-Black C-Black (or)<br>B-Black C-White (or)<br>B-White C-Black<br><br>When B says NO it means that Cs hat is Black(Cause he is not sure what is his hat color, as it could be either black or white)<br>So Cs hat color is Black'
/*7*/,'Ask any of the twins ?What direction will the other person point to when asked for the direction to the hospital ?, and do the opposite of what he says.'
/*8*/,'eight, five, four, nine, one, seven, six,<br>Numbers in alphabetical order<br>So next in series is 3'
/*9*/,'Take 1 ball from 1st bag, 2 from 2nd, 3 from 3rd, and so on till 10 from the 10th bag<br>Theoretically if all bags had same weight balls, the total weight will be<br>(1+2+3+4+5+6+7+8+9+10)*10 = 550<br>For example, lets say the 5th bag has the 9 kg balls, so adjusted weight will be<br>(1+2+3+4+6+7+8+9+10)*10 + 5 * 9= 545<br>So 550 ? actual weight of all the balls = the bag number which has the 9 kg balls'
/*10*/,'Allow both hour glasses to run at same time. By the time the 4 minute HG drains, 3mins will be left in the 7 min HG<br>Repeat similar process and the num<br>4 Min HG 7 Min HG<br>1 0<br>0 6<br>0 2<br>2 0<br>Now allow the 7 minute to drain, followed by the 2 mins left in the 4 min HG'
/*11*/,'Join the centers of the original and the removed rectangle.'
/*12*/,''
/*13*/,'There are multiple solutions to this.<br>1. Sort array-->parse sorted array to find duplicates<br>2. Could use bit vector technique'
/*14*/,''
/*15*/,'\#define POWER_OF_TWO(num) (\!((num)&(num-1)))<br>'
/*16*/,'1. Write a string_reverse function(which takes start & end indexes to reverse)<br>2. Do a reverse of ENTIRE STRING<br>3. GO thru the reversed string, and for every word encountered, call string_reverse(with the appropriate start \& end indexes)'
/*17*/,'innumerable!! Though it sounds like the answer is 1(in the north pole), in actuality you can have multiple points in the south pole(example: So you start from point A, walk 1 mile south, and reach point B (where the circumference(centered around north pole) is 1 mile) , you walk 1 mile east(you end up at the same point B), then you walk 1 mile north and end up at A )'
/*18*/,'The idea to use here is: when you subtract 1 from a number n, you end up with a result that has all the bits reversed till the first set bit. Example 20 is 10100 and 19 is 10011. So taking advantage of this we can write this piece of code<br><br>int CountSetBits(int num){<br>&nbsp&nbsp&nbsp&nbsp int num_ones=0;<br>&nbsp&nbsp&nbsp&nbsp while(num){<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp num & (num-1);<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ++num_ones;<br>&nbsp&nbsp&nbsp&nbsp }<br>&nbsp&nbsp&nbsp&nbsp return num_ones;<br>}'
/*19*/,''
/*20*/,'n<<3 - n = 7n'
/*21*/,''
/*22*/,'void string_reverse(char* str)<br>{<br>&nbsp&nbsp&nbsp&nbsp int len=strlen(str);<br>&nbsp&nbsp&nbsp&nbsp for(int i=0;i<len/2;++i){<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp char tmp =  a[i];<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp a[i] = a[len-1-i];<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp a[len-1-i] = tmp;<br>&nbsp&nbsp&nbsp&nbsp}<br>}<br><br>void string_reverse_noindex(char* str)<br>{<br>&nbsp&nbsp&nbsp&nbsp int len=strlen(str);<br>&nbsp&nbsp&nbsp&nbsp for(int i=0;i<len/2;++i){<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp char tmp =  *(a+i);<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp *(a+i) = *(a+len-1-i);<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp *(a+len-1-i) = tmp;<br>&nbsp&nbsp&nbsp&nbsp}<br>}<br>'
/*23*/,''
/*24*/,''
/*25*/,''
/*26*/,'Find out time taken for trains to collide --> Multiply that with 2 to get No of miles travelled by the bird'
/*27*/,''
/*28*/,'Lets say weight of each normal pill is m. Take 1 pill from 1st jar, 2 from 2nd, 3 from 3rd \& 4 from fourth jar --> Weigh it(lets say weight is M grams) --> (M - (10*m))+1 gives the jar number which has the contaminated pill'
/*29*/,'1. Fill 5 lit pail to full<br>2. pour 3 lit in 3_lit_pail(left with 2 lit in 5_lit_pail)<br>3. Pour the 2 lit into 3_lit_pail<br>4. Fill 5_lit_pail to full<br>5. top the 3_lit_pail(basically remove 1 lit from 5_lit_pail)<br>6. You are left with 4 lit in 5_lit_pail'
/*30*/,''
/*31*/,''
/*32*/,''
/*33*/,''
/*34*/,''
/*35*/,''
/*36*/,''
/*37*/,'Each number reads the previous number. For example the 4th number in series is how you would read the 3rd number(21....is read like there is one number 2, and a one number 1(and so 1211))'
/*38*/,''
/*39*/,''
/*40*/,''
/*41*/,''
/*42*/,''
/*43*/,''
/*44*/,''
/*45*/,''
/*46*/,''
/*47*/,''
/*48*/,''
/*49*/,''
/*50*/,''
/*51*/,''
/*52*/,''
/*53*/,''
/*54*/,''
/*55*/,''
/*56*/,''
/*57*/,''
/*58*/,''
/*59*/,''
/*60*/,''
/*61*/,''
/*62*/,''
/*63*/,''
/*64*/,''
/*65*/,''
/*66*/,''
/*67*/,''
/*68*/,''
/*69*/,''
/*70*/,''
/*71*/,''
/*72*/,''
/*73*/,''
/*74*/,''
/*75*/,''
/*76*/,''
/*77*/,''
/*78*/,''
/*79*/,''
/*80*/,''
/*81*/,''
/*82*/,''
/*83*/,''
/*84*/,''
/*85*/,''
/*86*/,''
/*87*/,''
/*88*/,''
/*89*/,''
/*90*/,''
/*91*/,''
/*92*/,''
/*93*/,''
/*94*/,''
/*95*/,''
/*96*/,''
/*97*/,''
/*98*/,''
/*99*/,''
/*100*/,''
);

print_puzzles_qa(questions,answers);
}

function star_ajaxFunction (url1)
{
  var xmlHttp;

  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
    xmlHttp.onreadystatechange=function()
    {
      if(xmlHttp.readyState==4)
      {
         var img1 = "";
         var element_id = "";
        var firstTwoChars = xmlHttp.responseText.substring(0,2);
        //var id = "";
        if(firstTwoChars=="un"){
            //UNSUBSCRIBED
            element_id = "m_"+ xmlHttp.responseText.substring(13,50) +"_id";
            img1 = "images/star_inactive.png";
         }
         else{
            //SUBSCRIBED
            element_id = "m_"+ xmlHttp.responseText.substring(11,50) +"_id";
            img1 = "images/star_active.png";
         }
         var v1 = document.getElementById(element_id);
         v1.src = img1;
      }
      else{
      }
    }
    xmlHttp.open("GET",url1,true);
    xmlHttp.send(null);
}

function star_Function (board_id)
{
   var v1 = document.getElementById("m_"+board_id+"_id");
   var name = "subscriptions";
   var subs = Get_Cookie(name);
   Set_Cookie(name, board_id, 100, "", "", "") 
   if(subs == null){
      Set_Cookie(name, board_id, 100, "", "", "") 
      v1.src = "http://premski.com/images/star_active.png";
   }
   else{
      //alert(subs);
      var subscriptions_array = subs.split(",");
      var final_cookie_string = "";
      var is_board_already_subscribed = false;
      for (var i in subscriptions_array) {
         if(subscriptions_array[i] == board_id){
            is_board_already_subscribed = true;
         }
         else{
            final_cookie_string += (final_cookie_string=="")? subscriptions_array[i]:","+subscriptions_array[i];
         }
      }
      if(!is_board_already_subscribed){
         final_cookie_string += ","+board_id;
      }
      Set_Cookie(name, final_cookie_string, 100, "", "", "");
      var img1 =  (is_board_already_subscribed)? "http://premski.com/images/star_inactive.png":"http://premski.com/images/star_active.png";
      v1.src = img1;
   }
}

function Set_Cookie( name, value, expires, path, domain, secure ) 
{
   // set time, it's in milliseconds
   var today = new Date();
   today.setTime( today.getTime() );
   
   /*
   if the expires variable is set, make the correct 
   expires time, the current script below will set 
   it for x number of days, to make it for hours, 
   delete * 24, for minutes, delete * 60 * 24
   */
   if ( expires )
   {
   expires = expires * 1000 * 60 * 60 * 24;
   }
   var expires_date = new Date( today.getTime() + (expires) );
   
   document.cookie = name + "=" +escape( value ) +
   ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
   ( ( path ) ? ";path=" + path : "" ) + 
   ( ( domain ) ? ";domain=" + domain : "" ) +
   ( ( secure ) ? ";secure" : "" );
}

// this function gets the cookie, if it exists
function Get_Cookie( name ) {	
   var start = document.cookie.indexOf( name + "=" );
   var len = start + name.length + 1;
   if ( ( !start ) &&
   ( name != document.cookie.substring( 0, name.length ) ) )
   {
   return null;
   }
   if ( start == -1 ) return null;
   var end = document.cookie.indexOf( ";", len );
   if ( end == -1 ) end = document.cookie.length;
   return unescape( document.cookie.substring( len, end ) );
}

function trim(str)
{
	return str.replace(/^\s+|\s+$/g,"");
}
    
function validate_captcha(form, correct_answer, check)
{
	var question_title = trim(document.prem_form.question_title.value);
	var question = trim(document.prem_form.question.value);
	if((question_title=="") && (question=="")){
		alert("Empty text!");
		return false;
	}
	if(check==1){
		var captcha_answer = trim(document.prem_form.captcha_answer.value);
		captcha_answer = hex_md5(captcha_answer);
		if(correct_answer == captcha_answer){
			form.submit();
		}
		else{
			alert("Invalid answer!");
		}
	}
	else{
		form.submit();
	}
	return false;
}