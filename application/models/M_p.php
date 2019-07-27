<?php
if(!defined('BASEPATH')) exit();
/**
* @author hobrt.me
* @file M_p.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2019
*
**/
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
			return $qr->result();
		else
		{
			$res = $qr->result();
			foreach ($res as $key) {
				$ret = $key->$se;
			}
			return $ret;
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
		$this->db->select('id');
		$this->db->from($tab);
		$this->db->where($wer);
		$res = $this->db->get();
		return $res->num_rows();
	}
	public function delete($tab,$wer = array())
	{
		if(count($wer) == 0)
		{
			$query = $this->db->query("DELETE FROM $tab ");
		}
		else
		{
			$query = $this->db->delete($tab, $wer);
		}
		if($query)
			return TRUE;
	}

	public function login($username ,$password)
	{
		$user = $this->db->escape($username);
		$password = _hash($password);
		$qr = $this->db->query("SELECT * FROM users WHERE username = $user AND password = '$password' OR email = $user AND password = '$password'");
		$login = $qr -> num_rows();
		if($login > 0)
		{
			$info = $qr->result();
			foreach ($info as $key) {
				$id = $key->id;
			}
			if($this->input->post('remember_me') == 1)
			{
				$this->session->sess_expiration = 60 * 60 * 24 * 30;
			}
			$arr = array("id" => $id);
			$this->session->set_userdata('logged_in',$arr);
			return TRUE;
		}
		else
			return "<div class='alert alert-danger'>خطاء في البيانات الرجاء إعادة المحاولة</div>";
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

	function totalSales($id)
	{
		$all = $this->qe_r("SELECT * FROM orders WHERE products LIKE '%\"".$id."\"%' ");
		//echo $this->db->last_query();
		$totalSales = 0;
		foreach ($all as $key) {
			$i = json_decode($key->products, TRUE);
			if(isset($i[$id]))
				$totalSales+=$i[$id];
		}
		return $totalSales;
	}

}



/* End of file m_p.php */
/* Location ./application/models/m_p.php */