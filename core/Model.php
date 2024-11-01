<?php

namespace core;
/**
* @property string table
 */
class Model
{
    protected $fieldsValue;
    protected static $primaryKey='id';
    public static $tableName;

    public function __construct()
    {
        $this->fieldsValue=[];
    }
    public function __set(string $name, $value): void
    {
        $this->fieldsValue[$name]=$value;
    }
    public function __get(string $name)
    {
        return $this->fieldsValue[$name]??null;
    }

    public function save()
    {
        $id=$this->{static::$primaryKey};
        if(empty($id)){
           $res= Core::getInstance()->db->insert(static::$tableName,$this->fieldsValue);
        }
        else{
            $res = Core::getInstance()->db->update(static::$tableName,[static::$primaryKey =>['=', $id]],$this->fieldsValue);
        }

        return $res;
    }
    public static function deleteById($id)
    {
        Core::getInstance()->db->delete(static::$tableName,null,$id);
    }
    public static function deleteByCondition($where)
    {
        Core::getInstance()->db->delete(static::$tableName,$where);
    }
    public static function selectById($id)
    {
        $res=Core::getInstance()->db->select(static::$tableName,'*',[static::$primaryKey=>$id]);
        if (is_array($res) && count($res) > 0) {
            return $res[0];
        } else {
            return null;
        }
    }

    /**
     * @param $where array|bool associative array by type $associativeArray = ['field' => ['operator', 'value']],
     * @param $or array|bool associative array by type $associativeArray = ['field' => ['operator', 'value'],*or* 'field2' => ['operator2', 'value2']]
     * @param $and array|bool associative array by type $associativeArray = ['field' => ['operator', 'value'],*and* 'field2' => ['operator2', 'value2']]
     * @param $fields string|array * or "field1, field2", or ["field1","field2"]
     * @return array|false|null
     */
    public static function selectByCondition($where,$or=null,$and=null,$fields='*')
    {
        if(!empty($and)and !empty($or)){
            $res=Core::getInstance()->db->select(static::$tableName,$fields,$where,$or,$and);
        }
        else if(!empty($and)){
            $res=Core::getInstance()->db->select(static::$tableName,$fields,$where,null,$and);
        }
        else if (!empty($or)){
            $res=Core::getInstance()->db->select(static::$tableName,$fields,$where,$or);
        }
        else if (empty($or)&&empty($and)){
            $res=Core::getInstance()->db->select(static::$tableName,$fields,$where);
        }
        if (!empty($res)){
            return $res;
        }
        else{
            return null;
        }
    }
    public static function selectAll()
    {
        $res=Core::getInstance()->db->select(static::$tableName,'*');
        if (!empty($res)){
            return $res;
        }
        else{
            return null;
        }
    }
}