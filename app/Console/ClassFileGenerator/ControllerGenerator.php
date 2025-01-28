<?php

namespace App\Console\ClassFileGenerator;

trait ControllerGenerator
{
    public function getStubVariablesController($className, $getPluralClassName, $getSingularClassName)
    {
        return [
            'modelName'       => $className,
            'pluralModelVar'  => $getPluralClassName,
            'modelVar'        => $getSingularClassName
        ];
    }
}
