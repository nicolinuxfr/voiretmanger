<?php 
/**
 * AutoFocus JS Scripts
 *
 * Adds scripts based on the AutoFocus theme options and conditions
 */
?>

jQuery(document).ready(function(){

<?php 

	// Add Custom Cropping Script Front Page
	if ( is_user_logged_in() ) { ?>

	// Setup HashGrid Plugin: http://hashgrid.com
	var grid = new hashgrid({ 
		id: 'afgrid',					// id for the grid container
		modifierKey: 'alt',				// optional 'ctrl', 'alt' or 'shift'
		showGridKey: 'g',				// key to show the grid
		holdGridKey: 'h',    			// key to hold the grid in place
		foregroundKey: 'f',				// key to toggle foreground/background
		jumpGridsKey: 'd',				// key to cycle through the grid classes
		numberOfGrids: 1,				// number of grid classes used
		classPrefix: 'afgrid-', 		// prefix for the grid classes
		cookiePrefix: 'autofocus-grid'	// prefix for the cookie name
	}); 

<?php }

	// Add Custom Cropping Script to Front Page when logged in
	// - Thanks to: http://ericfostermedia.com/
	if ( ( is_user_logged_in() && is_home() && (current_user_can('edit_others_posts') == TRUE) ) || ( ( is_archive() || is_search() ) && is_user_logged_in() && (current_user_can('edit_others_posts') == TRUE) && $archive_layout == 'images') ) { ?>

	// IE 8 & 9 Console Error Fix
	if(Function.prototype.bind&&console&&typeof console.log=="object"){["log","info","warn","error","assert","dir","clear","profile","profileEnd"].forEach(function(method){console[method]=this.call(console[method],console);},Function.prototype.bind);}
	if(!window.log){window.log=function(){log.history=log.history||[];log.history.push(arguments);if(typeof console!='undefined'&&typeof console.log=='function'){if(window.opera){var i=0;while(i<arguments.length){console.log("Item "+(i+1)+": "+arguments[i]);i++;}}
	else if((Array.prototype.slice.call(arguments)).length==1&&typeof Array.prototype.slice.call(arguments)[0]=='string'){console.log((Array.prototype.slice.call(arguments)).toString());}
	else{console.log(Array.prototype.slice.call(arguments));}}
	else if(!Function.prototype.bind&&typeof console!='undefined'&&typeof console.log=='object'){Function.prototype.call.call(console.log,console,Array.prototype.slice.call(arguments));}
	else{if(!document.getElementById('firebug-lite')){var script=document.createElement('script');script.type="text/javascript";script.id='firebug-lite';script.src='https://getfirebug.com/firebug-lite.js';document.getElementsByTagName('HEAD')[0].appendChild(script);setTimeout(function(){log(Array.prototype.slice.call(arguments));},2000);}
	else{setTimeout(function(){log(Array.prototype.slice.call(arguments));},500);}}}}

	// This hotfix makes older versions of jQuery UI drag-and-drop work in IE9
	(function($){var a=$.ui.mouse.prototype._mouseMove;$.ui.mouse.prototype._mouseMove=function(b){if($.browser.msie&&document.documentMode>=9){b.button=1};a.apply(this,[b]);}}(jQuery));

// Make images Draggable>
	var position;
	// Add Draggable Images 
	//jQuery(".dragthis").draggable();

<!--
	// Save Position
	jQuery(".save-position").click(function(position) {
		position = jQuery(this).parents(".entry-utility").siblings(".entry-image").children(".entry-image-post-link").position();
		var postid = jQuery(this).parents("article").attr("id").replace("post-",""); 

		var data = { 
			action: "af_save_ajax_hook",
			id : postid,
			topPos: position.top,
			leftPos: position.left
		}

		console.log(data)
		jQuery.post("<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php", data, function(response) {
			console.log(response);
		});
		
		alert('<?php _e('Saved AutoFocus Image Position Settings', 'autofocus'); ?>');
		return false;

	});

	// Reset Position
	jQuery(".reset-position").click(function() {
		jQuery(this).parents(".entry-utility").siblings(".entry-image").children(".entry-image-post-link").animate({
			top: '0',
			left: '0'
		}, 200 );

		var postid = jQuery(this).parents("article").attr("id").replace("post-",""); 

		var data = { 
			action: "af_reset_ajax_hook",
			id : postid,
			topPos: '', 
			leftPos: ''
		}

		console.log(data)
		jQuery.post("<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php", data, function(response) {
			console.log(response);
		});
		
		return false;

	});

	// Edit link animation
	jQuery(".af-layout .post").hover(function(){ 
		jQuery(this).find(".entry-utility").stop(true).animate({
			opacity: 1.00,
			right: '0'
		}, 200 );
	}, function(){
		jQuery(this).find(".entry-utility").stop(true).animate({
			opacity: 0,
			right: '-=100'
		}, 200 );
	});
-->

<?php }


	// Set Up Titles for Front Page using the Default Layout
	if ( (is_home() && $home_layout == 'default') || ( $archive_layout == 'images' && $home_layout == 'default' && ( is_archive() || is_search() ) ) ) {

		if ( $title_date == 'titledate' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
		
		<?php } elseif ( $title_date == 'datetitle' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
	
		<?php } elseif ( $title_date == 'title' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
		
		<?php } elseif ( $title_date == 'date' ) { ?>
		
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
	
		<?php } 
	}

	// Set Up Titles for Front Page using the Grid Layout
	if ( ( is_home() && $home_layout == 'grid') || ( $archive_layout == 'images' && $home_layout == 'grid' && ( is_archive() || is_search() ) ) ) {

		if ( $title_date == 'titledate' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
		
			// Hover animations for front page
			jQuery(".af-layout #sticky-area .post").hover(function(){ 
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
			}, function(){
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
			});

		<?php } elseif ( $title_date == 'datetitle' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
	
			// Hover animations for front page
			jQuery(".af-layout #sticky-area .post").hover(function(){ 
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
			}, function(){
				jQuery(this).children(".entry-content").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
			});

		<?php } elseif ( $title_date == 'title' ) { ?>
	
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-title").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
		
		<?php } elseif ( $title_date == 'date' ) { ?>
		
			// Hover animations for front page
			jQuery(".af-layout .post").hover(function(){ 
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 1.0).css({'display' : 'block'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 0.25);
			}, function(){
				jQuery(this).find(".entry-date").stop(true).fadeTo("fast", 0).css({'display' : 'none'});
				jQuery(this).children(".entry-image").stop(true).fadeTo("fast", 1.0);
			});
	
		<?php } 
	}

	// Hover animations for Single Pages and Large Image Shortcodes
	if ( is_single() ) { ?>

		// Hover animations for Single Pages
		jQuery(".single .entry-image-container").hover(function(){
			jQuery(this).children(".photo-credit, .entry-caption").stop(true).fadeTo("fast", 1.0);
		}, function(){
			jQuery(this).children(".photo-credit, .entry-caption").stop(true).fadeTo("fast", 0);
		});
		
		// Hover animations for Large Image Shortcodes
		jQuery("#content .entry-content .large-image").hover(function(){
			jQuery(this).children("figcaption").stop(true).fadeTo("fast", 1.0);
		}, function(){
			jQuery(this).children("figcaption").stop(true).fadeTo("fast", 0);
		});

	<?php }
	
	// Apply fancybox to multiple items when the option is turned on	
	if (is_single() && ( $fancybox == TRUE ) ) { ?>

		jQuery(".gallery a").fancybox({
			'padding'		:	0, 
			'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600,
			'speedOut'		:	200,
			'titlePosition'	:	'over',
			'overlayShow'	:	true,
			'overlayOpacity':	0.95,
			'overlayColor'	:	'#<?php echo $photo_color; ?>',
			'titleFormat'	: 	formatTitle,
			'onComplete'	:	function() {
				jQuery("#fancybox-close").hide();
				jQuery("#fancybox-title").hide();
				jQuery("#fancybox-wrap").hover(function() {
					jQuery("#fancybox-close").stop(true).fadeTo("fast", 1.0);
					jQuery("#fancybox-title").stop(true).fadeTo("fast", 1.0);
				}, function() {
					jQuery("#fancybox-close").stop(true).fadeTo("fast", 0);
					jQuery("#fancybox-title").stop(true).fadeTo("fast", 0);
				});
			}
		});
		
		function formatTitle(title, currentArray, currentIndex, currentOpts) {
	    	return '<div class="gallery-image-title">' + (title && title.length ? '<strong>' + title + '</strong>' : '' ) + '<span class="image-count">Image ' + (currentIndex + 1) + ' of ' + currentArray.length + '</span></div>';
		}

	<?php } ?>

});
	
jQuery(window).load(function(){
	
<?php

	// Add Cycle Slider when the option is turned on
	// - Cycle Plugin: http://malsup.com/jquery/cycle/
	if ( is_home() && ( $sliding_sticky_area == TRUE ) ) {

		if ( $slider_nav == 'prevnext' ) { ?>

			// Set count function
			onAfter = function(curr,next,opts) {
				var caption = (opts.currSlide + 1) ;
				jQuery('#counter').html(caption +" / "+opts.slideCount);
			}
		
			jQuery(function() {
				// Fade in the first slide
				jQuery('.cycle ').before('<div id="nav"><a href="#" id="previous">&lang; Prev</a><span id="counter">0 / 0</span><a href="#" id="next">Next &rang;</a></div>').cycle({ 
					fx: 'scrollHorz', 
					easing: 'easeInOutQuint',
					timeout: 4000, 
					delay: 0,
					speed: 800,
					next:  '#next',
					prev:  '#previous',
					pause: 1,
					sync: 1,
					fit: 0,
					slideExpr: '.post',
					before: function(){ 
						var $sh = jQuery(this).height();
						var delay = 400;
						if($sh > 0) jQuery(this).parent().animate({ height: $sh }, delay);
					},
					after: function(curr,next,opts) {
						onAfter(curr,next,opts);
					},
					pauseOnPagerHover: true
			    });
			});

		<?php } else { ?>

			jQuery(function() { 
				// Fade in the first slide
				jQuery('.cycle ').before('<div id="nav"></div>').cycle({ 
					fx: 'scrollHorz',
					easing: 'easeInOutQuint',
					timeout: 4000, 
					delay: 0,
					speed: 800,
					pause: 1,
					sync: 1,
					fit: 0,
					slideExpr: '.post',
					before: function(){ 
						var $sh = jQuery(this).height();
						var delay = 400;
						if ($sh > 0) jQuery(this).parent().animate({ height: $sh }, delay);
					},
					pager:  '#nav',
					pauseOnPagerHover: true
				});
			});

		<?php } ?>

			// Hover animations for Slider Controls
			jQuery(".entry-gallery-container").hover(function(){
				jQuery(this).find("#nav").stop(true).fadeTo("fast", 0.85);
			}, function(){
				jQuery(this).find("#nav").stop(true).fadeTo("fast", 0);
			});
		

	<?php }
	
	// Add Cycle Slider to Single Posts
	// - Cycle Slider Plugin: http://malsup.com/jquery/cycle/
	if ( is_single() && ( get_post_meta($post->ID, 'show_gallery', true) ) ) { 

		if ( $slider_nav == 'prevnext' ) { ?>

			// Set count function
			onAfter = function(curr,next,opts) {
				var caption = (opts.currSlide + 1) ;
				jQuery('#counter').html(caption +" / "+opts.slideCount);
			}
		
			jQuery(function() {
				// Fade in the first slide
				jQuery('.cycle img:first').fadeIn(1000, function() {
		    		jQuery('.cycle ').before('<div id="nav"><a href="#" id="previous">&lang; Prev</a><span id="counter">0 / 0</span><a href="#" id="next">Next &rang;</a></div>').cycle({ 
						fx: 'scrollHorz', 
						easing: 'easeInOutQuint',
						timeout: 5000, 
						delay: 0,
						speed: 800,
						next:  '#next',
						prev:  '#previous',
						pause: 1,
						sync: 1,
						slideExpr: '.entry-image',
					<?php if ($single_image_display == 'fixed-post-thumbnail') { ?>
						fit: 1,
						height: 532,
					<?php } else { ?>
						fit: 0,
					<?php } ?>
						before: function(){ 
							var sh = jQuery(this).height();
							var delay = 400;
							if( sh > 0 ) jQuery(this).parents('.cycle').animate({ height: sh }, delay);
						},
						after: function(curr,next,opts) {
							onAfter(curr,next,opts);
						},
						pauseOnPagerHover: true
					});
			    });
			});

		<?php } else { ?>

			jQuery(function() {
				jQuery('.cycle img:first').fadeIn(1000, function() {
		    		jQuery('.cycle').before('<div id="nav"></div>').cycle({ 
						fx: 'scrollHorz', 
						easing: 'easeInOutQuint',
						timeout: 5000, 
						delay: 0,
						speed: 800,
						pause: 1,
						sync: 1,
						slideExpr: '.entry-image',
					<?php if ($single_image_display == 'fixed-post-thumbnail') { ?>
						fit: 1,
						height: 532,
					<?php } else { ?>
						fit: 0,
					<?php } ?>
						before: function(){ 
							var sh = jQuery(this).height();
							var delay = 400;
							if( sh > 0 ) jQuery(this).parents('.cycle').animate({ height: sh }, delay);
						},
						pager: '#nav',
						pauseOnPagerHover: true
				    });
			    });
			});

		<?php } ?>

		// Hover animations for Slider Controls
		jQuery(".entry-gallery-container").hover(function(){
			jQuery(this).find("#nav").stop(true).fadeTo("fast", 0.75);
		}, function(){
			jQuery(this).find("#nav").stop(true).fadeTo("fast", 0);
		});
		
		// Check to see if the top of the slider is visible
		function isScrolledIntoView(elem) {
			var docViewTop = jQuery(window).scrollTop();
			var docViewBottom = docViewTop + jQuery(window).height();
			
			var elemTop = jQuery(elem).offset().top;
			var elemBottom = elemTop + jQuery(elem).height();
			
			return (elemTop <= docViewTop);
		}

		// Stop the slider if its out of view >
		var myelement = jQuery('.cycle');
		var mymessage = jQuery('#mymessage');
		jQuery(window).scroll(function() {
			if(isScrolledIntoView(myelement)) {
				jQuery('.cycle').cycle('pause');
			} else {
				jQuery('.cycle').cycle('resume');
			}
		});

<?php } ?>

});
