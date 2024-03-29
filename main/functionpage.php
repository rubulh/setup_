<?php
  /**********************************************************************
functionpage()
this function is to set up the necessary configuration 
this function ll check the various
>sqlconnection variables
>whether the database and the existing tables mentioned exist and are accessible by the entire
>the optional parameter gets set once any function in the setup finds an exception and cannot access the mysql database structure
>if exception =0 that is for settting up all the default parameters and the function is run in the default mode if the ifexception is one it checks if the variables set are correct if not raises a exception and an error
   **********************************************************************/
function functionpage($ifexception=0)
{
  if(!$ifexception)
    {
    A:
      echo "\nENTER THE HOST NAME:";
      $handle=fopen("php://stdin","r");
      $entered_host_name=trim(fgets($handle));
      echo "ENTER THE mysql username:";
      $entered_mysql_username=trim(fgets($handle));
      echo "ENTER THE mysql PASSWORD:";;
      $entered_mysql_password=trim(fgets($handle));
      echo "\ntrying to connect";
      sleep(1);
      echo".";
      sleep(1);
      echo ".";
      sleep(1);
      echo ".";
      sleep(1);
      $mysql_connection_trial=mysql_connect($entered_host_name,$entered_mysql_username,$entered_mysql_password);
      if(mysql_error())
	{
	  echo "\nTHE PARAMETERS ENTERED ARE INCORRECT\nTRY AGAIN";
	  goto A;
	}
      if(!mysql_error())
	{
	  echo "\tconnected to the mysql server\n";
	B:
	  echo "ENTER THE DATABASE NAME:";
	  $entered_db_name=trim(fgets($handle));
	  echo "\nseeking connection to the database";
	  sleep(1);
	  echo ".";
	  sleep(1);
	  echo ".";
	  sleep(1);
	  echo ".";
	  $trial_connection_to_database=@mysql_select_db($entered_db_name);
	  if(mysql_error())
	    {
	      echo "\t could not connect to the database\n creating a new one";
	   	      $createdb=mysql_query("CREATE DATABASE $entered_db_name");
	      if(mysql_error())
		{
		  echo "\n some error encountered try again";
		  goto B;
		}
	    }
	  if(!mysql_error())
	    {
	      echo "\t connected to the database successfully\n";
	    }
	}
      if(mysql_error())
	{
	  echo "\tconnection failed\nTHE ERROR IS:\n";
	  $trial_connection_error_encountered=mysql_error();
	  echo "$trial_connection_error_encountered\n";
	}
    C:
      echo "\nENTER THE TABLE NAME:";
      $entered_table_name=trim(fgets($handle));
      echo "\ntrying to resolve tablename";
      sleep(1);
      echo ".";
      sleep(1);
      echo ".";
      sleep(1);
      echo ".";
      $trying_the_table=@mysql_query("select * from $entered_table_name");
      if(mysql_error())
	{
	  echo "\t creating a table\n";
	  $tablecreate=
"CREATE  TABLE  `$entered_db_name`.`$entered_table_name` (  `USERID` int( 3  )  NOT  NULL  AUTO_INCREMENT ,
 `LOGINTIMESTAMP` text NOT  NULL ,
 `LASTTIMESTAMP` text NOT  NULL ,
 `LASTTIMESTAMPAUTHKEY` text NOT  NULL ,
 `AUTHKEY` text NOT  NULL ,
 `BASE` text NOT  NULL ,
 `SALT` text NOT  NULL ,
 `COOKIEEXPIRY` text NOT  NULL ,
 `LOGGED` text NOT  NULL ,
 `SESSIONID` text NOT  NULL ,
 `NAME` text NOT  NULL ,
 `PASSWORD` text NOT  NULL ,
 `LOGOUTTIMESTAMP` text NOT  NULL ,
 `TOTALLOGGEDTIME` text NOT  NULL ,
 PRIMARY  KEY (  `USERID`  )  ) ENGINE  = InnoDB  DEFAULT CHARSET  = latin1;
";

$create_table=mysql_query($tablecreate);
echo mysql_error();
if(mysql_error())
{
echo "\nsome error occured try again\n";
goto C;
}
	}
      if(!mysql_error())
	{
	  echo "\tcreated\n";
	}
    }
  echo "\n ENTER THE COOKIE EXPIRY TIME";
  $cookieexpirytime=trim(fgets($handle));
  echo "\n";


  echo "\nWRITING THE CONFIGURATION TO THE LOGIN CONFIGURATION FILE";
  sleep(1);
  echo ".";
  sleep(1);
  echo ".";
  sleep(1);
  echo ".";
  //write the details in a file
  $thefile="thesetupconfiguration.php";
  $filehandle=fopen($thefile,"w");
  if(!$filehandle)
    {
      echo "\n\n\n\n\n\n\n----ERROR ENCOUNTERED ==----------\n\n\n";
    }
  $thestringtowrite="<?php\n".'$SET_THEMYSLHOSTNAME'."=\"$entered_host_name\";".'$SET_THEMYSQLUSERNAME'."=\"$entered_mysql_username\";".'$SET_THEMYSQLPASSWORD'."=\"$entered_mysql_password\";".'$SET_THEMYSQLDBNAME'."=\"$entered_db_name\";".'$SET_THEMYSQLTABLENAME'."=\"$entered_table_name\";".'$SET_COOKIEEXPIRY'."=\"$cookieexpirytime\";?>";
  $writtenstring=fwrite($filehandle,$thestringtowrite);
  $fileclosed=fclose($filehandle);;
  echo "FILE SUCCESSFULLY WROTE!!...NOW EXITING\n\n";

  mysql_close();
}
functionpage();
?>
