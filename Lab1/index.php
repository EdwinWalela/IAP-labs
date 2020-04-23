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
    <center>
        <form action="index.php" method="POST">
            <input type="text" name="first_name" placeholder="first_name" required/><br/>
            <input type="text" name="last_name" placeholder="last_name" required/><br/>
            <input type="text" name="city_name" placeholder="city" required/><br/>
            <button type="submit" name="btn-save">Save</button>
        </form>
        <h3>Users</h3>
        <?php
            $user = new User('','','');
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