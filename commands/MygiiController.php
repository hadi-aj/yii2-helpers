<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class MygiiController extends Controller {

    public $modelName;
    public $modelPath;
    public $moduleName;
    public $controllerName;
    public $modulePath;
    public $ns = 'app\models\base';
    public $db = 'db';


    public function options($actionID) {
        return ['modelName', 'modelPath', 'moduleName', 'controllerName' , 'modulePath', 'ns', 'db'];
    }

    public function actionIndex() {

        Yii::$app->runAction('gii/model', [
            'interactive' => 0,
            'overwrite' => true,
            'enableI18N' => true,
            'tableName' => '*',
            'ns' => $this->ns,
            'db' => $this->db
        ]);
    }

    public function actionCrud() {

        if (!$this->moduleName or ! $this->modelName) {
            echo "Pllease set moduleName & modelName \n";
            die;
        }

        if ($this->controllerName) {
            $this->controllerName = $this->modelName;
        }
        
        if (!$this->modelPath) {
            $this->modelPath = 'app\models';
        }
        
        if (!$this->modulePath) {
            $this->modulePath = $this->moduleName;
        }

        Yii::$app->runAction('gii/crud', [
            'controllerClass' => 'app\modules\\' . $this->modulePath . '\controllers\\' . $this->modelName . 'Controller',
            'modelClass' =>  $this->modelPath . '\\' . $this->modelName,
            'searchModelClass' => $this->modelPath. '\\' . $this->modelName . 'Search',
            'viewPath' => '@app/modules/' . $this->modulePath . '/views/' . strtolower(preg_replace('/(?!^)[[:upper:]]/', '-\0', $this->modelName)),
            'enableI18N' => true,
//            'db' => $this->db
//            'interactive' => 0,
//            'overwrite' => true,
//            'tableName' => '*',
//            'ns' => 'app\models\base'
        ]);
    }

    public function actionCreateModels() {

        $models = array_diff(scandir(Yii::getAlias('@app') . '/models'), ['..', '.']);
        $baseModels = array_diff(scandir(Yii::getAlias('@app') . '/models/base'), ['..', '.'] + $models);

        $modelFile = <<< EOT
<?php

namespace app\models;

use app\models\base\CLASS_NAME as Base;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class CLASS_NAME extends Base {

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'modified'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modified'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdById',
                'updatedByAttribute' => 'modifiedById',
            ],
        ];
    }

    public function rules() {
        \$rules = parent::rules();
        \$rules[] = [['!createdById', '!modifiedById'], 'integer'];
        \$rules[] = [['!created', '!modified'], 'string'];
        return \$rules;
    }

}        
                
EOT;
        
        foreach ($baseModels AS $baseModel) {
            $baseModelName = Yii::getAlias('@app') . '/models/base/' . $baseModel;
            echo $baseModelName;
            echo "\n";
            if (strpos(file_get_contents($baseModelName), 'createdById')) {
                $modelName = Yii::getAlias('@app') . '/models/' . $baseModel;
                file_put_contents($modelName, str_replace('CLASS_NAME', str_replace('.php', '', $baseModel), $modelFile));
                chmod($modelName, 0777);
                echo "generated" . $modelName . "\n";
            }
        }
        echo "done! \n";
    }

}
