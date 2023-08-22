<?php
// $titleName = 'Create Controller';
// $this->headerText = $titleName;
$formNameModel = 'PController';
?>
<div class="innerLR">

    <div class="col-md-12" style="margin-bottom: 1em;">
        <div class="btn-group" role="group">
            <a href="<?= Yii::app()->createUrl('pController/index'); ?>" type="button" class="btn btn-info"><i
                        class="fa fa-folder-open-o" aria-hidden="true"></i>
                จัดการ Group
            </a>
        </div>
    </div>
    <div class="col-md-12">
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'pgroup-grid',
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            //'validateOnSubmit' => true
        ),
        'htmlOptions' => array('class' => 'well'), // for inset effect
    )); ?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldGroup($model, 'group_name', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

    <div class="form-group">
        <label class="col-sm-3 control-label">Permission</label>
        <div class="col-sm-9">
            <?php
            if ($pController) {
                foreach ($pController as $ckey => $controller) {
                    $action = CHtml::listData($controller->pAction, 'action', 'title');


                    $permission = (array)json_decode($model_p->permission);
                    $model_p->action = $permission[$controller->controller]->action;
                    $model_p->active = $permission[$controller->controller]->active;
                    ?>
                    <div class="entry input-group col-xs-12">
                        <div class="well bg-white">
                                <div class="form-group">
                                    <label class="control-label col-xs-3">Controller</label>
                                    <div class="col-xs-9">
                                        <?= $controller->title; ?>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php echo $form->checkboxListGroup(
                                            $model_p,
                                            '[' . $controller->controller . ']action',
                                            array(
                                                'widgetOptions' => array(
                                                    'data' => $action,
                                                ),
                                                'wrapperHtmlOptions' => array(
                                                    'class' => 'col-sm-5',
                                                ),
                                                'inline' => true,
                                            )
                                        ); ?>
                                        <?php echo $form->switchGroup($model_p, '[' . $controller->controller . ']active',
                                            array(
                                                'wrapperHtmlOptions' => array(
                                                    'class' => 'col-sm-5',
                                                ),
                                                'widgetOptions' => array(
                                                    'events' => array(
                                                        'switchChange' => 'js:function(event, state) {
						  console.log(this); // DOM element
						  console.log(event); // jQuery event
						  console.log(state); // true | false
						}'
                                                    )
                                                )
                                            )
                                        ); ?>

                                    </div>
                                </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <small>Press <span class="glyphicon glyphicon-plus gs"></span> to add another form field :)</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box-footer">
                <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'label' => $model->isNewRecord ? 'Create' : 'Save',
                    'htmlOptions' => array('class' => 'pull-right','onclick'=>'upload()'),
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
    </div>

    <script type="text/javascript">
        function upload()
    {
        alert('โปรดรอสักครู่ ระบบกำลังประมวลผล')
        // swal({
        //     title: "โปรดรอสักครู่",
        //     text: "ระบบกำลังประมวลผล",
        //     type: "info",
        //     confirmButtonText: "ตกลง",
        // });
    }
    </script>
</div>