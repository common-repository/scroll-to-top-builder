<?php
use ystp\DisplayConditionBuilder;

$savedData = $typeObj->getOptionValue('ystp-display-settings');
$obj = new DisplayConditionBuilder();
$obj->setSavedData($savedData);
?>

<div class="ystp-bootstrap-wrapper">
	<?php echo $obj->render(); ?>
</div>