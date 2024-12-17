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

    //funzione che inserisce un utente nel database e richiama la funzione di login come output 
      public function registrati($username, $pass): response_manager {
        $query = "INSERT INTO UTENTE (username,password) VALUES (?,?)";
        $stmt = $this->connection->prepare($query);
        $psw = hash('sha512', $pass);
    
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

      //funzione che controlla che un utente sia presente nel database e permette di accedere
      public function accedi($username, $pass): response_manager {
        $query = "SELECT username, isAdmin FROM UTENTE WHERE username = ? AND password = ?";
        $stmt = $this->connection->prepare($query);
        $result = array();
    
        $psw = hash('sha512', $pass);
    
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

      //trova percorso nel database e restituisce i dati del percorso
      public function get_percorso($id): response_manager {
        $query = "SELECT * FROM PERCORSO where id=?";
        $stmt = $this->connection->prepare($query);
    
        $result = array();
    
        if ($stmt === false) {
          return new response_manager($result, $this->connection, "Qualcosa sembra essere andato storto");
        } else if ($stmt->bind_param('i', $id) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "Qualcosa sembra essere andato storto");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        $result = array();
    
        while ($row = $tmp->fetch_assoc()) {
          array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
          $res->set_error_message("Nessun Percorso Trovato con questo Nome");
        }
    
        $stmt->close();
        return $res;
      }

      //prende tutte le recensioni di un determinato percorso
      public function get_recensioni($id,$utente='%'):response_manager{

        $query = "SELECT * FROM RECENSIONE where percorso=? and utente LIKE ?";
        $stmt = $this->connection->prepare($query);
    
        $result = array();
    
        if ($stmt === false) {
          return new response_manager($result, $this->connection, "Qualcosa sembra essere andato storto");
        } else if ($stmt->bind_param('is', $id,$utente) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "Qualcosa sembra essere andato storto");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        $result = array();
    
        while ($row = $tmp->fetch_assoc()) {
          array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
          $res->set_error_message("Nessuna Recensione Trovata con questo Nome");
        }
    
        $stmt->close();
        return $res;
      }

      public function aggiungi_recensione($utente,$id,$voto,$testo):response_manager{

        $query = "INSERT INTO `RECENSIONE` (`utente`, `percorso`, `voto`, `testo`, `ultima_modifica`) VALUES (?, ?, ?, ?, current_timestamp());";
        $stmt = $this->connection->prepare($query);
    
        if ($stmt === false) {
          return new response_manager(array(), $this->connection, "Errore");
        } else if ($stmt->bind_param('siis',$utente, $id,$voto,$testo) === false) {
          $stmt->close();
          return new response_manager(array(), $this->connection, "Errore");
        }
        $response = $stmt->execute();
    
        $stmt->close();
    
        if (!$response) {
          return new response_manager(array(), $this->connection, "Errore");
        }

        return $this->get_recensioni($id, $utente);

      }

}

?>