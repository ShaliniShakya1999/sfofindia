<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Donation receipt</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow-sm">
					<div class="card-body p-4 text-center">
						<?php if (empty($donation)): ?>
							<h1 class="h4 text-danger">Receipt not found</h1>
						<?php else: ?>
							<h1 class="h4 text-success">Valid donation receipt</h1>
							<p class="mb-1">Receipt: <strong><?php echo html_escape($donation['receipt_no']); ?></strong></p>
							<p class="mb-1">Donor: <?php echo html_escape($donation['name']); ?></p>
							<p class="mb-0">Amount: ₹<?php echo number_format((float) $donation['amount'], 2); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
