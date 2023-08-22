<?php
$titleName = 'ภาพถ่ายห้องเรียนรู้ทางไกล';
$formNameModel = 'ExportCaptureScreen';

$this->breadcrumbs = array('จัดการ' . $titleName);
Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

?>

<div class="innerLR">

    <div class="widget" data-toggle="collapse-widget" data-collapse-closed="false">
        <div class="widget-head">
            <h4 class="heading  glyphicons search"><i></i>ค้นหาขั้นสูง</h4>
        </div>
        <div class="widget-body of-out in collapse" style="height: auto;">
            <div class="search-form">
                <div class="wide form" style="padding-top:6px;">
                    <form id="SearchFormAjax" action="" method="get">
                        <div class="row">
                            <label>ห้องเรียนรู้ทางไกล</label>
                            <select class="span6 chosen" name="ms_temas" id="ms_temas">
                                <option value="">ทั้งหมด</option>
                                <?php
                                $criteria = new CDbCriteria();
                                $criteria->compare('active', 'y');
                                //แสดงตาม Group
                                $modelUser = Users::model()->findByPk(Yii::app()->user->id);
                                $group = json_decode($modelUser->group);
                                if (!in_array(1, $group)){
                                    $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
                                    $criteria->addInCondition('create_by', $groupUser);    
                                }
                                $criteria->order = 'create_date DESC';
                                $course = Msteams::model()->findAll($criteria);
                                if ($course) {
                                    $array = [];
                                    foreach ($course as $EachCourse) {
                                ?>
                                        <option <?= ($_GET['ms_temas'] == $EachCourse->id ? 'selected="selected"' : '') ?> value="<?= $EachCourse->id ?>"><?=(( $EachCourse->course_md_code != "" && $EachCourse->course_md_code != null )? $EachCourse->course_md_code : "ไม่พบรหัส")?> : <?= $EachCourse->name_ms_teams ?></option>
                                <?php  }
                                } ?>
                            </select>
                        </div>

                        <div class="row">
                            <label>รุ่น</label>
                            <select class="span6 chosen" name="gen_id" id="gen_id">
                                <?php if( $_GET['ms_temas'] == null && $_GET['gen_id'] == null) { ?>
                                    <option value="">ทั้งหมด</option>
                                <?php }else{ ?>
                                    <?php 
                                        $criteria = new CDbCriteria;
                                        $criteria->compare("active","y");
                                        $criteria->compare("course_id",$_GET['ms_temas']);
                                        $generation = CourseGeneration::model()->findAll($criteria);
                                        if($generation){ ?>
                                            <option value="">--- เลือกรุ่นหลักสูตร ---</option>
                                        <?php foreach ($generation as $gen) { ?>
                                                <option <?= ($_GET['gen_id'] == $gen->gen_id ? 'selected="selected"' : '') ?> value="<?= $gen->gen_id ?>"><?= $gen->gen_detail ?>&nbsp;&nbsp;&nbsp;(<?= Helpers::lib()->CuttimeLang($gen->gen_period_start, 2)." - ".Helpers::lib()->CuttimeLang($gen->gen_period_end, 2) ?>)</option>
                                                <?php     
                                            }    
                                        }else { ?>
                                            <option value=''>--- ไม่พบรุ่นหลักสูตร ---</option>
                                    <?php } ?>
                            <?php } ?>
                            </select>
                        </div>
                       
                        <div class="row">
                            <label>ชื่อ หรือ นามสกุล</label>
                            <input class="span6" autocomplete="off" name="names" id="names" value="<?=$_GET['names']?>" type="text">
                        </div>
                        <div class="row">
                            <button class="btn btn-primary mt-10 btn-icon glyphicons search"><i></i> ค้นหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName; ?> <b style="color: red">กรุณาเลือกห้องเรียนรู้ทางไกล แล้วค้นหา</b></h4>
        </div>
        <div class="widget-body">
            <div class="separator bottom form-inline small">
                <span class="pull-right">
                    <label class="strong">แสดงแถว:</label>
                    <?php echo $this->listPageShow($formNameModel); ?>
                </span>
            </div>
            <div class="clear-div"></div>

            <div class="overflow-table mt-2">
                <table class="table table-main">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ นามสกุล</th>
                            <th>ห้องเรียนรู้ทางไกล</th>
                            <th class="text-center">ภาพถ่าย</th>
                            <th class="text-center">Export Excel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value_da) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td>
                                <?= $value_da->pro->firstname. " " .$value_da->pro->lastname ?>
                            </td>
                            <td>
                              <?= $value_da->msteams->name_ms_teams ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo $this->createUrl('/CaptureScreen/ExportView/'.$value_da->user_id.'?ms_teams_id='.$value_da->ms_teams_id); ?>" class="btn-pic btn btn-primary">
                                    <span class="glyphicon glyphicon-eye-open"></span> รูปภาพ
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?= $this->createUrl('/CaptureScreen/GenSingleExcelCaptureScreen/'.$value_da->user_id.'?ms_teams_id='.$value_da->ms_teams_id) ?>" class="btn-excel btn ">
                                    <span class="glyphicon glyphicon-export"></span> Export Excel
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <?php if(count($data) > 0) { 
                $hrefImageAll = $this->createUrl('/CaptureScreen/ExportViewAll/'.$value_da->ms_teams_id);
                $hrefExcelAll = $this->createUrl('/CaptureScreen/GenAllExcelCaptureScreen') ;
                $action = '';
        }else{
                $hrefImageAll = 'javascript:void(0);';
                $hrefExcelAll = 'javascript:void(0);';
                $action = 'onclick="alertExport()"';
        } ?>
        <a href="<?= $hrefImageAll ?>" class="btn-pic btn btn-primary" <?= $action ?>>
            <span class="glyphicon glyphicon-eye-open"></span> รูปภาพผู้เรียนทั้งหมด
        </a>
        <a href="<?= $hrefExcelAll ?>" class="btn-excel btn" <?= $action ?>>
            <span class="glyphicon glyphicon-export"></span> Export Excel ทั้งหมด
        </a>
    </div>


</div>

<script>
 function alertExport(){
    swal("ไม่พบหลักสูตร", "กรุณาเลือก และค้นหาหลักสูตร", "warning");
 }

 $('#ms_temas').on('change', function() {
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createAbsoluteUrl("/CaptureScreen/GetGeneration"); ?>',
        data: ({
            ms_temas: this.value,
        }),
        success: function(data) {
            if(data != ""){
                $("#gen_id").html(data);
            }
        }
    });
 });


</script>