<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!class_exists("My_Controller"))
    include_once(APPPATH . 'core/My_Controller.php');
class Welcome extends My_Controller {

	/** @var array<string,string> */
	private $pages = array(
		'index' => 'web/index',
		'about' => 'web/about',
		'service' => 'web/service',
		'financial' => 'web/financial',
		'education' => 'web/education',
		'disability' => 'web/disability',
		'employment' => 'web/employment',
		'donation' => 'web/donation',
		'documents' => 'web/documents',
		'team' => 'web/team',
		'gallery' => 'web/gallery',
		'event' => 'web/event',
		'feature' => 'web/feature',
		'contact' => 'web/contact',
		'refund_policy' => 'web/refund_Policy',
		'legal_compliance' => 'web/legal_Compliance',
		'privacy_policy' => 'web/privacy_Policy',
		'terms' => 'web/terms',
		'create_order' => 'web/create_order',
		'razorpay_config' => 'web/razorpay_config',
		'send' => 'web/send',
		'blog' => 'web/blog',
		'blog_article' => 'web/blog_article',
	);

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function _remap($method, $params = array())
	{
		if (!isset($this->pages[$method])) {
			show_404();
		}
		
		$data = array();
		if ($method === 'gallery' || $method === 'event') {
			$this->load->model('Ngom_table_model', 'ngom_t');
			if ($method === 'gallery') {
				$data['ngom_gallery'] = $this->ngom_t->all('ngom_gallery');
			} else {
				$data['ngom_events'] = $this->ngom_t->all('ngom_events');
			}
		} elseif ($method === 'blog') {
			$this->db->where('status', 'active');
			$this->db->order_by('id', 'DESC');
			$data['blogs'] = $this->db->get('blog')->result_array();
		} elseif ($method === 'blog_article') {
			$slug = isset($params[0]) ? (string) $params[0] : '';
			if ($slug === '') {
				redirect('welcome/blog');
			}
			$this->db->where('slug', $slug);
			$data['article'] = $this->db->get('blog')->row_array();
			if (empty($data['article'])) {
				show_404();
			}
			// Fetch recent blogs for sidebar
			$this->db->where('status', 'active');
			$this->db->where('slug !=', $slug);
			$this->db->order_by('id', 'DESC');
			$this->db->limit(5);
			$data['recent_blogs'] = $this->db->get('blog')->result_array();
		}
		
		$this->loadview($this->pages[$method], $data);
	}
}
