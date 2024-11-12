<?php 
try{
    //!DA CAMBIARE PROTOCOLLO E HOST
    //!DA CAMBIARE PROTOCOLLO E HOST
    //!DA CAMBIARE PROTOCOLLO E HOST
    //!DA CAMBIARE PROTOCOLLO E HOST
    $pdo = new PDO('pgsql:dbname=tlazzari host=host.docker.internal port=3306', 'tlazzari', 'Aix5Booyeepohfee'); 
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define and execute the query
    $query = "SELECT * FROM t";
    $stmt = $pdo->query($query);

    // Fetch and print each row
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['at'] . "<br>"; // Replace 'column_name' with the actual column name of your table
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>