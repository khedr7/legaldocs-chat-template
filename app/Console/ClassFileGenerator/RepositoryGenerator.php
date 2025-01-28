<?php

namespace App\Console\ClassFileGenerator;

trait RepositoryGenerator
{
    public function getStubVariablesRepository($className, $getSingularClassName)
    {
        return [
            'modelName'     => $className,
            'modelVar'      => $getSingularClassName
        ];
    }
}
