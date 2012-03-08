<?php
/*
the update function
update the details of the user id and set the new cookies and session variables and then update the database
to be run only after the iflogged regenrate has been run assuming all has been run
session start must be outside this function
files needed randomstring salt base 
*/

function SET_update($USERID)
{
require_once("SET_mysqlconnection.php");
$_SESSION=array();
$regenerate=session_regenerate_id(true);
$dnewsessionid=session_id();
$dthecurrenttimestamp=time();
$dextracted_authkey=mysql_real_escape_string(SET_randomstring());
$dsalt=mysql_real_escape_string(SET_salt());
$dhashedextracted_authkey=md5($dextracted_authkey);
$dbase_main=mysql_real_escape_string(SET_baserandomstring());
$dbase=md5($dthecurrenttimestamp.$dsalt.$dthecurrenttimestamp.$USERID.$dbase_main.$USERID);
$dcookie_expiry_timestamp=$SET_COOKIEEXPIRY+$thecurrenttimestamp;

$_SESSION['authkey']=$dhashedextracted_authkey;
$dcookie1=setcookie("authkey",$dhashedextracted_authkey,$dcookie_expiry_timestamp);
$dcookie2=setcookie("base",$dbasd,$dcookie_expiry_timestamp);
$dcookie3=setcookie('userid',$USERID,$dcookie_expiry_timestamp);
if(!($dcookie1 && $dcookie2 && $dcookie3))
	{
	
	 error_log("[[[[[[[SET]>>>the SET_update function could not set all the cookies properly USERID($USERID)");
	 whisk(29);
	 return false;
	 exit(1);
	}
$dupdatequery="UPDATE $SET_THEMYSQLLOGINTABLENAME set AUTHKEY='$dextracted_authkey', BASE='$dbase',SALT='$dsalt',COOKIEEXPIRY='$dcookie_expiry_timestamp',LASTTIMESTAMP='$dthecurrenttimestamp',SESSIONID='$dnewsessionid' ";
$dqueried=mysql_query("$dupdatequery");
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