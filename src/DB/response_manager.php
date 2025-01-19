<?php

namespace DB;

class response_manager {

  private $empty = false;
  private $result = array();
  private $errno = 0;
  private $error_message = "";

  //costrutto che viene usato come risposta alle funzioni col database
  public function __construct($res, $conn, $mess) {
    $this->result = $res;

    $this->error_message = $mess;
    $this->empty = count($res) != 0 ? false : true;

    if ($conn) {
      $this->errno = $conn->errno;
    }
  }

  //funzione per sapere se il risultato della query ha avuto successo o no 
  public function ok(): bool {
    return !$this->empty && !$this->errno;
  }

  //controllo se risultato query e' vuota
  public function is_empty(): bool {
    return $this->empty;
  }

  //restituisce numero elementi risultato query
  public function get_element_count(): int {
    return count($this->result);
  }

  //restituisce elementi risultato query
  public function get_result(): array {
    return $this->result;
  }

  //restituisce messaggio errore
  public function get_error_message(): string {
    return $this->error_message;
  }

  //restituisce messaggio errore
  public function get_errno(): int {
    return $this->errno;
  }

  //imposta messaggio errore
  public function set_error_message($mes): void {
    $this->error_message = $mes;
  }
}
?>