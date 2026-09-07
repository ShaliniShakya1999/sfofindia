<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
	<div class="row justify-content-center">
		<div class="col-12">
			<div class="card border-0 shadow-sm mb-4">
				<div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
					<div>
						<h4 class="mb-1"><?php echo html_escape($document_title); ?></h4>
						<p class="text-muted mb-0">Document preview for <?php echo html_escape(isset($member['name']) ? $member['name'] : 'member'); ?>.</p>
					</div>
					<div class="d-flex flex-wrap gap-2">
						<a href="<?php echo html_escape($download_url); ?>" class="btn btn-primary">Download</a>
						<a href="<?php echo site_url('admin'); ?>" class="btn btn-outline-secondary">Back</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card border-0 shadow-sm">
				<div class="card-body p-2 p-md-3">
					<div class="ratio" style="--bs-aspect-ratio: 130%;">
						<iframe src="<?php echo html_escape($document_url); ?>" title="<?php echo html_escape($document_title); ?>" style="width:100%;height:100%;border:0;border-radius:12px;background:#f8f9fa;"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
