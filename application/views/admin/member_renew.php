<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <?php if (($member['status'] ?? '') === 'inactive'): ?>
                <div class="alert alert-danger text-white" role="alert">
                    <span class="text-sm">Your membership expired on <b><?php echo html_escape($member['validity_end'] ?? '—'); ?></b>. Renew now to regain access to documents and your member benefits.</span>
                </div>
            <?php elseif (!empty($member['validity_end'])): ?>
                <div class="alert alert-info text-white" role="alert">
                    <span class="text-sm">Your current membership is valid until <b><?php echo html_escape($member['validity_end']); ?></b>. You can renew early to extend it by a year from today.</span>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-header bg-gradient-indigo p-4 text-center">
                    <div class="bg-white d-inline-flex p-3 rounded-circle mb-3 shadow-lg">
                        <i class="material-symbols-rounded text-indigo" style="font-size: 40px;">autorenew</i>
                    </div>
                    <h3 class="text-white mb-0 font-weight-bolder">Renew Membership</h3>
                    <p class="text-white opacity-8 mb-0 text-sm">One year of membership for a flat fee.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div id="renew_form_wrapper">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label form-control-label">Name</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" value="<?php echo html_escape($member['name']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label form-control-label">Email</label>
                                <div class="input-group input-group-outline">
                                    <input type="email" class="form-control" value="<?php echo html_escape($member['email']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-12 text-center my-3">
                                <h6 class="text-muted text-xs text-uppercase font-weight-bold mb-2">Renewal Fee</h6>
                                <div class="font-weight-bolder text-indigo" style="font-size: 40px;">₹<?php echo (int) $fee; ?></div>
                                <p class="text-xs text-muted mb-0">Extends your membership by 1 year from today's payment date.</p>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" id="renew_now_btn" class="btn btn-lg bg-gradient-indigo rounded-pill px-6 shadow-primary shadow-lg transition-all mb-0">
                                Renew Now — Pay ₹<?php echo (int) $fee; ?> <i class="material-symbols-rounded ms-2 align-middle">arrow_forward</i>
                            </button>
                            <p class="text-xxs text-muted mt-3"><i class="material-symbols-rounded text-xs align-middle me-1">verified_user</i> Secured by Razorpay</p>
                        </div>
                    </div>

                    <!-- Processing State -->
                    <div id="renew_processing" class="text-center d-none py-5">
                        <div class="spinner-border text-indigo mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h5>Processing your renewal...</h5>
                        <p class="text-muted">Please do not close this window.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Razorpay Checkout JS -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const fee = <?php echo (int) $fee; ?>;
    const payBtn = document.getElementById('renew_now_btn');

    payBtn.addEventListener('click', async function() {
        payBtn.disabled = true;
        payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Initializing...';

        try {
            // 1. Create Order (amount is fixed server-side, never sent from here)
            const res = await fetch('<?php echo site_url("admin/renew_create_order"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({})
            });
            const order = await res.json();

            if (!order.success) {
                Swal.fire('Failed', order.error || 'Server error', 'error');
                resetBtn();
                return;
            }

            // 2. Open Razorpay
            const options = {
                "key": "<?php echo html_escape($rzp_key); ?>",
                "amount": order.amount,
                "currency": order.currency,
                "name": "Shaheed Foundation",
                "description": "Membership Renewal",
                "order_id": order.orderId,
                "handler": async function (response) {
                    verifyPayment(response);
                },
                "prefill": {
                    "name": "<?php echo $member['name']; ?>",
                    "email": "<?php echo $member['email']; ?>",
                    "contact": "<?php echo $member['mobile']; ?>"
                },
                "theme": { "color": "#1a685b" },
                "modal": { "ondismiss": function() { resetBtn(); } }
            };
            const rzp = new Razorpay(options);
            rzp.open();

        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Could not initiate payment. Check internet/config.', 'error');
            resetBtn();
        }
    });

    async function verifyPayment(rzpResponse) {
        document.getElementById('renew_form_wrapper').classList.add('d-none');
        document.getElementById('renew_processing').classList.remove('d-none');

        try {
            const res = await fetch('<?php echo site_url("admin/renew_verify_payment"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    razorpay_order_id: rzpResponse.razorpay_order_id,
                    razorpay_payment_id: rzpResponse.razorpay_payment_id,
                    razorpay_signature: rzpResponse.razorpay_signature
                })
            });
            const data = await res.json();

            if (data.ok) {
                Swal.fire({
                    title: 'Membership Renewed!',
                    text: 'You are active until ' + data.validity_end + '.',
                    icon: 'success',
                    confirmButtonText: 'Go to Profile'
                }).then(() => {
                    window.location.href = '<?php echo site_url("admin/profile"); ?>';
                });
            } else {
                Swal.fire('Verification Failed', data.error, 'error');
                document.getElementById('renew_form_wrapper').classList.remove('d-none');
                document.getElementById('renew_processing').classList.add('d-none');
                resetBtn();
            }
        } catch (err) {
            Swal.fire('Network Error', 'Payment may have succeeded but verification failed. Please contact the NGO.', 'warning');
        }
    }

    function resetBtn() {
        payBtn.disabled = false;
        payBtn.innerHTML = 'Renew Now — Pay ₹' + fee + ' <i class="material-symbols-rounded ms-2 align-middle">arrow_forward</i>';
    }
});
</script>

<style>
.bg-gradient-indigo { background: linear-gradient(135deg, #134e4a 0%, #1a685b 100%); }
.text-indigo { color: #1a685b !important; }
.shadow-primary { box-shadow: 0 4px 14px 0 rgba(26, 104, 91, 0.28); }
.px-6 { padding-left: 3rem; padding-right: 3rem; }
.form-control-label { font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px; color: #7b809a; }
</style>
