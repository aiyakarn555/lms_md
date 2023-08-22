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
       <!--  <a class="navbar-brand hidden-xs"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" height="60px" alt=""></a> -->
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
        <label>สวัสดีคุณ :  <?php echo $nameshow; ?></label>
        <br><br>
              <h2><label for="">ชื่อห้องเรียน :</label>
                <?php echo $name_vroom; ?>
                <br>  </h2>
                <h2><label for="">Classroom name :</label>
                <?php echo $Classroom_name; ?>
                <br>  </h2>
              <!-- <label for="">รหัสที่ใช้ในการเข้าห้องเรียน</label> -->
              <!-- <br><br> -->
              <label for="">รหัส :</label>
              <a>
                <?php echo $key; ?>
                <br><br>
                <?php echo $email ?>
              <!-- <label for="">ชื่อห้องเรียน :</label>
                <?php echo $name_vroom; ?>
                <br><br> -->  
              </a>
          
      </th>
      <th width="25%">
      </th>
  </tr>
</body>
</html>