
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />
<?php
$titleName = 'ระบบ Chat';
$formNameModel = 'Chat';
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
	$.appendFilter("Chat[news_per_page]", "news_per_page");
	    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');
    $('#Report_dateRang').daterangepicker();

    $('.type').change(function(){
        var type = $(this).val();
        if(type == ''){
            $('.university').hide();
            $('.company').hide();
        }else if(type == 'university'){
            $('.university').show();
            $('.company').hide();
        }else{
            $('.university').hide();
            $('.company').show();
        }
    });
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> 
				<?php echo $titleName;?>
			</h4>
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
			 <!-- Advanced Search -->
     
 
            <div class="search-form">
                <div class="wide form">
                    <?php
                    $form=$this->beginWidget('CActiveForm', array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'id'=>'SearchFormAjax',
                    ));
                    if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
                    {

                      
                    }else{
                        $user = Yii::app()->getModule('user')->user();
                        $model->typeOfUser = $user->authitem_name;
                        $owner_id = $user->id;
                    }
                    echo '<div class="row">';
                    echo '<label>'.$model->getAttributeLabel('time').'</label>';
                    $this->widget('zii.widgets.jui.CJuiDatepicker', array(
                        'model'=>$model,
                        'attribute'=>'time',
                        'htmlOptions' => array(
                            'class' => 'span6',
                        ),
                        'options' => array(
                            'mode'=>'focus',
                            'dateFormat'=>'yy-mm-dd',
                            'showAnim' => 'slideDown',
                            'showOn' => 'focus',
                            'showOtherMonths' => true,
                            'selectOtherMonths' => true,
                            'yearRange' => '-5:+2',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
                            'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
                                'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
                        )
                    ));
                    echo '</div>';

                    echo '<div class="row">';
                        echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons search'),'<i></i> ค้นหา');
                        echo '</div><br>';
                    $this->endWidget();
			
                    ?>
		</div>
		</div>	
			<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					// 'dataProvider'=>$model->courseonlinecheck()->search(),
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Chat[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Chat.*", "Chat.Delete", "Chat.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'chatcode',
							'header'=>'ผู้ส่ง',
							'type'=>'html',
							'value'=>'$data->user->username',
							// 'value'=>'UHtml::markSearch($data,"chatcode")'
						),
						array(
							'name'=>'message',
							'header'=>'ข้อความล่าสุด',
							'value'=>'$data->message',
							// 'filter'=>CHtml::activeTextField($model,'cates_search'),
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
						),
						array(
							'name'=>'time',
							'header'=>'วันที่ส่ง',
							'type'=>'html',
							'value'=>'date("Y-m-d H:i:s",$data->time)',
						),
						array(            
							'class'=>'AButtonColumn',
							'template'=>'{view} {delete}',
							'visible'=>Controller::PButton( 
								array("Chat.*", "Chat.View", "Chat.Update", "Chat.Delete") 
							),
							'buttons' => array(

								'view'=> array( 
									'visible'=>'Controller::PButton( array("Chat.*", "Chat.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Chat.*", "Chat.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Chat.*", "Chat.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

</div>
	<div class="innerLR">
		<?php if( Controller::DeleteAll(array("Chat.*", "Chat.Delete", "Chat.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small ">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
		<?php endif; ?>
	</div>
</div>
	<!-- With selected actions -->
