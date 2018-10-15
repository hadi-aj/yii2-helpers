<?php

namespace app\components\widgets\pwtdatepicker;

use yii\web\AssetBundle;

/**
 * @author Mohammad Mahdi Gholomian.
 * @copyright 2014 mm.gholamian@yahoo.com
 */
class PwtDatePickerAsset extends AssetBundle
{
	public $sourcePath = '@app/components/widgets/pwtdatepicker/assets';
	public $js = [
		'js/persian-date.min.js',
		'js/persian-datepicker.min.js',
//		'js/script.js',
	];
	public $css = [
		'css/persian-datepicker.min.css',
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}
