class SubscriptionForm {
    stripe = null;

    constructor(module, element = '#subscription-form', options = {}) {
        this.module = module;
        this.element = element;
        this.paymentMethod = $('#method');
        this.options = options;
        this.init();
    }

    init() {
        const self = this;

        $(document).on('submit', this.element, async function (event) {
            if (event.isDefaultPrevented()) {
                return false;
            }

            event.preventDefault();

            let form = $(this);
            let formData = new FormData(form[0]);
            let btnsubmit = form.find("button[type=submit]");
            let currentText = btnsubmit.html();
            let currentIcon = btnsubmit.find('i').attr('class');

            $('#payment-message').empty();
            btnsubmit.find('i').attr('class', 'fa fa-spinner fa-spin');
            btnsubmit.prop("disabled", true);

            if (btnsubmit.data('loading-text')) {
                btnsubmit.html('<i class="fa fa-spinner fa-spin"></i> ' + btnsubmit.data('loading-text'));
            }

            if (formData.get('method') === 'Stripe') {
                const {token, error} = await self.getStripe().createToken(self.cardNumber,
                    {
                        name: document.getElementById('cardholder-name').value
                    }
                );

                if (error) {
                    self.sendMessageByResponse({success: false, message: error.message});
                } else {
                    // Thêm token vào form trước khi submit
                    formData.set('token', token.id);
                }
            }

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location = response.redirect;
                        }, 1000);
                        return false;
                    }

                    btnsubmit.find('i').attr('class', currentIcon);
                    btnsubmit.prop("disabled", false);

                    if (btnsubmit.data('loading-text')) {
                        btnsubmit.html(currentText);
                    }

                    if (response.success === false) {
                        return false;
                    }

                    if (response.type === 'redirect') {
                        window.location.href = response.redirect;
                        return false;
                    }

                    if (response.type === 'embed') {
                        let htm = `<iframe src="${response.embed_url}" width="100%" height="350px" frameborder="0"></iframe>`;
                        if ($('#payment-container').length) {
                            $('#payment-container').html(htm);
                        } else {
                            form.html(htm);
                        }
                        
                        self.checkStatus(response.payment_history_id);

                        return false;
                    }

                    if (self.options.onSuccess) {
                        self.options.onSuccess(response);
                    } else {
                        self.sendMessageByResponse(response);
                    }
                },
                error: function (jqxhr, textStatus, errorThrown) {
                    let response = jqxhr.responseJSON;

                    btnsubmit.find('i').attr('class', currentIcon);
                    btnsubmit.prop("disabled", false);

                    if (btnsubmit.data('loading-text')) {
                        btnsubmit.html(currentText);
                    }

                    if (self.options.onError) {
                        self.options.onError(response);
                    }
                }
            });
        });

        this.paymentMethod.on('change', function(e) {
            let method = $(this).val();

            if (method === 'Stripe') {
                const stripe = self.getStripe();
                if (!stripe) {
                    return;
                }

                let formCard = `<div class="form-group">
                    <label for="cardholder-name">${self.options.language.cardholder_name}</label>
                    <input id="cardholder-name" class="form-control" type="text" placeholder="John Doe" required>
                </div>

                <div class="form-group">
                    <label for="card-number">${self.options.language.card_number}</label>
                    <div id="card-number" class="form-control"></div>
                </div>

                <div class="form-group">
                    <label for="card-expiry">${self.options.language.expiry_date}</label>
                    <div id="card-expiry" class="form-control"></div>
                </div>

                <div class="form-group">
                    <label for="card-cvc">${self.options.language.cvc}</label>
                    <div id="card-cvc" class="form-control"></div>
                </div>

                <small id="card-errors" class="form-text text-danger mb-3"></small>`;

                $('#form-card').html(formCard);

                const elements = stripe.elements();
                const style = {
                    base: {
                        color: "#32325d",
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: "antialiased",
                        fontSize: "16px",
                        "::placeholder": { color: "#aab7c4" }
                    },
                    invalid: { color: "#dc3545", iconColor: "#dc3545" }
                };

                self.cardNumber = elements.create("cardNumber", { style });
                self.cardNumber.mount("#card-number");

                self.cardExpiry = elements.create("cardExpiry", { style });
                self.cardExpiry.mount("#card-expiry");

                self.cardCvc = elements.create("cardCvc", { style });
                self.cardCvc.mount("#card-cvc");

                // Validation errors
                [self.cardNumber, self.cardExpiry, self.cardCvc].forEach(element => {
                    element.on("change", function(event) {
                        const displayError = document.getElementById("card-errors");
                        displayError.textContent = event.error ? event.error.message : "";
                    });
                });
            } else {
                $('#form-card').html('');
                self.cardNumber = null;
                self.cardExpiry = null;
                self.cardCvc = null;
            }
        });
    }

    checkStatus(paymentHistoryId) {
        const self = this;
        
        let interval = setInterval(function() {
            $.ajax({
                type: 'GET',
                url: `/payment/${self.module}/status/${paymentHistoryId}`,
                dataType: 'json',
                success: function(response) {
                    let status = response.status;
                    
                    if (status === 'pending' || status === 'processing') {
                        return;
                    }
                    
                    if (self.options.onSuccess && status === 'success') {
                        self.options.onSuccess(response);
                    }
                    
                    if (status === 'failed' && self.options.onError) {
                        self.options.onError(response);
                    }

                    clearInterval(interval);
                }.bind(this),
                error: function(jqxhr) {
                    if (self.options.onError) {
                        self.options.onError(jqxhr);
                    }

                    clearInterval(interval);
                }.bind(this)
            });
        }, 2000);
    }

    sendMessageByResponse(response) {
        let msg = get_message_response(response);
        console.log(msg);
        if (! msg) {
            return;
        }

        $('#payment-message').html(`<div class="alert alert-${msg.success ? 'success' : 'danger'}">${msg.message}</div>`);
    }

    getStripe() {
        if (this.stripe) {
            return this.stripe;
        }

        if (!this.options.stripePublishKey) {
            this.sendMessageByResponse({success: false, message: this.options.language.stripe_publish_key_not_set});
            return null;
        }

        this.stripe = Stripe(this.options.stripePublishKey);
        return this.stripe;
    }
}
