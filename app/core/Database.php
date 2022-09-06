<?php 

class Database{
    private $host = HOST;
    private $user = USER;
    private $pass = PASSWORD;
    private $db_name = DB_NAME;
    private static $conn;

    function __construct(){
        try {
            // error_reporting(E_ERROR | E_PARSE);
            $db = Database::$conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db_name);
        }catch( Exception $e ){
            App::errorLog("db_error", $e);
        }
    }

    // Get query
    static function query($query){
        try{
            return mysqli_query(Database::$conn, $query);
        }catch( Exception $e ){
            return false;
        }
    }

    public function getAll($operator = "", $row = "", $value = ""){
        $table = $this->table;
        if( !empty($operator) ){
            $query = "SELECT * FROM $table WHERE `$row` $operator $value";
        }else {
            $query = "SELECT * FROM $table";
        }
        
        $result = Database::query($query);
        if ( $result ) {
            if ( mysqli_num_rows($result) !== 0 ) {
                while ( $row = mysqli_fetch_object($result) ) {
                    $hasil[] = $row;
                }
                return (object) $hasil;
            }else {
                return [];
            }
        }
        
        // error
    }

    public function get($row = "", $operator = "", $value = ""){
        $table = $this->table;
        if( $row !== "" ){
            $query = "SELECT * FROM `$table` WHERE `$row` $operator '$value'";
        }else {
            $query = "SELECT * FROM `$table`";
        }

        $result = mysqli_fetch_object(Database::query($query));
        if ( is_null($result) ) {
            App::errorLog("db_error", "NULL");
            return;
        }
        

        return (object) $result;
    }

    // Post query
    public function create($data = [], $message = ""){
        $table = $this->table;
        $stringQuery = "INSERT INTO `$table` ";

        // create a syntax db keys
        $stringRow = "";

        $stringRow .= "( `id`, ";
        foreach ( $data as $key => $row ){
            $stringRow .= " `$key`,";
        }
        $stringRow .= ") VALUES ( NULL, ";
        $stringRow = str_replace(",)", ")", $stringRow);


        // create a syntax db values
        $stringValue = "";
        foreach ( $data as $key => $row ) {
            if( is_null($row) ){       
                $stringValue .= " NULL,";
            }else {
                $stringValue .= " '$row',";
            }
        }
        $stringValue .= ");";
        $stringValue = str_replace(",);", ");", $stringValue);
        
        // result
        $queryResult = $stringQuery . $stringRow . $stringValue;

        

        // execute
        $check = Database::query($queryResult);
        if( !$check ) {
            return false;
        }

        return [
            "status" => "success",
            "message" => $message
        ];
    }

    public function update($data = [], $id, $message = ""){
        $table = $this->table;
        
        $strQuery = "UPDATE `$table` SET ";
        foreach ( $data as $key => $row ){
            $res = htmlspecialchars($row);
            $strQuery .= "`$key` = '$res' ,";
        }
        // auto updated
        // $strQuery .= " `updated_at` = '" . App::date() . "'"; // if needed
        $strQuery .= " WHERE `$table`.`id` = $id";
        // $strQuery = str_replace(", WHERE", " WHERE", $strQuery);


        Database::query($strQuery);

        return [
            "status" => "success",
            "message" => $message
        ];
    }

    public function destroy($id) {
        $table = $this->table;
        //  DELETE FROM `user` WHERE `user`.`id` = 8
        $query = "DELETE FROM `$table` WHERE `$table`.`id` = $id";
        
        if (Database::query($query)) {
            return [
                "status" => "success",
                "message" => "Data berhasil dihapus !"
            ];
        }else {
            return [
                "status" => "error",
                "message" => "Data gagal dihapus !"
            ];
        }

    }

    
}