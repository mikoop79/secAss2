<h1>Experiment One. </h1>
<h2>Implementation of Liu's Secure Cookie Scheme</h2>
<p>username | expiration time| (data)k | HMAC(username | expiration time | data , k) <br/> where k = HMAC(username | expiration time, sk)</p>
<p><strong>NOTE</strong> sk = serverkey</p>

<h3>First generate k - the key for encryption</h3>

<?php
echo "User name: $username";
echo "<br/>Expiration time: $exptime";
echo "<br/>Data: $data <br/>";
echo "Seperator: $sepr <br/>";
echo "Server key: $serverkey <br/>";
echo "Key: $key <br/>";
echo "Initialisation vector: $iv <br/>";
echo "Encrypted data: $encdata <br/>";
echo "Encrypted data length: $enclength <br/></p>";
echo "<p>Decrypted data: $re_data</p>";
echo "<h3>Set the cookie</h3>";
echo '<p>Eg. <code>setcookie("LiuCookie", $encrypted_data, $exptime) /* expire in 1 hour */ </code> </p>';


echo "<h3>Get the cookie</h3>";
echo '<p>Eg. <code>$_COOKIE["LiuCookie"]</code> </p>';

$re_cookie_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $_COOKIE["LiuCookie"], MCRYPT_MODE_ECB, $iv);

echo "Get Decrypted cookie: " . $re_cookie_data . "<br>";

if (!isset($_COOKIE["LiuCookie"])){
	setcookie("LiuCookie", $encdata, $exptime);
} 

?>