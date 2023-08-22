
<script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('textarea.tinymce').tinymce({
	// Location of TinyMCE script
		script_url : '<?php echo Yii::app()->baseUrl; ?>/js/tinymce/tiny_mce.js',
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "youtubeIframe,openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,youtubeIframe,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		relative_urls: false,

		//FILE UPLOAD MODS
		file_browser_callback: "openmanager",
		open_manager_upload_path: '../../../../../uploads/',

		// Example content CSS (should be your site CSS)
		content_css : "<?php echo Yii::app()->baseUrl; ?>/css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

	    theme_advanced_resizing : false,
	    theme_advanced_resize_horizontal: false,
	    theme_advanced_resizing_max_width: '500',
	    theme_advanced_resizing_min_height: '300',
	    width: '500',
	    height: '300',	
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
});
</script>
<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
			<?php $form = $this->beginWidget('AActiveForm', array(
				'id'=>'shop-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true
		        ),
		        'errorMessageCssClass' => 'label label-important',
		        'htmlOptions' => array('enctype' => 'multipart/form-data')
			)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
					<div class="row">
						<?php echo $form->labelEx($model,'shoptype_id'); ?>
						<?php echo $this->listShopTypeShow($model,'2','span8');?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'shoptype_id'); ?>
					</div>
					
					<div class="row">
						<?php echo $form->labelEx($model,'shop_number'); ?>
						<?php echo $form->textField($model,'shop_number',array('size'=>20,'maxlength'=>20, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'shop_number'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'shop_name'); ?>
						<?php echo $form->textField($model,'shop_name',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'shop_name'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'shop_short_detail'); ?>
						<?php echo $form->textArea($model,'shop_short_detail',array('rows'=>4, 'cols'=>40,'class'=>'span8','maxlength'=>250)); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'shop_short_detail'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'shop_detail'); ?>
						<?php echo $form->textArea($model,'shop_detail',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
						<?php echo $form->error($model,'shop_detail'); ?>
					</div>

					<br>

					<div class="row">
						<?php echo $form->labelEx($model,'shop_tax'); ?>
						<?php
						echo $form->DropDownList($model,'shop_tax',array('0'=>'ไม่เสียภาษี (n.v.)','1'=>'เสียภาษี') , array(
							'empty'=>'กรุณาเลือกประเภท',
							'class'=>'span8'
						));
						?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'shop_tax'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'price'); ?>
						<?php echo $form->textField($model,'price',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'price'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'shop_unit'); ?>
						<?php echo $form->textField($model,'shop_unit',array('size'=>60,'maxlength'=>20, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'shop_unit'); ?>
					</div>

					<div class="row">
					<?php
					if(isset($imageShow)){
						echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
							"class"=>"thumbnail"
						));
					}
					?>
					</div>
					<br>

					<div class="row">
						<?php echo $form->labelEx($model,'shop_picture'); ?>
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'shop_picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						  	</div>
						</div>
						<?php echo $form->error($model,'shop_picture'); ?>
					</div>

					<div class="row">
						<font color="#990000">
							<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 250x180(แนวนอน) หรือ ขนาด 250x(xxx) (แนวยาว)
						</font>
					</div>
					<br><br>

					<div class="row buttons">
						<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
					</div>
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->