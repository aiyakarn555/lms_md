<?php
$width = 300;
$height = 300;
$re_width = $width/1;
$re_height = $height/1;
?>
<style type="text/css">
#upload-demo{
    width: 350px;
    height: 350px;
    padding-bottom:25px;
}
</style>


<script src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">

</script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<style type="text/css">
    body {
        font: 13px Arial, Helvetica, Sans-serif;
    }
    .uploadifive-button {
        float: left;
        margin-right: 10px;
    }
    #queue {
        border: 1px solid #E5E5E5;
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 600px;
    }
</style>

<!-- innerLR -->
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php
                $form = $this->beginWidget('AActiveForm', array(
                    'id' => 'Language-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>

                <!-- <div class="row">
                <?php
                if(isset($model->imageShow)){
                    echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->imageShow), $model->imageShow,array(
                        "class"=>"thumbnail"
                    ));
                }
                ?>
                </div>
                <br>

                <div class="row">
                    <?php echo $form->labelEx($model,'image'); ?>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-append">
                            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'image'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                    <?php echo $form->error($model,'image'); ?>
                </div>

                <div class="row">
                    <font color="#990000">
                        <?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 30 x 30 px
                    </font>
                </div> -->

                <div class="row ">
                    <div class="col-xs-12" style="padding-left: 15px; margin-bottom: 5px;">

                        <label class="cabinet center-block">
                            <p>upload image </p>
                            <figure>
                                <?php 
                                $url_pic = "";
                                if (isset($imageShow)) {
                                    $url_pic = Yii::app()->theme->baseUrl . '/../../../uploads/language/' . $model->id . '/' . $imageShow;
                                }
                                ?>
                                <img src="<?=$url_pic?>" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                                <figcaption><i class="fa fa-camera"></i></figcaption>
                            </figure>
                            <input type="hidden" name="url_pro_pic" id="url_pro_pic">
                            <input type="file" id="picture_input" class="item-img file center-block" name="picture" />
                        </label>
                    </div>
                </div>

                <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">
                                </div>
                                <div class="modal-body">
                                    <div id="upload-demo" class="center-block"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col-xs-12">
                            <font color="#990000">
                                <?php echo $this->NotEmpty();?> size <?=$width?> x <?=$height?> px
                            </font>
                        </div>
                    </div>
                    <br>

                <div class="row">
                    <?php echo $form->labelEx($model, 'language'); ?>
                    <?php echo $form->textField($model, 'language', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'language'); ?>
                </div>
                
               
                <div class="row">
                    <?php echo $form->labelEx($model,'status'); ?>
                    <!-- <div class="toggle-button" data-toggleButton-style-enabled="success"> -->
                        <?php echo $form->checkBox($model,'status',array(
                            'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
                        )); ?>
                    <!-- </div> -->
                    <?php echo $form->error($model,'status'); ?>
                </div>

                
                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2', 'onclick' => "return upload();"), '<i></i>save'); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>
<!-- END innerLR -->

<script>
    $(function () {
        init_tinymce();
    });

    $('#picture_input').on('change',function(){
        readFile(this);
    });

    <?php if(!isset($imageShow) || !file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/language/' . $model->id . '/' . $imageShow)){ ?>
        $(".gambar").attr("src", "<?php echo Yii::app()->theme->baseUrl; ?>/images/personnel_boy.png");
    <?php } ?>
    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: <?=$re_width?>,
            height: <?=$re_height?>,
        },
        enforceBoundary: true,
        enableExif: true
    });
    $('#cropImagePop').on('shown.bs.modal', function(){
                            // alert('Shown pop');
                            $uploadCrop.croppie('bind', {
                                url: rawImg
                            }).then(function(){
                                console.log('jQuery bind complete');
                            });
                        });

    $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId); readFile(this); });
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {width: <?=$width?>, height: <?=$height?>}
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            $('#cropImagePop').modal('hide');
            $('#url_pro_pic').val($('#item-img-output').attr('src'));

        });
    });
</script>
