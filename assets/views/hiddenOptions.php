<?php
$type = $typeObj->getOptionValue('ystp-type');

if(empty($type)) {
	$type = @$_GET['ystp_type'];
}

if(empty($type)) {
    $type = YSTP_DEFAULT_TYPE;
}
?>
<input type="hidden" name="ystp-type" value="<?php echo esc_attr($type); ?>">