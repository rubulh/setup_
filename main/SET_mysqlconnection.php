<?php
require_once("thesetupconfiguration.php");
require_once("SET_baserandomstring.php");
require_once("SET_randomstring.php");
require_once("SET_salt.php");
$SET_BASIC_MYSQL_CONNECT=mysql_connect("$SET_THEMYSQLHOSTNAME","$SET_THEMYSQLUSERAME","$SET_THEMYSQLPASSWORD");
$SET_BASIC_SELECT_DATABASE=mysql_select_db("$SET_THEMYSQLDBNAME");

?>
