<html>
<head>
	<title></title>
	<style type="text/css">
</style>
</head>

<body>
  <h3><u>อนุมัติการสมัครสมาชิก\ Approval</u></h3>
  <h4>เรียน : <?= $model->profile->firstname.' '.$model->profile->lastname; ?></h4>
  <h4>ท่านได้ทำการสมัครเพื่อเข้าใช้บริการ thorconn.com และแอพพลิเคชั่น Thoresen e-Leaning เรียบร้อยแล้ว </h4>
  <h4>โดยมีชื่อผู้ใช้และรหสัผ่านดังนี้</h4>
  <h4>- User : <?= $model->username; ?></h4>
  <h4>- Password : <?= $genpass; ?></h4>
  <h4><u>นโยบายรหัสผ่าน</u></h4>
  <h4>1. หลังจากที่ได้รับการอนุมัติชื่อผู้ใช้และรหัสผ่าน ให้ท่านทำการเปลี่ยนรหัสผ่านทันทีสำหรับการเข้าใช้คร้ังแรก</h4>
  <h4>2. การตั้งรหัสผ่านจะประกอบไปด้วยอักษรภาษาอังกฤษทั้งพิมพ์เล็ก /ใหญ่ ตัวเลขเครื่องหมายพิเศษ เช่น %?!#@ และมีจำนวน 8 ตัวอักษรขึ้นไป</h4>
  <h4>3. ไม่อนุญาติให้ใช้ข้อมูลส่วนตัวที่หาได้ง่ายได้แก่ชื่อวันเดือนปี เกิด เลขบัตรประชาชน มาตั้งรหัสผ่าน</h4>
  <h4>4. ระยะเวลาที่หมดอายุของรหัสผ่าน คือ 90 วัน</h4>
  <h4>5. รายงานต่อแอดมินทันทีเมื่อมีเหตุอันเชื่อได้ว่า ชื่อผู้ใช้และรหัสผ่านของตนเองถูกผู้อื่นนำไปใช้งานโดยไม่ถูกต้อง พร้อมกับเปลี่ยนรหัสผ่านของท่านทันที</h4>
  <h4>6. ไม่กระทำการเปลี่ยนแปลงแก้ไข หรือทำลายระบบป้องกันของระบบ ที่จะเข้าไปเรียกใช้ข้อมูลในส่วนที่ตนเองไม่มีสิทธิ</h4>
  <h4>7. ท่านสามารถเข้าสู่ระบบของเราได้ที่<a href="https://203.150.199.24/lms_md/">https://203.150.199.24/lms_md/</a></h4>
  <br><br>
  <h3><u>Registered successfully</u></h3>
  <h4>Dear : <?= $model->profile->firstname_en.' '.$model->profile->lastname_en; ?></h4>
  <h4>You have successfully applied a member of Md</h4>
  <h4>Please see a username and password as follows.</h4>
  <h4>- Username : <?= $model->username; ?></h4>
  <h4>- Password : <?= $genpass; ?></h4>
  <h4>PasswordPolicy</h4>
  <h4>1. After the username and password have been approved, please immediately change your password in first login.</h4>
  <h4>2. Setting a password can contain both lower / uppercase letters, numbers, and special characters such as % ?! # @ and 8 characters or more.</h4>
  <h4>3. Don't use of personal information that is easily available, such as name, date of birth, ID card number to set a password.</h4>
  <h4>4. The password expiration period is 90 days.</h4>
  <h4>5. Report to web admin immediately. When there is reason to believe that your username and password being to used by the others incorrectly.
Along with changing your password immediately.</h4>
  <h4>6. Don't to alter, modify or destroy the web system's security to access information in the area that they don't have authority.</h4>
  <h4>7. You can login to our system at <a href="https://203.150.199.24/lms_md/">https://203.150.199.24/lms_md/</a></h4>
</body>
</html>