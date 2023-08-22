<?php
$columns=array(
    array(
        'name'=>'user_id',
        'value'=>'$data->NameUser',
        'filter'=>CHtml::activeTextField($model,'user_name'),
        'htmlOptions' => array(
           'style' => 'width:110px',
        ),  
    ),
    array(
        'name'=>'order_bank',
        'filter'=>$this->listBankAll($model,'order_bank'),
        'type'=>'raw',
        'value'=>'$data->NameBankCheckPrint'
    ),
    array(
        'name'=>'order_cost',
        'value'=>'number_format($data->order_cost)',
        'htmlOptions' => array(
           'style' => 'width:90px; text-align:center;',
        ),  
    ),
    array(
        'name'=>'order_date_add',
        'type'=>'html',
        'value'=>'$data->DateConfirm',
           'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
               'model'=>$model,
               'attribute'=>'order_date_add',
               'htmlOptions' => array(
                   'id' => 'order_date_add',
                   //'style' => 'width:90px',
               ),  
               'options' => array(
                    'mode'=>'focus',
                    'dateFormat'=>'dd/mm/yy',
                    'showAnim' => 'slideDown',
                    'showOn' => 'focus', 
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'yearRange' => '-5+10', 
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
                    'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
                    'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
               )
           ), true)
    ),
    array(
        'name'=>'order_date_time',
        'type'=>'html',
        'value'=>'$data->TimeConfirm',
        'htmlOptions' => array(
           'style' => 'width:105px; text-align:center;',
        ),  
    ),
    array(
        'header'=>'การโอนเงิน',
        'filter'=>false,
        'name'=>'order_file',
        'type'=>'html',
        'value'=>'$data->CheckFileUp',
        'htmlOptions' => array(
           'style' => 'width:120px; text-align:center;',
        ),  
    ),
    /*array(
        'name'=>'order_point',
        'value'=>'number_format($data->order_point)',
        'htmlOptions' => array(
           'style' => 'width:50px',
        ),  
    ),*/
    // array(
    //     'name'=>'con_admin',
    //     'checkPoint'=>'orderonline',
    //     'class'=>'JToggleColumn',
    //     'filter' => array('0' => 'ยังไม่ได้ยืนยัน', '1' => 'ยืนยันแล้ว'), // filter
    //     'action'=>'toggle', // other action, default is 'toggle' action
    //     'checkedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/check.png',  // Image,text-label or Html
    //     'uncheckedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/delete.png', // Image,text-label or Html
    //     'checkedButtonTitle'=>'Yes.Click to No', // tooltip
    //     'uncheckedButtonTitle'=>'No. Click to Yes', // tooltip
    //     'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
    //     'htmlOptions'=>array('style'=>'text-align:center;width:115px;')
    // ),
);
?>
<?php $this->widget('application.components.widgets.tlbExcelView', array(
    'id'                   => 'Orderonline-grid',
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
    //'decimalSeparator'     => ',', // Default: '.'
    //'thousandsSeparator'   => '.', // Default: ','
    //'displayZeros'       => false,
    //'zeroPlaceholder'    => '-',
    //'sumLabel'             => 'Column totals:', // Default: 'Totals'
    'rowHeight'            => 25, // Default: 15
    'headerHeight'         => 40, // Default: 20
    'footerHeight'         => 40, // Default: 20
    'columns'              => $columns, // an array of your CGridColumns
    // 'exportType'           => 'Excel2007',
)); ?>