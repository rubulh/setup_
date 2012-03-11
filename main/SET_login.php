<?php
  /*
the SET_login function operates on true returned by the SET_checklogin function this functon
this function does the following
1.sets the session authkey and the same authkey encrypted in the cookie next line
2.sets the cookie authkey and userid in the session 
3.sets the another-authkey in the cookie called base after hashed with proper salt and all other things forms the entry in the database
   */
function SET_login($NAME,$PASS,$CHECKED)
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
  if((!$CHECKED) || ($CHECKED==7))
    {
      return false;
      exit(1);
    }
  else if($CHECKED)
    {
      session_start();
      {
	$NAME=mysql_real_escape_string($NAME);
	$PASS=md5(mysql_real_escape_string($PASS));
	//this is redundant yet necessary as i need two functions
	$query_all_details=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE WHERE NAME='$NAME' AND PASSWORD='$PASS'");

var_dump(mysql_error());
	$answer_all_details=mysql_fetch_array($query_all_details);
	if(!$answer_all_details)
	  {
	    error_log("[[[[[[[SET]>>>the SET_checklogin script allowed the user access to the SET_login but no entry corressponding to the NAME and PASS ($NAME,$PASS) was found in the SET_THEMYSQLLOGINTABLE");
	    return false;
	    whisk(1);
	    exit(1);
	  }
	$extracted_user_id=$answer_all_details['USERID'];
	$extracted_logged=$answer_all_details['LOGGED'];
	//check may be redundant
	 if((!$SET_THEMULTIPLELOGIN) && ($extracted_logged))
	{
	    error_log("[[[[[[[SET]>>>the SET_checklogin script allowed the user access to the SET_login and but multiple login incurred and multiple login disabled for (NAME,PASS)($NAME)");
	     return false;;
	}
	$thecurrenttimestamp=time();
	$extracted_authkey=mysql_real_escape_string(SET_randomstring());
	$salt=mysql_real_escape_string(SET_salt());
	$hashedextracted_authkey=md5($extracted_authkey);
	$base_main=mysql_real_escape_string(SET_baserandomstring());
	$base=md5($thecurrenttimestamp.$salt.$thecurrenttimestamp.$extracted_user_id.$base_main.$NAME);
	$cookie_expiry_timestamp=$SET_COOKIEEXPIRY+$thecurrenttimestamp;
	$THESESSIONID=session_id();
	{
	  $query_update_database=mysql_query("UPDATE $SET_THEMYSQLLOGINTABLE SET LOGINTIMESTAMP='$thecurrenttimestamp',LASTTIMESTAMP='$thecurrenttimestamp',AUTHKEY='$extracted_authkey',BASE='$base_main',SALT='$salt',COOKIEEXPIRY='$cookie_expiry_timestamp',LOGGED='1',SESSIONID='$THESESSIONID' WHERE USERID='$extracted_user_id'");
	  $answer_update_database=mysql_affected_rows();
	  if(!$answer_update_database)
	    {
	      error_log("[[[[[[[SET]>>>the SET_login function could not update the database for the user login for USER,USERID ($NAME,$extracted_user_id)");
	      whisk(2);
	      return false;
	      exit(1);
	    }
	}
      }
      $_SESSION['authkey']=$hashedextracted_authkey;
      $cookie1=setcookie("authkey",$hashedextracted_authkey,$SET_COOKIEEXPIRY+$thecurrenttimestamp);
      $cookie2=setcookie("base",$base,$SET_COOKIEEXPIRY+$thecurrenttimestamp);
      $cookie3=setcookie('userid',$extracted_user_id,$SET_COOKIEEXPIRY+$thecurrenttimestamp);
      if($cookie1 && ($cookie2 && $cookie3))
	{
	  return true;
	}
      else if(!($cookie1 && $cookie2))
	{
	  error_log("[[[[[[[SET]>>>seems like every thing else went correctly fo the SET_login function but the setcookie variables either of them or both gave false so the function returned false for the user USER,USERID like ($USER,$extracted_user_id)");
	  whisk(3);
	  return false;
	  exit(1);
	}
    }
}
?>