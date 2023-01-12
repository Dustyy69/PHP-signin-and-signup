<?php
require_once("connect.php");


if (isset($_REQUEST['register'])) {
	$username = $_REQUEST['username'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$pw = $_POST['password'];
	$cemail = $_POST['email'];
	$password = password_hash($pw, PASSWORD_DEFAULT);
	$statement = $pdo_conn->prepare('SELECT COUNT(*) FROM tbl_user_info WHERE email = :checkemail');
	$statement->bindValue(':checkemail', $cemail);

	$statement->execute();
	$num_rows = $statement->fetchColumn();
	if ($num_rows > 0) { ?>


		<div style="width:auto" class="alert alert-danger" role="alert">
			This is a danger alert—check it out!

		</div>

<?php
	} else {
		$query = "INSERT INTO tbl_user_info ( username, fname, lname,email,password ) VALUES ( :username, :fname, :lname,:email,:password )";
		$statement = $pdo_conn->prepare($query);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':fname', $fname);
		$statement->bindValue(':lname', $lname);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':password', $password);
		$result = $statement->execute();
	}
}

if (isset($_REQUEST['login'])) {
	$email = $_POST['login_email'];
	$pw = $_POST['login_password'];

	$pdo_statement = $pdo_conn->prepare('SELECT * FROM tbl_user_info WHERE email = :loginemail');
	$pdo_statement->bindValue(':loginemail', $email);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if (!empty($result)) {
		foreach ($result as $row) {
			if ($row['email'] === $email and $row['password'] === $pw and $row['role'] == 1) {
				header('location:Admin/index.php');
			} else if ($row['email'] === $email and $row['password'] === $pw and $row['role'] == 2) {
				header('location:Parent/index.php');
			} else if ($row['email'] === $email and $row['password'] === $pw and $row['role'] == 3) {
				header('location:Hospital/index.php');
			} else if ($row['email'] === $email and $row['password'] === $pw and $row['role'] == null) {
				header('location:waiting.php');
			}
		}
	} else {
		header('location:failed.php');
	}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="./assests/login_style.css">
	<link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>

<body>


	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form action="login.php" method="post">
				<h1>Create An Account!</h1>
				<input type="text" name="username" placeholder="Username" />
				<input type="text" name="fname" placeholder="First Name" />
				<input type="text" name="lname" placeholder="Last Name" />
				<input type="email" name="email" placeholder="Email" />
				<input type="password" name="password" placeholder="Password" />
				<input class="btn btn-outline-danger" type="submit" name="register" value="Sign Up"></button>
			</form>
		</div>
		<div class="form-container sign-in-container">
			<form action="Login.php" method="post">
				<h1>Sign in</h1>

				<input type="email" name="login_email" placeholder="Email" />
				<input type="password" name="login_password" placeholder="Password" />
				<input class="btn btn-outline-danger" type="submit" name="login" value="Sign In"></button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Welcome Back!</h1>
					<p>To keep connected with us please login with your personal details</p>
					<button class="ghost" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Hi There!</h1>
					<p>Enter your personal details to open an account with us</p>
					<button class="ghost" id="signUp">Sign Up</button>
				</div>
			</div>
		</div>
	</div>

	<script src="./assests/login_script.js" charset="utf-8"></script>
</body>

</html>