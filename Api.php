<?php 

include_once 'DBconnector.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
 {
	header('HTTP/1.0 403 Forbidden');
	echo "Forbidden request";
}
 else
 {
	$api_key = null;
	$api_key = generateApiKey(64);
	header("Content-Type: application/json; charset=UTF-8");
	echo generateResponse($api_key);
}

function generateApiKey($str_length)
{
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$bytes = openssl_random_pseudo_bytes(3*$str_length/4+1);
	$repl = unpack('C2', $bytes);

	$first = $chars[$repl[1]%62];
	$second = $chars[$repl[2]%62];
	return strtr(substr(base64_encode($bytes), 0, $str_length), '+/', "$first$second");
}

function saveApiKey($api_key)
{
	session_start();
	$dbcon = new DBconnector();
	$user = $_SESSION['username'];
	$myquery = mysqli_query($dbcon->conn, "SELECT * FROM users WHERE username='$user'");
	$user_array = mysqli_fetch_assoc($myquery);
	$uid = $user_array['id'];
	$good = mysqli_query($dbcon->conn, "INSERT INTO api_keys(user_id,api_key) VALUES('$uid','$api_key')") or die(mysqli_error($dbcon->conn));
	if ($good === true) 
	{
		return true;
	}
	return false;
}

function generateResponse($api_key)
{
	if (saveApiKey($api_key))
	{
		$res = ['success' => 1, 'message' => $api_key];
	} 
	else
	{
		$res = ['success' => 0, 'message' => 'Something went wrong. Please regenerate the API key'];
	}
	
	return json_encode($res);
}

 ?>