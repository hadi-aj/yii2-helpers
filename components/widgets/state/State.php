<?php

namespace app\components\widgets\state;

use Yii;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class State extends InputWidget {

    public $items;

    public function init() {
        parent::init();
        $this->items = ['1' => Yii::t('app', 'Published'), '0' => Yii::t('app', 'Unpublished'), '-1' => Yii::t('app', 'Trash')];
        if (!$this->options['class']) {
            $this->options['class'] = 'form-control';
        }
    }

    public function run() {
        echo $this->renderInput();
    }

    /**
     * Render input.
     */
    function renderInput() {
        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            return Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }
    }

}
