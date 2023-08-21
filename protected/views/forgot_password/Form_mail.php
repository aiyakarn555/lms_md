<style>
    table#t01 {
        width: 100%;    
        background-color: #61AB36CC;
        text-align: left;
    }
table#t02{
        width: 100%;    
        background-color:hsla(0, 52%, 0%, 0.06) ;
        text-align: left;
    }
</style>
<!-- Content -->
<html>
<head>
  <table id="t01">
  <tr>
      <th>
        <br>
        <center>
        <a class="navbar-brand hidden-xs"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" height="60px" alt=""></a>
        </center>
        <br>
      </th>
  </tr>
</table> 
</head>
<body> 
  <table width="100%" id="t02">
    <tr>
      <th width="25%">

      </th>
      <th width="50%">
      <br>              
        <label for="">Reset Password</label><br>
              <a href="<?php echo Yii::app()->createAbsoluteUrl('forgot_password/Checkpassword',array('oldpassword'=> $finduserbymail->password)); ?>">Link :: 
                <?php echo Yii::app()->createAbsoluteUrl('forgot_password/Checkpassword',array('oldpassword'=> $finduserbymail->password)); ?> 
              </a>
              <br><br>
      </th>

      <th width="25%">
      </th>
  </tr>
</body>
</html>