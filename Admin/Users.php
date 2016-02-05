<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['deluser'])){ 

    //if user id is 1 ignore
    if($_GET['deluser'] !='1'){

        $select = $db->prepare('DELETE FROM users WHERE userID = :userID') ;
        $select->execute(array(':userID' => $_GET['deluser']));

        header('Location: users.php?action=deleted');
        exit;

    }
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Users</title>
  <link rel="stylesheet" href="../styles/normalize.css">
  <link rel="stylesheet" href="../styles/main.css">
  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'users.php?deluser=' + id;
      }
  }
  </script>
</head>
<body>

    <div id="wrapper">

    <?php include('menu.php');?>

    <?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
        echo '<h3>User '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <table>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php
        try {

            $select = $db->query('SELECT userID, username, email FROM users ORDER BY username');
            while($row = $select->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['username'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                ?>

                <td>
                    <a href="edit-user.php?id=<?php echo $row['userID'];?>">Edit</a> 
                    <?php if($row['userID'] != 1){?>
                        | <a href="javascript:deluser('<?php echo $row['userID'];?>','<?php echo $row['username'];?>')">Delete</a>
                    <?php } ?>
                </td>
                
                <?php 
                echo '</tr>';

            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>

    <p><a href='add-user.php'>Add User</a></p>

</div>

</body>
</html>