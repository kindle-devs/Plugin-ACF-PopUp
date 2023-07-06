<?php

// Inclua o arquivo ACF
// require_once(ABSPATH . 'wp-content/plugins/advanced-custom-fields-pro/acf.php');

require_once plugin_dir_path(__FILE__) . 'includes/acf-fields.php';


function incluir_rodape()
{
    include 'includes/_popup.php';
}
add_action('wp_footer', 'incluir_rodape', 5);



function incluir_script_no_rodape()
{
    wp_enqueue_script('popup', plugin_dir_url(__FILE__) . 'includes/js/scripts.js', array(), time(), true);
    wp_enqueue_style('popup', plugin_dir_url(__FILE__) . 'includes/css/style.css', array(), time(), 'all');
}
add_action('wp_enqueue_scripts', 'incluir_script_no_rodape', 10);
