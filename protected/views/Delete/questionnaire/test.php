<?php echo CHtml::form();?>
    
    <?php echo CHtml::openTag('table',array('id'=>'test'));?>
    <?php echo CHtml::openTag('tr');?>
    <?php echo CHtml::tag('td', array(), CHtml::textField('test','test'));?>
    <?php echo CHtml::closeTag('tr');?>
    <?php echo CHtml::closeTag('table');?>
    <?php //echo CHtml::textField('abc',$abc)?>
    <?php echo CHtml::submitButton('submit')?>

<?php echo CHtml::endForm();?>

<?php 
    /*$cs = Yii::app()->clientScript;
    $cs->scriptMap = array(
    'jquery.js' => Yii::app()->request->baseUrl.'/js/jquery.js',
    'jquery.yii.js' => Yii::app()->request->baseUrl.'/js/jquery.min.js',
    );
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');*/

    echo CHtml::textField('test',$count);
    echo CHtml::textField('test123',$so_good);
    echo CHtml::button('abc',array('id'=>'abc'));

    /*$data = array(
        1 => array ('Name', 'Surname'),
        array('Schwarz', 'Oliver'),
        array('Test', 'Peter')
    );*/

    /*Yii::app()->clientScript->registerScript(
        'testjs',
        '$( "#abc" ).click(function() {
            alert( "Clicked" );
        });
        ',
        CClientScript::POS_READY
    ); */
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/jquery/jquery-1.11.3.min.js"); ?>
<script type="text/javascript">
    var counter = 1;
    var baseUrl = "index.php?r=Questionnaire/AddTextField";    
    $(document).ready(function(){
        $("#abc").click(function(){
            $.post(baseUrl, {
                count: counter,
                }
                ,function(result){
                    //alert(result);
                    $('#test').append(result);
                    counter++;
                }
            );
        });
    });
</script>