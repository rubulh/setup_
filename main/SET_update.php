<?php
/*
the update function
update the details of the user id and set the new cookies and session variables and then update the database
to be run only after the iflogged regenrate has been run assuming all has been run
session start must be outside this function
files needed randomstring salt base 
*/

function SET_update()
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
$USERID=$_COOKIE['userid'];
$_SESSION=array();
$getalldetails_query=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE where USERID='$USERID'");
if(mysql_error())
		{
      		error_log("[[[[[[[SET]>>>".mysql_error());
		}
$fetchalldetails=mysql_fetch_array($getalldetails_query);
$thelogintimestamp=$fetchalldetails['LOGINTIMESTAMP'];
$usernameindb=$fetchalldetails['NAME'];
$thebeforeauthkey=$fetchalldetails['AUTHKEY'];
$regenerate=session_regenerate_id(true);
$dnewsessionid=session_id();
$dthecurrenttimestamp=time();
$dextracted_authkey=mysql_real_escape_string(SET_randomstring());
$dsalt=mysql_real_escape_string(SET_salt());
$dhashedextracted_authkey=md5($dextracted_authkey);
$dbase_main=mysql_real_escape_string(SET_baserandomstring());
error_log("to update i am using".$thelogintimestamp." ".$dsalt." ".$dthecurrenttimestamp." ".$USERID." ".$dbase_main." ".$usernameindb);
$dbase=md5($thelogintimestamp.$dsalt.$dthecurrenttimestamp.$USERID.$dbase_main.$usernameindb);
$dcookie_expiry_timestamp=$SET_COOKIEEXPIRY+$dthecurrenttimestamp;
$_SESSION['authkey']=$dhashedextracted_authkey;
$dcookie1=setcookie("authkey",$dhashedextracted_authkey,$dcookie_expiry_timestamp);
$dcookie2=setcookie("base",$dbase,$dcookie_expiry_timestamp);
$dcookie3=setcookie("userid",$USERID,$dcookie_expiry_timestamp);
if(!($dcookie1 && $dcookie2 && $dcookie3))
	{
	
	 error_log("[[[[[[[SET]>>>the SET_update function could not set all the cookies properly USERID($USERID)");
	 whisk(29);
	 return false;
	 exit(1);
	}
$dupdatequery="UPDATE $SET_THEMYSQLLOGINTABLE set AUTHKEY='$dextracted_authkey', BASE='$dbase_main',SALT='$dsalt',COOKIEEXPIRY='$dcookie_expiry_timestamp',LASTTIMESTAMP='$dthecurrenttimestamp',LASTTIMESTAMPAUTHKEY='$thebeforeauthkey',SESSIONID='$dnewsessionid' ";
$dqueried=mysql_query("$dupdatequery");
if(mysql_error())
		{
      		error_log("[[[[[[[SET]>>>".mysql_error());
		}
if(!mysql_affected_rows())
	{
	 error_log("[[[[[[[SET]>>>the SET_update function could not update the updated parameters for the USERID($USERID)");
	 whisk(28);
	 return false;
	 exit(1);
	}
else
	{
	return true;
	}
}

?>