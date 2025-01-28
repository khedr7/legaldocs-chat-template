<?php

namespace App\Console\ClassFileGenerator\Stubs;

use App\Console\ClassFileGenerator\ModelGenerator;
use App\Console\ClassFileGenerator\ControllerGenerator;
use App\Console\ClassFileGenerator\FactoryGenerator;
use App\Console\ClassFileGenerator\RepositoryGenerator;
use App\Console\ClassFileGenerator\RequestGenerator;
use App\Console\ClassFileGenerator\ResourceGenerator;
use App\Console\ClassFileGenerator\ServiceGenerator;

trait StubsGenerator
{
    use ModelGenerator,
        ControllerGenerator,
        FactoryGenerator,
        RepositoryGenerator,
        RequestGenerator,
        ResourceGenerator,
        ServiceGenerator;

    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    public function getStubPath($stubType)
    {
        $stubPaths = [
            'controller'            => __DIR__ . '/../../../../stubs/controller.crud.stub',
            'service'               => __DIR__ . '/../../../../stubs/service.stub',
            'repository'            => __DIR__ . '/../../../../stubs/repository.stub',
            'model'                 => __DIR__ . '/../../../../stubs/model.filled.stub',
            'request'               => __DIR__ . '/../../../../stubs/request.filled.stub',
            'resource'              => __DIR__ . '/../../../../stubs/resource.filled.stub',
            'factory'               => __DIR__ . '/../../../../stubs/factory.filled.stub'
        ];
        $stubPath = $stubPaths[$stubType];
        if (!file_exists($stubPath)) {
            throw new \Exception("Stub file '$stubType' not found at '$stubPath'");
        }
        return $stubPath;
    }

    public function getStubVariables($stubType, $tableColumns)
    {
        $className            = $this->getClassNameFromTableName();
        $getPluralClassName   = $this->getPluralVarName();
        $getSingularClassName = $this->getSingularVarName();
        return match ($stubType) {
            'controller'   =>  $this->getStubVariablesController($className, $getPluralClassName, $getSingularClassName),
            'model'        =>  $this->getStubVariablesModel($className),
            'service'      =>  $this->getStubVariablesService($className, $getSingularClassName),
            'repository'   =>  $this->getStubVariablesRepository($className, $getSingularClassName),
            'request'      =>  $this->getStubVariablesRequest($className),
            'resource'     =>  $this->getStubVariablesResource($className),
            'factory'      =>  $this->getStubVariablesFactory($className),
        };
    }
}
