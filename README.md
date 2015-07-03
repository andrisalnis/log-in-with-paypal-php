#Log in users with PayPal using PHP

1. Create a new PayPal app: https://developer.paypal.com/developer/applications
2. Don't forget to set the return page URL
3. Get credentials:
![alt tag](http://i.snag.gy/Hb31q.jpg)
4. Edit **index.php** and set *$paypal_client_id*, *$paypal_secret* and *$app_return_url*
5. *(Optional)* If you want to grab more than just user's email & paypal id then change information requested from customers in your PayPal app's settings and set *$scope* in **index.php** (more info: https://developer.paypal.com/docs/integration/direct/identity/attributes/)
