<?php
namespace App\Database\contract;
use mysqli;
class Connection{
    private $db_server;
    private $db_username;
    private $db_password;
    private $db_name;
    private $conn;
    public function __construct(){
        $conn =new mysqli($this->db_server,$this->db_username,$this->db_password);
    }

}
?>