<html>
<head>
	<title></title>
	<style type="text/css">
</style>
</head>
<body>
	<h3><u>อนุมัติการเข้าใช้งานระบบ\ Approval</u></h3>
	<h4>เรียน : <?= $model->profile->firstname.' '.$model->profile->lastname; ?></h4>
	<h4>ผู้ดูแลระบบได้ทำการอนุมัติการสมัครสมาชิกเพื่อเข้าใช้บริการ LmsMd เรียบร้อยแล้ว </h4>
	<br><br>
	<!-- <h4>กรุณารอการอนุมัติการเข้าใช้งานระบบและ Username && Password เพื่อเข้าใช้งาน</h4> -->
	<h4>Dear : <?= $model->profile->firstname_en.' '.$model->profile->lastname_en; ?></h4>
	<h4>The webadministrator has approved member access of LmsMd </h4>

</body>
</html>