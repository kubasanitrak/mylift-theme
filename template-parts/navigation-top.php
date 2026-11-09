<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage mylift-theme
 * @since 1.0
 * * @version 1.0
 */

?>


<!-- <input type="checkbox" id="menuBtnID" class="desktop-hide nav-switch" checked> -->
<input type="checkbox" id="menuBtnID" class="desktop-hide nav-switch">
<label for="menuBtnID" class="hamburger hamburger--htx desktop-hide">
	<span>menu</span>
</label>
<div class="menu">
	<?php
	/*/
	wp_nav_menu( array(
		'theme_location' => 'main-menu',
		'container' => '',
		'menu_class' => 'main-nav-list nav-list list-none accord',
	 ) );
	/*/
	echo get_dynamic_scroll_nav();
	//*/
	wp_nav_menu( array(
		'theme_location' => 'lang-menu',
		'container' => '',
		'menu_class' => 'nav-list list-none lang-menu',
	) );
?>
</div>