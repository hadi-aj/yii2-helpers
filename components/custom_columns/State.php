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
class State extends DataColumn {

    public $attribute = 'state';
    public $format = ['state'];

    public function __construct($config = array()) {
        
        $this->filter['1'] =  Yii::t('app', 'Published');
        $this->filter['0'] =  Yii::t('app', 'Unpublished');
        $this->filter['-1'] =  Yii::t('app', 'Trash');

        return parent::__construct($config);
    }
}
