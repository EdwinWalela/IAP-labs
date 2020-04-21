<?php

    // session_start();
    include_once 'user.php';

    if(isset($_POST['btn-save'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $city = $_POST['city_name'];

        $user = new User($first_name,$last_name,$city);
        $res = $user->save();

        if($res){
            echo "Record Saved!";
        }else{
            echo "An Error occured";
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab1</title>
    <link rel="stylesheet" type="text/css" media="screen" href="./main.css" />
</head>
<body>
    <form action="index.php" method="POST">
        <input type="text" name="first_name" placeholder="first_name" required/>
        <input type="text" name="last_name" placeholder="last_name" required/>
        <input type="text" name="city_name" placeholder="city" required/>
        <button type="submit" name="btn-save">Save</button>
    </form>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="username"/>
        <input type="password" name="pass" placeholder="password"/>
        <button>Login</button>
    </form>
</body>
</html>