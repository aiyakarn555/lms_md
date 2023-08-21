<?php
$title = "หลักสูตรนิสิต/นักศึกษา";
if (isset(Yii::app()->user->authitem_name)) {
    if (Yii::app()->user->authitem_name == 'company') {
        $title = "หลักสูตรผู้ประกอบวิชาชีพ";
    }
}
?>
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i
                        class="fa fa-fw fa-book"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">หลักสูตร</h3>

                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมหลักสูตร การทำงานของ Product ของ
                    Brother</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-9">
                <div class="row" data-toggle="isotope">

                    <?php if (Yii::app()->user->hasFlash('CheckQues')): ?>
                        <?php
                        $messages = '';
                        $flashes = Yii::app()->user->getFlashes(true);
                        foreach ($flashes as $key => $value) {
                            $msg = (!is_string($value) && isset($value['msg'])) ? $value['msg'] : $value;
                            $class_text = (!is_string($value) && isset($value['class'])) ? $value['class'] : 'information';
                            $messages = <<<MSG
    <div class="alert alert-$class_text">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>$msg</strong> 
    </div>
MSG;
                            echo $messages;
                        }
                        ?>
                    <?php endif; ?>

                    <?php
                    $this->breadcrumbs = array('หลักสูตร');
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
//                        'summaryText' => 'หลักสูตรทั้งหมด {count} หลักสูตร',
                        'summaryText' => '',
                        'emptyText' => 'ยังไม่มีข้อมูล',
                        'pagerCssClass' => 'pagination',
                        'pager' => array(
                            'maxButtonCount' => '10',
                            'class' => 'CLinkPager',
                            'htmlOptions' => array(
                                'class' => '',
                                'style' => 'margin:10px 0;'
                            ),
                            'firstPageLabel' => '<< หน้าแรก',
                            'prevPageLabel' => '< ย้อนกลับ',
                            'nextPageLabel' => 'ถัดไป >',
                            'lastPageLabel' => 'หน้าสุดท้าย >>',
                            'header' => false,
                            'selectedPageCssClass' => 'active',
                        ),
                    ));
                    ?>

                    <?php /*$this->widget('IGridView', array(
		'id'=>'catecourse-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			array(
				'header'=>'ลำดับ',
			    'value'=>'$this->grid->dataProvider->pagination->currentPage*
			    	$this->grid->dataProvider->pagination->pageSize + $row+1',
			    'htmlOptions' => array(
			     	'style' => 'text-align:center;',
			    	'width'=>'25',
			  	),
			),
			array(
				'name'=>'cate_title',
				'type'=>'html',
				'value'=>'CHtml::link($data->cate_title,array("//cateOnline/view","id"=>$data->cate_id))',
				'htmlOptions' => array(
					'width'=>'280',
				),
			),
			array(
				'header'=>'จำนวนหลักสูตร',
				'value'=>'$data->CountCourse',
				'htmlOptions' => array(
					'width'=>'75',
					'style' => 'text-align:center;'
				),
			),
			array(
			    'header'=>'รายละเอียด',
			    'type' => 'raw',
			    'value' => '$data->DetailCourse',
			    'htmlOptions' => array(
			        'width'=>'120',
			        'style' => 'text-align:center;'
			    ),
			),
		),
));*/ ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php echo CHtml::form();?>
                <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
                    <div class="panel-heading panel-collapse-trigger">
                        <h4 class="panel-title">ค้นหา</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group input-group margin-none">
                            <div class="row margin-none">
                                <div class="col-xs-12 padding-none">
                                    <input class="form-control" type="text" name="search_text" placeholder="คำค้นหา"/>
                                </div>
                            </div>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo CHtml::endForm();?>
                <h4>หลักสูตรแนะนำ</h4>

                <div class="slick-basic slick-slider" data-items="1" data-items-lg="1" data-items-md="1" data-items-sm="1"
                     data-items-xs="1">

                    <?php
                    $course_online = CourseOnline::model()->findAll(array(
                        'condition' => 'active="y"',
                        'order' => 'create_date DESC',
                        'limit' => '6',
                    ));
                    if ($course_online) {
                        foreach ($course_online as $course_online_data) {
                            $folder = explode("_", $course_online_data->course_id);
                            $imageShow = Yii::app()->request->baseUrl . '/uploads/courseonline/' . $folder[0] . '/small/' . $course_online_data->course_picture;
                            ?>


                            <div class="item">
                                <div class="panel panel-default paper-shadow box-course" data-z="0.5" data-hover-z="1"
                                     data-animated>
                                    <div class="panel-body">
                                        <div class="media media-clearfix-xs">
                                            <div class="media-left">
                                                <div class="cover width-90 width-100pc-xs overlay cover-image-full hover">
                                                    <span class="img icon-block s90 bg-default"></span>
                                        <span class="overlay overlay-full padding-none icon-block s90 bg-default">
                            <?php if ($course_online_data->course_picture != "") { ?>
                                <span class="v-center">
<!--                                            <img src="--><? //=$imageShow;?><!--" class="img-responsive" style="height: 90px; width: 90px;">-->
                                            <img src="http://placehold.it/90x90" class="img-responsive"
                                                 style="height: 90px; width: 90px;">
                                        </span>
                            <?php } else { ?>
                                <span class="v-center">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_course2.png"
                                                 class="img-responsive">
                                        </span>
                            <?php }?>
                                        </span>
                                                    <a href="#"
                                                       class="overlay overlay-full overlay-hover overlay-bg-white">
                                            <span class="v-center">
                            <span class="btn btn-circle btn-white btn-lg"><i class="fa fa-graduation-cap"></i></span>
                                            </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading margin-v-5-3"><a
                                                        href="#"><?= iconv_substr($course_online_data->course_title, 0, 100, 'utf-8'); ?> <?= $course_online_data->getGen($course_online_data->course_id); ?></a>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }
                    } ?>


                </div>
            </div>
        </div>
    </div>
</div>