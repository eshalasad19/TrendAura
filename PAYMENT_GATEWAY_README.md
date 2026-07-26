# Payment Gateway — Currently in Test/Dummy Mode

`web/checkout.php` currently only offers **Cash on Delivery (COD)**. Card / JazzCash /
Easypaisa options were removed for now (see conversation history) — COD is real and
works as expected. `payment_status` stays `Unpaid` until an order is marked
`Delivered` in the admin panel, at which point it automatically flips to `Paid`
(COD is paid on delivery).

## How to add a real gateway later

When you're ready to integrate JazzCash, Easypaisa, or Stripe for real:

1. Get merchant/API credentials from the provider and add them to `.env` (same
   pattern as the Gmail credentials — never hardcode them in the PHP file).
2. Add a new payment method option back into the checkout form in `web/checkout.php`,
   and redirect to the gateway's hosted checkout page after "Place order" (most
   Pakistani gateways like JazzCash/Easypaisa work this way — you POST order details
   to their endpoint and they redirect the customer to pay, then redirect back to you).
3. In `web/checkout.php`, the line that currently sets:
   ```php
   $payment_status = 'Unpaid';
   ```
   should instead check the actual callback/webhook response from the gateway before
   marking an order as `Paid`. Never mark an order `Paid` just because the user
   reached a "success" page — always verify server-to-server with the gateway's
   callback/webhook, since the success page URL can be visited without an actual
   payment.
4. Add a dedicated `payment-callback.php` (or similar) that the gateway calls after
   payment, which verifies the transaction and updates `orderr.payment_status`
   accordingly.

Until then, everything about the order flow (email, tracking, admin dashboard, stock
deduction) already works correctly with the COD/dummy flow, so switching to a real
gateway later is a contained change — you're not touching the tracking system, the
emails, or the admin dashboard.
