<?php
error_reporting("Off");
require_once('config.php');
$con=mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_name);
include_once('useragent.php');
include_once('patterns.php');
////////////////////////////////////////////
//***********************Fatal error: Maximum execution time of 30 seconds exceeded in /// clean the code
/////////////


//	echo("&ltbr>".$file."&ltbr>");
if (file_exists($file)) {
	$fp = fopen( $file, "r" );
	
	$i = 0;
	while (!feof($fp)) {
		set_time_limit(0); // for increasing the execution time
		// do some processing with the line!
		$line=fgets($fp);//read 1line
		$error_block.=$line;
		$flag=preg_match_all("/^--([0-9a-fA-F]{8,})-([Z])--$/", $line);
		if($flag){
			parse_block($error_block);
			$error_block="";
			$flag=0;
		}
		$i++;
}
	if(!$fp){
		echo "Couldn't open the data file. Try again later.";
		exit;
	}else{
		// echo("Content&ltbr>".$theData);
	}
}
fclose($fp);



/*
foreach ($lines as $line_num => $line) {
	$error_block.=$line;
	$flag=preg_match_all("/^--([0-9a-fA-F]{8,})-([Z])--$/", $line);
	if($flag){
		parse_block($error_block);
		$error_block="";
		$flag=0;
	}
}

*/
?>
