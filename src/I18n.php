<?php

namespace RRZE\WP;

defined('ABSPATH') || exit;

class I18n
{
    public static function loadTextdomain()
    {
        add_action('init', function () {
            load_plugin_textdomain('rrze-wp', false, '/languages/');
        });
    }
}
