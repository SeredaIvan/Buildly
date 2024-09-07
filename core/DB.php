<?php
namespace core;

class DB
{
    public $pdo;

    public function __construct($dbHost, $dbName, $dbLogin, $dbPassword)
    {
        $this->pdo = new \PDO("mysql:host={$dbHost};dbname={$dbName}", $dbLogin, $dbPassword);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function insert($table, $fieldsAndValues)
    {
        $columns = implode(', ', array_keys($fieldsAndValues));

        $plugs = implode(', ', array_map(fn($key) => ":$key", array_keys($fieldsAndValues)));

        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$plugs})";

        $smt = $this->pdo->prepare($query);

        foreach ($fieldsAndValues as $key => &$value) {
            $smt->bindParam(":$key", $value);
        }

        $smt->execute();

        return $this->pdo->lastInsertId();
    }

    /**
     * @param $table string
     * @param $fields string|array
     * @param $where array|bool associative array by type $associativeArray = ['field' => ['operator', 'value']],
     * @param $or array|bool associative array by type $associativeArray = ['field' => ['operator', 'value'],*or* 'field2' => ['operator2', 'value2']]
     * @param $and array|bool associative array by type $associativeArray = ['field' => ['operator', 'value'],*and* 'field2' => ['operator2', 'value2']]
     * @return array
     */
    public function select($table, $fields, $where = false, $or = false, $and = false)
    {
        if (is_array($fields)) {
            $fields = implode(', ', $fields);
        } else if (!is_string($fields)) {
            $fields = '*';
        }

        $query = "SELECT $fields FROM $table";
        $params = [];

        if ($where) {
            $query = $this->whereTrue($query, $where, $params);
        }

        if ($and) {
            $query = $this->andTrue($query, $and, $params);
        }

        if ($or) {
            $query = $this->orTrue($query, $or, $params);
        }

        echo $query;
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $key => &$value) {
            $stmt->bindParam($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($table, $where = false, $id = false)
    {
        $query = "DELETE FROM {$table} WHERE ";

        if ($id) {
            $query .= "id = :id";
            $smt = $this->pdo->prepare($query);
            $smt->bindParam(':id', $id, \PDO::PARAM_INT);
            echo 'HOH';
            return $smt->execute();
        }
        else {
            if (count($where) == 1) {
                $key = array_keys($where)[0];
                $value = array_values($where)[0];
            }

            if (count($value) > 1) {
                $query .= "{$key} {$value[0]} :{$key}";
                $smt = $this->pdo->prepare($query);
                $smt->bindParam(":{$key}", $value[1]);
                echo 'HOH';
                return $smt->execute();
            }
            else {
                $query .= "{$key} = :{$key}";
                $smt = $this->pdo->prepare($query);
                $smt->bindParam(":{$key}", $value);
                echo 'HOH';
                return $smt->execute();
            }
        }
    }
    public function update($table, $where, $updateData)
    {
        $query = "UPDATE {$table} SET ";

        $updateFields = array_keys($updateData);
        $setPart = [];
        foreach ($updateFields as $field) {
            $setPart[] = "{$field} = :{$field}";
        }
        $query .= implode(", ", $setPart);

        $whereFields = array_keys($where);
        $query .= " WHERE ";
        $wherePart = [];
        foreach ($whereFields as $field) {
            if (is_array($where[$field])) {
                $operator = $where[$field][0];
                $value = $where[$field][1];
                $wherePart[] = "{$field} {$operator} :where_{$field}";
            } else {
                $wherePart[] = "{$field} = :where_{$field}";
            }
        }
        $query .= implode(" AND ", $wherePart);

        $smt = $this->pdo->prepare($query);

        foreach ($updateData as $field => &$value) {
            $smt->bindParam(":{$field}", $value);
        }

        foreach ($where as $field => $condition) {
            if (is_array($condition)) {
                $smt->bindParam(":where_{$field}", $condition[1]);
            } else {
                $smt->bindParam(":where_{$field}", $condition);
            }
        }

        return $smt->execute();
    }


    private function orTrue($query, $or, &$params)
    {
        $i = 0;

        foreach ($or as $key => $values) {
            if (count($values) < 2) {
                continue;
            }

            if ($i > 0) {
                $query .= " OR ";
            }else {
                $query .= " OR ";
            }

            $query .= "$key {$values[0]} :or_$key";
            $params[":or_$key"] = $values[1];
            $i++;
        }

        return $query;
    }

    private function andTrue($query, $and, &$params)
    {
        $i = 0;
        foreach ($and as $key => $values) {
            if (count($values) < 2) {
                continue;
            }

            if ($i > 0) {
                $query .= " AND ";
            } else {
                $query .= " AND ";
            }

            $query .= "$key {$values[0]} :and_$key";
            $params[":and_$key"] = $values[1];
            $i++;
        }

        return $query;
    }


    private function whereTrue($query, $where, &$params)
    {
        $i = 0;
        $query .= " WHERE ";

        foreach ($where as $key => $values) {
            if (count($values) < 2) {
                continue;
            }

            if ($i > 0) {
                $query .= " AND ";
            }

            $query .= "$key {$values[0]} :where_$key";
            $params[":where_$key"] = $values[1];
            $i++;
        }

        return $query;
    }
}
