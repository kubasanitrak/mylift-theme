<?php
/**
 * Block Name: BLOCK-gallery
 *
 * This is the template that displays the featured news block.
 * @param   array $block The block settings and attributes.
 */
?>
<?php
    $CLS_W = 'gallery-grid--container ';

    $HAS_LIGHTBOX = get_field('has_lightbox');
        
    // Create class attribute allowing for custom "className" values.
    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;

    // Support custom id values.
    $block_id = '';
    if ( ! empty( $block['anchor'] ) ) :
        $block_id = esc_attr( $block['anchor'] );
    endif;
?>

<div
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

    <div class="gallery-grid">
        <!-- INNER BLOCKS RESTRICTED TO GALLERY COLS ONLY -->
        <?php $allowed_blocks = [ 'acf/gallery-column' ]; ?>
        <InnerBlocks
            allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
        />
    
    </div>
</div><!-- END CAROUSEL CONTAINER -->