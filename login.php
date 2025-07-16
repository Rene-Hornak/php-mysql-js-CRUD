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
        unset($_SESSION['email']); // Log out current user

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

        // Hash the password with salt
        $salt = 'XyZzy12*_';
        $check = hash('md5', $salt . $_POST['password']);

        // Prepare and execute SQL statement
        $sql = "SELECT user_id, name, email, password FROM users WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':email' => $_POST['email'], 
            ':password' => $check
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row !== false) {
            // Successful login
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php");
            return;
        } else {
            // Error: incorrect email or password
            $_SESSION['error'] = "Incorrect email or password";
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
        <?php
            // Flash message for error
            if (isset($_SESSION['error'])) {
                echo '<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n";
                unset($_SESSION['error']);
            }
        ?>
        <h1>Welcome to the Resume Registry. Please log in.</h1>
        <form method="post">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?= htmlentities($_POST['email']) ?>"/><br/>
            <label for="password">Password</label>
            <input type="text" name="password" id="password"/><br/>
            
            <input type="submit"  value="Log In"/>
            <input type="submit" name="cancel" value="Cancel"/> 
        </form>
    </body>
</html>