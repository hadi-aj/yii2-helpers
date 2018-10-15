<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\custom_columns;

use yii\grid\DataColumn;

/**
 * Description of PublishType
 *
 * @author hadi
 */
class PublishType extends DataColumn {

    public $attribute = 'publishType';
    public $format = ['translate'];
    public $filter = [
        'public' => 'Public',
        'private' => 'Private',
    ];

}
