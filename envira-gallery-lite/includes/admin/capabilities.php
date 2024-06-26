<?php
/**
 * Capabilities class.
 *
 * @since 1.3.7
 *
 * @package Envira_Gallery
 * @author  Envira Team
 */

namespace Envira\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

/**
 * Capabilities class.
 *
 * @since 1.8.9
 *
 * @package Envira_Gallery
 * @author  Envira Team
 */
class Envira_Capabilities {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Register capabilities.
		add_action( 'admin_init', [ $this, 'add_capabilities' ] );
	}

	/**
	 * Registers Envira Gallery capabilities for each Role, if they don't already exist.
	 *
	 * If capabilities don't exist, they're copied from Posts. This ensures users prior to 1.8.9
	 * get like-for-like behaviour in Envira and don't notice the new capabilities.
	 *
	 * @since 1.0.0
	 */
	public function add_capabilities() {

		// Bail out if it is settings page update action. - Ignore nonce check as we don't use post data here.
		// phpcs:ignore WordPress.Security.NonceVerification
		if ( isset( $_POST['envira-permissions-nonce'] ) && sanitize_text_field( wp_unslash( $_POST['envira-permissions-nonce'] ) ) !== null ) {
			return;
		}

		// Grab the administrator role, and if it already has an Envira capability key defined, bail
		// as we only need to register our capabilities once.
		$administrator = get_role( 'administrator' );
		if ( $administrator->has_cap( 'edit_other_envira_galleries' ) ) {
			return;
		}

		// If here, we need to assign capabilities
		// Define the roles we want to assign capabilities to.
		$roles = [
			'administrator',
			'editor',
			'author',
			'contributor',
			'subscriber',
		];

		// Iterate through roles.
		foreach ( $roles as $role_name ) {
			// Properly get the role as WP_Role object.
			$role = get_role( $role_name );
			if ( ! is_object( $role ) ) {
				continue;
			}

			// Map this Role's Post capabilities to our Envira Gallery capabilities.
			$caps = [
				'edit_envira_gallery'               => $role->has_cap( 'edit_posts' ),
				'read_envira_gallery'               => $role->has_cap( 'read' ),
				'delete_envira_gallery'             => $role->has_cap( 'delete_posts' ),

				'edit_envira_galleries'             => $role->has_cap( 'edit_posts' ),
				'edit_other_envira_galleries'       => $role->has_cap( 'edit_others_posts' ),
				'edit_others_envira_galleries'      => $role->has_cap( 'edit_others_posts' ),
				'publish_envira_galleries'          => $role->has_cap( 'publish_posts' ),
				'read_private_envira_galleries'     => $role->has_cap( 'read_private_posts' ),

				'delete_envira_galleries'           => $role->has_cap( 'delete_posts' ),
				'delete_private_envira_galleries'   => $role->has_cap( 'delete_private_posts' ),
				'delete_published_envira_galleries' => $role->has_cap( 'delete_published_posts' ),
				'delete_others_envira_galleries'    => $role->has_cap( 'delete_others_posts' ),
				'edit_private_envira_galleries'     => $role->has_cap( 'edit_private_posts' ),
				'edit_published_envira_galleries'   => $role->has_cap( 'edit_published_posts' ),
				'create_envira_galleries'           => $role->has_cap( 'edit_posts' ),
			];

			// Add the above Envira capabilities to this Role.
			foreach ( $caps as $envira_cap => $value ) {
				// Don't add if value is false.
				if ( ! $value ) {
					continue;
				}
				$role->add_cap( $envira_cap );
			}
		}
	}
}
