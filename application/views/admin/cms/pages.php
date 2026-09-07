<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
	<div class="row">
		<div class="col-12">
			<h4 class="mb-1"><?php echo html_escape($title); ?></h4>
			<p class="text-sm text-muted mb-3">Paste HTML for a page to replace that page’s default content. Leave empty to use the built-in layout.</p>
			<?php $ci =& get_instance(); if ($ci->session->flashdata('cms_success')): ?>
				<div class="alert alert-success"><?php echo $ci->session->flashdata('cms_success'); ?></div>
			<?php endif; ?>
			<?php $this->load->view('admin/cms/partials/pages_form', array('cms' => $cms, 'page_fields' => $page_fields, 'embed' => false)); ?>
		</div>
	</div>
</div>
