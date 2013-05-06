<!DOCTYPE html>
<html lang="en-US">
  <head>
		<title>Blog <?php echo $blog["title"]; ?></title>
	</head>
	<body>
		<?php echo $blog["content"]; ?>
		<?php if(isset($logged_in)) { echo "<br />edit options"; } ?>
		<hr />
	</body>
</html>
