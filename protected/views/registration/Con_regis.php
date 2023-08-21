<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-main">
      <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= $label->label_regis ?></li>
    </ol>
  </nav>
</div>

<?php
$form = $this->beginWidget('CActiveForm', array(
  'id' => 'registration-form',
  'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1'),
));
?>
<section class="content" id="about-us">
  <div class="container">
    <div class="well">
      <div class="detail">
        <center>
          <h2><?php echo $model->conditions_title; ?></h2>
        </center>
        <?php echo $model->conditions_detail; ?>

      </div>
      <center>

        <div class="condition">
          <div class="form-group">
            <div class="radio radio-danger radio-inline">
              <input type="radio" name="status" id="accept" value="1">
              <label for="accept" class="bg-success text-black">
                <?= $label->label_accept ?>
              </label>
            </div>
            <div class="radio radio-danger radio-inline">
              <input type="radio" name="status" id="reject" value="2">
              <label for="reject" class="bg-danger text-black"><?= $label->label_reject ?>
              </label>
            </div>
          </div>
        </div>
        <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block')); ?>
      </center>
    </div>
  </div>

</section>

<div class="login-bg">
    <img class="login-img-1" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg3.png">
    <img class="login-img-2" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg4.png">
</div>

<?php $this->endWidget(); ?>
<?php if (Yii::app()->user->hasFlash('CheckQues')) {
?>
  <script>
    $(document).ready(function() {
      var url = '<?php echo Yii::app()->createUrl('registration/ShowForm'); ?>';
      var msg = '<?php echo Yii::app()->user->getFlash('CheckQues'); ?>';
      var cla = '<?php echo Yii::app()->user->getFlash('checkClass'); ?>';
      swal({
          title: "System",
          text: msg,
          type: cla,
          confirmButtonText: "OK",
        },
        function() {
          window.location.href = url;
        });
    });
  </script>
<?php
  Yii::app()->user->setFlash('CheckQues', null);
  Yii::app()->user->setFlash('checkClass', null);
}
?>