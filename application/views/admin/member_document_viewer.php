<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- CDN for html2canvas to enable 1-click Download as Photo / PNG -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<style>
/* Document Viewer Modern Container Styles */
.doc-viewer-wrapper {
  max-width: 1140px;
  margin: 0 auto;
}

.doc-action-bar {
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  border: 1px solid rgba(0,0,0,0.06);
}

.doc-canvas-area {
  background: #f1f3f9;
  border-radius: 20px;
  padding: 2.5rem 1.5rem;
  min-height: 520px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 1px solid rgba(0,0,0,0.06);
  position: relative;
}

/* ==========================================================================
   1. ID CARD STYLES (PHYSICAL PVC PHOTO PRESENTATION)
   ========================================================================== */
.id-cards-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 2.5rem;
  width: 100%;
}

.pvc-card {
  width: 330px;
  height: 520px;
  background: #ffffff;
  border-radius: 18px;
  box-shadow: 0 16px 36px rgba(15, 23, 42, 0.18), 0 2px 6px rgba(0,0,0,0.06);
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  border: 1px solid rgba(0,0,0,0.08);
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  user-select: none;
}

/* Realistic Lanyard Punch Slot */
.lanyard-slot {
  position: absolute;
  top: 8px;
  left: 50%;
  transform: translateX(-50%);
  width: 38px;
  height: 6px;
  background: #e2e8f0;
  border-radius: 4px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.3);
  z-index: 10;
}

/* Gloss Overlay Sheen */
.pvc-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: -50%;
  width: 200%;
  height: 100%;
  background: linear-gradient(135deg, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0.02) 50%, rgba(255,255,255,0) 100%);
  pointer-events: none;
  z-index: 5;
}

/* ID Card Front */
.id-card-front .front-header {
  padding: 1.4rem 1rem 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  position: relative;
  z-index: 2;
}

.id-card-front .ngo-logo-front {
  width: 46px;
  height: 46px;
  object-fit: contain;
  border-radius: 50%;
  background: #fff;
  padding: 2px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.id-card-front .ngo-title-box h5 {
  font-size: 0.85rem;
  font-weight: 800;
  color: #1a237e;
  margin: 0;
  line-height: 1.15;
  text-transform: uppercase;
  letter-spacing: -0.01em;
}

.id-card-front .ngo-title-box small {
  font-size: 0.65rem;
  color: #64748b;
  font-weight: 600;
  letter-spacing: 0.02em;
}

.id-card-front .photo-wrap {
  text-align: center;
  margin: 0.6rem auto 0.4rem;
  position: relative;
  z-index: 2;
}

.id-card-front .member-photo {
  width: 110px;
  height: 110px;
  object-fit: cover;
  border-radius: 12px;
  border: 3px solid #1a237e;
  box-shadow: 0 6px 16px rgba(0,0,0,0.12);
  background: #f8fafc;
}

.id-card-front .member-details {
  padding: 0.5rem 1.4rem;
  flex: 1;
  position: relative;
  z-index: 2;
}

.id-card-front .detail-row {
  display: flex;
  font-size: 0.76rem;
  margin-bottom: 0.35rem;
  line-height: 1.3;
}

.id-card-front .detail-label {
  width: 72px;
  font-weight: 700;
  color: #475569;
  flex-shrink: 0;
}

.id-card-front .detail-val {
  font-weight: 600;
  color: #0f172a;
  word-break: break-word;
}

.id-card-front .detail-val.member-name-val {
  color: #1a237e;
  font-size: 0.85rem;
  font-weight: 800;
}

/* Hologram sticker simulation */
.holo-seal {
  position: absolute;
  right: 18px;
  bottom: 60px;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: radial-gradient(circle at 30% 30%, #ffd700, #ff8c00, #00ced1, #9400d3);
  opacity: 0.65;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 0.55rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border: 1px solid rgba(255,255,255,0.8);
  z-index: 4;
}

/* Wavy Blue Geometric Bottom */
.id-card-front .front-bottom-wave {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 52px;
  background: #1a237e;
  clip-path: polygon(0 40%, 100% 0, 100% 100%, 0 100%);
  display: flex;
  align-items: flex-end;
  justify-content: center;
  padding-bottom: 8px;
  z-index: 1;
}

.id-card-front .front-bottom-wave span {
  color: #ffffff;
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

/* ID Card Back */
.id-card-back {
  background: #ffffff;
  padding: 1.4rem 1.2rem 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.id-card-back .back-header-logo {
  width: 42px;
  height: 42px;
  object-fit: contain;
  margin-bottom: 0.2rem;
}

.id-card-back h5 {
  font-size: 0.82rem;
  font-weight: 800;
  color: #1a237e;
  margin: 0 0 0.5rem;
  text-transform: uppercase;
}

.id-card-back .qr-box {
  background: #ffffff;
  padding: 6px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  border: 1px solid #e2e8f0;
  margin-bottom: 0.6rem;
  display: inline-block;
}

.id-card-back .qr-box img {
  width: 105px;
  height: 105px;
  display: block;
}

.id-card-back .qr-caption {
  font-size: 0.6rem;
  font-weight: 700;
  color: #1a237e;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  margin-bottom: 0.6rem;
}

.id-card-back .terms-card {
  background: #f8fafc;
  border-radius: 10px;
  padding: 0.6rem 0.8rem;
  border: 1px solid #e2e8f0;
  text-align: left;
  font-size: 0.62rem;
  color: #334155;
  line-height: 1.35;
  width: 100%;
  margin-bottom: 0.6rem;
}

.id-card-back .terms-title {
  font-size: 0.65rem;
  font-weight: 800;
  color: #1a237e;
  text-transform: uppercase;
  margin-bottom: 0.2rem;
  display: block;
}

.id-card-back .sign-area {
  margin-top: auto;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  padding-bottom: 0.4rem;
}

.id-card-back .sign-box {
  text-align: center;
}

.id-card-back .sign-line {
  width: 120px;
  border-top: 1px dashed #64748b;
  margin-bottom: 3px;
}

.id-card-back .sign-label {
  font-size: 0.6rem;
  font-weight: 600;
  color: #475569;
}

.id-card-back .back-footer {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 24px;
  background: #1a237e;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 0.65rem;
  font-weight: 700;
}

/* ==========================================================================
   2. CERTIFICATE STYLES (HIGH-END ORNATE AWARD PRESENTATION)
   ========================================================================== */
.cert-container {
  width: 100%;
  max-width: 960px;
  background: #ffffff;
  padding: 24px;
  border-radius: 12px;
  box-shadow: 0 20px 48px rgba(0,0,0,0.15);
  font-family: 'Times New Roman', Times, serif;
}

.cert-outer-border {
  border: 4px solid #1a237e;
  padding: 6px;
  background: #fdfcf7;
  position: relative;
}

.cert-inner-border {
  border: 2px solid #c59b27;
  padding: 2.2rem 2rem 1.8rem;
  position: relative;
  text-align: center;
  background: radial-gradient(circle at center, #ffffff 40%, #fbf9f1 100%);
}

/* Decorative Gold Corner Florets */
.cert-corner {
  position: absolute;
  width: 32px;
  height: 32px;
  border-color: #c59b27;
  border-style: solid;
}
.cert-corner-tl { top: 4px; left: 4px; border-width: 3px 0 0 3px; }
.cert-corner-tr { top: 4px; right: 4px; border-width: 3px 3px 0 0; }
.cert-corner-bl { bottom: 4px; left: 4px; border-width: 0 0 3px 3px; }
.cert-corner-br { bottom: 4px; right: 4px; border-width: 0 3px 3px 0; }

.cert-logo {
  width: 64px;
  height: 64px;
  object-fit: contain;
  margin-bottom: 0.5rem;
}

.cert-org-name {
  font-size: 1.4rem;
  font-weight: 800;
  letter-spacing: 0.08em;
  color: #1a237e;
  text-transform: uppercase;
  margin: 0;
}

.cert-org-sub {
  font-size: 0.8rem;
  color: #64748b;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  margin-bottom: 1.2rem;
  letter-spacing: 0.04em;
}

.cert-title-badge {
  display: inline-block;
  font-size: 2.2rem;
  font-weight: 800;
  color: #1a237e;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin: 0.4rem 0 0;
  line-height: 1;
}

.cert-subtitle {
  font-size: 1.05rem;
  font-weight: 700;
  color: #c59b27;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  margin-bottom: 1.4rem;
}

.cert-presented-text {
  font-size: 1.05rem;
  font-style: italic;
  color: #475569;
  margin-bottom: 0.6rem;
}

.cert-member-name {
  font-size: 2.4rem;
  font-weight: 800;
  color: #1a237e;
  font-style: italic;
  margin: 0.4rem 0 1rem;
  text-decoration: underline;
  text-decoration-color: #c59b27;
  text-underline-offset: 8px;
}

.cert-citation {
  max-width: 680px;
  margin: 0 auto 2rem;
  font-size: 1rem;
  line-height: 1.6;
  color: #334155;
}

.cert-footer-row {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-top: 2rem;
  padding: 0 1.5rem;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.cert-medal {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: radial-gradient(circle at 30% 30%, #ffe066, #c59b27, #997300);
  box-shadow: 0 4px 14px rgba(197, 155, 39, 0.4);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #fff;
  border: 2px solid #fff;
  text-align: center;
  padding: 4px;
}

.cert-medal span {
  font-size: 0.55rem;
  font-weight: 800;
  text-transform: uppercase;
  line-height: 1.1;
  text-shadow: 0 1px 2px rgba(0,0,0,0.4);
}

.cert-sign-col {
  text-align: center;
}

.cert-sign-line {
  width: 160px;
  border-top: 1.5px solid #1a237e;
  margin: 0 auto 5px;
}

.cert-sign-title {
  font-size: 0.8rem;
  font-weight: 700;
  color: #1a237e;
}

.cert-sign-sub {
  font-size: 0.7rem;
  color: #64748b;
}

/* ==========================================================================
   3. APPOINTMENT LETTER STYLES (OFFICIAL EXECUTIVE LETTERHEAD)
   ========================================================================== */
.letter-paper {
  width: 100%;
  max-width: 820px;
  background: #ffffff;
  padding: 3rem 3rem 3rem;
  border-radius: 8px;
  box-shadow: 0 16px 40px rgba(0,0,0,0.12);
  font-family: 'Times New Roman', Times, serif;
  color: #1e293b;
  position: relative;
  overflow: hidden;
}

/* Watermark */
.letter-paper::after {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 320px;
  height: 320px;
  background-image: url('<?php echo $logo_uri; ?>');
  background-repeat: no-repeat;
  background-position: center;
  background-size: contain;
  opacity: 0.04;
  pointer-events: none;
  z-index: 1;
}

.letter-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 2px solid #1a237e;
  padding-bottom: 1.2rem;
  margin-bottom: 1.5rem;
  position: relative;
  z-index: 2;
}

.letter-brand {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.letter-logo {
  width: 58px;
  height: 58px;
  object-fit: contain;
}

.letter-brand-text h3 {
  font-size: 1.45rem;
  font-weight: 800;
  color: #1a237e;
  margin: 0;
  letter-spacing: 0.02em;
}

.letter-brand-text p {
  font-size: 0.8rem;
  color: #64748b;
  margin: 2px 0 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.letter-contact-meta {
  text-align: right;
  font-size: 0.78rem;
  color: #475569;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  line-height: 1.4;
}

.letter-meta-row {
  display: flex;
  justify-content: space-between;
  font-size: 0.9rem;
  margin-bottom: 1.2rem;
  font-weight: 600;
  color: #334155;
  position: relative;
  z-index: 2;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.letter-body {
  position: relative;
  z-index: 2;
  font-size: 1.05rem;
  line-height: 1.7;
}

.letter-recipient {
  margin-bottom: 1.4rem;
  line-height: 1.4;
}

.letter-subject {
  font-weight: 800;
  color: #1a237e;
  font-size: 1.1rem;
  margin: 1.2rem 0;
  text-decoration: underline;
  text-underline-offset: 4px;
}

.letter-body p {
  margin-bottom: 1rem;
  text-align: justify;
}

.letter-sign-block {
  margin-top: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  position: relative;
  z-index: 2;
}

.letter-sign-col h6 {
  font-size: 1rem;
  font-weight: 700;
  color: #1a237e;
  margin: 0.8rem 0 0;
}

.letter-sign-col p {
  margin: 0;
  font-size: 0.85rem;
  color: #64748b;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

/* ==========================================================================
   PRINT MEDIA STYLES
   ========================================================================== */
@media print {
  body * {
    visibility: hidden;
  }
  .doc-canvas-area, .doc-canvas-area * {
    visibility: visible;
  }
  .doc-canvas-area {
    position: absolute;
    left: 0;
    top: 0;
    width: 100% !important;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
  }
  .doc-action-bar, .sidenav, .navbar, .btn, .view-mode-toggle {
    display: none !important;
  }
  .pvc-card, .cert-container, .letter-paper {
    box-shadow: none !important;
    border: 1px solid #ccc !important;
    page-break-inside: avoid;
  }
}
</style>

<div class="container-fluid py-4 doc-viewer-wrapper">

  <!-- TOP ACTION BAR -->
  <div class="card doc-action-bar mb-4">
    <div class="card-body p-3 p-md-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <div class="d-flex align-items-center gap-2">
          <h4 class="mb-0 fw-bold text-dark"><?php echo html_escape($document_title); ?></h4>
          <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small rounded-pill">
            <i class="fa fa-check-circle me-1"></i>Official Verified
          </span>
        </div>
        <p class="text-muted small mb-0 mt-1">
          Document preview for <strong><?php echo html_escape($member['name'] ?? 'Member'); ?></strong>
          &bull; ID: <code><?php echo html_escape($member_code); ?></code>
        </p>
      </div>

      <!-- Action Buttons (Download Options) -->
      <div class="d-flex flex-wrap align-items-center gap-2">
        <!-- Download as Image (PNG) -->
        <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm" id="btnDownloadPhoto" onclick="downloadDocumentImage()">
          <i class="fa fa-image me-1"></i>Download Image (PNG)
        </button>

        <!-- Download PDF -->
        <a href="<?php echo html_escape($download_url); ?>" class="btn btn-outline-danger btn-sm px-3 shadow-sm" id="btnDownloadPdf">
          <i class="fa fa-file-pdf me-1"></i>Download PDF
        </a>

        <!-- Print Document -->
        <button type="button" class="btn btn-outline-secondary btn-sm px-3 shadow-sm" onclick="window.print()">
          <i class="fa fa-print me-1"></i>Print
        </button>

        <!-- Back Button -->
        <a href="<?php echo !empty($back_url) ? html_escape($back_url) : site_url('admin'); ?>" class="btn btn-light btn-sm px-3 border shadow-sm">
          <i class="fa fa-arrow-left me-1"></i>Back
        </a>
      </div>
    </div>
  </div>

  <!-- DOCUMENT CANVAS AREA -->
  <div class="doc-canvas-area" id="docCanvasArea">

    <!-- ==================================================================== -->
    <!-- 1. ID CARD VIEW                                                      -->
    <!-- ==================================================================== -->
    <?php if ($document_type === 'id-card'): ?>
      <div class="id-cards-grid" id="printableDoc">
        
        <!-- CARD FRONT -->
        <div class="pvc-card id-card-front">
          <div class="lanyard-slot"></div>
          
          <div class="front-header">
            <img src="<?php echo $logo_uri; ?>" class="ngo-logo-front" alt="Logo">
            <div class="ngo-title-box">
              <h5><?php echo html_escape($org_name); ?></h5>
              <small>www.sfofindia.org</small>
            </div>
          </div>

          <div class="photo-wrap">
            <?php if (!empty($member_photo)): ?>
              <img src="<?php echo $member_photo; ?>" class="member-photo" alt="<?php echo html_escape($member['name']); ?>">
            <?php else: ?>
              <div class="member-photo d-flex align-items-center justify-content-center text-muted">
                <i class="fa fa-user fa-3x"></i>
              </div>
            <?php endif; ?>
          </div>

          <div class="member-details">
            <div class="detail-row">
              <span class="detail-label">Name :</span>
              <span class="detail-val member-name-val"><?php echo html_escape($member['name']); ?></span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Role :</span>
              <span class="detail-val text-capitalize"><?php echo html_escape($member['role'] ?? 'Member'); ?></span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Mobile :</span>
              <span class="detail-val"><?php echo html_escape($member['mobile'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-row">
              <span class="detail-label">ID No. :</span>
              <span class="detail-val fw-bold"><?php echo html_escape($member_code); ?></span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Valid Thru :</span>
              <span class="detail-val"><?php echo html_escape($valid_thru); ?></span>
            </div>
          </div>

          <div class="holo-seal">SEAL</div>

          <div class="front-bottom-wave">
            <span>sfofindia.org</span>
          </div>
        </div>

        <!-- CARD BACK -->
        <div class="pvc-card id-card-back">
          <div class="lanyard-slot"></div>

          <img src="<?php echo $logo_uri; ?>" class="back-header-logo" alt="Logo">
          <h5><?php echo html_escape($org_name); ?></h5>

          <div class="qr-box">
            <?php if (!empty($qr_data_uri)): ?>
              <img src="<?php echo $qr_data_uri; ?>" alt="Verification QR">
            <?php endif; ?>
          </div>
          <div class="qr-caption">Scan to Verify Member Authenticity</div>

          <div class="terms-card">
            <span class="terms-title"><i class="fa fa-shield-alt me-1"></i>Terms &amp; Conditions</span>
            &bull; This ID card is property of <?php echo html_escape($org_name); ?>.<br>
            &bull; Non-transferable &amp; must be presented on request.<br>
            &bull; If found, return to nearest NGO office.<br>
            &bull; Valid with authorized signature only.
          </div>

          <div class="sign-area">
            <div class="sign-box text-start">
              <small class="text-muted d-block" style="font-size:0.55rem;">Authority:</small>
              <strong style="font-size:0.62rem; color:#1a237e;">Headquarters</strong>
            </div>
            <div class="sign-box">
              <div class="sign-line"></div>
              <span class="sign-label">Authorized Signatory</span>
            </div>
          </div>

          <div class="back-footer">
            <span>www.sfofindia.org</span>
          </div>
        </div>

      </div>
    <?php endif; ?>

    <!-- ==================================================================== -->
    <!-- 2. CERTIFICATE VIEW                                                  -->
    <!-- ==================================================================== -->
    <?php if ($document_type === 'certificate'): ?>
      <div class="cert-container" id="printableDoc">
        <div class="cert-outer-border">
          <div class="cert-inner-border">
            <div class="cert-corner cert-corner-tl"></div>
            <div class="cert-corner cert-corner-tr"></div>
            <div class="cert-corner cert-corner-bl"></div>
            <div class="cert-corner cert-corner-br"></div>

            <img src="<?php echo $logo_uri; ?>" class="cert-logo" alt="Emblem">
            <h2 class="cert-org-name"><?php echo html_escape($org_name); ?></h2>
            <div class="cert-org-sub">Registered Non-Governmental Organization &bull; www.sfofindia.org</div>

            <div class="cert-title-badge">Certificate</div>
            <div class="cert-subtitle">Of Appreciation &amp; Membership</div>

            <div class="cert-presented-text">This is proudly presented to</div>

            <div class="cert-member-name"><?php echo html_escape($member['name']); ?></div>

            <div class="cert-citation">
              In grateful recognition of your valuable support, commitment, and dedicated contribution towards the humanitarian programs, community empowerment, and social welfare mission of <strong><?php echo html_escape($org_name); ?></strong>.
            </div>

            <div class="cert-footer-row">
              <div class="text-start" style="font-size:0.8rem; color:#475569;">
                <div><strong>Issue Date:</strong> <?php echo html_escape($issue_date); ?></div>
                <div><strong>Certificate ID:</strong> <?php echo html_escape($member_code); ?></div>
              </div>

              <div class="cert-medal">
                <i class="fa fa-award fa-lg mb-1"></i>
                <span>Official<br>Seal</span>
              </div>

              <div class="text-center" style="width:110px;">
                <?php if (!empty($qr_data_uri)): ?>
                  <img src="<?php echo $qr_data_uri; ?>" style="width:70px; height:70px;" alt="QR Code">
                  <div style="font-size:0.55rem; color:#64748b; margin-top:2px;">Scan to Verify</div>
                <?php endif; ?>
              </div>

              <div class="cert-sign-col">
                <div class="cert-sign-line"></div>
                <div class="cert-sign-title">Authorized Signatory</div>
                <div class="cert-sign-sub"><?php echo html_escape($org_name); ?></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- ==================================================================== -->
    <!-- 3. APPOINTMENT LETTER VIEW                                           -->
    <!-- ==================================================================== -->
    <?php if ($document_type === 'appointment-letter'): ?>
      <div class="letter-paper" id="printableDoc">
        <div class="letter-header">
          <div class="letter-brand">
            <img src="<?php echo $logo_uri; ?>" class="letter-logo" alt="Logo">
            <div class="letter-brand-text">
              <h3><?php echo html_escape($org_name); ?></h3>
              <p>Empowering Individuals, Strengthening Society &bull; sfofindia.org</p>
            </div>
          </div>
          <div class="letter-contact-meta">
            <div>www.sfofindia.org</div>
            <div>info@sfofindia.org</div>
            <div>+91 12345 67890</div>
          </div>
        </div>

        <div class="letter-meta-row">
          <div><strong>Ref. No.:</strong> <?php echo html_escape($ref_no); ?></div>
          <div><strong>Date:</strong> <?php echo html_escape($issue_date); ?></div>
        </div>

        <div class="letter-body">
          <div class="letter-recipient">
            <strong>To,</strong><br>
            <span class="fw-bold fs-5 text-primary"><?php echo html_escape($member['name']); ?></span><br>
            <span class="text-muted text-capitalize"><?php echo html_escape($member['role'] ?? 'Member'); ?></span><br>
            <span>Member ID: <strong><?php echo html_escape($member_code); ?></strong></span><br>
            <?php if (!empty($member['address'])): ?>
              <span><?php echo html_escape($member['address']); ?></span>
            <?php endif; ?>
          </div>

          <div class="letter-subject">
            Subject: Official Letter of Appointment as Active Member
          </div>

          <p>
            Dear <strong><?php echo html_escape($member['name']); ?></strong>,
          </p>

          <p>
            Greetings from <strong><?php echo html_escape($org_name); ?></strong>.
          </p>

          <p>
            We are pleased to formally welcome and appoint you as an <strong>Active Member</strong> of our organization. We are a collective of dedicated individuals working towards empowering communities, promoting educational opportunities, improving healthcare access, and advancing social welfare initiatives for an equitable and inclusive society.
          </p>

          <p>
            We appreciate your commitment and enthusiasm to support our programs. As an active member, you will play a vital role in our community outreach and mission initiatives. We look forward to your valuable association, continuous leadership, and long-term collaboration.
          </p>

          <p>
            Thank you for stepping forward to make a meaningful difference.
          </p>

          <div class="letter-sign-block">
            <div class="letter-sign-col">
              <p>Warm regards,</p>
              <div style="height: 40px;"></div>
              <h6>Authorized Signatory</h6>
              <p><?php echo html_escape($org_name); ?></p>
            </div>

            <div class="text-center" style="width: 120px;">
              <?php if (!empty($qr_data_uri)): ?>
                <img src="<?php echo $qr_data_uri; ?>" style="width: 80px; height: 80px;" alt="QR Code">
                <div style="font-size: 0.6rem; color: #1a237e; font-weight: 700; margin-top: 4px;">
                  SCAN TO VERIFY AUTHENTICITY
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>

<script>
// Download Document as High-Resolution PNG Image
function downloadDocumentImage() {
  const target = document.getElementById('printableDoc');
  const btn = document.getElementById('btnDownloadPhoto');
  if (!target) return;

  const originalText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i>Generating Photo...';

  const docTitle = '<?php echo html_escape(preg_replace("/[^a-zA-Z0-9_-]/", "_", ($member["name"] ?? "member") . "_" . $document_type)); ?>';

  html2canvas(target, {
    scale: 2, // High-DPI capture for razor-sharp quality
    useCORS: true,
    logging: false,
    backgroundColor: '#ffffff'
  }).then(function(canvas) {
    const link = document.createElement('a');
    link.download = docTitle + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
    btn.disabled = false;
    btn.innerHTML = originalText;
  }).catch(function(err) {
    console.error('Photo generation failed:', err);
    alert('Could not generate photo directly. Please use the Print or PDF option.');
    btn.disabled = false;
    btn.innerHTML = originalText;
  });
}
</script>
