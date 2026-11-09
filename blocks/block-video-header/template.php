<?php
/**
 * Block Name: BLOCK-lesson-video
 *
 * This is the template that displays the featured news block.
 * @param   array $block The block settings and attributes.
 */

	
// Create class attribute allowing for custom "className" values.

	$VIDEO_LANDSCAPE = str_replace(".mp4", "", get_field( 'video_land_url' ));
	$VIDEO_PORTRAIT = str_replace(".mp4", "", get_field( 'video_port_url' ));

	$POSTER_URL = get_field( 'video_poster' );
?>

	<div class="section section-full-width section--hero fixed toned">
		<video lazyload playsinline autoplay muted loop poster="<?php echo get_field('$POSTER_URL'); ?>" id="bgvidID" class="playing web-video lazyload autoplay-anim inline-video" data-videosrc_portrait="<?php echo $VIDEO_PORTRAIT; ?>" data-videosrc="<?php echo $VIDEO_LANDSCAPE; ?>"> </video>
	</div>
	<div class="section section-full-width section--hero sticky" data-theme="transparent">
		<h1 class="caps site-title">vertical</h1>
		<h1 class="caps site-title">movement<span class="doubled-line">movement</span></h1>
		<h1 class="caps site-title">from idea</h1>
		<h1 class="caps site-title">to reality</h1>
		<h3 class="caps site-subtitle strong">all in one place</h3>
	</div>