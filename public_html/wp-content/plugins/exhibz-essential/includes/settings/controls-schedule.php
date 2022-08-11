<?php 

function exhibz_schedule_settings_api_init() {

    add_settings_section(
       'exhibz_schedule_setting_section',
       'Exhibz Schedule Settings',
       null,
       'writing'
   );
 
   add_settings_field(
       'exhibz_schedule_setting_slug',
       'Schedule Slug',
       'exhibz_schedule_slug_setting_callback_function',
       'writing',
       'exhibz_schedule_setting_section'
   );

   add_settings_field(
    'exhibz_schedule_singular_name',
    'Schedule singular name',
    'exhibz_schedule_singular_setting_callback_function',
    'writing',
    'exhibz_schedule_setting_section'
   );
   
   add_settings_field(
    'exhibz_schedule_plural_name',
    'Schedule plural name',
    'exhibz_schedule_plural_setting_callback_function',
    'writing',
    'exhibz_schedule_setting_section'
   );

    register_setting( 'writing', 'exhibz_schedule_setting_slug' );
    register_setting( 'writing', 'exhibz_schedule_singular_name' );
    register_setting( 'writing', 'exhibz_schedule_plural_name' );
} 

add_action( 'admin_init', 'exhibz_schedule_settings_api_init' );


function exhibz_schedule_plural_setting_callback_function() {
    $name = get_option('exhibz_schedule_plural_name');
  
    echo '<input name="exhibz_schedule_plural_name" id="exhibz_schedule_plural_name" type="text" value="'.$name.'" />';
}

function exhibz_schedule_singular_setting_callback_function() {
    $sname = get_option('exhibz_schedule_singular_name');

    echo '<input name="exhibz_schedule_singular_name" id="exhibz_schedule_singular_name" type="text" value="'.$sname.'" />';
}

function exhibz_schedule_slug_setting_callback_function() {
    $slug = get_option('exhibz_schedule_setting_slug');
    echo '<input name="exhibz_schedule_setting_slug" id="exhibz_schedule_setting_slug" type="text" value="'.$slug.'" />';
}

// Schedule category settings


function exhibz_schedule_category_settings_api_init() {
 
   add_settings_field(
       'exhibz_schedule_cat_setting_slug',
       'Schedule category slug',
       'exhibz_schedule_cat_slug_setting_callback_function',
       'writing',
       'exhibz_schedule_setting_section'
   );

   add_settings_field(
    'exhibz_schedule_cat_singular_name',
    'Schedule category name',
    'exhibz_schedule_cat_singular_setting_callback_function',
    'writing',
    'exhibz_schedule_setting_section'
   );

    register_setting( 'writing', 'exhibz_schedule_cat_setting_slug' );
    register_setting( 'writing', 'exhibz_schedule_cat_singular_name' );


} 

add_action( 'admin_init', 'exhibz_schedule_category_settings_api_init' );

function exhibz_schedule_cat_singular_setting_callback_function() {
    $sname = get_option('exhibz_schedule_cat_singular_name');
   
    echo '<input name="exhibz_schedule_cat_singular_name" id="exhibz_schedule_cat_singular_name" type="text" value="'.$sname.'" />';
}

function exhibz_schedule_cat_slug_setting_callback_function() {
    $slug = get_option('exhibz_schedule_cat_setting_slug');
    echo '<input name="exhibz_schedule_cat_setting_slug" id="exhibz_schedule_cat_setting_slug" type="text" value="'.$slug.'" />';
}




