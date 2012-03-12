<?php
/*
regenerate function
if the session is not set but the cookies are set this function is executed
sets the session again and updates the database
for each execution of this function the error log is updated 
works inside the iflogged function so no need of any session set statement
moreover the function has to return false 
the responsibilty of removing the session handle and related stuff ll be done by the calling function
*/
function SET_regenerate($USERID)
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

	//first check the details
	$isthesessionset=false;
	$isthecookieset=false;
	{
	  if($_SESSION['authkey'] && session_id())
		{
		$isthesessionset=true;
		}
	}
 	if($isthesessionset)
	{
	error_log("[[[[[[[SET]>>>the session ids are set still the iflogged allowed the control to come upto the regenerate for the USERID($USERID)");
	return false;
	}
	
	else
	{
	  if(($_COOKIE['base'])&&($_COOKIE['userid'])&&$_COOKIE['authkey'])
		{
		$isthecookieset=true;
		}
	  if(!$isthecookieset)
		{
		return false;
		exit(1);
		}
	  else  {
		//now set the session
		//that the session is already started one need not set the session only verify and update
		@session_start();
		$regenera_query=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE WHERE USERID='$USERID'");
      		$regenera_details=mysql_fetch_array($regenera_query);
		$theauthkey=$regenera_details['AUTHKEY'];
		$authkeyincookie=$_COOKIE['authkey'];
		if(!(md5($theauthkey)==$authkeyincookie))
			{
			error_log("[[[[[[[SET]>>>the authkey in the cookie is not the has of that in the database;the control must not have been allowed upto this point by the iflogged function for USERID($USERID)");
			return false;
			}
		else	
			{
			$thecurrenttime=time();
			error_log("[[[[[[[SET]>>>REGENERATE SCRIPT REGENERATING THE SESSION VARIABLES FOR THE USERID,TIME($USERID,$thecurrenttime)");
			$_SESSION['authkey']=$authkeyincookie;
			$thecursessid=session_id();
			//update the table
			$updatequery=mysql_query("UPDATE $SET_THEMYSQLLOGINTABLE SET SESSIONID='$thecursessid' where USERID='$USERID'");
			if(mysql_error())
				{
				error_log("[[[[[[[SET]>>>the regenerated userid could not be updated in the database in the regenerate file for USERID($USERID)");
				return false;
				}
			else
				{
				return true;
				}
			}
		}
	}
}


?>