<?php

namespace RRZE\WP\Settings\Fields;

defined('ABSPATH') || exit;

class Textarea extends Field
{
    public $template = 'textarea';

    public function sanitize($value)
    {
        return sanitize_textarea_field($value);
    }
}
