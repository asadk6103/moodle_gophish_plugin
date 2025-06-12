<?php

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/forms/launch_campaign_form.php');

require_login();
require_capability('local/gophishintegration:launchcampaign', context_system::instance());

$PAGE->set_url(new moodle_url('/local/gophishintegration/launch.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('GoPhish Launch Campaign');
$PAGE->set_heading('GoPhish Launch Campaign');

echo $OUTPUT->header();

$client = new \local_gophishintegration\api_client();
$groups = json_decode($client->get_groups());

// Prepare the form
$form = new launch_campaign_form(null, ['groups' => $groups]);

if ($form->is_cancelled()) {
    redirect(new moodle_url('/')); // or redirect somewhere else
} else if ($data = $form->get_data()) {

    // Pre-configured values
    $templateid = 1;
    $url = 'https://yourlandingpage.com';

    $result = $client->create_campaign($data->name, $data->groupid, $templateid, $url);

    if ($result) {
        echo $OUTPUT->notification('Campaign launched successfully!', 'success');
    } else {
        echo $OUTPUT->notification('Failed to launch campaign.', 'error');
    }
}

$form->display();

echo $OUTPUT->footer();
