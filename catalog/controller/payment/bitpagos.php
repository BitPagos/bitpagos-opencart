<?php
/* BitPagos payment
 *
 * @version 1.0
 * @date 10/12/2013
 * @author DevSar
 * @more info available on www.devsar.com
 */

class ControllerPaymentBitpagos extends Controller {
	
	protected function index() {
		
		$this->language->load('payment/bitpagos');
 
		$this->data['button_confirm'] = $this->language->get('button_confirm'); 
		$this->data['action'] = $this->url->link('payment/bitpagos/pay');

		$this->load->model('checkout/order');
 
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
 		
		$this->data['currency'] = $order_info['currency_code'];		
		$this->data['order_id'] = $order_info['order_id'];

		$allowed_cur = array('USD');
		$currency = $_SESSION['currency'];
		if ( !in_array($currency, $allowed_cur)) {
			$currency = 'USD';
		}

		$this->template = 'default/template/payment/bitpagos.tpl';

		$this->data['htmlProducts'] = '';

		$this->children = array(
			'common/header',
			'common/footer',
		);
 
		$this->response->setOutput($this->render());
 		
	}

	public function success() {
		$this->redirect('index.php?route=checkout/success');
	}

	public function complete_order($reference_id) {
		
		$this->load->model('checkout/order');
		if ( !$this->config->get('bitpagos_transaction_status')) {
			die('Bitpagos not properly configured');
		}
		
		$order_info = $this->model_checkout_order->getOrder($reference_id);
		if ( !$order_info ) {
			die( 'Order not found!!' );
		}

		$complete_status_id = $this->config->get('bitpagos_transaction_status');
		
		$this->model_checkout_order->update( $reference_id, $complete_status_id );

		return $order_info;
		
	}

	public function bitpagos_ipn(){
		
		file_put_contents('/tmp/ipn.log', "############## OPEN-CART IPN ##############");
  		file_put_contents('/tmp/ipn.log', print_r($_POST, TRUE));

		if (!isset( $this->request->post['reference_id'] ) || 
			!isset( $this->request->post['transaction_id'] ) ) {
			header("HTTP/1.1 500 BAD_PARAMETERS");
			return false;
		}

		$transaction_id = filter_var($this->request->post['transaction_id'], FILTER_SANITIZE_STRING);

		$url = 'https://www.bitpagos.net/api/v1/transaction/' . $transaction_id . '/?api_key=' . $this->config->get('bitpagos_api_key') . '&format=json';	
    	$cbp = curl_init( $url );
    	curl_setopt($cbp, CURLOPT_RETURNTRANSFER, TRUE);
    	$response = curl_exec( $cbp );
    	curl_close( $cbp );
		$response = json_decode($response);
		
		file_put_contents('/tmp/nico.log', print_r($this->request->post));

		$reference_id = (int)$this->request->post['reference_id'];

		if ( $reference_id !== (int)$response->reference_id ) {
			header("HTTP/1.1 500 BAD_REFERENCE_ID");
			return false;
		}

		if ( $response->status == 'PA' || $response->status == 'CO' ) {
			$order_info = $this->complete_order($reference_id);
			$complete_status_id = $this->config->get('bitpagos_transaction_status');
			header("HTTP/1.1 200 OK");
			return true;
		}
		
		header("HTTP/1.1 500 ORDER_NOT_UPDATED");
		return false;
	} 

	public function pay() {		

		if (isset($this->request->post['order_id'])) {
			$reference_id = (int)$this->request->post['order_id'];
		} else {
			die('Illegal Access');
		}

		$this->data['error_warning'] = ''; 

		$account_id = $this->config->get('bitpagos_account_id');
		$status = $this->config->get('bitpagos_status');

		if (empty( $account_id ) || !$status ) {
			
			$this->data['error_warning'] = 'BitPagos not configured properly';
		
		} else {

			$this->load->model('checkout/order');

			// Confirm the order ( status = pending )					
			$default_order_status = $this->config->get('bitpagos_default_order_status');

			$this->model_checkout_order->confirm($reference_id, $default_order_status);
			$order_info = $this->model_checkout_order->getOrder($reference_id);

			if ($order_info) {

				$product_name = array();
				foreach( $this->cart->getProducts() as $product )  {
					$product_name[] = $product['name'];
				}
				$this->data['store_name'] = $order_info['store_name'];
				$this->data['reference_id'] = $reference_id;
				$this->data['description'] = join(', ', $product_name);
				$this->data['account_id'] = $account_id;
				$this->data['amount'] = $order_info['total'];
				$this->data['currency'] = $order_info['currency_code'];

			} else {
				$this->data['error_warning'] = 'No Order Found!';
			}

		}

		$this->data['action'] = $this->config->get('bitpagos_post_url');
		$this->data['bitpagos_ipn'] = $this->config->get('bitpagos_ipn_url');

		$this->template = 'default/template/payment/bitpagos_btn.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		$this->response->setOutput($this->render());
	}
}
?> 
