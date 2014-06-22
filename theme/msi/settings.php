<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Tagline setting
    $name = 'theme_msi/tagline';
    $title = get_string('tagline','theme_msi');
    $description = get_string('taglinedesc', 'theme_msi');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Custom CSS file
    $name = 'theme_msi/customcss';
    $title = get_string('customcss','theme_msi');
    $description = get_string('customcssdesc', 'theme_msi');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

}
