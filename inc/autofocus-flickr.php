<?php
/**
 * AutoFocus Flickr Functions 
 *
 * Pulls theme options and phpFlickr data for flickr galleries, sliders, etc.
 *
*/

/**
 * Displays Flickr Set Primary Image 
 */
function get_flickr_photo_set_link( $post_id ) {
	global $post, $af_flickr;
	$flickr_setid = $af_flickr->photosets_getInfo ( get_post_meta( $post_id, 'flickr_set', true ) );
	$flickr_username = flickrUsername();
	return "http://flickr.com/photos/" . $flickr_username . "/sets/" . $flickr_setid['id'] . "/";
}

/**
 * Displays Flickr Photosets in a slider  
 */
function get_flickr_photo_slider( $flickrsize = '', $limit ) {
	global $post, $af_flickr;

	$photos = $af_flickr->photosets_getPhotos(get_post_meta( $post->ID, 'flickr_set', true ), NULL, NULL, $limit);
	
	if ( $photos != null ) { 
		$return = null;
		$return .= '<div class="entry-gallery-container"><div id="gallery-container" class="cycle">';
	
		// Loop
		foreach ($photos['photoset']['photo'] as $photo) {
			$return .='<span class="entry-image"><a href="' . $af_flickr->buildPhotoURL($photo, 'large') . '" title="' . $photo['title'] . '" rel="ha-gallery"><img src="' . $af_flickr->buildPhotoURL($photo, 'large') . '" alt="' . $photo['title'] . '" title="' . $photo['title'] . '" width="800" /></a></span>';
		}
		echo $return .= '</div></div>';
	}
}

/**
 * Displays Flickr Set Primary Image 
 */
function get_flickr_set_primary_uri( $post_id, $flickrsize = '' ) {
	global $post, $af_flickr;
	$info = $af_flickr->photosets_getInfo ( get_post_meta( $post_id, 'flickr_set', true ) );
	return "http://farm" . $info['farm'] . ".static.flickr.com/" . $info['server'] . "/" . $info['primary'] . "_" . $info['secret'] . "" . $flickrsize . ".jpg";
}

/**
 * Creates Flickr Gallery for Shortcode Function
 */
function af_flickr_gallery_shortcode( $setID = '', $limit = '10' ) {
	global $af_flickr;

	$photos = $af_flickr->photosets_getPhotos($setID, NULL, NULL, $limit);

	if ( $photos != null ) { 
		$return.='<ul class="flickr-photos">';
		// Loop
		foreach ($photos['photoset']['photo'] as $photo) {
			$return.='<li><img style="max-width:188px;max-height:188px;" src="' . $af_flickr->buildPhotoURL( $photo, "small" ) . '" alt="' . $photo['title'] . '" /></li>';
		}
		echo $return.='</ul>';
	}
}

?>