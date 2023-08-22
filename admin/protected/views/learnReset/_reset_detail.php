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
            'enablePagination'  => false,
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
            			return $val->lesson->title;
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