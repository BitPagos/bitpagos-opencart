<?php 
class ControllerPaymentBitPagos extends Controller {
	private $error = array(); 

	
	public function install() {
       $this->db->query("CREATE TABLE `" . DB_PREFIX . "bitpagos` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`reference_id` int(11) DEFAULT NULL,
		`transaction_id` float DEFAULT NULL,
		`date` datetime DEFAULT NULL,
		PRIMARY KEY (`id`))");
   }
	public function uninstall() {
		$this->db->query("DROP TABLE `" . DB_PREFIX ."bitpagos`");
	}
	
	public function index() {
		
		$this->load->language('payment/bitpagos');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {			
			
			$this->request->post['bitpagos_default_order_status'] = $this->language->get('bitpagos_default_order_status');
			$this->request->post['bitpagos_ipn_url'] = $this->language->get('bitpagos_ipn_url');
			$this->request->post['bitpagos_post_url'] = $this->language->get('bitpagos_post_url');
			$this->model_setting_setting->editSetting('bitpagos', $this->request->post);			
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect((((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=extension/payment'));

		}

		$this->data['heading_title'] = $this->language->get('heading_title');		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');		
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_api_key'] = $this->language->get('text_api_key');
		$this->data['text_account_id'] = $this->language->get('text_account_id');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['text_order_status'] = $this->language->get('text_order_status');
		$this->data['text_ipn'] = $this->language->get('text_ipn');				
		$this->data['bitpagos_ipn_url'] = $this->language->get('bitpagos_ipn_url');
		$this->data['text_post'] = $this->language->get('text_post');
		$this->data['bitpagos_post_url'] = $this->language->get('bitpagos_post_url');

		$this->load->model('localisation/order_status');
    	$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
    	$this->data['text_status_transaction'] = $this->language->get('text_status_transaction');    	

		if ( isset( $this->error['warning'] ) ) {
			$this->data['error_warning'] = $this->error['warning'];
		} else { 
			$this->data['error_warning'] = ''; 
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/bitpagos', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/bitpagos', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['bitpagos_status'])) {
			$this->data['bitpagos_status'] = $this->request->post['bitpagos_status'];
		} else {
			$this->data['bitpagos_status'] = $this->config->get('bitpagos_status');
		}

		if (isset($this->request->post['bitpagos_order_status_id'])) {
			$this->data['bitpagos_order_status_id'] = $this->request->post['bitpagos_order_status_id'];
		} else {
			$this->data['bitpagos_order_status_id'] = $this->config->get('bitpagos_order_status_id'); 
		} 

		if (isset($this->request->post['bitpagos_api_key'])) {
			$this->data['bitpagos_api_key'] = $this->request->post['bitpagos_api_key'];
		} else {
			$this->data['bitpagos_api_key'] = $this->config->get('bitpagos_api_key');
		}

		if (isset($this->request->post['bitpagos_account_id'])) {
			$this->data['bitpagos_account_id'] = $this->request->post['bitpagos_account_id'];
		} else {
			$this->data['bitpagos_account_id'] = $this->config->get('bitpagos_account_id');
		}

		if (isset($this->request->post['bitpagos_transaction_status'])) {			
			$this->data['bitpagos_transaction_status'] = $this->request->post['bitpagos_transaction_status'];
		} else {
			$this->data['bitpagos_transaction_status'] = $this->config->get('bitpagos_transaction_status');
		}
	
		$this->template = 'payment/bitpagos.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'payment/bitpagos')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>