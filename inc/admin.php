<?php

// Prevent direct file access
if( ! defined( 'MJS_FILE' ) ) {
	die();
}

/**
* Adds link to MJ Styles admin page
*/
add_filter( 'plugin_action_links_' . plugin_basename( MJS_FILE ), function( $links ) {
    return array_merge(
        [
            'settings_link' => '<a href="' . admin_url( 'themes.php?page=mj-styles.php' ) . '">' . __( 'Add Styles', 'mj-s' ) . '</a>'
        ],
        $links
    );
});

/**
* Delete Options when plugin is uninstalled
*/
// register_uninstall_hook( MJS_FILE, function() {
//     delete_option( 'mjs_settings');
// } );


/**
 * Enqueues Scripts and Styles
 */
add_action( 'admin_enqueue_scripts', function ($hook) {

    if ( 'appearance_page_mj-styles' === $hook ) {
		wp_enqueue_style( 'codemirror-css', plugins_url( 'mj-styles/assets/codemirror.css' ) );
        wp_enqueue_style( 'dracula-css', plugins_url( 'mj-styles/assets/dracula.css' ) );

        wp_enqueue_script( 'codemirror-js', plugins_url( 'mj-styles/assets/codemirror.js' ), [], '20161119', true );
        wp_enqueue_script( 'css-js', plugins_url( 'mj-styles/assets/css.js' ), [], '20161119', true );
	}
});

/**
 * Add "Custom Styles" submenu to "Appearance" Admin Menu
 */
add_action( 'admin_menu', function() {
    add_theme_page( __( 'MJ Styles', 'mj-styles' ), __( 'Custom Styles', 'mj-styles' ), 'edit_theme_options', basename( MJS_FILE ), 'mjs_display_submenu_page' );
} );



/**
 * Register settings
 */
add_action( 'admin_init', function() {
    register_setting( 'mjs_settings_group', 'mjs_settings' );
} );


/**
 * Display Admin Menu page
 */
function mjs_display_submenu_page() {

	$options = get_option( 'mjs_settings' );
	$content = isset( $options['mjs-content'] ) && ! empty( $options['mjs-content'] ) ? $options['mjs-content'] : __( '/* Enter Your Custom CSS Here */', 'mj-s' );

	if ( isset( $_GET['settings-updated'] ) ) : ?>
		<div id="message" class="updated"><p><?php _e( 'Custom Styles updated successfully.', 'mj-s' ); ?></p></div>
	<?php endif; ?>

	<div class="wrap">
		<h2 style="margin-bottom: 1em;"><?php _e( 'Custom Styles', 'mj-s' ); ?></h2>

		<form name="mjs-form" action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'mjs_settings_group' ); ?>

            <div>
                <textarea id="content" name="mjs_settings[mjs-content]" id="mjs_settings[mjs-content]" ><?php echo esc_html( $content ); ?></textarea>
            </div>

			<div id="template">
				<?php do_action( 'mjs-form-top' ); ?>

				<?php do_action( 'mjs-textarea-bottom' ); ?>
				<div>
					<?php submit_button( __( 'Update Custom Styles', 'mj-s' ), 'primary', 'submit', true ); ?>
				</div>
				<?php do_action( 'mjs-form-bottom' ); ?>
			</div>

		</form>

		<script>

            jQuery( document ).ready( function() {
                var myCodeMirror = CodeMirror.fromTextArea(content ,
        			{
                        mode : 'css',
        				lineNumbers : true,
                        theme : 'dracula',
        			});
            });
		</script>
	</div>
<?php
}
