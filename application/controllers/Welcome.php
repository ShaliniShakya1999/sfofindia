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
		if ($method === 'contact_submit') {
			$this->contact_submit();
			return;
		}
		if (!isset($this->pages[$method])) {
			show_404();
		}
		
		$data = array();
		if ($method === 'index' || $method === 'donation') {
			$this->load->model('Ngom_table_model', 'ngom_t');
			$data['campaigns'] = $this->ngom_t->get_campaigns_with_totals(6, true);
			if ($method === 'index') {
				$data['ngom_events'] = $this->ngom_t->all('ngom_events', 6);
			}
		} elseif ($method === 'gallery' || $method === 'event') {
			$this->load->model('Ngom_table_model', 'ngom_t');
			if ($method === 'gallery') {
				$data['ngom_gallery'] = $this->ngom_t->all('ngom_gallery');
			} else {
				$data['ngom_events'] = $this->ngom_t->all('ngom_events');
			}
		} elseif ($method === 'team') {
			$this->db->where('status', 'active');
			$this->db->order_by('id', 'ASC');
			$data['active_members'] = $this->db->get('members')->result_array();
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
			$this->db->where_in('status', array('active', 'Active', 'published'));
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

	/**
	 * Handles the public contact form (application/views/web/contact.php).
	 * Saves the message and raises an admin notification — replaces the old
	 * standalone send.php script, which never existed in this deployment and
	 * (per its leftover source in views/web/send.php) pointed at an unrelated
	 * mail account anyway.
	 */
	private function contact_submit()
	{
		$this->load->library('session');

		if (strtoupper((string) $this->input->server('REQUEST_METHOD')) !== 'POST') {
			show_404();
			return;
		}
		if (!$this->public_throttle('contact', 5, 900)) {
			$this->session->set_flashdata('error', 'Too many messages were submitted. Please try again later.');
			redirect('contact');
			return;
		}
		if (trim((string) $this->input->post('website', true)) !== '') {
			$this->session->set_flashdata('success', 'Thank you — your message has been sent. We will get back to you soon.');
			redirect('contact');
			return;
		}

		$name    = trim((string) $this->input->post('username', true));
		$email   = trim((string) $this->input->post('email', true));
		$phone   = trim((string) $this->input->post('phone', true));
		$subject = trim((string) $this->input->post('subject', true));
		$message = trim((string) $this->input->post('message', true));

		if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === ''
			|| mb_strlen($name) > 120 || mb_strlen($subject) > 180 || mb_strlen($message) > 5000) {
			$this->session->set_flashdata('error', 'Please fill in your name, email, and message.');
			redirect('contact');
			return;
		}

		$this->load->model('Common_model', 'c_model');
		$saved = $this->c_model->saveContact(array(
			'name'       => $name,
			'email'      => $email,
			'phone'      => $phone,
			'subject'    => $subject !== '' ? $subject : 'Website Contact Form',
			'message'    => $message,
			'created_at' => date('Y-m-d H:i:s'),
		));

		if ($saved) {
			ngom_notify(
				'New Contact Message',
				$name . ' sent a message: "' . mb_strimwidth($subject !== '' ? $subject : $message, 0, 80, '...') . '"',
				'info',
				'support_tickets'
			);

			try {
				$this->load->helper('cms');
				$this->load->model('Site_model');
				$cms = $this->Site_model->get_all_flat();
				$to = !empty($cms['contact_email']) ? $cms['contact_email'] : '';
				if ($to !== '') {
					ngom_send_email(
						$to,
						'New Contact Form Message: ' . $subject,
						"<h3>New Contact Message</h3><p><b>Name:</b> " . html_escape($name) . "</p><p><b>Email:</b> " . html_escape($email) . "</p><p><b>Phone:</b> " . html_escape($phone) . "</p><p><b>Message:</b><br>" . nl2br(html_escape($message)) . "</p>"
					);
				}
			} catch (Exception $e) {
				log_message('error', 'Contact form email error: ' . $e->getMessage());
			}

			$this->session->set_flashdata('success', 'Thank you — your message has been sent. We will get back to you soon.');
		} else {
			$this->session->set_flashdata('error', 'Could not send your message. Please try again.');
		}

		redirect('contact');
	}
}
