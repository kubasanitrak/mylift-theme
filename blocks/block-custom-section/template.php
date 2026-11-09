<?php
/**
 * Block Name: BLOCK-custom-section
 * Section Content Block Template.
 * 
 * @param   array $block The block settings and attributes.
 */

    // Create class attribute allowing for custom "className" values.
    
    $ADD_TO_SCROLL_MENU = get_field('add_link_to_main_nav');

    // $IS_COLUMN_CONTAINER = get_field('is_column_container');
    $IS_FULL_W = get_field('is_full_width');
    $IS_COLS = get_field('is_cols');
    $HAS_SPLIT = get_field('is_split_screen');
    $ANIMATE_ON_SCROLL = get_field('animate_on_scroll');
    $BGR_COLOR = get_field('section_bgr');
    $MENU_TEXT = get_field('menu_text');
    
    // $SHOW_ARR_DOWN = get_field('display_scroll_down_arr');

    $CLS_W = '';
    if(!$IS_COLS) :
        $CLS_W = 'section';
    else:
        $CLS_W = 'even-columns';
    endif;

    if($IS_FULL_W && !$IS_COLS) :
        $CLS_W .= ' section-full-width';
    endif;

    // scroll-trigger--news, scroll-trigger--morph, scroll-trigger--contact, scroll-trigger--faq
    if($ANIMATE_ON_SCROLL) :
        $CLS_W .= ' scroll-trigger';
        $CLS_W .= ' scroll-trigger--';
        $CLS_W .= get_field('animation_type');
    endif;

    if($HAS_SPLIT) :
        $CLS_W .= ' section-split-screen';
    endif;
/*
<div class="even-columns scroll-trigger scroll-trigger--contact">
<div class="even-columns--item">
<div class="section-contact--row section-contact--row_legal scroll-trigger scroll-trigger--contact">

repeater s poli s podmíněnou logikou:
- faq-item
? is sticky headline ?
    ano => counter (pro --grid-row-$i CSS variable)
        => headline field
        => subheadline field
    ne => simple textfield (bez wysiwyg)



<div class="faq-item faq-item--headline scroll-trigger scroll-trigger--faq" style="--grid-row: 1">
    <h1 class="faq-item--headline_title"></h1>
    <h3 class="faq-item--headline_caption caps strong"></h3>
</div>

<div class="faq-item faq-item--claim" >
    <h3 class="faq-item--caption"></h3>   
</div>

<div class="faq-item faq-item--headline scroll-trigger scroll-trigger--faq" style="--grid-row: 3">
    <h1 class="faq-item--headline_title"></h1>
    <h3 class="faq-item--headline_caption caps strong"></h3>
</div>

<div class="faq-item faq-item--headline scroll-trigger scroll-trigger--faq" style="--grid-row: 5">
    <h1 class="faq-item--headline_title"></h1>
    <h3 class="faq-item--headline_caption caps strong"></h3>
</div>
*/
    // $CLS_W = '';
    
    // if($BGR_SHAPE) :
    //     $CLS_W .= ' scroll-trigger--shape bgr-shape bgr-shape--';
    //     $CLS_W .= strval($BGR_SHAPE);
    // endif;
    
    // if($BGR_SHAPE_COLOR) :
    //     $CLS_W .= ' bgr-shape-color--';
    //     $CLS_W .= strval($BGR_SHAPE_COLOR);
    // endif;

    // PADDED OR FULL WIDTH
    // $CLS_W .= !$ADD_TO_SCROLL_MENU ? ' section-padded' : ' section-full-width' ;
    // Create class attribute allowing for custom "className" values.
    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;

    $DATA_THEME = 'default';

    if($BGR_COLOR) :
        $DATA_THEME = $BGR_COLOR;
    endif;

    // Support custom id values.
    //*/
    $block_id = $ADD_TO_SCROLL_MENU ? esc_attr( get_field( 'id_to_scroll' ) ) : '';
    /*/
    $block_id = '';
    if ( ! empty( $block['anchor'] ) ) :
        // $block_id = esc_attr( $block['anchor'] );
        $block_id = esc_attr( get_field( 'id' ) );
    endif;
    //*/

?>
    


<?php if ( ! $is_preview ) { ?>

<div data-theme="<?php echo $DATA_THEME ?>"
    <?php
    echo wp_kses_data(
        get_block_wrapper_attributes(
            array(
                'id'    => $block_id,
                'class' => esc_attr( $classes ),
            )
        )
    );
    ?>
>
<?php } ?>

    
        
        <InnerBlocks/>

    
<!-- TODO ALLOWED INNER BLOCKS IF IS_COLUMNS -->
   

<?php if ( ! $is_preview ) { ?>
    
    </div>
<?php } ?>
    
<?php 
/*
transparent : Transparent
dark : Dark
default : Light

news : News
morph : Shape Bgr Morph
contact : Contact Rows
faq : FAQ
*/
 ?>