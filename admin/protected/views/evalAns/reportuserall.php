<?php
$columns=array(
    array(
        'header'=>'ชื่อผู้ทำ',
        'name'=>'user_id',
        'value'=>array($this,'gridUser'),
        'htmlOptions' => array(
           'style' => 'width:95px',
        ),  
    ),
    array(
        'header'=>'หัวข้อแบบสอบถาม',
        'name'=>'eva_id',
        'value'=>'$data->eva->eva_title',
        'htmlOptions' => array(
           'style' => 'width:95px',
        ),  
    ),
    array(
        'header'=>'มากที่สุด (5)',
        'name'=>'eval_answer',
        'value'=>' ($data->eval_answer == "5")?"✔":"" ',
        'htmlOptions' => array(
           'style' => 'width:95px;background: #000;',
        ),  
        'footer'=>'ผลรวม: ' . $model->getTotalAns($ans,"5"),
    ),
    array(
        'header'=>'มาก (4)',
        'name'=>'eval_answer',
        'value'=>' ($data->eval_answer == "4")?"✔":"" ',
        'htmlOptions' => array(
           'style' => 'width:95px;background: #000;',
        ),  
        'footer'=>'ผลรวม: ' . $model->getTotalAns($ans,"4"),
    ),
    array(
        'header'=>'ปานกลาง (3)',
        'name'=>'eval_answer',
        'value'=>' ($data->eval_answer == "3")?"✔":"" ',
        'htmlOptions' => array(
           'style' => 'width:95px;background: #000000;',
        ),  
        'footer'=>'ผลรวม: ' . $model->getTotalAns($ans,"3"),
    ),
    array(
        'header'=>'น้อย (2)',
        'name'=>'eval_answer',
        'value'=>' ($data->eval_answer == "2")?"✔":"" ',
        'htmlOptions' => array(
           'style' => 'width:95px;background: #000;',
        ),  
        'footer'=>'ผลรวม: ' . $model->getTotalAns($ans,"2"),
    ),
    array(
        'header'=>'น้อยที่สุด (1)',
        'name'=>'eval_answer',
        'value'=>' ($data->eval_answer == "1")?"✔":"" ',
        'htmlOptions' => array(
           'style' => 'width:95px;background: #000;',
        ),  
        'footer'=>'ผลรวม: ' . $model->getTotalAns($ans,"1"),
    ),
);
?>

<?php $this->widget('application.components.widgets.tlbExcelView', array(
    'id'                   => 'Order-grid',
    'dataProvider'         => $model->search($id=null,$ans),
    'grid_mode'            => $production, // Same usage as EExcelView v0.33
    'template'             => "{summary}\n{items}\n{exportbuttons}\n{pager}",
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
    'bgColor'              => 'FAFAFA', // Default: 'FFFFFF'
    'headerBgColor'        => 'CCE5FF', // Default: 'CCCCCC'
    //'borderColor'        => '333333', // Default: '000000'
    //'decimalSeparator'   => ',', // Default: '.'
    //'thousandsSeparator' => '.', // Default: ','
    //'displayZeros'       => false,
    //'zeroPlaceholder'    => '-',
    'sumLabel'             => 'Column totals:', // Default: 'Totals'
    'rowHeight'            => 25, // Default: 15
    'headerHeight'         => 40, // Default: 20
    'footerHeight'         => 40, // Default: 20
    'columns'              => $columns, // an array of your CGridColumns
    //'exportType'         => 'Excel2007',
)); ?>