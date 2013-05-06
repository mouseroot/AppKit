<!DOCTYPE html>
<html lang="en-US">
  <head>
		<title>Main page</title>
	</head>
	<body>
		<?php
			if($session->get("username"))
			{
				$username = $session->get("username");
				echo "Welcome " . $session->get("username") . "<br />";
				echo "<a href='http://localhost/AppKit/profile/$username/'>View profile</a><br />";
				echo "<a href='http://localhost/AppKit/logout/'>Logout</a><br />";
				echo "<a href='http://localhost/AppKit/blogs/$username/'>View blogs</a><br />";
			}
			else
			{
				echo $login_form;
			}
		?>
		<hr />
		
	</body>
</html>
