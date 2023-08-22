<?php
$FormText = 'เพิ่ม ข้อมูล Excel ผู้ผ่านการเรียน';
$this->breadcrumbs = array($FormText);
// echo Yii::getVersion();
//$this->renderPartial('_form', array('model'=>$model,'profile'=>$profile,'authassign'=>$authassign,'FormText'=>$FormText));
?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/theme/scripts/plugins/forms/dropzone/css/dropzone.css"
      rel="stylesheet">
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/theme/scripts/plugins/forms/dropzone/dropzone.min.js"></script>
<div class="innerLR">
    <div class="widget">
        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">นำเข้าจาก Excel</h4>
        </div>
        <!-- // Widget heading END -->

        <div class="widget-body">
            <div class="row-fluid">
                <form enctype="multipart/form-data" id="sutdent-form" method="post"
                      action="<?php echo Yii::app()->createUrl('importdata/importexcelpass'); ?>">
                    <div class="span4">
                        <?php $form = $this->beginWidget('AActiveForm', array(
                            'id'=>'news-form',
                            'enableClientValidation'=>true,
                            'clientOptions'=>array(
                                'validateOnSubmit'=>true
                            ),
                            'errorMessageCssClass' => 'label label-important',
                            'htmlOptions' => array('enctype' => 'multipart/form-data')
                        )); ?>
                        <h4>นำเข้าไฟล์ <label>(ไฟล์ excel เท่านั้น)</label></h4>
                      
                            <?php echo $form->fileField($model,'excel_file',array('class'=>'form-control')); ?>
                            <!-- </span> -->
                            <?php echo $this->NotEmpty();?>
                            <?php echo $form->error($model,'excel_file'); ?>

                        <?php $this->endWidget(); ?>
                        <div class="form-actions">

                            <button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>นำเข้าไฟล์
                                excel
                            </button>
                            <!-- <button type="button" class="btn btn-icon btn-default glyphicons circle_remove"><i></i>Cancel</button> -->
                        </div>
                    </div>
                </form>
                <script type="text/javascript">
                    $('#sutdent-form').submit(function () {
                        
                        console.log();
                        if ($('#User_excel_file').val() == '') {
                            alert('กรุณาเลือกไฟล์ Excel');
                            return false;
                        }
                        return true;
                    });
                </script>
                <div class="span4">
                    <h4>แบบฟอร์ม</h4>
                    <a href="<?php echo Yii::app()->getBaseUrl() . '/../uploads/Import_Pass_Course_Md.xlsx'; ?>"
                       class="glyphicons download_alt"><i></i>Download Excel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="widget">
        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">การทำงาน</h4>
        </div>
        <!-- // Widget heading END -->
        <div class="widget-body">
            <div class="row-fluid" id='print'>
                <div class="widget-body">
                    <!-- Table -->

                    <?php
                    // var_dump($HisImportErrorMessageArr);
                    // exit();
                    // foreach ($data as $key => $value) {
                    //     # code...
                    //     var_dump($value['email']);
                    // }
                    if (count($data) > 0):?>
                        <table class="table table-striped table-bordered ">
                            <!-- Table heading -->
                            <?php
                            $headTable = <<<HTB
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>เลขบัตรประชาชน</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>รหัสสถาบัน</th>
                                        <th>โค้ดหลักสูตร</th>
                                        <th>เลขที่ ปก.</th>

                                       
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody>
HTB;
                                    echo $headTable;
                            foreach ($data as $key => $valueRow) {

                                    $number = $key + 1;
                                    $cards = $valueRow['cards'];
                                    $fullname = $valueRow['fullnames'];
                                    $institutions = $valueRow['institutions'];
                                    $coursemds = $valueRow['coursemds'];

                                    if($Insert_success[$key] == "notpass"){
                                        $msg = '<b style="color:red;">'.$valueRow['msg'].'</b>';
                                    }else{
                                        $msg = '<b style="color:green;">'.$valueRow['msg'].'</b>';
                                    }

                                    $counum = $valueRow['counum'];
                                    
                                    $BodyTable = <<<HTM
										<!-- Table row -->
										<tr class="gradeX">
											<td>$number</td>
                                            <td class="left">$cards</td>
											<td class="left">$fullname</td>
                                            <td class="left">$institutions</td>
											<td class="left">$coursemds</td>
                                            <td class="left">$counum</td>
                                            <td class="left">$msg</td>
										</tr>	
HTM;
                                    echo $BodyTable;
                                }
                            ?>
                            </tbody>
                        </table>
                        <!-- <input type="button" value="Print" onclick="printDiv('print')"> -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="widget">
        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">รหัสที่ใช้ใน Excel</h4>
        </div>
        <!-- // Widget heading END -->

        <div class="widget-body">
            <div class="row-fluid">
                   
              
                    <?php $idx = 1; ?>
                    <div class="widget-body" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. Code สถาบัน</h5>
                            <?php
                            $dataProvider = new CActiveDataProvider('Institution', array(
                                'criteria'=>array(
                                    'condition'=>'',
                                    'order'=>'id ASC', 
                                ),
                                'pagination' => false ));
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'columns' => array(
                                    array(            // display 'author.username' using an expression
                                        'header' => 'รหัสสถาบัน',
                                        'value' => '$data->code',
                                    ),
                                    array(            // display 'author.username' using an expression
                                        'header' => 'ชื่อสถาบัน',
                                        'value' => '$data->institution_name',
                                    ),
                                ),
                            ));
                            ?>
                    </div>

                     <div class="widget-body" style="margin-top:16px;">
                        <h5><?= $idx++; ?>. Code หลักสูตร</h5>
                            <?php
                            $dataProvider = new CActiveDataProvider('CourseMd', array(
                                'criteria'=>array(
                                    'condition'=>'',
                                    'order'=>'id ASC', 
                                ),
                                'pagination' => false ));
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'columns' => array(
                                    array(            // display 'author.username' using an expression
                                        'header' => 'โค้ดหลักสูตรกรมเจ้าท่า',
                                        'value' => '$data->code',
                                    ),
                                    array(            // display 'author.username' using an expression
                                        'header' => 'ชื่อหลักสูตร',
                                        'value' => '$data->course_name',
                                    ),
                                ),
                            ));
                            ?>
                    </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>