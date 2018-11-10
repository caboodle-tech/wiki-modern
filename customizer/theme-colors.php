<?php
/**
* Adds the Theme Colors panel and sections in the Customizer.
*
* @package      Wiki Modern
* @author       Christopher Keers <source@caboodle.tech>
* @copyright    .
* @license      .
* @uses         WP_Customize_Color_Control to add color controls to the Customizer.
*/

/*
$ctime = filemtime( get_template_directory() . '/customizer/js/theme-colors.js' );
wp_enqueue_script( 'wm-theme-colors-js', get_template_directory_uri() . '/customizer/js/theme-colors.js', array( 'jquery','customize-preview' ), $ctime, true);
*/

/** Load Wiki Modern's default colors. */
$colors = json_decode( file_get_contents( get_template_directory() . '/etc/theme-colors.json'), true );

/** PANEL: Theme Colors. */
$wp_customize->add_panel(
    'wm_theme_colors',
    array(
        'description'   => __('Here you can change the various colors used in the Wiki Modern theme.'),
        'priority'      => 50,
        'title'         =>  __('Theme Colors')
    )
);

/** SECTION: Sidebar and Footer. */
$wp_customize->add_section(
    'wm_sidebar_and_footer',
    array(
        'panel' => 'wm_theme_colors',
        'title' => 'Sidebars and Footer'
    )
);

/** Sidebar and Footer Backgound Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_saf_bg_color'],
    'description'   => __('Background color for the sidebars, footer, and buttons.'),
    'label'         => 'Background Color',
    'section'       => 'wm_sidebar_and_footer',
    'slug'          => 'wm_saf_bg_color',
);

/** Sidebar and Footer Text Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_saf_color'],
    'description'   => __('Font color for the sidebars and footer.'),
    'label'         => 'Text Color',
    'section'       => 'wm_sidebar_and_footer',
    'slug'          => 'wm_saf_color'
);

/** Sidebar and Footer Link Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_saf_a'],
    'description'   => __('Link color for the sidebars and footer.'),
    'label'         => 'Link Color',
    'section'       => 'wm_sidebar_and_footer',
    'slug'          => 'wm_saf_a',
);

/** Sidebar and Footer Active Link Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_saf_a_active'],
    'description'   => __('Background color of the active link (list item) in the navigation menu.'),
    'label'         => 'Active Link Background Color',
    'section'       => 'wm_sidebar_and_footer',
    'slug'          => 'wm_saf_a_active'
);

/** Sidebar and Footer Hover Link Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_saf_a_hover'],
    'description'   => __('Background color of links (list items) in the navigation menu when you hover over them.'),
    'label'         => 'Active Link Hover Background Color',
    'section'       => 'wm_sidebar_and_footer',
    'slug'          => 'wm_saf_a_hover'
);

/** Sidebar and Footer Active Link Pointer. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_saf_a_pointer'],
    'description'   => __('This is the arrow that points at the active link in the sidebar navigation menu.'),
    'label'         => 'Active Link Pointer Color',
    'section'       => 'wm_sidebar_and_footer',
    'slug'          => 'wm_saf_a_pointer'
);

/** SECTION: PAGE CONTENT. */
$wp_customize->add_section( 'wm_page_content' , array(
    'panel' => 'wm_theme_colors',
    'title' =>  'Page Content'
) );

/** Page Content Background Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_pg_bg_color'],
    'description'   => __('Background color for the page content.'),
    'label'         => 'Background Color',
    'section'       => 'wm_page_content',
    'slug'          => 'wm_pg_bg_color'
);

/** Page Content, Featured Image, Buttons, and Input Border Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_pg_border_color'],
    'description'   => __('Border color for the page content area, buttons, and inputs. This color will also be used for section separators in the sidebars.'),
    'label'         => 'Border Color',
    'section'       => 'wm_page_content',
    'slug'          => 'wm_pg_border_color'
);

/** Page Content Text Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_pg_color'],
    'description'   => __('Text color for the page content.'),
    'label'         => 'Text Color',
    'section'       => 'wm_page_content',
    'slug'          => 'wm_pg_color'
);

/** Page Content Link Color. */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_pg_a'],
    'description'   => __('Link color for the page content.'),
    'label'         => 'Link Color',
    'section'       => 'wm_page_content',
    'slug'          => 'wm_pg_a'
);

/** Page Content Icon Color. (buttons) */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_pg_btn'],
    'description'   => __('Icon color for buttons in the page content area.'),
    'label'         => 'Button Icon Color',
    'section'       => 'wm_page_content',
    'slug'          => 'wm_pg_btn'
);

/** Page Content Icon Background Color. (buttons) */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_pg_btn_bg_color'],
    'description'   => __('Background color for buttons in the page content area.'),
    'label'         => 'Button Background Color',
    'section'       => 'wm_page_content',
    'slug'          => 'wm_pg_btn_bg_color'
);

/** Page Content Hover Border Color. (buttons, inputs) */
$theme_colors[] = array(
    'class'         => 'WP_Customize_Color_Control',
    'default'       => $colors['wm_pg_border_color_hover'],
    'description'   => __('Color to switch borders to when a button is hovered over or when an input receives focus.'),
    'label'         => 'Hover Border Color',
    'section'       => 'wm_page_content',
    'slug'          => 'wm_pg_border_color_hover'
);

/** Add the settings and controls for each color option Wiki Modern has. */
foreach( $theme_colors as $color_option ) {

    /** Settings. */
    $wp_customize->add_setting(
        $color_option['slug'],
        array(
            'capability' => 'edit_theme_options',
            'default' => $color_option['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'=>'postMessage',
            'type' => 'theme_mod'
        )
    );

    /** Controls. */
    $wp_customize->add_control(
        new $color_option['class'](
            $wp_customize,
            $color_option['slug'],
            array(
                'description' => $color_option['description'],
                'label' => $color_option['label'],
                'section' => $color_option['section'],
                'settings' => $color_option['slug']
            )
        )
    );

}
