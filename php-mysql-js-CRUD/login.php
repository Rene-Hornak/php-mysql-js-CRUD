<?php
    require_once "pdo.php";
    session_start();

    // button cancel redirect to index.php
    if (isset($_POST['cancel'])){
        header("Location: index.php");
        return;
    }

    // check Form data, correct data let log in into web-application
    if (isset($_POST['email']) && isset($_POST['password'])) {
        unset($_SESSION['email']); // Logout current user

        // Error: email and password are empty
        if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
            $_SESSION['error'] = "Email and password are required";
            header("Location: login.php");
            return;
        }

        // Error: email must contain @
        if (strpos($_POST['email'], '@') === FALSE) {
            $_SESSION['error'] = "Email address must contain @";
            header("Location: login.php");
            return;
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
    </head>
    <body>
        <h1>Please Log In</h1>
        <form method="post">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"/><br/>
            <label for="password">Password</label>
            <input type="text" name="password" id="password"/><br/>
            
            <input type="submit"  value="Log In"/>
            <input type="submit" name="cancel" value="Cancel"/> 
        </form>
    </body>
</html>