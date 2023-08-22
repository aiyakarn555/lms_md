<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />


<?php
$titleName = 'ระบบ Chat';
$formNameModel = 'Chat';
$this->breadcrumbs=array($titleName);


Yii::app()->clientScript->registerScript('search', "
 $('#SearchFormAjax').submit(function(){
    /* $.fn.yiiGridView.update('$formNameModel-grid', {
         data: $(this).serialize()
     });*/
     return true;
 });
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    /*$.updateGridView = function(gridID, name, value) {
        $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
        $.fn.yiiGridView.update(gridID, {data: $.param(
            $("#"+gridID+" input, #"+gridID+" .filters select")
        )});
    }
    $.appendFilter = function(name, varName) {
        var val = eval("$."+varName);
        $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
    }
    $.appendFilter("Report[news_per_page]", "news_per_page");*/

    $('.collapse-toggle').click();
    $('#Cometchat_dateRang').attr('readonly','readonly');
   	$('#Cometchat_dateRang').css('cursor','pointer');
    $('#Cometchat_dateRang').daterangepicker();

EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
    <?php
    /**  */
    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'nameSearch','type'=>'text'),
            array('name'=>'dateRang','type'=>'text'),
        ),
    ));?>
    <div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> 
				<?php echo $titleName;?>
			</h4>
		</div>
		<div class="widget-body">
			<div class="clear-div"></div>
			<div class="overflow-table" style="text-align:center;">
				<?php if($model->nameSearch != '') {
					$sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' AND ";
        			$search = explode(" ",$model->nameSearch);
        			$searchCount = count($search);
        			$sqlUser .= "(";
			        foreach ($search as $key => $searchText) {
			            $sqlUser .= "(username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%')";
			            if($searchCount != $key+1){
			                $sqlUser .= " OR ";
			            }
			        }
			        $sqlUser .= ")";
 					$user = Yii::app()->db->createCommand($sqlUser)->queryAll();
 					?>
					<table class="table table-bordered table-striped">
						<thead>
							<th>ชื่อผู้ใช้</th>
							<th>คู่สนทนา</th>
							<th>ข้อความล่าสุด</th>
							<th>เวลาสนทนาล่าสุด</th>
							<th>ดูข้อมูลการสนทนา</th>
						</thead>
						<tbody>
 					<?php
		 					if (!empty($user)) {
		 						foreach ($user as $us) {
		 							$criteria=New CDbCriteria;
		 							$criteria->with=array('from_rel','to_rel');
		 							$criteria->condition = 't.from='.$us['id'];
		 							$criteria->order = "t.id desc";

		 							if($model->dateRang !='' ) {
	                                    list($start,$end) = explode(" - ",$model->dateRang);
	                                    $start=strtotime($start);
	                                    $end=strtotime($end);
	                                    // $start = date("Y-d-m",strtotime($start))." 00:00:00";
	                                    // $end = date("Y-d-m",strtotime($end))." 23:59:59";
	                                    $criteria->addBetweenCondition("t.sent",$start,$end,"AND");
                                	}
                                	// AND create_date BETWEEN "'.$start.'" AND "'.$end.'"'

		 							$userchat = Cometchat::model()->findAll($criteria);
		 							$user_arr=array();
		 					?>
			 					<?php
			 					foreach ($userchat as $uc) {
			 						if (in_array($uc->to,$user_arr)) {

									}else{
										array_push($user_arr,$uc->to);
										echo "<tr>";
										echo "<td>".$uc->from_rel->profiles->firstname." ".$uc->from_rel->profiles->lastname."</td>";
										echo "<td>".$uc->to_rel->profiles->firstname." ".$uc->to_rel->profiles->lastname."</td>";
										echo "<td>".$uc->message."</td>";
										echo "<td>".date('d/m/Y',$uc->sent)."</td>";
										if($model->dateRang !='' ){
											echo "<td><a href='view?from=".$uc->from."&to=".$uc->to."&start=".$start."&end=".$end."' class='btn-action glyphicons eye_open btn-success'><i></i></a></td>";
										}else{
											echo "<td><a href='view?from=".$uc->from."&to=".$uc->to."' class='btn-action glyphicons eye_open btn-success'><i></i></a></td>";
										}
										echo "</tr>";
									}
			 					}
			 					?>
							<?php } ?>
		 					<?php }else{ ?>
								<h3 style="color: red;">ไม่พบข้อมูล</h3>
		 					<?php } ?>
		 					</tbody>
		 					</table>
				<?php }else if($model->dateRang !=''){?>
				<table class="table table-bordered table-striped">
				<thead>
					<th>ชื่อผู้ใช้</th>
					<th>คู่สนทนา</th>
					<th>ข้อความล่าสุด</th>
					<th>เวลาสนทนาล่าสุด</th>
					<th>ดูข้อมูลการสนทนา</th>
				</thead>
				<tbody>
				<?php
						$criteria=New CDbCriteria;
						$criteria->with=array('from_rel','to_rel');
						$criteria->order = "t.id desc";
                        list($start,$end) = explode(" - ",$model->dateRang);
                        $start=strtotime($start);
                        $end=strtotime($end);
                        $criteria->addBetweenCondition("t.sent",$start,$end,"AND");
						$userchat = Cometchat::model()->findAll($criteria);
						$user_arr=array();
						//
						foreach ($userchat as $uc) {
							$user_check=(string)$uc->from.",".$uc->to;
							$user_check1=(string)$uc->to.",".$uc->from;
	 						if ((in_array($user_check,$user_arr)) OR (in_array($user_check1,$user_arr))) {

							}else{
								array_push($user_arr,(string)$uc->from.",".$uc->to);
								echo "<tr>";
								echo "<td>".$uc->from_rel->profiles->firstname." ".$uc->from_rel->profiles->lastname."</td>";
								echo "<td>".$uc->to_rel->profiles->firstname." ".$uc->to_rel->profiles->lastname."</td>";
								echo "<td>".$uc->message."</td>";
								echo "<td>".date('d/m/Y',$uc->sent)."</td>";
								echo "<td>".$uc->to_rel->profiles->firstname."</td>";
								echo "</tr>";
							}
	 					}
				?>
				</tbody>
				</table>
				<?php }else{ ?>
					<table class="table table-bordered table-striped">
						<thead>
							<th>ชื่อผู้ใช้</th>
							<th>คู่สนทนา</th>
							<th>ข้อความล่าสุด</th>
							<th>เวลาสนทนาล่าสุด</th>
							<th>ดูข้อมูลการสนทนา</th>
						</thead>
					<tbody>
					<?php
						$criteria=New CDbCriteria;
						$criteria->with=array('from_rel','to_rel');
						$criteria->order = "t.id desc";
						$userchat = Cometchat::model()->findAll($criteria);
						$user_arr=array();
						//
						foreach ($userchat as $uc) {
							$user_check=(string)$uc->from.",".$uc->to;
							$user_check1=(string)$uc->to.",".$uc->from;
	 						if ((in_array($user_check,$user_arr)) OR (in_array($user_check1,$user_arr))) {

							}else{
								array_push($user_arr,(string)$uc->from.",".$uc->to);
								echo "<tr>";
								echo "<td>".$uc->from_rel->profiles->firstname." ".$uc->from_rel->profiles->lastname."</td>";
								echo "<td>".$uc->to_rel->profiles->firstname." ".$uc->to_rel->profiles->lastname."</td>";
								echo "<td>".$uc->message."</td>";
								echo "<td>".date('d/m/Y',$uc->sent)."</td>";
								echo "<td><a href='view?from=".$uc->from."&to=".$uc->to."' class='btn-action glyphicons eye_open btn-success'><i></i></a></td>";
								echo "</tr>";
							}
	 					}

					?>
					</tbody>
					</table>
					<?php } ?>
			</div>
		</div>
	</div>
</div>

