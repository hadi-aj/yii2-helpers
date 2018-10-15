<?php

namespace app\components;

use Yii;
use yii\validators\Validator;

class MobileValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = Yii::t('app', 'Mobile is invalid');
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if(strlen($value) != 11 or !is_numeric($value) or substr($value, 0 , 2) != '09') {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
if ( value.length != 11 || value.substring(0, 2) != '09' || !(!isNaN(parseFloat(value)) && isFinite(value)) ) {
    messages.push($message);
}
JS;
    }
}
