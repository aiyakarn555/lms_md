<?php
$columns=array(
    array(
        'name'=>'passcours_user',
        'filter'=>CHtml::activeTextField($model,'user_name'),
        'type' => 'raw',
        'value'=>'$data->NameUser',
        'htmlOptions' => array(
            'width'=>'120',
        ),
    ),
    array(
        'name'=>'passcours_cours',
        'filter'=>CHtml::activeTextField($model,'cours_name'),
        'type' => 'raw',
        'value'=>'$data->CourseOnlines->course_title',
    ),
    array(
        'name'=>'passcours_date',
        'value'=>'ClassFunction::datethai($data->passcours_date)',
        'htmlOptions' => array(
            'width'=>'110',
            'style' => 'text-align:center;',
        ),
        'filter'=>$this->widget('zii.widgets.jui.CJuiDatepicker', array(
            'model'=>$model,
            'attribute'=>'passcours_date',
            'htmlOptions' => array(
                'id' => 'passcours_date',
            ),  
            'options' => array(
                'mode'=>'focus',
                'dateFormat'=>'dd/mm/yy',
                'showOn' => 'focus', 
                'showOtherMonths' => true,
                'selectOtherMonths' => true,
                'yearRange' => '-5+10', 
                'changeMonth' => true,
                'changeYear' => true,
                'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
                'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
                    'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
    )), true)),
);
?>
<?php $this->widget('application.components.widgets.tlbExcelView', array(
    'id'                   => 'Passcours-grid',
    'dataProvider'         => $model->search(),
    'grid_mode'            => $production, // Same usage as EExcelView v0.33
    //'template'           => "{summary}\n{items}\n{exportbuttons}\n{pager}",
    'title'                => 'PrintReport - ' . date('d-m-Y - H-i-s'),
    'creator'              => 'Your Name',
    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
    'description'          => mb_convert_encoding('Etat de production généré à la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
    'lastModifiedBy'       => 'Some Name',
    'sheetTitle'           => 'Report on ' . date('m-d-Y H-i'),
    'keywords'             => '',
    'category'             => '',
    'landscapeDisplay'     => true, // Default: false
    'A4'                   => true, // Default: false - ie : Letter (PHPExcel default)
    'RTL'                  => false, // Default: false
    'pageFooterText'       => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
    'automaticSum'         => false, // Default: false
    'decimalSeparator'     => ',', // Default: '.'
    'thousandsSeparator'   => '.', // Default: ','
    //'displayZeros'       => false,
    //'zeroPlaceholder'    => '-',
    //'sumLabel'             => 'Column totals:', // Default: 'Totals'
    'rowHeight'            => 25, // Default: 15
    'headerHeight'         => 40, // Default: 20
    'footerHeight'         => 40, // Default: 20
    'columns'              => $columns, // an array of your CGridColumns
    // 'exportType'           => 'Excel2007',
)); ?>