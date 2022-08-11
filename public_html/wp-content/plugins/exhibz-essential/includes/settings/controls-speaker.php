<?php 

function exhibz_speaker_settings_api_init() {

    add_settings_section(
       'exhibz_speaker_setting_section',
       'Exhibz Speaker Settings',
       null,
       'writing'
   );
 
   add_settings_field(
       'exhibz_speaker_setting_slug',
       'Speaker Slug',
       'exhibz_speaker_slug_setting_callback_function',
       'writing',
       'exhibz_speaker_setting_section'
   );

   add_settings_field(
    'exhibz_speaker_singular_name',
    'Speaker singular name',
    'exhibz_speaker_singular_setting_callback_function',
    'writing',
    'exhibz_speaker_setting_section'
   );
   
   add_settings_field(
    'exhibz_speaker_plural_name',
    'Speaker plural name',
    'exhibz_speaker_plural_setting_callback_function',
    'writing',
    'exhibz_speaker_setting_section'
   );

    register_setting( 'writing', 'exhibz_speaker_setting_slug' );
    register_setting( 'writing', 'exhibz_speaker_singular_name' );
    register_setting( 'writing', 'exhibz_speaker_plural_name' );
} 

add_action( 'admin_init', 'exhibz_speaker_settings_api_init' );


function exhibz_speaker_plural_setting_callback_function() {
    $name = get_option('exhibz_speaker_plural_name');
  
    echo '<input name="exhibz_speaker_plural_name" id="exhibz_speaker_plural_name" type="text" value="'.$name.'" />';
}

function exhibz_speaker_singular_setting_callback_function() {
    $sname = get_option('exhibz_speaker_singular_name');

    echo '<input name="exhibz_speaker_singular_name" id="exhibz_speaker_singular_name" type="text" value="'.$sname.'" />';
}

function exhibz_speaker_slug_setting_callback_function() {
    $slug = get_option('exhibz_speaker_setting_slug');
    echo '<input name="exhibz_speaker_setting_slug" id="exhibz_speaker_setting_slug" type="text" value="'.$slug.'" />';
}

// team category settings


function exhibz_speaker_category_settings_api_init() {
 
   add_settings_field(
       'exhibz_speaker_cat_setting_slug',
       'Speaker category slug',
       'exhibz_speaker_cat_slug_setting_callback_function',
       'writing',
       'exhibz_speaker_setting_section'
   );

   add_settings_field(
    'exhibz_speaker_cat_singular_name',
    'Speaker category name',
    'exhibz_speaker_cat_singular_setting_callback_function',
    'writing',
    'exhibz_speaker_setting_section'
   );

    register_setting( 'writing', 'exhibz_speaker_cat_setting_slug' );
    register_setting( 'writing', 'exhibz_speaker_cat_singular_name' );


} 

add_action( 'admin_init', 'exhibz_speaker_category_settings_api_init' );

function exhibz_speaker_cat_singular_setting_callback_function() {
    $sname = get_option('exhibz_speaker_cat_singular_name');
   
    echo '<input name="exhibz_speaker_cat_singular_name" id="exhibz_speaker_cat_singular_name" type="text" value="'.$sname.'" />';
}

function exhibz_speaker_cat_slug_setting_callback_function() {
    $slug = get_option('exhibz_speaker_cat_setting_slug');
    echo '<input name="exhibz_speaker_cat_setting_slug" id="exhibz_speaker_cat_setting_slug" type="text" value="'.$slug.'" />';
}







