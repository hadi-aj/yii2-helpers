<?php

namespace app\components\widgets\pwtdatepicker;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class PwtDatepicker extends InputWidget {

    public $pluginOptions;

    public function init() {
        parent::init();
        if ($this->options['class'] == NULL) {
            $this->options['class'] = 'form-control text-left ltr';
        }
        if (!$this->pluginOptions['format']) {
            $this->pluginOptions['format'] = 'YYYY/MM/DD';
        }
        if ($this->pluginOptions['initialValue'] === NULL) {
            $this->pluginOptions['initialValue'] = (boolean) ($this->model->{$this->attribute} ?: $this->value);
        }
    }

    public function run() {
        echo $this->renderInput();

        PwtDatePickerAsset::register($this->getView());

        $this->renderJsCode();
    }

    /**
     * Render input.
     */
    function renderInput() {

        $html = '';
        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::textInput($this->name, $this->value, $this->options);
        }
        return $html;
    }

    function renderJsCode() {
        $id = $this->options['id'];

        if ($this->pluginOptions['inline']) {

            $this->pluginOptions['altField'] = "#{$id}";
            $this->pluginOptions['altFormat'] = $this->pluginOptions['format'];


            $id = $this->options['inlineTagId'];
        }

        $options = Json::encode($this->pluginOptions);
        $js = "$('#{$id}').persianDatepicker({$options});";
        $this->getView()->registerJs($js);
    }

}
