<?php

namespace core;

class DB
{
    public $pdo;

    public function __construct($dbHost, $dbName, $dbLogin, $dbPassword)
    {
        $this->pdo = new \PDO("mysql:host={$dbHost},dbname={$dbName},{$dbLogin},{$dbPassword}");
    }

    /**
     * @param $table
     * @param $fields __ string or array
     * @param $where array associative array by type $associativeArray = ['field' => ['operator', 'value']],
     * @param $or array associative array by type $associativeArray = ['field' => ['operator', 'value'],*or* 'field2' => ['operator2', 'value2']]
     * @param $and array associative array by type $associativeArray = ['field' => ['operator', 'value'],*and* 'field2' => ['operator2', 'value2']]
     * @return array
     */
    public function select($table, $fields, $where = false, $or = false, $and = false)
    {
        if (is_array($fields)) {
            $arr = implode(', ', $fields);
            $fields = $arr;
        }
        else if(!is_string($fields)){
            $fields='*';
        }
        $query = "SELECT " . $fields . " FROM " . $table;
        if ($or) {
            if ($where) {
                $query= $this->whereTrue($query,$where);
                $query= $this->orTrue($query,$or);
            }
            else{
                $query.=" WHERE ";
                $query= $this->orTrue($query,$or);
            }
        }
        if ($and){
            if ($where) {
                $query= $this->whereTrue($query,$where);
                $query= $this->andTrue($query,$and);
            }
            else{
                $query.=" WHERE ";
                $query= $this->andTrue($query,$and);
            }
        }
        if ($where) {
            $this->whereTrue($query, $where);
        }

    }

    private function orTrue($query,$or)
    {
        $i=0;
        foreach ($or as $key=>$values){
            if (count($values) < 2) {
                return $query;
            }
            $query = $query . " OR " . $key . " " . $values[0] . " " . $values[1]." ";
            $i++;
            if($i<count($or)){
                $query.=" AND ";
            }
        }
        return $query;
    }
    private function andTrue($query,$and)
    {
        $i=0;
        foreach ($and as $key=>$values){
            if (count($values) < 2) {
                return $query;
            }
            $query = $query . " AND " . $key . " " . $values[0] . " " . $values[1]." ";
            $i++;
            if($i<count($and)){
                $query.=" AND ";
            }
        }
        return $query;
    }

    private function whereTrue($query,$where)
    {
        foreach ($where as $key => $values) {
            if (count($values) < 2) {
                return $query;
            }
            $query = $query . " WHERE " . $key . " " . $values[0] . " " . $values[1]." ";
        }
        return $query;
    }
}