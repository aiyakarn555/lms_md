<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-main">
			<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?= $label->label_usability ?></li>
		</ol>
	</nav>
</div>


<!--<section class="content" id="manual">
	<div class="container">
		<div class="row">

			<?php foreach ($usability_data as $usa) { ?>

				<div class="modal fade" id="modal-manual-detail-<?= $usa->usa_id ?>">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

								<h4 class="modal-title"><i class="fas fa-sign-in" aria-hidden="true"></i> <?php echo ($usa->usa_title); ?> </h4>
							</div>
							<div class="modal-body">
								<?php echo htmlspecialchars_decode($usa->usa_detail) ?>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
							</div>
						</div>
					</div>
				</div>

			<?php } ?>

		</div>


		<div class="row">
			<?php foreach ($usability_data as $usa) { ?>
				<div class="col-sm-4 col-md-3">
					<div class="well">
						<a data-toggle="modal" href='#modal-manual-detail-<?= $usa->usa_id ?>'>
							<div class="manual-icon"></i><i class="fas fa-info-circle fa-4x"></i></div>
							<h4><?php echo ($usa->usa_title); ?></h4>
						</a>
					</div>
				</div>

			<?php } ?>
		</div>
	</div>
</section> -->
<section class="content" id="manual">
    <div class="container">
        <div class="row">
           <!-- <form id="searchForm" class=" col-sm-4 col-md-3" action="<?php echo $this->createUrl('usability/search') ?>" style="margin-bottom: 15px; margin-top: 0;">
            <div class="input-group">
                <input type="text" class="form-control" name="text" placeholder="<?= $labelSite->label_placeholder_search ?>">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div> -->
        </form>
        <div class="col-sm-4 col-md-4">
        </div>
        <?php foreach ($usability_data as $usa) { ?>
            <div class="modal fade" id="modal-manual-detail-<?= $usa->usa_id ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                            <h4 class="modal-title"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo ($usa->usa_title); ?> </h4>
                        </div>
                        <div class="modal-body">
                            <?php echo htmlspecialchars_decode($usa->usa_detail) ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><sapn class="fa fa-times" aria-hidden="true"></sapn></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
     <?php foreach ($usability_data as $usa) { ?>
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="well">
                <a data-toggle="modal" href='#modal-manual-detail-<?= $usa->usa_id ?>'>
                    <div class="manual-icon">
                        <?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/usability/' . $usa->usa_id.'/'.$usa->usa_address)) { ?>
                            <img src="<?= Yii::app()->baseUrl; ?>/uploads/usability/<?= $usa->usa_id.'/'.$usa->usa_address; ?>" width="auto" >
                        <?php }else{ ?>
                            <div class="manual-icon"></i><i class="fas fa-info-circle fa-4x"></i></div>
                        <?php } ?>
                    </div>
                    <h4><?php echo ($usa->usa_title); ?></h4>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
</div>
</section>