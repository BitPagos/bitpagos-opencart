<form action="<?php echo $action; ?>" id="form-bitpagos" method="post">
	<input type="hidden" name="order_id" value="<?php echo $order_id ?>">
    <?php echo $htmlProducts; ?>
	<div class="buttons">
		<div class="right">
		    <input type="submit" value="<?php echo $button_confirm; ?>" class="button" id="button-confirm" />
		</div>
	</div>
</form>