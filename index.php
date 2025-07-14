<?php
session_start();
include 'includes/connection.php';

$errMsg = "";

if (isset($_SESSION['error'])) {
    $errMsg = $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Log-in</title>
	<link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>
	<div class="container">
		<div class="login_container">
			<div class="login_title">
				<span>Login</span>
			</div>

            <form action="process/login_process.php" method="post">
                <div class="input_wrapper">
                    <input type="text" id="user" name="username" class="input_field" required>
                    <label for="user" class="label">Username</label>
                    <i class="fa-regular fa-user icon"></i>
                </div>
    
                <div class="input_wrapper">
                    <input type="password" id="pass" name="password" class="input_field" required>
                    <label for="pass" class="label">Password</label>
                    <i class="fa-solid fa-lock icon"></i>
                </div>

                <div class="error">
                    <?php if (!empty($errMsg)): ?>
                        <p style="color: red; margin-top: 5px; text-align: center"><?php echo $errMsg; ?></p>
                    <?php endif; ?>
                    <br>
                </div>
    
                <div class="input_wrapper">
                    <input type="submit" class="input-submit" name="login" value="Submit">
                </div>
            </form>

			<div class="signup">
				<span>Don't have an account? <a href="pages/register.php"> Sign Up</a></span>
			</div>

		</div>
	</div>
</body>
</html>
