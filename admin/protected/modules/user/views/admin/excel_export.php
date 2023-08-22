 <?php
 $strExcelFileName = "Export-Data-" . date('Ymd-His') . ".xls";
      header("Content-Type: application/x-msexcel; name=\"" . $strExcelFileName . "\"");
      header("Content-Disposition: inline; filename=\"" . $strExcelFileName . "\"");
      header('Content-Type: text/plain; charset=UTF-8');
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Pragma:no-cache");
?>
    <?php
    // if((($model->date_start != '') && ($model->date_end != '')) || (($model->date_start_lastuse != '') && ($model->date_end_lastuse != '')) || ($model->generation != '') || ($model->identification != '') || ($model->nameSearch != '') || ($model->department != '') ||  ($model->email != '') || ($model->status_login != '')){
    if (!empty($_GET['ReportUser'])){ 
       $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id 
        WHERE del_status = 0 AND tbl_users.superuser = 0 ";//INNER JOIN tbl_type_user ON tbl_type_user.id = tbl_users.department_id 
        
            if(($model->date_start != '') && ($model->date_end != '')){
                $startDate = date("Y-m-d H:i:s", strtotime($model->date_start));
                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
                    if($startDate == $endDate){
                        $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end));
                    }
                $sqlUser .= " AND tbl_users.create_at between '".$startDate."' and '".$endDate."' ";
                
            }
            if(($model->date_start_lastuse != '') && ($model->date_end_lastuse != '')){
                $startDate = date("Y-m-d H:i:s", strtotime($model->date_start_lastuse));
                $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end_lastuse));
                    if($startDate == $endDate){
                        $endDate = date("Y-m-d 23:59:59", strtotime($model->date_end_lastuse));
                    }
                $sqlUser .= " AND tbl_users.lastvisit_at between '".$startDate."' and '".$endDate."' ";
                
            }
            // if($model->generation !='') {
            //     $sqlUser .= " AND tbl_profiles.generation = '".$model->generation."' ";
                
            // }

            //type_user
            if($model->type_user !='') {
                if($model->type_user == 1){ //General
                    $sqlUser .= " AND tbl_users.type_register != '3' ";
                }else if($model->type_user == 2){ //Staff
                    $sqlUser .= " AND tbl_users.type_register = '3' ";

                }
                // $sqlUser .= " AND tbl_profiles.type_user LIKE '".$model->type_user."' ";
            }
            
            // if($model->department !='') {
            //     $sqlUser .= " AND tbl_users.department_id = '".$model->department."' ";   
            // }
            if ($model->employee_type != ''){
                $sqlUser .= " AND tbl_profiles.type_employee = " . $model->employee_type;
            }
            // if($model->occupation !='') {
            //     $sqlUser .= " AND tbl_profiles.occupation LIKE '".$model->occupation."' ";
                
            // }
            if($model->nameSearch !='') {
                $search = explode(" ",$model->nameSearch);
                foreach ($search as $key => $searchText) {
                    $sqlUser .= " AND (tbl_profiles.firstname LIKE '%". trim($searchText) ."%' OR tbl_profiles.lastname LIKE '%" . trim($searchText) . "%')";
                }
            }
            if($model->email !='') {
                $sqlUser .= " AND tbl_users.email LIKE '%".$model->email."%' ";
            }
            if($model->identification !='') {
                $sqlUser .= " AND tbl_users.username LIKE '%".$model->identification."%' ";
            }
            if($model->status_login !='') {
                if($model->status_login == 0){
                    $sqlUser .= " AND tbl_users.lastvisit_at = 0";
                } else {
                    $sqlUser .= " AND tbl_users.lastvisit_at > 0";
                }
            }

            //Divsion
            if(!empty($model->division_id)){
                $divisionInarray =  implode(",",$model->division_id);
                $sqlUser .= " and tbl_users.division_id IN ( ".$divisionInarray." )";
            }
            //Department
            if(!empty($model->department)){
                $departmentInarray =  implode(",",$model->department);
                $sqlUser .= " and tbl_users.department_id IN ( ".$departmentInarray." )";
            }
            //Station
            // if(!empty($model->station)){
            //     $stationInarray =  implode(",",$model->station);
            //     $sqlUser .= " and tbl_users.station_id IN ( ".$stationInarray." )";
            // }
            $sqlUser .= " ORDER BY tbl_profiles.firstname_en ASC";
        // $item_count = Yii::app()->db->createCommand($sqlUser)->queryScalar();
        $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();
        $dataProvider=new CArrayDataProvider($modelAll, array(
                'pagination'=>array(
                  'pageSize'=>false
                ),
          ));
        $model = $dataProvider->getData();
        $model2 = $modelAll;
//        $this->widget('CLinkPager',array(
//            'pages'=>$dataProvider->pagination)
//        );
        // $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
        if (!empty($model)) {
            ?>


<!--<div class="div-table2 hidden">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> รายชื่อสมาชิก
            </h4>
        </div>
        <div class="widget-body">-->
            <!-- Table -->
            <table class="table table-bordered table-striped">
                <!-- Table heading -->
                <thead>
                <tr>
                    <th class="center">ลำดับ</th>
                    <th class="center">ประเภทพนักงาน</th>
                    <th class="center">ชื่อ - นามสกุล</th>
                    <th class="center">แผนก</th>
                    <th class="center">ตำแหน่ง</th>
                    <!-- <th class="center">บัตรประชาชน</th> -->
                    <!-- <th class="center">เบอร์</th> -->
                    <th class="center">เบอร์โทรศัพท์</th>
                    <th class="center">อีเมลล์</th>
                    <th class="center">สถานะการใช้งาน</th>
                    <!-- <th class="center">ประเภทสมาชิก</th> -->
                    <!-- <th class="center">จังหวัด</th> -->
                    <!-- <th class="center">รุ่น</th> -->
                    <th class="center">วันที่สมัคร</th>
                    <th class="center">วันที่ใช้งาน</th>
                </tr>
                </thead>
                <!-- // Table heading END -->
                <!-- Table body -->
                <tbody>
            <?php 
            $i = 1;
                foreach ($model2 as $key => $userItem) {
                    if($userItem[sex] == 'Male'){
                        $sex = 'ชาย';
                    } else if($userItem[sex] == 'Female'){
                        $sex = 'หญิง';
                    }

                    if($userItem[status]==0){
                        $status = "ระงับการใช้งาน";
                    }else{
                        $status = "เปิดการใช้งาน";
                    }
                    $type = TypeUser::model()->findByPk($userItem[type_user]);
                    $typeemployee = Profile::model()->findByPk($userItem['user_id']);
                    if ($typeemployee['type_employee'] == 1){
                        $typeemp = "คนประจำเรือ";
                    }
                    if ($typeemployee['type_employee'] == 2){
                        $typeemp = "พนักงานออฟฟิศ";
                    }
                    $Dep = Department::model()->findByPk($userItem['department_id']);
                    $Pos = Position::model()->findByPk($userItem['position_id']);
            ?>
                <!-- Table row -->
                <tr>
                    <td class="center"><?= $i ?></td>
                    <td class="center"><?= $typeemp ?></td>
                    <td class="center"><?= $userItem[firstname_en] . " " . $userItem[lastname_en] ?></td>
                    <td class="center"><?= ($Dep->dep_title) ? $Dep->dep_title : '-'; ?></td>
                    <td class="center"><?= ($Pos->position_title) ? $Pos->position_title : '-'; ?></td>
                    <td class="center"><?= $userItem[tel] ?></td>
                    <td class="center"><?= $userItem[email] ?></td>
                    <td class="center"><?= $status ?></td>
                    <!-- <td class="center"><?= $type->name ?></td> -->
                    <!-- <td class="center"><?= Province::getNameProvince($userItem[province]) ?></td> -->
                    <!-- <td class="center"><?= Generation::getNameGen($userItem[generation]) ?></td> -->
                    <td class="center"><?= Helpers::changeFormatDate($userItem[create_at],'datetime'); ?></td>
                    <?php 
                    if ($userItem[lastvisit_at] == 0) {
                        $lastvisit_at = 'ยังไม่เข้าสู่ระบบ';
                    } else {
                        $lastvisit_at = $userItem[lastvisit_at];
                    }
                    ?>
                    <td class="center"><?= ($lastvisit_at == 'ยังไม่เข้าสู่ระบบ') ? $lastvisit_at : Helpers::changeFormatDate($lastvisit_at,'datetime'); ?></td>
                </tr>
                <!-- // Table row END -->
            <?php
            $i++;
            }
            ?>
                </tbody>
            <!-- // Table body END -->
            </table>
            <!-- // Table END -->
<!--        </div>      
    </div>
</div>-->

        <?php
        }else{
        ?>

        <?php var_dump("adadasd"); ?>
<!--            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                </div>
                <div class="widget-body">
                     Table 
                    <h3 style="color: red;">ไม่พบข้อมูล</h3>
                     // Table END 
                </div>
            </div>-->
    <?php
        }
    }else{
        ?>

        <?php var_dump("11231314"); ?>
<!--        <div class="widget" style="margin-top: -1px;">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines">
                    <i></i> </h4>
            </div>
            <div class="widget-body">
                 Table 
                <h3 class="text-success">กรุณาป้อนข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3>
                 // Table END 
            </div>
        </div>-->
        <?php
    }
    ?>