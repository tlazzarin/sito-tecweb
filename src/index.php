<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $admin=$_SESSION['isAdmin'];
    echo $admin;

    if(!$admin)
    {
        echo "<h1>Hello ".$_SESSION['Username']."</h1>";
    }
    else
    {
        echo "<h1>Hello</h1>";
        
    }

    ?>
    
</body>
</html>