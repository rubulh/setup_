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
global $SET_THEMYSQLHOSTNAME;
global $SET_THEMYSQLUSERNAME;
global $SET_THEMYSQLPASSWORD;
global $SET_THEMYSQLDBNAME;
global $SET_THEMYSQLLOGINTABLE;
global $SET_COOKIEEXPIRY;
global $SET_THEMULTIPLELOGIN;
global $SET_BASIC_MYSQL_CONNECT;
global $SET_BASIC_SELECT_DATABASE;

  $thecurrentsessionid=session_id();
  $currentauthkeycookie=$_COOKIE['authkey'];
  $currentbasecookie=$_COOKIE['base'];
  $thecurrentsessionauthkey=$_SESSION['authkey'];
  $thecurrentuserid=$_COOKIE['userid'];
  $ifsession_set=false;
  $thecurrenttimestamp=time();
  $thereneratedthing=false;
  if(($currentauthkeycookie)&&($currentbasecookie)&&($thecurrentuserid))
    {
      if($thecurrentsessionid)
       {
      $ifsession_set=true;
       }
     {
      //extract all details from the table
      $query_ex_details=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE WHERE USERID='$thecurrentuserid'");
      $answer_ex_details=mysql_fetch_array($query_ex_details);
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
	  $authkeyindb=mysql_real_escape_string($answer_ex_details['AUTHKEY']);
	  $baseindb=mysql_real_escape_string($answer_ex_details['BASE']);
	  $saltindb=mysql_real_escape_string($answer_ex_details['SALT']);
	  $usernameindb=$answer_ex_details['NAME'];
	  $cookieexpiryindb=$answer_ex_details['COOKIEEXPIRY'];
error_log($loggedindb);
error_log(md5($authkeyindb));
error_log($thecurrentsessionauthkey);
error_log(md5($logintimeindb.$saltindb.$lasttimedb.$thecurrentuserid.$baseindb.$usernameindb));
error_log($currentbasecookie);
error_log("to verify i am using".$logintimeindb." ".$saltindb." ".$lasttimedb." ".$thecurrentuserid." ".$baseindb." ".$usernameindb);
	  if(!(($loggedindb)&&(md5($authkeyindb)==$currentauthkeycookie)&&(md5($logintimeindb.$saltindb.$lasttimedb.$thecurrentuserid.$baseindb.$usernameindb)==$currentbasecookie)))
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
	    return false;
	    }
	  else if(($loggedindb)&&(md5($authkeyindb)==$currentauthkeycookie)&&(md5($logintimeindb.$saltindb.$lasttimedb.$thecurrentuserid.$baseindb.$usernameindb)==$currentbasecookie))
		{
		if(!($thecurrentsessionid && $thecurrentsessionauthkey))
			{
			$thereneratedthing=SET_regenerate($thecurrentuserid);
			if(!$thereneratedthing)
				{
					if($thecurrentsessionid)
	        			{
					$thecurrentsessionauthkey;
					$_SESSION=array();
	         			session_destroy();
	        			}
	    			$cookie1=setcookie("authkey","",$thecurrenttimestamp-60*60);
	    			$cookie2=setcookie("base","",$thecurrenttimestamp-60*60);
	    			$cookie3=setcookie("userid","",$thecurrenttimestamp-60*60);
	    			$cookie4=setcookie("PHPSESSID","",$thecurrenttimestamp-60*60);
				return false;
				}
			}
		}
	//i might need another condition inside the if condition in here 
	}
      }
    }
  $finallysessionid=session_id();
  if($finallysessionid)
    {
      return $finallysessionid;
    }
  else if(!$finallysessionid)
    {
      return false;
    }
}

/*
note that the function has not been set according to the regenerate function thing i need to think it and do it in the future

 */
?>
