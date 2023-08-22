<?php
$titleName = 'Create Controller';
// $this->headerText = $titleName;
$formNameModel = 'PController';
?>
<div class="innerLR">

    <div class="col-md-12">
        <a href="<?= Yii::app()->createUrl('pcontroller/'); ?>" type="button" class="btn btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i>
            จัดการ Controller
        </a>
    </div>
    <div class="clearfix"></div>
    <br>
    <div class="col-md-12">

    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'pcontroller-grid',
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true
        ),
        'htmlOptions' => array('class' => 'well'), // for inset effect
    )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model_c); ?>

    <?php echo $form->textFieldGroup($model_c, 'title', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

    <?php echo $form->textFieldGroup($model_c, 'controller', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

    <div class="form-group">
        <label class="col-sm-3 control-label">Action</label>
        <div class="col-sm-9">
            <div class="controls">
                <div class="action">


                    <?php
                        if(!$model_c->isNewRecord){

                            $count_a = count($model_a);

                            foreach ($model_a as $key=>$value){
                    ?>
                    <div class="entry input-group col-xs-12">
                        <div class="thumbnail">
                            <div class="well" style="margin-bottom: 0">
                                <?php echo $form->textFieldGroup($value, '['.$key.']title', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'placeholder' => 'Title')), 'labelOptions' => array("label" => "Title"))); ?>
                                <?php echo $form->textFieldGroup($value, '['.$key.']action', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'placeholder' => 'Action')), 'labelOptions' => array("label" => "Action"))); ?>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="control-label"></label>
                                    <button class="btn btn-danger btn-remove" type="button" style="width: 100%;">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                            }?>

<!--                            <div class="entry input-group col-xs-12">
                                <div class="thumbnail">
                                    <div class="well" style="margin-bottom: 0">
                                        <?php echo $form->textFieldGroup($model_t, '['.$count_a.']title', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'placeholder' => 'Title')), 'labelOptions' => array("label" => "Title"))); ?>
                                        <?php echo $form->textFieldGroup($model_t, '['.$count_a.']action', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'placeholder' => 'Action')), 'labelOptions' => array("label" => "Action"))); ?>
                                        <div class="form-group" style="margin-bottom: 0;">
                                            <label class="control-label"></label>
                                            <button class="btn btn-success btn-add" type="button" style="width: 100%;">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                            <?php
                        }else{
                            ?>
                            <div class="entry input-group col-xs-12">
                            <div class="well bg-white">
                                        <?php echo $form->textFieldGroup($model_a, '[0]title', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'placeholder' => 'Title')), 'labelOptions' => array("label" => "Title"))); ?>
                                        <?php echo $form->textFieldGroup($model_a, '[0]action', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'placeholder' => 'Action')), 'labelOptions' => array("label" => "Action"))); ?>
                                        <div class="row">
<!--                                        <div class="col-md-9 col-md-offset-3">
                                            <button class="btn btn-success btn-block" type="button">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>                                            
                                        </div>-->
                                        </div>
                                        </div>
                            </div>
                            <?php
                        }
                        ?>






                </div>
            </div>
            
        </div>
        
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label"></label>
        <div class="col-sm-9">
            <div class="controls">
                <div class="action">
                    <button class="btn btn-success btn-add" type="button" style="width: 100%;">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
        <small>Press <span class="glyphicon glyphicon-plus gs"></span> to add another form field :)</small>
        </div>
        </div>
        </div>
    </div>
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model_c->isNewRecord ? 'Create' : 'Save',
            'htmlOptions' => array('class' => 'pull-right'),
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php
Yii::app()->clientScript->registerScript('settings-script', <<<EOD

    $(function()
    {
        $(document).on('click', '.btn-add', function(e)
        {
            e.preventDefault();
            var numItems = $('.entry').length
            var data_html = '<div class="entry input-group col-xs-12">'+
    '<div class="thumbnail">'+
        '<div class="well" style="margin-bottom: 0">'+
            '<div class="form-group"><label class="col-sm-3 control-label required" for="PAction_title">Title <span class="required">*</span></label>'+
               '<div class="col-sm-9"><input class="span5 form-control" maxlength="255" required placeholder="Title" name="PAction['+ numItems +'][title]" id="PAction_title" type="text">'+
                    '<div class="help-block error" id="PAction_title_em_'+ numItems +'" style="display:none"></div>'+
                '</div>'+
            '</div>'+
            '<div class="form-group"><label class="col-sm-3 control-label required" for="PAction_action">Action <span class="required">*</span></label>'+
                '<div class="col-sm-9"><input class="span5 form-control " required maxlength="255" placeholder="Action" name="PAction['+ numItems +'][action]" id="PAction_action" type="text">'+
                   '<div class="help-block error" id="PAction_action_em_'+ numItems +'"  style="display:none"></div>'+
                '</div>'+
            '</div>'+
            '<div class="form-group">'+
                '<label class="control-label"></label>'+
                '<button class="btn btn-danger btn-remove" type="button" style="width: 100%;">'+
                    '<span class="glyphicon glyphicon-minus"></span>'+
                '</button>'+
            '</div>'+
        '</div>'+
    '</div>'+
'</div>';
            
            var controlForm = $('.controls .action:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(data_html).appendTo(controlForm);
                
            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="glyphicon glyphicon-minus"></span>');
        }).on('click', '.btn-remove', function(e)
        {
            $(this).parents('.entry:first').remove();
    
            e.preventDefault();
            return false;
        });
    });


EOD
    , CClientScript::POS_END);
?>

</div>