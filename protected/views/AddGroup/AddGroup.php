<!-- page 2 add Questionnaire-->


<?php echo CHtml::beginForm(Yii::app()->createUrl('AddGroup/AddGroup'), 'POST'); ?>
<?php
echo "<br>";
echo 'TH ชื่อแบบสอบถาม';
echo CHtml::textField('nameTH');
echo '<br>';
echo '<br>';
echo 'EN ชื่อแบบสอบถาม';
echo CHtml::textField('nameEN');
?>
<br>
<br>


<?php
echo 'วันที่';
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name' => 'publishDate',
    // additional javascript options for the date picker plugin
    'options' => array(
        'showAnim' => 'fold',
    ),
    'htmlOptions' => array(
        'style' => 'height:20px;'
    ),
));
?>

<?php
echo 'ถึง';
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name' => 'endDate',
    // additional javascript options for the date picker plugin
    'options' => array(
        'showAnim' => 'fold',
    ),
    'htmlOptions' => array(
        'style' => 'height:20px;'
    ),
));
?>

<table style='border-style: solid; margin-top:10px; margin-bottom: 10px; margin-left: 30px;'>
    <tr>
        <td>หัวข้อที่ 1 <input type="button" value="save" onclick="saveQuestion('<?php echo  $count;?>');"/>
 <input type="button" value="Preview" onclick=""/>
         </td>


    </tr>   
    <tr>
        <td> <?php
            echo CHtml::label('หัวข้อ : ', null);
            echo CHtml::dropDownList('DDlist', '', $dropdownitem, ''); // แสดง dropDownList
            echo '<br>';
            echo CHtml::label('คำถาม : ', null);
            ?>
            <div id='Question'></div>
        </td>
    </tr>



</table>
<?php
echo CHtml::submitButton('ตกลง');
echo CHtml::submitButton('ยกเลิก');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/jquery/jquery-1.11.3.min.js"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        var value = $('#DDlist :selected').text();
        jQuery.ajax({
            type: "POST",
            url: "../Addgroup/Listquestion",
            data: {val: value},
            success: function (msg) {
               //alert('success');
                $("#Question").html(msg);
            },
            error: function (xhr) {
                alert("failure: " + xhr.readyState + this.url);

            }
        });
        $('#DDlist').change(function () {
            var value = $('#DDlist :selected').text();
            var baseUrl = "../AddGroup/AddGroup";

            jQuery.ajax({
                type: "POST",
                url: "../Addgroup/Listquestion",
                data: {val: value},
                success: function (msg) {
                    //cosole.log('success');
                 //   alert('success');
                    $("#Question").html(msg);
                },
                error: function (xhr) {
                    alert("failure: " + xhr.readyState + this.url);

                }
            });


        });
    });

function saveQuestion(count)
{
    var Title = $('#DDlist :selected').text();
    for(i=1;i<=count;i++)
    {
    if($("#chkquestion"+i).is(':checked'))// Only Check 
    {
    var question = $("#chkquestion"+i).val();
    if(question!=null)
    {
    alert(question);
     jQuery.ajax({
                type: "POST",
                url: "../Addgroup/InsertQuestion",   
                data: {chkquestion: question,result:Title},            
                success: function (msg) {                    
                    //alert('success');      
                        $("#test").html(msg);        
                },
                error: function (xhr) {
                    alert("failure: " + xhr.readyState + this.url);

                }
            });
    }
    }
    }
}
</script>

<div id= "test"></div>
<?php
echo CHtml::endForm();




