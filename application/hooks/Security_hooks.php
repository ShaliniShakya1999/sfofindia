<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_hooks
{
	public function inject_csrf_fields()
	{
		$CI =& get_instance();
		$output = $CI->output->get_output();
		$content_type = strtolower((string) $CI->output->get_content_type());

		foreach ($CI->output->headers as $header) {
			header($header[0], $header[1]);
		}
		header('X-Content-Type-Options: nosniff');
		header('Referrer-Policy: strict-origin-when-cross-origin');
		header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
		if (ENVIRONMENT === 'production' && (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')) {
			header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
		}

		if ($output === '' || !$CI->config->item('csrf_protection') || $content_type !== 'text/html') {
			echo $output;
			return;
		}

		$token_name = $CI->security->get_csrf_token_name();
		$token_hash = $CI->security->get_csrf_hash();
		$input = '<input type="hidden" name="' . html_escape($token_name) . '" value="' . html_escape($token_hash) . '">';
		$output = preg_replace('/(<form\b[^>]*method\s*=\s*["\']?post["\']?[^>]*>)/i', '$1' . $input, $output);
		echo $output;
	}
}
