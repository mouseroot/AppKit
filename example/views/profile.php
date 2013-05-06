<!DOCTYPE html>
<html lang="en-US">
  <head>
		<title>Profile of <?php echo $user ?></title>
	</head>
	<body>
		<?php
			if($logged_in == $user)
			{
				
				echo "Edit menu + Normal menu";
			}
			else
			{
				echo "Normal menu";
			}
		?>
			<br />
		<?php 
			foreach($blogs as $blog)
			{
				$id = $blog["id"];
				$title = $blog["title"];
				echo "<a href='blog/$id'>$title</a>";
			}
		?>
		
	</body>
</html>
