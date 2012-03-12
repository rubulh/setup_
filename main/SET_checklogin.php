<?php
/*************************************************************************
function SET_checklogin();
checks if the login and pass so passed matches that Tin the table
if yes unit logs the user in
hashed password checked 
mysql extension used so assumed that the connection is already there st the start of the script
escaping and all other stuff is done in here
*/

function SET_checklogin($USERNAME,$PASS)
{
global $SET_THEMYSQLHOSTNAME;
global $SET_THEMYSQLUSERNAME;
global $SET_THEMYSQLPASSWORD;
global $SET_THEMYSQLDBNAME;
global $SET_THEMYSQLLOGINTABLE;
global $SET_COOKIEEXPIRY;
global $SET_THEMULTIPLELOGIN;
global $SET_BASIC_MYSQL_CONNECT;
global $SET_BASIC_SELECT_DATABASE;
  $USERNAME=mysql_real_escape_string($USERNAME);
  $HASHEDPASS=mysql_real_escape_string(md5(mysql_real_escape_string($PASS)));
  $query_checklogin=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE WHERE NAME='$USERNAME'");
  if(mysql_error())
		{
      error_log("[[[[[[[SET]>>>".mysql_error());
		}
  $answer_checklogin=mysql_fetch_array($query_checklogin);
  $ansagain_checklogin=mysql_fetch_array($query_checklogin);
  if(($ansagain_checklogin))
    {
	$useridfirst=$answer_checklogin['USERID'];
	$useridsecond=$ansagain_checklogin['USERID'];
      error_log("[[[[[[SET]>>>MULTIPLE ENTRIES FOUND FOR SAME USERNAME AND USERID ($USERNAME,$useridfirst,$useridsecond)");
      SET_whisk(73);
      return 0;
    }
$answer_checklogin_AFTER=false;
$thereturnedpass=$answer_checklogin['PASSWORD'];
if($thereturnedpass==$HASHEDPASS)$answer_checklogin_AFTER=true;
var_dump($thereturnedpass,$HASHEDPASS);
  if(!$answer_checklogin_AFTER)
    {
      return 0;
      exit(1);
    }
  else if($answer_checklogin_AFTER)
    {
	$theloggedin=$answer_checklogin['LOGGED'];
	if($SET_THEMULTIPLELOGIN)return 1;
	else if(!$SET_THEMULTIPLELOGIN)
		{
			if((!$theloggedin))return 1;
			else return 7;
		}
    }
}

?>