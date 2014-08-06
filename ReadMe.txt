MSLA (Light ModSecurity Log Auditor) Project By AmirMohammad Sadeghian
http://www.root25.com


SETUP:

1.Copy all the files inside the zip package to your server path.

2.create a database and import the "modsec_db.sql" file into your database.

3.open config.php in a text editor and change the Database name,username,password,host and the Mod_security log path.

4.run the Parser.php from your browser ( it might take some times it depends on how big is your log file)

5.after the parser.php fully loaded and page become Done , open the index.php

6.input the username and password as following for going into the dashboard.

username:root25.com
password:ssap25

7.For drawing the graphs it need some times. 

""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
IMPORTANT: This script need internet access for drawing the charts because i use Google API's for the charts.

""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""


As i mentioned before this was a student project , so you can change any parts based on your own need.
the hardest part and heart of this script are the patterns inside the "patterns.php" that will help to
find and extract specific parts from the log.
"useragent.php" will extract the details of os and browser from the user-agent information in the log.


if you had any question or any comment please refer to: http://goo.gl/5F4yu
