<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://gravitec.net/
 * @since      1.0.0
 *
 * @package    Gravitecnet
 * @subpackage Gravitecnet/admin/partials
 */

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );

$gravitecnet_settings         = new Gravitecnet_Settings();
$gravitecnet_security_helpers = new Gravitecnet_Security_Helpers();
$gravitecnet_path_helper      = new Gravitecnet_Path_Helper( $gravitecnet_settings );

$gravitecnet_form = new Gravitecnet_Form(
	$_POST,
	$gravitecnet_settings,
	$gravitecnet_security_helpers
);
$gravitecnet_form->handle_submit();

$ACTIVATE_BUTTON_ID = 'gravitecnet_activate_button';
$LOGIN_BUTTON_ID = 'gravitecnet_login_button';
$DEACTIVATE_BUTTON_ID = 'gravitecnet_deactivate_button';
?>

<!--Hidden form for saving credentials! Easiest way for saving it (what i've found) -->
<form id="gravitecnet_credentials_form" method="POST">
	<?php $gravitecnet_security_helpers->display_wp_nonce_field() ?>
    <input type="hidden"
           required="required"
           name="<?php echo esc_attr( $gravitecnet_settings->get_app_key_field_name() ); ?>"
           value="<?php echo esc_attr( $gravitecnet_settings->get_app_key() ); ?>"
           id="<?php echo esc_attr( $gravitecnet_settings->get_app_key_field_name() ); ?>">
    <input type="hidden"
           required="required"
           name="<?php echo esc_attr( $gravitecnet_settings->get_app_secret_field_name() ); ?>"
           value="<?php echo esc_attr( $gravitecnet_settings->get_app_secret() ); ?>"
           id="<?php echo esc_attr( $gravitecnet_settings->get_app_secret_field_name() ); ?>">
    <input type="hidden"
           required="required"
           name="<?php echo esc_attr( $gravitecnet_settings->get_email_field_name() ); ?>"
           value="<?php echo esc_attr( $gravitecnet_settings->get_account_email() ); ?>"
           id="<?php echo esc_attr( $gravitecnet_settings->get_email_field_name() ); ?>">
    <input name='is_auth_form' value='check' style='display:none'/>
</form>

<div id="grv-wp-wrap">
    <div class="grv-header">
        <div class="grv-container">
            <div class="grv-header-row">
                <a href="https://gravitec.net/" class="grv-logo" target="_blank" rel="noopener"
                   aria-label="Gravitec.net">
                    <svg viewBox="0 0 123.64 16.11" xmlns="http://www.w3.org/2000/svg" width="184" height="24">
                        <path
                                d="M15 6.8h-3.6a3.58 3.58 0 0 0-2.6 1.6c-.1.1 0 .1 0 .2H13q.9 0 .6.9A5.53 5.53 0 0 1 6.14 13a2.26 2.26 0 0 0-1.8-.1l-1.1.3c-.4.1-.5-.1-.4-.5a6.47 6.47 0 0 1 .4-1.3A3.42 3.42 0 0 0 3 10.1 16 16 0 0 1 2.54 8a5.75 5.75 0 0 1 7-5.9 6.14 6.14 0 0 1 2.6 1.5c.5.5.7.5 1.2 0l.1-.1a.65.65 0 0 0 0-1.1A7.09 7.09 0 0 0 8.34.1 5.28 5.28 0 0 0 7 .2a7.62 7.62 0 0 0-5.9 10 3.78 3.78 0 0 1 0 1.5C.84 13 .44 14.3 0 15.6c0 .1-.1.3 0 .4a.75.75 0 0 0 .5.1c1.3-.4 2.5-.8 3.8-1.1a3.79 3.79 0 0 1 1.5 0 8 8 0 0 0 4.6.1 7.78 7.78 0 0 0 5.4-7.4c-.06-.7-.26-.8-.8-.9zM21.74.6h3.2a6.05 6.05 0 0 1 3.9 1.2 3.75 3.75 0 0 1 1.5 3.1 3.94 3.94 0 0 1-1 2.7 5.41 5.41 0 0 1-3.1 1.6l4.4 6.4h-2.3l-4.2-6.2h-.5v6.2h-2V.6zm2 1.8v5.2c3 .1 4.5-.8 4.5-2.6a2.77 2.77 0 0 0-.5-1.6 2.48 2.48 0 0 0-1.4-.8 16.12 16.12 0 0 0-2.6-.2zM43.44 0l7.1 15.6h-2.1l-1.7-3.8h-6.4l-1.7 3.8h-2.1zm0 4.7L41 10h4.8zm9.9-4.1h2.2l4.7 10.6L64.94.6h2.2l-6.9 15.5zm19.8 0h2v15h-2zm8.2 0h9.2v2h-3.6v12.9h-2V2.6h-3.6zm15.2 0h8.3v2h-6.3v3.7h6.3v2h-6.3v5.1h6.3v2h-8.3zm27.1.5v2.3a10.12 10.12 0 0 0-4.5-1.2 6.37 6.37 0 0 0-4.4 1.7 5.39 5.39 0 0 0-1.8 4.1 5.45 5.45 0 0 0 1.8 4.2 6.52 6.52 0 0 0 4.6 1.7 8.15 8.15 0 0 0 4.2-1.3v2.3a9.56 9.56 0 0 1-4.4 1.1 8.47 8.47 0 0 1-6-2.4 7.89 7.89 0 0 1-2.5-5.7A7.57 7.57 0 0 1 113 2.3a8.34 8.34 0 0 1 5.8-2.3 13.43 13.43 0 0 1 4.84 1.1z"/>
                    </svg>
                </a>

                <div class="grv-heading">№1 Push service for Media</div>
            </div>
        </div>
    </div>

	<div class='grv-review'>
		<div class='grv-container'>
			<div class="grv-review-row">
        		<span>⭐ Appreciate Gravitec?</span>
        		<a style="margin-left:15px;" href="https://wordpress.org/plugins/gravitec-net-web-push-notifications/#reviews" target="_blank">Leave us a review →	</a>
			</div>
		</div>
    </div>
	
    <div class="grv-container">
        <div class='grv-menu-wrapper'>
            <nav class='grv-menu'>
                <h1 data-tab='main' class='active'>Main</h1>
                <h1 data-tab='configuration'>Configuration</h1>
				<h1 data-tab='push'>Send notification</h1>
				<h1 data-tab='segmentation'>Segmentation</h1>
				<?php if( class_exists( 'woocommerce' ) ){ ?>
					<h1 data-tab='woocommerce'>WooCommerce</h1>
				<?php } ?>
            </nav>
        </div>
    </div>

    <div class="grv-container">
        <div class="grv-main grv-nav-item active" data-tab='main'>
            <div>
                <h1 class="grv-title-h1">Welcome to <a href="https://gravitec.net/" target="_blank"
                                                       rel="noopener">Gravitec.net</a>!</h1>
                <p class="grv-text"><a href="https://gravitec.net/" target="_blank" rel="noopener">Gravitec.net</a> is
                    an
                    automated content delivery platform that helps increase your audience, which will increase your
                    productivity.</p>
                <p class="grv-text">Your website can now deliver web push notifications, and your visitors can easily
                    subscribe to them!</p>
                <hr class="grv-break-line"/>
                <h2 class="grv-title-h2">Exclusively from <a href="https://gravitec.net/" target="_blank"
                                                             rel="noopener">Gravitec.net</a></h2>
                <ul class="grv-ulist">
                    <li>RSS Automation - use your RSS feed as a source for automated push notifications.</li>
                    <li>RSS Digest - automatically create digests of the most popular news items from your RSS feed.
                    </li>
                    <li>Bell - a customizable widget that shows subscribers their notification history.</li>
                </ul>
				<?php if ( $gravitecnet_settings->pluginWasActivated() ): ?>
                    <a href="https://push.gravitec.net" target="_blank" class="grv-btn">Go to Dashboard</a>
				<?php else: ?>
                    <a href="#" id="<?php echo esc_attr( $ACTIVATE_BUTTON_ID ); ?>" class="grv-btn">Create new account in 1 click</a>
                    <a href="#" id="<?php echo esc_attr( $LOGIN_BUTTON_ID ); ?>" class="grv-btn grv-login-btn">Connect to existing account</a>
				<?php endif; ?>
            </div>
            <div>

				<?php if ( $gravitecnet_settings->pluginWasActivated() ): ?>
                    <div class="grv-alert">
                        <div class="grv-alert-text">Gravitec.net is active on your website</div>
                        <a href="#" id="<?php echo esc_attr( $DEACTIVATE_BUTTON_ID ); ?>" class="grv-alert-action">Disconnect</a>
                    </div>
				<?php endif; ?>
                <div class="grv-media">
                    <img src="<?php echo esc_url( $gravitecnet_path_helper->get_img_path( 'wp-activated.svg' ) ); ?>"
                         alt="Gravitec.net" width="240" height="145"/>
                </div>
            </div>
        </div>

		<form class="grv-configuration grv-nav-item" data-tab='configuration' method='POST'>
			<?php $gravitecnet_security_helpers->display_wp_nonce_field(); ?>
            <div class="grv-input-field">
				<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_automatically_send_on_post_field_name() ); ?>" <?php if ($gravitecnet_settings->get_automatically_send_on_post()) { echo "checked"; } ?>>
                <label>Automatically send a push notification when I create a post from the WordPress 				  editor</label>
            </div>
			<hr/>
            <div class="grv-input-field">
				<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_use_featured_image_field_name() ); ?>" <?php if ($gravitecnet_settings->get_use_featured_image()) { echo "checked"; } ?>>
                <label>Use the post's featured image for the notification icon</label>
            </div>
			<hr/>
			<div class="grv-input-field grv-text-input">
				<label>Additional Notification URL Parameters</label>
				<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_add_url_parameters() ); ?>" placeholder='utm_medium=ppc&utm_source=adwords&utm_campaign=snow%20boots&utm_content=durable%20%snow%boots' name="<?php echo esc_attr( $gravitecnet_settings->get_add_url_parameters_field_name() ); ?>">
            </div>
			<hr/>
			<div class="grv-input-field">
				<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_status_after_sending_field_name() ); ?>" <?php if ($gravitecnet_settings->get_status_after_sending()) { echo "checked"; } ?>>
                <label>Show status message after sending notifications</label>
            </div>
			<hr/>
			<input name='which-form' value='configuration' style='display:none'/>
			<button type='submit'>
				SAVE
			</button>
		</form>
		<form class="grv-configuration grv-nav-item" id='grv-send-notification-form' data-tab='push' method='POST'>
			<?php $gravitecnet_security_helpers->display_wp_nonce_field(); ?>
			<div class="grv-input-field grv-text-input">
				<label>Notification Title</label>
				<input type="text" placeholder='Notification Title' name='title' required>
            </div>
			<hr/>
			<div class="grv-input-field grv-text-input">
				<label>Notification Message</label>
				<input type="text" placeholder='Notification Message' name='message' required>
            </div>
			<hr/>
			<div class="grv-input-field grv-text-input">
				<label>Target URL</label>
				<input type="url" placeholder='Target URL' name='url' required>
            </div>
			<hr/>
			<input name='which-form' value='push' style='display:none'/>
			<button type='submit'>
				SEND
			</button>
		</form>
		<form class="grv-configuration grv-nav-item" data-tab='segmentation' method='POST'>
			<?php $gravitecnet_security_helpers->display_wp_nonce_field(); ?>
			<p style='font-size: 26px'>
				Create segments based on the pages that your subscribers visit
			</p>
			<div class="grv-input-field">
				<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_tag_enable_segmentation_field_name() ); ?>" <?php if ($gravitecnet_settings->get_tag_enable_segmentation()) { echo "checked"; } ?>>
				<label>Enable segmentation</label>
			</div>
			<hr/>
			<div class="grv-input-field grv-text-input">
				<label>Page URL</label>
				<input type="url" value="<?php echo esc_attr( $gravitecnet_settings->get_tag_url() ); ?>" placeholder='Enter target URL' name="<?php echo esc_attr( $gravitecnet_settings->get_tag_url_field_name() ); ?>">
			</div>
			<div class="grv-input-field">
				<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_tag_enable_subpages_field_name() ); ?>" <?php if ($gravitecnet_settings->get_tag_enable_subpages()) { echo "checked"; } ?>>
				<label>Use for sub-pages</label>
			</div>
			<hr/>
			<div class="grv-input-field grv-text-input">
				<label>Tag name</label>
				<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_tag_title() ); ?>" placeholder='Enter tag title' name="<?php echo esc_attr( $gravitecnet_settings->get_tag_title_field_name() ); ?>">
			</div>
			<hr/>
			<div class='grv-segmentation-condition-wrapper' style='display: flex'>
				<div class="grv-input-field grv-text-input grv-segmentation-condition">
					<label>Condition</label>
					<select style='padding: 8px 16px; font-size: 14px; border-radius: 6px; width: 300px; max-width: 100%;' value="<?php echo esc_attr( $gravitecnet_settings->get_tag_condition() ); ?>" name="<?php echo esc_attr( $gravitecnet_settings->get_tag_condition_field_name() ); ?>">
						<option <?php if ($gravitecnet_settings->get_tag_condition() === 'visit') { echo "selected"; } ?> value='visit'>Visit</option>
						<option <?php if ($gravitecnet_settings->get_tag_condition() === 'scroll') { echo "selected"; } ?> value='scroll'>Scroll</option>
						<option <?php if ($gravitecnet_settings->get_tag_condition() === 'time') { echo "selected"; } ?> value='time'>Time</option>
					</select>
				</div>
				<div class="grv-input-field grv-segmentation-settings-item <?php if ($gravitecnet_settings->get_tag_condition() === 'scroll') { echo "active"; } ?>" data-condition='scroll'>
					<label>Scroll, %</label>
					<div style='display: flex; align-items: center'>
						<input oninput='if (this.value > 100) {this.value = 100}' type="number" value="<?php echo esc_attr( $gravitecnet_settings->get_tag_scroll() ); ?>" placeholder='Enter scroll % value' name="<?php echo esc_attr( $gravitecnet_settings->get_tag_scroll_field_name() ); ?>">
					</div>
				</div>
				<div class="grv-input-field grv-segmentation-settings-item <?php if ($gravitecnet_settings->get_tag_condition() === 'time') { echo "active"; } ?>" data-condition='time'>
					<label>Duration, seconds</label>
					<div>
						<input type="number" value="<?php echo esc_attr( $gravitecnet_settings->get_tag_visit_time() ); ?>" placeholder='Enter visit time in seconds' name="<?php echo esc_attr( $gravitecnet_settings->get_tag_visit_time_field_name() ); ?>">
					</div>
				</div>
			</div>
			<hr/>
			<input name='which-form' value='segmentation' style='display:none'/>
			<button type='submit'>
				SAVE
			</button>
			<div class='grv-segmentation-accordion'>
				<div class='grv-segmentation-accordion__icon'>
					<span>
						i
					</span>
				</div>
				<div>
					<p class="grv-segmentation-accordion__title">
						How to Use a Segmentation
					</p>
					<p class='grv-segmentation-accordion__description'>
						You can create tags to be assigned to your subscribers who visit a particular page. Add a page URL, create a tag name and add a condition such as “Scroll” + “70%” to automatically assign tags to subscribers. For example, if you create the tag “PlayStation5” for your product page, and select “Scroll” + “70%“, subscribers who visit this page and scroll it over 70%, will be marked with the “PlatStation5” tag. After that, you can send push notifications specifically to this subscriber group.
					</p>
				</div>
			</div>
		</form>
		
		
    	<?php if( class_exists( 'woocommerce' ) ){ ?>
			<div class="grv-nav-item grv-configuration" data-tab='woocommerce'>
				<nav class='grv-menu grv-woo-menu'>
					<h3 data-tab='abandoned-cart' class='active'>Abandoned cart</h3>
					<h3 data-tab='new-product'>New product</h3>
					<h3 data-tab='price-drop'>Price drop</h3>
					<h3 data-tab='sale-price'>Sale price</h3>
				</nav>
				<form method='POST' class="grv-woo-nav-item active" data-tab='abandoned-cart'>
					<?php $gravitecnet_security_helpers->display_wp_nonce_field(); ?>
					<div class="grv-input-field">
						<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_enable_abandoned_cart_field_name() ); ?>" <?php if ($gravitecnet_settings->get_enable_abandoned_cart()) { echo "checked"; } ?>>
						<label>Enable abandoned cart push notification</label>
					</div>
					<p style='font-size: 16px'>
						<span style='color: red'>*</span>Use <b>{product_name}</b>, <b>{product_count}</b>, <b>{cart_total}</b>, <b>{checkout_page}</b> to create proper template. For example, "You've left <b>{product_count}</b> item(s) in your cart".
					</p>
					<div class="grv-input-field grv-text-input">
						<label>Notification Title</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_title_template() ); ?>" placeholder='Notification Title' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_title_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Notification Message</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_message_template() ); ?>" placeholder='Notification Message' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_message_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field">
						<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_icon_field_name() ); ?>" <?php if ($gravitecnet_settings->get_woo_abandoned_icon()) { echo "checked"; } ?>>
						<label>Use the products's featured image for the notification icon</label>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Target URL</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_redirect_url() ); ?>" placeholder='Target URL' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_redirect_url_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Send Push Notification</label>
						<div style='display: flex; align-items: center; grid-column-gap: 15px'>
							<select style='width: 200px' value="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_push_period() ); ?>" name="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_push_period_field_name() ); ?>">
								<option <?php if ($gravitecnet_settings->get_woo_abandoned_push_period() === 'once') { echo "selected"; } ?> value='once'>Only once, after</option>
								<option <?php if ($gravitecnet_settings->get_woo_abandoned_push_period() === 'repeat') { echo "selected"; } ?> value='repeat'>Every</option>
							</select>
							<input type="number" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_hours() ); ?>" name="<?php echo esc_attr( $gravitecnet_settings->get_woo_abandoned_hours_field_name() ); ?>" style='width: 50px; padding: 8px'  placeholder='hour' required>
							<span>hour(s)</span>
						</div>
					</div>
					<hr/>
					<input name='which-form' value='woocommerce-abandoned-cart' style='display:none'/>
					<button type='submit'>
						SAVE
					</button>
				</form>
				<form method='POST' class="grv-woo-nav-item" data-tab='new-product'>
					<?php $gravitecnet_security_helpers->display_wp_nonce_field(); ?>
					<div class="grv-input-field">
						<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_woo_enable_new_product_field_name() ); ?>" <?php if ( $gravitecnet_settings->get_woo_enable_new_product() ) { echo "checked"; } ?>>
						<label>Enable new product push notification</label>
					</div>
					<p style='font-size: 16px'>
						<span style='color: red'>*</span>Use <b>{product_name}</b>, <b>{short_product_description}</b>, <b>{product_url}</b> to create proper template.
					</p>
					<div class="grv-input-field grv-text-input">
						<label>Notification Title</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_new_product_title_template() ); ?>" placeholder='Notification Title' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_new_product_title_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Notification Message</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_new_product_message_template() ); ?>" placeholder='Notification Message' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_new_product_message_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field">
						<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_woo_new_product_icon_field_name() ); ?>" <?php if ( $gravitecnet_settings->get_woo_new_product_icon() ) { echo "checked"; } ?>>
						<label>Use the products's featured image for the notification icon</label>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Target URL</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_new_product_redirect_url() ); ?>" placeholder='Target URL' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_new_product_redirect_url_field_name() ); ?>" required>
					</div>
					<hr/>
					<input name='which-form' value='woocommerce-new-product' style='display:none'/>
					<button type='submit'>
						SAVE
					</button>
				</form>
				<form method='POST' class="grv-woo-nav-item" data-tab='price-drop'>
					<?php $gravitecnet_security_helpers->display_wp_nonce_field(); ?>
					<p style='font-size: 16px'>
						<span style='color: red'>*</span>Use <b>{product_name}</b>, <b>{old_price}</b>, <b>{new_price}</b>, <b>{product_url}</b> to create proper template.
					</p>
					<div class="grv-input-field grv-text-input">
						<label>Notification Title</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_price_drop_title_template() ); ?>" placeholder='Notification Title' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_price_drop_title_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Notification Message</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_price_drop_message_template() ); ?>" placeholder='Notification Message' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_price_drop_message_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field">
						<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_woo_price_drop_icon_field_name() ); ?>" <?php if ( $gravitecnet_settings->get_woo_price_drop_icon() ) { echo "checked"; } ?>>
						<label>Use the products's featured image for the notification icon</label>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Target URL</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_price_drop_redirect_url() ); ?>" placeholder='Target URL' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_price_drop_redirect_url_field_name() ); ?>" required>
					</div>
					<hr/>
					<input name='which-form' value='woocommerce-price-drop' style='display:none'/>
					<button type='submit'>
						SAVE
					</button>
				</form>
				<form method='POST' class="grv-woo-nav-item" data-tab='sale-price'>
					<?php $gravitecnet_security_helpers->display_wp_nonce_field(); ?>
					<p style='font-size: 16px'>
						<span style='color: red'>*</span>Use <b>{product_name}</b>, <b>{sale_price}</b>, <b>{product_url}</b> to create proper template.
					</p>
					<div class="grv-input-field grv-text-input">
						<label>Notification Title</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_sale_price_title_template() ); ?>" placeholder='Notification Title' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_sale_price_title_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Notification Message</label>
						<input type="text" value="<?php echo esc_attr( $gravitecnet_settings->get_woo_sale_price_message_template() ); ?>" placeholder='Notification Message' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_sale_price_message_template_field_name() ); ?>" required>
					</div>
					<hr/>
					<div class="grv-input-field">
						<input type="checkbox" value="true" name="<?php echo esc_attr( $gravitecnet_settings->get_woo_sale_price_icon_field_name() ); ?>" <?php if ($gravitecnet_settings->get_woo_sale_price_icon()) { echo "checked"; } ?>>
						<label>Use the product's featured image for the notification icon</label>
					</div>
					<hr/>
					<div class="grv-input-field grv-text-input">
						<label>Target URL</label>
						<input type="url" value="<?php echo esc_url( $gravitecnet_settings->get_woo_sale_price_redirect_url() ); ?>" placeholder='Target URL' name="<?php echo esc_attr( $gravitecnet_settings->get_woo_sale_price_redirect_url_field_name() ); ?>" required>
					</div>
					<hr/>
					<input name='which-form' value='woocommerce-sale-price' style='display:none'/>
					<button type='submit'>
						SAVE
					</button>
				</form>
			</div>
		<?php } ?>
    </div>

    <div class="grv-container">
        <div class="grv-footer">
            For any questions or problems, contact <a href="mailto:support@gravitec.net"
                                                      class="grv-link">support@gravitec.net</a>
        </div>
    </div>
</div>

<script>
    !(function () {
		var appKeyField = document.querySelector('#<?php echo esc_js( $gravitecnet_settings->get_app_key_field_name() ); ?>');
		var appSecretField = document.querySelector('#<?php echo esc_js( $gravitecnet_settings->get_app_secret_field_name() ); ?>');
		var accountEmailField = document.querySelector('#<?php echo esc_js( $gravitecnet_settings->get_email_field_name() ); ?>');
		var credentialsForm = document.querySelector('#gravitecnet_credentials_form');
		var activationButton = document.querySelector('#<?php echo esc_js( $ACTIVATE_BUTTON_ID ); ?>');
		var loginButton = document.querySelector('#<?php echo esc_js( $LOGIN_BUTTON_ID ); ?>');
		var deactivateButton = document.querySelector('#<?php echo esc_js( $DEACTIVATE_BUTTON_ID ); ?>');

        function getTimezone() {
            var tz = jstz.determine();
            return tz.name();
        }

		function createParams() {
			return {
				email: "<?php echo esc_js( $gravitecnet_settings->get_current_user_email() ); ?>",
				rss: "<?php echo esc_js( $gravitecnet_settings->get_rss_url() ); ?>",
				domain: "<?php echo esc_js( $gravitecnet_settings->get_domain() ); ?>",
				zone: getTimezone(), // Assuming this function returns a safe value
				locale: "<?php echo esc_js( $gravitecnet_settings->get_locale() ); ?>"
			};
		}

		function createParamsForLoginToExistAccount() {
			return {
				existlogin: true,
				rss: "<?php echo esc_js( $gravitecnet_settings->get_rss_url() ); ?>",
				domain: "<?php echo esc_js( $gravitecnet_settings->get_domain() ); ?>",
				zone: getTimezone(),
				locale: "<?php echo esc_js( $gravitecnet_settings->get_locale() ); ?>"
			};
		}

        function dictToEncodedQueryParams(obj) {
            var str = [];
            for (var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        }

		function getActivationUrl() {
			var baseUrl = <?php echo json_encode($gravitecnet_settings->get_activate_button_url()); ?>;
			var queryParams = dictToEncodedQueryParams(createParams());
			return baseUrl + queryParams;
		}

		function getActivationUrlForLoginToExistAccount() {
			var baseUrl = <?php echo json_encode($gravitecnet_settings->get_activate_button_url()); ?>;
			var queryParams = dictToEncodedQueryParams(createParamsForLoginToExistAccount());
			return baseUrl + queryParams;
		}

        function openWindowForGravitecnetActivation() {
            window.open(getActivationUrl());
        }

        function openWindowForGravitecnetActivationFromExistAccount() {
            window.open(getActivationUrlForLoginToExistAccount());
        }

        function deactivate() {
            appKeyField.value = '';
            appSecretField.value = '';
            accountEmailField.value = '';

            credentialsForm.submit();
        }

        document.addEventListener('click',function(e) {
            if(e.target === activationButton) {
                openWindowForGravitecnetActivation();   
            }
            if(e.target === loginButton) {
                openWindowForGravitecnetActivationFromExistAccount();  
            }
            if(e.target === deactivateButton) {
                deactivate();
            }
        });

        function receiveMessage(event) {
            if (!event.data.credentials) {
                console.error('Not found credentials in postMessage');
                return
            }

            var appKeyValue = event.data.credentials.appKey;
            var appSecretValue = event.data.credentials.appSecret;
            var accountEmailValue = event.data.credentials.email;

            if (!appKeyValue || !appSecretValue) {
                console.error("AppKey or appSecret doesn't exist in postMessage")
                return;
            }

            appKeyField.value = appKeyValue;
            appSecretField.value = appSecretValue;
            accountEmailField.value = accountEmailValue;

            credentialsForm.submit();
        }

        window.addEventListener('message', receiveMessage, false);
		
		const navButtons = document.querySelectorAll('.grv-menu h1');
		const navItems = document.querySelectorAll('.grv-nav-item');
		
		if (navButtons && navItems) {
			navButtons.forEach(button => {
				button.addEventListener('click', e => {
					navButtons.forEach(btn => btn.classList.remove('active'));
					navItems.forEach(item => item.classList.remove('active'));
					const navItemTitle = e.target.dataset.tab;
					document.querySelectorAll(`[data-tab="${navItemTitle}"]`).forEach(tab => {
						tab.classList.add('active');
					});
				})
			});
		}
		
		const addTagCondition = document.querySelector('.grv-segmentation-condition select');
		
		if (addTagCondition) {
			addTagCondition.addEventListener('click', () => {
				const settingsItems = document.querySelectorAll('.grv-segmentation-settings-item');
				settingsItems.forEach(item => {
					item.classList.remove('active');
					if (addTagCondition.value === item.dataset.condition) {
						item.classList.add('active')
					}
				});
			})
		}
		
		const wooNavButtons = document.querySelectorAll('.grv-woo-menu h3');
		const wooNavItems = document.querySelectorAll('.grv-woo-nav-item');
		
		if (wooNavButtons && wooNavItems) {
			wooNavButtons.forEach(button => {
				button.addEventListener('click', e => {
					wooNavButtons.forEach(btn => btn.classList.remove('active'));
					wooNavItems.forEach(item => item.classList.remove('active'));
					const navItemTitle = e.target.dataset.tab;
					document.querySelectorAll(`[data-tab="${navItemTitle}"]`).forEach(tab => {
						tab.classList.add('active');
					});
				})
			});
		}
		
// 		const segmentationAccordionTitle = document.querySelector('.grv-segmentation-accordion__title');
// 		const segmentationAccordionDescription = document.querySelector('.grv-segmentation-accordion__description');
		
// 		if (segmentationAccordionTitle && segmentationAccordionDescription) {
// 			segmentationAccordionTitle.addEventListener('click', () => {
// 				segmentationAccordionDescription.classList.toggle('active');
// 				segmentationAccordionTitle.classList.toggle('active');
// 			})
// 		}		
    })();
</script>