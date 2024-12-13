<?php 
namespace DB;

use Exception;
use mysqli;

require_once('response_manager.php');

class Constant{
    protected const DB_ADDR="db";
    protected const DB_NAME="tlazzari";
    protected const USERNAME="tlazzari";
    protected const PASSWORD="pass";
}

class Functions extends Constant{
    private $connection;

    public function openConnection():bool{
        $this->connection=new mysqli(parent::DB_ADDR,parent::USERNAME,parent::PASSWORD,parent::DB_NAME);
        $this->connection->set_charset("utf8");

        if($this->connection->connect_errno)
        {
            return false;
        }

        return true;
    }

    public function closeConnection(): void {
        $this->connection->close();
    }

    public function registrati($username, $pass): response_manager {
        $query = "INSERT INTO UTENTE (username,password) VALUES (?,?)";
        $stmt = $this->connection->prepare($query);
        $psw = hash('sha256', $pass);
    
        if ($stmt === false) {
          return new response_manager(array(), $this->connection, "Errore");
        } else if ($stmt->bind_param('ss',$username, $psw) === false) {
          $stmt->close();
          return new response_manager(array(), $this->connection, "Errore");
        }
        $response = $stmt->execute();
    
        $stmt->close();
    
        if (!$response) {
          return new response_manager(array(), $this->connection, "Errore");
        }
        return $this->accedi($username, $pass);
      }

      public function accedi($username, $pass): response_manager {
        $query = "SELECT username, isAdmin FROM UTENTE WHERE username = ? AND password = ?";
        $stmt = $this->connection->prepare($query);
        $result = array();
    
        $psw = hash('sha256', $pass);
    
        if ($stmt === false) {
          return new response_manager($result, $this->connection, "Errore");
        } else if ($stmt->bind_param('ss', $username, $psw) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "Errore");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        while ($row = $tmp->fetch_assoc()) {
          array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
          $res->set_error_message("Utente non esiste");
        }
    
        $stmt->close();
        return $res;
      }

}

?>