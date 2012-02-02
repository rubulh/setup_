<?php
  /*
function SET_iflogged returns if the user currently accessing the script is logged in or not
the flow is
1.checks if the session is set and if the session userid is available and the cookie authkey in the session
2.checks if the cookies are set and and if the authkey in the cookie is same as the authkey session and if the database authkey hashed for the user is concurrent
3.also check if the base and the salt and the logintimestamp and lasttimestamp generate the hash in the base cookie
4.all of it is determined if the logged field in the table is 1 else all is erased and the corressponding fields are updated in the database
5.check if the session is set
   */
function SET_iflogged()
{
  require_once("SET_mysqlconnection.php");
  $thecurrentsessionid=session_id();
  $currentauthkeycookie=$_COOKIE['authkey'];
  $currentbasecookie=$_COOKIE['base'];
  $thecurrentsessionauthkey=$_SESSION['authkey'];
  $thecurrentuserid=$_COOKIE['userid'];
  $ifsession_set=false;
  $thecurrenttimestamp=time();
  if(($currentauthkeycookie)&&($currentbasecookie)&&($thecurrentuserid))
    {
      if($currentsessionid)
       {
      $ifsession_set=true;
       }
     {
      //extract all details from the table
      $query_ex_details=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLENAME WHERE 'USERID'='$thecurrentuserid'");
      $answer_ex_details=mysql_fetch_array();
      if(!$answer_ex_details)
	{
	  if($ifsession_set)
	    {
	    error_log("[[[[[[[SET]>>>exception cookie userid and session id set for the user with USERID($thecurrentuserid) but the query to the SET_THEMYSQLLOGINTABLENAME returned no result the session and cookies removed");
	      $_SESSION['authkey']="";
	      $_SESSION=array();
	      session_destroy();
	    }
	  $cookie1=setcookie("authkey","",$thecurrenttimestamp-60*60);
	  $cookie2=setcookie("base","",$thecurrenttimestamp-60*60);
	  $cookie3=setcookie("userid","",$thecurrenttimestamp-60*60);
	  $cookie4=setcookie("PHPSESSID","",$thecurrenttimestamp-60*60);
	}
      else if($answer_ex_details)
	{
	  $sessionidindb=$answer_ex_details['SESSIONID'];
	  $loggedindb=$answer_ex_details['LOGGED'];
	  $logintimeindb=$answer_ex_details['LOGINTIMESTAMP'];
	  $lasttimedb=$answer_ex_details['LASTTIMESTAMP'];
	  $authkeyindb=$answer_ex_details['AUTHKEY'];
	  $baseindb=$answer_ex_details['BASE'];
	  $saltindb=$answer_ex_details['SALT'];
	  $usernameindb=$answer_ex_details['USER'];
	  $cookieexpiryindb=$answer_ex_details['COOKIEEXPIRY'];
	  if((!$loggedindb)&&((!(md5($baseindb)==$currentbasecookie))&&(!(md5($logintimeindb.$saltindb.$lasttimedb.$thecurrentuserid.$baseindb.$usernameindb)==$currentbaseincookie))))
	    {
	     if($ifsession_set)
	        {
		$_SESSION=array();
	         $_SESSION['authkey']="";
	         session_destroy();
	        }
	    $cookie1=setcookie("authkey","",$thecurrenttimestamp-60*60);
	    $cookie2=setcookie("base","",$thecurrenttimestamp-60*60);
	    $cookie3=setcookie("userid","",$thecurrenttimestamp-60*60);
	    $cookie4=setcookie("PHPSESSID","",$thecurrenttimestamp-60*60);
	    }
	}
      }
    }
  $finallysessionid=session_id();
  if($finallyseessionid)
    {
      return $finallysessionid;
    }
  else if(!$finallysessionid)
    {
      return false;
    }t
}

/*
note that the function has not been set according to the regenerate function thing i need to think it and do it in the future

 */
?>
