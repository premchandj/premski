<?php
$feed = "http://www.bloglines.com/export?id=premchandj";
//$str = file_get_contents("/home/prem/personal/ws/bloglines.rss");
$str = file_get_contents($feed);

$lines_array = explode("\n", $str);
$first_array_value = 0;
print "var bloglines_menu_array = Array(\n";
print "',<b>Blogroll</b>,,font-family:Times New Roman;font-size:125%'\n";
foreach($lines_array as $line){
   $arr = array();
   if(strpos($line,"outline text=")!=false){
      strip_line($line, $arr, '>');
      if($first_array_value==0){
         print ",";
      }
      print "' ,<b>".$arr['text']."</b>,,font-family:Times New Roman;font-size:90%;h5'\n";
      $first_array_value = 0;
   }
   elseif(strpos($line,"outline title=")!=false){
      strip_line($line, $arr, "/>");
      print ",'  ,<b>".$arr['title']."</b>,".$arr['htmlUrl'].",font-family:Times New Roman;font-size:75%'\n";
   }
}
print ");\n";

function strip_line($str, &$out_array, $end_delimiter='>')
{
   $arr1 = explode("<outline", $str);
   $arr2 = explode($end_delimiter, $arr1[1]);
   $arr2[0] = trim($arr2[0]);
   $arr2 = explode("\"", $arr2[0]);
   $key = "";
   $value = "";
   $key_str = 1;
   foreach($arr2 as $str){
      $str = trim($str);
      $p1 = strpos($str, '=');
      if($p1 != false){
         $str = substr($str, 0, $p1);
      }
      if($key_str){$key = $str;}
      else{
         if($key != ""){
            $str1 = "";
            $arr3 = explode("'", $str);
            foreach($arr3 as $i){
               $str1 .= ($str1=="")? $i:"\\'".$i;
            }
            $out_array[$key] = $str1;
         }
         $key = "";
      }
      $key_str = ($key_str==1)? 0:1;
   }
}
?>
