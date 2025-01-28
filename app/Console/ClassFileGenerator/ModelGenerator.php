<?php

namespace App\Console\ClassFileGenerator;

trait ModelGenerator
{
    public function getStubVariablesModel($className)
    {
        return [
            'modelName'          => $className,
            'relationsFunctions' => $this->relations,
            'tableName'          => $this->tableName,
            'columnsFillables'   => $this->getReadyFillableForModel(),
            'columnsCasts'       => $this->getReadyCastsForModel(),
        ];
    }

    public function getReadyFillableForModel()
    {
        $columnsString = implode("',\n        '", $this->tableColumns);
        return "'" . $columnsString . "'";
    }

    public function getReadyCastsForModel()
    {
        $casts = '';
        foreach ($this->tableColumnsTypes[$this->tableName] as $key => $value) {
            if ($value === 'int') {
                $casts .= "'$key' => 'integer', ";
            } elseif ($value === 'float') {
                $casts .= "'$key' => 'float', ";
            } elseif ($value === 'bool') {
                $casts .= "'$key' => 'boolean', ";
            } elseif ($value === 'datetime') {
                $casts .= "'$key' => 'datetime', ";
            } else {
                $casts .= "'$key' => 'string', ";
            }
        }
        return $casts;
    }
}
