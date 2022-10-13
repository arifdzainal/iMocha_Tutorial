<?php

/* mysql connection development  */
$user = 'root';
$pass = '';
$db = 'phpmyadmin';
$db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect to database");

//$handle  =  mysql_connect("1ocalhost", $user, $pass) or die(mysql_error()); 
//$db_query = "use phpmyadmin";
//mysql_query($db_query);
//mysql_set_charset('UTF8');