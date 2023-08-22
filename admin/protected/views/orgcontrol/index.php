<?php
/* @var $this CoursecontrolController */
/* @var $dataProvider CActiveDataProvider */
// echo $_GET['id'];

$this->breadcrumbs=array(
	'Org Courses',
);

// $this->menu=array(
// 	array('label'=>'Create OrgCourse', 'url'=>array('create')),
// 	array('label'=>'Manage OrgCourse', 'url'=>array('admin')),
// );
?>

<style type="text/css">
/**
 * Nestable
 */

 .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; background: #fff; min-height: 100px }

 .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
 .dd-list .dd-list { padding-left: 30px; }
 .dd-collapsed .dd-list { display: none; }

 .dd-item,
 .dd-empty,
 .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

 .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }

.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder,
.dd-empty { 
    margin: 5px 0; 
    padding: 0; 
    min-height: 30px; 
    background: #fff; 
    /*border: 1px dashed #b6bcbf; */
    box-sizing: border-box; 
    -moz-box-sizing: border-box; 
}
.dd-empty { 
 /* border: 1px dashed #bbb; */
 min-height: 100px; 
 background-color: #fff;
    /*background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;*/
}

.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
    box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

/**
 * Nestable Extras
 */

 .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

 #nestable-menu { padding: 0; margin: 20px 0; }

 #nestable-output,
 #nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

 #nestable2 .dd-handle {
    color: #fff;
    border: 1px solid #999;
    background: #bbb;
    background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
    background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
    background:         linear-gradient(top, #bbb 0%, #999 100%);
}
#nestable2 .dd-handle:hover { background: #bbb; }
#nestable2 .dd-item > button:before { color: #fff; }


.dd-hover > .dd-handle { background: #2ea8e5 !important; }

/**
 * Nestable Draggable Handles
 */

 .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd3-content:hover { color: #2ea8e5; background: #fff; }

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-item > button { margin-left: 30px; }

.dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
    border: 1px solid #aaa;
    background: #ddd;
    background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:         linear-gradient(top, #ddd 0%, #bbb 100%);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
.dd3-handle:hover { background: #ddd; }

</style>
<div class="span12">
    <h1>แผนก</h1>

    <div class="span12">
       <menu id="nestable-menu">
         <!-- <button type="button" data-action="expand-all">Expand All</button> -->
         <!-- <button type="button" data-action="collapse-all">Collapse All</button> -->
         <button type="button" id="save" class="btn btn-success">SAVE</button>
     </menu>
 </div>


 <div class="cf nestable-lists">

    <div class="row">
        <div class="span6" align="center" style="background-color: #fff; padding: 10px 0;"><strong style="font-size: medium;">แผนกที่เลือก</strong></div>
        <div class="span6" align="center" style="background-color: #fff; padding: 10px 0;"><strong style="font-size: medium;">แผนกทั้งหมด</strong></div>
    </div>
    <div class="row-fluid">

      <div class="span6">
          <div class="dd" id="nestable">
              <?php
              $courseonline=OrgDepart::model()->find(array(
                'condition'=>'parent_id=0 AND orgchart_id='.$_GET['id'],
            ));
              if($courseonline){
                if(isset($_GET['id'])){
                    $this->Widget('ATreeView', array(
                        'data' => OrgDepart::getChilds(0),
                        'animated' => 'slow',
                        'collapsed' => 'true',
                        'persist' => 'cookie',
                        'htmlOptions' => array('class'=>'dd-list'),
                    ));
                }
            }else{
                ?>
                <div class="dd-empty"></div>
            <?php } ?>
        </div>
    </div>

    <div class="span6">
      <div class="dd" id="nestable2">
       <?php
       $criteria = new CDbCriteria;
       $criteria->compare('active','y');
       $criteria->compare('lang_id',1);
       $criteria->addInCondition('id', $result_department);
       $department=Department::model()->findAll($criteria);
       if($department){
        ?>
        <ol class="dd-list">
            <?php
            foreach ($department as $key => $value) {
                ?>
                <li class="dd-item" data-id="<?=$value->id?>">
                 <div class="dd-handle"><?=$value->dep_title?></div>
             </li>
             <?php
         }
         ?>
     </ol>
     <?php 
 }else{
   ?>
   <div class="dd-empty"></div>
   <?php
}
?>

</div>
</div>
</div>


</div>


<!--<div class="span12">-->
    <!--    <textarea id="nestable-output"></textarea>-->
    <!--    <textarea id="nestable2-output"></textarea>-->
    <!--</div>-->

    <div style="clear:both;"></div>
</div>
<?php 
// $this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); 

$cs=Yii::app()->clientScript;
$path=Yii::app()->baseUrl;
$path_theme=Yii::app()->theme->baseUrl;
$cs->registerScriptFile($path_theme.'/assets/theme/scripts/plugins/nestable/jquery.nestable.js',CClientScript::POS_END);

?>



<script>

    $(document).ready(function()
    {

        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
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

    $('#nestable-menu').on('click', function(e)
    {
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


    $('#save').click(function() {
      var tmp = JSON.stringify($('#nestable').nestable('serialize'));
      var tmp2 = JSON.stringify($('#nestable2').nestable('serialize'));
      $.ajax({
        type: 'POST',
        url: '<?=Yii::app()->createUrl('Orgcontrol/save_categories')?>',
    // dataType: 'json',
    data: {categories: tmp, org_id:<?=$_GET['id']?>, categories2:tmp2},
    success: function(data) {
      alert("SAVE");
      history.go(0);
  }
});
  });


});
</script>

