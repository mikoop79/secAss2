<h1>Experiment Two </h1>
<h2>Implementation of Fu's Secure Cookie Scheme</h2>

<p>username | expiration time| data | HMAC(username | expiration time | data , sk) 
<br/> where sk  is the server key</p>
<p><strong>Note</strong> the data is sent unencrypted, just part of the cookie value</p>


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
echo '<p>Eg. <code>setcookie("FuCookie", $encrypted_data, $exptime) /* expire in 1 hour */ </code> </p>';
echo "<h3>Get the Fu cookie</h3>";
echo '<p>Eg. <code>$_COOKIE["FuCookie"]</code> </p>';

$re_fu_cookie_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $_COOKIE["FuCookie"], MCRYPT_MODE_ECB, $iv);

echo "Get Decrypted Fu cookie: " . $re_fu_cookie_data . "<br>";

if (!isset($_COOKIE["FuCookie"])){
	setcookie("FuCookie", $encdata, $exptime);
} 

?>
