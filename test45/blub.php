<?php


blub
function upBitShare($username, $password, $filepath) {
	
if(!file_exists($filepath)) {
return "Error - File doesn't exist! :(";
}

$post = array('user' => $username, 'password' => md5($password));
$result = sCurl('http://bitshare.com/api/openapi/login.php', $post);
$hashkey = str_replace('SUCCESS:', '', $result);

$post = array('action' => 'getFileserver');
$result = sCurl('http://bitshare.com/api/openapi/upload.php', $post);
$url = str_replace('SUCCESS:', '', $result);

$post = array('hashkey' => $hashkey,
              'file' => "@$filepath",
              'filesize' => filesize($filepath));
$result = sCurl($url, $post);

preg_match('%http://bitshare.com/files/(.*?)\.html%', $result, $bitsharedownload);
preg_match('%http://bitshare.com/delete/(.*?)\.html%', $result, $bitsharedelete);
$bsdow = $bitsharedownload[0];
$bsdel = $bitsharedelete[0];
$bsresult = array('download' => $bsdow, 'delete' => $bsdel);
return $bsresult;

}

