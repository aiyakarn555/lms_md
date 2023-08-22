<?php
$this->breadcrumbs = array(
    'จัดเรียงบทเรียน',
);
?>
<style>
.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }

#nestable2 .dd-handle:hover { background: #bbb; }
#nestable2 { background-color: #9bb759; }
</style>

<div class="span12">
    <div class="span12">
        <menu id="nestable-menu">
            <button type="button" id="save" class="btn btn-default">บันทึก</button>
        </menu>
    </div>


    <div class="cf nestable-lists">
        <div class="row-fluid">
            <div class="col-xs-12">
                <div class="bg-danger" style="padding: 20px;">
                    <h4 class="text-center"><strong>บทเรียนทั้งหมด</strong></h4>
                    <div class="dd" id="nestable2">
                        <?php
                        $criteria = new CDbCriteria;
                        $criteria->addCondition('course_id ="'.$_GET['id'].'"');
                        $criteria->addCondition('active ="y" AND sequence_id = 0');
                        $criteria->order='lesson_no';
                        $lessonList = Lesson::model()->findAll($criteria);

                        if ($lessonList) {
                             if (isset($_GET['id'])) {
                                $this->Widget('ZTreeViewLesson', array(
                                    'data' => Lesson::getChilds(0),
                                    'animated' => 'slow',
                                    'collapsed' => 'true',
                                    'persist' => 'cookie',
                                    'htmlOptions' => array('class' => 'dd-list'),
                                ));
                            }

                            } else {
                                ?>
                                <div class="dd-empty">empty</div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>

    </div>
    <?php

    $cs = Yii::app()->clientScript;
    $path = Yii::app()->baseUrl;
    $path_theme = Yii::app()->theme->baseUrl;
    $cs->registerScriptFile($path_theme . '/nestable/jquery.nestable.js', CClientScript::POS_END);
    $cs->registerCssFile($path_theme . '/nestable/nestable.css');
    ?>

    <script>
        $(document).ready(function () {

            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                output = list.data('output');
                if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));

            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 2
        $('#nestable2').nestable({
            group: 1,
            maxDepth: 11
        })
        .on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
            action = target.data('action');
        });

        $('#save').click(function () {
            var tmp2 = JSON.stringify($('#nestable2').nestable('serialize'));
            $.ajax({
                type: 'POST',
                url: '<?=Yii::app()->createUrl('courseOnline/save_categories')?>',
                data: {categories: tmp2, course_id:<?=$_GET['id']?>},
                success: function (data) {
                    alert("บันทึกสำเร็จ");
                    history.go(0);
                }
            });
        });


    });
</script>

