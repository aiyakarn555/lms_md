<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<?php
$titleName = 'รายงานผู้ทำบัญชีที่ผ่านหลักสูตรที่สามารถนับชั่วโมงการพัฒนาความรู้ต่อเนื่องทางวิชาชีพบัญชี(CPD)';
$formNameModel = 'Passcours';

$this->breadcrumbs = array($titleName);
$search_export = '';
if ($search) {
    $gen = !empty($search['generation']) ? $search['generation'] : '';
    $name = !empty($search['search']) ? $search['search'] : '';
    $course_id = !empty($search['course_id']) ? implode(',', $search['course_id']) : '';
    $mem = !empty($search['memtype']) ? $search['memtype'] : '';
    $period_start = !empty($search['period_start']) ? $search['period_start'] : '';
    $period_end = !empty($search['period_end']) ? $search['period_end'] : '';
    if ($gen != '') {
        $search_export .= "&generation=$gen";
    }
    if ($name != '') {
        $search_export .= "&search=$name";
    }
    if ($course_id != '') {
        $search_export .= "&course_id=$course_id";
    }
    if ($mem != '') {
        $search_export .= "&memtype=$mem";
    }
    if ($period_start != '') {
        $search_export .= "&period_start=$period_start";
    }
    if ($period_end != '') {
        $search_export .= "&period_end=$period_end";
    }
}
Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
        $('#download').click(function(){
	   	window.location = '" . $this->createUrl('//Passcpd/ReportPasscpd') . "?' + $(this).parents('form').serialize() + '&download=true'+'$search_export';
	    return false;
	});
	$('#export').click(function(){
	   	window.location = '" . $this->createUrl('//Passcpd/ReportPasscpd') . "?' + $(this).parents('form').serialize() + '&export=true'+'$search_export';
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
	$.appendFilter("Passcours[news_per_page]", "news_per_page");
EOD
        , CClientScript::POS_READY);
?>

<div class="innerLR">
    <div class="widget">
        <?php
        $this->renderPartial('search', array(
            'model' => $model,
            'search' => $search
        ));
        ?>
    </div><!-- search-form -->



    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> <?php echo $titleName; ?></h4>
        </div>

        <div class="widget-body div-table" style="overflow: auto;">
            <!-- Table -->
            <table class="table table-bordered " >
                <!-- Table heading -->
                <thead>
                    <tr style="background-color: #b2d0e8;">
                        <th  style="vertical-align: middle;" class="center"><b>ลำดับที่</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>รหัสบัตรประชาชน</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>รหัสผู้ทำบัญชี</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>เลขทะเบียนผู้สอบบัญชีรับอนุญาต</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>คำนำหน้า</b></th>
                        <th  style="vertical-align: middle; width:7%;" class="center"><b>ชื่อ</b></th>
                        <th  style="vertical-align: middle; width:7%;" class="center"><b>นามสกุล</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>ประเภทสมาชิก</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่สมัครเป็นสมาชิก</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่เข้าอบรม</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่จบการอบรม</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>วันที่ผ่านการสอบ 60%</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>เวลาที่ผ่านการสอบ</b></th>
                        <th  style="vertical-align: middle; width:10%;" class="center"><b>ที่อยู่</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>เบอร์โทร</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>อีเมลล์</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>ชื่อวิชา</b></th>

                        <!--<th colspan="2" style="vertical-align: middle;" class="center"><b>ผลสอบ Final Test</b></th>-->
                        <th  style="vertical-align: middle;" class="center"><b>หนังสือรับรอง</b></th>
                        <th  style="vertical-align: middle;" class="center"><b>บัตรประชาชน</b></th>
                    </tr>
<!--                    <tr  style="background-color: #b2d0e8;">
                        <th class="center" style="width:5%;"><b>ครั้งที่1 คิดเป็นร้อยละ</b></th>
                        <th class="center" style="width:5%;"><b>ครั้งที่2 คิดเป็นร้อยละ</b></th>
                    </tr>-->
                </thead>
                <!-- // Table heading END -->

                <!-- Table body -->
                <tbody>
                <!-- Table row -->

                <?php

                $data_table = '';
//                $dataProvider = $model->highsearch();
                            $getPages = $_GET['page'];
                            if($getPages>1)$getPages--;
                            $start_cnt = $dataProvider->pagination->pageSize * $getPages;
//                            var_dump($dataProvider->pagination);
//                            exit();
            if($dataProvider->getData()!=''){
                foreach($dataProvider->getData() as $index => $data){
                    $date_start_learn = Helpers::learn_date_from_course($data['course_id'], $data['user_id']);
                    if(empty($data['passcours_date']) || $data['passcours_date'] < $date_start_learn){
                        $data['passcours_date'] = Helpers::learn_end_date_from_course($data['course_id'], $data['user_id']);
                        if($data['passcours_date'] > $data['pass_60_date'] ){
                            $data['passcours_date'] = $data['pass_60_date'];
                        }
                    }
                    $start_cnt++;

                    $CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($data['special_category'] === 'y') {
			$CertificateType = 'cpd';
		}
		//generate button
		$cert_button = CHtml::link('พิมพ์', 'javascript:void(0)', array(
				'submit' => array('//PassCpd/Certificate/'),
				'params' => array(
					'CourseId' => $data['course_id'],
					'UserId' => $data['user_id'],
					'CertificateType' => $CertificateType,
				),
				'target' => '_blank',
				'class' => 'btn btn-warning',
			));

                //--------------------------------------------
                /////////// gen ID card button //////////////////
                 if($data['pic_cardid'] != '') {
                    $idcard = $data['pic_cardid'];

                    //generate button
                    $regis_model = Coursescore::model()->findByAttributes(array('user_id'=>$data['user_id'],'course_id'=>$data['course_id']));

                    $file = Yush::getUrl($regis_model->register, Yush::SIZE_ORIGINAL, $idcard);

                    $IDcard_button = CHtml::link('บัตรประชาชน', $file, array(
    //                                'download' => $id_user,
                                    'target' => '_blank',
                                    'class' => 'btn btn-warning',
                            ));
                }else{
                    $IDcard_button = '-';
                }

                //---------------------------------------------
                $data_audit = (!empty($data['auditor_id']))? intval($data['auditor_id']):'-';
                if($data['type_user']==1){
                    $data_bookeeper_id = '-';
                    $color = '<font color="black">';
                }elseif($data['type_user']==3){
                    $data_bookeeper_id = '-';
                    $color = '<font color="blue">';
                }else{
                    $data_bookeeper_id = $data['username'];
                    if($data['type_user']==2){
                    $color = '<font color="red">';
                    }

                    if($data['type_user']==4){
                    $color = '<font color="#22bd1e">';
                    }
                }

                if($data['title_id']){
                    $title = Helpers::title_name($data['title_id']);
                } else {
                    $title = 'คุณ';
                }
                $pv = ($data['province'])?' จ.'.Helpers::province_name($data['province']):"";
                
                $data_table .= "<tr>
                    <td>".$start_cnt."</td>
                    <td>".$data['username']."</td>
                    <td>".$data_bookeeper_id."</td>
                    <td>".$data_audit."</td>
                    <td><center>".$title."</center></td>
                    <td>".$data['firstname']."</td>
                    <td>".$data['lastname']."</td>
                    <td>".$color.Helpers::lib()->changeTypeUser($data['id'])."</font></td>
                    <td>".Helpers::lib()->changeFormatDate($data['create_at'])."</td>
                    <td>".Helpers::lib()->changeFormatDate($date_start_learn)."</center></td>
                    <td>".Helpers::lib()->changeFormatDate($data['passcours_date'])."</center></td>
                    <td>".Helpers::lib()->changeFormatDate($data['pass_60_date'])."</center></td>
                    <td><center>".date("H:i",strtotime($data['pass_60_date'])).' น.'."</center></td>
                    <td>".$data['address'].$pv."</td>
                    <td><center>".$data['phone']."</center></td>
                    <td style='max-width: 100px;overflow: overlay;white-space: nowrap;'>".$data['email']."</td>
                    <td style='max-width: 200px;overflow: overlay;white-space: nowrap;'>".Helpers::lib()->changeNameCourse($data['course_title'])."</td>
                    <td><center>".$cert_button."</center></td>
                    <td><center>".$IDcard_button."</center></td>
                </tr>
                ";

                 }
            }else{
                $data_table .= "<tr>
                    <td colspan=18><b>กรุณาเลือกหลักสูตร</b></td>
                        </tr>";
            }
                 echo $data_table;
                ?>
                </tbody>
                <!-- // Table body END -->

            </table>
            <!-- // Table END -->
        </div>
        <?php
                    $this->widget('CLinkPager',array(
                                    'pages'=>$dataProvider->pagination
                                    )
                                );
                ?>
        <a href="Export_excel?Passcours[generation]=<?=$gen?>&Passcours[search]=<?=$name?>&Passcours[memtype]=<?=$mem?>&Passcours[course_id][]=<?=$course_id?>&Passcours[period_start]=<?=$period_start?>&Passcours[period_end]=<?=$period_end?>" target="_blank"><button type="submit" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> ส่งออกรายงาน (Excel)</button></a>
        <!--<button type="submit" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> ส่งออกรายงาน (Excel)</button>-->
        
        <?php echo CHtml::tag('button',array(
                                            'class' => 'btn btn-primary btn-icon glyphicons download',
                                            'id'=> 'download',
                                    ),'<i></i>ส่งออกไฟล์บัตรประชาชน และใบประกาศนียบัตร'); ?>
    </div>

</div>
<?php

//Yii::app()->clientScript->registerScript('export', "
//
//  $(function(){
//      $('#btnExport').click(function(e) {
////        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()));
////        e.preventDefault();
//            window.location = '". $this->createUrl('//Passcpd/ReportPasscpd')  . "?' + $(this).parents('form').serialize() + '&export=true'+'$search_export';
//	    return false;
//      });
//  });
//
//", CClientScript::POS_END);

?>

<!--<input type="text" class="chk_s" value="">
<div class="data_log"></div>-->
