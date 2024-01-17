<?php
include_once "MySQL_Access.php";

class Theater_DB_Access extends MySQL_Access{
    var $host_name = "localhost";
    var $db_name = "theaters";
    var $user_name = "root";
    var $password = "";
}
