<?php 
$this->widget('booster.widgets.TbGridView',array(
            'summaryText' => false, // 1st way
            'id'=>'reportCaptcha-grid',
            'dataProvider'=>$model->search(),
					//'filter'=>$model,
            'selectableRows' => 2,
            'htmlOptions' => array(
            	'style'=> "margin-top: -1px;",
            	),
            'summaryText' => false, // 1st way
            'columns'=>array(
            	array(
            		'header'=>'No.',
            		'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            		),
            	array(
                        'header' => 'ประเภท',
                        'type' => 'html',
                        'value' => function($val) {
                              return  $val->reset_type == '0' ? 'การเรียน' : 'การสอบวัดผล';
                        },
                        ),
            	array(
            		'header' => 'ชื่อหลักสูตร',
            		'type' => 'html',
            		'value' => function($val) {
            			return $val->course->course_title;
            		},
                        'htmlOptions' => array(
                        'style'=> "font-size: 12px;",
                        ),
            		),
            	array(
            		'header' => 'บทเรียน',
            		'type' => 'html',
            		'value' => function($val) {
            			return isset($val->lesson->title) ? $val->lesson->title : '-';
            		},
                        'htmlOptions' => array(
                        'style'=> "font-size: 12px;",
                        ),
            		),
                  array(
                        'header' => 'รายละเอียด',
                        'type' => 'html',
                        'value' => function($val) {
                              return $val->reset_description;
                        },
                        ),
            	array(
            		'header' => 'วันที่',
            		'value' => function($val) {
            			return Helpers::lib()->changeFormatDate($val->reset_date,'datetime');
            		},
            		),
            	array(
            		'header' => 'โดย',
            		'value' => function($val) {
            			return $val->reset->getFullName();
            		},
            		),
            	),
            )); 

            ?>