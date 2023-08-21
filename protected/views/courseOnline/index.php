<style>
    .grid-view th {
        font-size: 22px;
        /*font-weight: bold !important;*/
    }
</style>

<?php
$cateOnlineModel = CateOnline::model()->findByPk($_GET['id']);
$this->breadcrumbs = array(
    'หลักสูตร' => array('//cateOnline/index'),
    $cateOnlineModel->cate_title
);
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
<script type="text/javascript">
    function ShowUp(id) {
        $("#Show" + id).parents("tr").next("tr").toggle();
        $("#Show" + id).toggleClass("up");
    }
</script>

<!-- <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>หมายเหตุ</strong> การสั่งซื้อหลักสูตรสามารถซื้อได้ 1 หลักสูตร ต่อ 1 ครั่งเท่านั้น
</div> -->
<!--<div id="infinity_contacts_details-3" class="widget contacts-details_wrapper" style="margin-top: 0;">-->
<!--    <div class="widget-title"><h4>--><?php //echo $title; ?><!-- >>> --><?php //echo $cateOnlineModel->cate_title; ?><!--</h4></div>-->
<!--</div>-->
<div class="container">
    <div class="page-section">
        <div class="row">
            <?php


            $this->widget('GGridView', array(
                'id' => 'courseonline-grid',
                //'dataProvider'=>$model->searchBuy(),
                'dataProvider' => $model->search($pk),
                'filter' => $model,
                'columns' => array(
                    /*array(
                        'header'=>'ลำดับ',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage*
                            $this->grid->dataProvider->pagination->pageSize + $row+1',
                        'htmlOptions' => array(
                            'style' => 'text-align:center;',
                            'width'=>'25',
                        ),
                    ),*/
                    // array(
                    //  'header'=>'รูปภาพ',
                    //  'type'=>'raw',
                    //  'value'=> 'Controller::ImageShowIndex(Yush::SIZE_THUMB,$data,$data->course_picture,array())',
                    //  'htmlOptions'=>array('width'=>'110')
                    // ),
                    array(
                        'name' => 'course_title',
                        'value' => 'CHtml::link($data->course_title,Yii::app()->createUrl("courseOnline/view",array("id"=>$data->course_id)), array("target"=>"_blank","style"=>"font-size:22px;"))',
                        'type' => 'raw',
                        'htmlOptions' => array(
                            'width' => '290',
                        ),
                    ),
                    array(
                        'name' => 'course_lecturer',
                        'value' => 'CHtml::link($data->teachers->teacher_name,Yii::app()->createUrl("teacher/view",array("id"=>$data->course_lecturer)), array("target"=>"_blank","style"=>"font-size:22px;"))',
                        'type' => 'raw',
                        'filter' => $this->listTeacher($model),
                        'htmlOptions' => array(
                            'width' => '200',
                        ),
                    ),
                    /*array(
                        //'name'  => 'status',
                        'header'=>'สถานะ',
                        'value' => 'Helpers::lib()->checkCoursePass($data->course_id)',
                        'type'  => 'raw',
                        'htmlOptions' => array(
                            'width'=>'200',
                        ),
                    ),*/
                    /*array(
                        'name'=>'course_point',
                        'value'=>'number_format($data->course_point)',
                        'htmlOptions' => array(
                            'width'=>'30',
                        ),
                    ),
                    array(
                        'header'=>'บทเรียน',
                        'value'=>'$data->lessonCount',
                        'htmlOptions' => array(
                            'width'=>'50',
                            'style' => 'text-align:center;'
                        ),
                    ),*/
                    /*array(
                        'header'=>'เวลาเรียน',
                        'type' => 'raw',
                        //'value'=>'$data->course_id',
                        'value'=>'Helpers::lib()->CheckDateTimeUser($data->course_id)',
                        'htmlOptions' => array(
                            'width'=>'80',
                            'style' => 'text-align:center;'
                        ),
                        'visible'=>$this->checkVisible()
                    ),*/
                    /*array(
                        'header'=>'แบบสอบถาม',
                        'type' => 'raw',
                        'value'=>'$data->Evaluate',
                        'htmlOptions' => array(
                            'style' => 'text-align:center;'
                        ),
                        'visible'=>$this->checkVisible()
                    ),*/
                    // array(
                    //     'header'=>'พิมพ์',
                    //     'type' => 'raw',
                    //     'value'=>'Helpers::lib()->CheckTestingPass($data->course_id)',
                    //     'htmlOptions' => array(
                    //         'style' => 'text-align:center;'
                    //     ),
                    //     'visible'=>$this->checkVisible()
                    // ),
                    // array(
                    //  'name'=>'course_price',
                    //  'value'=>'number_format($data->course_price)',
                    //  'htmlOptions' => array(
                    //      'width'=>'30',
                    //  ),
                    // ),
                    // array(
                    //     'header'=>'สั่งซื้อสินค้า',
                    //     'type' => 'raw',
                    //     'value' => 'Helpers::lib()->CheckBuyItem($data->course_id,"string")',
                    //     'htmlOptions' => array(
                    //         'width'=>'90',
                    //         'style' => 'text-align:center;'
                    //     ),
                    //     'headerHtmlOptions' => array(
                    //         'style' => 'text-align:center;'
                    //     ),
                    // ),
                    array(
                        'value' => '$data->Arrow',
                        'type' => 'raw',
                        'htmlOptions' => array(
                            'style' => 'text-align:center;',
                            'width' => '10',
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>


