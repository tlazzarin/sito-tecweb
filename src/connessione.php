<?php 
try{
    $pdo = new PDO('mysql:dbname=tlazzari; host=db; port=3306', 'root'); 
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define and execute the query
    $query = "SELECT * FROM a";
    $stmt = $pdo->query($query);

    // Fetch and print each row
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['id'] . "<br>"; // Replace 'column_name' with the actual column name of your table
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>