<?php 
$this->widget('booster.widgets.TbGridView',array(
            'summaryText' => false, // 1st way
            'id'=>'reportCaptcha-grid',
            'dataProvider'=>$model->searchAnsDetail(),
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
            	/*array(
            		'header' => 'รหัสพาสปอร์ต',
            		'value' => function($val) {
            			return $val->user->username;
            		},
            		),
            	array(
            		'header' => 'ชือ-นามสกุล',
            		'value' => function($val) {
            			return $val->member->title_name->prof_title.' '.$val->member->m_firstname_th.'   '.$val->member->m_lastname_th;
            		},
            		),*/
            	array(
            		'header' => 'ชื่อหลักสูตร',
            		'type' => 'html',
            		'value' => function($val) {
            			return $val->course->course_name;
            		},
            		),
            	array(
            		'header' => 'บทเรียน',
            		'type' => 'html',
            		'value' => function($val) {
            			return $val->lesson->lesson_name;
            		},
            		),
            	array(
            		'header' => 'เวลาที่ตอบ/วินาที',
            		'value' => function($val) {
            			return $val->time;
            		},
            		),
            	array(
            		'header' => 'วันที่',
            		'value' => function($val) {
            			return Helpers::lib()->changeFormatDate($val->created_date,'datetime');
            		},
            		),
            	),
            )); 

            ?>