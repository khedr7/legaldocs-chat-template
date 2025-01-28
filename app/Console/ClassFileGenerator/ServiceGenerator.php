<?php

namespace App\Console\ClassFileGenerator;

trait ServiceGenerator
{
    public function getStubVariablesService($className, $getSingularClassName)
    {
        return [
            'modelName'     => $className,
            'modelVar'      => $getSingularClassName
        ];
    }
}
