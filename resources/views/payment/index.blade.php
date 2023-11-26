<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Payment Page</h1>

    <form id="payment-form">
        <div>
            <label for="amount">Amount (in cents):</label>
            <input type="text" id="amount" name="amount" required>
        </div>

        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>

        <button type="button" id="submit">
            Pay Now
        </button>
    </form>

    <script>
        // Set your publishable key
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');

        // Create an instance of Elements
        const elements = stripe.elements();

        // Create an instance of the card Element.
        const card = elements.create('card');

        // Add an instance of the card Element into the `card-element` div.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        const submitButton = document.getElementById('submit');
        submitButton.addEventListener('click', async function() {
            const { token, error } = await stripe.createToken(card);

            if (error) {
                // Inform the user if there was an error.
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(token);
            }
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            fetch('/create-payment-intent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ amount: document.getElementById('amount').value, token: token.id }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.client_secret) {
                    stripe.confirmCardPayment(data.client_secret, {
                        payment_method: {
                            card: card,
                        },
                    })
                    .then(result => {
                        if (result.error) {
                            // Show error to your customer
                            console.error(result.error.message);
                        } else {
                            // The payment succeeded!
                            window.location.href = '/payment-success';
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
