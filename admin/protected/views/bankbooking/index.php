
<?php
$titleName = 'จัดการธนาคารสำหรับการจองหลักสูตร';
$formNameModel = 'BankBooking';

$this->breadcrumbs=array($titleName);
	Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
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
	$.appendFilter("BankBooking[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'bank_name','type'=>'text'),
		array('name'=>'account_name','type'=>'text'),
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
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("BankBooking[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("BankBooking.*", "BankBooking.Delete", "BankBooking.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndexLinux("bank",$data->id,$data->bank_images)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=>'bank_name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"bank_name")'
						),

						array(
							'name'=>'account_name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"account_name")'
						),

						array(
							'name'=>'account_number',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"account_number")'
						),

						array(
							'header'=>'เลือกหลักสูตร',
							'type'=>'raw',
							'value'=>function($data){
								return CHtml::link( '<i class="fa fa-folder-open-o"></i> เลือกหลักสูตร', 'javascript:void(0)', array( 'class' => 'btn btn-primary btn-icon', 'onclick' => 'selectCourse(' . $data->id . ')'));
							},
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'headerHtmlOptions'=>array('style'=>'text-align: center'),
						),

						array(
							'header'=>'เลือกห้องเรียนออนไลน์',
							'type'=>'raw',
							'value'=>function($data){
								return CHtml::link( '<i class="fa fa-folder-open-o"></i> เลือกห้องเรียนออนไลน์', 'javascript:void(0)', array( 'class' => 'btn btn-primary btn-icon', 'onclick' => 'selectMsteams(' . $data->id . ')'));
							},
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'headerHtmlOptions'=>array('style'=>'text-align: center'),
						),

						


					    array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
					        foreach ($lang as $key => $value) {
					    		$menu = BankBooking::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/BankBooking/create","lang_id"=>$value->id,"parent_id"=>$val->id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->id : $val->id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			// $link = array("/BankBooking/update","id"=>$id);
					    			$link = array("/BankBooking/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->id);
					    		} 
					            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
					        }
					        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
                    	},
		                    'type'=>'raw',
		                    'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
		                ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("BankBooking.*", "BankBooking.View", "BankBooking.Update", "BankBooking.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("BankBooking.*", "BankBooking.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("BankBooking.*", "BankBooking.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("BankBooking.*", "BankBooking.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>



	<?php if( Controller::DeleteAll(array("BankBooking.*", "BankBooking.Delete", "BankBooking.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteBankBooking('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>

<div class="modal fade" id="selectApplyCourseToCertificate" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">เลือกหลักสูตร</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				<button type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="selectApplyMsTeams" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">เลือกห้องเรียนออนไลน์</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				<button type="submit" class="btn btn-primary" onclick="saveMsModal()">บันทึก</button>
			</div>
		</div>
	</div>
</div>


                <script>
function selectCourse(bank_id=null) {
      if(bank_id != undefined && bank_id!=null) {
      	$.post("<?= $this->createUrl('bankbooking/coursemodal') ?>", { bank_id: bank_id }, function(respon) {
      		if(respon) {
      			$('#selectApplyCourseToCertificate .modal-body').html(respon);
      			setTimeout(function() {
      				$('#selectApplyCourseToCertificate').modal({
      					keyboard: false
      				});
      			}, 1000);
      		}
      	});
      }
  }

  function selectMsteams(bank_id=null) {
      if(bank_id != undefined && bank_id!=null) {
      	$.post("<?= $this->createUrl('bankbooking/msteamsmodal') ?>", { bank_id: bank_id }, function(respon) {
      		if(respon) {
      			$('#selectApplyMsTeams .modal-body').html(respon);
      			setTimeout(function() {
      				$('#selectApplyMsTeams').modal({
      					keyboard: false
      				});
      			}, 1000);
      		}
      	});
      }
  }


  function saveModal() {
              var bankId = $('input[name="id"]').val();
              var courseCheckList = $('.courseCheckList');
              var checkedList = [];

              if(courseCheckList != undefined) {
               $.each(courseCheckList, function(i, checkbox) {
                if(checkbox.value != null && checkbox.checked == true) {
                 checkedList.push(checkbox.value);
                  // checkedList[i] = checkbox.value;
                }
                console.log(checkedList);
              });
               if(checkedList!=null) {
                 $.post("<?= $this->createUrl('bankbooking/savecoursemodal') ?>", { checkedList: JSON.stringify(checkedList), bankId: bankId }, function(respon) {
                  if(respon) {
                    $('#selectApplyCourseToCertificate').modal('hide');
                                  // $('#MtCourseType-grid').load(document.URL + ' #MtCourseType-grid');
                                  $.fn.yiiGridView.update('BankBooking-grid');
                               } else {
                                 alert('error');
                               }
                             });
               }
             }
           }

           function saveMsModal() {
              var bankId = $('input[name="msid"]').val();
              var msCheckList = $('.msCheckList');
              var checkedListms = [];

              if(msCheckList != undefined) {
               $.each(msCheckList, function(i, checkbox) {
                if(checkbox.value != null && checkbox.checked == true) {
                 checkedListms.push(checkbox.value);
                }
              });
               if(checkedListms!=null) {
                 $.post("<?= $this->createUrl('bankbooking/savemsmodal') ?>", { checkedListms: JSON.stringify(checkedListms), bankId: bankId }, function(respon) {
                  if(respon) {
                    $('#selectApplyMsTeams').modal('hide');
                                  // $('#MtCourseType-grid').load(document.URL + ' #MtCourseType-grid');
                                  $.fn.yiiGridView.update('BankBooking-grid');
                               } else {
                                 alert('error');
                               }
                             });
               }
             }
           }

</script>