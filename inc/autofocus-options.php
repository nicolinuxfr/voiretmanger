<?php
/**
 * Defines tha AutoFocus Theme Options
 *
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	$shortname = "af";
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 */

function optionsframework_options() {
	global $shortname;
	
	// If using image radio buttons, define a directory path
	$imagepath = TEMPLATE_DIR . '/inc/options/images/';

	// Frontpage Layout Choices 
	$layout_choices =  array(
		'grid' => $imagepath . 'grid-view.png',
		'default' => $imagepath . 'stag-view.png'
	);

	// Date & Title Choices 
	$date_title_choices = array(
		'titledate' => __( 'Post Title &rarr; Post Date', 'autofocus' ),
		'datetitle' => __( 'Post Date &rarr; Post Title', 'autofocus' ),
		'title' => __( 'Post Title only', 'autofocus' ),
		'date' => __( 'Post Date only', 'autofocus' )
	);

	// Post Title Display
	$title_position_choices =  array(
		'inline' => $imagepath . 'inline-pos.png',
		'sidebar' => $imagepath . 'sidebar-pos.png'
	);
	
	// Slider Navigation Choices 
	$slider_nav_choices = array(
		'numbered' => __( 'Numbered', 'autofocus' ),
		'prevnext' => __( 'Previous & Next', 'autofocus' )
	);
	
	// Image Display Choices 
	$image_display_choices = array(
		'full-post-thumbnail' => $imagepath . 'full-img.gif',
		'fixed-post-thumbnail' => $imagepath . 'fixed-img.gif'
	);

	// Archive Layout Choices 
	$archive_layout_choices =  array(
		'default' => $imagepath . 'default-view.png',
		'images' => $imagepath . 'image-view.png'
	);	

	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[''] = 'Select a category:';
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	$options = array();
	
	// Display options
	$options[] = array( "name" => __('Layout Options', 'autofocus'),
	                    "type" => "heading");
	
	$options[] = array( "name" => __('Home Page Layout','autofocus'),
						"desc" => __('<strong>Grid (Portfolio) Layout</strong> Shows a square grid of images on the home page.  <strong>Staggered (Default) Layout</strong> Shows a staggered grid of images on the home page with excerpts.','autofocus'),
						"id" => $shortname . "_home_layout",
						"std" => "grid",
						"type" => "images",
						"options" => $layout_choices);
						
	$options[] = array( "name" => __('Post Title Position', 'autofocus'),
						"desc" => __('<strong>Inline</strong> Display the Post Title just below the Entry Image. <strong>Sidebar</strong> Display the Post Title to the right of the Entry Content.','autofocus'),
						"id" => $shortname . "_title_position",
						"std" => "inline",
						"type" => "images",
						"options" => $title_position_choices);
						
	$options[] = array( "name" => __('Image Display', 'autofocus'),
						"desc" => __('Choose how to display images and galleries on single posts. <strong>Full</strong> Shows images on single posts at 800 pixels wide with a flexible height. (IMPORTANT: When using the slider option, slides do not rotate automatically). <strong>Fixed</strong> Constrains images on single posts to fit in a 800px &times; 600px display area.','autofocus'),
						"id" => $shortname."_image_display",
						"std" => "full-post-thumbnail",
						"type" => "images",
						"options" => $image_display_choices);

	$options[] = array( "name" => __('Archive Layout', 'autofocus'),
						"desc" => __('<strong>Default</strong> Uses the default archive layout on archive pages. <strong>Images</strong> Uses the AutoFocus Home Page Layout (See settings above) on archives pages.','autofocus'),
						"id" => $shortname . "_archive_layout",
						"std" => "default",
						"type" => "images",
						"options" => $archive_layout_choices);
						
	$options[] = array(	"name" => __('iPhone Support (Experimental)', 'autofocus'),
						"desc" => __("This is an <em>experimental</em> feature that displays a mobile version of AutoFocus when accessing your site from an iPhone.",'autofocus'),
						"id" => $shortname."_iphone",
						"std" => false,
						"type" => "checkbox");

	$options[] = array( "name" => __('General Options', 'autofocus'),
	                    "type" => "heading");
	
	$options[] = array( "name" => __('Post Title & Date Display','autofocus'),
						"desc" => __('<strong>Post Title &rarr; Post Date</strong> Shows the Post Title initially. Shows the Post Date on mouse-overs.  <strong>Post Date &rarr; Title</strong> Shows the Post Date initially. Shows the Post Title on mouse-overs.  <strong>Post Title only</strong> Shows the Post Title on mouse-overs.  <strong>Post Date only</strong>Shows the Post Date on mouse-overs.  ','autofocus'),
						"id" => $shortname."_title_date",
						"std" => "titledate",
						"type" => "radio",
						"options" => $date_title_choices);
						
	$options[] = array( "name" => __('Sliding Feature Area','autofocus'),
						"desc" => __('Show a sliding featured content area of <a href="http://www.nathanrice.net/blog/definitive-sticky-posts-guide-for-wordpress-27/" target="_blank">Sticky Posts</a> on the front page?','autofocus'),
						"id" => $shortname."_sliding_sticky_area",
						"std" => FALSE,
						"type" => "checkbox");
	
	$options[] = array( "name" => __('Slider Navigation','autofocus'),
						"desc" => __('<strong>Numbered</strong> Uses a numbered list to slide between images (ie: 1, 2, 3, etc). <strong>Previous & Next</strong> Uses Previous / Next links and an image count to slide between images (ie: &lsaquo;Prev 1/10 Next&rsaquo;). ','autofocus'),
						"id" => $shortname."_slider_nav",
						"std" => "numbered",
						"type" => "radio",
						"options" => $slider_nav_choices);
						
	$options[] = array( "name" => __('Blog Category','autofocus'),
						"desc" => __('Select a post category to be shown in the Blog Template and excluded from the Front Page.','autofocus'),
						"id" => $shortname."_blog_cat",
						"std" => "",
						"type" => "select",
						"options" => $options_categories);
	
	$options[] = array( "name" => __('Add Fancybox (Lightbox)','autofocus'),
						"desc" => __('Add a check here to use Fancybox within the [gallery] on single pages. (http://fancybox.net/).','autofocus'),
						"id" => $shortname."_fancybox",
						"std" => FALSE,
						"type" => "checkbox");
	
	$options[] = array( "name" => __('Show Exif data','autofocus'),
						"desc" => __('Add a check here to show the Exif data for your images on attachment pages (WP Gallery Images only).','autofocus'),
						"id" => $shortname."_show_exif_data",
						"std" => FALSE,
						"type" => "checkbox"); 
	
	$options[] = array( "name" => __('Hide Navigation Arrows','autofocus'),
						"desc" => __('Add a check here to remove the left and right navigation arrows.','autofocus'),
						"id" => $shortname."_hide_nav_arrows",
						"std" => FALSE,
						"type" => "checkbox");
	
	$options[] = array(	"name" => __('Info on Author Page','autofocus'),
						"desc" => __("Display a <a href=\"http://microformats.org/wiki/hcard\" target=\"_blank\">microformatted vCard</a> with the author&rsquo;s avatar, bio and email on the author page.",'autofocus'),
						"id" => $shortname."_author_info",
						"std" => false,
						"type" => "checkbox");

	// Branding options
	$options[] = array( "name" => __('Branding & Color Options', 'autofocus'),
	                    "type" => "heading");
	
	$options[] = array( "name" => __('Custom Logo', 'autofocus'),
						"desc" => __('Upload a logo for your theme, or specify the image address of your online logo. (Example: http://yoursite.com/logo.png)','autofocus'),
						"id" => $shortname."_logo",
						"std" => "",
						"type" => "upload");
						
	$options[] = array( "name" => __('Custom Favicon', 'autofocus'),
						"desc" => __('Upload a 16px x 16px Png/Gif image that will represent your website&rsquo;s favicon.', 'autofocus'),
						"id" => $shortname."_custom_favicon",
						"std" => "",
						"type" => "upload"); 
	
	$options[] = array( "name" => "Text Color",
						"desc" => __('Change the color of text, borders and link hover states by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#999999</span>)','autofocus'),
						"id" => $shortname."_text_color",
						"std" => "999999",
						"type" => "color");
						
	$options[] = array( "name" => __('Link Color','autofocus'),
						"desc" => __('Change the color of anchor links by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#00CCFF</span>)','autofocus'),
						"id" => $shortname."_link_color",
						"std" => "00CCFF",
						"type" => "color");
						
	$options[] = array( "name" => __('Background Color','autofocus'),
						"desc" => __('Change the background color by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#FFFFFF</span>)','autofocus'),
						"id" => $shortname."_bg_color",
						"std" => "FFFFFF",
						"type" => "color");   
	
	$options[] = array( "name" => __('Photo Background Color','autofocus'),
						"desc" => __('Change the background color of Portrait (narrow) images on Single Pages by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">#F0F0F0</span>)','autofocus'),
						"id" => $shortname."_photo_color",
						"std" => "F0F0F0",
						"type" => "color");
	
	$options[] = array(	"name" => __('Text in Footer','autofocus'),
						"desc" => __('Edit the text that shows up in the footer.', 'autofocus'),
						"id" => $shortname."_footer_text",
						"std" => __('&copy;2011 <a href=\"' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' . get_bloginfo( 'name', 'display' ) . '</a>. All rights reserved. Proudly powered by <a href="http://wordpress.org/" title="Semantic Personal Publishing Platform" rel="generator">WordPress</a>. Built with the <a class="theme-link" href="http://fthrwght.com/autofocus/" title="AutoFocus II Pro" rel="theme">AutoFocus II Pro Theme</a>.', 'autofocus'),
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "94") );

	$options[] = array( "name" => __('Custom CSS', 'autofocus'),
	                    "desc" => __('Quickly add some CSS to your theme by adding it to this block.', 'autofocus'),
	                    "id" => $shortname."_custom_css",
	                    "std" => "",
	                    "type" => "textarea");


	// Flickr options
	$options[] = array( "name" => "Flickr Options",
						"type" => "heading");
						
	$options[] = array( "name" => "Flickr Options",
						"desc" => __('Connect to your Flickr account using the settings below. A working Flickr account is required and all fields below must be filled. <br />Follow <a href="http://fthrwght.com/autofocus/#flickrapi" target="_blank">these instructions</a> to get your Flickr API and Secret Keys.','autofocus'),
						"type" => "info");

	$options[] = array(	"name" => __('Flickr Username','autofocus'),
						"desc" => '',
						"id" => $shortname."_flickr_username",
						"std" => "Insert Flickr Username",
						"type" => "text");
	
	$options[] = array(	"name" => __('Flickr API Key','autofocus'),
						"desc" => '',
						"id" => $shortname."_flickr_api_key",
						"std" => "Insert Flickr API Key",
						"type" => "text");
	
	$options[] = array(	"name" => __('Flickr Secret Key','autofocus'),
						"desc" => '',
						"id" => $shortname."_flickr_secret_key",
						"std" => "Insert Flickr Secret Key",
						"type" => "text");

	return $options;
} ?>