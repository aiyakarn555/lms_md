
<style type="text/css">
	.topic-info{
		color: #000;
	}
	.profile-detail h5{
		margin: 5px 0;
	}
	.profile-detail h5 b{
		color: #333;
		padding-right: 8px;
		min-width: 120px;
		display: inline-block;
		text-align: left;
	}
	.profile-detail h5 span{
		color: #296283;
		padding: 8px 8px;
		background: #f0f0f0;
		border-radius: 5px;
		margin: 5px 0;
		font-weight: 600;
		border: 1px solid #ddd;
		width: 100%;
		display: inline-block;
	}

	.profile-detail h5 ul{
		list-style: square;
	}
	.profile-detail h5 ul li{
		margin: 8px 0 0 0;
	}
	.profile-detail h5 ul li span{
		width: auto !important;
		margin: 0 5px;
	}
	.profile-detail h5 ul li a span{
		color: #296283 !important;
	}
	.m-1{
		margin: 1em 0;
	}
	.mt-1{
		margin-top: 1em;
	}
	.mt-2{
		margin-top: 2em;
	}

	.d-inlineblock{
		display: inline-block;
		width: auto !important;
	}
	.register-detail{
		padding: 0 2em 2em;
	}

	.baht {
        position: absolute;
        left:  16px;
        top: 40px;
        z-index: 2;
        display: block;
        pointer-events: none;
    }
	</style>

	<form>
		<div class="well profile-detail">
			<div class="text-center m-1">
				<?php 
				if ($user['pic_user'] == null) {
					
					$img  = Yii::app()->theme->baseUrl . "/../../../themes/template2/images/thumbnail-profile.png";
					
					
				} else {

					$img = Yii::app()->baseUrl . '/../uploads/user/' . $user['id'] . '/thumb/' . $user['pic_user'];
				}

				?>		                

				<img border="9" src="<?php echo $img; ?>" width="150" height="180">
			</div>
			<h4 class="topic-info">ข้อมูลพื้นฐาน</h4>
			<div class="mt-1 register-detail">
				<div class="row">
					<div class="col-md-12"><h5><b>ชื่อ-นามสกุล:</b><span><?php if ($profile['sex'] == 'Male') {
						echo "นาย";
					}else{
						echo "นางสาว";
					} ?>&nbsp;&nbsp;<?php echo $profile['firstname'] ?>&nbsp;&nbsp;<?php echo $profile['lastname'] ?></span></h5></div>
					<div class="col-md-12"><h5><b>Name:</b><span><?php if ($profile['sex'] == 'Male') {
						echo "Mr.";
					}else{
						echo "Miss";
					}?>&nbsp;&nbsp;<?php echo $profile['firstname_en'] ?>&nbsp;&nbsp;<?php echo $profile['lastname_en'] ?></span></h5></div>
					<div class="col-md-6"><h5><b>วันเดือนปีเกิด:</b><span><?php if($profile['birthday'] != ""){$birthday = Helpers::lib()->changeFormatDateNew($profile['birthday']); echo $birthday;}else{echo "-";}  ?></span> </h5></div>
					<div class="col-md-3"><h5><b>อายุ:</b><span><?php if($profile['age'] != ""){ echo $profile['age'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-3"><h5><b>เดือน:</b><span><?php if($profile['mouth_birth'] != ""){ echo $profile['mouth_birth'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>สถานที่เกิด:</b><span><?php if($profile['place_of_birth'] != ""){ echo $profile['place_of_birth'];}else{echo "-";}  ?></span> </h5></div>
					<div class="col-md-6"><h5><b>กรุ๊ปเลือด:</b><span><?php if($profile['blood'] != ""){ echo $profile['blood'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>ส่วนสูง:</b><span><?php if($profile['hight'] != ""){ echo $profile['hight'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>น้ำหนัก:</b><span><?php if($profile['weight'] != ""){ echo $profile['weight'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>เลขบัตรประจำตัวประชาชน:</b><span><?php if($profile['identification'] != ""){ echo $profile['identification'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>วันที่บัตรหมดอายุ:</b><span><?php if($profile['date_of_expiry'] != ""){$date_of_expiry = Helpers::lib()->changeFormatDateNew($profile['date_of_expiry']); echo $date_of_expiry;}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>สถานที่ออกบัตร:</b><span><?php if($profile['place_issued'] != ""){ echo $profile['place_issued'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>วันที่ออกบัตร:</b><span><?php if($profile['date_issued'] != ""){$date_issued = Helpers::lib()->changeFormatDateNew($profile['date_issued']); echo $date_issued;}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>หนังสือเดินทาง:</b><span><?php if($profile['passport'] != ""){ echo $profile['passport'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>วันที่บัตรหมดอายุ:</b><span><?php if($profile['pass_expire'] != ""){$pass_expire = Helpers::lib()->changeFormatDateNew($profile['pass_expire']); echo $pass_expire;}else{echo "-";}  ?></span></h5></div>
					<div class="col-md-6"><h5><b>สถานที่ออกบัตร:</b><span><?php if($profile['passport_place_issued'] != ""){ echo $profile['passport_place_issued'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>วันที่ออกบัตร:</b><span><?php if($profile['passport_date_issued'] != ""){$passport_date_issued = Helpers::lib()->changeFormatDateNew($profile['passport_date_issued']); echo $passport_date_issued;}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>หนังสือประจำตัวลูกเรือ:</b><span><?php if($profile['seamanbook'] != ""){ echo $profile['seamanbook'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>วันที่บัตรหมดอายุ:</b><span><?php if($profile['seaman_expire'] != ""){$seaman_expire = Helpers::lib()->changeFormatDateNew($profile['seaman_expire']); echo $seaman_expire;}else{echo "-";}  ?></span></h5></div>
					<!-- <div class="col-md-6"><h5><b>บัตรประกันสังคมเลขที่:</b><span><?php if($profile['ss_card'] != ""){ echo $profile['ss_card'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>เลขที่บัตรประจำตัวผู้เสียภาษีอากร:</b><span><?php if($profile['tax_payer'] != ""){ echo $profile['tax_payer'];}else{echo "-";}  ?></span></h5></div> -->
					<div class="col-md-6"><h5><b>เชื้อชาติ:</b><span><?php if($profile['race'] != ""){ echo $profile['race'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>สัญชาติ:</b><span><?php if($profile['nationality'] != ""){ echo $profile['nationality'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>ศาสนา:</b><span><?php if($profile['religion'] != ""){ echo $profile['religion'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>เพศ:</b><span><?php 
					if($profile['sex'] != ""){
						if ($profile['sex'] == 'Male') {
							echo "ชาย";
						}else{
							echo "หญิง";
						}
					}else{echo "-";}
					?></span></h5></div>
					<div class="col-md-6"><h5><b>สถานะภาพทางการสมรส:</b><span><?php 
					if($profile['status_sm'] != ""){
						if ($profile['status_sm'] == 's') {
							echo "โสด";
						}else{
							echo "สมรส";
						}
					}else{echo "-";}
					?></span></h5></div>
					<div class="col-md-6"><h5><b>จำนวนบุตร:</b><span><?php if($profile['number_of_children'] != ""){ echo $profile['number_of_children'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-7"><h5><b>ชื่อ-นามสกุลคู่สมรส:</b><span><?php if ($profile['spouse_firstname'] != '') {
					echo $profile['spouse_firstname']; ?>&nbsp;&nbsp;<?php echo $profile['spouse_lastname'];
					}else{echo "-";}  ?></span></h5></div>
					<div class="col-md-5"><h5><b>อาชีพ:</b><span><?php if($profile['occupation_spouse'] != ""){ echo $profile['occupation_spouse'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-7"><h5><b>ชื่อ-นามสกุลบิดา:</b><span><?php if ($profile['father_firstname'] != '') {
					echo $profile['father_firstname']; ?>&nbsp;&nbsp;<?php echo $profile['father_lastname'];
					}else{echo "-";}  ?></span></h5></div>
					<div class="col-md-5"><h5><b>อาชีพ:</b><span><?php if($profile['occupation_father'] != ""){ echo $profile['occupation_father'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-7"><h5><b>ชื่อ-นามสกุลมารดา:</b><span><?php if ($profile['mother_firstname'] != '') {
					echo $profile['mother_firstname']; ?>&nbsp;&nbsp;<?php echo $profile['mother_lastname'];
					}else{echo "-";}  ?></span></h5></div>
					<div class="col-md-5"><h5><b>อาชีพ:</b><span><?php if($profile['occupation_father'] != ""){ echo $profile['occupation_father'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>บ้าน:</b><span><?php if($profile['accommodation'] != ""){
					if ($profile['accommodation'] == 'own house') {
					     echo "ของตนเอง";
					}else if($profile['accommodation'] == 'rent house'){
						 echo "บ้านเช่า";
					}else if($profile['accommodation'] == 'with parents'){
						 echo "อาศัยอยู่กับบิดามารดา";
					}else if($profile['accommodation'] == 'apartment'){
						 echo "อพาร์ทเม้นท์";
					}else if($profile['accommodation'] == 'with relative'){
						 echo "อยู่กับญาติ/เพื่อน";
					}
					}else{echo "-";} ?></span></h5></div>
					<div class="col-md-12"><h5><b>ที่อยู่:</b><span><?php if($profile['address'] != ""){ echo $profile['address'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-12"><h5><b>ที่อยู่ตามภูมิลำเนา:</b><span><?php if($profile['domicile_address'] != ""){ echo $profile['domicile_address'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>เบอร์โทรศัพท์:</b><span><?php if($profile['tel'] != ""){ echo $profile['tel'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>เบอร์โทรศัพท์ผู้ที่ติดต่อฉุกเฉิน:</b><span><?php if($profile['phone'] != ""){ echo $profile['phone'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>ชือผู้ที่ติดต่อฉุกเฉิน:</b><span><?php if($profile['name_emergency'] != ""){ echo $profile['name_emergency'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>ความสัมพันธ์:</b><span><?php if($profile['relationship_emergency'] != ""){ echo $profile['relationship_emergency'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>อีเมล:</b><span><?php if($profile['email'] != ""){ echo $user['email'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>ไอดีไลน์:</b><span><?php  if($profile['line_id'] != ""){ echo $profile['line_id'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>ประวัติการเจ็บป่วยรุนแรง:</b><span><?php 
					if($profile['history_of_illness'] != ""){
						if ($profile['history_of_illness'] == 'y') {
							echo "เคย";
						}else{
							echo "ไม่เคย";
						}
						;}else{echo "-";} 
						?></span></h5></div>
					<div class="col-md-6"><h5><b>โรคที่เคยป่วย:</b><span><?php  if($profile['sickness'] != ""){ echo $profile['sickness'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>สถานะการรับใช้ชาติ:</b><span><?php  if($profile['military'] != ""){ 
						if ($profile['military'] == 'enlisted') {
							echo 'เกณฑ์แล้ว';
						}else if ($profile['military'] == 'not enlisted') {
							echo 'ยังไม่ได้เกณฑ์';
						}else if ($profile['military'] == 'exempt') {
							echo 'ได้รับการยกเว้น';
						}
						}else{echo "-";} ?></span></h5></div>
						<div class="col-md-12">
							<h5><b>ประวัติการศึกษา:</b>
								<ul><?php
								$user_id = $user['id'];
								$ProfilesEdu = ProfilesEdu::model()->findAll(array(
									'condition' => 'user_id=:user_id AND active=:active',
									'params' => array(':user_id'=>$user_id, ':active'=>'y')));

								if(!empty($ProfilesEdu)){ 
									foreach ($ProfilesEdu as $key => $value) {					

										$education_data = $ProfilesEdu[$key]->attributes;
										$edu_id = $education_data['edu_id'];
										$institution = $education_data['institution'];
										$date_graduation = $education_data['date_graduation'];

										$Education = Education::model()->findAll(array(
											'condition' => 'edu_id=:edu_id AND active=:active',
											'params' => array(':edu_id'=>$edu_id, ':active'=>'y')));
										foreach ($Education as $keyedu => $valueedu) {
											$Education_detail = $Education[$keyedu]->attributes;
											
											?>
											<li>
												<span><?php 
												if($edu_id != ""){
													echo $Education_detail['edu_name'];
												}else{ echo "-"; }
												?></span>
												<span><?php if($institution != ""){ echo $institution;}else{ echo "-"; } ?></span>
												<span><?php if($date_graduation != ""){echo $date_graduation;}else{ echo "-"; } ?></span>
											</li>
											<?php
										}
									}
								}
								?>
							</ul>
						</h5>
					</div>
					<div class="col-md-12">
						<h5><b>เอกสารแนบไฟล์วุฒิการศึกษา/วิชาชีพ:</b>
							<ul>
								<?php
								$user_id = $user['id'];
								$idx = 1;
								$uploadFolder = Yii::app()->getUploadUrl('edufile');
								$criteria = new CDbCriteria;
								$criteria->addCondition('user_id ="'.$user_id.'"');
								$criteria->addCondition("active ='y'");
								$FileEdu = FileEdu::model()->findAll($criteria);

								if(isset($FileEdu)){
									foreach($FileEdu as $fileDatas){?>
										<li>
											<a href="<?php echo Yii::app()->baseUrl . '/../uploads/edufile/' . $fileDatas->filename; ?>"><span><?php echo $fileDatas->file_name;?></span></a>
										</li>
										<?php
									}
								}
								?>
							</ul>
						</ul>
					</h5>
				</div>
			<!-- 	<div class="col-md-12">
							<h5><b>ประวัติการฝึกอบรม:</b>
								<ul><?php
								$user_id = $user['id'];
								$ProfilesTraining = ProfilesTraining::model()->findAll(array(
									'condition' => 'user_id=:user_id AND active=:active',
									'params' => array(':user_id'=>$user_id, ':active'=>'y')));

								if(!empty($ProfilesTraining)){ 
									foreach ($ProfilesTraining as $key => $value) {					

										$training_data = $ProfilesTraining[$key]->attributes;
										$message = $training_data['message'];
											
											?>
											<li>	
												<span><?php if($message != ""){ echo $message;}else{ echo "-"; } ?></span>
											</li>
											<?php
									}
								}
								?>
							</ul>
						</h5>
					</div> -->
					<!-- <div class="col-md-12">
							<h5><b>ประวัติการฝึกอบรม:</b>
						     <table border="1">
									<thead>
										<tr style="background-color:#66CCFF	;">
											<td width="1%">ลำดับ</td>
											<td width="17%">การฝึกอบรม</td>
											
										</tr>
									</thead>
									<tbody><?php 
								$user_id = $user['id'];
                             $criteria= new CDbCriteria;
                             $criteria->addCondition('user_id ="'.$user_id.'"');
                             $ProfilesTraining = ProfilesTraining::model()->findAll($criteria);

								if(!empty($ProfilesTraining)){ 
									$i = 1;
									foreach ($ProfilesTraining as $key => $value) {																
											?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $value['message']; ?></td>
		
										</tr>
										<?php
									}
                                    }else{
                                    	?>
                                    	<tr>
											<td><?php echo "-"; ?></td>
											<td><?php echo "-"; ?></td>
				
										</tr>
										
                                   <?php 
                                       }
                                   ?>
									</tbody>
								</table>
						</h5>
					</div> -->
					<div class="col-md-12">
							<h5><b>ประวัติการฝึกอบรม:</b>
						     <table border="1">
									<thead>
										<tr style="background-color:#66CCFF	;">
											<td width="1%">ลำดับ</td>
											<td width="17%">การฝึกอบรม</td>
											<td width="17%">วันหมดอายุ</td>
										</tr>
									</thead>
									<tbody><?php 
								$user_id = $user['id'];
                             $criteria= new CDbCriteria;
                             $criteria->addCondition('user_id ="'.$user_id.'"');
                             $FileTraining = FileTraining::model()->findAll($criteria);
          
								if(!empty($FileTraining)){ 
									$i = 1;
									foreach ($FileTraining as $key => $value) {																
											?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $value['file_name']; ?></td>
		                                    <td><?php $expire_date = Helpers::lib()->changeFormatDateNew($value['expire_date']);
		                                     echo $expire_date; ?></td>
										</tr>
										<?php
									}
                                    }else{
                                    	?>
                                    	<tr>
											<td><?php echo "-"; ?></td>
											<td><?php echo "-"; ?></td>
											<td><?php echo "-"; ?></td>
										</tr>
										
                                   <?php 
                                       }
                                   ?>
									</tbody>
								</table>
						</h5>
					</div>
				<div class="col-md-12">
					<h5><b>เอกสารแนบไฟล์ฝึกอบรม:</b>
						<ul>
							<?php
							$user_id = $user['id'];
							$idx = 1;
							$uploadFolder = Yii::app()->getUploadUrl('Trainingfile');
							$criteria = new CDbCriteria;
							$criteria->addCondition('user_id ="'.$user_id.'"');
							$criteria->addCondition("active ='y'");
							$FileTraining = FileTraining::model()->findAll($criteria);

							if(isset($FileTraining)){

								foreach($FileTraining as $fileDatas){?>
									<li>
										<a href="<?php echo Yii::app()->baseUrl . '/../uploads/Trainingfile/'.$user_id.'/' . $fileDatas->filename; ?>"><span><?php echo $fileDatas->file_name;?></span></a>
									</li>
									<?php
								}
							}
							?>
							
						</ul>
					</h5>
				</div>
				<!-- <div class="col-md-12">
							<h5><b>ประวัติการทำงาน:</b>
								<ul><?php
								$user_id = $user['id'];
								$ProfilesWorkHistory = ProfilesWorkHistory::model()->findAll(array(
									'condition' => 'user_id=:user_id AND active=:active',
									'params' => array(':user_id'=>$user_id, ':active'=>'y')));

								if(!empty($ProfilesWorkHistory)){ 
									foreach ($ProfilesWorkHistory as $key => $value) {					

										$WorkHistory_data = $ProfilesWorkHistory[$key]->attributes;
										$company_name = $WorkHistory_data['company_name'];
										$since_date = $WorkHistory_data['since_date'];
										$position_name = $WorkHistory_data['position_name'];
										$reason_leaving = $WorkHistory_data['reason_leaving']
											
											?>
											<li>
												<span><?php if($company_name != ""){ echo $company_name;}else{ echo "-"; } ?></span>
												<span><?php if($position_name != ""){ echo $position_name;}else{ echo "-"; } ?></span>
												<span><?php if($since_date != ""){ echo $since_date;}else{ echo "-"; } ?></span>
												<span><?php if($reason_leaving != ""){echo $reason_leaving;}else{ echo "-"; } ?></span>
											</li>
											<?php
									
									}
								}
								?>
							</ul>
						</h5>
					</div> -->
					<div class="col-md-12">
							<h5><b>ประวัติการทำงาน:</b>
								<table border="1">
									<thead>
										<tr style="background-color:#66CCFF	;">
											<td width="17%">บริษัท</td>
											<td width="17%">ตำแหน่ง</td>
											<td width="17%">ออกเมื่อ</td>
											<td width="17%">สาเหตุที่ออก</td>
										</tr>
									</thead>
									<tbody><?php 
								$user_id = $user['id'];
                             $criteria= new CDbCriteria;
                             $criteria->addCondition('user_id ="'.$user_id.'"');
                             $ProfilesWorkHistory = ProfilesWorkHistory::model()->findAll($criteria);

								if(!empty($ProfilesWorkHistory)){ 
									foreach ($ProfilesWorkHistory as $key => $value) {																
											?>
										<tr>
											<td><?php echo $value['company_name']; ?></td>
											<td><?php echo $value['position_name']; ?></td>
											<td><?php $since_date = Helpers::lib()->changeFormatDateNew($value['since_date']); 
											echo $since_date; ?></td>
											<td><?php echo $value['reason_leaving']; ?></td>
										</tr>
										<?php
									}
                                    }else{
                                    	?>
                                    	<tr>
											<td><?php echo "-"; ?></td>
											<td><?php echo "-"; ?></td>
											<td><?php echo "-"; ?></td>
											<td><?php echo "-"; ?></td>
										</tr>
										
                                   <?php 
                                       }
                                   ?>
									</tbody>
								</table>
						</h5>
					</div>
				<div class="col-md-12">
					<h5><b>เอกสารแนบไฟล์:</b>
						<ul>
							<?php
							$user_id = $user['id'];
							$idx = 1;
							$uploadFolder = Yii::app()->getUploadUrl('attach');
							$criteria = new CDbCriteria;
							$criteria->addCondition('user_id ="'.$user_id.'"');
							$criteria->addCondition("active ='y'");
							$AttachFile = AttachFile::model()->findAll($criteria);

							if(isset($AttachFile)){
								foreach($AttachFile as $fileDatas){?>
									<li>
										<?php if($fileDatas->file_data == 1){
											echo 'หนังสือเดินทาง';
										}else if($fileDatas->file_data == 2){
                                            echo 'หนังสือประจำตัวลูกเรือ';
										}else if($fileDatas->file_data == 3){
                                            echo 'บัตรประชาชน';
										}else if($fileDatas->file_data == 4){
                                            echo 'ทะเบียนบ้าน';
										}  ?><a href="<?php echo Yii::app()->baseUrl . '/../uploads/attach/' . $fileDatas->filename; ?>"><span><?php echo $fileDatas->filename;?></span></a>
									</li>
									<?php
								}
							}
							?>
							
						</ul>
					</h5>
				</div>
				<div class="col-md-12">
					<h5><b>ความสามารถด้านภาษา</b>
						<table border="1">
							<thead>
								<tr style="background-color:#66CCFF	;">
									<td width="17%">ภาษา</td>
									<td width="17%">เขียน</td>
									<td width="17%">พูด</td>
								</tr>
							</thead>
							<tbody>
								<?php
							 $user_id = $user['id'];
                             $criteria= new CDbCriteria;
                             $criteria->addCondition('user_id ="'.$user_id.'"');
                             $ProfilesLanguage = ProfilesLanguage::model()->findAll($criteria);
                             if(!empty($ProfilesLanguage)){ 
                             foreach ($ProfilesLanguage as $key => $value) {
								?>
								<tr >
									<td style="background-color:#F5F5F5;"><?php echo $value['language_name']; ?></td>
									<td><?php 
                                      if ($value['writes'] == 4) {
                                        echo "ดีมาก";
                                      }else if($value['writes'] == 3){
                                      	echo "ดี";
                                      }else if($value['writes'] == 2){
                                      	echo "พอใช้ได้";
                                      }else if($value['writes'] == 1){
                                      	echo "ใช้ไม่ได้";
                                      }
									 ?></td>
									<td><?php 
                                            if ($value['spoken'] == 4) {
                                        echo "ดีมาก";
                                      }else if($value['spoken'] == 3){
                                      	echo "ดี";
                                      }else if($value['spoken'] == 2){
                                      	echo "พอใช้ได้";
                                      }else if($value['spoken'] == 1){
                                      	echo "ใช้ไม่ได้";
                                      }
									 ?></td>
								</tr>
								<?php
							       }

							       }else{
							       	?>
                                <tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
                               <?php  }
								?>
							</tbody>
						</table>
				    </h5>
				</div>
				<?php  
				$position = Position::model()->find(array(
					'condition' => 'id=:position_id',
					'params' => array(':position_id'=>$user['position_id'])
				));
				$position = $position->attributes;

				?>
				
				<div class="col-md-6"><h5><b>ตำแหน่งเรือที่ท่านสนใจสมัคร:</b><span><?php echo $position['position_title']; ?></span></h5></div>

				<div class="col-md-12">
					<h5><b>เปลี่ยนตำแหน่งเรือ:</b>
						<?php
                         if($user['register_status'] == 0){
						?>
						<select class="form-control d-inlineblock position_id" name="position_id" id="<?php echo $user['id'];?>">
							<option value="">เลือกตำแหน่ง</option>
							<?php
							 $departmentModel = Department::model()->findAll(array(
                    'condition' => 'type_employee_id=:type_employee_id AND active=:active',
                    'params' => array(':type_employee_id'=>1, ':active'=>'y')));
							
						  $dep_id = [];
                  foreach ($departmentModel as $keydepart => $valuedepart) {
                   $dep_id[] = $valuedepart->id;

                   }
							 $criteria= new CDbCriteria;
                             $criteria->compare('active','y');
                             $criteria->addInCondition('department_id', $dep_id);
                             $criteria->order = 'position_title ASC';
                             $positions = Position::model()->findAll($criteria);
							
								foreach ($positions as $ke => $val) {
									$pos = $positions[$ke]->attributes;
									?>
									<option value="<?php echo $pos['id']; ?>"><?php echo $pos['position_title']; ?></option>
								<?php   
							}						
							?>
						</select>
						<?php
                         }else{?>
                         	<select class="form-control d-inlineblock" disabled>
                         		<option value="">เลือกตำแหน่ง</option>
                         		</select>
                        <?php }
						?>
					</h5>
				</div>
				<div class="col-md-4"><h5><b>เงินเดือนที่คาดหวัง:</b><span><?php if($profile['expected_salary'] != ""){ echo $profile['expected_salary'];}else{echo "-";} ?></span></h5></div>
				<div class="col-md-1"><h5><b class="baht">บาท</b></h5></div>
				<div class="col-md-7"><h5><b>พร้อมที่จะเริ่มงานเมื่อ:</b><span><?php if($profile['start_working'] != ""){$start_working = Helpers::lib()->changeFormatDateNew($profile['start_working']); echo $start_working;}else{echo "-";} ?></span></h5></div>
			</div>
			<div class="text-center mt-2">
				<button class="btn btn-success btn-icon save_data"><i></i>บันทึกข้อมูล</button>                        
			</div>
		</div>

	</div>
</form>
</body>
