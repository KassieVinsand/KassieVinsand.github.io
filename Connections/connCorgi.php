<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connCorgi = "localhost";
$database_connCorgi = "blog";
$username_connCorgi = "bloguser";
$password_connCorgi = "password";
$connCorgi = mysql_pconnect($hostname_connCorgi, $username_connCorgi, $password_connCorgi) or trigger_error(mysql_error(),E_USER_ERROR); 
?>