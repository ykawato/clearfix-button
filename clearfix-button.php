<?php
/*
Plugin Name: Clearfix Button
Plugin URI:  https://glocalism.co.jp
Description: Adds a TinyMCE button to insert a clearfix div into content in the Classic Editor, with a dim line shown in Visual mode.
Version:     1.1
Author:      ykawato
Author URI:  https://glocalism.co.jp
License:     GPL2
Text Domain: clearfix-button
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the TinyMCE plugin script for the Classic Editor.
 */
function cb_clearfix_button_register_plugin( $plugins ) {
    // Path to the JS file that will handle the TinyMCE plugin code
    $plugins['clearfix_button'] = plugin_dir_url( __FILE__ ) . 'clearfix-button.js';
    return $plugins;
}

/**
 * Add the new button to the TinyMCE buttons array.
 */
function cb_clearfix_button_register_button( $buttons ) {
    // Add the name of the TinyMCE plugin button
    array_push( $buttons, 'clearfix_button' );
    return $buttons;
}

/**
 * Enqueue editor stylesheet (TinyMCE) so that .clearfix has a dashed line in visual mode.
 */
function cb_clearfix_button_editor_styles( $mce_css ) {
    $editor_style_url = plugin_dir_url( __FILE__ ) . 'clearfix-button-editor.css';

    // Append our CSS file to the list of editor styles
    if ( ! empty( $mce_css ) ) {
        $mce_css .= ',';
    }
    $mce_css .= $editor_style_url;
    return $mce_css;
}

/**
 * Initialize registering the button and loading editor-only CSS
 * only if the user can edit and if rich editing is enabled.
 */
function cb_clearfix_button_init() {

    // Check if the user can edit posts or pages
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
        return;
    }

    // Check if rich editing is enabled
    if ( get_user_option( 'rich_editing' ) !== 'true' ) {
        return;
    }

    // Hook in our TinyMCE plugin
    add_filter( 'mce_external_plugins', 'cb_clearfix_button_register_plugin' );
    add_filter( 'mce_buttons', 'cb_clearfix_button_register_button' );

    // Hook in our editor-only CSS
    add_filter( 'mce_css', 'cb_clearfix_button_editor_styles' );
}
add_action( 'admin_head', 'cb_clearfix_button_init' );