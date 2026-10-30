<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author hobrt.me
* @file Data.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2022
*
**/

use chriskacerguis\RestServer\RestController;

class Data extends RestController {


	public function early_checks()
	{
		$this->load->library('jwt_public');

		$valide_token = $this->jwt_public->validate_token();

		if($valide_token !== TRUE) {
			// response() ends the request; exit makes that explicit
			$this->response($valide_token[1], $valide_token[0]);
			exit;
		}
	}

	public function check_get()
	{
		return $this->response(['success' => true], 200);
	}

	/**
	 * The app logs out of this store: stop sending pushes to its device.
	 * Only clears the token when it is this device's (POST device_token), so
	 * logging out on one phone doesn't silence the admin's other phone.
	 */
	public function logout_post()
	{
		$device = trim((string) $this->input->post('device_token'));

		if ($device !== '')
			$this->m_p->up_d('admins', ['device_id' => ''], ['id' => $this->jwt_public->user_id, 'device_id' => $device]);

		return $this->response(['success' => true], 200);
	}

	public function order_post($id = FALSE) {

		if($id === FALSE)
			return $this->response(FALSE, 200);

		$order = $this->m_p->s_a('orders', array('id' => $id), 1);

		if(count($order) == 0)
			return $this->response(FALSE, 200);

		$nstatus = $this->input->post("status");

		$nstatus = filter_var($nstatus, FILTER_VALIDATE_INT);

		// only the statuses the admin knows (status() in p_helper)
		if($nstatus === FALSE || !array_key_exists($nstatus, status()))
			return $this->response(['success' => false, 'message' => 'Unknown status'], 400);

		$this->m_p->up_d('orders', ['status' => $nstatus], ['id' => $id]);

		// same as admin > order details: the customer gets the status SMS
		if ((int) $order[0]->status !== $nstatus)
			send_sms($id);

		return $this->response(['success' => true, 'status' => (string) $nstatus], 200);
	}

	public function order_get($id = FALSE)
	{
		if($id === FALSE)
			return $this->response(FALSE, 200);

		$order = $this->m_p->s_a('orders', array('id' => $id), 1);

		if(count($order) == 0)
			return $this->response(FALSE, 200);

		$order = $order[0];

		$products = json_decode($order->products, TRUE);

		$listProducts = [];

		foreach($products as $p) {

			$prd = get_info('products', $p['id'], '*');

			$options = [];

			if(isset($p['options']) && $p['options'] != null) {

				$op = json_decode($p['options'], TRUE) ?? [];

				if(count($op) > 0){
					foreach ($op as $key1 => $value1) {
						$options[] = [
							"option" => base64_decode(hex2bin($key1)),
							"value" => $value1
						];
					}
				}
			}

			$listProducts[] = [
				"title" => $prd->title,
				"image" => add_thumb($prd->images, '_m'),
				"qty" => $p['q'],
				"options" => $options
			];

		}

		$ret = [
			"name" => $order->name,
			"phone" => $order->tele,
			"status" => $order->status,
			"price" => $order->totalPrice,
			"date" => date("d/m/Y H:i", $order->date),
			"address" => $order->address,
			"city" => $order->city,
			"coupon" => $order->coupon,
			"products" => $listProducts
		];

		return $this->response($ret, 200);
	}

	public function orders_get($status = FALSE)
	{

		$page = max(0, (int) ($_GET['page'] ?? 0));

		$start = $page * 12;

		// ?q= searches the customer name, phone and order id
		$q = trim((string) ($_GET['q'] ?? ''));

		$this->db->from('orders');

		if($status !== FALSE && ctype_digit((string) $status))
			$this->db->where('status', (int) $status);

		if($q !== '') {
			$this->db->group_start()->like('name', $q)->or_like('tele', $q);
			if (ctype_digit($q))
				$this->db->or_where('id', (int) $q);
			$this->db->group_end();
		}

		$orders = $this->db->order_by('id', 'DESC')->limit(12, $start)->get()->result();

		$ret = [];

		foreach($orders as $order) {

			$products = json_decode($order->products, TRUE);

			$p = array_values($products)[0] ?? ['id' => 0];

			$img = add_thumb(get_info('products', $p['id'], "images"), '_s');

			$title = get_info('products', $p['id'], "title");

			$ret[] = [
				"id" => $order->id,
				"name" => $order->name,
				"title" => $title,
				"status" => $order->status,
				"phone" => $order->tele,
				"price" => $order->totalPrice. " ".setting('currency'),
				"img" => $img,
				"date" => date("d/m/Y H:i", $order->date),
				"city" => $order->city
			];

		}

		return $this->response($ret, 200);

	}

	public function index_get()
	{

		$o['all'] = $this->m_p->qe_r1("SELECT COUNT(o.id) AS total, COUNT(IF(o.confirmationDate != 0,1,null)) AS tc, COUNT(IF(o.status = 1,1,null)) AS tp, COUNT(IF(o.status = 5,1,null)) AS td FROM orders o LIMIT 1");

		$o['total_products'] = $this->m_p->qe_r1("SELECT COUNT(p.id) AS total FROM products p LIMIT 1")->total ?? 0;

		// orders per status, for the app's filter counts (the order list is paged)
		$o['by_status'] = [];
		foreach ($this->m_p->qe_r("SELECT status, COUNT(id) AS total FROM orders GROUP BY status") as $row)
			$o['by_status'][(string) $row->status] = (int) $row->total;

		$date = date("Y-m-d");

		$months = array();

		for ($i=0; $i < 12; $i++) {

			$w3 = [];

			$m = strtotime("-$i month");
			$startMonth = strtotime("01-".date("m-Y", $m));
			$endMonth = strtotime(date("t-m-Y 23:59:59", $m));


			$w3[] = "date < ".$endMonth;
			$w3[] = "date > ".$startMonth;

			$w = $w3;

			$wh = " WHERE ".implode(" AND ", $w);

			$sql = <<<EOD

			SELECT
			COUNT(o.id) AS total,
			CONCAT(MONTH(FROM_UNIXTIME(o.date)) ,'-', YEAR(FROM_UNIXTIME(o.date))) AS dd,
			MONTH(FROM_UNIXTIME(o.date)) AS m,
			YEAR(FROM_UNIXTIME(o.date)) AS y
			FROM
			orders o
			$wh


EOD;

			$t = $this->m_p->qe_r1($sql);

			$months[$i] = $t->total;

		}

		$allValues = array_reverse($months);

		

		$o["data"] = $allValues;

		return $this->response($o, 200);
	}
}
