<?php
$titleName = 'จัดการปัญหาการใช้งาน';
$formNameModel = 'ReportProblem';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
	$('#export').click(function(){
	   	window.location = '". $this->createUrl('//reportProblem/report')  . "?' + '&export=true';
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("ReportProblem[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'contac_by_name','type'=>'text'),
	),
	));?>

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
				<span class="pull-left">
					<?php echo CHtml::tag('button',array(
						'class' => 'btn btn-primary btn-icon glyphicons print',
						'id'=> 'export',
					),'<i></i>ออกรายงาน'); ?>
				</span>
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
			<?php $this->widget('AGridView', array(
				'id'=>$formNameModel.'-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns'=>array(	
					array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),		
                    array(
						'name'=>'create_date',
						'type'=>'html',
						// 'value'=>'UHtml::markSearch($data,"report_date")'
						'value'=>function($data){
			                return Helpers::changeFormatDate($data->create_date,'datetime');
			            },
					),		
					array(
						'header'=>'ชื่อ - สกุล',
                        'value'=>function($data){
							return $data->contac_by_name.' '.$data->contac_by_surname;
						}
				    ),
					
					array(
                        'header'=>'อีเมล์',
                        'value'=>function($data){
							$user = User::model()->findByAttributes(array(
								'email' => $data->contac_by_email,
							));
							// var_dump($user);
							if($user){
								if($user->bookkeeper_id){
									return $user->bookkeeper_id;
								} else {
									return $user->username;
								}
							} else {
								$user = Profile::model()->findByAttributes(array(
									'firstname' => $data->contac_by_name,
								));
								if($user){
									if($user->user->bookkeeper_id){
										return $user->user->bookkeeper_id;
									} else {
										return $user->user->username;
									}
								} else {
									return 'ไม่มีในระบบ';
								}
							}
		                	
				        },
                    ),
                    array(
						'name'=>'contac_by_tel',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"contac_by_tel")'
					),
					
					array(
						'name'=>'contac_type',
						'type'=>'html',
						'value'=>'UHtml::markSearch($data,"contac_type")'
					),
					
					array(
						'name'=>'contac_detail',
						'type'=>'html',
						// 'value'=>'UHtml::markSearch($data,"accept_report_date")'
						'value'=>function($data){
			                $output = UHtml::markSearch($data,"contac_detail");
			                	return $output;
			            },
					),
					array(
						'name'=>'contac_answer',
						'type'=>'html',
						'value'=>function($data){
							if($data->contac_answer == 'y'){
								$output = 'ตอบกลับแล้ว';
								$color = 'green';
				            } else {
				            	$color = 'red';
				            	$output = 'ยังไม่ได้ตอบ';
				            }
			                return '<span style="color: '.$color.'">'.$output.'</span>';
			            },
					),
					array(
                'header'=>'ส่งข้อความ',
                'type' => 'raw',
                'visible' => Controller::PButton( array("ReportProblem.*", "ReportProblem.sendMailMessage") ),
                'htmlOptions'=>array('style'=>'text-align: center; width:10%'),
                'value' => function($data) {
                    return  CHtml::button("ส่งข้อความ",array('onclick'=>'sendMsg('.$data->contac_id.')','class' => 'btn btn-danger','style'=>'font-size: 8px;'));
              },  
              ),
				),
			)); ?>
			</div>
		</div>
	</div>
</div>

<script>
	function sendMsg(contac_id){
      swal({
        title: "ส่งข้อความ",
        //text: "ระบุข้อความ",
        type: "input",
        confirmButtonColor: "#DD6B55",
        showCancelButton: true,
                //allowEnterKey: true,
                closeOnConfirm: false,
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก",
                animation: "slide-from-top",
                inputPlaceholder: "ข้อความ"
              },
              function(inputValue){
                if (inputValue === false) 
                  {return false;
                  } else {
                   swal({
                    title: "โปรดรอสักครู่",
                    text: "ระบบกำลังตรวจสอบ",
                    type: "info",
                    //confirmButtonText: "ตกลง",
                    showConfirmButton: false
                  });
                   $.ajax({
                    type: "POST",
                    url: '<?php echo $this->createUrl('reportProblem/sendMailMessage'); ?>',
                    data: {inputValue: inputValue,'contac_id': contac_id},
                    success: function (data) {
                      swal({
                        type: "success",
                        title: "ระบบ",
				      text: "ทำรายการสำเร็จ",
				      timer: 500,
				    },
				    function() {
				      setTimeout(function(){
				        location.reload();
				      },500);
				    });

                    },
                  });
                 }
               });
    }
</script>

<?php
$columns=array(
    // array(
    //     'name'=>'report_date',
    //     'filter'=>CHtml::activeTextField($model,'report_date'),
    //     'type' => 'raw',
    //     'value'=>'$data->report_date',
    //     'htmlOptions' => array(
    //         'width'=>'120',
    //     ),
    // ),
    // array(
    //     'header'=>'ชื่อ - สกุล',
    //     'value'=>function($data){
    //         return $data->firstname.' '.$data->lastname;
    //     }
    // ),
    // array(
    //     'header'=>'บัตรประชาชน',
    //     'value'=>function($data){
    //         $user = User::model()->findByAttributes(array(
    //             'email' => $data->email,
    //         ));
    //         // var_dump($user);
    //         if($user){
    //             if($user->bookkeeper_id){
    //                 $name = $user->bookkeeper_id;
    //                 return $name.' ';
    //             } else {
    //                 $name = $user->username;
    //                 return $name.' ';
    //             }
    //         } else {
    //             $user = Profile::model()->findByAttributes(array(
    //                 'firstname' => $data->firstname,
    //             ));
    //             if($user){
    //                 if($user->user->bookkeeper_id){
    //                     $name = $user->user->bookkeeper_id;
    //                     return $name.' ';
    //                 } else {
    //                     $name = $user->user->username;
    //                     return $name.' ';
    //                 }
    //             } else {
    //                 return 'ไม่มีในระบบ';
    //             }
    //         }
            
    //     },
    // ),
    // array(
    //     'name'=>'report_title',
    //     'type'=>'html',
    //     'value'=>'UHtml::markSearch($data,"report_title")'
    // ),
    // array(
    //     'name'=>'accept_report_date',
    //     'type'=>'html',
    //     // 'value'=>'UHtml::markSearch($data,"accept_report_date")'
    //     'value'=>function($data){
    //         return Helpers::changeFormatDate($data->accept_report_date,'datetime');
    //     },
    // ),
    // array(
    //     'name'=>'status',
    //     'value'=>'ReportProblem::itemAlias("UserStatus",$data->status)',
    //     'filter' => ReportProblem::itemAlias("UserStatus"),
    // ),
    // array(
    //     'name'=>'answer',
    //     'type'=>'html',
    //     'value'=>function($data){
    //         if($data->answer != ''){
    //             return $data->answer;
    //         } else {
    //             return 'ยังไม่ตอบกลับ';
    //         }
    //     },
    //     'htmlOptions' => array(
    //         'width'=>'220',
    //     ),
    // ),
        array(
                        'name'=>'create_date',
                        'type'=>'html',
                        // 'value'=>'UHtml::markSearch($data,"report_date")'
                        'value'=>function($data){
                            return Helpers::changeFormatDate($data->create_date,'datetime');
                        },
                    ),      
                    array(
                        'header'=>'ชื่อ - สกุล',
                        'value'=>function($data){
                            return $data->contac_by_name.' '.$data->contac_by_surname;
                        }
                    ),
                    
                    array(
                        'header'=>'อีเมล์',
                        'value'=>function($data){
                            $user = User::model()->findByAttributes(array(
                                'email' => $data->contac_by_email,
                            ));
                            // var_dump($user);
                            if($user){
                                if($user->bookkeeper_id){
                                    return $user->bookkeeper_id;
                                } else {
                                    return $user->username;
                                }
                            } else {
                                $user = Profile::model()->findByAttributes(array(
                                    'firstname' => $data->contac_by_name,
                                ));
                                if($user){
                                    if($user->user->bookkeeper_id){
                                        return $user->user->bookkeeper_id;
                                    } else {
                                        return $user->user->username;
                                    }
                                } else {
                                    return 'ไม่มีในระบบ';
                                }
                            }
                            
                        },
                    ),
                    array(
                        'name'=>'contac_by_tel',
                        'type'=>'html',
                        'value'=>'UHtml::markSearch($data,"contac_by_tel")'
                    ),
                    
                    array(
                        'name'=>'contac_type',
                        'type'=>'html',
                        'value'=>'UHtml::markSearch($data,"contac_type")'
                    ),
                    
                    array(
                        'name'=>'contac_detail',
                        'type'=>'html',
                        // 'value'=>'UHtml::markSearch($data,"accept_report_date")'
                        'value'=>function($data){
                            $output = UHtml::markSearch($data,"contac_detail");
                                return $output;
                        },
                    ),
                    array(
                        'name'=>'contac_answer',
                        'type'=>'html',
                        'value'=>function($data){
                            if($data->contac_answer == 'y'){
                                $output = 'ตอบแกลับล้ว';
                                $color = 'green';
                            } else {
                                $color = 'red';
                                $output = 'ยังไม่ได้ตอบ';
                            }
                            return '<span style="color: '.$color.'">'.$output.'</span>';
                        },
                    ),
    // array(
    //     'name'=>'passcours_cours',
    //     'filter'=>CHtml::activeTextField($model,'cours_name'),
    //     'type' => 'raw',
    //     'value'=>'$data->CourseOnlines->course_title',
    // ),
    // array(
    //     'name'=>'passcours_date',
    //     'value'=>'ClassFunction::datethai($data->passcours_date)',
    //     'htmlOptions' => array(
    //         'width'=>'110',
    //         'style' => 'text-align:center;',
    //     ),
    //     'filter'=>$this->widget('zii.widgets.jui.CJuiDatepicker', array(
    //         'model'=>$model,
    //         'attribute'=>'passcours_date',
    //         'htmlOptions' => array(
    //             'id' => 'passcours_date',
    //         ),  
    //         'options' => array(
    //             'mode'=>'focus',
    //             'dateFormat'=>'dd/mm/yy',
    //             'showOn' => 'focus', 
    //             'showOtherMonths' => true,
    //             'selectOtherMonths' => true,
    //             'yearRange' => '-5+10', 
    //             'changeMonth' => true,
    //             'changeYear' => true,
    //             'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
    //             'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
    //                 'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
    // )), true)),
);
?>
<!-- <?php $this->widget('application.components.widgets.tlbExcelView', array(
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
)); ?> -->