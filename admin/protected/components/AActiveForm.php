<?php
class AActiveForm extends CActiveForm
{
   	public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true,$enableClientValidation=true)
    {
        $html = '<div class="error help-block">';
        $html .= parent::error($model, $attribute, $htmlOptions, $enableAjaxValidation,$enableClientValidation);
        $html .= '</div>';

        return $html;
    }
}