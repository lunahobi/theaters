<?php
class MySQL_Access
{
    var $host_name = "";
    var $user_name = "";
    var $password = "";
    var $db_name = "";
    var $conn_id = 0;
    var $errno = 0;
    var $errstr = "";
    var $halt_on_error = 1;
    var $query_pieces = array();
    var $result_id = 0;
    var $num_rows = 0;
    var $row = array();

    function connect()
    {
        $this->errno = 0;
        $this->errstr = "";

        if ($this->conn_id == 0) { // установить соединение, если оно ещё не установлено
            $this->conn_id = @mysqli_connect($this->host_name, $this->user_name, $this->password);

            if (!$this->conn_id) {
                $this->errno = mysqli_connect_errno();
                $this->errstr = mysqli_connect_error();
                $this->error("Cannot connect to server");
                return (FALSE);
            }

            if (isset($this->db_name) && $this->db_name != "") {
                if (!@mysqli_select_db($this->conn_id, $this->db_name)) {
                    $this->errno = mysqli_errno($this->conn_id);
                    $this->errstr = mysqli_error($this->conn_id);
                    $this->error("Cannot select database");
                    return (FALSE);
                }
            }
        }

        return ($this->conn_id);
    }

    function disconnect()
    {
        if ($this->conn_id != 0) {
            mysqli_close($this->conn_id);
            $this->conn_id = 0;
        }
        return (true);
    }

    public function resetConnection()
    {
        $this->disconnect(); // Предполагается, что у вас есть метод disconnect для закрытия текущего соединения
        $this->connect();    // Предполагается, что у вас есть метод connect для установки нового соединения
    }

    function error($msg)
    {
        if (!$this->halt_on_error) return;
        $msg .= "\n";
        if ($this->errno)
            $msg .= sprintf("Error: %s (%d)\n", $this->errstr, $this->errno);
        die(nl2br(htmlspecialchars($msg)));
    }

    function issue_query($arg = "")
    {
        if ($arg == "")
            $arg = array();
        if (!$this->connect())
            return (FALSE);
        if (is_string($arg))
            $query_str = $arg;
        else if (is_array($arg)) {
            if (count($arg) != count($this->query_pieces) - 1) {
                $this->errno = -1;
                $this->errstr - "data value/placeholder count mismatch";
                $this->error("Cannot execute query");
                return (FALSE);
            }
            $query_str = $this->query_pieces[0];
            for ($i = 0; $i < count($arg); $i++) {
                $query_str .= $this->sql_quote($arg[$i])
                    . $this->query_pieces[$i + 1];
            }
        } else {
            $this->errno = -1;
            $this->errstr = "unknown argument type to issue_query";
            $this->error("Cannot execute query");
            return (FALSE);
        }
        $this->num_rows = 0;
        $this->result_id = mysqli_query($this->conn_id, $query_str);
        $this->errno = mysqli_connect_errno();
        $this->errstr = mysqli_connect_error();
        if ($this->errno) {
            $this->error("Cannot execute query: $query_str");
            return (FALSE);
        }
        $this->num_rows = mysqli_affected_rows($this->conn_id);
        return ($this->result_id);
    }

    function fetch_row()
    {
        $this->row = mysqli_fetch_row($this->result_id);

        if ($this->row === null) {
            // Записей больше нет, освободим ресурсы
            $this->free_result();
            return false;
        }

        return $this->row;
    }


    function fetch_array()
    {
        $this->row = mysqli_fetch_array($this->result_id);
        $this->errno = mysqli_connect_errno();
        $this->errstr = mysqli_connect_error();
        if ($this->errno) {
            $this->error("fetch_array error");
            return (FALSE);
        }
        if (is_array($this->row))
            return ($this->row);
        $this->free_result();
        return (FALSE);
    }

    function fetch_object()
    {
        $this->row = mysqli_fetch_object($this->result_id);
        $this->errno = mysqli_connect_errno();
        $this->errstr = mysqli_connect_error();
        if ($this->errno) {
            $this->error("fetch_object error");
            return (FALSE);
        }
        if (is_array($this->row))
            return ($this->row);
        $this->free_result();
        return (FALSE);
    }


    function free_result()
    {
        if ($this->result_id)
            mysqli_free_result($this->result_id);
        $this->result_id = 0;
        return (TRUE);
    }

    function sql_quote($str)
    {
        if (!isset($str))
            return ("NULL");
        $func = function_exists("mysqli_real_escape_string")
            ? "mysqli_real_escape_string"
            : "addslashes";
        return ("'" . $func($this->conn_id, $str) . "'");
    }

    function prepare_query($query)
    {
        $this->query_pieces = explode("?", $query);
        return (TRUE);
    }

    function count_rows($result): int {
        return mysqli_num_rows($result);
    }
}
