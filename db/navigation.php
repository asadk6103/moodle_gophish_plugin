<?php

defined('MOODLE_INTERNAL') || die();

function local_gophishintegration_extend_navigation(global_navigation $navigation) {
    global $PAGE, $CFG;

    $systemcontext = context_system::instance();

    // Only add if user has permission
    if (has_capability('local/gophishintegration:createemailtemplate', $systemcontext)) {

        // Add under main "Site" section (nav root)
        $node = navigation_node::create(
            get_string('gophishintegration', 'local_gophishintegration'),
            new moodle_url('/local/gophishintegration/template.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            'gophishintegration'
        );

        $navigation->add_node($node);
    }
}
