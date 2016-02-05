<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit User</title>
  <link rel="stylesheet" href="../styles/normalize.css">
  <link rel="stylesheet" href="../styles/main.css">
</head>
<body>

<div id="wrapper">

    <?php include('menu.php');?>
    <p><a href="users.php">User Admin Index</a></p>

    <h2>Edit User</h2>


    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        //collect form data
        extract($_POST);

        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if( strlen($password) > 0){

            if($password ==''){
                $error[] = 'Please enter the password.';
            }

            if($passwordConfirm ==''){
                $error[] = 'Please confirm the password.';
            }

            if($password != $passwordConfirm){
                $error[] = 'Passwords do not match.';
            }

        }
        

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            try {

                if(isset($password)){

                    $hashedpassword = $user->create_hash($password);

                    //update into database
                    $select = $db->prepare('UPDATE users SET username = :username, password = :password, email = :email WHERE userID = :userID') ;
                    $stmt->execute(array(
                        ':username' => $username,
                        ':password' => $hashedpassword,
                        ':email' => $email,
                        ':userID' => $userID
                    ));


                } else {

                    //update database
                    $select = $db->prepare('UPDATE users SET username = :username, email = :email WHERE userID = :userID') ;
                    $select->execute(array(
                        ':username' => $username,
                        ':email' => $email,
                        ':userID' => $userID
                    ));

                }
                

                //redirect to index page
                header('Location: users.php?action=updated');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    ?>


    <?php
    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo $error.'<br />';
        }
    }

        try {

            $select = $db->prepare('SELECT userID, username, email FROM users WHERE userID = :userID') ;
            $select->execute(array(':userID' => $_GET['id']));
            $row = $select->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action='' method='post'>
        <input type='hidden' name='userID' value='<?php echo $row['userID'];?>'>

        <p><label>Username</label><br />
        <input type='text' name='username' value='<?php echo $row['username'];?>'></p>

        <p><label>Password (only to change)</label><br />
        <input type='password' name='password' value=''></p>

        <p><label>Confirm Password</label><br />
        <input type='password' name='passwordConfirm' value=''></p>

        <p><label>Email</label><br />
        <input type='text' name='email' value='<?php echo $row['email'];?>'></p>

        <p><input type='submit' name='submit' value='Update User'></p>

    </form>

</div>

</body>
</html>   