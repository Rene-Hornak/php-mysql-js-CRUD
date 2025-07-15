<?php
    require_once "pdo.php";
    session_start();
    
    
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
            if(isset($_SESSION['something']))
        ?>
    </body>
</html>