<?php 
$GLOBALS['read']  = trim(exec("sed -n 's/guest ok = //p' /etc/samba/smb.conf")) == "yes";
$GLOBALS['write'] = trim(exec("sed -n 's/read only = //p' /etc/samba/smb.conf")) == "no";
$GLOBALS['username'] = 'admin';
$GLOBALS['password'] = '8e9abd3327374f51929b0be6f07e4566b281ab2328e6da50f50d35e735d1791a';
$GLOBALS['salt'] = '8QBe355o1ewDFXcY7OXd^!GF0KrV(!(i';
?>