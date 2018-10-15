<?php

namespace app\commands;

use yii\console\controllers\MigrateController AS Base;

class Migrate2Controller extends Base {

    public function beforeAction($action) {
        $fields = [
            'title:string:notNull',
            'state:boolean:defaultValue(true)',
            'createdById:integer:foreignKey(user)',
            'created:dateTime',
            'modifiedById:integer:foreignKey(user)',
            'modified:dateTime',
        ];
        $this->fields = array_merge($this->fields, $fields);
        return parent::beforeAction($action);
    }

}
