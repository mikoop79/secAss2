<?php
ob_start();
session_start();
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


// only use the one session key// if not set the set it.
if (!isset($_SESSION['key'])){
    $key = substr(hash_hmac("sha256", "{$username}{$sepr}{$exptime}", $serverkey), 0, $keysize);
    $_SESSION['key'] = $key;
} else {
	$key =  $_SESSION['key'];
}


// // echo "Key: " . $key; 
// echo "\n Session Key: ". $_SESSION['key'];
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
    <link rel="stylesheet" type="text/css" media="screen" href="bootstrap/css/bootstrap.min.css">
 <script src="./bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#myTab a').click(function (e) {
  		e.preventDefault();
        $(this).tab('show');
})


})
	
	
</script>
</head>
<div id="" class="well">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active">
            <a href="#example1" data-toggle="tab">Liu's Example</a>
        </li>
        <li>
            <a href="#example2" data-toggle="tab">Fu's Example</a>
        </li>
        <li>
            <a href="#example3" data-toggle="tab">Our Example</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="example1">
            <?php include 'examples/example1.php'; ?>
        </div>
        <div class="tab-pane fade" id="example2">
            <?php include 'examples/example2.php'; ?>
        </div>
        <div class="tab-pane fade" id="example3">
            <?php include 'examples/example3.php'; ?>
        </div>
    </div>
</div>