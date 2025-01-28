<?php

namespace App\Console\Commands;

use App\Traits\StringHelper;
use Illuminate\Console\Command;

class RelationsGenerator
{
    use StringHelper;


    protected $tableName;
    public $relations = "";
    public Command $command;
    public function __construct(Command $command)
    {
        // parent::__construct();
        $this->command = $command;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }


    public function getBelongsToRelation()
    {
        $tableName = $this->command->ask("table name?");
        $foreignKey = $this->command->ask("foreign key name?(or press d for default value)");
        $idKey = $this->command->ask("id name?(or press d for default value)");

        if ($foreignKey == "d") {
            $foreignKey = StringHelper::getSingularVarName($tableName) . "_id";
        }
        if ($idKey == "d") {
            $idKey =  "id";
        }


        $this->relations .=  "
    public function " . StringHelper::getSingularVarName($tableName) . "()
    {
        return \$this->belongsTo(" . $this->getModelNameFromTableName($tableName) . "::class, '" . $foreignKey . "', '" . $idKey . "');
    }
    \n";
    }

    public function getHasManyRelation()
    {
        $tableName = $this->command->ask("table name?");
        $foreignKey = $this->command->ask("foreign key name?(or press d for default value)");
        $idKey = $this->command->ask("id name?(or press d for default value)");

        if ($foreignKey == "d") {
            $foreignKey = StringHelper::getSingularVarName($this->tableName) . "_id";
        }
        if ($idKey == "d") {
            $idKey =  "id";
        }


        $this->relations .=  "
    public function " . StringHelper::getPluralVarName($tableName) . "()
    {
        return \$this->hasMany(" . $this->getModelNameFromTableName($tableName) . "::class, '" . $foreignKey . "', '" . $idKey . "');
    }
    \n";
    }

    public function getHasOneRelation()
    {
        $tableName = $this->command->ask("table name?");
        $foreignKey = $this->command->ask("foreign key name?(or press d for default value)");
        $idKey = $this->command->ask("id name?(or press d for default value)");

        if ($foreignKey == "d") {
            $foreignKey = StringHelper::getSingularVarName($this->tableName) . "_id";
        }
        if ($idKey == "d") {
            $idKey =  "id";
        }


        $this->relations .=  "
    public function " . StringHelper::getSingularVarName($tableName) . "()
    {
        return \$this->hasOne(" . $this->getModelNameFromTableName($tableName) . "::class, '" . $foreignKey . "', '" . $idKey . "');
    }
    \n";
    }

    public function getBelongsToManyRelation()
    {
        $tableName = $this->command->ask("table name?");
        $pivotTableName = $this->command->ask("pivot table name ?");

        $foreignPivotKey = $this->command->ask("foreign pivot key  name ? (or press d for default value)");
        $foreignRelatedKey = $this->command->ask("foreign related key  name ? (or press d for default value)");
        $parentKey = $this->command->ask("parent key name ? (or press d for default value)");
        $relatedKey = $this->command->ask("related key name ? (or press d for default value)");

        if ($foreignPivotKey == "d") {
            $foreignPivotKey = StringHelper::getSingularVarName($this->tableName) . "_id";
        }
        if ($parentKey == "d") {
            $parentKey =  "id";
        }

        if ($foreignRelatedKey == "d") {
            $foreignRelatedKey = StringHelper::getSingularVarName($tableName) . "_id";
        }
        if ($relatedKey == "d") {
            $relatedKey =  "id";
        }


        $this->relations .=  "
    public function " . StringHelper::getPluralVarName($tableName) . "()
    {
        return \$this->belongsToMany(" . $this->getModelNameFromTableName($tableName) . "::class,'" . $pivotTableName . "', '" . $foreignPivotKey . "','" . $foreignRelatedKey . "','" . $parentKey . "', '" . $relatedKey . "');
    }
    \n";
    }
}
