=== YITH WooCommerce Product Add-Ons Premium ===

Contributors: yithemes
Tags: woocommerce, product, option, form, attribute, variation, radio, checkbox, label, upload, image
Requires at least: 4.4
Tested up to: 4.9
Stable tag: 1.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Changelog ==

= 1.3.2 - xxx xx, 2018 =
* Tweak: New options sign filters
* Fix: Minor bugs

= 1.3.1 - Jan 18, 2018 =
* New: Filter 'wapo_select_variations_in_loop' to manage the variations in loop
* Tweak: Template yith-wapo-form-option-type.php loaded by wc_get_template function
* Tweak: Added the add-on $title to the "ywapo_empty_option_text" filter
* Update: YIT Plugin Framework 3.0.9
* Fix: Group doesn't saving
* Fix: Image replacement
* Fix: WooCommerce 2.6 compatibility
* Fix: And operator dependencies
* Fix: Minor bugs

= 1.3.0 - Dec 12, 2017 =
* New: AND/OR operators for Options Requirements
* New: Negative value in options price
* New: Possibility to reset add-ons type file
* New: Unero theme quick view support
* New: 'yith_wapo_allow_frontend_free_price' filter to show free options price "+ $0.00"
* New: HTML options container
* New: French translation
* Update: YIT Plugin Framework 3
* Fix: Deprecated 'woocommerce_add_order_item_meta' action
* Fix: Options not shown in checkout
* Fix: Options not shown in order details
* Fix: Options not shown in order emails
* Fix: Options not shown in order again
* Fix: Variations fields in shop page
* Fix: Options textarea freeze after press enter key
* Fix: Product Bundles plugin compatibility
* Fix: Select2 and SelectWoo problems
* Fix: Product attributes types
* Fix: Multi Vendor user error
* Fix: Minor bugs

= 1.2.8 - Oct 12, 2017 =
* New: WooCommerce 3.2.0 support
* New: Flatsome product lightbox compatibility
* Update: language file
* Fix: Removed 'Color and Label Variations' item from YITH Plugins menu in admin
* Fix: Illegal string offset in order again feature
* Fix: Quick View compatibility
* Fix: Minor bugs

= 1.2.7 - Aug 31, 2017 =
* New: es_ES translations files
* New: nl_NL translations files
* Update: Core files
* Fix: Increased Type Description length
* Fix: Minor bugs

= 1.2.6 - Jul 21, 2017 =
* New: "Toggle" function on options group (frontend)
* New: HTML code in option label
* New: 'yith_wapo_frontend_price_html' filter
* New: 'yith_wapo_cart_item_addon_price' filter
* Update: Core files
* Update: Language files
* Fix: Blank page with WooCommerce 3.0
* Fix: Type "Color" attributes and variations problem
* Fix: "Mixed Content" error with SSL images
* Fix: "Sold individually" cart price
* Fix: WooCommerce select2 error
* Fix: Order again errors
* Fix: Hidden variations in options editor
* Fix: Base price before options in variable products
* Fix: JavaScript errors in backend
* Fix: Prevent "add to cart" at the press "enter" in product options fields
* Fix: Call to undefined method WC_Product_Variable::get_default_attributes()
* Fix: Compatibility with YITH WooCommerce Role-based Prices Premium
* Fix: Deprecated 'woocommerce_add_order_item_meta' hook
* Fix: Limit selectable elements with Multi Labels type
* Fix: Fatal error: Cannot unset string offsets in class.yith-wapo-frontend.php
* Fix: Prevent "Manage" popup open in other tab
* Fix: Type text "max length"
* Fix: Fatal error after activation
* Fix: Minor bugs

= 1.2.5 - Apr 07, 2017 =
* New: WooCommerce 3.0.x support
* New: Dutch language files
* Dev: Added yith_wapo_product_price_updated trigger
* Dev: Added query operator for category filter
* Dev: Added product id in group list
* Fix: Special chars in label
* Fix: Change featured image problem
* Fix: Minor bugs
* Fix: Variations query when categories are filtered in the edit group
* Fix: Flolat value for sum + avada style for dropdown
* Fix: Add to cart layout with Avada
* Fix: Variation query with categories

= 1.2.4 =
* New: Add-Ons options "Minimum and Maximum sum value amount"
* Fix: Featured image does not changed when an add-on was hided by a dependence
* Fix: Calculate totals after quantity value is changed by minum and maximum rules
* Fix: Calculate totals after product quantity changed.

= 1.2.3 =

* New: Add-Ons type "Multiple Labels".
* New: Option "Always show the price table" allows the admin to always show the price table even if the amount of the add-ons is 0 in the single product page.
* Fix: "Limit selectable elements" now works with "Number" Add-On.
* Fix: Integration with "YITH WooCommerce Product Bundle Premium".

= 1.2.1.1 =

* New: Option "All options required" that allow the admin to decide if a required add-on must have all options required or just one.
* Fix: Dependece conflict between add-ons and variations requirements.
* Fix: Some price types not shown in the "new option" template.

= 1.2.1 =

* New: Added two price type "Price multiplied by value" and "Price multiplied by string length".
* New: Now the options list are sortable with drag & drop in the back-end.
* New: Option "calculate quantity by values amout" that allow the user to set the quantity value as the sum of the total amount of the add-on options.
* Fix: Mobile layout in single product page

= 1.2.0.9 =

* New: Product Add-Ons is now integrated with YITH WooCommerce Product Bundle Premium(with versions grather than 1.1.3).
* New: Add-Ons option "replace the product image" works now with YITH WooCommerce Zoom Magnifier.
* Fix: Error with category field on variation requirements.
* Fix: Output error after plugin activation.
* Fix: Wrong arguments using the filter 'woocommerce_cart_item_thumbnail'.
* Fix: Argument missed with YITH WooCommerce Catalog mode.
* Fix: If more then one add-on checked "replace the product image" option the product image was reset.

= 1.2.0.8 =

* New: WordPress 4.7 support.
* New: Product Add-Ons is now integrated with YITH Composite Products for WooCommerce Premium(with versions grather than 1.0.3).
* New: Product Add-Ons is now integrated with YITH WooCommerce Subscrition Premium(with versions grather than 1.1.6).
* Fix: Total box was duplicated with Avada theme and variable product.
* Fix: Prevent variations limit for the "Variation Requirements" field.

= 1.2.0.7 =

* Fix: The Add-ons order can' t be saved in the backend.
* Fix: The Add-ons price get 0 when decimal separator is not the point.

= 1.2.0.6 =

* New: Option "Replace the product image" that allows the customer to replace the product featured image when the add-on is selected.
* Fix: Min and Max option values doesn' t appear in the administration panel after saving.
* Fix: Required field not works for checkboxes when the option "max item selected" is set.

= 1.2.0.5 =

* Fix: Add option doesn' t work with some configurations.

= 1.2.0.4 =

* New: Administration restyling.
* Fix: Add to cart button was disabled with Flatsome theme.

= 1.2.0.3 =

* Fix: Total preview was not updated right after variations was changed.
* Fix: First element with the add-ons "select" was not stored in the cart.

= 1.2.0.2 =

* New: Hide price feature with YITH WooCommerce Catalog Mode Premium and YITH WooCommerce Requeste a Quote Premium.
* Fix: Labels and descriptions of the Add-Ons were not translated on the customer email even if translation was complete on WPML String Translations.

= 1.2.0.1 =

* Fix: Add-on with dependence doesn' t appear even if the correct variation was selected.
* Fix: Prevent notice in the back-end when a new add-on was inserted.


= 1.2.0 =

= Add-Ons =

* New: Possibility to hide add-ons until a specified option or variation is selected.
* New: Integration with YITH WooCommerce Role Based Price.
* New: Flatsome quick view compatibility.
* New: Exclude products field on group
* Fix: Click doesn' t fire on radio button label.
* Fix: Error was printed when a customer receives YITH WooCommerce Request a quote email.
* Fix: Add-ons name and value was not translated by WPML on the Cart

= Variations =

* New: Change product image on hover (only for one attirbute).
* New: Option to show custom attributes style also on "Additional Information" Tab.
* New: Compatibility with WooCommerce Products Filter.
* New: Compatibility with YITH Composite Products For WooCommerce.
* New: Compatibility with WooCommerce Quick View by WooThemes.
* Fix: Reset attribute type on plugin deactivation.
* Fix: Description and default variations on archive pages.
* Update: Language files.
* Update: Core plugin.

= 1.1.4 = Released on Jul 08, 2016

* Update:  Language files.
* Fix: Wrong total price preview when variation is changed
* Fix: Default variation on single product pages for products with only one attribute
* Fix: Issue when there were two labels in two different group

= 1.1.3 =

* New:  WooCommerce 2.6 support.
* New:  Option "Max Items Selected" for checkboxes add ons

= 1.1.2 =

* Update:  Language files.
* Fix:    jQuery event not triggered with "The Edge / Internet Explorer" browser
* Fix:    Product Add-On Group is not saved because of mysql error

= 1.1.1 =

* Fix: error on add to cart when add-on is not "sold individually"

= 1.1.0 =

* New: Support to WordPress 4.5.2.
* New: Support to WooCommerce 2.6 Beta2.

= Add-Ons =

* New: "Sold individually" add-ons option that allow user to sell an add-on lonely(* the price will not increases by cart quantity)
* New: "Upoad File size" option on settings that allow the administrator to set max uploaded file size
* New: "Vendor" option on group that allow administrator to change the vendor previously store
* New: Option "Show product price on 'cart page'" that allow you to show the product base price on the cart item
* Fix: minor bugs

= Variations =

* New: Compatibility with YITH WooCommerce Added to Cart Popup.
* New: Set dual color such as blue-white (half box blue and half box white).
* New: Show a preview of the attribute image in the tooltip (available only for image attributes).
* Fix: Variations now work with Owl Carousel 2 when infinite loop option is set.
* Fix: Clicking on selected attribute before selecting another one is no longer necessary.
* Update: Language files.
* Update: Core plugin.

= 1.0.9 =

*Fix: prevent localize domain issue

= 1.0.8 =

*New: support to YITH WooCommerce Request a Quote - 1.4.7 version

= 1.0.7 =

*Update: Text Domain
*Fix: minor bugs

= 1.0.6 =

*Fix: Prevent notice on products loop

= 1.0.5 =

*New: WordPress 4.5 support

= 1.0.4 =

*Fix: Request a quote button not working in the products loop
*Fix: Removed unuseless query execution

= 1.0.3 =

* New: WPML support
* Fix: Options total price was not correct when user change quantity on single product page

= 1.0.2 =

* Fix: Options are not saved when a quote was inserted inside a label

= 1.0.1 =

* Fix: Price total doesn' t change after option is selected on quick view

= 1.0.0 =

Initial Release
