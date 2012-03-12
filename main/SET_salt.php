<?php
  /*
function set base random string

   */
function SET_salt()
{
$therootstring="shd1hH2772668&&&(72981)(_{::}}272652,<::}[]223as3dD71Sd27AFh3S3S9d8d2d88d38dhaSHJS3812890uwuyisudua327(*&*^^$%$$$%^%&^%&ejhdkjajdaaoi831357268";
$thereturnstring="";
$length=rand(32,67);
for($i=0;$i<$length;$i++)
  {
    $thereturnstring=$thereturnstring.$therootstring[rand(0,(strlen($therootstring)-1))];
  }
return $thereturnstring;
}
?>
