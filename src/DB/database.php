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
      try{
        $this->connection=new mysqli(parent::DB_ADDR,parent::USERNAME,parent::PASSWORD,parent::DB_NAME);
      }
      catch(Exception $e){
        return false;
      }
        
        
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
          return new response_manager(array(), $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('ss',$username, $psw) === false) {
          $stmt->close();
          return new response_manager(array(), $this->connection, "C'è stato un errore");
        }
        try{
          $response = $stmt->execute();
        }
        catch(Exception $e){
          return new response_manager(array(), $this->connection, "Utente con stesso Username già presente");
        }
    
        $stmt->close();
    
        if (!$response) {
          return new response_manager(array(), $this->connection, "Non è stato possibile registrarsi");
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
          return new response_manager($result, $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('ss', $username, $psw) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "C'è stato un errore");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        while ($row = $tmp->fetch_assoc()) {
          array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
          $res->set_error_message("Errore in username o password");
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
          return new response_manager($result, $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('i', $id) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "C'è stato un errore");
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

      //restituisce tutte le caratteristiche
      public function get_caratteristiche($id): response_manager {
        $query = "SELECT * FROM `CARATTERISTICA_PERCORSO` WHERE percorso = ?";
        $stmt = $this->connection->prepare($query);
    
        $result = array();
    
        if ($stmt === false) {
          return new response_manager($result, $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('i', $id) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "C'è stato un errore");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        $result = array();
    
        while ($row = $tmp->fetch_assoc()) {
          array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
          $res->set_error_message("Nessuna Caratteristica Trovata con questo Percorso");
        }
    
        $stmt->close();
        return $res;
      }

      //restituisce tutti i percorsi
      public function get_tutti_percorsi(): response_manager {
        $query = "SELECT percorso.*,immagine.* from PERCORSO as percorso inner JOIN IMMAGINI as immagine on immagine.id_immagine=percorso.id where immagine.id_immagine like \"%/1.jpg\"";
        $stmt = $this->connection->prepare($query);
    
        $result = array();
    
        if ($stmt === false) {
          return new response_manager($result, $this->connection, "C'è stato un errore");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        $result = array();
    
        while ($row = $tmp->fetch_assoc()) {
          array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
          $res->set_error_message("Nessun Percorso trovato nel database");
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
          return new response_manager($result, $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('is', $id,$utente) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "C'è stato un errore");
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

      //funzione che aggiunge recensione dell'utente al database e restituisce tutte le recensioni per quel percorso(inclusa quella nuova)
      public function aggiungi_recensione($utente,$id,$voto,$testo):response_manager{

        $query = "INSERT INTO `RECENSIONE` (`utente`, `percorso`, `voto`, `testo`, `ultima_modifica`) VALUES (?, ?, ?, ?, current_timestamp());";
        $stmt = $this->connection->prepare($query);
    
        if ($stmt === false) {
          return new response_manager(array(), $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('siis',$utente, $id,$voto,$testo) === false) {
          $stmt->close();
          return new response_manager(array(), $this->connection, "C'è stato un errore");
        }
        $response = $stmt->execute();
    
        $stmt->close();
    
        if (!$response) {
          return new response_manager(array(), $this->connection, "Non è stato possibile aggiungere la tua recensione");
        }

        return $this->get_recensioni($id, $utente);

      }

      //cancella la recensione dal database
      public function cancella_recensione($id,$utente)
      {
        $query = "DELETE FROM RECENSIONE WHERE `RECENSIONE`.`utente` = ? AND `RECENSIONE`.`percorso` = ?";
        $stmt = $this->connection->prepare($query);

        $result=array();
    
        if ($stmt === false) {
          return new response_manager(array(), $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('si',$utente, $id) === false) {
          $stmt->close();
          return new response_manager(array(), $this->connection, "C'è stato un errore");
        }
        $response = $stmt->execute();
    
        
    
        if (!$response) {
          return new response_manager(array(), $this->connection, "Non è stato possibile modificare la recensione");
        }

        $res = new response_manager($result, $this->connection, "");

        if (!$res->ok()) {
          $res->set_error_message("Non è stato possibile modificare la recensione");
        }
      
        $stmt->close();
        return $res;
      }

      //prende dal database le foto di un determinato percorso
      public function get_immagini($id):response_manager{

        $query = "SELECT * FROM `IMMAGINI` WHERE id_immagine LIKE ?";
        $stmt = $this->connection->prepare($query);
    
        $result = array();
    
        if ($stmt === false) {
          return new response_manager($result, $this->connection, "C'è stato un errore");
        } else if ($stmt->bind_param('s', $id) === false) {
          $stmt->close();
          return new response_manager($result, $this->connection, "C'è stato un errore");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        $result = array();
    
        while ($row = $tmp->fetch_assoc()) {
          array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
          $res->set_error_message("Nessuna Immagine Trovata con questo id");
        }
    
        $stmt->close();
        return $res;
      }


       //prende dal database i tre percorsi con le migliori reccensioni
      public function get_percorsi_top(): response_manager {
        $query = "SELECT p.*, i.*, AVG(r.voto) as media_voti 
                  FROM PERCORSO p 
                  LEFT JOIN RECENSIONE r ON p.id = r.percorso 
                  INNER JOIN IMMAGINI i ON i.id_immagine = p.id 
                  WHERE i.id_immagine LIKE '%/1.jpg' 
                  GROUP BY p.id 
                  ORDER BY media_voti DESC 
                  LIMIT 3";
                  
        $stmt = $this->connection->prepare($query);
        $result = array();
    
        if ($stmt === false) {
            return new response_manager($result, $this->connection, "C'è stato un errore");
        }
    
        $stmt->execute();
        $tmp = $stmt->get_result();
    
        while ($row = $tmp->fetch_assoc()) {
            array_push($result, $row);
        }
    
        $res = new response_manager($result, $this->connection, "");
    
        if (!$res->ok()) {
            $res->set_error_message("Nessun percorso trovato");
        }
    
        $stmt->close();
        return $res;
    }

}



