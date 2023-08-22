<?php
$columns=array(
                                                array(
                                                        'header'=>'ลำดับที่',
                                                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',  //  row is zero based
                                                    'htmlOptions' => array(
						    	'width'=>'5%',
                                                        'style' => 'text-align:center;',
						  	),
                                                ),
                                                array(
							'header' => 'รหัสบัตรประชาชน',
							'type' => 'raw',
							'value' => function($data) {
								return $data['bookkeeper_id'];
							},
						),
                                                                 array(
							'header' => 'เลขทะเบียนผู้สอบบัญชี',
							'type' => 'raw',
							'value' => function($data) {
								return $data['auditor_id'];
							},
						),
                                                array(
							'header' => 'รหัสผู้ทำบัญชี',
							'type' => 'raw',
							'value' => function($data) {
								return $data['username'];
							},
						),
                                                array(
							'header' => 'คำนำหน้าชื่อ',
							'type' => 'raw',
							'value' => function($data) {
								return Helpers::title_name($data['title_id']);
							},
						),
						array(
							'header' => 'ชื่อ',
//							'name'=>'passcours_user',
//							'filter'=>CHtml::activeTextField($model,'user_name'),
							'type' => 'raw',
							'value'=>function($data) {
								return $data['firstname'];
							},
						    'htmlOptions' => array(
						    	'width'=>'120',
						  	),
						),
						array(
							'header' => 'นามสกุล',
//							'name'=>'passcours_user',
//							'filter'=>CHtml::activeTextField($model,'user_name'),
							'type' => 'raw',
							'value'=>function($data) {
								return $data['lastname'];
							},
						    'htmlOptions' => array(
						    	'width'=>'120',
						  	),
						),
                                                array(
							'header' => 'ประเภทสมาชิก',
							'type' => 'html',
							'value' => function($data) {
								return $data['name'];
							},
						),
						array(
                                                        'header' => 'วันที่สมัครเป็นสมาชิก',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data['create_at'], 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
                                                array(
                                                        'header' => 'วันที่เข้าอบรม',
//							'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate(Helpers::learn_date_from_course($data['passcours_cours'],$data['passcours_user']), 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
                                                    array(
                                                        'header' => 'วันที่จบการอบรม',
//							'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data['passcours_date'], 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
                                                    array(
                                                        'header' => 'วันที่ผ่านการสอบ 60%',
//							'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data['pass_60_date']);
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
                                                    array(
                                                        'header' => 'เวลาที่ผ่านการสอบ',
//							'name'=>'passcours_date',
							'value' => function($data) {
								return date("H:i",strtotime($data['pass_60_date'])).' น.';
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
						array(
							'header' => 'ที่อยู่',
							'type' => 'raw',
							'value' => function($data) {
								return $data['address'].' จ.'.Helpers::province_name($data['province']);
							},
						),
                                                                array(
							'header' => 'เบอร์โทร',
							'type' => 'raw',
							'value' => function($data) {
								return $data['phone'];
							},
						),
                                                                array(
							'header' => 'อีเมลล์',
							'type' => 'raw',
							'value' => function($data) {
								return $data['email'];
							},
						),
);
?>
<?php $this->widget('application.components.widgets.tlbExcelView', array(
    'id'                   => 'Passcpd-grid',
    'dataProvider'         => $dataProvider,//$model->highsearch(),
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