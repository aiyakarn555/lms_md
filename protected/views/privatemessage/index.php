<script src='https://www.google.com/recaptcha/api.js'></script>

<?php 
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
	$langId = Yii::app()->session['lang'] = 1;
	$ck_mail = "Please Check your Junk Mail";
}else{
	$langId = Yii::app()->session['lang'];
	$ck_mail = "กรุณาตวรจสอบใน จดหมายขยะ";
}

$mail = Yii::app()->user->getFlash('mail');
if(!empty($mail)){
	$icon = !empty($icon) ? $icon : 'warning';
	?>
	<script type="text/javascript">
		swal({
			title: "System",
			text: "<?= $mail; ?>"+"<?= $ck_mail ?>",
			type: "success",
		});

	</script>
	<?php
	Yii::app()->user->setFlash('mail',null);
}?>

<div class="header-page parallax-window">
	<div class="container">
		<h1><?= $label->label_privatemessage  ?>
		<small class="pull-right">
			<ul class="list-inline list-unstyled">
				<li><a href="<?php echo $this->createUrl('site/index'); ?>"><?= $label->label_homepage  ?></a></li> /
				<li><span class="text-bc"><?= $label->label_privatemessage  ?></span></li>
			</ul>
		</small>
	</h1>
</div>

</div>
<!-- Content -->
<?php
$form = $this->beginWidget('CActiveForm', array(
//                            'name' => 'form1',
	'id' => 'Privatemessage',
	'action'=>Yii::app()->createUrl('/Privatemessage/save'),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
<section class="content" id="message">
	<div class="container">
		<div class="row">
			<!-- กล่องหัวข้อ -->
			<div class="col-sm-4 col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?= $label->label_privatemessage  ?> <span class="pull-right"><a data-toggle="modal" href='#modal-new-message'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span></h3>
					</div>
					<div class="panel-body list">
						<?php foreach ($Privatemessage as $key => $value) {  ?>
							<ul class="list-unstyled">
								<li>
									<span class="pull-right"><?= $value->create_date ?></span>	
									<a href="<?= Yii::app()->createUrl('Privatemessage/index?id='.$value->pm_id.'/')?>"><span class="img-send" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/user.png);"></span><?= $value->pm_topic ?></a>
								</li>
							</ul>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- end กล่องหัวข้อ -->
			<?php 

			?>
			<div class="col-sm-8 col-md-9">
				<div class="panel panel-default">
					<div class="panel-heading" style="height: 40px;">
						<div class="text-left">
							<!-- show user -->
							<?php if (Yii::app()->user->getId()==null) { ?>
								<strong>Firstname - Lastname</strong>
							<?php }else { ?>
								<?= $Privatemessage->pm_to; ?>
								<strong><?= $CurrentMessage->toUser->profile->firstname; ?>  <?= $CurrentMessage->toUser->profile->lastname; ?></strong>
								<!-- <strong><?php echo $nameuser->firstname ;echo "&nbsp;"; echo $nameuser->lastname  ?></strong> -->
							<?php	}  ?>

							<span class="img-user pull-left" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/user.png);"></span>
							<!-- show user -->
						</div>


					</div>

					<div class="panel-body">	
						<?php if ($CurrentMessage) {
							?>
							<div class="message-right">
								<div class="right-detail">
									<?=$CurrentMessage->pm_quest ?><br>
									<span><?=$CurrentMessage->create_date?></span>
								</div>

							</div>
							<?php if(!empty($CurrentMessage->all_file)){ 
								$typefile = explode(".",  $CurrentMessage->all_file);
								$typeimage = array('jpg','png','jpeg');
								$typenoimg = array('pdf','zip','rar');
								$link = '';

								?>
								<div class="message-right">
									<div class="right-detail">
										<?php if(in_array($typefile[sizeof($typefile)-1], $typeimage)){ ?>
											<img src="<?=Yii::app()->baseUrl.'/uploads/contactus/'.$CurrentMessage->all_file; ?>" style="width: 40%" >
										<?php }elseif (in_array($typefile[sizeof($typefile)-1], $typenoimg)) { ?>
											<a href="<?php echo $this->createUrl('/Privatemessage/download', array('id' => $CurrentMessage->pm_id)); ?>" >
												ดาวน์โหลดไฟล์แนบ
											</a>
										<?php } ?>
									</div>

								</div>
							<?php } ?>

						<?php } ?>
						<?php  foreach ($CurrentMessage->msgReturn as $pmr ){
							if ($pmr->create_by == Yii::app()->user->id) { ?>
								<!-- User ขวา-->
								<div class="message-right">
									<div class="right-detail">
										<?=$pmr->pmr_return ?>
										<span><?=$pmr->create_date?></span>
									</div>
								</div>
								<!-- end user -->
							<?php } else { ?>
								<!-- ADMIN ซ้าย-->
								<div class="message-left">
									<div class="left-detail">
										<?=	$pmr->pmr_return ?>
										<span><?=$pmr->create_date?></span>
									</div>
								</div>
								<!-- end admin -->
							<?php  	} 	
						} ?>
					</div>
					<div class="panel-footer">
						<div class="text-right">
							<strong><?= $profile->firstname; ?>  <?= $profile->lastname; ?></strong>
							<span class="img-user pull-right" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/teacher_6.jpg);"></span>
						</div>
						<div class="clearfix"></div> 

						<div class="form-group">
							<label for="textarea" class="control-label"><?= $label->label_reply  ?></label>
							<textarea name="pm_quest" id="textarea" class="form-control" rows="3"></textarea>
						</div>
						<!--+++++++++ ส่งข้อความ ++++++++++++++++-->

						<div class="text-right">
							<input type="hidden" name="Privatemessage[user_id]" value="<?=Yii::app()->user->id;?>">
							<input type="hidden"  name="pm_id" value="<?= $id ?>">

							<!-- ////////////////////////// -->

							<!-- +++++++++++++++++  captchar ========-->	
							<script>
								function makeaction(){
									document.getElementById('btn_submit').disabled = false;  
								}
							</script>		
							<!-- <div class="g-recaptcha" data-sitekey="6LcSH0EUAAAAANZfkzbBwR-Z_oJLJ6E4QVGbyei1" data-callback="makeaction"></div> -->
							<div class="g-recaptcha" data-sitekey="6LdMXXcUAAAAAN1JhNtbE94ISS3JPEdP8zEuoJPD" data-callback="makeaction"></div>
							<!-- +++++++++++++++++ end  captchar ========-->	
							<?php echo CHtml::submitButton($label->label_sendMess, array(
								'class' => 'btn-warning', 
								'id'=>'btn_submit' ,
								'disabled'=>'disabled',
							));	?>
						</div>
						<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>	
<?php 

?>
<!-- Modal new message -->
<div class="modal fade" id="modal-new-message">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?= $label->label_createMsg ?></h4>
			</div>
			<div class="modal-body">	
				<div class="form-group">
					<label for=""><?= $label->label_receiver ?></label>
					<select name="pm_to" id="" class="form-control" required>
						<!-- <option value="">123</option> -->

						<?php 
						foreach ($superuser as $superuser_index) {
											// foreach ($profile as $key => $value) { 
							if ($superuser_index->id != $profile->user_id) {	?>
								<option value="<?= $superuser_index->id?>">
									<?= $superuser_index->profile->firstname ."&nbsp;". $superuser_index->profile->lastname ?></option>
									<?php			
								}
													// }
							}	
							?>
						</select>
					</div>
					<div class="form-group">
						<label for=""><?= $label->label_topic ?></label>
						<input type="text" name="pm_topic" id="" class="form-control"  novalidate>
					</div>
					<div class="form-group">
						<label for=""><?= $label->label_detail ?></label>
						<textarea name="detail" id="" class="form-control" rows="6"></textarea>
					</div>
					<div class="form-group">
						<label for=""><?= $label->label_notification ?></label>
						<div class="">
							<label>
								<input type="checkbox" value="1" name="mail">
								<?= $label->label_notfiToEmail ?>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label for=""><?= $label->label_uploadFile ?></label>
						<input type="file" class="form-control-file" name="upfile" id="upfile" multiple >

					</div>
				</div>
				<div class="modal-footer">
					<!-- 	<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button> -->
					<button type="submit" class="btn-warning"><?= $label->label_sendMess ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php $this->endWidget();?>


	<script type="text/javascript">
		$( document ).ready(function() {
			$("#upfile").change(function () {
				var fileExtension = ['jpeg', 'jpg', 'png', 'pdf'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					$("#upfile").val(null);
					alert("Only formats are allowed : "+fileExtension.join(', '));
				}
			});
		});
	</script>