<?php
	//the SET_register function 
	//it does the following takes in username password checks it and validates that it and then inserts it into the database 
	// and sets all the other fields in the field to the corressponding field as xxxxx appropiately


function register($regusername,$regpass)
{
	require_once("SET_mysqlconnection.php");
	
	$theregusername=mysql_real_escape_string($regusername);
	$md5theregpass=md5(mysql_real_escape_string($regpass));
	$querytoregister="INSERT INTO $SET_THEMYSQLLOGINTABLENAME (NAME,PASSWORD,LOGGED,LOGINTIMESTAMP,LASTTIMESTAMPAUTHKEY,AUTHKEY,BASE,SALT,COOKIEEXPIRY,SESSIONID,LOGOUTTIMESTAMP,TOTALLOGGEDTIME) VALUES('$theregusername','$md5theregpass','7','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx','xxxxxxx')";
	$ansregwuer=mysql_query($querytoregister);
	$affred=mysql_affected_rows();
	if($affre==(-1))
		{
		error_log("[[[[[[[SET]>>>the SET_login function could not update the database for the user login for USER,USERID ($USER,$extracted_user_id)");
	      	whisk(2);
	      	return false;
	      	exit(1);
		}
	else if($affre==1)
		{
		return true;	
		}

}


?>
