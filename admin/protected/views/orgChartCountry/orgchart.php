<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/jOrgChart/example/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/jOrgChart/example/css/jquery.jOrgChart.css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/jOrgChart/example/css/custom.css"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/jOrgChart/example/css/prettify.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/jOrgChart/example/prettify.js"></script>

<!-- jQuery includes -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/theme/scripts/jOrgChart/example/jquery.jOrgChart.js"></script>
<!--<script src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/assets/theme/scripts/jquery.serialize-list.js"></script>-->
<script>
    jQuery(document).ready(function() {
        $("#org").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : true
        });

//        function check(elm){
//            var domArray = [];
//            if(elm.children('ul').lenght > 0){
//                domArray
//            }
//        }

        $('#save').click(function(){

            var myObject = new Object();
            myObject.name = "John";
            myObject.age = 12;
            myObject.pets = [{id:"cat"}, {id:"dog"}];
            console.log(JSON.stringify(myObject));
//            var domArray = [];
//            var dom = $("#org");
//            var liroot = dom.find('li')[0];
//
//            if($(liroot).children("ul").length > 0){
//                var ulroot = $(liroot).children("ul")[0];
//                $.each($(ulroot).children("li"),function(index, value) {
//                    if($(this).children("ul").length > 0) {
//
//                    }else{
//                        domArray[$(liroot).attr('data-id')] = $(this);
//                    }
//                    //console.log(check($(this)));
//                });
//            }
//            $.post('<?php //echo $this->createUrl('/orgchart/orgchartsave'); ?>//',{html:$("#org").html()},function(data){
//                console.log(data);
//            })
        });

    });
</script>
<div style="background-color: #fdf5ce;">
    <?php
    $criteria=new CDbCriteria;
    $criteria->order='t.lft'; // or 't.root, t.lft' for multiple trees
    $criteria->condition='t.root=1'; // or 't.root, t.lft' for multiple trees
    $categories=OrgChart::model()->findAll($criteria);
    $level=0;

    foreach($categories as $n=>$category)
    {
        if($category->level==$level)
            echo CHtml::closeTag('li')."\n";
        else if($category->level>$level)
            echo ($category->level==1)?CHtml::openTag('ul',array('id'=>'org','style'=>'display:none')):CHtml::openTag('ul')."\n";
        else
        {
            echo CHtml::closeTag('li')."\n";

            //you write for($i=$level-$model->level;$i;$i--) but we don't have $model, we have $category
            for($i=$level-$category->level;$i;$i--)
            {
                echo CHtml::closeTag('ul')."\n";
                echo CHtml::closeTag('li')."\n";
            }
        }

        echo CHtml::openTag('li',array('data-level'=>$category->level,'data-id'=>$category->id));
        echo CHtml::encode($category->title);
        $level=$category->level;
    }

    for($i=$level;$i;$i--)
    {
        echo CHtml::closeTag('li')."\n";
        echo CHtml::closeTag('ul')."\n";
    }

    ?>
    <div id="chart" class="orgChart"></div>
    <input type="button" id="save" value="Save">

</div>