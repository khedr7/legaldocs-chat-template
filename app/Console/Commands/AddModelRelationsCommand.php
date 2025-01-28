<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\RelationsGenerator;

class AddModelRelationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:relation {modelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $relations = "";
    protected $modelName;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function addRelationsToModel($modelPath)
    {
        // Get the contents of the file
        $fileContents = file_get_contents($modelPath);

        // Find the position of the closing brace of the class
        $pos = strrpos($fileContents, '}');

        // Add your string after the closing brace of the class
        $newContents = substr($fileContents, 0, $pos) . $this->relations . substr($fileContents, $pos);

        // Save the new contents back to the file
        file_put_contents($modelPath, $newContents);
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->modelName = $this->argument('modelName');
        $modelPath = base_path('App\\Models') . '\\' . $this->modelName . '.php';

        if (class_exists("App\\Models\\" . $this->modelName)) {
            $b = true;
            $relationGenerator = new RelationsGenerator($this);
            $relationGenerator->setTableName($this->modelName);
            do {
                printf("1- belongsTo\n");
                printf("2- belongsToMany\n");
                printf("3- hasMany\n");
                printf("4- HasOne\n");
                printf("5- Exit\n");
                $selectedRelation = $this->ask('select the relation');
                switch (intval($selectedRelation)) {
                    case 1:
                        $relationGenerator->getBelongsToRelation();
                        break;
                    case 2:
                        $relationGenerator->getBelongsToManyRelation();
                        break;
                    case 3:
                        $relationGenerator->getHasManyRelation();
                        break;
                    case 4:
                        $relationGenerator->getHasOneRelation();
                        break;
                    case 5:
                        printf("5\n");
                        $b = false;
                        break;
                }
            } while ($b);
            $this->relations = $relationGenerator->relations;
            $this->addRelationsToModel($modelPath);

            printf("The model " . $this->modelName . " modefied successfully.");
        } else {
            printf("The model " . $this->modelName . " does not exist.");
        }
    }
}
