<?php

namespace app\components\behaviors;

use yii\base\Behavior;
use yii\base\Model;

class TrimBehavior extends Behavior
{

    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        $attributes = $this->owner->attributes;
        foreach($attributes as $key => $value) { //For all model attributes
            $this->owner->$key = trim($this->owner->$key);
        }
    }
}