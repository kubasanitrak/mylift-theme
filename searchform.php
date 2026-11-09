<?php ?>
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="wp-block-search__inside-wrapper">
		<label>
			<span class="screen-reader-text"><?php echo _x( 'search', 'label' ) ?></span>
			<input type="search" id="search-fieldID" class="search-field wp-block-search__input" placeholder="<?php echo esc_attr_x( 'search', 'placeholder' ) ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'search', 'label' ) ?>" />
		</label>
	</div>
	<input id="search-btnID" type="submit" class="search-submit visually-hidden" value="<?php echo _x( 'ok', 'submit button' ) ?>" />
</form>
