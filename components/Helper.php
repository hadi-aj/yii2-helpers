<?php

namespace app\components;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

class Helper extends Model {

    const PAGE_ARRAY = [2 => 2, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 200 => 200];

    public static function upload($thisModel, $file, $attribute) {
        $now = time();

        if ($thisModel->{$file}) {
            $fileName = $now . Yii::$app->security->generateRandomString() . '.' . $thisModel->{$file}->extension;
            if ($thisModel->{$file}->saveAs(Yii::getAlias('@webroot') . Yii::getAlias('@filesDir') . '/' . $fileName)) {
                $thisModel->{$attribute} = $fileName;
            }
        }
    }

    /**
     * 
     * @param ActiveDataProvider $dataProvider
     * @param integer $default
     * @param string $pageParam
     * @return array 
     */
    public static function pager(ActiveDataProvider $dataProvider, $default = 50, $pageParam = 'page-size') {
        $pageSize = Yii::$app->request->get($pageParam, $default);
        $dataProvider->setPagination(['pageSize' => $pageSize]);
//        echo '<pre>';
//        print_r($dataProvider->getPagination()->pageSize);
//        die;
        $pager = Html::dropDownList($pageParam, $pageSize, self::PAGE_ARRAY);
        return [
            'layout' => "{summary}\n{items}\n{pager}" . '<div class="pull-left">' . $pager . '</div>',
            'filterSelector' => 'select[name="' . $pageParam . '"]',
        ];
    }

    public static function getTotal($models, $fieldName) {
        $total = 0;

        foreach ($models as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }

    /**
     * 
     * @param Model $model
     * @param string $attribute
     * @return array
     */
    public static function getEnumValues($model, $attribute) {
        $type = $model->getTableSchema()->getColumn($attribute)->dbType;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
//        $enum = explode("','", $matches[1]);
//        return $enum;
        foreach (explode("','", $matches[1]) as $value) {
            $values[$value] = Yii::t('app', ucfirst(self::toCamelCase($value)));
        }
        return $values;
    }

    public static function toCamelCase($str) {
        return preg_replace('/(?!^)[[:upper:]]/', ' \0', $str);
    }

    public static function camelCaseVariableToPascalCaseString($str) {
        return ucfirst(preg_replace('/(?!^)[[:upper:]]/', ' \0', $str));
    }

}
