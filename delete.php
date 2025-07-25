<?php
    require_once "pdo.php";
    session_start();

    // If the delete button is pressed and profile_id is set
    // Delete the profile from the database 
    if ( isset($_POST['delete']) && isset($_POST['profile_id'])) {
        // Prepare and execute SQL statement to delete the profile
        $sql = "DELETE FROM Profile WHERE profile_id = :profile_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':profile_id' => $_POST['profile_id']));
                
        // Set success message and redirect to index.php
        $_SESSION['success'] = "Record deleted"; 
        header("Location: index.php");
        return;       
    }

    // If profile_id is not set, redirect to index.php with error message
    if ( !isset($_GET['profile_id']) ) {
        $_SESSION['error'] = "Missing profile_id";
        header("Location: index.php");
        return;
    }

    // Prepare and execute SQL statement to fetch the profile details
    $stmt = $pdo->prepare("SELECT first_name, last_name, profile_id FROM Profile WHERE profile_id = :profile_id");
    $stmt->execute(array(':profile_id' => $_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If no profile is found, set error message and redirect to index.php
    if ($row === false) {
        $_SESSION['error'] = "Bad value for profile_id";
        header("Location: index.php");
        return;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile delete</title>
</head>
<body>
    <h1>Deleting profile</h1>
    <form method="post">
        <p>First Name: <?= htmlentities($row['first_name']) ?></p>
        <p>Last Name: <?= htmlentities($row['last_name']) ?></p>
        <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>"><br/>
        <input type="submit" name="delete" value="Delete">
        <a href="index.php">Cancel</a> 
    </form>
</body>
</html>