<div class="widget-head">
    <h4 class="heading glyphicons search">
        <i></i> High Search:
    </h4>
</div>
<?php 
    $gens = !empty($search['generation']) ? $search['generation'] : '';
    $name = !empty($search['search']) ? $search['search'] : '';
    $course_id = !empty($search['course_id']) ? implode(',', $search['course_id']) : '';
    $period_start = !empty($search['period_start']) ? $search['period_start'] : '';
    $period_end = !empty($search['period_end']) ? $search['period_end'] : '';

    $form = $this->beginWidget('CActiveForm',
        array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'htmlOptions' => array(
                'class'=>'search_box'
            ),
        )
    ); 
?>
    <div class="widget-body">
        <dl class="dl-horizontal">
            <div class="form-group">
                <dt><label>เลือกรุ่น : </label></dt>
                <dd>
                    <select name="Passcours[generation]">
                        <option value="">--- กรุณาเลือกรุ่น ---</option>
                        <?php
                            $Generation = Generation::model()->findAll();
                            if($Generation) {
                                foreach($Generation as $gen) {
                                    $select = '';
                                    if($gen->id_gen == $gens){
                                        $select = 'selected';
                                    }
                                    ?>
                                    <option <?= $select ?> value="<?= $gen->id_gen ?>"><?= $gen->name ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                <option value="">ยังไม่มีรุ่นการเรียน</option>
                                <?php
                            }
                        ?>
                    </select>
                </dd>
            </div>
            <div class="form-group">
                <dt><label>เลือกหลักสูตร : </label></dt>
                <dd>
                    <!--<select name="Passcours[course_id][]" multiple style="width: 50%; height: 150px;" id="courseSelectMulti">-->
                    <select name="Passcours[course_id][]"  style="width: 50%;" id="courseSelectMulti">
                        <option  value="">กรุณาเลือกหลักสูตร</option>
                    <?php
                        $CourseOnline = CourseOnline::model()->findAll(array(
                            'condition' => 'active = "y" and cate_id = 36',
                            'order' => 'cate_id ASC, cate_course ASC, course_id ASC'
                            )
                        );
                        $curr_supper_cate = null;
                        $curr_course_cate = null;
                        if($CourseOnline) {
                            foreach($CourseOnline as $Course) {
                                if($curr_course_cate != $Course->cate_course && $curr_course_cate != null) {
                                        ?>
                                        </optgroup>
                                        <?php
                                    }
                                if($curr_supper_cate != $Course->cate_id && $curr_supper_cate != null) {
                                    ?>
                                    </optgroup>
                                    <?php
                                }
                                if($curr_supper_cate != $Course->cate_id) {
                                    $curr_supper_cate = $Course->cate_id;
                                    ?>
                                    <optgroup label="<?=  $Course->cates->cate_title ?>">
                                    <?php
                                }
                                if($Course->cate_course != null && $curr_course_cate != $Course->cate_course) {
                                    $curr_course_cate = $Course->cate_course;
                                    ?>
                                    <optgroup label="-- <?=  $Course->category->name ?>" style="margin-left: 14px; ">
                                    <?php
                                }
                                $select = '';
                                    if($Course->course_id == $course_id){
                                        $select = 'selected';
                                    }
                                ?>
                                <option <?= $select ?> value="<?= $Course->course_id ?>"><?= $Course->course_title ?></option>
                                <?php
                            }
                        } else {
                            ?>
                            <option value="">ยังไม่มีบทเรียน</option>
                            <?php
                        }
                    ?>
                    </select>
                </dd>
            </div>
            <div class="form-group">
                <dt><label>ค้นหา : </label></dt>
                <dd>
                    <div>
                        <input name="Passcours[search]" type="text" value="<?=$name?>" placeholder="ค้นหาด้วยชื่อ, สกุล หรือบัตรประชาชน">
                    </div>
                    <span style="font-size: 0.9em; color: red;">(สามารถค้นหาด้วย ชื่อ, สกุล หรือบัตรประชาชน)</span>
                </dd>
            </div>
            <div class="form-group">
                <dt><label>ประเภทสมาชิก : </label></dt>
                <dd>
                    <select name="Passcours[memtype]">
                        <option value="">--- เลือกประเภทสมาชิก ---</option>
                        <?php
                            $memtype = TypeUser::model()->findAll();
                            if($memtype) {
                                foreach($memtype as $type) {
                                    $select = '';
                                    if($type->id == $name){
                                        $select = 'selected';
                                    }
                                    ?>
                                    <option <?= $select ?> value="<?= $type->id ?>"><?= $type->name ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                <option value="">ยังไม่มีรุ่นการเรียน</option>
                                <?php
                            }
                        ?>
                    </select>
                </dd>
            </div>

            <div class="form-group">
                <dt><label>วันที่ผ่านการสอบ 60% เริ่มต้น<br> - วันที่ผ่านการสอบ 60% สิ้นสุด : </label></dt>
                <dd>
                    <input name="Passcours[period_start]" type="text" class="form-control" value="<?=$period_start?>" placeholder="เลือกช่วงเวลาเริ่ม" id="passcoursStartDateBtn"> : <input name="Passcours[period_end]" type="text" class="form-control"  value="<?=$period_end?>" placeholder="เลือกช่วงเวลาสิ้นสุด" id="passcoursEndDateBtn">
                </dd>
            </div>
            <div class="form-group">
                <dt></dt>
                <dd><button type="submit" class="btn btn-primary btn-icon glyphicons search"><i></i> Search</button></dd>
            </div>
        </dl>
    </div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function() {
        // $('#courseSelectMulti').select2();
        endDate();
        startDate();
    });
    function startDate() {
        $('#passcoursStartDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function() {
                $("#passcoursEndDateBtn").datepicker("option","minDate", this.value);
            },
        });
    }
    function endDate() {
        $('#passcoursEndDateBtn').datepicker({
            dateFormat:'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true,
        });
    }
</script>