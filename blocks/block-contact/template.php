<?php
/**
 * Block Name: BLOCK-contact
 * Contact rows. Values from ACF options; labels from this block.
 *
 * @param array $block The block settings and attributes.
 */

if ( ! function_exists( 'get_field' ) ) {
    return;
}

$plain = function_exists( 'mylift_contact_plain_text' ) ? 'mylift_contact_plain_text' : function ( $value ) {
    return (string) $value;
};

$company    = $plain( get_field( 'contact_company_name', 'option' ) );
$phone      = $plain( get_field( 'contact_phone', 'option' ) );
$mobile     = $plain( get_field( 'contact_mobile', 'option' ) );
$email      = $plain( get_field( 'contact_email', 'option' ) );
$office_1   = $plain( get_field( 'contact_office_street', 'option' ) );
$office_2   = $plain( get_field( 'contact_office_city', 'option' ) );
$workshop_1 = $plain( get_field( 'contact_workshop_street', 'option' ) );
$workshop_2 = $plain( get_field( 'contact_workshop_city', 'option' ) );
$ico        = $plain( get_field( 'contact_ico', 'option' ) );
$dic        = $plain( get_field( 'contact_dic', 'option' ) );

$label_phone    = (string) get_field( 'label_phone' );
$label_mobile   = (string) get_field( 'label_mobile' );
$label_email    = (string) get_field( 'label_email' );
$label_workshop = (string) get_field( 'label_workshop' );
$label_ico      = (string) get_field( 'label_ico' );
$label_dic      = (string) get_field( 'label_dic' );
$legal_line_1   = (string) get_field( 'legal_line_1' );
$legal_line_2   = (string) get_field( 'legal_line_2' );
$copyright      = (string) get_field( 'copyright_text' );

if ( $copyright === '' ) {
    $copyright = '© ' . gmdate( 'Y' ) . ' MYLIFT';
}

$email_href    = $email !== '' ? 'mailto:' . $email : '';
$email_display = $email !== '' ? str_replace( '@', '(at)', $email ) : '';
$phone_href    = function_exists( 'mylift_format_tel_href' ) ? mylift_format_tel_href( $phone ) : $phone;
$mobile_href   = function_exists( 'mylift_format_tel_href' ) ? mylift_format_tel_href( $mobile ) : $mobile;

$workshop_heading = $label_workshop !== '' ? nl2br( esc_html( $label_workshop ), false ) : '';

$legal_ids = '';
if ( $ico !== '' || $dic !== '' ) {
    $parts = array();
    if ( $ico !== '' ) {
        $parts[] = trim( $label_ico . ': ' . $ico );
    }
    if ( $dic !== '' ) {
        $parts[] = trim( $label_dic . ': ' . $dic );
    }
    $legal_ids = implode( ', ', $parts );
}
$wrapper_attrs = '';
if ( function_exists( 'get_block_wrapper_attributes' ) ) {
    $wrapper_attrs = wp_kses_data(
        get_block_wrapper_attributes(
            array(
                'class' => 'section-contact-rows',
            )
        )
    );
} else {
    $wrapper_attrs = 'class="section-contact-rows"';
}
?>

<div <?php echo $wrapper_attrs; ?>>
<div class="even-columns scroll-trigger scroll-trigger--contact">
    <div class="even-columns--item">
        <h2 class="company-name highlight strong caps"><?php echo esc_html( $company ); ?></h2>
    </div>
    <div class="even-columns--item">
        <?php if ( $phone !== '' ) : ?>
            <p class="caps company-links highlight strong"><?php echo esc_html( $label_phone ); ?>:  <a class="strong" href="tel:<?php echo esc_attr( $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a></p>
        <?php endif; ?>
        <?php if ( $mobile !== '' ) : ?>
            <p class="caps company-links highlight strong"><?php echo esc_html( $label_mobile ); ?>: <a class="strong" href="tel:<?php echo esc_attr( $mobile_href ); ?>"><?php echo esc_html( $mobile ); ?></a></p>
        <?php endif; ?>
        <?php if ( $email !== '' ) : ?>
            <p class="caps company-links highlight strong"><?php echo esc_html( $label_email ); ?>: <a class="strong" href="<?php echo esc_url( $email_href ); ?>"><?php echo esc_html( $email_display ); ?></a></p>
        <?php endif; ?>
    </div>
</div>
<div class="even-columns scroll-trigger scroll-trigger--contact">
    <div class="even-columns--item">
        <h2 class="company-name strong caps"><?php echo esc_html( $company ); ?></h2>
    </div>
    <div class="even-columns--item">
        <?php if ( $office_1 !== '' ) : ?>
            <p class="caps company-links strong"><?php echo esc_html( $office_1 ); ?></p>
        <?php endif; ?>
        <?php if ( $office_2 !== '' ) : ?>
            <p class="caps company-links strong"><?php echo esc_html( $office_2 ); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="even-columns scroll-trigger scroll-trigger--contact">
    <div class="even-columns--item">
        <h2 class="company-name strong caps"><?php echo $workshop_heading; ?></h2>
    </div>
    <div class="even-columns--item">
        <?php if ( $workshop_1 !== '' ) : ?>
            <p class="caps company-links strong"><?php echo esc_html( $workshop_1 ); ?></p>
        <?php endif; ?>
        <?php if ( $workshop_2 !== '' ) : ?>
            <p class="caps company-links strong"><?php echo esc_html( $workshop_2 ); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="section-contact--row section-contact--row_legal scroll-trigger scroll-trigger--contact">
    <?php if ( $legal_ids !== '' ) : ?>
        <h4 class="caps strong company-legal"><?php echo esc_html( $legal_ids ); ?></h4>
    <?php endif; ?>
    <?php if ( $legal_line_1 !== '' ) : ?>
        <h4 class="caps strong company-legal"><?php echo esc_html( $legal_line_1 ); ?></h4>
    <?php endif; ?>
    <?php if ( $legal_line_2 !== '' ) : ?>
        <h4 class="caps strong company-legal"><?php echo esc_html( $legal_line_2 ); ?></h4>
    <?php endif; ?>
</div>
<p class="copyright highlight plain caps"><?php echo esc_html( $copyright ); ?></p>
</div>
