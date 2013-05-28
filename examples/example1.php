<h1>Experiment One </h1>
<h2>Implementation of Fu's Secure Cookie Scheme</h2>

<p><code>username | expiration time | data | HMAC(username | expiration time | data , sk)</code> 
<br/> where sk  is the server key</p>
<p><strong>Note</strong> the data is sent unencrypted, just part of the cookie value</p>

<?php
//Data to be stored in the cookie 
$FuData = "Fu's Data: Item one, Item two, Item six and twenty-seven other items";
//Encrypt the data
$FUencdata = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $FuData, "ecb");
//Decrypt Data
$re_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $FUencdata, MCRYPT_MODE_ECB, $iv);

// Cookie details
echo "User name: $username";
echo "<br/>Expiration time: $exptime";
echo "<br/>Data: $FuData <br/>";
echo "Seperator: $sepr <br/>";
echo "Server key: $serverkey <br/>";
//echo "Key: $key <br/>";
// echo "Initialisation vector: $iv <br/>";
// echo "Encrypted data: $FUencdata <br/>";
// echo "Encrypted data length: $enclength <br/></p>";
echo "<p>Decrypted data: $re_data</p>";
echo "<h3>Set the cookie</h3>";
echo '<p>Eg. <code>setcookie("FuCookie", $FuData, $exptime) /* expire in 1 hour */ </code> </p>';
echo "<h3>Get the Fu cookie</h3>";
echo '<p>Eg. <code>$_COOKIE["FuCookie"]</code> </p>';

$cookieValue = $username . $sepr. $exptime . $sepr . hash_hmac("sha256", "{$username}{$sepr}{$exptime}{$sepr}{$FuData}", $serverkey);
echo "Fus Cookie scheme: " . $cookieValue . "</br>";


$FuCookie = explode($sepr, $_COOKIE['FuCookie']);
	echo '<pre>';
	echo var_dump($FuCookie);
	echo '</pre>';


echo "Get Fu cookie HASH to compare: " . $FuCookie[2] . "<br>";

if (!isset($_COOKIE["FuCookie"])){
	setcookie("FuCookie", $cookieValue, $exptime);
	$page = $_SERVER['PHP_SELF'];
    $sec = "0";
    header("Refresh: $sec; url=$page");
} 

?>
