<?php
mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_ECB, '');
//Liu's cookie creation scheme

?>

<!DOCTYPE html>
<html>
<head>
<title>ExpOne</title>
</head>
<body>
<h1>Experiment One </h1>

<h2>Implementation of Liu's Secure Cookie Scheme</h2>
<p>username | expiration time| (data)k | HMAC(username | expiration time | data , k)
<br/> where k = HMAC(username | expiration time, sk)</p>
<p><strong>NOTE</strong> sk = serverkey</p>

<h3>First generate k - the key for encryption</h3>

<?php 
//User name

$username = "Barry234";

echo "User name: $username";

//Expiration time

$exptime = (time() +3600);

echo "<br/>Expiration time: $exptime";

//Data to be stored in the cookie 

$data = "Item one, Item two, Item six and twenty-seven other items";

echo "<br/>Data: $data <br/>";

//Define a separator value
$sepr = "|";

echo "Seperator: $sepr <br/>";

//Create a secret server key
$serverkey = hash('sha256', "Secret Server Key - ssshhh");

echo "Server key: $serverkey <br/>";

//Generate the key to encrypt the data with

$keysize = mcrypt_get_key_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

$key = substr(hash_hmac("sha256", "{$username}{$sepr}{$exptime}", $serverkey), 0, $keysize);

echo "Key: $key <br/>";

//Create iv value
$ivsize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

$iv = base64_encode(mcrypt_create_iv($ivsize, MCRYPT_DEV_RANDOM));

echo "Initialisation vector: $iv <br/>";

//Encrypt the data
$encdata = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, "ecb"); 
echo "Encrypted data: $encdata <br/>";
$enclength = strlen($encdata);
echo "Encrypted data length: $enclength <br/></p>";

$re_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encdata, MCRYPT_MODE_ECB, $iv);

echo "<p>Decrypted data: $re_data</p>";

echo "<h3>Set the cookie</h3>";

//cookie setting values
$cname = "Basil";
//$value = $encdata;
//$expire = $exptime;
$path = "/";
$domain = "localhost";
//$secure = 


$bakeHMAC = hash_hmac("sha256", "{$username}{$sepr}{$exptime}{$sepr}{$encdata}", $key);

echo "<p>baked HMAC = $bakeHMAC</p>";

$encvalue = "{$username}{$sepr}{$exptime}{$sepr}{$encdata}{$sepr}{$bakeHMAC}";

echo "<h4>Cookie values</h4>";
echo "<p>name = $cname <br/>";
//echo "value = $encdata <br/>";
echo "value = $encvalue <br/>";
echo "expire = $exptime <br/>";
echo "path = $path <br/>";
echo "domain = $domain</p>";

if(setcookie($cname, $encvalue, $expire, $path, $domain)){

echo "<h4>The cookie is set</h4>";
}

echo "<p>$_COOKIE[$cname]</p>";

$contents = explode($sepr, $_COOKIE[$cname]);

echo "<p>$contents[0]";
echo "<br/>$contents[1]";
echo "<br/>$contents[2]";
echo "<br/>$contents[3]</p>";

//$re_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encdata, MCRYPT_MODE_ECB, $iv);

echo "<h4>Retrieve the cookie contents</h4>";

$databack = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $contents[2], MCRYPT_MODE_ECB, $iv);

echo "<p>$databack</p>";

echo "</body></html>";
