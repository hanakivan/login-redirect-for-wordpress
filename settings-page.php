<?php

/**
 * Special thanks to: https://deliciousbrains.com/create-wordpress-plugin-settings-page/
 */

function lrfw_add_settings_page() {
	add_options_page(
		LRFW_PLUGIN_NAME,
		LRFW_PLUGIN_NAME,
        'manage_options',
		LRFW_SLUG,
        'lrfw_render_plugin_settings_page'
    );
}
add_action( 'admin_menu', 'lrfw_add_settings_page' );

function lrfw_render_plugin_settings_page() {
	?>
	<h2><?php echo LRFW_PLUGIN_NAME;?></h2>
	<form action="options.php" method="post">
		<?php
		settings_fields( LRFW_OPTIONS_NAME );
		do_settings_sections( 'lrfw_plugin' ); ?>
		<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
	</form>
	<?php
}

function lrfw_register_settings() {
	register_setting( LRFW_OPTIONS_NAME, LRFW_OPTIONS_NAME, 'lrfw_example_plugin_options_validate' );
	add_settings_section( 'api_settings', 'Settings', 'lrfw_plugin_section_text', 'lrfw_plugin' );

	add_settings_field( 'lrfw_field_login_redirect_url', 'Login redirect URL', 'lrfw_field_login_redirect_url', 'lrfw_plugin', 'api_settings' );
}
add_action( 'admin_init', 'lrfw_register_settings' );

function lrfw_example_plugin_options_validate( $input ) {
	$newinput['login_redirect_uri'] = trim( $input['login_redirect_uri'] );

    if(filter_var($newinput['login_redirect_uri'], FILTER_VALIDATE_URL) === false) {
	    $newinput['login_redirect_uri'] = "";
    }

	return $newinput;
}

function lrfw_plugin_section_text() {
	echo '<p>Here you can configure all the settings for the plugin.</p>';
}

function lrfw_field_login_redirect_url() {
	$options = get_option( LRFW_OPTIONS_NAME );

    if(!is_array($options)) {
	    $options = [];
    }

    if(!isset($options["login_redirect_uri"])) {
	    $options["login_redirect_uri"] = "";
    }

	echo "<input class='regular-text' id='lrfw_field_login_redirect_url' name='".LRFW_OPTIONS_NAME."[login_redirect_uri]' type='text' value='" . esc_attr( $options['login_redirect_uri'] ) . "' />";
    echo "<br />";
    echo "<span style='display: block; margin-left: 3px; font-size: 12px; margin-top: 3px'>Information: Works only with URLs of the current site.</span>";
}