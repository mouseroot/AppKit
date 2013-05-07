<!DOCTYPE html>
<html lang="en-US">
  <head>
		<?php
			if($session->get("user"))
			{
				$user = $session->get("user");
				$email = $user->email;
				echo "<title>Welcome $email</title>";
			}
			else
			{
				echo "<title>Site title</title>";
			}
		?>
	</head>
	<body>
		<?php
			if($session->get("user"))
			{
				echo "Show main for user " . $session->get("user")->email;
			}
			else
			{
				include "login_form.php";
			}
		?>
	</body>
</html>
