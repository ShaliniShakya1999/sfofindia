<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
	<h4 class="mb-3"><?php echo isset($title) ? html_escape($title) : 'Homepage'; ?></h4>
	<?php $ci =& get_instance(); if ($ci->session->flashdata('cms_success')): ?>
		<div class="alert alert-success"><?php echo $ci->session->flashdata('cms_success'); ?></div>
	<?php endif; ?>
	<?php $this->load->view('admin/cms/partials/homepage_form', array('cms' => $cms, 'embed' => false)); ?>
</div>
