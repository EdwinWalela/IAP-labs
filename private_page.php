<?php
  include_once 'DBconnector.php';
  session_start();
  
  if(!isset($_SESSION['username']))
  {
   header("Location: login.php");
  }

  function fetchUserApiKey()
  {
   
	$dbcon = new DBconnector();
	$user = $_SESSION['username'];
	$myquery = mysqli_query($dbcon->conn, "SELECT * FROM users WHERE username='$user'");
	$user_array = mysqli_fetch_assoc($myquery);
	$uid = $user_array['id'];
	$good = mysqli_query($dbcon->conn, "SELECT * FROM api_keys WHERE user_id = '$uid' ORDER BY `api_keys`.`id` DESC") or die(mysqli_error($dbcon->conn));
  $key =  mysqli_fetch_assoc($good);
  
	return $key['api_key'];

  }
?>

<html>

    <head>
       <title>IAP-Labs</title>
       <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> 
       <script type="text/javascript" src="validate.js"></script>
       <link rel="stylesheet" type="text/css" href="validate.css">

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="apikey.js"></script>


    </head>

    <body>
        <p align='right'><a href="logout.php">Logout</a></p>
        <hr>
      
        <button class="btn btn-primary" id="api-key-btn">Generate APi key</button> <br> <br>

        <strong>API key:</strong><br>

        <textarea name="api_key" id="api_key" cols="100" rows="2" readonly> <?php echo fetchUserApiKey(); ?> </textarea>
        <hr>

    </body>

</html>