<?php
/**
 * Charitable Template Hooks.
 *
 * Action/filter hooks used for Charitable functions/templates
 *
 * @package   Charitable/Functions/Templates
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.7.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'charitable_campaigns_loop_optionally_remove_actions' ) ) :
	/**
	 * Optionally remove certain actions from a campaign view based on arguments provided.
	 *
	 * @since  1.7.0
	 *
	 * @param  WP_Query $campaigns The campaigns.
	 * @param  array    $args      The view arguments.
	 * @return void
	 */
	function charitable_campaigns_loop_optionally_remove_actions( $campaigns, $args ) {
		if ( ! $args['show_image'] ) {
			remove_action( 'charitable_campaign_content_loop_before_title', 'charitable_template_campaign_loop_thumbnail', 10 );
		}

		if ( ! $args['show_description'] ) {
			remove_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_description', 4 );
		}

		if ( ! $args['show_progress_bar'] ) {
			remove_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_progress_bar', 6 );
		}

		if ( ! $args['show_amount_donated'] ) {
			remove_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_loop_donation_stats', 8 );
		}
	}

endif;

if ( ! function_exists( 'charitable_campaigns_loop_add_back_optionally_removed_actions' ) ) :
	/**
	 * Add back items that were optionally removed.
	 *
	 * @since  1.7.0
	 *
	 * @param  WP_Query $campaigns The campaigns.
	 * @param  array    $args      The view arguments.
	 * @return void
	 */
	function charitable_campaigns_loop_add_back_optionally_removed_actions( $campaigns, $args ) {
		if ( ! $args['show_image'] ) {
			add_action( 'charitable_campaign_content_loop_before_title', 'charitable_template_campaign_loop_thumbnail', 10 );
		}

		if ( ! $args['show_description'] ) {
			add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_description', 4 );
		}

		if ( ! $args['show_progress_bar'] ) {
			add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_progress_bar', 6 );
		}

		if ( ! $args['show_amount_donated'] ) {
			add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_loop_donation_stats', 8 );
		}
	}
endif;


if ( ! function_exists( 'charitable_campaigns_loop_add_actions' ) ) :
	/**
	 * Optionally add certain actions into a campaign view
	 *
	 * @since  1.7.0
	 *
	 * @return void
	 */
	function charitable_campaigns_loop_add_actions() {
		/**
		 * Campaigns loop, right at the start.
		 *
		 * @see charitable_template_campaign_loop_add_modal()
		 * @see charitable_template_responsive_styles()
		 * @see charitable_campaigns_loop_optionally_remove_actions()
		 */
		add_action( 'charitable_campaign_loop_before', 'charitable_template_campaign_loop_add_modal' );
		add_action( 'charitable_campaign_loop_before', 'charitable_template_responsive_styles', 10, 2 );
		add_action( 'charitable_campaign_loop_before', 'charitable_campaigns_loop_optionally_remove_actions', 10, 2 );
		/**
		 * Campaigns loop, before title.
		 *
		 * @see charitable_template_campaign_loop_thumbnail()
		 */
		add_action( 'charitable_campaign_content_loop_before_title', 'charitable_template_campaign_loop_thumbnail', 10 );

		/**
		 * Campaigns loop, after the main title.
		 *
		 * @see charitable_template_campaign_description()
		 * @see charitable_template_campaign_progress_bar()
		 * @see charitable_template_campaign_loop_donation_stats()
		 * @see charitable_template_campaign_donate_link()
		 * @see charitable_template_campaign_loop_more_link()
		 */
		add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_description', 4 );
		add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_progress_bar', 6, 2 );
		add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_loop_donation_stats', 8 );
		add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_loop_donate_link', 10, 2 );
		add_action( 'charitable_campaign_content_loop_after', 'charitable_template_campaign_loop_more_link', 10, 2 );

		/**
		 * Campaigns loop, right at the end
		 *
		 * @see charitable_campaigns_loop_add_back_optionally_removed_actions()
		 */
		add_action( 'charitable_campaign_loop_after', 'charitable_campaigns_loop_add_back_optionally_removed_actions', 10, 2 );
	}

endif;


/**
 * Add custom CSS to the <head>.
 *
 * @see charitable_template_custom_styles()
 */
add_filter( 'wp_head', 'charitable_template_custom_styles' );

/**
 * Single campaign, before content.
 *
 * @see charitable_template_campaign_description()
 * @see charitable_template_campaign_summary()
 */
add_action( 'charitable_campaign_content_before', 'charitable_template_campaign_description', 4 );
add_action( 'charitable_campaign_content_before', 'charitable_template_campaign_summary', 6 );

/**
 * Single campaign, campaign summary.
 *
 * @see charitable_template_campaign_percentage_raised()
 * @see charitable_template_campaign_donation_summary()
 * @see charitable_template_campaign_donor_count()
 * @see charitable_template_campaign_time_left()
 * @see charitable_template_donate_button()
 */
add_action( 'charitable_campaign_summary', 'charitable_template_campaign_percentage_raised', 4 );
add_action( 'charitable_campaign_summary', 'charitable_template_campaign_donation_summary', 6 );
add_action( 'charitable_campaign_summary', 'charitable_template_campaign_donor_count', 8 );
add_action( 'charitable_campaign_summary', 'charitable_template_campaign_time_left', 10 );
add_action( 'charitable_campaign_summary', 'charitable_template_donate_button', 12 );

/**
 * Single campaign, after content.
 *
 * @see charitable_template_campaign_donation_form_in_page()
 */
add_action( 'charitable_campaign_content_after', 'charitable_template_campaign_donation_form_in_page', 4 );

/**
 * Add the campaign loop actions
 *
 * @see charitable_campaigns_loop_add_actions()
 */

charitable_campaigns_loop_add_actions();

/**
 * Donation receipt, after the page content (if there is any).
 *
 * @see charitable_template_donation_receipt_summary()
 * @see charitable_template_donation_receipt_offline_payment_instructions()
 */
add_action( 'charitable_donation_receipt', 'charitable_template_donation_receipt_summary', 4 );
add_action( 'charitable_donation_receipt', 'charitable_template_donation_receipt_offline_payment_instructions', 6 );
add_action( 'charitable_donation_receipt', 'charitable_template_donation_receipt_details', 8 );

/**
 * Footer, right before the closing body tag.
 *
 * @see charitable_template_campaign_modal_donation_window()
 */
add_action( 'wp_footer', 'charitable_template_campaign_modal_donation_window' );

/**
 * Add the login form before the donation form, outside the <form> tags
 *
 * @see charitable_template_donation_form_login()
 */
add_action( 'charitable_donation_form_before', 'charitable_template_donation_form_login', 4 );

/**
 * Donation form, before the donor fields.
 *
 * @see charitable_template_donation_form_donor_details()
 */
add_action( 'charitable_donation_form_donor_fields_before', 'charitable_template_donation_form_donor_details', 6 );

/**
 * Add a link to the login form after the registration form.
 *
 * @see charitable_template_form_login_link()
 */
add_action( 'charitable_user_registration_after', 'charitable_template_form_login_link' );
