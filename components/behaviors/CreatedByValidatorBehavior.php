<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\behaviors;

use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CreatedByValidatorBehavior extends Behavior {

    public $attributes = [];
    public $createdById = 'createdById';

    public function events() {
        return [
            SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeDelete',
        ];
    }

    public function beforeDelete($event) {
        if(YII_ENV_DEV) {
            return TRUE;
        }
        if ($this->owner->{$this->createdById} != Yii::$app->user->id) {
            $event->isValid = FALSE;
        }
    }

}
