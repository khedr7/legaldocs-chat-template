<?php

namespace App\Console\ClassFileGenerator;

trait FactoryGenerator
{
    public function getStubVariablesFactory($className)
    {
        return [
            'modelName'     => $className,
            'columns'       => $this->getReadyColumnsForFactory(),
        ];
    }

    public function getReadyColumnsForFactory()
    {
        $columnsString = "";
        for ($i = 0; $i < count($this->tableColumns); $i++) {
            if ($i != count($this->tableColumns) - 1) {
                if ($i == 0) {
                    $columnsString = $columnsString . "'" . $this->tableColumns[$i] . "' => '',\n";
                } else {
                    $columnsString = $columnsString . "            '" . $this->tableColumns[$i] . "' => '',\n";
                }
            } else {
                $columnsString = $columnsString . "            '" . $this->tableColumns[$i] . "' => ''";
            }
        }
        return $columnsString;
    }
}
