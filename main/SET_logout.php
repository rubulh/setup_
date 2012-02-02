<?php
  /*
SET_logout function does the following
1.removes all the session and cookie variables
2.and then updates the database
   */
function SET_logout($_COOKIE['userid'])
{
  require_once("SET_mysqlconnection.php");
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
    $query_extr_all_details=mysql_query("SELECT * FROM $SETTHEMYSQLLOGINTABLE WHERE 'USERID'='$USERID'");
    $answer_extr_all_details=mysql_fetch_array();
    $againanswer_extr_all_details=mysql_fetch_array();
    if($againanswer_extr_all_details)
      {
	 error_log("[[[[[[[SET]>>>the logout function could not extract the details of the USERID ($USERID)");
	 return false;
	 whisk(5);
	 exit(1);

      }
    $USER=$answer_extr_all_details['USER'];
    $logged_till_now=$answer_extr_all_details['TOTALLOGGEDTIME'];
    $logintimestamp=$answer_extr_all_details['LOGINTIMESTAMP'];
    $loggedtotal=$logged_till_now+($thecurrenttimestamp-$logintimestamp);
    //update the database
    $query_update=mysql_query("UPDATE $SET_THEMYSQLLOGINTABLE SET 'LOGGED'='0','LOGOUTSTAMP'='$thecurrenttimestamp','TOTALLOGGEDTIME'='$loggedtotal','LASTIMESTAMP'='0','SESSIONID'='','BASE'='',SALT='','AUTHKEY'='','COOKIEEXPIRY='$thecurrenttimestamp'");
    $answer_update=mysql_affected_rows();
    if(!$answer_update)
      {
	 error_log("[[[[[[[SET]>>>the logout function could not update the database for the USER,USERID ($USER,$USERID) the query failed");
	 return false;
	 whisk(4);
	 exit(1);

      }
  }
  return true;
}
?>
