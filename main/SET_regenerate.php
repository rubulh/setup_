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
function regenerate($USERID)
{
	//first check the details
	$isthesessionset=false;
	$isthecookieset=false;
	{
	  if($_SESSION['authkey'] || session_id())
		{
		$isthesessionset=true;
		}
	}
 	if($isthesessionset)
	{
	error_log("[[[[[[[SET]>>>the session ids are set stil the iflogged allowed the control to come upto the regenerate for the USERID($USERID)");
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
		//now set the cookies
		
		}
	}
}


?>