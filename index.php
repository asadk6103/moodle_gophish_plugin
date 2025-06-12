<?php

require_once(__DIR__.'/../../config.php');

require_login();
require_capability('local/gophishintegration:view', context_system::instance());

$PAGE->set_url(new moodle_url('/local/gophishintegration/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pluginname', 'local_gophishintegration'));
$PAGE->set_heading(get_string('pluginname', 'local_gophishintegration'));

echo $OUTPUT->header();

$client = new \local_gophishintegration\api_client();
$campaigns = $client->get_campaigns();

if (empty($campaigns)) {
    echo $OUTPUT->notification(get_string('nocampaigns', 'local_gophishintegration'), 'warning');
} else {
    $table = new html_table();
    $table->head = ['Name', 'Status', 'Launch Date', 'Completed Date'];
    foreach ($campaigns as $campaign) {
        $launched = !empty($campaign->launch_date) ? date('Y-m-d H:i:s', strtotime($campaign->launch_date)) : '-';
        $completed = !empty($campaign->completed_date) ? date('Y-m-d H:i:s', strtotime($campaign->completed_date)) : '-';
        $table->data[] = [
            format_string($campaign->name),
            ucfirst($campaign->status),
            $launched,
            $completed
        ];
    }
    echo html_writer::table($table);
}

echo $OUTPUT->footer();
