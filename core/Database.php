<?php

namespace Apollo\Core;

// https://codeshack.io/super-fast-php-mysql-database-class/

use mysqli;

/**
 * Class Database
 *
 * @package Apollo\Core
 */
class Database
{

    protected mysqli $connection;
    protected $query;
    public int $query_count = 0;

    /**
     * Database constructor.
     *
     * @param  array  $credentials
     * @param  string  $charset
     */
    public function __construct(
        array $credentials,
        string $charset = 'utf8'
    ) {
        $this->connection = new mysqli(
            $credentials[0],
            $credentials[1],
            $credentials[2],
            $credentials[3]
        );
        if ($this->connection->connect_error) {
            die(
                'Failed to connect to MySQL - '.$this->connection->connect_error
            );
        }
        $this->connection->set_charset($charset);
    }

    /**
     * @param $query
     *
     * @return $this
     */
    public function query($query)
    {
        if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                $x        = func_get_args();
                $args     = array_slice($x, 1);
                $types    = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types      .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                    } else {
                        $types      .= $this->_gettype($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }
                array_unshift($args_ref, $types);
                call_user_func_array(
                    array($this->query, 'bind_param'),
                    $args_ref
                );
            }
            $this->query->execute();
            if ($this->query->errno) {
                die(
                    'Unable to process MySQL query (check your params) - '
                    .$this->query->error
                );
            }
            $this->query_count++;
        } else {
            die(
                'Unable to prepare statement (check your syntax) - '
                .$this->connection->error
            );
        }

        return $this;
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        $params = array();
        $meta   = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            $r = array();
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            $result[] = $r;
        }
        $this->query->close();

        return $result;
    }

    /**
     * @return array
     */
    public function fetchArray()
    {
        $params = array();
        $meta   = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
        }
        $this->query->close();

        return $result;
    }

    /**
     * @return mixed
     */
    public function numRows()
    {
        $this->query->store_result();

        return $this->query->num_rows;
    }

    /**
     * @return bool
     */
    public function close()
    {
        return $this->connection->close();
    }

    /**
     * @return mixed
     */
    public function affectedRows()
    {
        return $this->query->affected_rows;
    }

    /**
     * @param $var
     *
     * @return string
     */
    private function _gettype($var)
    {
        if (is_string($var)) {
            return 's';
        }
        if (is_float($var)) {
            return 'd';
        }
        if (is_int($var)) {
            return 'i';
        }

        return 'b';
    }
}