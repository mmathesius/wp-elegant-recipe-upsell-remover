<?php
/**
 * Plugin Name: WordPress Elegant Recipe Theme Upsell Panel Remover
 * Plugin URI:  https://yourwebsite.com
 * Description: Automatically hides the premium upsell panel (.section-action) from the free version of the Elegant Recipe Blog Theme.
 * Version:     1.0.0
 * Author:      Your Name
 * License:     GPL2
 */

// Exit if accessed directly to protect against malicious URL hits
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Inject the CSS snippet into the frontend header
function wperp_hide_upsell_panel() {
    echo '<style type="text/css">
        .section-action {
            display: none !important;
        }
    </style>';
}
add_action( 'wp_head', 'wperp_hide_upsell_panel' );
