<?php

require('includes/config.php');

$select = $db->prepare('SELECT postID, postTitle, postCont, postDate FROM posts WHERE postID =:postID');
$select -> execute(array(':postID' => $_GET['id']));
$row = $select->fetch();

if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['postTitle'];?></title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

    <div id="wrapper">

        <h1>Blog</h1>
        <hr />
        <p><a href="./">Blog Index</a></p>
 <?php
        
		echo '<div>';
		    echo '<h1>'.$row['postTitle'].'</h1>';
		    echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
		    echo '<p>'.$row['postCont'].'</p>';                
		echo '</div>';

?>

	</div>
</body>
</html>


