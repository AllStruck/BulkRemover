<?php
/*

*/
add_action('admin_menu', 'add_bulk_remover_menu');


function add_bulk_remover_menu() {
	add_submenu_page( 'tools.php', 'Bulk Remover', 'Bulk Remover', 'manage_options', 'bulk-remover', 'bulk_remover_menu_page_output' );
}
function bulk_remover_menu_page_output() {
	 $post_types_input_selection = "";
	 $post_types = get_post_types(array('public'=> true));

	if (!isset($_POST['Delete'])) {
	 
		// Show options for post types that can be deleted:
		foreach ($post_types as $post_type) {
			$posts_count = wp_count_posts($post_type);
			$total_count = $posts_count->trash + $posts_count->publish + $posts_count->draft;
			$post_types_input_selection .= '<input type="checkbox" name="' . $post_type . '" value="' . $post_type . '" /> <strong>' . $post_type . '</strong> <i>(Published: ' . $posts_count->publish . ', Draft: '. $posts_count->draft .', Trash: '. $posts_count->trash .'. Total: '. $total_count .')</i><br/>';
		}

	 	echo <<<ECHO
	 
	 <h1>Bulk Remover</h1>
	 
	 <h3>Select the types which you wish to delete <strong>all</strong> posts from.</h3>
	 
	 
	 <form action="/wp-admin/tools.php?page=bulk-remover" method="post">
	 
	 <p>$post_types_input_selection</p>
	 
	 <p><strong style="color:red">Warning:</strong> Clicking this delete button will delete all of the posts from the types you selected above (<u>published</u>, <u>draft</u>, and <u>trash</u>) <strong>without confirmation</strong>!</p>
	 
	 <p><input style="font-size:14pt;font-weight:bold;color:red !important;" type="submit" name="Delete" value="Delete" /></p>
	 
	 </form>
	 
ECHO;

	} else {
		echo <<<ECHO
		<h3>Sorry for the wait, here's what happened:</h3>
ECHO;

		// Delete the posts:
		foreach ($post_types as $post_type) {
			global $post;
			if (isset($_POST[$post_type]) && $_POST[$post_type] == $post_type) {
				$postsObject = get_posts(array(
					'post_type' => $post_type, 'numberposts' => 9999,
					'post_status' => array('publish', 'draft', 'trash')));
				foreach ($postsObject as $postObject) {
					setup_postdata($postObject);
					wp_delete_post($postObject->ID, true); // Force complete delete.
					echo '<p>Deleted ID: ' . $postObject->ID . ' Title: ' . $postObject->post_title . '</p>';
				}
				echo '<p style="color:red;">Posts in type ' . $post_type . ' deleted.</p>';
			} else {
				echo '<p>$_POST[$post_type] not set or does not match $post_type</p>';
			}
		}
	}
}