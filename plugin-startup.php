<?php
####################################################################################################
# This contains all of the wordpress front-end and wp-admin settings and the reference libraries   #
####################################################################################################

# create a unique slug for the plugin WOLFECANDY_[SLUG]_PLUGIN_VERSION - use this with all functions to ensure unique
define('WOLFECANDY_QRCODE_PLUGIN_VERSION', '1.0');

#-------------------------------------
# CREATE ANY CUSTOM USER ROLES REQUIRED BY PLUGIN

function WOLFECANDY_QRCODE_add_process_roles_on_plugin_activation() {

#add_role( string $role, string $display_name, array $capabilities = array() )

       #add_role( 'process-manager', 'Process X Manager', array( 'po' => true ) );
	   #add_role( 'process-admin', 'Process X Administrator', array( 'po' => true ) );
	   #...
	   #...
}
register_activation_hook( __FILE__, 'WOLFECANDY_QRCODE_add_process_roles_on_plugin_activation' );


#-------------------------------------
# FUNCTIONS TO RUN AT START-UP

function WOLFECANDY_QRCODE_run_process_startup_functions() {

	# e.g. create database tables
	#CreateTables();
	
 #       if ( check_role('Subscriber')  ){
                # ...
                # ...
 #       } else {  }

}

#-------------------------------------
# run on start up after the theme has been loaded
add_action( 'after_setup_theme', 'WOLFECANDY_QRCODE_run_process_startup_functions' );

#-------------------------------------

############################ ADMIN DASHBOARD #######################

############################ SHOW METHOD

# add menu items via WordPress admin dashboard
# add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )

# Required capabiliy is "edit-pages"

function WOLFECANDY_QRCODE_my_add_menu_item_tasks(){

}
add_filter( 'admin_menu', 'WOLFECANDY_QRCODE_my_add_menu_item_tasks' );

#############################################################################
#-------------------------------------
# ACTIVATE FUNCTIONS USING SHORTCODE

# SYNTAX: add_shortcode(  $tag,  $func ); 

# NB: shortcut code name, function name to include within pages or posts

#-------------------------------------------------
add_shortcode('show-qr-code', 'ShowQRCode');

#-------------------------------------------------

############################ WORDPRESS ACTION FUNCTIONS

function WOLFECANDY_QRCODE_wptp_add_tags_to_attachments() {
        #register_taxonomy_for_object_type( 'post_tag', 'attachment' );
    }
add_action( 'init' , 'WOLFECANDY_QRCODE_wptp_add_tags_to_attachments' );

#############################################################################
############################ BESPOKE FUNCTIONS

# continue in functions.php for generic calls and also create new [x].php files to include

# plugin specific functions - only add these if using the direct class
require( 'C-qr-code.php' );  
	
//------------------------------------------------------------------


function show_notices_for_WOLFECANDY_QRCODE() {
    // We attempt to fetch our transient that we stored earlier.
    // If the transient has expired, we'll get back a boolean false
    $message = get_transient( 'my_plugin_activation_error_message' );
	delete_transient ('my_plugin_activation_error_message');

    if ( ! empty( $message ) ) {
        esc_html_e("<div class='notice notice-error is-dismissible'>
            <p>$message</p>
        </div>");
    }
}

add_action( 'admin_notices', 'show_notices_for_WOLFECANDY_QRCODE' );

//------------------------------------------------------------------

function ShowQRCode($_atts){

	// call the QR class
	$qr = new WlfC_QRCode();
	$html_out=$qr->Build_QRCode($_atts);

	return $html_out;

}


?>