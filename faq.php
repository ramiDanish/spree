<?php include 'includes/header.php'; ?>

<div class="container mt-4 mb-4">
    <h2>Frequently Asked Questions</h2>

    <div class="accordion" id="faqAccordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        What is your return policy?
                    </button>
                </h5>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                <div class="card-body">
                    We offer a 30-day money-back guarantee. If you're not satisfied with your purchase, you can return it within 30 days for a full refund.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        How long does shipping take?
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                <div class="card-body">
                    Shipping typically takes 5-7 business days. You will receive a tracking number once your order has been shipped.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Do you offer international shipping?
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                <div class="card-body">
                    Yes, we ship internationally! Additional shipping charges may apply.
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>