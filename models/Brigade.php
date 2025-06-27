<?php
namespace models;
use core\Model;

class Brigade extends Model
{
    public static $tableName = 'brigades';
    public function toObj(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }
}
