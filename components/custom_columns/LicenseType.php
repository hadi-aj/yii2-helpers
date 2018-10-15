<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\custom_columns;

use yii\grid\DataColumn;

/**
 * Description of LicenseType
 *
 * @author hadi
 */
class LicenseType extends DataColumn {

    public $attribute = 'licenseType';
    public $format = ['translate'];
    public $filter = [
        'copy' => 'copy',
        'assignment' => 'assignment'
    ];

//    public function __set('sssssss') {
//        
//    }
//    public set
//
//
//    protected function renderFilterCellContent() {
//        
//    }
//    public $filter = [
//    'pending' => Yii::t('app', 'pending'),
//    'accepted' => Yii::t('app', 'accepted'),
//    'rejected' => Yii::t('app', 'rejected'),
//    ];
//    public $value = 'F';
}
