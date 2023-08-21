<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i
                        class="fa fa-fw fa-book"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">หลักสูตร</h3>

                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมหลักสูตร การทำงานของ Product ของ
                    Brother</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <?php
            $this->breadcrumbs = array(
                'สั่งซื้อหลักสูตรอบรมออนไลน์' => array('index', 'id' => $model->cate_id),
                $model->course_title,
            );

            $this->widget('ADetailView', array(
                'data' => $model,
                'attributes' => array(
                    array('name' => '-', 'value' => 'รายละเอียด'),
                    array(
                        'name' => 'course_picture',
                        'type' => 'raw',
                        'value' => ($model->course_picture) ? CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->course_picture), $model->course_picture, array(
                            "class" => "thumbnail"
                        )) : '-',
                    ),
                    'course_number',
                    array(
                        'name' => 'course_type',
                        'value' => $model->CourseType
                    ),
                    array(
                        'name' => 'course_lecturer',
                        'value' => $model->teachers->teacher_name,
                    ),
                    'course_title',
                    'course_short_title',
                    array('name' => 'course_detail', 'type' => 'raw'),
                    array(
                        'name' => 'course_price',
                        'value' => number_format($model->course_price) . ' บาท',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
