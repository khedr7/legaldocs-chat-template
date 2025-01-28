<?php

namespace App\Console\ClassFileGenerator\Stubs;

trait FilesGenerator
{
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
        return $path;
    }

    public function fillFile($filePath, $content)
    {
        if (!$this->files->exists($filePath)) {
            $this->files->put($filePath, $content);
            $this->info("File : {$filePath} created");
        } else {
            $this->info("File : {$filePath} already exits");
        }
    }

    public function getSourceFilePath($fileName, $fileType)
    {
        $sourceFilesPaths = [
            'controller'            => base_path('App\\Http\\Controllers') . '\\' . $fileName . 'Controller.php',
            'service'               => base_path('App\\Services') . '\\' . $fileName . 'Service.php',
            'repository'            => base_path('App\\Repositories') . '\\' . $fileName . 'Repository.php',
            'model'                 => base_path('App\\Models') . '\\' . $fileName . '.php',
            'request'               => base_path('App\\Http\\Requests') . '\\' . $fileName . 'Request.php',
            'resource'              => base_path('App\\Http\\Resources') . '\\' . $fileName . 'Resource.php',
            // 'factory'               => database_path('factories') . '\\' . $fileName . 'Factory.php',
        ];
        return $sourceFilesPaths[$fileType];
    }
    
}
