<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))),
); ?>

<div class="createAuthItem">

<!--	<h2>--><?php ///*echo Rights::t('core', 'Create :type', array(
//		':type'=>Rights::getAuthItemTypeName($_GET['type']),
//	));*/ ?><!--</h2>-->

    <?php
    $this->_titleheader = Rights::t('core', 'Create :type', array(
		':type'=>Rights::getAuthItemTypeName($_GET['type']),
	));
    ?>

	<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>

</div>