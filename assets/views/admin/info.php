<?php
$postId = @$_GET['post'];
?>
<div class="ystp-bootstrap-wrapper">
    <div>
	    <?php if(YSTP_PKG_VERSION == YSTP_FREE_VERSION) {
		    echo \ystp\AdminHelper::upgradeButton();
	    }?>
    </div>
	<label>
		<?php _e('Current version'); ?>
	</label>
	<p class="current-version-text" style="color: #3474ff;"><?php echo YSTP_VERSION_TEXT; ?></p>
	<label>
		<?php _e('Last update date'); ?>
	</label>
	<p style="color: #11ca79;"><?php echo YSTP_LAST_UPDATE_DATE; ?></p>
	<label>
		<?php _e('Next update date'); ?>
	</label>
	<p style="color: #efc150;"><?php echo YSTP_NEXT_UPDATE_DATE; ?></p>
</div>