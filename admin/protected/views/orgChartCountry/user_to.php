
<?php
$modelUsers_old_chk = ChkUsercourseto::model()->findAll(
        array(
          'condition' => 'course_id=:course_id AND orgchart_id=:orgchart_id',
          'params' => array(':course_id'=>$_GET['id'], ':orgchart_id'=>$_GET['orgchart_id'] )
        )
      );

$modelUsers_old_chk_user = [];
foreach ($modelUsers_old_chk as $key2 => $val) {
  $modelUsers_old_chk_user[] = $val->user_id;
}

  
$titleName = 'จัดการผู้ใช้งาน';
$formNameModel = 'CourseOnline';

$this->breadcrumbs=array($titleName);
?>
<?php
                ?>
 <form enctype="multipart/form-data"  action="<?=$this->createUrl('OrgChart/CheckUserTo/').'/'.$_GET['id']?>" method="get">
  <div class="container-fluid"> 
    <h3><b>ค้นหา </b></h3>
</div>
<input type="hidden" name="orgchart_id" value="<?=$_GET['orgchart_id'] ?>">
<input type="hidden" name="all" value="<?=$_GET['all'] ?>">
  

<div class="row">

    <div class="col-md-12">
     <label>  <h5>ค้นหาจาก ชื่อ - นามสกุล</h5></label>
    

<input class="span6" autocomplete="off" name="namesearch" value="<?=$_GET['namesearch']?>" type="text">
  </div>

  <?php $class = 'span6'; ?>

   <div class="col-md-12">
    <label>  <h5>ประเภท</h5></label>
    <?php 
    $listype = array('1'=>'บุคคลภายนอก' , '3'=>'บุคคลภายใน');

echo CHtml::dropDownList('type',$_GET['type'], $listype , array(
      'empty'=>'ทั้งหมด',
      'class'=>$class,
      'id'=>'typese',

    )); ?>
  </div>
  <div class="col-md-12 typehid">
    <label>  <h5>ประเภทบุคคลภายใน</h5></label>

    <?php 
    $listype_in = array('1'=>'SHIP' , '2'=>'Office');

echo CHtml::dropDownList('type_in',$_GET['type_in'], $listype_in , array(
      'empty'=>'ทั้งหมด',
      'class'=>$class,
      'id'=>'typeinse',

    )); ?>
  </div>




  <div class="col-md-12">
    <label>  <h5>แผนก</h5></label>
    <?php 
    $listdep = CHtml::listData(Department::model()->findAll(array(
    "condition"=>" active = 'y'",'order'=>'dep_title')),'id', 'dep_title');

echo CHtml::dropDownList('dep',$_GET['dep'], $listdep , array(
      'empty'=>'ทั้งหมด',
      'class'=>$class,
      'id'=>'departmentse',

    )); ?>
  </div>
  <br>

  <div class="col-md-12">
     <label>  <h5>ตำแหน่ง</h5></label>
   <?php $listpos = CHtml::listData(Position::model()->findAll(array(
    "condition"=>" active = 'y'",'order'=>'position_title')),'id', 'position_title');

echo CHtml::dropDownList('pos',$_GET['pos'], $listpos , array(
      'empty'=>'ทั้งหมด',
      'class'=>$class,
      'id'=>'positionse',
    )); ?>
  </div>

  <div class="col-md-12">
     <label>  <h5>ระดับ</h5></label>

<?php  $listbranch = CHtml::listData(Branch::model()->findAll(array(
    "condition"=>" active = 'y'",'order'=>'branch_name')),'id', 'branch_name');

echo CHtml::dropDownList('branch','', '' , array(
      'empty'=>'กรุณาเลือกตำแหน่ง',
      'class'=>$class,
      'id'=>'branchse',
    ));
     ?>
  </div>

  <div class="col-md-12">
    <button type="submit" class="btn btn-primary mt-10 btn-icon glyphicons search"><i></i> ค้นหา</button>
  </div>
</div>


</form>

<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
       <h4><b>รายชื่อสมาชิก</b></h4><br>
      <table class="table table-bordered" id="user-list">
         <thead>
          <tr>
      
            <th>Identification</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Position</th>
            <th>Branch</th>
            <th>Add</th>

           
          </tr>
        </thead>
        <tbody>
          <?php 

          if($_GET['dep'] != null || $_GET['pos'] != null || $_GET['namesearch'] != null || $_GET['type'] != null){

            $criteria = new CDbCriteria; 
            $criteria->with = array('profiles');
           
            if($_GET['dep'] != null){
              $criteria->compare('department_id',$_GET['dep']);
            }
            if($_GET['pos'] != null){
              $criteria->compare('position_id',$_GET['pos']);
            }
            if($_GET['branch'] != null){
              $criteria->compare('branch_id',$_GET['branch']);
            }

            if($_GET['type_in'] != null){
              $criteria->compare('profiles.type_employee',$_GET['type_in']);
            }
            // if($_GET['type'] != null){
            //   $criteria->compare('type_user',$_GET['type']);
            // }

             if($_GET['namesearch'] != null){

                $search = explode(" ",$_GET['namesearch']);
                foreach ($search as $key => $searchText) {

                  $criteria->condition = 'profiles.firstname LIKE :keyword OR profiles.lastname LIKE :keyword OR profiles.firstname_en LIKE :keyword OR profiles.lastname_en LIKE :keyword';

                  $criteria->params = array(':keyword'=>'%'.trim($searchText).'%');
                }

            }

            // $org_id = $_GET['orgchart_id']; 
            // $orgRoot = OrgChart::model()->findByPk($org_id);
            
            
            // if($orgRoot->department_id != null){
            // $criteria->addNotInCondition('department_id',[$orgRoot->department_id]); 
            // }

            // if($orgRoot->position_id != null){
            // $criteria->addNotInCondition('position_id',[$orgRoot->position_id]); 
            // }

            // if($orgRoot->branch_id != null){
            // $criteria->addNotInCondition('branch_id',[$orgRoot->branch_id]); 
            // }

            if(count($modelUsers_old_chk) > 0){
              $criteria->addNotInCondition('id',$modelUsers_old_chk_user); 
            }


            $user_list = Users::model()->findAll($criteria);


            if($user_list){
              foreach ($user_list as $key => $userItem) {
               ?>
               <tr>

                <td><?= $userItem->identification ?></td>
                <td><?= $userItem->profiles->firstname.' '.$userItem->profiles->lastname ?></td>
                <td><?= $userItem->email ?></td>
                <td><?= $userItem->profiles->phone ?></td>
                <td><?= $userItem->department->dep_title ?></td>
                <td><?= $userItem->position->position_title ?></td>
                <td><?= $userItem->branch->branch_name ?></td>
                  <td class="center"><button type="button" class="btn btn-success"  onclick="Adduser(<?= $userItem->id ?>);" ><i class="fa fa-plus" aria-hidden="true"></i></button></td>

              </tr>
            <?php }
          }else{?>
           <td colspan ="999">ไม่พบข้อมูล</td>
         <?php }

       }else{ ?>
        <td colspan ="999">กรุณาค้นหาข้อมูล</td>
     <?php  }
           ?>

        </tbody>

      </table>
      <hr>
 
        <h4><b>รายชื่อผู้ที่มีสิทธิ์เห็นหลักสูตร</b></h4><br>

       <table class="table table-bordered" id="user-list">
         <thead>
          <tr>
            <th>Identification</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Position</th>
            <th>Branch</th>
            <th>Delete</th>

          </tr>
        </thead>
        <tbody>
          <?php 

          $criteria = new CDbCriteria; 
          $criteria->with = array('profiles');
          if(count($modelUsers_old_chk) > 0){
            $criteria->addInCondition('id',$modelUsers_old_chk_user);
            $modeluser = Users::model()->findAll($criteria);
          }


          if($modeluser){
          foreach ($modeluser as $key => $userItem) {
           ?>
           <tr>
            <td><?= $userItem->identification ?></td>
                <td><?= $userItem->profiles->firstname.' '.$userItem->profiles->lastname ?></td>
                <td><?= $userItem->email ?></td>
                <td><?= $userItem->profiles->phone ?></td>
                <td><?= $userItem->department->dep_title ?></td>
                <td><?= $userItem->position->position_title ?></td>
                <td><?= $userItem->branch->branch_name ?></td>
              <td class="center"><button type="button" class="btn btn-danger"  onclick="Deleteuser(<?= $userItem->id ?>);" ><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
          </tr>
          <?php } 

           }else{?>
             <td colspan ="999">ไม่พบข้อมูล</td>
         <?php }
           ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<script>  

    $("#departmentse").change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("OrgChart/LoadPos"); ?>',
            data: ({
                dep_id: $(this).val()
            }),
            success: function(data) {
                $("#positionse").html(data);
            }
        });
    });




       $("#positionse").change(function() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("OrgChart/LoadBranch"); ?>',
            data: ({
                pos_id: $(this).val()
            }),
            success: function(data) {
                $("#branchse").html(data);
            }
        });
    });


$(".typehid").hide();
  
  $( "#typese" ).change(function() {
    var chkty = $( "#typese" ).val();
    if(chkty == 3){
      $(".typehid").show();
    }else{
      $(".typehid").hide();
      $("#typeinse").val("");

    }
});

  
<?php if($_GET['type_in'] != null){?>
$(".typehid").show();
<?php } ?>
</script>


        <script type="text/javascript">

          function Adduser(id) {

            var org_id = <?= $_GET['orgchart_id'] ?>;
            var course_id = <?=  $_GET['id'] ?>;
            var user_id = id;
           $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('OrgChart/AddUserTo'); ?>',
            data: ({
              user_id:user_id,
              org_id:org_id,
              course_id:course_id
            }),
            success: function(data) {
           // swal("Good job!", "ลบผู้ใช้งานสำเร็จ", "success");
           location.reload();
            }
        });
          }

               function Deleteuser(id) {

            var org_id = <?= $_GET['orgchart_id'] ?>;
            var course_id = <?=  $_GET['id'] ?>;
            var user_id = id;
           $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('OrgChart/DelteUserTo'); ?>',
            data: ({
              user_id:user_id,
              org_id:org_id,
              course_id:course_id
            }),
            success: function(data) {
           // swal("Good job!", "ลบผู้ใช้งานสำเร็จ", "success");
           location.reload();
            }
        });
          }

        </script>