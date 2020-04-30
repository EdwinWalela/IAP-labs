<?php

    // session_start();
    include_once 'user.php';

    if(isset($_POST['btn-save'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $city = $_POST['city_name'];
        $username =$_POST['username'];
        $password=$_POST['password'];

        $user = new User($first_name,$last_name,$city,$username,$password);
        if(!$user->validateForm()){
            $user->createFormErrorSessions();
            header("Refresh:0");
            die();
        }
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
    <link rel="stylesheet" type="text/css" media="screen" href="./styles/validate.css" />
    <script type="text/javascript" src="./scripts/validate.js"></script>
</head>
<body>
    <center>
        <form action="index.php" method="POST" onsubmit="return validateForm()">
        <div id="form-errors">
            <?php
                session_start();
                if(!empty($_SESSION['form_errors'])){
                    echo " " . $_SESSION['form_errors'];
                    unset($_SESSION['form_errors']); 
                }
            ?>
        </div>
            <input type="text" name="first_name" placeholder="first_name" required/><br/>
            <input type="text" name="last_name" placeholder="last_name"required/><br/>
            <input type="text" name="username" placeholder="username" required/><br/>
            <input type="password" name="password" placeholder="password"required/><br/>
            <input type="text" name="city_name" placeholder="city" required/><br/>
            <button type="submit" name="btn-save">Save</button>
            <a href="login.php">Login</a>
        </form>
        <h3>Users</h3>
        <?php
            $user = new User('','','','','');
            $result = $user->readAll();
            if($result->num_rows != 0){
                echo("<p> First Name | Last Name | City");
                while($row = $result->fetch_assoc()) {
                    echo "<p>";
                    echo($row["first_name"]);
                    echo(" | ");
                    echo($row["last_name"]);
                    echo(" | ");
                    echo($row["user_city"]);
                    echo "</p>";
                }
            }else{
                echo("No records Found");
            }
        ?>
    </center>
</body>
</html>