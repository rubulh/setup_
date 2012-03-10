<?php
	//the SET_register function 
	//it does the following takes in username password checks it and validates that it and then inserts it into the database 
	// and sets all the other fields in the field to the corressponding field as xxxxx appropiately


function SET_register($regusername,$regpass)
{
	require_once("SET_mysqlconnection.php");
	$theregusername=mysql_real_escape_string($regusername);
	$md5theregpass=md5(mysql_real_escape_string($regpass));
	$querytoevaluate=mysql_query("SELECT * FROM $SET_THEMYSQLLOGINTABLE WHERE NAME='$theregusername'");
	$ansevaluate=mysql_fetch_array($querytoevaluate);
	if($ansevaluate)
		{
		return 7;
		exit(1);
		}
	
	$querytoregister="INSERT INTO $SET_THEMYSQLLOGINTABLE (NAME,PASSWORD,LOGGED,LOGINTIMESTAMP,LASTTIMESTAMPAUTHKEY,AUTHKEY,BASE,SALT,COOKIEEXPIRY,SESSIONID,LOGOUTTIMESTAMP,TOTALLOGGEDTIME) VALUES('$theregusername','$md5theregpass','x','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx')";
	$ansregwuer=mysql_query($querytoregister);
	if(mysql_error())
		{
      error_log("[[[[[[[SET]>>>".mysql_error());
		}
	$affred=mysql_affected_rows();
	if($affred==(-1))
		{
		error_log("[[[[[[[SET]>>>the SET_register function could not update the database for the user registration for USER ($theregusername)");
	      	SET_whisk(2);
	      	return 0;
	      	exit(1);
		}
	else if($affred==1)
		{
		return 1;	
		}

}


?>
