<?php
  /*
SET_logout function does the following
1.removes all the session and cookie variables
2.and then updates the database
   */
function SET_logout()
{
session_start();
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
$LASTTIMESTAMPAUTHKEY=$_SESSION['authkey'];
  $thecurrenttimestamp=time();
  $ifsession_set=false;
  if(session_id())
    {
      $ifsession_set=true;
    }
  {
    if($ifsession_set)
      {
	$_SESSION['authkey']="";
	session_destroy();
      }
    $cookie1=setcookie("authkey","",$thecurrenttimestamp-60*60);
    $cookie2=setcookie("base","",$thecurrenttimestamp-60*60);
    $cookie3=setcookie("userid","",$thecurrenttimestamp-60*60);
    $cookie4=setcookie("PHPSESSID","",$thecurrenttimestamp-60*60);
  }
  {
    //extract details from the database
    $query_extr_all_details=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE WHERE USERID='$USERID'");
    $answer_extr_all_details=mysql_fetch_array($query_extr_all_details);
    $againanswer_extr_all_details=mysql_fetch_array($query_extr_all_details);
    if(!$answer_extr_all_details)
      {
	 error_log("[[[[[[[SET]>>>the logout function could not extract the details of the USERID ($USERID)");
	 SET_whisk(5);
	 return false;
      }
    $USER=$answer_extr_all_details['NAME'];
    $logged_till_now=$answer_extr_all_details['TOTALLOGGEDTIME'];
    $logintimestamp=$answer_extr_all_details['LOGINTIMESTAMP'];
    $loggedtotal=$logged_till_now+($thecurrenttimestamp-$logintimestamp);
    //update the database
    $query_update=mysql_query("UPDATE $SET_THEMYSQLLOGINTABLE SET LOGGED='0',LASTTIMESTAMP='$thecurrenttimestamp',LASTTIMESTAMPAUTHKEY='$LASTTIMESTAMPAUTHKEY',LOGOUTTIMESTAMP='$thecurrenttimestamp',TOTALLOGGEDTIME='$loggedtotal',SESSIONID='',BASE='',SALT='',AUTHKEY='',COOKIEEXPIRY='$thecurrenttimestamp' WHERE USERID='$USERID'");
	if(mysql_error())
		{
      		error_log("[[[[[[[SET]>>>".mysql_error());
		}
    $answer_update=mysql_affected_rows();
    if(!$answer_update)
      {
	 error_log("[[[[[[[SET]>>>the logout function could not update the database for the USER,USERID ($USER,$USERID) the query failed");
	 whisk(5);
	 return false;
      }
  }
  return true;
}
?>
