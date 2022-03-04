<?php
/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Twenty 1.0
 */

// vhm code

//show custom field
add_action( 'show_user_profile', 'show_extra_profile_fields' );
add_action( 'edit_user_profile', 'show_extra_profile_fields' );

function show_extra_profile_fields( $user ) {
	$position = get_the_author_meta( 'position', $user->ID );
	?>
	<h3><?php esc_html_e( 'User Position', 'vhm' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="position"><?php esc_html_e( 'Position', 'vhm' ); ?></label></th>
			<td>
				<input type="text"
			       id="position"
			       name="position"
			       value="<?php echo esc_attr( $position ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
	</table>
	<?php
}

//validate the error
add_action( 'user_profile_update_errors', 'user_profile_update_errors', 10, 3 );
function user_profile_update_errors( $errors, $update, $user ) {
	if ( empty( $_POST['position'] ) ) {
		$errors->add( 'position_error', __( '<strong>ERROR</strong>: Please enter your Position.', 'vhm' ) );
	}
}

//Save the data
add_action( 'personal_options_update', 'update_profile_fields' );
add_action( 'edit_user_profile_update', 'update_profile_fields' );

function update_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	if ( ! empty( $_POST['position'] ) ) {
		update_user_meta( $user_id, 'position', $_POST['position'] );
	}
}
