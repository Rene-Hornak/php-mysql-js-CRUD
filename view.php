<?php
    require_once "pdo.php";
    session_start();

    $sql = "SELECT * FROM Profile WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->exceute(array(":profile_id" => $_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile view</title>
</head>
<body>
    <h1>Profile Information</h1> 
    <?php
        echo '<p>First Name: </p>' . htmlentities($row['first_name']);
        echo '<p>Last Name: </p>' . htmlentities($row['last_name']);
        echo '<p>Email: </p>' . htmlentities($row['email']);
        echo '<p>Headline: </p>' . htmlentities($row['headline']);
        echo '<p>Summary: </p>' . htmlentities($row['summary']);

        echo '<a href="index.php">Done</a>'
    ?>  
</body>
</html>