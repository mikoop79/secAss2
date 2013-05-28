<h1>Experiment Two. </h1>
<h2>Implementation of Liu's Secure Cookie Scheme</h2>
<p> <code>username | expiration time| (data)k | HMAC(username | expiration time | data , k)</code> <br/> where k = HMAC(username | expiration time, sk)</p>
<p><strong>NOTE</strong> sk = serverkey</p>

<h3>First generate k - the key for encryption</h3>

<?php

//Data to be stored in the cookie 
$LiuData = "Lius Data: Item one, Item two, Item six and twenty-seven other items";
//Encrypt the data
$encdata = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $LiuData, "ecb");
// Encrypted data length
$enclength = strlen($encdata);
//Decrypt the data
$re_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encdata, MCRYPT_MODE_ECB, $iv);
echo "User name: $username";
echo "<br/>Expiration time: $exptime";
echo "<br/>Data: $LiuData <br/>";
echo "Seperator: $sepr <br/>";
echo "Server key: $serverkey <br/>";
echo "Key: $key <br/>";
echo "Initialisation vector: $iv <br/>";
echo "Encrypted data: $encdata <br/>";
echo "Encrypted data length: $enclength <br/></p>";
echo "<p>Decrypted data: $re_data</p>";



$cookievalue =  $username . $sepr . $exptime . $sepr . $encdata . $sepr . hash_hmac("sha256", "{$username}{$sepr}{$exptime}", $key);
echo "<strong>Lius cookie scheme data: </strong>" . $cookievalue;


echo "<h3>Set the cookie</h3>";
echo '<p>Eg. <code>setcookie("LiuCookie", $cookievalue, $exptime) /* expire in 1 hour */ </code> </p>';


echo "<h3>Get the cookie</h3>";
echo '<p>Eg. <code>$_COOKIE["LiuCookie"]</code> </p>';


$value = explode($sepr, $_COOKIE['LiuCookie']);
	echo '<pre>';
	echo var_dump($value);
	echo '</pre>';


	$re_cookie_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $value[2], MCRYPT_MODE_ECB, $iv);

echo "Get Data value and decrypt the data: " . $re_cookie_data . "<br>";

if (!isset($_COOKIE["LiuCookie"])){
	setcookie("LiuCookie", $cookievalue, $exptime);

	$page = $_SERVER['PHP_SELF'];
    $sec = "0";
    header("Refresh: $sec; url=$page");
} 

?>