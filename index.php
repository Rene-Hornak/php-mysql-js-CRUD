<?php
    require_once "pdo.php";
    session_start();
    
    $sql = "SELECT profile_id, first_name, last_name, headline FROM Profile";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    // Function display the table of profiles takes an array of rows and a boolean indicating if the user is logged in
    function displayTable($rows, $isLoggedIn = false) {
        // If no rows are found, display a message
        if(count($rows) === 0){
            echo '<p>No rows found</p>' . "\n";
            return;
        }

        // Display the table header
        echo '<table border="1">';
        echo '<tr><th>Name</th><th>Headline</th>';
        if($isLoggedIn) echo '<th>Action</th>';
        echo '</tr>';

        // Loop through each row and display the data 
        foreach($rows as $row) {
            echo '<tr><td>';
            echo '<a href="view.php?profile_id=' . $row['profile_id'] . '">' . 
                htmlentities($row['first_name']) . ' ' .
                htmlentities($row['last_name']) . '</a></td>';
            echo '<td>' . htmlentities($row['headline']) . '</td>';

            // If the user is logged in, display edit and delete options
            if($isLoggedIn) {
                echo '<td><a href="edit.php?profile_id=' . $row['profile_id'] . '">Edit</a>';
                echo '<a href="delete.php?profile_id=' . $row['profile_id'] . '">Delete</a></td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Resume Registry</title>
    </head>
    <body>
        <h1>Resume Registry</h1>
        <?php
            // Display flash message for error
            if (isset($_SESSION['error'])) {    
                echo '<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n";
                unset($_SESSION['error']);
            }
            // Display flash message for success
            if (isset($_SESSION['success'])) {      
                echo '<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n";
                unset($_SESSION['success']);
            }

            // Check if user is logged in and display appropriate links and table
            // If user is logged in, show logout link and table with edit/delete options
            // If user is not logged in, show login link and table without edit/delete options
            if(isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
                echo '<a href="logout.php">Logout</a>' . "\n"; 
                displayTable($rows, true);
                echo '<a href="add.php">Add New Entry</a>' . "\n";  
            } else {
                echo '<a href="login.php">Please log in</a>' . "\n";
                displayTable($rows, false);
            }
        ?>
    </body>
</html>