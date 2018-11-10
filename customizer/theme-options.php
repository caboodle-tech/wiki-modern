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

/** SECTION: Theme Options. */
$wp_customize->add_section(
    'wm_theme_options',
    array(
        'priority'      => 40,
        'title' =>  'Theme Options'
    )
);

/** Toggle Logo. */
$theme_options[] = array(
    'class'         => 'WM_Customizer_Toggle_Control',
    'default'       => false,
    'description'   => __('If there is a site logo hide it from showing. NOTE: You could also remove the logo added under Site Identity.'),
    'label'         => __('Hide Logo'),
    'sanitize'      => 'wm_sanitize_toggle',
    'section'       => 'wm_theme_options',
    'slug'          => 'wm_toggle_logo'
);

/** Toggle Site Title. */
$theme_options[] = array(
    'class'         => 'WM_Customizer_Toggle_Control',
    'default'       => true,
    'description'   => __('When the Site Title is not empty display it.'),
    'label'         => __('Show Site Title'),
    'sanitize'      => 'wm_sanitize_toggle',
    'section'       => 'wm_theme_options',
    'slug'          => 'wm_toggle_site_title'
);

/** Toggle Site Tagline. */
$theme_options[] = array(
    'class'         => 'WM_Customizer_Toggle_Control',
    'default'       => true,
    'description'   => __('When the Site Tagline is not empty display it.'),
    'label'         => __('Show Site Tagline'),
    'sanitize'      => 'wm_sanitize_toggle',
    'section'       => 'wm_theme_options',
    'slug'          => 'wm_toggle_tagline'
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
            'transport'         =>'postMessage',
            'type'              => 'theme_mod'
        )
    );

    /** Controls. */
    $wp_customize->add_control(
        new $option['class'](
            $wp_customize,
            $option['slug'],
            array(
                'description'   => $option['description'],
                'label'         => $option['label'],
                'section'       => $option['section'],
                'settings'      => $option['slug']
            )
        )
    );

}
