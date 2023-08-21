<?php
// For admins, add link to delete post
$isAdmin = !Yii::app()->user->isGuest && Yii::app()->user->isAdmin();
?>
<div class="post">
    <div class="header">
        <?php echo Yii::app()->controller->module->format_date($data->created, 'long'); ?> by <?php echo CHtml::link(CHtml::encode($data->author->name), $data->author->url); ?>
        <?php if($data->editor) echo ' (Modified: '. Yii::app()->controller->module->format_date($data->updated, 'long') .' by '. CHtml::link(CHtml::encode($data->editor->name), $data->editor->url) .')'; ?>
    </div>
    <div class="content">
        <?php
            $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
                echo $data->content;
            $this->endWidget();

            if($data->author->signature)
            {
                echo '<br />---<br />';
                $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
                    echo $data->author->signature;
                $this->endWidget();
            }
        ?>
    </div>
    <?php if($isAdmin || Yii::app()->user->id == $data->author_id): ?>
        <div class="footer">
            <?php echo CHtml::link(CHtml::image(Yii::app()->controller->module->registerImage("postbit_edit.gif")), array('/forum/post/update', 'id'=>$data->id)); ?>
        </div>
    <?php endif; ?>
</div>
