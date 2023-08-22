	<?php
	$FormText = 'รายงานการตอบแคปช่า';
	$this->headerText = $FormText;
	$this->breadcrumbs=array(
		UserModule::t('Manage'),
		);
		?>

		<?php  $form = $this->beginWidget(
			'booster.widgets.TbActiveForm',
			array(
				'id' => 'reportCaptcha-form',
				'method' => 'get',
				'action' => $this->createUrl('configCaptcha/reportanscaptcha'),
                        'htmlOptions' => array('class' => 'well'), // for inset effect
                        )

                        ); ?>
                        <button type="button" name="btn" id="btn" value="Show" onclick='toggle()' class="btn btn-info">ค้นหาขั้นสูง</button>
                        <div class="panel panel-default" id='display' style='display:none;'>
                        	<div class="panel-body">
                        		<div class="form-group ">
                        			<div class="col-md-12">
                        				<div class="col-md-12">
                        					<label></label>
                        					<?php echo $form->textFieldGroup(
                        						$model,
                        						'searchvalue'
                        						); ?>
                        					</div>
                        					
                               </div>
                               <div class="col-md-12">
                                <div class="col-md-12">
                                 <?php
                                 $list = array();
                                 $list = MtCourseName::getCourseNameList();

                                 echo $form->dropDownListGroup(
                                  $model, 'search_course',
                                  array(
                                    'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-5',
                                      ),
                                    'widgetOptions' => array(
                                      'data' =>  $list,
                                      'htmlOptions' => array(
                                        'empty' => '---กำหนดหลักสูตร---',
                                        'onchange' => 'js:$.ajax({
                                          url: "'.Yii::app()->createUrl("ConfigCaptcha/LessonChange").'",
                                          type: "POST",
                                          data: {id:$(this).val()},
                                          success:function(data){
                                            /*console.log(data);*/
                                            $("#ValidateCaptcha_search_lesson").html(data);
                                          }
                                        });'
                                        ),
                                      )
                                    )
                                  );
                                  ?>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="col-md-12">
                                 <?php 
                                 $list2 = array();
                                 echo $form->dropDownListGroup(
                                  $model, 'search_lesson',
                                  array(
                                    'wrapperHtmlOptions' => array(
                                      'class' => 'col-sm-5',
                                      ),
                                    'widgetOptions' => array(
                                      'data' =>  $list2,
                                      'htmlOptions' => array(
                                        'empty' => '---กำหนดหลักสูตร---',
                                        ),
                                      )
                                    )
                                  );
                                  ?>
                                </div>
                              </div>

                              <div class="col-sm-12">
                                <div class="col-md-6">
                                  <label></label>
                                  <?php echo $form->datePickerGroup($model, 'startdate_start',
                                    array(
                                     'widgetOptions' => array(
                                      'htmlOptions' => array('placeholder' => "YYYY-MM-DD", 'class' => 'form-control'),
                                      )
                                     )
                                     ); ?>
                                   </div>
                                   <div class="col-md-6">
                                    <label></label>
                                    <?php echo $form->datePickerGroup($model, 'enddate_end',
                                      array(
                                       'widgetOptions' => array(
                                        'htmlOptions' => array('placeholder' => "YYYY-MM-DD", 'class' => 'form-control'),
                                        )
                                       )
                                       ); ?>
                                     </div>
                                   </div>
                                   <div class="col-md-12">
                                    <div class="col-md-12" style="margin-top:10px;">
                                     <button  type="submit" class="btn btn-info" ><i class="fa fa-search"  style="margin: 4px;" aria-hidden="true"></i>ค้นหา</button>
                                     <a href="<?php echo $this->createUrl('configCaptcha/ReportAnsCaptcha') ?>" type="submit" class="btn btn-danger"><i class="fa fa-close"></i><span  style="margin: 4px;" class="" aria-hidden="true"></span>ยกเลิก</a>  
                                   </div> 
                                 </div>
                               </div>
                             </div>
                           </div>
                           <?php $this->endWidget();
                           unset($form);?>
                           <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i class="fa fa-file-excel-o"></i> Export</button>
                           <?php $this->widget('booster.widgets.TbGridView',array(
            'summaryText' => false, // 1st way
            'id'=>'authCourse-grid',
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
            		'header' => 'รหัสพาสปอร์ต',
            		'value' => function($val) {
            			return $val->user->username."";
            		},
            		),
            	array(
            		'header' => 'ชือ-นามสกุล',
                'type' => 'html',
                'value' => function($val) {
                 $strName = $val->member->title_name->prof_title.' '.$val->member->m_firstname_th.'   '.$val->member->m_lastname_th."<br>";
                 $strName .= $val->member->title_name_en->prof_title.' '.$val->member->m_firstname_en.'   '.$val->member->m_lastname_en."";
                 return $strName;
               },
               ),
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
            			$lesson = ValidateCaptcha::model()->findAll(array(
            				'condition' => 'cnid=:cnid AND user_id=:user_id GROUP BY lid',
            				'params' => array(':cnid'=>$val->cnid, ':user_id' => $val->user_id),
            				));
            			$respon = '';
            			foreach ($lesson as $key => $value) {
            				$respon .= $value->lid.' : '.$value->lesson->lesson_name.'<br>';
            			}
            			return $respon;
            		},
            		),
            	array(
            		'header' => 'จำนวนที่ผิดผลาด',
            		'type' => 'html',
            		'value' => function($val) {
            			$count_false = ValidateCaptcha::model()->count(array(
            				'condition' => 'cnid=:cnid AND user_id=:user_id AND `check`=:check ',
            				'params' => array(':cnid'=>$val->cnid, ':user_id' => $val->user_id,':check'=>'false'),
            				));
            			return $count_false;
            		},
            		),
            	array(
            		'header' => 'จำนวนที่ไม่กรอก',
            		'type' => 'html',
            		'value' => function($val) {
            			$count_timeout = ValidateCaptcha::model()->count(array(
            				'condition' => 'cnid=:cnid AND user_id=:user_id AND `check`=:check ',
            				'params' => array(':cnid'=>$val->cnid, ':user_id' => $val->user_id,':check'=>'timeout'),
            				));
            			return $count_timeout;
            		},
            		),
            	array(
            		'header'=>'รายละเอียด',
            		'value'=> function($val){

                  return	CHtml::link("รายละเอียด",'javascript:void(0)',array( 'onclick' => 'modalMessage('.$val->user_id.','.$val->cnid.') ',"class" => "btn btn-info","style" => "min-width:155px;"));
                },
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align: center'),
                ),

              ),
            )); 

            ?>
            <div class="div-table" style="display: none;">
             <?php $this->widget('booster.widgets.TbGridView',array(
            'summaryText' => false, // 1st way
            'id'=>'authCourse-grid',
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
                'header' => 'รหัสพาสปอร์ต',
                'value' => function($val) {
                  return $val->user->username."";
                },
                ),
              array(
                'header' => 'ชือ-นามสกุล',
                'type' => 'html',
                'value' => function($val) {
                 $strName = $val->member->title_name->prof_title.' '.$val->member->m_firstname_th.'   '.$val->member->m_lastname_th."<br>";
                 $strName .= $val->member->title_name_en->prof_title.' '.$val->member->m_firstname_en.'   '.$val->member->m_lastname_en."";
                 return $strName;
               },
               ),
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
                  $lesson = ValidateCaptcha::model()->findAll(array(
                    'condition' => 'cnid=:cnid AND user_id=:user_id GROUP BY lid',
                    'params' => array(':cnid'=>$val->cnid, ':user_id' => $val->user_id),
                    ));
                  $respon = '';
                  foreach ($lesson as $key => $value) {
                    $respon .= $value->lid.' : '.$value->lesson->lesson_name.'<br>';
                  }
                  return $respon;
                },
                ),
              array(
                'header' => 'จำนวนที่ผิดผลาด',
                'type' => 'html',
                'value' => function($val) {
                  $count_false = ValidateCaptcha::model()->count(array(
                    'condition' => 'cnid=:cnid AND user_id=:user_id AND `check`=:check ',
                    'params' => array(':cnid'=>$val->cnid, ':user_id' => $val->user_id,':check'=>'false'),
                    ));
                  return $count_false;
                },
                ),
              array(
                'header' => 'จำนวนที่ไม่กรอก',
                'type' => 'html',
                'value' => function($val) {
                  $count_timeout = ValidateCaptcha::model()->count(array(
                    'condition' => 'cnid=:cnid AND user_id=:user_id AND `check`=:check ',
                    'params' => array(':cnid'=>$val->cnid, ':user_id' => $val->user_id,':check'=>'timeout'),
                    ));
                  return $count_timeout;
                },
                ),

              ),
            )); 

            ?>
          </div>
          <div class="modal fade" tabindex="-1" role="dialog" id="selectModalMessage">
           <div class="modal-dialog modal-lg" role="document"  style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;">
            <div class="modal-content">
             <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="font-size: 25px;color: #aaa;}">รายงาน</h4>
            </div>

            <div class="div-table-modal">
              <div class="modal-body">
                <button type="button" id="btnExportModal" class="btn btn-primary btn-icon glyphicons file"><i class="fa fa-file-excel-o"></i> Export</button>
                <div class="html-body"></div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
          </div>
        </div>
      </div>
      <script>
        function modalMessage(id,course){
         if(id != undefined && id != null && course != undefined && course != null){
          $.ajax({
           type: "POST",
           url: '<?php echo $this->createUrl('configCaptcha/ReportCaptchaModal'); ?>',
           data: {'id': id,'course':course},
           success: function(respon){
            if(respon){
             $('#selectModalMessage .html-body').html(respon);
             setTimeout(function() {
              $('#selectModalMessage').modal({
               keyboard: false
             });
            });
           }
         },
       });
        }
      };

      function toggle() {
       var ds = document.getElementById("display");
       if(ds.style.display == 'none')
        ds.style.display = 'block';
      else 
        ds.style.display = 'none';
    }

    $(document).ready(function(){
        var date_input=$('input[name="ValidateCaptcha[startdate_start]"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
        	format: 'yyyy-mm-dd',
        	container: container,
        	todayHighlight: false,
        	autoclose: false,
        	endDate: 'now'
        })

        var date_input=$('input[name="ValidateCaptcha[enddate_end]"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
        	format: 'yyyy-mm-dd',
        	container: container,
        	todayHighlight: true,
        	autoclose: true,
        	endDate: 'now'
        })

        <?php 
        if ($_GET['ValidateCaptcha']['search_course']!=0) {
          ?>
          $.ajax({
            url: "<?php echo Yii::app()->createUrl("ConfigCaptcha/LessonChange"); ?>",
            type: "POST",
            data: {id:<?= $_GET['ValidateCaptcha']['search_course'] ?>},
            success:function(data){
              $("#ValidateCaptcha_search_lesson").html(data);
              $("#ValidateCaptcha_search_lesson").val(<?= $_GET['ValidateCaptcha']['search_lesson']; ?>);
            }
          });
          <?php
        }
        ?>  
      });

    </script>

    <?php 
    Yii::app()->clientScript->registerScript('export', "
      $(function(){
        $('#btnExport').click(function(e) {
          window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$FormText."</h2>'+$('.div-table').html()));
          e.preventDefault();
        });
        $('.div-table a').attr('href','#');
      });

      ", CClientScript::POS_END);
      ?>

      <?php 
      Yii::app()->clientScript->registerScript('exportmodal', "

        $(function(){
          $('#btnExportModal').click(function(e) {
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$FormText."</h2>'+$('.div-table-modal').html()));
            e.preventDefault();
          });
          $('.div-table-modal a').attr('href','#');
        });

        ", CClientScript::POS_END);
        ?>

