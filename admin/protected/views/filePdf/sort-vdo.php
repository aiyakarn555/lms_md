<?php
/* @var $this CoursecontrolController */
/* @var $dataProvider CActiveDataProvider */
// echo $_GET['id'];

$this->breadcrumbs = array(
    'Org Vdo',
);
$titleName = 'ชื่อบทเรียน: '.$lesson->lesson_name;
$this->headerText = $titleName;

// $this->menu=array(
// 	array('label'=>'Create OrgCourse', 'url'=>array('create')),
// 	array('label'=>'Manage OrgCourse', 'url'=>array('admin')),
// );
?>
<div class="span12">
    <!-- <h1>Org Vdo</h1> -->

    <div class="span12">
        <menu id="nestable-menu">
            <button type="button" data-action="expand-all">Expand All</button>
            <button type="button" data-action="collapse-all">Collapse All</button>
            <button type="button" id="save">SAVE</button>
        </menu>
    </div>


    <div class="cf nestable-lists">

        <div class="row">
            <div class="col-xs-6" align="center" style="background-color: #fff; padding: 10px 0;"><strong
                        style="font-size: medium;">กำหนดลำดับชั้นวิดีโอ</strong></div>
            <div class="col-xs-6" align="center" style="background-color: #fff; padding: 10px 0;"><strong
                        style="font-size: medium;">วิดีโอทั้งหมด</strong></div>
        </div>
        <div class="row-fluid">

            <div class="col-xs-6">
                <div class="dd" id="nestable">
                    <?php
                    $courseonline = ControlVdo::model()->find(array(
                        'condition' => 'parent_id=0 AND lesson_id=' . $_GET['id'],
                    ));
                    if ($courseonline) {
                        if (isset($_GET['id'])) {
                            $this->Widget('ZTreeView', array(
                                'data' => ControlVdo::getChilds(0),
                                'animated' => 'slow',
                                'collapsed' => 'true',
                                'persist' => 'cookie',
                                'htmlOptions' => array('class' => 'dd-list'),
                            ));
                        }
                    } else {
                        ?>
                        <div class="dd-empty"></div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="dd" id="nestable2">
                    <?php
                    $criteria = new CDbCriteria;
                    $criteria->addInCondition('id', $result_control_lesson);
                    $lessonList = File::model()->findAll($criteria);
                    // var_dump($lessonList);exit();
                    // $fileList = LessonList::model()->with('files')->findByPk($id);
                    if ($lessonList) {
                        ?>
                        <ol class="dd-list">
                            <?php
                            foreach ($lessonList as $key => $value) {
                                ?>
                                <li class="dd-item" data-id="<?= $value->id ?>">
                                    <div class="dd-handle">
                                        <div class="well well-sm">
                                            <div class="row">
                                                <div class="col-xs-3 col-md-3 text-center">
                                                    <img src="http://bootsnipp.com/apple-touch-icon-114x114-precomposed.png"
                                                         alt="bootsnipp"
                                                         class="img-rounded img-responsive"/>
                                                </div>
                                                <div class="col-xs-9 col-md-9 section-box">
                                                    <h2 id="filenamedoctext<?= $value->id ?>">
                                                        <?= $value->RefileName;?></h2>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <?php echo '<input class="form-control" id="filenamedoc'.$value->id.'" type="text" value="'.$value->file_name.'" style="display:none;" onblur="editName('.$value->id.');">'; ?>
                                    <a id="btnEditName<?= $value->id ?>" onclick='$("#filenamedoctext<?= $value->id ?>").hide(); $("#filenamedoc<?= $value->id ?>").show(); $("#filenamedoc<?= $value->id ?>").focus(); $("#btnEditName<?= $value->id ?>").hide();' class="btn btn-warning btn-edt"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ol>
                        <?php
                    } else {
                        ?>
                        <div class="dd-empty"></div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>


        <div style="clear:both;"></div>
    </div>


    <!--<div class="span12">-->
    <!--    <textarea id="nestable-output"></textarea>-->
    <!--    <textarea id="nestable2-output"></textarea>-->
    <!--</div>-->

</div>
<?php
// $this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// ));

$cs = Yii::app()->clientScript;
$path = Yii::app()->baseUrl;
$path_theme = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($path_theme . '/base_assets/nestable/jquery.nestable.js', CClientScript::POS_END);
$cs->registerCssFile($path_theme . '/base_assets/nestable/nestable.css');

?>


<script>
function editName(filedoc_id){

    var name = $('#filenamedoc'+filedoc_id).val();
    
    $.get("<?php echo $this->createUrl('lesson/editNameVdo'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filenamedoc'+filedoc_id).hide();
        $('#filenamedoctext'+filedoc_id).text(name);
        $('#filenamedoctext'+filedoc_id).show();
        $('#btnEditName'+filedoc_id).show();
    });

}
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

        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1
        })
            .on('change', updateOutput);

        // activate Nestable for list 2
        $('#nestable2').nestable({
            group: 1
        })
            .on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('#nestable3').nestable();


        $('#save').click(function () {
            var tmp = JSON.stringify($('#nestable').nestable('serialize'));
            var tmp2 = JSON.stringify($('#nestable2').nestable('serialize'));
            // tmp value: [{"id":21,"children":[{"id":196},{"id":195},{"id":49},{"id":194}]},{"id":29,"children":[{"id":184},{"id":152}]},...]
            $.ajax({
                type: 'POST',
                url: '<?=Yii::app()->createUrl('File/savePriority')?>',
                data: {vdo: tmp, lesson_id:<?=$_GET['id']?>, vdo2: tmp2},
                success: function (data) {
                    alert("SAVE");
                    history.go(0);
                }
            });
        });


    });
</script>

