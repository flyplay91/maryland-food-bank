<?php
/**
* Plugin Name: Location Import
* Plugin URI: http://mdfoodbank.org
* Description: Custom location data import script
* Version: 1.0
* Author: WebConnection
* Author URI: www.webconnection.com
* License: A "Slug" license name e.g. GPL12
*/

defined('ABSPATH') or die("No script kiddies please!");

// Initialize the menu
function location_import_menu(){

    add_menu_page('Import Locations', 'Import Locations', 'manage_options', 'location-import-menu', 'location_import_options', '', 15);

    // add_submenu_page('location-import-menu', 'Pull Coordinates', 'Pull Coordinates', 'manage_options', 'pull-coordinates', 'pull_coordinates');

     add_submenu_page('location-import-menu', 'Purge Locations', 'Purge Locations', 'manage_options', 'purge-locations', 'purge_locations');

}

// Add menu
add_action('admin_menu','location_import_menu');

// Render pages
function location_import_options(){

    if(!@include("admin/location-import-admin.php")) throw new Exception("Failed to include 'location-import-admin.php'");

}

function pull_coordinates(){

    if(!@include("admin/pull-coordinates.php")) throw new Exception("Failed to include 'pull-coordinates.php'");

}

function purge_locations(){

    if(!@include("admin/purge-locations.php")) throw new Exception("Failed to include 'purge-locations.php'");

}



?>