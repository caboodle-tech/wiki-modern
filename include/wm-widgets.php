<?php
register_sidebar(array(
    'name' => __('Left Sidebar'),
    'id' => 'left_sidebar_widget',
    'description' => 'Allows you to add widgets to the sites left sidebar under your sites navigation.',
    'class' => 'wm-test-class',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="wm-widget-title">',
    'after_title' => '</h2>',
    'section'       => 'wm_theme_options_sidebar'
));

register_sidebar(array(
    'name' => __('Right Sidebar'),
    'id' => 'right_sidebar_widget',
    'description' => 'Allows you to add widgets to the sites right sidebar under the blog posts information. Please keep in mind that the right sidebar is only visible on blog post pages.',
    'class' => 'wm-test-class',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="wm-widget-title">',
    'after_title' => '</h2>',
    'section'       => 'wm_theme_options_sidebar'
));

register_sidebar(array(
    'name' => __('Footer Column 1'),
    'id' => 'col1_footer_widget',
    'description' => 'Allows you to add widgets to the sites footer in the first column. Please keep in mind that you may choose how many footer columns that show under Theme Options > Footer.',
    'before_widget' => '<div class="wm-widget">',
    'after_widget' => '</div>',
    'before_title' => '<div class="wm-widget-title">',
    'after_title' => '</div>',
    'section'       => 'wm_theme_options_sidebar'
));

register_sidebar(array(
    'name' => __('Footer Column 2'),
    'id' => 'col2_footer_widget',
    'description' => 'Allows you to add widgets to the sites footer in the second column. Please keep in mind that you may choose how many footer columns that show under Theme Options > Footer.',
    'class' => 'wm-test-class',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="wm-widget-title">',
    'after_title' => '</h2>',
    'section'       => 'wm_theme_options_sidebar'
));

register_sidebar(array(
    'name' => __('Footer Column 3'),
    'id' => 'col3_footer_widget',
    'description' => 'Allows you to add widgets to the sites footer in the third column. Please keep in mind that you may choose how many footer columns that show under Theme Options > Footer.',
    'class' => 'wm-test-class',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="wm-widget-title">',
    'after_title' => '</h2>',
    'section'       => 'wm_theme_options_sidebar'
));

register_sidebar(array(
    'name' => __('Footer Column 4'),
    'id' => 'col4_footer_widget',
    'description' => 'Allows you to add widgets to the sites footer in the forth column. Please keep in mind that you may choose how many footer columns that show under Theme Options > Footer.',
    'class' => 'wm-test-class',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="wm-widget-title">',
    'after_title' => '</h2>',
    'section'       => 'wm_theme_options_sidebar'
));
?>
