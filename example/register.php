<!DOCTYPE html>
<html>
	<head>
		<title>Example</title>
	</head>
	<body>
	<?php
		error_reporting(E_ALL & ~E_NOTICE); // FOR CHECKBOX

		require_once 'src/EasyCheckData.php';

		if(isset($_POST['invia']))
		{
			$ECD = new EasyCheckData();
			$ECD->setVar($_POST['username'], "Username")->isDef()->minLen(6)->maxLen(30);
			$ECD->setVar($_POST['email'], "Email")->isDef()->isEmail();
			$ECD->setVar($_POST['check'], "Terms")->isChecked();
			$ECD->setVar($_POST['age'], "Age")->isDef()->isNumber();
			foreach($ECD->getFirstErrors() as $error)
			{
				echo $error."<br>";
			}
		}
	?>
		<form action="" method="post">
			<input type="text" name="username" placeholder="Username"><br>
			<input type="email" name="email" placeholder="Email"><br>
			<input type="checkbox" name="check"> Terms of use<br>
			<input type="text" name="age" placeholder="Age"><br>
			<input type="submit" name="invia"><br>	
		</form>
	</body>
</html>
