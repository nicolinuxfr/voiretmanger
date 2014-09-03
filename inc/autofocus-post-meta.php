<?php

/**	
 *	Post Options and Instructions
 *	Create Post Meta Options and Shortcode Instructions
 */


/**	
 *	Post Meta Options 
 * 	New Array For Video Embed Codes, Copyright info, , and Image Position Gallery Display Option
 */
$af_option_meta_boxes = array(
"video" => array(
	"name" => "videoembed_value",
	"title" => __("Embed URL","autofocus"),
	"type" => "text",
	"std" => "",
	"description" => __("Paste your oEmbed URL here. (Examples: http://vimeo.com/7757262 or http://www.youtube.com/watch?v=xwnJ5Bl4kLI)","autofocus")),

"copyright" => array(
	"name" => "copyright_value",
	"title" => __("Photo Credit","autofocus"),
	"type" => "text",
	"std" => "",
	"description" => __("Text entered here will replace the default Photo credit. (Example: &copy; 2011 Photographer Name. All rights reserved.)","autofocus")),

"showgallery" => array(
	"name" => "show_gallery",
	"title" => __("Show Sliding Image Gallery?","autofocus"),
	"type" => "checkbox",
	"std" => "FALSE",
	"description" => __("Show a sliding Gallery of attached images above the post title? (Limited to 10 images. IMPORTANT: All images must be at least 800px wide or 600px tall.)","autofocus")),

"slider_count" => array(
	"name" => "slider_count_value",
	"title" => __("Slider Image Count","autofocus"),
	"type" => "text",
	"std" => "10",
	"description" => __("This determines how many images are displayed in the image slider. (Recommended Maximum: <strong>20</strong>)","autofocus")),

"af_image_pos_top" => array(
	"name" => "af_image_pos_top_value",
	"title" => __("Top Image Position","autofocus"),
	"type" => "hiddentext",
	"std" => '',
	"description" => __("Set the top image position.","autofocus")),

"af_image_pos_left" => array(
	"name" => "af_image_pos_left_value",
	"title" => __("Left Image Position","autofocus"),
	"type" => "hiddentext",
	"std" => '',
	"description" => __("Set the left image position.","autofocus")),
); 


/**	
 *	AutoFocus Options Meta Boxes 
 */
function af_option_meta_boxes() {
  global $post, $af_option_meta_boxes; ?>

	<div class="form-wrap">

		<?php 
		foreach($af_option_meta_boxes as $meta_box) {
			$meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);

			if($meta_box_value == "")
				$meta_box_value = $meta_box['std'];

			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			switch ( $meta_box['type'] ) {
				case 'text':
					echo '<div class="form-field form-required">';
					echo '<label for="'.$meta_box['name'].'">'.$meta_box['title'].'</label>';
					echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" />';
					echo '<p id="'.$meta_box['name'].'">'.$meta_box['description'].'</p></div>';
				break;

				case 'hiddentext':
					echo '<div class="form-field form-required hide" style="display:none">';
					echo '<label for="'.$meta_box['name'].'">'.$meta_box['title'].'</label>';
					echo '<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" />';
					echo '<p id="'.$meta_box['name'].'">'.$meta_box['description'].'</p></div>';
				break;

				case 'checkbox':
					echo '<div class="form-field form-required">';
					echo '<label for="'.$meta_box['name'].'" class="selectit">'.$meta_box['title'];
					echo '<input type="checkbox" style="text-align:left;width:50px;" name="'.$meta_box['name'].'"  value="true"';
					checked('true', $meta_box_value);
					echo ' /></label>';
					echo '<p id="'.$meta_box['name'].'">'.$meta_box['description'].'</p></div>';
				break;
			}
		} ?> 
	</div>
<?php }

/**	
 *	Flickr Options Meta Boxes 
 */
function af_flickr_meta_boxes() {
	global $post, $af_flickr;
	$flickr_user_id = flickrUserId();
	$flickr_api_key = flickrApiKey();

	if ( !empty($flickr_user_id) && !empty($flickr_api_key) ) {
		$flickr_sets = $af_flickr->photosets_getList( flickrUserId() );
		if ( count( $flickr_sets['photoset'] ) == 0 ) {
			?>
			<div><?php _e( 'You currently have no publicly viewable Flickr sets.', 'flickr' ); ?></div>
			<?php
		} else { ?>
			<div>
				<?php wp_nonce_field( 'af-phpflickr-custom-fields', 'af-phpflickr-custom-fields_wpnonce', false, true ); ?>
				<div style="padding: 15px 0 15px 5px">
					<label for="enable_flickr"><?php _e( 'Enable Flickr:', 'autofocus' ); ?></label> 
					<input type="checkbox" id="enable_flickr" name="enable_flickr" <?php if ( get_post_meta( $post->ID, 'enable_flickr', true ) ) { echo 'checked="checked"'; }?> />
				</div>
				<div style="padding: 0 0 10px 5px">
					<?php _e( 'Choose Flickr set:', 'autofocus' ); ?>
					<select id="flickr_set" name="flickr_set" >
						<?php foreach ($flickr_sets['photoset'] as $photoset) { ?>
							<option value="<?php echo $photoset["id"]; ?>" <?php if ( (string)get_post_meta( $post->ID, 'flickr_set', true ) == (string)$photoset["id"] ) { echo 'selected'; }?>><?php echo $photoset["title"]; ?></option>
						<?php } ?>
					</select>
				</div>
				<div style="padding: 15px 0 15px 5px">
					<label for="flickr_link"><?php _e('Add a link to the Flickr Gallery?:', 'autofocus' ); ?></label> 
					<input type="checkbox" id="flickr_link" name="flickr_link" <?php if ( get_post_meta( $post->ID, 'flickr_link', true ) ) { echo 'checked="checked"'; }?> />
				</div>
			</div>

	<?php }
	
	} else { ?>
		<div><?php _e( 'You must provide your Flickr user ID and API Key under Appearance &rarr; Theme Options &rarr; Flickr Settings', 'autofocus' ); ?></div>
	<?php }

}
//	Add Action Hooks
//add_action( 'admin_menu', 'create_af_meta_boxes' );
//add_action( 'save_post', 'save_af_meta_data' );
//add_action( 'save_post', 'save_flickr_data');

/**	
 *	Create Form Data 
 */
function create_af_meta_boxes() {
	global $theme_name;
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'af_option_meta_boxes', __('AutoFocus Post Options', 'autofocus'), 'af_option_meta_boxes', 'post', 'normal', 'high' );
		add_meta_box( 'af_flickr_meta_boxes', __('Flickr Settings', 'autofocus'), 'af_flickr_meta_boxes', 'post', 'normal', 'high' );
	}
}

/**	
 *	Save Form Data
 */
function save_af_meta_data( $post_id ) {
	global $post, $af_option_meta_boxes, $af_flickr_meta_boxes;

	foreach($af_option_meta_boxes as $meta_box) {
		// Verify
		if ( isset( $_POST[$meta_box['name'].'_noncename'] ) && !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}
	
		if ( isset( $_POST['post_type'] ) && ('page' == $_POST['post_type'] ) ) {
			if ( !current_user_can( 'edit_page', $post_id ))
				return $post_id;
		} else {
			if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
		}
	
		if ( isset( $_POST[$meta_box['name']] ) ) {
			$data = $_POST[$meta_box['name']];
		}
	
		if ( get_post_meta($post_id, $meta_box['name']) == "" )
			add_post_meta($post_id, $meta_box['name'], $data, true);
	
		elseif ( isset( $data ) && ($data != get_post_meta($post_id, $meta_box['name'], true)) )
			update_post_meta($post_id, $meta_box['name'], $data);
	
		elseif ( isset( $data ) && $data == "")
		delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
	}
}

/**	
 *	Save Flickr Form Data
 */
function save_flickr_data( $post_id ) {
	global $post;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;

	if ( !isset( $_POST[ 'af-phpflickr-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'af-phpflickr-custom-fields_wpnonce' ], 'af-phpflickr-custom-fields' ) )
		return $post_id;

	$flickr_data = array( 'enable_flickr', 'flickr_set', 'flickr_link' );

	foreach ( $flickr_data as $field ) {
		if ( isset( $_POST[ $field ] ) && trim( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, $_POST[ $field ] );
		} else {
			delete_post_meta( $post_id, $field );
		}
	}

	return true;
}

?>