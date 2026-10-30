<?php 
$config = array();
$config['full_tag_open'] = '<nav aria-label="Page navigation example" class="navigation-btn ">
                                  <ul class="pagination justify-content-center">';
$config['full_tag_close'] = '</ul>
                              </nav>';
$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close'] = '</a></li>';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tagl_close'] = '</li>';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tagl_close'] = '</li>';
$config['first_tag_open'] = '<li class="page-item">';
$config['first_tagl_close'] = '</li>';
$config['last_tag_open'] = '<li class="page-item">';
$config['last_tagl_close'] = '</li>';
$config['last_link'] = lang("lang_h67");
$config['first_link'] = lang("lang_h68");
$config['next_link'] = '<span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>';
$config['prev_link'] = '<span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>';
$config['attributes'] = array('class' => 'page-link');
return $config;
?>