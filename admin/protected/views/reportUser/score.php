<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$titleName = 'รายงานผลคะแนนสอบ';
$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
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

    <?php
    /**  */
    /*$this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'nameSearch','type'=>'text'),
            array('name'=>'typeOfUser','type'=>'list','query'=>$model->typeOfUserList),
            array('name'=>'course','type'=>'list','query'=>$model->courseList),
            array('name'=>'dateRang','type'=>'text'),

            //array('name'=>'course_point','type'=>'text'),
        ),
    ));*/?>
    <div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
        <div class="widget-head">
            <h4 class="heading  glyphicons search"><i></i>ค้นหาขั้นสูง</h4>
        </div>
        <div class="widget-body collapse" style="height: 0px;">
            <div class="search-form">
                <div class="wide form">
                    <?php
                    $form=$this->beginWidget('CActiveForm', array(
                        'action'=>Yii::app()->createUrl($this->route),
                        'method'=>'get',
                        'id'=>'SearchFormAjax',
                    ));
                    ?>

                    <div class="form-group">
                        <label>หน่วยงาน</label>
                        <?php
                        echo $form->dropDownList($model, 'company_id', Company::getCompanyList(), array(
                            'empty' => '---เลือกหน่วยงาน---',
                            'class' => 'form-control',
                            'style' => 'width:100%',
                            'ajax' =>
                                array('type' => 'POST',
                                    'dataType' => 'json',
                                    'url' => CController::createUrl('/user/admin/division'), //url to call.
//                                                    'update' => '#' . CHtml::activeId($model, 'division_id'), // here for a specific item, there should be different update
                                    'success' => 'function(data){
                                                        $("#division_id").empty();
                                                        $("#division_id").append(data.data_dsivision);
                                                        $("#position_id").empty();
                                                        $("#position_id").append(data.data_position);
                                                    }',
                                    'data' => array('company_id' => 'js:this.value'),
                                ))); ?>
                        <?php echo $form->error($model, 'company_id'); ?>
                    </div>
                    <div class="form-group">
                        <label>ศูนย์/แผนก</label>
                        <?php
                        //                                        var_dump($model->division_id);
                        echo $form->dropDownList($model, 'division_id', Division::getDivisionList(), array('empty' => '---เลือก ศุนย์/แผนก---', 'class' => 'form-control', 'style' => 'width:100%', 'id' => 'division_id')); ?>
                        <?php echo $form->error($model, 'division_id'); ?>
                    </div>
                    <div class="form-group">
                        <label>ตำแหน่ง</label>
                        <?php
                        echo $form->dropDownList($model, 'position_id', Position::getPositionList(), array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%','id'=>'position_id')); ?>
                        <?php echo $form->error($model, 'position_id'); ?>
                    </div>

                    <?php
                    if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true) {
                        echo '<div class="row">';
                        /** @var CActiveForm $form */
                        echo '<label>'.$model->getAttributeLabel('course').'</label>';
                        echo $form->dropDownList($model,'course',$model->CourseListFreedom,
                            array(
                                'empty'=>'เลือกหลักสูตร',
                                'class'=>'span6 type'
                            ));
                        echo '</div>';
                    }else{
                        $user = Yii::app()->getModule('user')->user();
                        $model->typeOfUser = $user->authitem_name;
                        $owner_id = $user->id;
                    }

                    echo '<div class="row">';
                    echo '<label>'.$model->getAttributeLabel('dateRang').'</label>';
                    echo $form->textField($model,'dateRang',array('class' => 'span6'));
                    echo '</div>';
                    echo '<div class="row">';
                    echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons search'),'<i></i> ค้นหา');
                    echo '</div>';
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> <?php echo $titleName; ?></h4>
        </div>

        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
            <table class="table table-bordered table-striped">
                <?php
                $cate_type = array('university'=>1,'company'=>2);
                if($model->course!=""){
                    $course = CourseOnline::model()->findAll(array(
                        'condition' => 'active = "y" AND course_id='.$model->course.'',
                        'order' => 'sortOrder'
                    ));
                }else{
                    $course = CourseOnline::model()->findAll(array(
                        'condition' => 'active = "y"',
                        'order' => 'sortOrder'
                    ));
                }
                ?>
                <!-- Table heading -->
                <thead>
                    <tr>
                        <?php
                        foreach ($course as $key => $courseItem) {
                            if(isset($owner_id)) {
                                $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                            }else{
                                $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
                            }
                            if(count($lesson) > 0) {
                                $lessonArray[$key] = $lesson;
                                ?>
<!--                                <th colspan="--><?php //echo count($lesson)*2; ?><!--" class="center">--><?php //echo $courseItem->course_title; ?><!--</th>-->
                            <?php
                            }
                        }
                        ?>
                    </tr>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle;" class="center">ลำดับที่</th>
                        <th rowspan="2" style="vertical-align: middle;" class="center">ชื่อนามสกุล</th>
                        <?php
                        if(!empty($lessonArray)){
                            foreach ($lessonArray as $key => $lessonItems) {
                                foreach ($lessonItems as $lessonItem) {
                                    ?>
                                    <th colspan="2" class="center"><?php echo $lessonItem->title; ?></th>
                                <?php
                                }
                            }
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        if(!empty($lessonArray)){
                        foreach ($lessonArray as $key => $lessonItems) {
                        foreach ($lessonItems as $lessonItem) {
                        ?>
                        <th class="center">ก่อน</th>
                        <th class="center">หลัง</th>
                        <?php }}} ?>
                    </tr>
                </thead>
                <!-- // Table heading END -->

                <!-- Table body -->
                <tbody>
                <?php
                $sqlUser = " SELECT *,tbl_users.id AS user_id FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id ";
                if($model->typeOfUser == 'university') {
                    $sqlUser .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                }
                $sqlUser .= "WHERE status='1' ";
                if($model->typeOfUser == 'university' ) {
                    if($model->university != '') {
                        $sqlUser .= " AND university.id = '".$model->university."' ";
                    }
                }
                if($model->typeOfUser !='' ) {
                    $sqlUser .= ' AND authitem_name = "'.$model->typeOfUser.'" ';
                }

                if($model->company_id !='' ) {
                    $sqlUser .= " AND tbl_users.company_id = '".$model->company_id."' ";
                }
                if($model->division_id !='' ) {
                    $sqlUser .= " AND tbl_users.division_id = '".$model->division_id."' ";
                }
                if($model->position_id !='' ) {
                    $sqlUser .= " AND tbl_users.position_id = '".$model->position_id."' ";
                }

                /*if($model->nameSearch != '') {
                    $search = explode(" ", $model->nameSearch);
                    $searchCount = count($search);
                    $sqlUser .= "AND (";
                    foreach ($search as $key => $searchText) {
                        $sqlUser .= "(username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%')";
                        if ($searchCount != $key + 1) {
                            $sqlUser .= " OR ";
                        }
                    }
                    $sqlUser .= ")";
                }*/

                $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
                $orderNumber = 1;

                foreach ($user as $userItem) { /** @var User $userItem */?>
                <!-- Table row -->
                    <tr>

                        <td class="center"><?php echo $orderNumber++; ?></td>
                        <td class="center"><?php echo $userItem['firstname']." ".$userItem['lastname']; ?></td>
                        <?php
                        if(!empty($lessonArray)){
                        foreach ($lessonArray as $key => $lessonItems) {
                            foreach ($lessonItems as $lessonItem) {
                                if($model->dateRang !='' ) {
                                    list($start,$end) = explode(" - ",$model->dateRang);
                                    $start = date("Y-m-d",strtotime($start))." 00:00:00";
                                    $end = date("Y-m-d",strtotime($end))." 23:59:59";
                                    $scorePre = Score::model()->findAll(array('condition'=>'lesson_id="'.$lessonItem->id.'" AND user_id ="'.$userItem['user_id'].'" AND type="pre" AND create_date BETWEEN "'.$start.'" AND "'.$end.'"'));
                                }else{
                                    $scorePre = Score::model()->findAll(array('condition'=>'lesson_id="'.$lessonItem->id.'" AND user_id ="'.$userItem['user_id'].'" AND type="pre" '));
                                }

                                $scorePreText = "";
                                if(empty($scorePre)){
                                    $scorePreText = "-";
                                }else{
                                    $scorePreCount = count($scorePre);
                                    foreach ($scorePre as $key => $pre) {
                                        $scorePreText .= $pre->score_number;
                                        if($scorePreCount-1 != $key){
                                            $scorePreText .= ",";
                                        }else{
                                            $scorePreText .= " จาก ".$pre->score_total;
                                        }
                                    }

                                }
                                if($model->dateRang !='' ) {
                                    list($start,$end) = explode(" - ",$model->dateRang);
                                    $start = date("Y-m-d",strtotime($start))." 00:00:00";
                                    $end = date("Y-m-d",strtotime($end))." 23:59:59";
                                    $scorePost = Score::model()->findAll(array('condition'=>'lesson_id="'.$lessonItem->id.'" AND user_id ="'.$userItem['user_id'].'" AND type="post" AND create_date BETWEEN "'.$start.'" AND "'.$end.'"'));
                                }else {
                                    $scorePost = Score::model()->findAll(array('condition' => 'lesson_id="' . $lessonItem->id . '" AND user_id ="' . $userItem['user_id'] . '" AND type="post" '));
                                }

                                $scorePostText = "";
                                if(empty($scorePost)){
                                    $scorePostText = "-";
                                }else{
                                    $scorePostCount = count($scorePost);
                                    foreach ($scorePost as $key => $post) {
                                        $scorePostText .= $post->score_number;
                                        if($scorePostCount-1 != $key){
                                            $scorePostText .= ",";
                                        }else{
                                            $scorePostText .= " จาก ".$post->score_total;
                                        }
                                    }
                                }
                                ?>
                                <td class="center"><?php echo $scorePreText; ?></td>
                                <td class="center"><?php echo $scorePostText; ?></td>
                            <?php }} ?>
                    </tr>
                <?php }} ?>
                <!-- // Table row END -->

                </tbody>
                <!-- // Table body END -->

            </table>
            <!-- // Table END -->

        </div>
        <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
    </div>
</div>
<?php

Yii::app()->clientScript->registerScript('export', "

  $(function(){
      $('#btnExport').click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()));
        e.preventDefault();
      });
  });

", CClientScript::POS_END);

?>
