<?php

namespace DB;

class DBAccess
{
    private const DB_ADDR = "db";
    private const DB_NAME = "tlazzari";
    private const USERNAME = "tlazzari";
    private const PASSWORD = "pass";

    private $db_conn;

    //Funzione che apre una connessione con il database, inizializzando l'oggetto dbconn
    public function open_db_conn()
    {
        \mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_INDEX);
        $this->db_conn = mysqli_connect(DBAccess::DB_ADDR, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DB_NAME);
        //!DEBUG
        //return mysqli_connect_error();
        //!PRODUZIONE
        if (mysqli_connect_errno()) {
            return true;
        } else {
            return false;
        };
    }

    public function closeConnection()
    {
        mysqli_close($this->db_conn);
    }
}
