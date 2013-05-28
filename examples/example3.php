<h1>Experiment Three </h1>
<h2>Our Implementation of the Secure Cookie Scheme</h2>
<p> <code>session id | expiration time | (data)k | HMAC(session id | expiration time | data, k)</code>
<br/> where k = HMAC(session id | expiration time, sk) referred to as "OurKey</p>
<p><strong>NOTE</strong> sk = server key </p>


<h3>First generate k - the key for encryption</h3>

<?php
if (!isset($_SESSION['Ourkey'])){
    
     $ourKey = substr(hash_hmac("sha256", "{$sessionid}{$sepr}{$exptime}", $serverkey), 0, $keysize);
    $_SESSION['Ourkey'] = $ourKey;
} else {
	$ourKey =  $_SESSION['Ourkey'];
}


//Data to be stored in the cookie 
$OurData = "Our Data: This is our Data, Item one, Item 234";
//Encrypt the data
$encdata = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $ourKey, $OurData, "ecb");
// Encrypted data length
$enclength = strlen($encdata);
//Decrypt the data
$re_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $ourKey, $encdata, MCRYPT_MODE_ECB, $iv);
echo "User name: $username <br/>";
echo "Session ID:" . $sessionid . "<br/>";
echo "<br/>Expiration time: $exptime";
echo "<br/>Data: $OurData <br/>";
echo "Seperator: $sepr <br/>";
echo "Server key: $serverkey <br/>";
echo "OurKey: $ourKey <br/>";
echo "Initialisation vector: $iv <br/>";
echo "Encrypted data: $encdata <br/>";
echo "Encrypted data length: $enclength <br/></p>";
echo "<p>Decrypted data: $re_data</p>";

$cookievalue =  $sessionid . $sepr . $exptime . $sepr . $encdata . $sepr . hash_hmac("sha256", "{$sessionid}{$sepr}{$exptime}", $ourKey);
echo "<strong>Our cookie scheme data: </strong>" . $cookievalue;


echo "<h3>Set the cookie</h3>";
echo '<p>Eg. <code>setcookie("OurCookie", $cookievalue, $exptime) /* expire in 1 hour */ </code> </p>';


echo "<h3>Get the cookie</h3>";
echo '<p>Eg. <code>$_COOKIE["OurCookie"]</code> </p>';


$value = explode($sepr, $_COOKIE['OurCookie']);
	echo '<pre>';
	echo var_dump($value);
	echo '</pre>';


	$re_cookie_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $ourKey, $value[2], MCRYPT_MODE_ECB, $iv);

echo "Get Data value and decrypt the data: " . $re_cookie_data . "<br>";

if (!isset($_COOKIE["OurCookie"])){
	setcookie("OurCookie", $cookievalue, $exptime);

	$page = $_SERVER['PHP_SELF'];
    $sec = "0";
    header("Refresh: $sec; url=$page");
} 

?>