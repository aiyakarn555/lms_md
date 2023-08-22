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
$titleName = 'รายงายผลคะแนนสอบ';
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
                    if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true) {
                        if($model->categoryUniversity==NULL){
                            foreach ($model->categoryUniiversityList as $key => $val) {
                                $model->categoryUniversity=$key;
                                break;
                            }
                        }
                        
                        
                        echo '<div class="row">';
                        echo "<label>หลักสูตร</label>";
                        echo $form->dropDownList($model, 'categoryUniversity', $model->categoryUniiversityList,
                            array(
                                'class' => 'span6'
                            ));
                        echo '</div>';
// freedom
                        // $orgchart=OrgChart::model()->findAllByAttributes(array('active'=>'y'));
                        // $courseList = CHtml::listData($orgchart,'id','title');

                    

                    }
                    // else{
                    //     $user = Yii::app()->getModule('user')->user();
                    //     $model->typeOfUser = $user->authitem_name;
                    //     $owner_id = $user->id;
                    // }
                    echo '<div class="row">';
                    echo '<label>'.$model->getAttributeLabel('dateRang').'</label>';
                    $this->widget('zii.widgets.jui.CJuiDatepicker', array(
                        'model'=>$model,
                        'attribute'=>'dateRang',
                        'htmlOptions' => array(
                            'class' => 'span6',
                        ),
                        'options' => array(
                            'mode'=>'focus',
                            'dateFormat'=>'dd/mm/yy',
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

        <div class="widget-body" style="overflow: auto;" id="dvData">
            <!-- Table -->
            <table class="table table-bordered table-striped">
                <?php
                $cate_type = array('university'=>1,'company'=>2);
                if($model->typeOfUser != '') {
                    $cate_id = '';
                    if($model->typeOfUser == 'university'){
                        if($model->categoryUniversity != ''){
                            $cate_id = $model->categoryUniversity;
                        }
                    }
                    if($model->typeOfUser == 'company'){
                        if($model->categoryCompany != ''){
                            $cate_id = $model->categoryCompany;
                        }
                    }

                    if($cate_id == '') {
                        $course = CourseOnline::model()->with('cates')->findAll(array(
                            'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                            'order' => 'sortOrder'
                        ));
                    }else{
                        $course = CourseOnline::model()->with('cates')->findAll(array(
                            'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                            'order' => 'sortOrder'
                        ));
                    }
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
                        <th rowspan="3" style="vertical-align: middle;" class="center">ลำดับที่</th>
                        <th rowspan="3" style="vertical-align: middle;" class="center">ชื่อนามสกุล</th>
                        <?php
                        // foreach ($course as $key => $courseItem) {
                            if(isset($owner_id)) {
                                $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $model->categoryUniversity . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                            }else{
                                $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $model->categoryUniversity . '" AND active ="y"', 'order' => 'title'));
                            }
                            if(count($lesson) > 0) {
                                $lessonArray[$key] = $lesson;
                                ?>
                            <?php
                            }
                        // }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        foreach ($lessonArray as $key => $lessonItems) {
                            foreach ($lessonItems as $lessonItem) {
                                ?>
                                <th colspan="2" class="center"><?php echo $lessonItem->title; ?></th>
                            <?php
                            }
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        foreach ($lessonArray as $key => $lessonItems) {
                        foreach ($lessonItems as $lessonItem) {
                        ?>
                        <th class="center">ก่อน</th>
                        <th class="center">หลัง</th>
                        <?php }} ?>
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
                $course_id = $model->categoryUniversity;
                $orgcourse=OrgCourse::model()->findAll('course_id='.$course_id);
                $dep=array();
                foreach ($orgcourse as $key => $oc) {
                    array_push($dep, $oc->orgchart_id);
                }
                // 
                $criteria = new CDbCriteria();
                $criteria->with=array('user');
                // $criteria->compare('status','1');
                $criteria->compare('status','1');
                $criteria->addInCondition('department_id',$dep);
                $user=profiles::model()->findAll($criteria);
                foreach ($user as $userItem) { /** @var User $userItem */?>
                <!-- Table row -->
                    <tr>
                        <td class="center"><?php echo $orderNumber++; ?></td>
                        <td><?php echo $userItem->firstname." ".$userItem->lastname; ?></td>
                        <?php
                        foreach ($lessonArray as $key => $lessonItems) {
                            foreach ($lessonItems as $lessonItem) {

                                if($model->dateRang !='' ) {
                                    list($start,$end) = explode(" - ",$model->dateRang);
                                    $start = date("Y-d-m",strtotime($start))." 00:00:00";
                                    $end = date("Y-d-m",strtotime($end))." 23:59:59";
                                    $scorePre = Score::model()->findAll(array('condition'=>'lesson_id="'.$lessonItem->id.'" AND user_id ="'.$userItem->user_id.'" AND type="pre" AND create_date BETWEEN "'.$start.'" AND "'.$end.'"'));
                                }else{
                                    $scorePre = Score::model()->findAll(array('condition'=>'lesson_id="'.$lessonItem->id.'" AND user_id ="'.$userItem->user_id.'" AND type="pre" '));
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
                                            $scorePreText .= "/".$pre->score_total;
                                        }
                                    }

                                }
                                if($model->dateRang !='' ) {
                                    list($start,$end) = explode(" - ",$model->dateRang);
                                    $start = date("Y-d-m",strtotime($start))." 00:00:00";
                                    $end = date("Y-d-m",strtotime($end))." 23:59:59";
                                    $scorePost = Score::model()->findAll(array('condition'=>'lesson_id="'.$lessonItem->id.'" AND user_id ="'.$userItem->user_id.'" AND type="post" AND create_date BETWEEN "'.$start.'" AND "'.$end.'"'));
                                }else {
                                    $scorePost = Score::model()->findAll(array('condition' => 'lesson_id="' . $lessonItem->id . '" AND user_id ="' . $userItem->user_id . '" AND type="post" '));
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
                                            $scorePostText .= "/".$post->score_total;
                                        }
                                    }
                                }
                                ?>
                                <td class="center">
                                <?php 
                                echo $scorePreText; ?></td>
                                <td class="center"><?php echo $scorePostText; ?></td>
                            <?php }} ?>
                    </tr>
                <?php } ?>
                <!-- // Table row END -->

                </tbody>
                <!-- // Table body END -->

            </table>
            <!-- // Table END -->

        </div>
        <div class="text-center">
            <input type="button" id="btnExport" value=" Export Excel" class="btn btn-primary" />
        </div><br>
    </div>
</div>

<script>
    $("#btnExport").click(function(e) {
       
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#dvData').html()));
        e.preventDefault();
    });
</script>