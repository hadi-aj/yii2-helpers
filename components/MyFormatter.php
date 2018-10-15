<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\imagine\Image;

class MyFormatter extends Formatter {

    function asPersianNumber($value) {

        $num = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return str_replace($num, $persian, str_replace($arabic, $persian, $value));
    }

    public function asState($value) {
        // translate your int value to something else...
        switch ($value) {
            case 0:
                return Yii::t('app', 'Unpublished');
            case 1:
                return Yii::t('app', 'Published');
            case -1:
                return Yii::t('app', 'Trash');
            default:
                return 'Unknown';
        }
    }

    public function asPay($value) {
        // translate your int value to something else...
        switch ($value) {
            case 0:
                return Yii::t('app', 'Not Paid');
            case 1:
                return Yii::t('app', 'Paid');
            default:
                return 'Unknown';
        }
    }

    public function asMyImage($image, $params = ['width' => '100px']) {


        if (is_string($image)) {
            $imageName = $image;
        } else {
            $imageName = $image->image;
        }

        if (!$imageName) {
            $imageName = 'default.jpg';
            $imagePath = Yii::getAlias('@defaultAssets');
        } else {
            $imagePath = Yii::getAlias('@imagesDir');
        }

        if (is_array(@$params['thumbnail'])) {

            $thWidth = $params['thumbnail']['width'];
            $thHeight = $params['thumbnail']['height'];
            $thBackground = $params['thumbnail']['background'] ? $params['thumbnail']['background'] : '#000';
            $thMode = ($params['thumbnail']['mode'] == 'inset' ? 'inset' : 'outbound');

            $thumbnailName = $thWidth . '_' . $thHeight . '_' . $thMode . '_' . str_replace('#', '', $thBackground) . '_' . $imageName;
            $thumbnailFile = Yii::getAlias('@webroot') . Yii::getAlias('@thumbnailDir') . '/' . $thumbnailName;

            if (!file_exists($thumbnailFile)) {
                Image::$thumbnailBackgroundColor = $thBackground;
                Image::thumbnail(Yii::getAlias('@webroot') . $imagePath . '/' . $imageName, $thWidth, $thHeight, $thMode == 'inset' ? ManipulatorInterface::THUMBNAIL_INSET : ManipulatorInterface::THUMBNAIL_OUTBOUND)
                        ->save($thumbnailFile);
            }

            $imagePath = Yii::getAlias('@thumbnailDir');
            $imageName = $thumbnailName;
            unset($params['thumbnail']);
        }
        return Html::img(Url::base(TRUE) . $imagePath . '/' . $imageName, $params);
    }

    public function asMyFile($file, $params = ['html' => '', 'class' => '']) {

        if (is_string($file)) {
            $src = $file;
        } else {
            $src = $file->file;
        }
        if ($file) {
            return Html::a('<i class="glyphicon glyphicon-download-alt"></i>' . $params['html'], Url::base(true) . Yii::getAlias('@filesDir') . '/' . $src, ['class' => $params['class']]);
        } else {
            return '';
        }
    }

    public function asJalaliDate($date, $format = 'Y-m-d H:i:s') {
        if ($date and $date != '0000-00-00 00:00:00' and $date != '0000-00-00') {
            return Yii::$app->jdate->date($format, strtotime($date));
        }
    }

    public function asJalali($date, $format = 'Y-m-d H:i:s') {
        return $this->asJalaliDate($date, $format);
    }

    /**
     * 
     * PARA: Date Should In YYYY-MM-DD Format
     * RESULT FORMAT:
     * '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
     * '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
     * '%m Month %d Day'                                            =>  3 Month 14 Day
     * '%d Day %h Hours'                                            =>  14 Day 11 Hours
     * '%d Day'                                                        =>  14 Days
     * '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
     * '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
     * '%h Hours                                                    =>  11 Hours
     * '%a Days                                                        =>  468 Days
     * 
     * 
     * @param type $date
     * @param type $format
     * @return type
     */
    public function asDateDifference($date_1, $date_2, $differenceFormat = '%a') {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    public function asTranslate($value, $params = ['category' => 'app']) {
        return Yii::t($params['category'], Helper::camelCaseVariableToPascalCaseString($value));
    }

    public function asIntegerToText($value, $params) {
        return $params[$value];
    }

    public function asToUrl($value, $params = ['url' => '', 'options' => []]) {
        return Html::a($value . $params['url'], $params['url'], $params['options']);
    }

}
