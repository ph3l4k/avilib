<?php
class Avilib_i18n {
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'avilib',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}