<?php
    require_once "pdo.php";
    session_start();

    // If user is not logged in, access is denied 
    if(!isset($_SESSION['name']) && !isset($_SESSION['user_id'])) {
        die("ACCESSS DENIED");
    }

    // If the form is submitted, process the data
    if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['emailAddress']) && isset($_POST['subject']) && isset($_POST['abstract'])) {

        // Error: all fields are required
        if(strlen($_POST['name']) < 1 || strlen($_POST['surname']) < 1 || 
        strlen($_POST['emailAddress']) < 1 || strlen($_POST['subject']) < 1 || 
        strlen($_POST['abstract']) < 1) {
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
            return;
        }

        // Insert the profile into the database
        $sql = "INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':user_id' => $_SESSION['user_id'],
            ':first_name' => $_POST['name'],
            ':last_name' => $_POST['surname'],
            ':email' => $_POST['emailAddress'],
            ':headline' => $_POST['subject'],
            ':summary' => $_POST['abstract']
        ));

        // Set success message and redirect to index.php
        $_SESSION['success'] = "Profile added successfully";
        header("Location: index.php");
        return;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile add</title>
</head>
<body>
    <h1>Adding Profile</h1> 
    <?php
        // Flash messages for error 
        if (isset($_SESSION['error'])) {    
            echo '<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n";
            unset($_SESSION['error']);
        }

        // Flash message for success
        if (isset($_SESSION['success'])) {      
            echo '<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n";
            unset($_SESSION['success']);
        }
    ?>
    <form method="post">
        <label for="firstName">First Name:</label>
        <input type="text" name="name" id="firstName"/>

        <label for="lastName">Last Name:</label>
        <input type="text" name="surname" id="lastName"/>
        
        <label for="email">Email:</label>
        <input type="text" name="emailAddress" id="email"/>
        
        <label for="headline">Headline:</label>
        <input type="text" name="subject" id="headline"/>

        <label for="summary">Summary:</label>
        <input type="text" name="abstract" id="summary"/>

        <input type="hidden" name="user_id" value="<?= htmlentities($_SESSION['user_id']) ?>"/>

        <input type="submit" value="Add"/>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>