
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
					<div class="col-md-6"><h5><b>เลขบัตรประจำตัวประชาชน:</b><span><?php if($profile['identification'] != ""){ echo $profile['identification'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>วันที่บัตรหมดอายุ:</b><span><?php if($profile['date_of_expiry'] != ""){$date_of_expiry = Helpers::lib()->changeFormatDateNew($profile['date_of_expiry']); echo $date_of_expiry;}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>หนังสือเดินทาง:</b><span><?php if($profile['passport'] != ""){ echo $profile['passport'];}else{echo "-";} ?></span> </h5></div>
					<div class="col-md-6"><h5><b>วันที่บัตรหมดอายุ:</b><span><?php if($profile['pass_expire'] != ""){$pass_expire = Helpers::lib()->changeFormatDateNew($profile['pass_expire']); echo $pass_expire;}else{echo "-";}  ?></span></h5></div>
					
					<div class="col-md-6"><h5><b>สัญชาติ:</b><span><?php if($profile['nationality'] != ""){ echo $profile['nationality'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>เพศ:</b><span><?php 
					if($profile['sex'] != ""){
						if ($profile['sex'] == 'Male') {
							echo "ชาย";
						}else{
							echo "หญิง";
						}
					}else{echo "-";}
					?></span></h5></div>
					<div class="col-md-12"><h5><b>ที่อยู่ตามภูมิลำเนา:</b><span><?php if($profile['domicile_address'] != ""){ echo $profile['domicile_address'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>เบอร์โทรศัพท์:</b><span><?php if($profile['phone2'] != ""){ echo $profile['phone2'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>อีเมล:</b><span><?php if($profile['email'] != ""){ echo $user['email'];}else{echo "-";} ?></span></h5></div>
					<div class="col-md-6"><h5><b>ไอดีไลน์:</b><span><?php  if($profile['line_id'] != ""){ echo $profile['line_id'];}else{echo "-";} ?></span></h5></div>
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
				
			</div>
		</div>

	</div>
</form>
</body>
