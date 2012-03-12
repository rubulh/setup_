<?php
  /*
function set base random string

   */
function SET_baserandomstring()
{
$therootstring="thaHJDHueuHGHD3948JDG][E[K338487gayAYU##FH&6389&^GGXgssgpopqmczhq*()hff--sj+{!jdjsjDHD;',,789HHH,.><fhfhkf3732993";
$thereturnstring="";
$length=rand(32,67);
for($i=0;$i<$length;$i++)
  {
    $thereturnstring=$thereturnstring.$therootstring[rand(0,(strlen($therootstring)-1))];
  }
return $thereturnstring;
}
?>