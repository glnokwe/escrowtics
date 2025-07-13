\== Escrowtics ==
Contributors: Godlove N. Nokwe
Donate link: #
Tags: escrow, payments, PayPal, marketplace, transactions, WordPress plugin
Requires at least: 5.6
Tested up to: 6.5
Stable tag: 1.0.0
License: GPLv2 or later
License URI: [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)

A simple yet powerful escrow plugin for WordPress to manage secure transactions between users.

\== Description ==
Escrowtics is a WordPress plugin that provides seamless escrow functionality for marketplaces and service-based platforms. With integrated PayPal support, real-time status updates, role-based workflows, and dispute resolution tools, Escrowtics ensures both buyers and sellers are protected during online transactions.

**Key Features:**

* Secure payment handling using PayPal & Bitcoin (via blokonomics) integration
* Role-based transaction control (buyer, seller, admin)
* Escrow wallet balances and automatic updates
* Admin approval and dispute management interfaces
* AJAX-powered forms and SweetAlert confirmation dialogs
* Email notifications with custom branding and HTML formatting
* Custom database tables for full control and scalability

Built with performance and simplicity in mind, Escrowtics requires no third-party services or external webhook configuration. It is ideal for freelancers, service providers, and online marketplaces.

\== Installation ==

1. Upload the `escrowtics` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to the "Escrowtics" settings page to configure PayPal credentials and transaction roles
4. Add the shortcode " [escrot_account] " to your desired frontend page (empty full width page)

\== Frequently Asked Questions ==
\= How do I enable PayPal payments? =
Go to Escrowtics > Settings and enter your PayPal API credentials (client ID and secret).

\= Does it work with custom post types? =
Escrowtics operates independently of WordPress post types, using its own database structure.

\= Can I customize emails sent by the plugin? =
Yes, email messages use HTML formatting and include your site branding.

\== Screenshots ==

1. Admin dashboard for managing escrow transactions
2. Seller's view of pending approvals and received funds
3. Buyer's interface for initiating escrow payment
4. SweetAlert confirmation dialog before submitting forms

\== Changelog ==
\= 1.0.0 =

* Initial release
* Bitcoin & PayPal integration with sandbox/live mode
* Role-based workflow with buyer/seller/admin actions
* Admin dispute panel with status updates
* Responsive and AJAX-enhanced user forms

\== Upgrade Notice ==
\= 1.0.0 =
First official release with full PayPal support and escrow management capabilities.

\== Arbitrary section ==
For developers: Escrowtics uses `escrowtics_` prefixed hooks and filters. Custom actions can be added to extend form behavior, emails, or transaction logic. The plugin follows WordPress coding standards and is compatible with multisite environments.

\== A brief Markdown Example ==
Ordered list:

1. Secure payment holding
2. Admin-controlled release or refund
3. Dispute escalation process

Unordered list:

* No third-party service required
* Fully responsive interface
* Developer-friendly architecture

