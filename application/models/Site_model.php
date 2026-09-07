<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Key/value site content for NGO CMS (public website).
 */
class Site_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default copy when DB empty or key missing.
	 *
	 * @return array<string,string>
	 */
	public function defaults()
	{
		return array(
			'site_name' => 'Shaheed Foundation India',
			'meta_title' => 'Shaheed Foundation India',
			'meta_description' => 'Honoring sacrifice, supporting martyrs’ families with dignity and care.',
			'meta_keywords' => 'NGO, martyrs, India, charity, donation',
			'contact_phone' => '+012 345 67890',
			'contact_email' => 'info@sfofindia.com',
			'contact_address' => 'SCO-88 Second Floor, Opp. Sector 12 A Gurgaon',
			
			'newsletter_subtitle' => 'Don\'t worry, we won\'t spam you with emails.',
			'slide1_title' => 'Honoring Sacrifice. Supporting Families. Building Hope.',
			'slide1_text' => 'At Shaheed Foundation of India, we stand beside the families of our martyrs, offering respect, support, and long-term assistance to help them live with dignity and security.',
			'slide1_btn1' => 'Support a Martyr\'s Family',
			'slide1_btn2' => 'Join as a Volunteer',
			'slide1_img' => 'img/soldier1.avif',
			'slide2_title' => 'Standing Strong with the Families of Our Fallen Heroes',
			'slide2_text' => 'Shaheed Foundation of India is committed to honoring the brave souls who laid down their lives for the nation by ensuring care, dignity, and a secure future for their families.',
			'slide2_btn1' => 'Support Disabled People',
			'slide2_btn2' => 'Become a Volunteer',
			'slide2_img' => 'img/army2.jpg',
			'slide3_title' => 'A Strong Support System for the Families of Our Martyrs',
			'slide3_text' => 'Shaheed Foundation of India is dedicated to honoring the supreme sacrifice of our brave martyrs by supporting their families with dignity, care, and long-term security.',
			'slide3_btn1' => 'Donate Now',
			'slide3_btn2' => 'Join as a Volunteer',
			'slide3_img' => 'img/Army.jpg',
			'about_label' => 'About Shaheed Foundation of India',
			'about_heading' => 'Standing With Those Who Gave Everything',
			'about_p1' => 'Shaheed Foundation of India is a non-profit organization dedicated to supporting the families of brave martyrs who sacrificed their lives for the nation. Our mission is to ensure that no martyr\'s family ever feels alone, forgotten, or helpless.',
			'about_quote' => 'A nation that honors its martyrs must stand with their families.',
			'donation_box_text' => 'Your contribution helps us provide dignity, care, and hope to the families of our martyrs.',
			'what_we_do_1' => 'Financial assistance for martyrs\' families',
			'what_we_do_2' => 'Education and healthcare support',
			'what_we_do_3' => 'Employment and skill development programs',
			'what_we_do_4' => 'Emergency relief and crisis support',
			'about_image' => 'img/images.jpg',
			'google_analytics_id' => '',
			'google_map_embed' => '',
			'whatsapp_float_number' => '',
			'pwa_enabled' => '0',
		);
	}

	/**
	 * @return array<string,string>
	 */
	public function get_all_flat()
	{
		if (!$this->db->table_exists('site_settings')) {
			return $this->defaults();
		}
		$rows = $this->db->get('site_settings')->result();
		$out = array();
		foreach ($rows as $r) {
			$out[$r->setting_key] = $r->setting_value;
		}
		return array_merge($this->defaults(), $out);
	}

	/**
	 * @param array<string,string> $data
	 */
	public function save_batch($data)
	{
		if (!$this->db->table_exists('site_settings')) {
			return false;
		}
		foreach ($data as $key => $val) {
			if (!is_string($key) || $key === '') {
				continue;
			}
			$q = $this->db->get_where('site_settings', array('setting_key' => $key), 1);
			if ($q->num_rows() > 0) {
				$this->db->where('setting_key', $key);
				$this->db->update('site_settings', array('setting_value' => $val));
			} else {
				$this->db->insert('site_settings', array(
					'setting_key' => $key,
					'setting_value' => $val,
				));
			}
		}
		return true;
	}

	/**
	 * @param string $key
	 * @param string $val
	 */
	public function save_setting($key, $val)
	{
		return $this->save_batch(array($key => $val));
	}
}
