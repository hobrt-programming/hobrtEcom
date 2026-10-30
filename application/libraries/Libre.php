<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author hobrt-programming.com
*/
class Libre
{
	public function doupload($input_name = 'file', $types = 'gif|jpg|jpeg|png')
	{
		$CI = & get_instance();
		$name_array = array();
		$count = count($_FILES[$input_name]['size']);
		$i = 0;
		foreach($_FILES as $key=>$value)
		{
			if($key == $input_name)
			for($s=0; $s<=$count-1; $s++) {
				if(!empty($value['name'][$s])){
					$_FILES[$input_name]['name']		= $value['name'][$s];
					$_FILES[$input_name]['type']    	= $value['type'][$s];
					$_FILES[$input_name]['tmp_name'] 	= $value['tmp_name'][$s];
					$_FILES[$input_name]['error']       = $value['error'][$s];
					$_FILES[$input_name]['size']    	= $value['size'][$s];
					$config['upload_path'] 				= './uploads/';
					$config['allowed_types'] 			= $types;
					$config['encrypt_name'] 			= TRUE;
					$config['max_size']					= '20480'; // 20 MB
					$CI->upload->initialize($config);
					$a = $CI->upload->do_upload($input_name);
					if(!$a)
					{
						echo "not uploaded";
						echo $CI->upload->display_errors("","");
						continue;
					}
					$data_upload = $CI->upload->data();
					$name_array[$i] = $data_upload['file_name'];
					$CI->image_l
						->load($data_upload['full_path'])
						->resize_crop(100,100)
						->save_pa('','_s',FALSE);
					/*$CI->image_l
						->load($data_upload['full_path'])
						->load_watermark("./img/logo.png")
						->resize(600,600)
						->watermark(7)
						->save_pa('','',TRUE);*/
					$CI->image_l
						->load($data_upload['full_path'])
						->resize_crop(400,400)
						->save_pa('','_m',FALSE);
					$i++;
				}

			}
		}
		$names= implode(',', $name_array);
		/*	$this->load->database();
		$db_data = array('id'=> NULL,
		'name'=> $names);
		$this->db->insert('testtable',$db_data);
		*/
		return $names;
	}
}