<?php
/**
 *	AutoFocus Shortcodes
 *
 *	Adds custom Shortcodes for displaying dynamic content within the post area.
*/

/**	
 *	Pull Quote Shortcode
 */
function pull_quote_sc($atts, $content = null) {
	extract( shortcode_atts( array(
		'author' => 'Author’s Name (Default)',
		), $atts ) );
	return '<blockquote class="pull-quote"><p>' . $content . '</p><cite class="author"> &mdash; ' . esc_attr($author) . '</cite></blockquote>';
}
add_shortcode("pullquote", "pull_quote_sc");

/**	
 *	Flickr Gallery Shortcode
 */
function flickr_gallery_sc($atts, $content = null) {
	global $af_flickr;

	extract( shortcode_atts( array(
		'setid' => '',
		'limit' => '10',
		), $atts ) );

	// Create varibles from shortcode attributes
	$sc_setid = esc_attr($setid);
	$sc_limit = esc_attr($limit);

	// Flickr loop variables
	$images = $af_flickr->photosets_getPhotos($sc_setid, NULL, NULL, $sc_limit);

	if ( $images != null ) { 
		$return = '<div id="gallery-flickrset" class="gallery"><div class="gallery-row clear">';
		$count = 0;
	
		// Start Flickr loop
		foreach ($images['photoset']['photo'] as $image) { 
			$count++;
			if(($count % 5) == 0 && ($count) != ($sc_limit)) {
				$return.='<dl class="gallery-item col-5"><dt class="gallery-icon"><a href="' . $af_flickr->buildPhotoURL($image, 'large') . '" title="' . $image['title'] . '"><img style="max-width:88px;max-height:88px;" src="' . $af_flickr->buildPhotoURL( $image, "square" ) . '" alt="' . $image['title'] . '" /></a></dt></dl></div><div class="gallery-row clear">';
			} else {
				$return.='<dl class="gallery-item col-5"><dt class="gallery-icon"><a href="' . $af_flickr->buildPhotoURL($image, 'large') . '" title="' . $image['title'] . '"><img style="max-width:88px;max-height:88px;" src="' . $af_flickr->buildPhotoURL( $image, "square" ) . '" alt="' . $image['title'] . '" /></a></dt></dl>';
			}
		}
		return $return.='</div></div>';
	}
}
add_shortcode("flickrgallery", "flickr_gallery_sc");

/**	
 *	Large Post Image Shortcode
 */
function large_image_sc($atts, $content = null) {
	extract( shortcode_atts( array(
		// 'description' => 'This is a short or detailed description for the image you see over there on the left. (Default)',
		'description' => '',
		), $atts ) );
	if ( !$description == '' ) {
		return '<figure class="large-image">' . $content . '<figcaption class="image-description ie6">' . esc_attr($description) . '</figcaption></figure>';
	} elseif ( $description == '' ) {
		return '<figure class="large-image">' . $content . '</figure>';
	}
}
add_shortcode("largeimage", "large_image_sc");

/**	
 *	Narrow Columns Shortcode
 */
function narrow_column_sc($atts, $content = null) {
	extract( shortcode_atts( array(
		'side' => 'left',
		), $atts ) );
	return '<div class="narrow-column ' . esc_attr($side) . '"><p>' . $content . '</p></div>';
}
add_shortcode("narrowcolumn", "narrow_column_sc");

/**
 * The AutoFocus Five Caption shortcode.
 * added by Richard Shepherd to include HTML5 goodness
 *
 * The supported attributes for the shortcode are 'id', 'align', 'width', and
 * 'caption'.
 *
 */
function autofocus_img_caption_shortcode($attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;


if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';
$align = 'class="' . esc_attr($align) . '" ';

  return '<figure ' . $idtag . $align . 'aria-describedby="figcaption_' . $id . '" style="width: ' . $width . 'px">' 
  . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';
}
add_shortcode('wp_caption', 'autofocus_img_caption_shortcode');
add_shortcode('caption', 'autofocus_img_caption_shortcode');


// AJOUTS PERSOS

function retro_f($atts, $content = null) {
	extract( shortcode_atts( array(
		'author' => 'Author’s Name (Default)',
		), $atts ) );
	return '<blockquote class="pull-quote"><p>' . $content . '</p><cite class="author"> &mdash; ' . esc_attr($author) . '</cite></blockquote>';
}
add_shortcode("retro", "retro_f");


?>