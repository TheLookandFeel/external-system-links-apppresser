<?php

/**
 * Plugin Name: External System Links for AppPresser
 * Description: Filters external links in post content to give them 'external system' classes, to have AppPresser handle them as links opening in the system browser.
 * Author: The Look and Feel
 * Author URI: http://thelookandfeel.no
 */

if ( ! file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    wp_die(__('Autoloader for External System Links for AppPresser could not be loaded.',
        'external-system-links-apppresser'));
}

require('vendor/autoload.php');

$updatePhp = new WPUpdatePhp('5.4.0');

if ($updatePhp->does_it_meet_required_php_version(PHP_VERSION)) {
    add_action('plugins_loaded', function () {
        $instance = new \TheLookAndFeel\ExternalSystemLinksAppPresser\Plugin();
        $instance->setup();
    }, 20);
}