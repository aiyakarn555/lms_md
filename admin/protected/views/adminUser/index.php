<?php  
$FormText = ' รายชื่อผู้ดูแลระบบ';
// $this->headerText = $FormText;
$this->breadcrumbs=array(
    'ข้อมูลผู้ดูแลระบบ'=>array('index'),
    $FormText,
);
$formNameModel = 'AdminUser';

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    $.updateGridView = function(gridID, name, value) {
        $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
        $.fn.yiiGridView.update(gridID, {data: $.param(
            $("#"+gridID+" input, #"+gridID+" .filters select")
        )});
    }
    $.appendFilter = function(name, varName) {
        var val = eval("$."+varName);
        $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
    }
    $.appendFilter("AdminUser[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);

?>
<div class="innerLR">
<?php $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'name_search','type'=>'text'),
        ),
    ));?>
    <div class="col-md-9">
        <a href="<?= Yii::app()->createUrl('adminUser/create'); ?>" type="button" class="btn btn-primary"><i
            class="fa fa-plus" aria-hidden="true"></i> 
            เพิ่มผู้ดูแลระบบ
        </a>
    </div>
    <br>
<div class="separator bottom form-inline small">
    <span class="pull-right">
        <label class="strong">แสดงแถว:</label>
        <?php echo $this->listPageShow($formNameModel);?>
    </span>
</div>
<?php  $this->widget('AGridView',array(
            'summaryText' => false, // 1st way
            'id'=>'AdminUser-grid',
                    'dataProvider'=>$model->search(),
                    //'filter'=>$model,
                    'selectableRows' => 2,
                    'htmlOptions' => array(
                        'style'=> "margin-top: -1px;",
                    ),
            'afterAjaxUpdate'=>'function(id, data){
                $.appendFilter("AdminUser[news_per_page]");
            }',
                    
            'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
                    // array(
                    //     'header' => 'รหัสบัตรประชาชน',
                    //     'type'=>'raw',
                    //     'value' => function($val){
                    //         if(empty($val->profiles->identification)){
                    //             return 'ไม่มีข้อมูล';
                    //         } else {
                    //             return $val->profiles->identification;
                    //         }
                    //     }
                    // ),
                    array(
                        'header' => 'ชื่อ - สกุล',
                        'type'=>'raw',
                        'value' => function($val){
                                $username = $val->profiles->firstname.' '.$val->profiles->lastname;
                            if(empty($username)){
                                return 'ไม่มีข้อมูล';
                            } else {
                                return $username;
                            }
                        }
                    ),
                     array(
                       'header' => 'อีเมลล์',
                       'type'=>'raw',
                       'value' =>'$data->email'
                    ),
                    // array(
                    //     'header' => 'กลุ่มผู้ดูแล',
                    //     'type'=>'raw',
                    //     'value' => function($val){
                    //             $group =  $val->group;
                    //             $jsongroup =  json_decode($group);
                    //             $groups = '';
                    //             if($jsongroup){
                    //                 foreach ($jsongroup as $key => $grp) {
                    //                     $groupUser =  PGroup::model()->find(array('condition' => 'id ='.$grp));
                    //                     $number =$key+1;
                    //                     $groups .=   $number.').'.$groupUser->group_name.'<br>';
                    //                 }
                    //                 return   $groups;
                    //             } 
                    //         }
                    // ),
                    array(
                        'header' => 'วันที่สมัคร',
                        'type'=>'raw',
                        'value' => function($val){
                                return Helpers::lib()->changeFormatDate($val->create_at,'datetime');
                        }
                    ),
                     array(
                        'header' => 'วันที่เข้าใช้งานล่าสุด',
                        'type'=>'raw',
                        'value' => function($val){
                                return Helpers::lib()->changeFormatDate($val->lastvisit_at,'datetime');
                        }
                    ),
                 //    array(
                 //     'header' => 'ฝ่าย',
                 //        'type'=>'raw',
                 //        'value' =>'$data->company->company_title'
                 //    ),
                    // array(
                    //  'header' => 'กอง',
                    //     'type'=>'raw',
                    //     'value' =>'$data->divisions->div_title'
                    // ),
                 //    array(
                 //     'header' => 'แผนก',
                 //        'type'=>'raw',
                 //        'value' =>'$data->departments->dep_title'
                 //    ),
                    // array(
                    //  'header' => 'ตำแหน่ง',
                    //     'type'=>'raw',
                    //     'value' =>'$data->position->position_title'
                    // ),
                    array(
                    'class' => 'zii.widgets.grid.CButtonColumn',
                    'htmlOptions' => array('style' => 'white-space: nowrap'),
                    'afterDelete' => 'function(link,success,data) { if (success && data) alert(data); }',
                    'template' => '{view} {update} {btn_delete}',
                    'buttons' => array(
                        'view' => array(

                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'View'),
                            'label' => '<button type="button" class="btn btn-primary"><i class="fa fa-list-alt"></i></button>',
                            'imageUrl' => false,
                        ),
                        'update' => array(
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Update'),
                            'label' => '<button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>',
                            'imageUrl' => false,
                            'url'=> function($data) {
                                return Yii::app()->controller->createUrl('adminUser/update', ['id' => $data->id]);
                            }
                        ),
                        'btn_delete' => array(
                            'options' => array(
                                'rel' => 'tooltip', 
                                'data-toggle' => 'tooltip', 
                                'title' => 'Delete',
                                'class' => 'btn_del'
                                ), 
                                'url'=> function($data) {
                                return Yii::app()->controller->createUrl('adminUser/delete', ['id' => $data->id]);
                                },
                            'label' => '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>',
                            'imageUrl' => false,
                            //'Url' => false,
                            )
                        )
                    ),
            ),
        )); ?>
<script type="text/javascript">
function toggle() {
    var ds = document.getElementById("display");
    if(ds.style.display == 'none')
        ds.style.display = 'block';
    else 
        ds.style.display = 'none';
}
function btn_del(){
    $('.btn_del').on('click',function(){
            var url = $(this).attr('href');
                swal({
                title: "คุณต้องการลบข้อมูลใช่หรือไม่",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false,
                closeOnCancel: false
                },
                function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        success: function(result){
                              $.fn.yiiGridView.update('AdminUser-grid',{ complete: function(jqXHR, status) {
                    if (status=='success'){
                        btn_del();
                    }
                }});
                            swal("ลบข้อมูลสำเร็จ!", "", "success");
                        }
                    });
                } else {
                    swal("ยกเลิก", "", "error");
                }
            });
                return false;
        });
}

    $(function(){
        btn_del();
    }); 
</script>

</div>