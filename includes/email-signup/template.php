<?php
/**
 * File containing the PHP template for the email list signup form.
 *
 * @package sensei
 * @since   2.0.0
 */

?>
<div id="mc_embed_signup">
	<form
		action="https://senseilms.us19.list-manage.com/subscribe/post?u=<?php echo esc_attr( Sensei_Email_Signup_Form::MC_USER_ID ); ?>&amp;id=<?php echo esc_attr( Sensei_Email_Signup_Form::MC_LIST_ID ); ?>"
		method="post"
		id="mc-embedded-subscribe-form"
		name="mc-embedded-subscribe-form"
		class="validate"
		target="_blank"
		novalidate
	>
		<input type="hidden" name="SOURCE" value="PLUGIN">
		<div id="mc_embed_signup_scroll">
			<h2><?php esc_html_e( 'Join Our Mailing List!', 'woothemes-sensei' ); ?></h2>
			<p>
				<?php esc_html_e( "We're here for you — get tips, product updates, and inspiration straight to your mailbox.", 'woothemes-sensei' ); ?>
			</p>
			<div>
				<div class="gdpr-checkbox">
					<label class="checkbox subfield" for="gdpr_23563">
						<input type="checkbox" id="gdpr_23563" name="gdpr[23563]" value="Y" class="av-checkbox ">
						<span><?php esc_html_e( 'Yes, please send me occasional emails about Sensei', 'woothemes-sensei' ); ?></span>
					</label>
				</div>
			</div>
			<div class="email-input">
				<div class="mc-field-group">
					<input type="email" value="<?php echo esc_attr( get_option( 'admin_email', '' ) ); ?>" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="<?php esc_attr_e( 'Enter your email address', 'woothemes-sensei' ); ?>">
				</div>
				<div class="gdpr-content">
					<p>
						<?php
						echo sprintf(
							wp_kses_post(
								// translators: placeholder is the URL to MailChimp's Legal page.
								__(
									"We use Mailchimp as our marketing platform. By clicking below to subscribe, you acknowledge that your information will be transferred to Mailchimp for processing. <a href=\"%s\" target=\"_blank\">Learn more about Mailchimp's privacy practices here.</a>",
									'woothemes-sensei'
								)
							),
							'https://mailchimp.com/legal/'
						);
						?>
					</p>
				</div>
			</div>
			<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_7a061a9141b0911d6d9bafe3a_278a16a5ed" tabindex="-1" value=""></div>
			<div class="buttons clear">
				<a href="#close" id="mc-embedded-cancel" class="button" rel="modal:close"><?php esc_html_e( 'Not Now', 'woothemes-sensei' ); ?></a>
				<input type="submit" value="<?php esc_attr_e( 'Yes, please!', 'woothemes-sensei' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button-primary" disabled>
			</div>
		</div>
	</form>
</div>
