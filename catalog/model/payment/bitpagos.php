<?php
/* Moneybrace online payment
 *
 * @version 1.0
 * @date 11/03/2012
 * @author george zheng <xinhaozheng@gmail.com>
 * @more info available on mzcart.com
 */
class ModelPaymentBitpagos extends Model {
  	public function getMethod($address, $total) {
		
		$this->load->language('payment/bitpagos');
 
		// $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('moneybrace_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
 
		// if ($this->config->get('moneybrace_total') > $total) {
		// 	$status = false;
		// } elseif (!$this->config->get('moneybrace_geo_zone_id')) {
		// 	$status = true;
		// } elseif ($query->num_rows) {
		// 	$status = true;
		// } else {
		// 	$status = false;
		// }
 
		$currencies = array(
			'AUD',
			'CAD',
			'EUR',
			'GBP',
			'JPY',
			'USD',
			'NZD',
			'CHF',
			'HKD',
			'SGD',
			'SEK',
			'DKK',
			'PLN',
			'NOK',
			'HUF',
			'CZK',
			'ILS',
			'MXN',
			'MYR',
			'BRL',
			'PHP',
			'TWD',
			'THB',
			'CNY',
			'TRY'
		);
 
		// if (!in_array(strtoupper($this->currency->getCode()), $currencies)) {
		// 	$status = false;
		// }
 
		$method_data = array();

		$status = true;
 
		if ($status) {
      		$method_data = array(
        		'code'       => 'bitpagos',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('bitpagos_sort_order')
      		);
    	}
 
    	return $method_data;
  	}
}
?> 
