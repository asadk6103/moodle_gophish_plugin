<?php

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/forms/create_landing_page_form.php');

require_login();
require_capability('local/gophishintegration:createlandingpage', context_system::instance());

$PAGE->set_url(new moodle_url('/local/gophishintegration/landingpage.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('GoPhish Landing Page');
$PAGE->set_heading('GoPhish Landing Page');

echo $OUTPUT->header();

$client = new \local_gophishintegration\api_client();

// Prepare the form
$form = new create_landing_page_form();

if ($form->is_cancelled()) {
    redirect(new moodle_url('/')); // or redirect somewhere else
} else if ($data = $form->get_data()) {

    // Pre-configured values
    $result = $client->create_landing_page(
        $data->name,
        $data->html_editor['text'],
        $data->lpcapturedata,
        $data->lpcapturepassword,
        $data->lpurl
    );
    if ($result) {
        echo $OUTPUT->notification('landing page added successfully!', 'success');
    } else {
        echo $OUTPUT->notification('Failed to add landing page.', 'error');
    }
}

$form->display();

echo $OUTPUT->footer();
