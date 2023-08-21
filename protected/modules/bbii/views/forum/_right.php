<div class="col-md-4 col-lg-3">
    <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
        <div class="panel-heading panel-collapse-trigger">
            <h4 class="panel-title">ค้นหา</h4>
        </div>
        <div class="panel-body">
                    <?php $this->widget('SimpleSearchForm'); ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">หมวดหมู่</h4>
        </div>
        <div class="panel-body">
            <?php echo CHtml::dropDownList('bbii-jumpto', '', CHtml::listData(BbiiForum::getForumOptions(), 'id', 'name', 'group'),
                array('empty'=>Yii::t('BbiiModule.bbii','เว็บบอร์ด'),
                    'class'=>'form-control',
                    'onchange'=>"window.location.href='" . CHtml::normalizeUrl(array('forum')) . "/id/'+$(this).val()",
                )); ?>
        </div>
    </div>
</div>