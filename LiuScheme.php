<?php
ob_start();
mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_ECB, '');
//Decalre variables before any echo output
//User name
$username = "Barry234";
//Expiration time
$exptime = time() +3600;
//Data to be stored in the cookie 
$data = "Item one, Item two, Item six and twenty-seven other items";
//Define a separator value
$sepr = "|";
//Create a secret server key
$serverkey = hash('sha256', "Secret Server Key - ssshhh");
//Generate the key to encrypt the data with
$keysize = mcrypt_get_key_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
$key = substr(hash_hmac("sha256", "{$username}{$sepr}{$exptime}", $serverkey), 0, $keysize);
//Create iv value
$ivsize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

$iv = base64_encode(mcrypt_create_iv($ivsize, MCRYPT_DEV_RANDOM));
//Encrypt the data
$encdata = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, "ecb");
// Encrypted data length
$enclength = strlen($encdata);
//Decrypt the data
$re_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encdata, MCRYPT_MODE_ECB, $iv);




//Liu's cookie creation scheme

?>

<!DOCTYPE html>
<html>
<head>
<title>ExpOne></title>
 <script src="http://code.jquery.com/jquery-latest.js"></script>
 <script src="./jquery.cookie.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
	<div id="" class="well">
<h1>Experiment One </h1>

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

// set cookie data
// if (isset($_COOKIE['LiuCookie'])) {
//     echo "Cookie Set:" . $_COOKIE['LiuCookie'];
    
// } else {
    //setcookie('LiuCookie', $encdata, $exptime, '/');  /* expire in 1 hour */
    echo 'Trying to set cookie. Reload page plz';    
// }

echo "<h3>Get the cookie</h3>";
echo '<p>Eg. <code>$_COOKIE["LiuCookie"], $encrypted_data, $exptime) /* expire in 1 hour */ </code> </p>';

$re_cookie_data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $_COOKIE["LiuCookie"], MCRYPT_MODE_ECB, $iv);

echo "Get COOKIE: " . $re_cookie_data . "<br>";

?>

<p class="btn" id="setCookie" >Set Cookie</p>
<script type="text/javascript">
$(document).ready(function() {
  $("#setCookie").click(function(){
		alert("setCookie");
		var data = '<?php echo $encdata ?>';
		var time = '<?php echo $exptime ?>';
		$.cookie('LiuCookie', data, time, '/');

	})
});
	
</script>
</div>
</body></html>