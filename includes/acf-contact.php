<?php
/**
 * Contact ACF: shared option fields + block label fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Decode ACF/typography entities (&nbsp;) to plain text.
 *
 * @param string $value Raw field value.
 * @return string
 */
function mylift_contact_plain_text( $value ) {
    $value = html_entity_decode( (string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
    return str_replace( "\xC2\xA0", ' ', $value );
}

/**
 * Build tel: href from a displayed phone number (+420 220 570 696 → 00420220570696).
 *
 * @param string $phone Display phone number.
 * @return string
 */
function mylift_format_tel_href( $phone ) {
    $phone = mylift_contact_plain_text( $phone );
    $phone = preg_replace( '/[^\d+]/', '', $phone );
    if ( strpos( $phone, '+' ) === 0 ) {
        $phone = '00' . substr( $phone, 1 );
    }
    return $phone;
}

add_action( 'acf/init', 'mylift_register_contact_acf' );
function mylift_register_contact_acf() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key'                   => 'group_mlcontactopt',
            'title'                 => 'Kontaktní údaje',
            'fields'                => array(
                array(
                    'key'   => 'field_mlc_msg',
                    'label' => 'Sdílené kontaktní údaje',
                    'name'  => '',
                    'type'  => 'message',
                    'message' => 'Tyto hodnoty platí pro všechny jazykové verze. Překlady popisků (Tel, Workshop, právní text) se editují v bloku Contact na každé stránce.',
                ),
                array(
                    'key'           => 'field_mlc_company',
                    'label'         => 'Název společnosti',
                    'name'          => 'contact_company_name',
                    'type'          => 'text',
                    'default_value' => 'MYLIFT s.r.o.',
                ),
                array(
                    'key'           => 'field_mlc_phone',
                    'label'         => 'Telefon',
                    'name'          => 'contact_phone',
                    'type'          => 'text',
                    'default_value' => '+420 220 570 696',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlc_mobile',
                    'label'         => 'Mobil',
                    'name'          => 'contact_mobile',
                    'type'          => 'text',
                    'default_value' => '+420 724 536 723',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlc_email',
                    'label'         => 'E-mail',
                    'name'          => 'contact_email',
                    'type'          => 'email',
                    'default_value' => 'info@mylift.cz',
                ),
                array(
                    'key'           => 'field_mlc_office1',
                    'label'         => 'Sídlo — ulice',
                    'name'          => 'contact_office_street',
                    'type'          => 'text',
                    'default_value' => 'Fr. Křížka 1105/4',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlc_office2',
                    'label'         => 'Sídlo — PSČ a město',
                    'name'          => 'contact_office_city',
                    'type'          => 'text',
                    'default_value' => '170 00  Praha 7',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlc_workshop1',
                    'label'         => 'Dílna / sklad — ulice',
                    'name'          => 'contact_workshop_street',
                    'type'          => 'text',
                    'default_value' => 'Sanderova 26',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlc_workshop2',
                    'label'         => 'Dílna / sklad — PSČ a město',
                    'name'          => 'contact_workshop_city',
                    'type'          => 'text',
                    'default_value' => '170 00  Praha 7',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlc_ico',
                    'label'         => 'IČO',
                    'name'          => 'contact_ico',
                    'type'          => 'text',
                    'default_value' => '27431070',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlc_dic',
                    'label'         => 'DIČ',
                    'name'          => 'contact_dic',
                    'type'          => 'text',
                    'default_value' => 'CZ27431070',
                    'wrapper'       => array( 'width' => '50' ),
                ),
            ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'options_page',
                        'operator' => '==',
                        'value'    => 'mylift-settings',
                    ),
                ),
            ),
            'menu_order'            => 1,
            'position'              => 'acf_after_title',
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
        )
    );

    acf_add_local_field_group(
        array(
            'key'                   => 'group_mlcontactblk',
            'title'                 => 'BLOCK contact labels',
            'fields'                => array(
                array(
                    'key'     => 'field_mlb_msg',
                    'label'   => 'Popisky této jazykové verze',
                    'name'    => '',
                    'type'    => 'message',
                    'message' => 'Čísla, adresy a IČO/DIČ se berou z MYLIFT → settings. Tady měň jen texty viditelné v tomto jazyce.',
                ),
                array(
                    'key'           => 'field_mlb_phone',
                    'label'         => 'Popisek telefonu',
                    'name'          => 'label_phone',
                    'type'          => 'text',
                    'default_value' => 'Tel',
                    'wrapper'       => array( 'width' => '33' ),
                ),
                array(
                    'key'           => 'field_mlb_mobile',
                    'label'         => 'Popisek mobilu',
                    'name'          => 'label_mobile',
                    'type'          => 'text',
                    'default_value' => 'Mob',
                    'wrapper'       => array( 'width' => '33' ),
                ),
                array(
                    'key'           => 'field_mlb_email',
                    'label'         => 'Popisek e-mailu',
                    'name'          => 'label_email',
                    'type'          => 'text',
                    'default_value' => 'Mail',
                    'wrapper'       => array( 'width' => '33' ),
                ),
                array(
                    'key'           => 'field_mlb_workshop',
                    'label'         => 'Nadpis dílny / skladu',
                    'name'          => 'label_workshop',
                    'type'          => 'textarea',
                    'rows'          => 2,
                    'new_lines'     => '',
                    'default_value' => "Workshop\n& warehouse",
                    'instructions'  => 'Zalomení řádku se zobrazí jako v původním „Workshop / & warehouse“.',
                ),
                array(
                    'key'           => 'field_mlb_ico',
                    'label'         => 'Popisek IČO',
                    'name'          => 'label_ico',
                    'type'          => 'text',
                    'default_value' => 'IČO',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'           => 'field_mlb_dic',
                    'label'         => 'Popisek DIČ',
                    'name'          => 'label_dic',
                    'type'          => 'text',
                    'default_value' => 'DIČ',
                    'wrapper'       => array( 'width' => '50' ),
                ),
                array(
                    'key'   => 'field_mlb_legal1',
                    'label' => 'Právní řádek 1',
                    'name'  => 'legal_line_1',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_mlb_legal2',
                    'label' => 'Právní řádek 2',
                    'name'  => 'legal_line_2',
                    'type'  => 'text',
                ),
                array(
                    'key'          => 'field_mlb_copy',
                    'label'        => 'Copyright',
                    'name'         => 'copyright_text',
                    'type'         => 'text',
                    'instructions' => 'Prázdné = automaticky © aktuální rok MYLIFT.',
                    'placeholder'  => '© 2026 MYLIFT',
                ),
            ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => 'acf/contact',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
        )
    );
}
