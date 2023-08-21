
<?php echo CHtml::beginForm(Yii::app()->createUrl('AddGroup/Preview'), 'POST'); ?>
<div id="pre"></div>


<input type="button" value="AJAX" onclick="Ajax();"/>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/jquery/jquery-1.11.3.min.js"); ?>

<script type="text/javascript">
    var baseUrl = "../AddGroup/Preview";
    function Ajax() {
        jQuery.ajax({
            type: "POST",
            url: "../AddGroup/getDataPreview",
            success: function (data) {
                //alert(data);                             
                $("#pre").html(data);
            },
            error: function (xhr) {
                alert("failure: " + xhr.readyState + this.url);

            }
        });

    }
</script>



<?php
echo CHtml::endForm();
