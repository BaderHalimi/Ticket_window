<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <head>
        <script
            src="https://assets.ottu.net/checkout/v3/checkout.min.js"
            data-error="{{ route('payment.error') }}"
            data-cancel="{{route('payment.cancel')}}"
            data-success="{{ route('payment.success') }}"
            data-beforepayment="beforePayment"></script>
    </head>
</head>

<body>
    <div id="checkout"></div>
    <script>
        // Checkout.reload();
        Checkout.init({
            selector: 'checkout',
            merchant_id: 'localhost:8000',
            session_id: '{{ session()->getId() }}',
            apiKey: '1287348f-8b2c-4d3a-9e1f-5c6d7e8f9a0b',
            // Default values configured for Apple Pay
            applePayInit: {
                version: 6,
                buttonLocale: 'en',
                supportedNetworks: ['amex', 'masterCard', 'maestro', 'visa', 'mada'],
                merchantCapabilities: ['supports3DS']
                // Remaining values are configured via init checkout API
            },
            googlePayInit: {
                apiVersion: 2,
                apiVersionMinor: 0,
                allowedCardNetworks: ["AMEX", "DISCOVER",
                    "INTERAC", "JCB", "MASTERCARD", "VISA"
                ],
                allowedCardAuthMethods: ["PAN_ONLY",
                    "CRYPTOGRAM_3DS"
                ],
                allowPrepaidCards: true,
                allowCreditCards: true,
                billingAddressRequired: false,
                assuranceDetailsRequired: false,
                existingPaymentMethodRequired: true,
                tokenizationSpecificationType: 'PAYMENT_GATEWAY',
                totalPriceStatus: 'FINAL',
                totalPriceLabel: 'TOTAL',
                buttonLocale: 'en',
                // Remaining Values are configured via
                // init checkout API
            }
        });
    </script>
</body>

</html>
