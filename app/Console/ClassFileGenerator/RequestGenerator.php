<?php

namespace App\Console\ClassFileGenerator;

trait RequestGenerator
{
    public function getStubVariablesRequest($className)
    {
        return [
            'modelName'     => $className,
            'columns'       => $this->getReadyColumnsForRequest(),
        ];
    }

    public function getReadyColumnsForRequest()
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
