<?php
if(!defined('BASEPATH')) exit();
/**
* @author hobrt.me
* @file M_p.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2022
*
**/
require_once APPPATH . 'libraries/Hb_migrator.php';

class M_p extends CI_Model
{
	public function s_a($tab, $wer=array(), $limit=10, $start=0,$arr = array('*'),$order = 'id', $ord_t = "DESC")
	{
		$se = implode(',', $arr);
		$this->db->select($se);
		$this->db->from($tab);
		$this->db->where($wer);
		if($limit !== FALSE)
			$this->db->limit($limit,$start);
		$this->db->order_by($order,$ord_t);
		$ret = $this->db->get();
		//echo $this->db->last_query();
		return $ret->result();
	}
	public function s_cart($tab, $wer=array(), $limit=10, $start=0,$arr = array('*'),$order = 'id', $ord_t = "DESC")
	{
		$se = implode(',', $arr);
		$this->db->select($se);
		$this->db->from($tab);
		$this->db->where_in("id", $wer);
		$this->db->order_by($order,$ord_t);
		$ret = $this->db->get();
		//echo $this->db->last_query();
		return $ret->result();
	}
	public function get_html_codes($page)
	{
		$this->db->select("*");
		$this->db->from("html_codes");
		$this->db->where("FIND_IN_SET($page, pages)");
		$this->db->order_by("position");
		$ret = $this->db->get();
		//echo $this->db->last_query();
		return $ret->result();
	}
	
	public function get_delivered_orders_total_price()
{
    $this->db->select_sum('totalPrice')->from('orders');
    $this->db->where('status', 5);

    $result = $this->db->get()->row();
    
    return ($result) ? $result->totalPrice : 0;
}

public function get_delivered_orders_count()
{
    $this->db->from('orders');
    $this->db->where('status', 5);

    return $this->db->count_all_results();
}

	public function ins($tab,$arr)
	{
		$sql = $this->db->insert_string($tab,$arr);
		$ins = $this->db->query($sql);
		if ($ins)
			return $this->db->insert_id();
		else
			return FALSE;
	}
	public function up_d($tab,$arr,$wer='1 = 1')
	{
		$sql = $this->db->update_string($tab,$arr,$wer);
		$up = $this->db->query($sql);
		if ($up)
			return TRUE;
		else
			return FALSE;
	}

	public function se_a($tab ,$arr = array('*'))
	{
		$se = implode(',', $arr);
		$this->db->select($se);
		$this->db->from($tab);
		$ret = $this->db->get();
		return $ret->result();
	}

	public function get_info($tab,$id=false,$se = "*")
	{
		$this->db->select($se);
		$this->db->from($tab);
		if($id)
			$this->db->where('id',$id);
		$qr = $this->db->get();
		if($se == "*")
			return $qr->row_array();
		else
		{
			$res = $qr->result();
			foreach ($res as $key) {
				$ret = $key->$se;
			}
			return $ret ?? "-";
		}
	}

	public function sel($tab,$wer=array())
	{
		$this->db->select('*');
		$this->db->from($tab);
		$this->db->where($wer);
		$this->db->order_by("id", "DESC");
		$ret = $this->db->get();
		return $ret->result();
	}
	public function get_num($tab,$wer=array())
	{
		$this->db->select('COUNT(id) AS total');
		$this->db->from($tab);
		$this->db->where($wer);
		$res = $this->db->get();
		return $res->row()->total ?? 0;
	}
	public function delete($tab,$wer = array())
	{
		// never wipe a whole table because a condition is missing
		if(empty($wer))
			return FALSE;

		$query = $this->db->delete($tab, $wer);
		if($query)
			return TRUE;
	}

	public function getTotal($table, $field, $w = array()) {

		$this->db->select("SUM($field) AS total, COUNT(id) AS c");
		$this->db->from($table);
		$this->db->where($w);
		$this->db->limit(1);
		$ret = $this->db->get();
		return $ret->row_array();

	}

	public function login($username ,$password)
	{
		$username = is_string($username) ? trim($username) : "";
		$password = is_string($password) ? $password : "";

		$ip = $this->input->ip_address();

		// Throttle per client first so a stranger can't lock the real admin out,
		// then a higher per-account ceiling against distributed guessing.
		$attempts = $this->get_num("login_attempts", array("username" => $username, 'time > ' => time() - 15*60));

		if(!rate_limit("login_ip_".$ip, 20, 15*60)
			|| !rate_limit("login_user_ip_".strtolower($username)."_".$ip, 5, 5*60)
			|| $attempts >= 50) {
			return "Too many failed attempts, please wait a few minutes and try again .";
		}

		$this->db->select("*");
		$this->db->from("admins");
		$this->db->where(array("username" => $username));
		$this->db->limit(1);
		$user = $this->db->get()->row();

		if(!is_null($user))
		{
			
			if( Hb_migrator::password_matches($password, $user->password) ) {

				// 2019 sha1 hashes (and outdated bcrypt costs) are replaced on login
				if (Hb_migrator::is_legacy_hash($user->password) || password_needs_rehash($user->password, PASSWORD_DEFAULT))
					$this->up_d("admins", array("password" => password_hash($password, PASSWORD_DEFAULT)), array("id" => $user->id));

				return $user;

			}else {

				$this->ins("login_attempts", ["username" => $username, 'time' => time()]);


			}

			return "password and username are not match .";
		}
		else{

			$this->ins("login_attempts", ["username" => $username, 'time' => time()]);

			return "password and username are not match .";
		}
	}

	/**
	 * Keeps only the keys of $data that are real columns of $table, minus $except.
	 * Use it before inserting/updating with request data (mass assignment).
	 */
	public function only_columns($table, $data, $except = array('id'))
	{
		$columns = array_diff($this->db->list_fields($table), $except);
		return array_intersect_key((array) $data, array_flip($columns));
	}

	public function escape($i)
	{
		return $this->db->escape($i);
	}


	public function escape_like($i)
	{
		return $this->db->escape_like_str($i);
	}

	public function qe_r($q)
	{
		$e = $this->db->query($q);
		return $e->result();
	}
	
	public function qe_r1($q)
	{
		$e = $this->db->query($q);

		return $e->row();
	}


	function totalSales($id)
	{
		$id = (int) $id;
		$all = $this->qe_r("SELECT * FROM orders WHERE products LIKE '%\"".$id."\"%' ");
		//echo $this->db->last_query();
		$totalSales = 0;
		foreach ($all as $key) {
			$i = json_decode($key->products, TRUE);

			foreach ($i as $k) {
				if($k['id'] == $id)
					$totalSales += (int) $k["q"];
			}
		}
		return $totalSales;
	}

	function select_where_in($tab ,$select="*", $column = "id", $where_in= "1,2,3")
	{
		$where_in = explode(",", $where_in);
		$this->db->select($select);
		$this->db->from($tab);
		$this->db->where_in($column, $where_in);
		$ret = $this->db->get();
		return $ret->result();
	}

	public function searchProducts($searchQuery, $not_in) {
        $this->db->select('*');
		$this->db->from('products');
		$this->db->group_start();
		$this->db->like('title', (string) $searchQuery);
		$this->db->or_where('id', (int) $searchQuery);
		$this->db->group_end();
		// products already in the collection (none yet when it is new)
		$not_in = array_filter(array_map('intval', (array) $not_in));
		if ($not_in)
			$this->db->where_not_in('id', $not_in);
		$this->db->limit(5);
		$query = $this->db->get();
		
		return $query->result_array();
    }

	public function generate_slug($table, $from_string = "any text") {
        
        // Convert the string to a slug
        $slug = url_title($from_string, '-', true);
        
        // Check if the generated slug already exists in the specified table
        $is_unique = false;
        $original_slug = $slug;
        $counter = 1;
        
        while (!$is_unique) {
            $query = $this->db->get_where($table, ['slug' => $slug]);
            
            if ($query->num_rows() === 0) {
                $is_unique = true;
            } else {
                $slug = $original_slug . '-' . $counter;
                $counter++;
            }
        }
        
        return $slug;
    }

	public function findOneById($table, $id) {
        $query = $this->db->get_where($table, ['id' => $id]);
        $item = $query->row();
		return $item;
    }

	public function findOneBySlug($table, $slug) {
        $query = $this->db->get_where($table, ['slug' => $slug]);
        $item = $query->row();
		return $item;
    }

	public function getReviews($product_id, $limit = 5) {
        $this->db->select('*');
        $this->db->from('reviews');
        $this->db->where('product', $product_id);
        $this->db->order_by('date', 'desc');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        
        return $query->result();
    }

    public function getMeanReview($product_id) {
        $this->db->select_avg('vote');
        $this->db->from('reviews');
        $this->db->where('product_id', $product_id);
        
        $query = $this->db->get();
        $result = $query->row();
        
        return $result->vote_avg;
    }

}



/* End of file m_p.php */
/* Location ./application/models/m_p.php */