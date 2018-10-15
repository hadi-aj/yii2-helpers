<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\behaviors;

use hoomanMirghasemi\jdf\Jdf;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class JalaliToGregorianBehavior extends Behavior {

    public $attributes = [];

    public function events() {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event) {

        foreach ($this->attributes AS $atttibute) {
            if ($this->owner->{$atttibute}) {
                $this->owner->{$atttibute} = $this->convertArabicNumber($this->owner->{$atttibute});
                $jDateTemp = explode('/', explode(' ', $this->owner->{$atttibute})[0]);
                if ($jDateTemp[0] < 1500) {
                    $this->owner->{$atttibute} = Jdf::jalali_to_gregorian($jDateTemp[0], $jDateTemp[1], $jDateTemp[2], '-');
                }
            }
        }
    }

    private function convertArabicNumber($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

}
