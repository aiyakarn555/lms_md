<?php
Yii::app()->params['TEXT_ACTIVE'] = 'Active'; //1 for active

// Yii::app()->params['IMAGE_SIZE']['THUMB']['WIDTH']

// Yii::app()->params['IMAGE_SIZE']['THUMB']['HEIGHT']
Yii::app()->params['IMAGE_SIZE'] = array(
    "FULL" => array(
        'WIDTH' => '980',
        'HEIGHT' => '540'
    ),
    "THUMB" => array(
        'WIDTH' => '300',
        'HEIGHT' => '180'
    ),
    "SLIDE" => array(
        'WIDTH' => '1000',
        'HEIGHT' => '300'
    ),
);