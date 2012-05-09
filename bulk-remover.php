<?php 
/**
 *
 * Plugin Name: Bulk Remover
 * Plugin URI: http://bulkremover.allstruck.com/
 * Description: Remove all posts given a specific post type.
 * Version: 1.0b
 * Author: AllStruck
 * Author URI: http://www.allstruck.com
 * 
 * Usage:
 * 
 * 1. Navigate to the Bulk Remover menu under Tools in your WordPress Administration Menu.
 *
 */

$bulkRemoverRootDir = plugin_dir_path(__FILE__);
$bulkRemoverRootURI = plugin_dir_url(__FILE__);

require_once($bulkRemoverRootDir . '/controller/init.php');


?>