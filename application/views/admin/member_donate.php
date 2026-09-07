<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-header bg-gradient-indigo p-4 text-center">
                    <div class="bg-white d-inline-flex p-3 rounded-circle mb-3 shadow-lg">
                        <i class="material-symbols-rounded text-indigo" style="font-size: 40px;">volunteer_activism</i>
                    </div>
                    <h3 class="text-white mb-0 font-weight-bolder">Support Our Mission</h3>
                    <p class="text-white opacity-8 mb-0 text-sm">Your contribution drives social change and saves lives.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div id="donation_form_wrapper">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label form-control-label">Donor Name</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" id="donor_name" class="form-control" value="<?php echo html_escape($member['name']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label form-control-label">Contact Email</label>
                                <div class="input-group input-group-outline">
                                    <input type="email" id="donor_email" class="form-control" value="<?php echo html_escape($member['email']); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-12 text-center my-4">
                                <h6 class="text-muted text-xs text-uppercase font-weight-bold mb-3">Select or Enter Amount (INR)</h6>
                                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                                    <button type="button" class="btn btn-outline-indigo rounded-pill px-4 amt-preset" data-val="500">₹500</button>
                                    <button type="button" class="btn btn-outline-indigo rounded-pill px-4 amt-preset" data-val="1000">₹1000</button>
                                    <button type="button" class="btn btn-outline-indigo rounded-pill px-4 amt-preset" data-val="2500">₹2500</button>
                                    <button type="button" class="btn btn-outline-indigo rounded-pill px-4 amt-preset" data-val="5000">₹5000</button>
                                </div>
                                <div class="col-md-6 mx-auto">
                                    <div class="input-group input-group-lg input-group-outline">
                                        <span class="input-group-text px-3 text-indigo font-weight-bold">₹</span>
                                        <input type="number" id="donation_amount" class="form-control text-center font-weight-bolder" placeholder="Enter custom amount" style="font-size: 24px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="button" id="pay_now_btn" class="btn btn-lg bg-gradient-indigo rounded-pill px-6 shadow-primary shadow-lg transition-all mb-0">
                                Proceed to Payment <i class="material-symbols-rounded ms-2 align-middle">arrow_forward</i>
                            </button>
                            <p class="text-xxs text-muted mt-3"><i class="material-symbols-rounded text-xs align-middle me-1">verified_user</i> Secured by Razorpay Interface</p>
                        </div>
                    </div>

                    <!-- Success / Processing State -->
                    <div id="payment_processing" class="text-center d-none py-5">
                        <div class="spinner-border text-indigo mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h5>Processing your donation...</h5>
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
    const amtInput = document.getElementById('donation_amount');
    const presets = document.querySelectorAll('.amt-preset');
    const payBtn = document.getElementById('pay_now_btn');

    presets.forEach(btn => {
        btn.addEventListener('click', () => {
            presets.forEach(b => b.classList.replace('btn-indigo', 'btn-outline-indigo'));
            btn.classList.replace('btn-outline-indigo', 'btn-indigo');
            amtInput.value = btn.getAttribute('data-val');
        });
    });

    payBtn.addEventListener('click', async function() {
        const amount = amtInput.value;
        if (!amount || amount < 1) {
            Swal.fire('Error', 'Please enter a valid donation amount (Min ₹1)', 'error');
            return;
        }

        payBtn.disabled = true;
        payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Initializing...';

        try {
            // 1. Create Order
            const res = await fetch('<?php echo site_url("donations/create_order"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ amount: amount })
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
                "description": "Donation for Social Causes",
                "order_id": order.orderId,
                "handler": async function (response) {
                    verifyPayment(response, amount);
                },
                "prefill": {
                    "name": "<?php echo $member['name']; ?>",
                    "email": "<?php echo $member['email']; ?>",
                    "contact": "<?php echo $member['mobile']; ?>"
                },
                "theme": { "color": "#4f46e5" },
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

    async function verifyPayment(rzpResponse, amount) {
        document.getElementById('donation_form_wrapper').classList.add('d-none');
        document.getElementById('payment_processing').classList.remove('d-none');

        try {
            const res = await fetch('<?php echo site_url("donations/verify_payment"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    razorpay_order_id: rzpResponse.razorpay_order_id,
                    razorpay_payment_id: rzpResponse.razorpay_payment_id,
                    razorpay_signature: rzpResponse.razorpay_signature,
                    name: "<?php echo $member['name']; ?>",
                    email: "<?php echo $member['email']; ?>",
                    mobile: "<?php echo $member['mobile']; ?>",
                    amount: amount
                })
            });
            const data = await res.json();

            if (data.ok) {
                Swal.fire({
                    title: 'Thank You! ❤️',
                    text: 'Your donation of ₹' + amount + ' was successful.',
                    icon: 'success',
                    confirmButtonText: 'View History'
                }).then(() => {
                    window.location.href = '<?php echo site_url("admin/donation_history"); ?>';
                });
            } else {
                Swal.fire('Verification Failed', data.error, 'error');
                resetBtn();
                document.getElementById('donation_form_wrapper').classList.remove('d-none');
                document.getElementById('payment_processing').classList.add('d-none');
            }
        } catch (err) {
            Swal.fire('Network Error', 'Payment was successful but verification failed. Please contact NGO.', 'warning');
        }
    }

    function resetBtn() {
        payBtn.disabled = false;
        payBtn.innerHTML = 'Proceed to Payment <i class="material-symbols-rounded ms-2 align-middle">arrow_forward</i>';
    }
});
</script>

<style>
.bg-gradient-indigo { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
.text-indigo { color: #4f46e5 !important; }
.btn-outline-indigo { border-color: #4f46e5; color: #4f46e5; }
.btn-outline-indigo:hover, .btn-indigo { background-color: #4f46e5; color: #fff; border-color: #4f46e5; }
.shadow-primary { box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.39); }
.px-6 { padding-left: 3rem; padding-right: 3rem; }
.form-control-label { font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px; color: #7b809a; }
</style>
