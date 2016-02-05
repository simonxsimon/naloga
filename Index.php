<?php
require('includes/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Blog Povio</title>
	<link rel="stylesheet" href="styles/normalize.css">
	<link rel="stylesheet" href="styles/main.css">
</head>

<body>
	<div id ="wrapper">
		<h1>Blog</h1>

		<ul id="menu">
			<li><a href="index.php">Domov</a></li>
			<li><a href="admin/index.php">Admin</a></li>
			
		</ul>

	<?php

		$select = $db -> query('Select postID, postTitle, postDesc, postDate from posts ORDER BY postID DESC');
		while($row = $select -> fetch()){
			echo '<div>';
                echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                echo '<p>'.$row['postDesc'].'</p>';                
                echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';                
            echo '</div>';
		}
	
	?>

	</div>



</body>
</html>
	
