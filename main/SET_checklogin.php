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
  require_once("SET_mysqlconnection.php");
  $USERNAME=mysql_real_escape_string($USERNAME);
  $HASHEDPASS=mysql_real_escape_string(md5(mysql_real_escape_string($PASS)));
  $query_checklogin=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE WHERE NAME='$USERNAME' and PASSWORD='$HASHEDPASS'")
  $answer_checklogin=mysql_fetch_array($query_checklogin);
  $ansagain_checklogin=mysql_fetch_array($query_checklogin);
  if(($ansagain_checklogin))
    {
      error_log("[[[[[[SET]>>>MULTIPLE ENTRIES FOUND FOR SAME USERNAME AND PASSWORD ($USERNAME,$HASHEDPASS)");
    }
  if(!$answer_checklogin)
    {
      return false;
      exit(1);
    }
  else if($answer_checklogin)
    {
      $theloggedin=$answer_checklogin['LOGGED'];
      if((!$SET_THEMULTIPLELOGIN) && ($theloggedin))
	{
		return "ALREADYLOGGED";
		exit(1)
	}
      return true;
      exit(1);
    }
}

?>