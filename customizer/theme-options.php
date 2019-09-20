<?php
/**
* Adds the Theme Options section in the Customizer.
*
* @package      Wiki Modern
* @author       Christopher Keers <source@caboodle.tech>
* @copyright    .
* @license      .
* @uses         WM_Customizer_Toggle_Control to add custom toggle controls to the WP Customizer.
*/

/** PANEL: Theme Colors. */
$wp_customize->add_panel(
    'wm_theme_options',
    array(
        'description'   => __('Here you can change various options used in the Wiki Modern theme.'),
        'priority'      => 50,
        'title'         =>  __('Theme Options')
    )
);

/** SECTION: Sidebar */
$wp_customize->add_section(
    'wm_theme_options_sidebar',
    array(
        'panel' => 'wm_theme_options',
        'title' =>  'Left Sidebar'
    )
);

/** Toggle Logo. */
$theme_options[] = array(
    'class'         => 'WM_Customizer_Toggle_Control',
    'default'       => false,
    'description'   => __('If there is a site logo hide it from showing.'),
    'label'         => __('Hide Logo'),
    'sanitize'      => 'wm_sanitize_toggle',
    'section'       => 'wm_theme_options_sidebar',
    'slug'          => 'wm_toggle_logo'
);

/** Toggle Site Title. */
$theme_options[] = array(
    'class'         => 'WM_Customizer_Toggle_Control',
    'default'       => true,
    'description'   => __('When the Site Title is not empty display it.'),
    'label'         => __('Show Site Title'),
    'sanitize'      => 'wm_sanitize_toggle',
    'section'       => 'wm_theme_options_sidebar',
    'slug'          => 'wm_toggle_site_title'
);

// Align Site Title
$theme_options[] = array(
    'class'         => 'WM_Customizer_Text_Radio_Control',
    'default'       => 'centered',
    'description'   => __('How would you like the site title aligned?'),
    'label'         => __('Site Title Alignment'),
    'choices'       => array(
        'left'          => __( 'Left' ),
        'centered'      => __( 'Centered' ),
        'right'         => __( 'Right' )
    ),
    'sanitize'      => 'wm_text_sanitization',
    'section'       => 'wm_theme_options_sidebar',
    'slug'          => 'wm_site_title_alignment'
);

/** Toggle Site Tagline. */
$theme_options[] = array(
    'class'         => 'WM_Customizer_Toggle_Control',
    'default'       => true,
    'description'   => __('When the Site Tagline is not empty display it.'),
    'label'         => __('Show Site Tagline'),
    'sanitize'      => 'wm_sanitize_toggle',
    'section'       => 'wm_theme_options_sidebar',
    'slug'          => 'wm_toggle_tagline'
);

// Align Site Title
$theme_options[] = array(
    'class'         => 'WM_Customizer_Text_Radio_Control',
    'default'       => 'centered',
    'description'   => __('How would you like the site tagline aligned?'),
    'label'         => __('Site Tagline Alignment'),
    'choices'       => array(
        'left'          => __( 'Left' ),
        'centered'      => __( 'Centered' ),
        'right'         => __( 'Right' )
    ),
    'sanitize'      => 'wm_text_sanitization',
    'section'       => 'wm_theme_options_sidebar',
    'slug'          => 'wm_site_tagline_alignment'
);

/** SECTION: Footer */
$wp_customize->add_section(
    'wm_theme_options_footer',
    array(
        'panel' => 'wm_theme_options',
        'title' =>  'Footer'
    )
);

// How many columns to show in the footer?
$theme_options[] = array(
    'default'       => '0',
    'description'   => __('How many columns of content do you want in the sites footer?'),
    'label'         => __('Footer Columns'),
    'choices'       => array(
        '0'         => __( 'None' ),
        '1'         => __( '1' ),
        '2'         => __( '2' ),
        '3'         => __( '3' ),
        '4'         => __( '4' )
    ),
    'sanitize'      => 'wm_select_sanitization',
    'section'       => 'wm_theme_options_footer',
    'slug'          => 'wm_footer_column_count',
    'type'          => 'select'
);

// Column 1 alignment
$theme_options[] = array(
    'class'         => 'WM_Customizer_Text_Radio_Control',
    'default'       => 'left',
    'description'   => __('How would you like column 1 aligned?'),
    'label'         => __('Column 1 Alignment'),
    'choices'       => array(
        'left'          => __( 'Left' ),
        'centered'      => __( 'Centered' ),
        'right'         => __( 'Right' )
    ),
    'sanitize'      => 'wm_select_sanitization',
    'section'       => 'wm_theme_options_footer',
    'slug'          => 'wm_col1_alignment'
);

// Column 2 alignment
$theme_options[] = array(
    'class'         => 'WM_Customizer_Text_Radio_Control',
    'default'       => 'left',
    'description'   => __('How would you like column 2 aligned?'),
    'label'         => __('Column 2 Alignment'),
    'choices'       => array(
        'left'          => __( 'Left' ),
        'centered'      => __( 'Centered' ),
        'right'         => __( 'Right' )
    ),
    'sanitize'      => 'wm_select_sanitization',
    'section'       => 'wm_theme_options_footer',
    'slug'          => 'wm_col2_alignment'
);

// Column 3 alignment
$theme_options[] = array(
    'class'         => 'WM_Customizer_Text_Radio_Control',
    'default'       => 'left',
    'description'   => __('How would you like column 3 aligned?'),
    'label'         => __('Column 3 Alignment'),
    'choices'       => array(
        'left'          => __( 'Left' ),
        'centered'      => __( 'Centered' ),
        'right'         => __( 'Right' )
    ),
    'sanitize'      => 'wm_select_sanitization',
    'section'       => 'wm_theme_options_footer',
    'slug'          => 'wm_col3_alignment'
);

// Column 4 alignment
$theme_options[] = array(
    'class'         => 'WM_Customizer_Text_Radio_Control',
    'default'       => 'left',
    'description'   => __('How would you like column 4 aligned?'),
    'label'         => __('Column 4 Alignment'),
    'choices'       => array(
        'left'          => __( 'Left' ),
        'centered'      => __( 'Centered' ),
        'right'         => __( 'Right' )
    ),
    'sanitize'      => 'wm_select_sanitization',
    'section'       => 'wm_theme_options_footer',
    'slug'          => 'wm_col4_alignment'
);

/** Add the settings and controls for each option Wiki Modern has to the Customizer. */
$slugCounter = 0;
foreach( $theme_options as $option ) {

    /** Make sure everything has a unique slug. */
    if( empty( $option['slug'] ) ){
        $option['slug'] = 'wm-theme-options-' . $slugCounter;
        $slugCounter++;
    }

    /** Settings. */
    $wp_customize->add_setting(
        $option['slug'],
        array(
            'capability'        => 'edit_theme_options',
            'default'           => $option['default'],
            'sanitize_callback' => $option['sanitize'],
            'transport'         => 'postMessage'
        )
    );

    /** Controls. */
    if( $option['class'] ){
        if( $option['choices'] ){
            $wp_customize->add_control(
                new $option['class'](
                    $wp_customize,
                    $option['slug'],
                    array(
                        'choices'       => $option['choices'],
                        'description'   => $option['description'],
                        'label'         => $option['label'],
                        'section'       => $option['section'],
                        'settings'      => $option['slug'],
                        'type'          => $option['type'] ?: 'theme_mod'
                    )
                )
            );
        } else {
            $wp_customize->add_control(
                new $option['class'](
                    $wp_customize,
                    $option['slug'],
                    array(
                        'description'   => $option['description'],
                        'label'         => $option['label'],
                        'section'       => $option['section'],
                        'settings'      => $option['slug'],
                        'type'          => $option['type'] ?: 'theme_mod'
                    )
                )
            );
        }
    } else {
        $wp_customize->add_control(
            $option['slug'],
            array(
                'choices'       => $option['choices'],
                'description'   => $option['description'],
                'label'         => $option['label'],
                'section'       => $option['section'],
                'settings'      => $option['slug'],
                'type'          => $option['type'] ?: 'theme_mod'
            )
        );
    }
}
