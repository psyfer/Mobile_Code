<?php
/*************************************************************************
PHP Version: 5.0.4 Xampp
ui name:export to a excel file
Description: select period and the vendor
Version Date: 1.0 21.09.2006      
Author: Pasan Rajapaksha
**************************************************************************/
//mysql quary to be executed to transfer data to excel file 
$sql=stripslashes($_REQUEST["sql"]);


define(db_host, "localhost"); 
define(db_user, "root"); 
define(db_pass, ""); 
define(db_link, mysql_connect(db_host,db_user,db_pass)); 
define(db_name, "downloadzone"); 
mysql_select_db(db_name); 

//$select = "SELECT * FROM gree_log";                 
$export = mysql_query($sql); 
$fields = mysql_num_fields($export); 

for ($i = 0; $i < $fields; $i++) { 
    $header .= mysql_field_name($export, $i) . "\t"; 
} 

while($row = mysql_fetch_row($export)) { 
    $line = ''; 
    foreach($row as $value) {                                             
        if ((!isset($value)) OR ($value == "")) { 
            $value = "\t"; 
        } else { 
            $value = str_replace('"', '""', $value); 
            $value = '"' . $value . '"' . "\t"; 
        } 
        $line .= $value; 
    } 
    $data .= trim($line)."\n"; 
} 
$data = str_replace("\r","",$data); 

if ($data == "") { 
    $data = "\n(0) Records Found!\n";                         
} 
//getting the date
$now_date = date('m-d-Y');
//geting the type e.g=greeting tone etc
if($_REQUEST["id"]==1)$type="greeting_log";
else if($_REQUEST["id"]==2)$type="animation_log";
else if($_REQUEST["id"]==3)$type="animatedgreeting_log";
else if($_REQUEST["id"]==4)$type="game_log";
else if($_REQUEST["id"]==5)$type="theme_log";
else if($_REQUEST["id"]==6)$type="tone_log";
else if($_REQUEST["id"]==7)$type="wallpaper_log";

header("Content-type: application/x-msdownload"); 
header("Content-Disposition: attachment; filename=".$now_date."_".$type.".xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
print "$header\n$data";  
?> 
