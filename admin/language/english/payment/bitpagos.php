<?php
// Heading
$_['heading_title']      = 'BitPagos!';

// Fields  
$_['text_api_key'] = 'API KEY:';
$_['text_account_id'] = 'Account ID:';

$_['text_payment'] = 'Payment';

$_['text_paymentwindow_overlay'] = 'Overlay';
$_['text_paymentwindow_fullscreen'] = 'Full screen';

// Image for show in admin->payment list
$_['text_bitpagos'] = '<a onclick="window.open(\'http://bitpagos.net\');"><img src="view/image/payment/BitPagos_713x200.png" alt="BitPagos" style="width: 75px; height: 34px" title="BitPagos" /></a>';

$_['text_success'] = 'Success: You have modified the BitPagos details.';

$_['text_logos'] = 'Logos';

$_['text_group'] = 'Group:';

$_['text_yes'] = 'Yes';
$_['text_no'] = 'No';

$_['text_order_status'] = 'Initial order status:';
$_['text_status']       = 'Status:';
$_['text_sort_order']   = 'Sort order:';
$_['text_status_transaction']   = 'Status for succesfull payment transaction:';
$_['text_ipn']       = 'IPN URL:';
$_['text_post']       = 'POST URL:';
$_['bitpagos_default_order_status'] = 1; // PENDING
$_['bitpagos_ipn_url'] = HTTP_CATALOG  . 'index.php?route=payment/bitpagos/bitpagos_ipn';
$_['bitpagos_post_url'] = HTTP_CATALOG . 'index.php?route=payment/bitpagos/success';
?>