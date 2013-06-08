<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_KaosKece = "localhost";
$database_KaosKece = "kaoskece";
$username_KaosKece = "root";
$password_KaosKece = "";
$KaosKece = mysql_pconnect($hostname_KaosKece, $username_KaosKece, $password_KaosKece) or trigger_error(mysql_error(),E_USER_ERROR); 
?>