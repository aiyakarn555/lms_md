<html>
<head>
	<title></title>
	<style type="text/css">
</style>
</head>
<body>
	<h4>รายชื่อแจ้งเตือนหลักสูตร</h4>
	<br>
	<?php foreach($model as $value){ ?>
		<h4>คุณ : <?= $value['firstname'].' '.$value['lastname']; ?> หลักสูตร <?= $value['nameCourse']; ?>กำลังจะหมดอายุ ในอีก <?= $value['dayEnd']; ?>วัน </h4>
		<br>
	<?php } ?>
	<br>
	<h4>จึงเรียนมาเพื่อทราบ</h4>

</body>
</html>