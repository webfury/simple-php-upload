<?php
session_start();

// Constants
define('MAX_LOGIN_ATTEMPTS', 3);
define('LOCKOUT_DURATION', 24 * 60 * 60); // 24 hours in seconds

// Check if the user has attempted to log in before
if (!isset($_SESSION["login_attempts"])) {
    $_SESSION["login_attempts"] = 0;
}

// Check if the form is submitted
if (isset($_POST['password'])) {
    // Check if the user is currently locked out
    if (isset($_SESSION['lockout_time']) && time() - $_SESSION['lockout_time'] < LOCKOUT_DURATION) {
        $error = 'You are currently locked out. Please try again later.';
    } else {
        $password = $_POST['password'];

        if ($password == '1973usedx') {
            $_SESSION['logged_in'] = true;
            unset($_SESSION["login_attempts"]); // Reset login attempts on successful login
            unset($_SESSION['lockout_time']); // Reset lockout time on successful login
            header('Location: upload.php');
            exit();
        } else {
            $_SESSION["login_attempts"]++;

            if ($_SESSION["login_attempts"] >= MAX_LOGIN_ATTEMPTS) {
                // Set lockout time
                $_SESSION['lockout_time'] = time();
                $error = 'You have exceeded the maximum number of login attempts. Please try again later.';
            } else {
                $error = 'Invalid password! Attempt ' . $_SESSION["login_attempts"] . ' of ' . MAX_LOGIN_ATTEMPTS . '.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if(isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="post">
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
