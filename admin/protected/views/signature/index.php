
<?php
$titleName = 'จัดการลายเซ็นต์';
$formNameModel = 'Signature';

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
  $.appendFilter("Signature[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
  <?php $this->widget('AdvanceSearchForm', array(
    'data'=>$model,
    'route' => $this->route,
    'attributes'=>array(
      array('name'=>'sign_title','type'=>'text'),
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
      <div class="separator bottom form-inline small">
         <div class="buttons pull-left">
        <?php 
        echo CHtml::link("<i></i> เพิ่มลายเซนต์",
          $this->createUrl('//'.$formNameModel.'/create'),
          array("class"=>"btn btn-primary btn-icon glyphicons circle_plus")); 
        ?>
      </div>
      </div>
      <div class="clear-div"></div>
      <div class="overflow-table">
        <?php $this->widget('AGridView', array(
          'id'=>$formNameModel.'-grid',
          'dataProvider'=>$model->signaturecheck()->search(),
          'filter'=>$model,
          'selectableRows' => 2,  
          'htmlOptions' => array(
            'style'=> "margin-top: -1px;",
          ),
          'afterAjaxUpdate'=>'function(id, data){
            $.appendFilter("Signature[news_per_page]");
            InitialSortTable(); 
          }',
          'columns'=>array(
            array(
              'visible'=>Controller::DeleteAll(
                // array("Signature.*", "Signature.Delete", "Signature.MultiDelete")
              ),
              'class'=>'CCheckBoxColumn',
              'id'=>'chk',
            ),
            array(
              'name'=>'sign_title',
              'type'=>'html',
              'value'=>'UHtml::markSearch($data,"sign_title")',
              'htmlOptions'=>array('style'=>'width: 250px;'),
            ),
            
             array(
              'name'=>'create_date',
              'type'=>'raw',
              'value'=> function($data){
                return ClassFunction::datethaiTime($data->create_date);
              },
              'htmlOptions'=>array('style'=>'width: 250px;'),
            ),
        
              array(
              'type'=>'raw',
              'value'=>function($data){
                if($data->sign_hide == 1){
                  // return CHtml::link("ปิด",array("/Signature/active","id"=>$data->sign_id), array("class"=>"btn btn-danger"));
                  return '<input  id="toggle-event" type="checkbox" checked data-toggle="toggle" data-onstyle="success" value="'.$data->sign_id.'">';
                } else {
                  return '<input  id="toggle-event" type="checkbox" data-toggle="toggle" data-onstyle="success" value="'.$data->sign_id.'">';
                  // return CHtml::link("เปิด",array("/Signature/active","id"=>$data->sign_id), array("class"=>"btn btn-success"));
                }
              },
              'header' => 'เปิด/ปิด การแสดงผล',
              'htmlOptions'=>array('style'=>'text-align: center;'),
              'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
            ),
            array(            
              'class'=>'AButtonColumn',
              'visible'=>Controller::PButton( 
                array("Signature.*", "Signature.View", "Signature.Update", "Signature.Delete") 
              ),
              'buttons' => array(
                'view'=> array( 
                  'visible'=>'Controller::PButton( array("Signature.*", "Signature.View") )' 
                ),
                'update'=> array( 
                  'visible'=>'Controller::PButton( array("Signature.*", "Signature.Update") )' 
                ),
                'delete'=> array( 
                  'visible'=>'Controller::PButton( array("Signature.*", "Signature.Delete") )' 
                ),
              ),
            ),
          ),
        )); ?>
      </div>
    </div>
  </div>

  <?php if( Controller::DeleteAll(array("Signature.*", "Signature.Delete", "Signature.MultiDelete")) ) : ?>
    <!-- Options -->
    <div class="separator top form-inline small">
      <!-- With selected actions -->
      <div class="buttons pull-left">
        <?php 
        echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด",
          "#",
          array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
            "onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');")); 
        ?>
      </div>
      <!-- // With selected actions END -->
      <div class="clearfix"></div>
    </div>
    <!-- // Options END -->
  <?php endif; ?>

</div>


<script>
	$('[id^="toggle-event"]').change(function() {
		var id = this.value;
		$.ajax({
			url: "<?= $this->createUrl('Signature/active'); ?>", 
			type: "POST",
			data:  {id:id},
			success: function(data){
					swal("สำเร็จ", "", "success");
					$("#SearchFormAjax").yiiActiveForm('resetForm');
				}
			});
	});
</script>