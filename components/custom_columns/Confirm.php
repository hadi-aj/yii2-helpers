<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\custom_columns;

use yii\grid\DataColumn;
use Yii;

/**
 * Description of Confirm
 *
 * @author hadi
 */
class Confirm extends DataColumn {

    public $attribute = 'confirm';
    public $format = ['translate'];
    public $filter = [
        'pending' => 'pending',
        'accepted' => 'accepted',
        'rejected' => 'rejected',
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
