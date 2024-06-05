<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paypal Payment</title>
    <script src="https://www.paypal.com/sdk/js?client-id=ARlRaIrD8H5JDXRBfDteyoESRQxHL0eZ7upm0fz8f_qbk1EJSrAs-5KSnKZ20wQ4sLZAYHuSfxYPF8H4"></script>

</head>
<body>
    <div id="paypal-button-container"></div>

<script>
    paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and currency code
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '20'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction completed by ' + details.payer.name.given_name);
                });
            }
        }).render('#paypal-button-container');
</script>
</body>
</html>


