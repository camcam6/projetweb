<?php
namespace core;

use PDO;

class AppModel {

    private $conn;
    private $table;

    public function __construct()
    {
        try
        {
            $this->conn  = new PDO('mysql:host=localhost;dbname=site_miage', 'root', '');
            $this->table = strtolower(explode('\\', get_class($this))[2]);
            $this->conn->query("SET NAMES UTF8");
        }
        catch (\PDOException $e)
        {
            die('Erreur ! ' . $e->getMessage() . '<br>');
        }
    }

    public function count($conditions = [], $field = '*')
    {
        $cond  = '';

        if (isset($conditions['where']))
        {
            $cond = [];

            foreach ($conditions['where'] as $k => $v)
                array_push($cond, "$k = '$v'");

            $cond = ' WHERE ' . implode(' AND ', $cond);
        }

        return $this->conn->query("SELECT COUNT($field) FROM $this->table $cond")->fetchColumn();
    }

    public function max($conditions = [], $field = '*')
    {
        $cond  = '';

        if (isset($conditions['where']))
        {
            $cond = [];

            foreach ($conditions['where'] as $k => $v)
                array_push($cond, "$k = '$v'");

            $cond = ' WHERE ' . implode(' AND ', $cond);
        }

        return $this->conn->query("SELECT MAX($field) FROM $this->table $cond")->fetchColumn();
    }

    public function find($conditions = [],$join = [], $fields = [])
    {
        $cond   = '';
        $j      = '';
        $order  = '';

        if (empty($fields))
            $fields = '*';
        else
            $fields = implode(', ', $fields);

        if (isset($conditions['where']))
        {
            $cond = [];

            foreach ($conditions['where'] as $k => $v)
                array_push($cond, "$k = '$v'");

            $cond = ' WHERE ' . implode(' AND ', $cond);
        }

        if (isset($conditions['order']))
        {
            $order = [];

            foreach ($conditions['order'] as $field => $type)
                array_push($order, "$field $type");

            $order = ' ORDER BY ' . implode(' ', $order);
        }

        if (!empty($join)) {
            $j = [];

            foreach ($join as $table => $keys)
                array_push($j, "JOIN $table ON " . $keys[0] . ' = ' . $keys[1]);

            $j = implode(' ', $j);
        }

        return $this->conn->query("SELECT $fields FROM $this->table $j $cond $order")->fetchAll(\PDO::FETCH_OBJ);
    }

    public function save($data)
    {
        $columns = implode(', ', array_keys($data));
        $values  = "'" . implode("', '", array_values($data)) ."'";
        $stmt    = $this->conn->prepare("INSERT INTO $this->table($columns) VALUES($values)");

        return $stmt->execute();
    }

    public function update($data, $conditions = [])
    {
        $set  = '';
        $cond = '';

        if (!empty($data))
        {
            $set = [];

            foreach ($data as $c => $v)
                array_push($set, "$c = '$v'");

            $set = 'SET ' . implode(', ', $set);
        }
        else
            die('Erreur lors de l\'update. Vous devez préciser des données.');

        if (isset($conditions['where']))
        {
            $cond = [];

            foreach ($conditions['where'] as $k => $v)
                array_push($cond, "$k = '$v'");

            $cond = ' WHERE ' . implode(' AND ', $cond);
        }

        return $this->conn->query("UPDATE $this->table $set $cond");
    }

    public function delete($column, $value)
    {
        return $this->conn->query("DELETE FROM $this->table WHERE $column = '$value'");
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function __destruct()
    {
        $this->conn = null;
    }

}