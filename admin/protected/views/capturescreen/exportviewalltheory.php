<?php
$titleName = 'จัดการภาพแคปหน้าจอผู้เรียนทั้งหมด';

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
            <a class="btn btn-link btn-backpage"  href="<?= Yii::app()->createUrl('CaptureScreen/ExportIndexTheory'); ?>">
                <span class="glyphicon glyphicon-chevron-left"></span> ย้อนกลับ
            </a>
            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName; ?></h4>
                </div>
                <div class="widget-body capscreen-card">
                 <h5> ห้องเรียนรู้ทางไกล:<strong class="text-primary"> <?= $Courses->course_title ?></strong></h5>
               
                 <?php foreach ($model as $key => $value) { 


                    $criteria = new CDbCriteria;
                    $criteria->compare("t.user_id",$value->user_id);
                    $criteria->compare("course_id",$Courses->id);
                    $criteria->order = 'create_date DESC';
                    $criteria->limit = 5;
                    $CaptureLearn = CaptureLearn::model()->with('pro')->findAll($criteria);

                    //if(!empty($CaptureLearn)){


                        ?>

                        <div class="panel panel-info panel-capture">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <h5 class="panel-item">
                                            เลขบัตรประชาชน<br>
                                            <strong><?= $value->pro->identification ?></strong>
                                        </h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <h5 class="panel-item">
                                            ชื่อ นามสกุล<br>
                                            <strong><?= $value->pro->firstname. " " .$value->pro->lastname ?></strong>
                                        </h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <h5 class="panel-item">
                                            วันที่เริ่มเรียน - วันที่สิ้นสุด <br>
                                            <strong><?= $Courses->course_date_start. " - " .$Courses->course_date_end  ?></strong>
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            

                            <?php 

                            if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/FaceRegis/' . $value->user_id.'.jpg')) {
                                $srcUser = Yii::app()->baseUrl.'/../uploads/FaceRegis/'.$value->user_id.'.jpg';
                            }else{
                                if(file_exists(YiiBase::getPathOfAlias('webroot') . '/../../../uploads/FaceRegis/' . $value->user_id.'.jpg')){
                                    $srcUser = Yii::app()->theme->baseUrl . '/../../../uploads/FaceRegis/' .$value->user_id.'.jpg';
                                }else{
                                    $srcUser = "<div align='center'>-</div>";
                                }
                            }

                            if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/IdCard/' . $value->user_id.'.jpg')) {
                                $srcIdCard = Yii::app()->baseUrl.'/../uploads/IdCard/'.$value->user_id.'.jpg';
                            }else{
                                if(file_exists(YiiBase::getPathOfAlias('webroot') . '/../../../uploads/IdCard/' . $value->user_id.'.jpg')){
                                    $srcIdCard = Yii::app()->theme->baseUrl . '/../../../uploads/IdCard/' .$value->user_id.'.jpg';
                                }else{
                                    $srcIdCard = "<div align='center'>-</div>";
                                }
                            }
                            ?>


                            <div class="panel-body">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-3"><h4>ภาพจากบทเรียนรู้ด้วยตัวเอง</h4></div>
                                        </div>
                                        <br>
                                        <?php $i=1; foreach ($CaptureLearn as $key1 => $val) { ?>
                                            <?php 
                                                if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/learn_picture/'.$val->course_id.'/'.$val->user_id.'/' . $val->file_name)) {
                                                    $src = Yii::app()->baseUrl. '/../uploads/learn_picture/'.$val->course_id.'/' .$val->user_id.'/' . $val->file_name;
                                                }else{
                                                    if(file_exists(YiiBase::getPathOfAlias('webroot') . '/../../../uploads/learn_picture/' .$val->course_id.'/' .$val->user_id.'/' . $val->file_name)){
                                                        $src = Yii::app()->theme->baseUrl . '/../../../uploads/learn_picture/'.$val->course_id.'/' .$val->user_id.'/' . $val->file_name;
                                                    }else{
                                                        $src = "";
                                                    }
                                                }
                                                ?>
                                                <?php if($src != ""){ ?>
                                                    <div class="col-sm-3 col-xs-5">
                                                        <img src="<?=$src?>">
                                                        <div class="img-date">
                                                            <p class="mt-1"><b>รูปที่ <?= $i++; ?></b> วันที่ <?= explode(" ",$val->create_date)[0] ?></p>
                                                            <p class="mt-1">เวลา <?= explode(" ",$val->create_date)[1] ?></p>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                        <?php } ?>
                                    </div>
                                <div class="row">
                                    <div class="col-sm-2 col-xs-4">
                                        <img src="<?= $srcUser ?>" class="w-100" alt="">
                                        <h5 class="text-center mt-1">
                                            รูปถ่ายสมัครสมาชิก
                                        </h5>
                                    </div>
                                    <div class="col-sm-2 col-xs-4">
                                        <img src="<?=$srcIdCard?>" class="w-100" alt="">
                                        <h5 class="text-center mt-1">
                                            รูปถ่ายบัตรประชาชน...
                                        </h5>
                                    </div>
                                </div>
                            </div>

                    </div>
                <?php //} 
            
            
                    }  ?>


            </div>
          <!--   <nav aria-label="Page navigation" class="pull-right">
                <ul class="pagination">
                    <li class="disabled">
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav> -->
        </div>