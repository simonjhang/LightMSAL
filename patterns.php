<?php
function parse_block($block){
		preg_match_all("/^--([0-9a-fA-F]{8,})-([Z])--$/", $line);
		preg_match("/((?:(?:[0-2]?\\d{1})|(?:[3][01]{1}))[-:\\/.](?:Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|Jun(?:e)?|Jul(?:y)?|Aug(?:ust)?|Sep(?:tember)?|Sept|Oct(?:ober)?|Nov(?:ember)?|Dec(?:ember)?)[-:\\/.](?:(?:[1]{1}\\d{1}\\d{1}\\d{1})|(?:[2]{1}\\d{3})))(?![\\d])/",$block,$matches); // Date
		$date=$matches[0];
		preg_match("/[0-9]{2}:[0-9]{2}:[0-9]{2}\s/",$block,$matches); // Time
		$time=$matches[0];
		preg_match("/([a-zA-Z]{2}\s)([0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3})\s([0-9]*)\s([0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3})\s([0-9]*)/",$block,$matches); // IP's & Port's
		$source_ip=$matches[2];
		$source_port=$matches[3];
		$dest_ip=$matches[4];
		$dest_port=$matches[5];
		preg_match("/\s(GET)(.*)(\sHost)/",$block,$matches); // GET Header Address
		$get_address=$matches[2];
		preg_match("/\s(User-Agent:\s)(.*)(\sAccept:)/",$block,$matches); // User Agent
		$user_agent=$matches[2];
		//preg_match("/\s\[(tag\s\")(.*)(\"])\s/",$block,$matches); // message Tags(Attack Type)
		//$message_tags=$matches;
		preg_match("/(\[msg)(.*?)(\"\])/",$block,$matches); //  message
		$message=$matches[2];
		preg_match("/(-H--\sMessage:\s)(.*)(]\s)/",$block,$matches); // detailed message
		$detailed_message=$matches[2];
		
		//echo("Date:".$date."<br>Time:".$time."<br>Attacker IP:".$attacker_ip."<br>Attacker Port:".$attacker_port."<br>Server IP:".$server_ip."<br>server port:".$server_port."<br>GET Adress:".$get_address."<br>User Agent:".$user_agent."<br>Message:".$message."<br>Detailed Message:".$detailed_message."<br><br><br>");
		$ua=useragent_parser($user_agent);// parsing user agent for browser & os
		$browser=$ua['name'];//browser
		$os=$ua['platform'];//os 
		mysql_query("insert into log (`date`,`time`,`source_ip`,`source_port`,`dest_ip`,`dest_port`,`get_adr`,`os`,`browser`,`message`,`detailed_message`)values('$date','$time','$source_ip','$source_port','$dest_ip','$dest_port','$get_address','$os','$browser','$message','$detailed_message')");
		
}
?>