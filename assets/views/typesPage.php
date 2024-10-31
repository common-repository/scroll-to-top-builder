<?php
namespace ystp;
global $YSTP_TYPES;
$types = Scroll::getScrollTypes();
?>
<div class="ystp-bootstrap-wrapper ystp-types-page">
	<div class="row">
		<div class="col-xs-6">
			<h2><?php _e('Choose Scroll type', YSTP_TEXT_DOMAIN); ?></h2>
		</div>
	</div>
	<div class="ystp-wrapper">
		<?php foreach ($types as $typeObj): ?>
			<?php $type = $typeObj->getName(); ?>
			<?php
				$isAvaliable = $typeObj->isAvailable();
				if (!$isAvaliable) {
					continue;
				}
			?>
		<a class="create-scroll-link scrolls-div ystp-<?php echo $type; ?>-div" href="<?php echo AdminHelper::buildCreateCountdownUrl($typeObj); ?>">
			<div class="ystp-scroll-type-wrapper">
				<div class="ystp-type-icon ystp-type-div ystp-<?php echo $type; ?>-type"></div>
				<div class="ystp-type-view-footer">
						<span class="ystp-icon-title"><?php echo $YSTP_TYPES['titles'][$type]; ?></span>
				</div>
			</div>
		</a>
		<?php endforeach; ?>
	</div>
</div>
