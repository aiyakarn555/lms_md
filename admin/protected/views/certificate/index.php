<?php
$titleName = 'จัดการใบประกาศนียบัตร';
$formNameModel = 'Certificate';

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
  $.appendFilter("Certificate[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
  <?php /*$this->widget('AdvanceSearchForm', array(
    'data'=>$model,
    'route' => $this->route,
    'attributes'=>array(
      array('name'=>'sign_title','type'=>'text'),
    ),
  ));*/?>

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
        echo CHtml::link("<i></i> เพิ่มใบประกาศนียบัตร",
          $this->createUrl('//'.$formNameModel.'/create'),
          array("class"=>"btn btn-primary btn-icon glyphicons circle_plus")); 
        ?>
      </div>
      </div>
      <div class="clear-div"></div>
      <div class="overflow-table">
        <?php $this->widget('AGridView', array(
          'id'=>$formNameModel.'-grid',
          'dataProvider'=>$model->certificatecheck()->search(),
          'filter'=>$model,
          'selectableRows' => 2,  
          'htmlOptions' => array(
            'style'=> "margin-top: -1px;",
          ),
          'afterAjaxUpdate'=>'function(id, data){
            $.appendFilter("Certificate[news_per_page]");
            InitialSortTable(); 
          }',
          'columns'=>array(
            array(
              'visible'=>Controller::DeleteAll(
                array("Certificate.*", "Certificate.Delete", "Certificate.MultiDelete")
              ),
              'class'=>'CCheckBoxColumn',
              'id'=>'chk',
            ),
            array(
              'name'=>'cert_name',
              'type'=>'html',
              'value'=>'UHtml::markSearch($data,"cert_name")',
              'htmlOptions'=>array('style'=>'width: 250px;'),
            ),
           array(
              'header'=>'ชื่อหลักสูตร',
              'type'=>'html',
              'value'=>function($data){
                $model = CertificateNameRelations::model()->findAll(array('condition' => 'cert_id='.$data->cert_id));
                $arrayKeys = array_keys($model);
                $lastArrayKey = array_pop($arrayKeys);
                $coursename = empty($model) ? 'ไม่ได้เลือกหลักสูตร' : '';
                foreach ($model as $key => $value) {
                  $coursename .= ($key+1).'. '.$value->courseOnline->course_title;
                  if($key != $lastArrayKey) {
                    $coursename .= '<br>';
                  }
                }
                return $coursename;
              },
            ),
          array(
              'header'=>'เลือกหลักสูตร',
              'type'=>'raw',
              'value'=>function($data){
                return CHtml::link( '<i class="fa fa-folder-open-o"></i> เลือกหลักสูตร', 'javascript:void(0)', array( 'class' => 'btn btn-primary btn-icon', 'onclick' => 'selectCourse(' . $data->cert_id . ')'));
              },
              'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
              'headerHtmlOptions'=>array('style'=>'text-align: center'),
              ),
             array(
              'name'=>'create_date',
              'type'=>'html',
              'value'=>function($data){
                return ClassFunction::datethaiTime($data->create_date);
              }
            ),
        
            //   array(
            //   'type'=>'raw',
            //   'value'=>function($data){
            //     if($data->cert_hide == 1){
            //       return CHtml::link("ปิด",array("/Certificate/active","id"=>$data->cert_id), array("class"=>"btn btn-danger"));
            //     } else {
            //       return CHtml::link("เปิด",array("/Certificate/active","id"=>$data->cert_id), array("class"=>"btn btn-danger"));
            //     }
            //   },
            //   'header' => 'เปิด/ปิด การแสดงผล',
            //   'htmlOptions'=>array('style'=>'text-align: center;'),
            //   'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
            // ),

            array(
              'header'=>'ตัวอย่าง',
                  'value'=>'CHtml::link("<i class=\'fa fa-search\'></i> ดูตัวอย่าง", array(
                    "Certificate/CertificateDisplay",
                    "id"=>$data->cert_id,
                    "sid"=>$data->sign_id,
                    "sid2"=>$data->sign_id2,
                    ), array(
                "class"=>"btn btn-primary btn-icon",
                "target" => "_blank"
                ));',

              'type'=>'raw',
              'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
              'headerHtmlOptions'=>array('style'=>'text-align: center'),
            ),
            array(            
              'class'=>'AButtonColumn',
              'visible'=>Controller::PButton( 
                array("Certificate.*", "Certificate.View", "Certificate.Update", "Certificate.Delete") 
              ),
              'buttons' => array(
                'view'=> array( 
                  'visible'=>'Controller::PButton( array("Certificate.*", "Certificate.View") )' 
                ),
                'update'=> array( 
                  'visible'=>'Controller::PButton( array("Certificate.*", "Certificate.Update") )' 
                ),
                'delete'=> array( 
                  'visible'=>'Controller::PButton( array("Certificate.*", "Certificate.Delete") )' 
                ),
              ),
              'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
            ),
          ),
        )); ?>
      </div>
    </div>
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
  <?php if( Controller::DeleteAll(array("Certificate.*", "Certificate.Delete", "Certificate.MultiDelete")) ) : ?>
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
  function selectCourse(certificateId=null) {
      // console.log(certificateId);
          if(certificateId != undefined && certificateId!=null) {
           $.post("<?= $this->createUrl('certificate/coursemodal') ?>", { certificateId: certificateId }, function(respon) {
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

       function saveModal() {
              var certificateId = $('input[name="cert_id"]').val();
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
                 $.post("<?= $this->createUrl('certificate/savecoursemodal') ?>", { checkedList: JSON.stringify(checkedList), certificateId: certificateId }, function(respon) {
                  if(respon) {
                    $('#selectApplyCourseToCertificate').modal('hide');
                                  // $('#MtCourseType-grid').load(document.URL + ' #MtCourseType-grid');
                                  $.fn.yiiGridView.update('Certificate-grid');
                               } else {
                                 alert('error');
                               }
                             });
               }
             }
           }
</script>
