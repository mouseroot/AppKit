<!DOCTYPE html>
<html lang="en-US">
  <head>
		<?php
			if($session->get("user"))
			{
				$email = $session->get("user")->email;
				echo "<title>blog - Home</title>";
			}
			else
			{
				echo "<title>blog - Index</title>";
			}
		?>
	</head>
	<body>
		<?php
			if($session->get("user"))
			{
				echo "Welcome " . $session->get("user")->email . "<br />";
				echo "Published Blogs:<br .>";
				echo "<ul>";
				foreach($blogs as $blog)
				{
					$id = $blog->id;
					$title = $blog->title;
					echo "<li><a href='view/$id'>$id - $title</a></li><br />";
				}
				echo "</ul>";
				echo "<a href='create'>New blog</a><br />";
				echo "<a href='logout'>Logout</a><br />";
			}
			else
			{
				echo "Mouseroots blog";
				include "login_view.php";
			}
		?>
	</body>
</html>
