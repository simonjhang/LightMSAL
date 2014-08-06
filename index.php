<?php
session_start();
error_reporting("Off");
require_once('config.php');
$con=mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_name);
$do=$_REQUEST["do"];
if($do=="login"){
	$user=$_POST["username"];
	$pass=$_POST["password"];
	$user=mysql_real_escape_string($user);
	$pass=sha1($pass);
	$res=mysql_query("select * from `mod` where user='$user' and pass='$pass'");
	echo("select * from `mod` where user='$user' and pass='$pass'");
	$cnt=mysql_num_rows($res);
	if($cnt==1){
		$_SESSION["modsec"]=1;
	 	header("location:index.php");
	}
	
}else if($do=="logout"){
	$_SESSION["modsec"]=0;
	session_destroy();
	 header("location:index.php");
}

/////calc attack chart

/////
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Light MSLA Project By Amir Sadeghian root25.com</title>
<style type="text/css">
#cleft {
	width: 8%;
	float: left;
	background-color: #FFF;
	color: #F00;
	height: 900px;
}
#cmain {
	width: 100%;
	float: left;
	text-align: center;
}
#cmiddle {
	float: left;
	width: 100%;
	background-color: #FFF;
	color: #F00;
}
body {
	background-color: #000;
}
body,td,th {
	color: #000;
	font-family: Arial;
	text-align: center;
}
.black_txt {
	color: #000;
}
.white_txt {
	color: #FFF;
}
a:link {
	color: #FFF;
}
a:visited {
	color: #FFF;
}
a:hover {
	color: #F00;
}
</style>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
    
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['gauge']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
		  <?php
			function get_memory() {
			  foreach(file('/proc/meminfo') as $ri)
				$m[strtok($ri, ':')] = strtok('');
			  return 100 - round(($m['MemFree'] + $m['Buffers'] + $m['Cached']) / $m['MemTotal'] * 100);
			}
			$memory_usage=get_memory();
			
			$output = shell_exec('cat /proc/loadavg'); 
			$loadavg = substr($output,0,strpos($output," ")); 
			$cpu_usage=$loadavg*1;
			echo("['Memory',".$memory_usage."],");
			echo("['CPU',".$cpu_usage."]");
			?>
        ]);

        var options = {
          title: 'Resource Usage',
          width: 400, height: 120,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('usages'));
        chart.draw(data, options);
      }
    </script>
    
    
    <script type="text/javascript">
	 google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php
		  $res=mysql_query("select distinct message from log");
			$i=0;
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			set_time_limit(0); // for increasing the execution time
				$message=$row["message"];
				$attack[$i]["name"]=$message;
					$res2=mysql_query("select id from log where message='$message'");
					$numb=mysql_num_rows($res2);
				$attack[$i]["number"]=$numb;
				$i++;
			}
		  /////////
		for($j=0;$j<$i;$j++){
			if($attack[$j]["name"]==""){$attack[$j]["name"]="Unkown";}
			if($i==$j){
				echo("['".$attack[$j]["name"]."',".$attack[$j]["number"]."]");
			}else{
				echo("['".$attack[$j]["name"]."',".$attack[$j]["number"]."],");
			}
		}
		?>
        ]);

        var options = {
          title: 'Attacks',
		  fontSize:'12',
		  //is3D:'true',
          width:'1200',
          height:'600'
        };

        var chart = new google.visualization.PieChart(document.getElementById('attacks'));
        chart.draw(data, options);
      }
    </script>
    
    
    
       <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Attack');
		data.addColumn('number', 'Amount');
        data.addRows([
		  <?php
		  $res=mysql_query("select distinct message from log");
			$i=0;
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			set_time_limit(0); // for increasing the execution time
				$message=$row["message"];
				$attack[$i]["name"]=$message;
					$res2=mysql_query("select id from log where message='$message'");
					$numb=mysql_num_rows($res2);
				$attack[$i]["number"]=$numb;
				$i++;
			}
		  /////////
		for($j=0;$j<$i;$j++){
			if($attack[$j]["name"]==""){$attack[$j]["name"]="Unkown";}
			if($i==$j){
				echo("['".$attack[$j]["name"]."',".$attack[$j]["number"]."]");
			}else{
				echo("['".$attack[$j]["name"]."',".$attack[$j]["number"]."],");
			}
		}
		?>
        ]);
		 var options = {
          sort: 'enable',
        };
        var table = new google.visualization.Table(document.getElementById('attacks2'));
        table.draw(data, {showRowNumber: true});
      }
    </script>
    
    
    
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Day', 'Attacks'],
           <?php
		  $res=mysql_query("select distinct `date` from log order by `date` asc");
			$i=0;
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			set_time_limit(0); // for increasing the execution time
				$ops=$row["date"];
				$date[$i]["name"]=$ops;
					$res2=mysql_query("select id from log where `date`='$ops'");
					$numb=mysql_num_rows($res2);
				$date[$i]["number"]=$numb;
				$i++;
			}
		  /////////
		for($j=0;$j<$i;$j++){
			if($date[$j]["name"]==""){$date[$j]["name"]="Unkown";}
			if($j==$i){
				echo("['".$date[$j]["name"]."',".$date[$j]["number"]."]");
			}else{
				echo("['".$date[$j]["name"]."',".$date[$j]["number"]."],");
			}
		}
		?>
        ]);

        var options = {
          title: 'Attacks Per Day',
		  colors:['#FFCC00'],
        };

        var chart = new google.visualization.AreaChart(document.getElementById('cal'));
        chart.draw(data, options);
      }
    </script>

    
    
    
   <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year',  'Expenses'],
          <?php
		  $res=mysql_query("select distinct os from log");
			$i=0;
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			set_time_limit(0); // for increasing the execution time
				$ops=$row["os"];
				$os[$i]["name"]=$ops;
					$res2=mysql_query("select id from log where os='$ops'");
					$numb=mysql_num_rows($res2);
				$os[$i]["number"]=$numb;
				$i++;
			}
		  /////////
		for($j=0;$j<$i;$j++){
			if($os[$j]["name"]==""){$os[$j]["name"]="Unkown";}
			if($j==$i){
				echo("['".$os[$j]["name"]."',".$os[$j]["number"]."]");
			}else{
				echo("['".$os[$j]["name"]."',".$os[$j]["number"]."],");
			}
		}
		?>
        ]);

        var options = {
          title: 'Opreating Systems'
        };

        var chart = new google.visualization.BarChart(document.getElementById('os'));
        chart.draw(data, options);
      }
    </script>
    
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year',  'Expenses'],
          <?php
		  $res=mysql_query("select distinct browser from log");
			$i=0;
			while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			set_time_limit(0); // for increasing the execution time
				$ops=$row["browser"];
				$browser[$i]["name"]=$ops;
					$res2=mysql_query("select id from log where browser='$ops'");
					$numb=mysql_num_rows($res2);
				$browser[$i]["number"]=$numb;
				$i++;
			}
		  /////////
		for($j=0;$j<$i;$j++){
			if($browser[$j]["name"]==""){$browser[$j]["name"]="Unkown";}
			if($j==$i){
				echo("['".$browser[$j]["name"]."',".$browser[$j]["number"]."]");
			}else{
				echo("['".$browser[$j]["name"]."',".$browser[$j]["number"]."],");
			}
		}
		?>
        ]);

        var options = {
          title: 'Browsers',
		  colors:['#66CCFF'],
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('browser'));
        chart.draw(data, options);
      }
    </script>
</head>

<body>
<span class="white_txt">[Light MSLA]</span><br>
<?php
if(!isset($_SESSION["modsec"])){
?>
<br>
<br>
<div><center>
  <form id="form1" name="form1" method="post" action="index.php?do=login">
    <label for="username" class="white_txt">Username</label>
    <input type="text" name="username" id="username" />
    <br />
    <br />
    <label for="password" class="white_txt">Password</label>
    <input type="password" name="password" id="password" />
    <br />
    <br />
    <input type="submit" name="button" id="button" value="Login" />
  </form></center>
</div>
<?php
}else {
?>
<span class="white_txt"> Welcomge to [Light ModSecurity Log Auditing] Dashbord (<a href="?do=logout">log out</a>)</span><br>
<br>
<div id="cmain">
  <div id="cmiddle"><div id="usages"></div></div>
</div>
<div class="black_txt">.</div>
<div id="cmain">
  <div id="cmiddle"><div id="attacks"></div></div>
</div>
<div class="black_txt">.</div>
<div id="cmain">
  <div id="cmiddle"><div id="attacks2"></div></div>
</div>
<div class="black_txt">.</div>
<div id="cmain">
  <div id="cmiddle"><div id="cal"></div></div>
</div>
<div class="black_txt">.</div>
<div id="cmain">
  <div id="cmiddle"><div id="os"></div></div>
</div>
<div class="black_txt">.</div>
<div id="cmain">
  <div id="cmiddle"><div id="browser"></div></div>
</div>
<div class="black_txt">.</div>
<div id="cmain">
  <div id="cmiddle"><div id="geo"></div></div>
</div>
<?php
}
?> <br>
<br>
<br>
<br>
<center>
<span class="white_txt">Light  ModSecurity Log Auditor project by AmirMohammad Sadeghian.<br>
Copyright 2012 By AmirMohammad Sadeghian ( <a href="http://www.root25.com/">root25.com</a> )</span></center>

</body>
</html>