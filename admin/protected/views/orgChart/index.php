<?php
/* @var $this OrgChartController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Org Charts',
);

?>
<style>
    body {
        margin: 0;            /* Reset default margin */
    }
    iframe {
        display: block;       /* iframes are inline by default */
        background: #000;
        border: none;         /* Reset default border */
        height: 100vh;        /* Viewport-relative units */
        width: 100%;
    }

</style>
<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> Organization chart</h4>
		</div>
		<div class="widget-body">
        <?php $type = $_GET['type'];?>
            <!--			<div class="spacer"></div>-->
            <iframe src="<?php echo $this->createUrl('/OrgChart/OrgChart2/?type='.$type.''); ?>"></iframe>
            <!--			<div>-->
                <!--				--><?php //echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?>
                <!--			</div>-->
            </div>
        </div>

    </div>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));*/ ?>
