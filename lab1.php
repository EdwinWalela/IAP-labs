
<?php 
   include_once "user.php";
   include_once "DBConnector.php";
   include_once "FileUploader.php";

   $conn = new DBConnector();


   if(isset($_POST['btn-save']))
   {
      $first_name = $_POST['first_name'];
      $last_name  = $_POST['last_name'];
      $city       = $_POST['city_name'];
      $pass       = $_POST['password'];
      $uname       = $_POST['username'];

      $utc_timestamp = $_POST['utc_timestamp'];
      $offset = $_POST['time_zone_offset'];

      $_SESSION['username'] = $uname;

      $file_name = $_FILES['fileToUpload']['name'];
      $file_size = $_FILES['fileToUpload']['size'];
      $final_file_name = $_FILES['fileToUpload']['tmp_name'];
      $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

      $user = new User($first_name, $last_name, $city, $uname, $pass);

      $user->setUtcTimestamp($utc_timestamp);
      $user->setTimezoneOffset($offset);

      $fileUpload = new FileUploader();

      $fileUpload->setUsername($uname);

      $fileUpload->setOriginalName($file_name);
      $fileUpload->setFileType($file_type);
      $fileUpload->setFinalFileName($final_file_name);
      $fileUpload->setFileSize($file_size);


      if(!$user->validateForm())
      {
         $user->createFormErrorSessions();
         header("Location:lab1.php");
         die();
      }
      else
      {
       if ($fileUpload->fileWasSelected()) 
         {
         if ($fileUpload->fileTypeisCorrect()) 
         {
            if ($fileUpload->fileSizeIsCorrect()) 
            {
               if (!($fileUpload->fileAlreadyExists())) 
               {
				    $user->save();
					 $fileUpload->uploadFile() ;
               }
               else
               {
						echo "File already exists"."<br>";

					}
            }
            else
            {
					echo "Please pick smaller image size"."<br>";
				}
         }
         else
         {
				echo "Incorrects file type"."<br>";
			}

      }
      else
      {
         echo "Please select a file to upload"."<br>";
      }
   }
}
   $conn->closeDatabase();

?>

<html>
   <head>
        <title>IAP-Lab 1</title>
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">

        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> 
       
       <script type="text/javascript" src="timezone.js"></script>

   </head>

   <body>
       <form method="post" name="user_details" id="user_details" onsubmit="return validateForm()" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF'] ?>">
          <table align="center">
             <tr>
               <td>
                  <div id="form-errors">
                        <?php 
                        
                           session_start();
                           if(!empty($_SESSION['form_errors']))
                           {
                              echo " ". $_SESSION['form_errors'] ."<br>";
                              unset($_SESSION['form_errors']);
                           }

                            if(!empty($_SESSION['exists']))
                            {
                              echo " ". $_SESSION['exists'];
                              unset($_SESSION['exists']);
                           }
                           
                        ?>
                  </div> 
                 
               </td>
               <tr>
               <td><input type="text"  name="first_name" required placeholder="First name"></td>
             </tr>
             <tr>
               <td><input type="text" name="last_name" placeholder="Last name"></td>
             </tr>
             <tr>
                  <td><input type="text" name="city_name" placeholder="City"></td>
             </tr>
               
            <tr>
                  <td><input type="text" name="username" id="uname" placeholder="Username"></td>         
            </tr>

               <tr>
                  <td><input type="password" name="password" placeholder="Password"></td>         
            </tr>

            <tr>
                   <td>Profile Image: <input type="file" name="fileToUpload" id="fileToUpload"></td>  
            </tr>

             <tr>
                 <td><button type="submit" name="btn-save" id="submit"><strong>SAVE</strong> </button></td>
             </tr>

             <tr>
                 <td> <input type="hidden" name="utc_timestamp" id="utc_timestamp" value=""> </td> 
             </tr>

             <tr>
                     <td> <input type="hidden" name="time_zone_offset" id="time_zone_offset" value=""> </td>
             </tr>

             <tr>
                  <td><a href="login.php">Login</a></td>
             </tr>
          </table>
       </form>

       <p>Database results:</p>
      <?php 
      
         $user_disp= User::create();
         $user_disp->readAll();
      ?>


   </body>
   
</html>







