<?php

/**
 * MySQLIQuickn
 * ============
 *
 * Author: chrisbuchholz
 * URL: https://github.com/ChrisBuchholz/MySQLIQuickn
 * Description:
 *  small library that makes using MySQLI even quicker to get done
 *  for the generel CRUD tasks that you use again, and again and again...
 *
 *  Written solely for the purpose of use for my PHP assignments in school.
 *
 * Usage:
 *  Should be quite self-explanatory.
 *  Only requirements is of five defined constants:
 *      MYSQL_HOST
 *      MYSQL_USER
 *      MYSQL_PASSWORD
 *      MYSQL_DATABASE
 *      MYSQL_CHARSET     
 **/ 

class MySQL {

    private $result = NULL;
    private $link = NULL;

    public function __construct() {
        if(false === ($this->link = mysqli_connect(MYSQL_HOST, MYSQL_USER,
            MYSQL_PASSWORD, MYSQL_DATABASE))) {
            throw new Exception('Error: ' . mysqli_connect_error());
        }
        $this->link->set_charset(MYSQL_CHARSET);
    }

    public function query($query) {
        if(is_string($query) && empty($query) === false) {
            if(false === ($this->result = mysqli_query($this->link, $query))) {
                throw new Exception('Error performing query: ' . $query
                    . ', error message: ' . mysqli_error($this->link));
                return false;
            }
            return true;
        }
        return false;
    }

    public function fetch() {
        if(false === ($row = mysqli_fetch_assoc($this->result))) {
            mysqli_free_result($this->result);
            return false;
        }
        return $row;
    }

    public function getInsertID() {
        return mysqli_insert_id($this->link);
    }

    public function count_rows() {
        if($this->result !== NULL) {
            return mysqli_num_rows($this->result);
        }
    }

    public function escape($str) {
        return $this->link->real_escape_string($str);
    }

    function __destruct() {
        mysqli_close($this->link);
    }

}
