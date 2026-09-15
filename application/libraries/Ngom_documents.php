<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PDF documents for NGO: ID card, appointment letter, certificate, donation receipt.
 * Requires: composer require tecnickcom/tcpdf (vendor/autoload.php loaded from index.php).
 */
class Ngom_documents {

	/** @var CI_Controller */
	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		if (!class_exists('TCPDF')) {
			show_error('TCPDF not found. Run: composer install (project root).');
		}
	}

	public function member_verify_url(array $member)
	{
		$pid = isset($member['public_id']) ? $member['public_id'] : md5((string)($member['id'] ?? 'guest'));
		return site_url('member_verify/' . rawurlencode($pid));
	}

	/**
	 * Shrinks the current font (family/style already set on $pdf) down to the
	 * largest size between $min_size and $max_size whose rendered width of
	 * $text fits within $max_width (mm). Prevents text from running off the
	 * edge of small layouts like ID cards, e.g. long org names or names.
	 * Truncates with an ellipsis as a last resort if even $min_size overflows.
	 *
	 * @return string possibly-truncated text to render at the now-set font size
	 */
	private function fitTextToWidth(\TCPDF $pdf, $text, $max_width, $max_size, $min_size = 4.5)
	{
		$text = (string) $text;
		$size = $max_size;
		while ($size > $min_size) {
			$pdf->SetFontSize($size);
			if ($pdf->GetStringWidth($text) <= $max_width) {
				return $text;
			}
			$size -= 0.5;
		}
		$pdf->SetFontSize($min_size);
		// Still too wide at the minimum readable size: truncate with an ellipsis.
		while (mb_strlen($text) > 1 && $pdf->GetStringWidth($text . '...') > $max_width) {
			$text = mb_substr($text, 0, -1);
		}
		if ($pdf->GetStringWidth($text) > $max_width) {
			return $text; // single char still too wide; nothing more we can do
		}
		return $text . '...';
	}

	/**
	 * @return string binary PDF
	 */
	public function id_card_pdf(array $member, $org_name = 'NGO')
	{
		$url = $this->member_verify_url($member);
		// Standard ID card size (Slightly larger for quality)
		$pdf = new \TCPDF('P', 'mm', array(85.6, 53.98), true, 'UTF-8', false);
		$pdf->SetCreator('NGO CMS');
		$pdf->SetMargins(0, 0, 0);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetAutoPageBreak(false);

		// NGO Logo Path (Attempt to find ngo-logo.png or similar)
		$logo_path = '';
		$possible_logos = array(
			FCPATH . 'assetsA/img/ngo-logo.png',
			FCPATH . 'assetsA/img/logo-ct-dark.png',
			FCPATH . 'assetsA/img/favicon.png'
		);
		foreach ($possible_logos as $pl) {
			if (is_file($pl)) { $logo_path = $pl; break; }
		}

		// FRONT SIDE
		$pdf->AddPage();
		
		// BACKGROUND GRADIENT (Geometric/Wavy approximations)
		$pdf->SetFillColor(26, 35, 126); // Deep Blue
		// Top thin accent
		$pdf->Rect(0, 0, 53.98, 2, 'F');
		
		// Bottom Large Curve (using polygon for wavy effect)
		$pdf->SetFillColor(26, 35, 126);
		$points = array(
			0, 70,       // Left start
			53.98, 62,   // Right start (higher)
			53.98, 85.6, // Right bottom
			0, 85.6      // Left bottom
		);
		$pdf->Polygon($points, 'F');

		// Logo & Header
		$pdf->SetXY(0, 4);
		if ($logo_path !== '') {
			$pdf->Image($logo_path, 6, 5, 12, 12, '', '', '', false, 300, '', false, false, 0, false, false, false);
		}
		
		$pdf->SetTextColor(33, 33, 33);
		$org_label = strtoupper((string) $org_name);
		$header_x = 20;
		$header_y = 5;
		$header_w = 32;

		// Shrink the font so the org name wraps to at most 2 lines instead of
		// silently truncating (old MultiCell) or overflowing (old fixed size).
		// Then measure the *actual* wrapped height and place the website line
		// right after it, so long org names never collide with "www...".
		$font_size = 11;
		$pdf->SetFont('helvetica', 'B', $font_size);
		while ($font_size > 7 && $pdf->getNumLines($org_label, $header_w) > 2) {
			$font_size -= 0.5;
			$pdf->SetFont('helvetica', 'B', $font_size);
		}
		if ($pdf->getNumLines($org_label, $header_w) > 2) {
			// Even at the smallest readable size it needs 3+ lines: a cramped
			// wrap would run past the photo section, so fit it on one line instead.
			$org_label = $this->fitTextToWidth($pdf, $org_label, $header_w, $font_size, 6);
			$line_h = $font_size * 0.42;
			$pdf->SetXY($header_x, $header_y + 1);
			$pdf->Cell($header_w, $line_h, $org_label, 0, 1, 'L');
			$url_y = $header_y + 1 + $line_h + 1;
		} else {
			$block_h = $pdf->getStringHeight($header_w, $org_label);
			$pdf->SetXY($header_x, $header_y);
			$pdf->MultiCell($header_w, $block_h, $org_label, 0, 'L', false, 1, $header_x, $header_y, true);
			$url_y = $header_y + $block_h + 1;
		}

		$pdf->SetFont('helvetica', '', 6);
		$pdf->SetXY($header_x, $url_y);
		$pdf->Cell(30, 3, 'www.sfofindia.org', 0, 1, 'L');

		// Photo Section
		$photo_path = '';
		if (!empty($member['photo'])) {
			$p = FCPATH . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, ltrim($member['photo'], '/'));
			if (is_file($p)) { $photo_path = $p; }
		}
		
		// Photo Square Holder
		$pdf->SetLineStyle(array('width' => 0.4, 'color' => array(200, 200, 200)));
		$pdf->Rect(16, 22, 22, 22);
		
		if ($photo_path !== '') {
			$pdf->Image($photo_path, 16.5, 22.5, 21, 21, '', '', '', false, 300, '', false, false, 0, false, false, false);
		} else {
			$pdf->SetFillColor(245, 245, 245);
			$pdf->Rect(16.5, 22.5, 21, 21, 'F');
		}

		// Field Labels
		$pdf->SetTextColor(50, 50, 50);
		$pdf->SetFont('helvetica', '', 7);
		
		$y = 48;
		$fields = array(
			'Name' => $member['name'],
			'Role' => $member['role'] ?? 'Member',
			'Mobile' => $member['mobile'] ?? 'N/A',
			'ID No.' => !empty($member['member_id_code']) ? $member['member_id_code'] : $member['id']
		);

		// Available width for the value column: card is 53.98mm wide, value
		// column starts at x=20 (8 + 12 label width), leave a small right margin.
		$value_max_width = 53.98 - 20 - 2;
		foreach ($fields as $label => $val) {
			$pdf->SetXY(8, $y);
			$pdf->SetFont('helvetica', 'B', 7);
			$pdf->Cell(12, 4, $label . ' :', 0, 0, 'L');
			$pdf->SetFont('helvetica', '', 7);
			$fitted_val = $this->fitTextToWidth($pdf, (string) $val, $value_max_width, 7);
			$pdf->Cell(32, 4, $fitted_val, 0, 1, 'L');
			$y += 4.5;
		}

		// Bottom URL
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetFont('helvetica', 'B', 8);
		$pdf->SetXY(0, 78);
		$pdf->Cell(53.98, 5, 'sfofindia.org', 0, 1, 'C');

		// BACK SIDE
		$pdf->AddPage();
		
		// Logo on back
		if ($logo_path !== '') {
			$pdf->Image($logo_path, 21, 5, 12, 12, '', '', '', false, 300, '', false, false, 0, false, false, false);
		}
		$pdf->SetTextColor(26, 35, 126);
		$pdf->SetFont('helvetica', 'B', 9);
		$pdf->SetXY(0, 18);
		$pdf->Cell(53.98, 5, strtoupper((string)$org_name), 0, 1, 'C');

		// QR Code for verification
		$style = array('border' => 0, 'vpadding' => 'auto', 'hpadding' => 'auto', 'fgcolor' => array(0, 0, 0), 'bgcolor' => false, 'module_width' => 1, 'module_height' => 1);
		$pdf->write2DBarcode($url, 'QRCODE,H', 18, 26, 18, 18, $style, 'N');

		// Terms & Conditions Header
		$y_terms = 48;
		$pdf->SetFillColor(26, 35, 126);
		$pdf->Rect(12, $y_terms, 30, 4, 'F');
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetFont('helvetica', 'B', 5.5);
		$pdf->SetXY(12, $y_terms + 0.5);
		$pdf->Cell(30, 3, 'Terms & Conditions', 0, 1, 'C');

		$pdf->SetTextColor(50, 50, 50);
		$pdf->SetFont('helvetica', '', 5);
		$html_terms = '
		<div style="line-height: 1.2;">
			• This ID card is property of ' . $org_name . '.<br>
			• Non-transferable and must be worn at all times.<br>
			• If found, return to nearest NGO office.<br>
			• Valid only with authorized signature.
		</div>';
		$pdf->writeHTMLCell(44, 20, 5, $y_terms + 6, $html_terms, 0, 0, false, true, 'L', true);

		// Signature Block
		$pdf->SetXY(10, 72);
		$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0)));
		$pdf->Line(10, 68, 44, 68);
		$pdf->SetFont('helvetica', 'I', 5.5);
		$pdf->SetXY(10, 68.5);
		$pdf->Cell(34, 4, 'Authorized Signature', 0, 1, 'C');

		// Bottom accent back
		$pdf->SetFillColor(26, 35, 126);
		$pdf->Rect(0, 75, 53.98, 10.6, 'F');
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetFont('helvetica', 'B', 7);
		$pdf->SetXY(0, 78);
		$pdf->Cell(53.98, 4, 'sfofindia.org', 0, 1, 'C');

		return $pdf->Output('member-id-card.pdf', 'S');
	}

	public function appointment_pdf(array $member, $org_name = 'NGO', $body = '')
	{
		// Portrait A4
		$pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('NGO CMS');
		$pdf->SetMargins(15, 45, 15); // Top margin accommodates header
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		// Colors
		$color_blue = array(26, 35, 126);   // Deep Blue
		$color_gold = array(184, 134, 11);  // Gold
		$color_text = array(50, 50, 50);

		// Assets
		$logo_path = '';
		$possible_logos = array(
			FCPATH . 'assetsA/img/ngo-logo.png',
			FCPATH . 'assetsA/img/logo-ct-dark.png',
			FCPATH . 'assetsA/img/favicon.png'
		);
		foreach ($possible_logos as $pl) {
			if (is_file($pl)) { $logo_path = $pl; break; }
		}

		// 1. Premium Header
		if ($logo_path !== '') {
			$pdf->Image($logo_path, 15, 10, 22, 22, '', '', '', false, 300, '', false, false, 0, false, false, false);
		}
		
		$pdf->SetTextColorArray($color_blue);
		$pdf->SetFont('times', 'B', 24);
		$pdf->SetXY(40, 10);
		$pdf->Cell(100, 10, 'SFOI', 0, 1, 'L');
		
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->SetXY(41, 19);
		$pdf->Cell(100, 5, 'sfofindia.org', 0, 1, 'L');
		$pdf->SetXY(41, 23);
		$pdf->SetFont('helvetica', 'I', 7.5);
		$pdf->Cell(100, 5, 'Empowering Individuals, Strengthening Society', 0, 1, 'L');

		// Right-side Contact info
		$pdf->SetTextColor(80, 80, 80);
		$pdf->SetFont('helvetica', '', 7.5);
		$x_contact = 145;
		// Website
		$pdf->SetXY($x_contact, 12);
		$pdf->Cell(50, 4, 'www.sfofindia.org', 0, 1, 'R');
		// Email
		$pdf->SetXY($x_contact, 16);
		$pdf->Cell(50, 4, 'info@sfofindia.org', 0, 1, 'R');
		// Phone
		$pdf->SetXY($x_contact, 20);
		$pdf->Cell(50, 4, '+91 12345 67890', 0, 1, 'R');

		// Header Dividing Line
		$pdf->SetLineStyle(array('width' => 0.5, 'color' => $color_blue));
		$pdf->Line(15, 36, 195, 36);

		// 2. Background Watermark (Semi-transparent)
		if ($logo_path !== '') {
			$pdf->SetAlpha(0.04);
			$pdf->Image($logo_path, 55, 100, 100, 100, '', '', '', false, 300, '', false, false, 0, false, false, false);
			$pdf->SetAlpha(1);
		}

		// 3. Document Details (Ref No & Date)
		$pdf->SetTextColorArray($color_text);
		$pdf->SetFont('helvetica', '', 10);
		
		$date_raw = $member['verified_at'] ?? 'now';
		$ref_no = 'SFOI/' . date('Y/m', strtotime($date_raw)) . '/' . str_pad($member['id'], 3, '0', STR_PAD_LEFT);
		$date_str = date('d F, Y', strtotime($date_raw));
		$member_identifier = !empty($member['member_id_code'])
			? $member['member_id_code']
			: (!empty($member['member_user_id']) ? $member['member_user_id'] : $member['id']);

		$pdf->SetXY(15, 48);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(100, 5, 'Ref. No.: ' . $ref_no, 0, 0, 'L');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(80, 5, 'Date: ' . $date_str, 0, 1, 'R');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 6, 'Member ID: ' . $member_identifier, 0, 1, 'L');

		// 4. Body Content
		$pdf->Ln(12);
		$pdf->Cell(0, 5, 'To,', 0, 1);
		$pdf->SetFont('helvetica', 'B', 11);
		$pdf->Cell(100, 6, html_escape($member['name']), 0, 1);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(100, 5, html_escape($member['role'] ?? 'Member'), 0, 1);
		$pdf->Cell(100, 5, 'SFOI (sfofindia.org)', 0, 1);

		$pdf->Ln(10);
		$pdf->SetFont('helvetica', 'B', 10.5);
		$pdf->Cell(0, 7, 'Subject: Official Appointment Letter', 0, 1);
		
		$pdf->Ln(5);
		$pdf->SetFont('helvetica', '', 10.5);
		$pdf->Cell(0, 6, 'Dear ' . ($member['gender'] === 'female' ? 'Madam' : 'Sir') . ',', 0, 1);
		
		$pdf->Ln(4);
		$main_body = "Greetings from SFOI (sfofindia.org).\n\nWe are a collective of like-minded individuals working towards empowering communities, promoting education, healthcare, and social welfare initiatives for a better and inclusive society.\n\nWe appreciate your interest in partnering with us / supporting our initiatives. Together, we can create a meaningful impact and bring positive change to the lives of many.\n\nWe look forward to your valuable association and a long-term collaboration.\n\nThank you.";
		$pdf->MultiCell(0, 6.5, $main_body, 0, 'L');

		$pdf->Ln(12);
		$pdf->Cell(0, 5, 'Warm regards,', 0, 1);
		$pdf->Ln(10);
		$pdf->SetFont('helvetica', 'B', 11);
		$pdf->Cell(0, 5, 'Authorized Signatory', 0, 1);
		$pdf->SetFont('helvetica', '', 9.5);
		$pdf->Cell(0, 4, (string)$org_name, 0, 1);

		// 5. Verification QR Code (Moved up for visibility)
		$url = $this->member_verify_url($member);
		$pdf->write2DBarcode($url, 'QRCODE,H', 170, 240, 20, 20, array('border' => 0, 'fgcolor' => $color_blue), 'N');
		$pdf->SetXY(160, 262);
		$pdf->SetTextColorArray($color_blue);
		$pdf->SetFont('helvetica', '', 6);
		$pdf->Cell(40, 4, 'SCAN TO VERIFY AUTHENTICITY', 0, 1, 'C');

		return $pdf->Output('appointment-letter.pdf', 'S');
	}

	public function certificate_pdf(array $member, $title = 'Certificate of Appreciation', $body = '', $org_name = 'NGO')
	{
		// Landscape A4 (297 x 210 mm)
		$pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('NGO CMS');
		$pdf->SetMargins(0, 0, 0);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		// Colors
		$color_blue = array(26, 35, 126);   // Deep Blue
		$color_gold = array(184, 134, 11);  // Gold
		$color_text_main = array(33, 33, 33);

		// NGO Logo Path
		$logo_path = '';
		$possible_logos = array(
			FCPATH . 'assetsA/img/ngo-logo.png',
			FCPATH . 'assetsA/img/logo-ct-dark.png',
			FCPATH . 'assetsA/img/favicon.png'
		);
		foreach ($possible_logos as $pl) {
			if (is_file($pl)) { $logo_path = $pl; break; }
		}

		// 1. Decorative Background Elements
		$pdf->SetFillColorArray($color_blue);
		$pdf->Polygon(array(0,0, 60,0, 0,60), 'F'); // Top-Left
		$pdf->Polygon(array(297,210, 237,210, 297,150), 'F'); // Bottom-Right

		// 2. Premium Gold Borders
		$pdf->SetLineStyle(array('width' => 0.5, 'color' => $color_gold));
		$pdf->Rect(10, 10, 277, 190);
		$pdf->SetLineStyle(array('width' => 1.5, 'color' => $color_gold));
		$pdf->Rect(8, 8, 281, 194);

		// 3. Header Branding
		if ($logo_path !== '') {
			$pdf->Image($logo_path, 138.5, 15, 20, 20, '', '', '', false, 300, '', false, false, 0, false, false, false);
		}
		
		$pdf->SetTextColorArray($color_text_main);
		$pdf->SetFont('times', 'B', 22);
		$pdf->SetXY(0, 38);
		$pdf->MultiCell(297, 10, strtoupper((string)$org_name), 0, 'C');
		
		$pdf->SetFont('helvetica', '', 10);
		$pdf->SetTextColor(100, 100, 100);
		$pdf->SetXY(0, 48);
		$pdf->Cell(297, 5, 'www.sfofindia.org', 0, 1, 'C');

		// 4. Certificate Body
		$pdf->SetTextColorArray($color_blue);
		$pdf->SetFont('times', 'B', 40);
		$pdf->SetXY(0, 65);
		$pdf->Cell(297, 15, 'CERTIFICATE', 0, 1, 'C');
		
		$pdf->SetTextColorArray($color_gold);
		$pdf->SetFont('times', 'B', 18);
		$pdf->Cell(297, 10, strtoupper($title), 0, 1, 'C');

		$pdf->SetTextColor(80, 80, 80);
		$pdf->SetFont('times', '', 14);
		$pdf->Ln(5);
		$pdf->Cell(297, 10, 'This is to certify that', 0, 1, 'C');

		$pdf->SetTextColorArray($color_blue);
		$pdf->SetFont('times', 'BI', 38);
		$pdf->Ln(2);
		$name = html_escape($member['name']);
		$pdf->Cell(297, 18, $name, 0, 1, 'C');
		
		$pdf->SetTextColor(80, 80, 80);
		$pdf->SetFont('times', '', 12);
		$pdf->Ln(8);
		$cert_body = ($body !== '') ? $body : "has been recognized for their valuable contribution and dedication towards the mission and initiatives of " . $org_name . ". We appreciate their commitment and efforts in bringing positive change to society.";
		$pdf->MultiCell(180, 8, $cert_body, 0, 'C', false, 1, 58.5);

		// 5. Footer Details
		$y_footer = 165;
		$pdf->SetXY(40, $y_footer);
		$pdf->SetLineStyle(array('width' => 0.4, 'color' => array(50, 50, 50)));
		$pdf->Line(40, $y_footer + 10, 100, $y_footer + 10);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->SetXY(40, $y_footer + 12);
		$pdf->Cell(60, 5, 'Authorized Signature', 0, 0, 'C');

		$pdf->SetXY(197, $y_footer);
		$pdf->Line(197, $y_footer + 10, 257, $y_footer + 10);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->SetXY(197, $y_footer + 12);
		$date = date('d F, Y', strtotime($member['verified_at'] ?? 'now'));
		$pdf->Cell(60, 5, $date, 0, 0, 'C');

		// 6. Gold Seal
		if ($logo_path !== '') {
			$pdf->SetFillColorArray($color_gold);
			$pdf->Circle(148.5, 175, 12, 0, 360, 'F');
			$pdf->Image($logo_path, 140.5, 167, 16, 16, '', '', '', false, 300, '', false, false, 0, false, false, false);
		}

		// 7. QR Code (Digital Verification)
		$url = $this->member_verify_url($member);
		$style = array('border' => 0, 'fgcolor' => $color_blue);
		$pdf->write2DBarcode($url, 'QRCODE,H', 265, 12, 18, 18, $style, 'N');

		return $pdf->Output('certificate.pdf', 'S');
	}

	public function donation_receipt_pdf(array $donation, $org_name = 'NGO')
	{
		$pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('NGO CMS');
		$pdf->SetMargins(18, 18, 18);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$logo_path = '';
		foreach (array(
			FCPATH . 'assetsA/img/ngo-logo.png',
			FCPATH . 'assetsA/img/logo-ct-dark.png'
		) as $possible_logo) {
			if (is_file($possible_logo)) {
				$logo_path = $possible_logo;
				break;
			}
		}

		$blue = array(24, 74, 128);
		$light_blue = array(235, 243, 252);
		$muted = array(90, 100, 110);
		$receipt_no = (string) ($donation['receipt_no'] ?? '—');
		$created_at = !empty($donation['created_at']) ? strtotime($donation['created_at']) : time();
		$donor_name = (string) ($donation['name'] ?? 'Donor');
		$email = (string) ($donation['email'] ?? '—');
		$mobile = (string) ($donation['mobile'] ?? '—');
		$payment_id = (string) ($donation['payment_id'] ?? '—');

		$pdf->SetFillColorArray($blue);
		$pdf->Rect(0, 0, 210, 38, 'F');
		if ($logo_path !== '') {
			$pdf->Image($logo_path, 18, 8, 22, 22, '', '', '', false, 300, '', false, false, 0, false, false, false);
		}
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetXY(45, 9);
		$pdf->SetFont('helvetica', 'B', 17);
		$pdf->Cell(145, 8, $org_name, 0, 1, 'L');
		$pdf->SetX(45);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(145, 6, 'Donation Receipt', 0, 1, 'L');
		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetY(50);
		$pdf->SetFont('helvetica', 'B', 16);
		$pdf->SetTextColorArray($blue);
		$pdf->Cell(0, 9, 'Thank You for Your Generous Support', 0, 1, 'C');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->SetTextColorArray($muted);
		$pdf->Cell(0, 6, 'This receipt acknowledges your contribution to our charitable mission.', 0, 1, 'C');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Ln(8);

		$pdf->SetFillColorArray($light_blue);
		$pdf->SetDrawColorArray(array(200, 215, 232));
		$pdf->RoundedRect(18, 78, 174, 27, 2, '1111', 'DF');
		$pdf->SetXY(25, 84);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(30, 6, 'Receipt No.', 0, 0);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->Cell(72, 6, $receipt_no, 0, 0);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(18, 6, 'Date', 0, 0);
		$pdf->SetFont('helvetica', '', 9);
		$pdf->Cell(47, 6, date('d M Y, H:i', $created_at), 0, 1);
		$pdf->SetXY(25, 92);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(30, 6, 'Status', 0, 0);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->SetTextColor(25, 120, 70);
		$pdf->Cell(72, 6, 'PAID', 0, 0);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(18, 6, 'Currency', 0, 0);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(47, 6, 'INR', 0, 1);

		$pdf->SetY(117);
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->SetTextColorArray($blue);
		$pdf->Cell(0, 8, 'Donor Details', 0, 1);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->SetDrawColor(220, 225, 230);
		$pdf->Line(18, 126, 192, 126);
		$pdf->SetY(130);
		$pdf->Cell(32, 6, 'Full Name', 0, 0);
		$pdf->Cell(65, 6, $donor_name, 0, 0);
		$pdf->Cell(25, 6, 'Email', 0, 0);
		$pdf->Cell(52, 6, $email, 0, 1);
		$pdf->Cell(32, 6, 'Mobile', 0, 0);
		$pdf->Cell(65, 6, $mobile !== '' ? $mobile : '—', 0, 1);

		$pdf->SetY(153);
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->SetTextColorArray($blue);
		$pdf->Cell(0, 8, 'Payment Details', 0, 1);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetDrawColor(220, 225, 230);
		$pdf->Line(18, 162, 192, 162);
		$pdf->SetY(166);
		$pdf->SetFont('helvetica', 'B', 13);
		$pdf->Cell(42, 9, 'Amount Paid', 0, 0);
		$pdf->SetTextColorArray($blue);
		$pdf->Cell(132, 9, 'INR ' . number_format((float) ($donation['amount'] ?? 0), 2), 0, 1, 'R');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', '', 9);
		$pdf->Cell(42, 6, 'Payment ID', 0, 0);
		$pdf->Cell(132, 6, $payment_id, 0, 1, 'R');

		$pdf->SetFillColorArray(array(248, 250, 252));
		$pdf->RoundedRect(18, 190, 174, 24, 2, '1111', 'F');
		$pdf->SetXY(25, 196);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->MultiCell(125, 5, 'Thank you, ' . $donor_name . ', for standing with ' . $org_name . '. Your generosity helps us serve families and communities with dignity.', 0, 'L');

		$verify = site_url('donations/verify_receipt/' . rawurlencode((string) $donation['receipt_no']));
		$style = array('border' => 0, 'vpadding' => 'auto', 'hpadding' => 'auto', 'fgcolor' => array(24, 74, 128), 'bgcolor' => false, 'module_width' => 1, 'module_height' => 1);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->SetTextColorArray($blue);
		$pdf->SetXY(25, 225);
		$pdf->Cell(105, 6, 'Verify this receipt', 0, 1);
		$pdf->SetFont('helvetica', '', 9);
		$pdf->SetTextColor(80, 80, 80);
		$pdf->SetX(25);
		$pdf->MultiCell(105, 5, 'Scan the QR code or use the verification link to confirm this donation receipt.', 0, 'L');
		$pdf->write2DBarcode($verify, 'QRCODE,H', 155, 220, 30, 30, $style, 'N');
		$pdf->SetFont('helvetica', 'I', 9);
		$pdf->SetTextColorArray($blue);
		$pdf->SetXY(18, 260);
		$pdf->Cell(174, 6, 'Want to make a bigger difference? Become a member and join our mission.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 8);
		$pdf->SetTextColor(100, 100, 100);
		$pdf->SetXY(18, 270);
		$pdf->Cell(174, 5, 'Computer-generated receipt • No signature required', 0, 1, 'C');
		return $pdf->Output('receipt.pdf', 'S');
	}
}