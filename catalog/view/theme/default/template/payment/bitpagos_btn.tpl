<?php echo $header; ?>

<?php if ( $error_warning ) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
<?php }  else { ?>
	<div style="text-align: center">
		<form action="<?php echo $action ?>" method="post">
			<p>Thank you for your order, please click the button below to pay with BitPagos.</p>
			<script src='https://www.bitpagos.net/public/js/partner/m.js' 
					class='bp-partner-button' 
					data-role='checkout' 
					data-account-id="<?php echo $account_id ?>" 
					data-reference-id='<?php echo $reference_id?>' 
					data-title='<?php echo $store_name ?>' 
					data-amount='<?php echo $amount ?>' 
					data-currency='<?php echo $currency ?>' 
					data-description='<?php echo $description ?>' 
					data-ipn='<?php echo $bitpagos_ipn ?>'></script>
		</form>
	</div> 
<?php } ?>

<?php echo $footer; ?>