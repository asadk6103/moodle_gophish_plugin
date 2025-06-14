<?php

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_gophishintegration', get_string('pluginname', 'local_gophishintegration'));

    $settings->add(new admin_setting_configtext(
        'local_gophishintegration/apiurl',
        get_string('apiurl', 'local_gophishintegration'),
        get_string('apiurl_desc', 'local_gophishintegration'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'local_gophishintegration/apikey',
        get_string('apikey', 'local_gophishintegration'),
        get_string('apikey_desc', 'local_gophishintegration'),
        '',
        PARAM_ALPHANUMEXT
    ));

    $ADMIN->add('localplugins', $settings);

    $ADMIN->add('localplugins', new admin_externalpage(
        'local_gophishintegration_sync',
        'GoPhish User Sync',
        $CFG->wwwroot . '/local/gophishintegration/sync.php',
        'local/gophishintegration:syncusers'
    ));

    $ADMIN->add('localplugins', new admin_externalpage(
        'local_gophishintegration_launch',
        'GoPhish Launch Campaign',
        $CFG->wwwroot . '/local/gophishintegration/launch.php',
        'local/gophishintegration:launchcampaign'
    ));


     $ADMIN->add('localplugins', new admin_externalpage(
        'local_gophishintegration_email_template',
        'GoPhish Email Templates',
        $CFG->wwwroot . '/local/gophishintegration/template.php',
        'local/gophishintegration:createemailtemplate'
    ));
     
    $ADMIN->add('localplugins', new admin_externalpage(
        'local_gophishintegration_landing_pages',
        'GoPhish Landing Pages',
        $CFG->wwwroot . '/local/gophishintegration/landingpage.php',
        'local/gophishintegration:createlandingpage'
    ));
  
    $ADMIN->add('localplugins', new admin_externalpage(
        'local_gophishintegration_sending_profiles',
        'GoPhish Sending Profiles',
        $CFG->wwwroot . '/local/gophishintegration/sendingprofile.php',
        'local/gophishintegration:createsendingprofiles'
    ));
}
