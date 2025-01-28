<?php

namespace App\Console\ClassFileGenerator;

trait ResourceGenerator
{
    public function getStubVariablesResource($className)
    {
        return [
            'modelName'     => $className,
            'columns'       => $this->getReadyColumnsForResource(),
        ];
    }

    public function getReadyColumnsForResource()
    {
        $columnsString = "'id' => \$this->id,\n";
        for ($i = 0; $i < count($this->tableColumns); $i++) {
            $columnsString = $columnsString . "            '" . $this->tableColumns[$i] . "' => \$this->" . $this->tableColumns[$i] . ",\n";
        }
        $columnsString = $columnsString . "            " .  "'created_at' => \$this->created_at";
        return $columnsString;
    }
}
