<?php
/**
 * Plugin Name: WordPress Elegant Recipe Theme Upsell Panel Remover
 * Plugin URI:  https://yourwebsite.com
 * Description: Automatically hides the premium upsell panel (.section-action) from the free version of the Elegant Recipe Blog Theme.
 * Version:     1.2.0
 * Author:      Your Name
 * License:     GPL2
 */

// Exit if accessed directly to protect against malicious URL hits
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Inject the CSS snippet into the frontend header
 */
function wperp_hide_upsell_panel() {
    echo '<style type="text/css">
        .section-action {
            display: none !important;
        }
    </style>';
}
add_action( 'wp_head', 'wperp_hide_upsell_panel' );

/**
 * 2. Register the hidden documentation page so it has a valid admin URL
 */
function wperp_register_doc_page() {
    add_submenu_page(
        null,                                       // Set parent to null to hide it from the sidebar menus
        'Theme Upsell Remover Documentation',       // Page title
        'Upsell Remover Docs',                       // Menu title
        'manage_options',                            // Required capability
        'wp-elegant-recipe-upsell-remover-docs',     // Menu slug
        'wperp_render_doc_page'                     // Callback function to render HTML
    );
}
add_action( 'admin_menu', 'wperp_register_doc_page' );

/**
 * 3. Add the "Documentation" link to the Plugin card row
 */
function wperp_add_action_links( $links ) {
    // Generate the URL pointing to our hidden admin page
    $doc_url = admin_url( 'admin.php?page=wp-elegant-recipe-upsell-remover-docs' );
    
    // Create the HTML link anchor
    $doc_link = '<a href="' . esc_url( $doc_url ) . '" style="font-weight: bold;">Documentation</a>';
    
    // Add it to the front of the existing action links array
    array_unshift( $links, $doc_link );
    return $links;
}
// Dynamic hook structure: plugin_action_links_{plugin_folder_name/plugin_file_name.php}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wperp_add_action_links' );

/**
 * 4. Render the documentation page HTML
 */
function wperp_render_doc_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>WordPress Elegant Recipe Theme Upsell Panel Remover</h1>
        <p>Welcome to the documentation for your custom optimization plugin.</p>
        
        <hr />

        <h2>What This Plugin Does</h2>
        <p>This plugin runs automatically in the background to ensure a clean layout on your Elegant Recipe Blog Theme website. It performs two core functions:</p>
        <ul>
            <li><strong>Frontend Clean-up:</strong> It injects a targeting CSS snippet into your site header to safely remove the <code>.section-action</code> upgrade advertisement container.</li>
            <li><strong>Theme Isolation:</strong> Because this is packaged as an independent plugin, your modification will remain intact even if the primary Elegant Recipe theme receives core updates.</li>
        </ul>

        <h2>Troubleshooting & Maintenance</h2>
        <table class="widefat fixed" cellspacing="0" style="max-width: 600px; margin-top: 15px;">
            <thead>
                <tr>
                    <th class="manage-column" scope="col" style="font-weight: bold;">Issue</th>
                    <th class="manage-column" scope="col" style="font-weight: bold;">Solution</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>The panel came back.</strong></td>
                    <td>The theme developers may have changed the container name in a theme update. Right-click and inspect the element to see if the class name is still <code>.section-action</code>.</td>
                </tr>
                <tr>
                    <td><strong>The site layout looks broken.</strong></td>
                    <td>If hiding the panel leaves a massive white gap, simply deactivate this plugin from your main Plugins screen to safely restore the default theme behavior.</td>
                </tr>
            </tbody>
        </table>

        <p style="margin-top: 25px;">
            <a href="<?php echo admin_url('plugins.php'); ?>" class="button button-secondary">← Back to Plugins</a>
        </p>
    </div>
    <?php
}
