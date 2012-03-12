<?php
  /*
function set base random string

   */
function SET_randomstring()
{
$therootstring="hfhH828((98189Pp{2882ussUUIQOEO.,,..<>:!@44URURHKJDKkdshdhks93498400)*&^%ddg!@@$$#ehhfshdgfshgfjhHDG2948874DHCH BNVNV,.???{{[[]27373GAFGF";
$thereturnstring="";
$length=rand(32,67);
for($i=0;$i<$length;$i++)
  {
    $thereturnstring=$thereturnstring.$therootstring[rand(0,(strlen($therootstring)-1))];
  }
return $thereturnstring;
}
?>
