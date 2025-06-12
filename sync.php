<?php

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/user/lib.php');

require_login();
require_capability('local/gophishintegration:syncusers', context_system::instance());

$PAGE->set_url(new moodle_url('/local/gophishintegration/sync.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('GoPhish User Sync');
$PAGE->set_heading('GoPhish User Sync');

echo $OUTPUT->header();

if (optional_param('sync', false, PARAM_BOOL)) {
    $users = get_users_to_sync();
    $client = new \local_gophishintegration\api_client();
    $groupname = 'Moodle Sync ' . date('Y-m-d H:i:s');
    $result = $client->create_group($groupname, $users);

    if ($result) {
        echo $OUTPUT->notification('Successfully synced ' . count($users) . ' users to GoPhish group: ' . $groupname, 'success');
    } else {
        echo $OUTPUT->notification('Failed to sync users.', 'error');
    }
}

$url = new moodle_url('/local/gophishintegration/sync.php', ['sync' => 1]);
echo $OUTPUT->single_button($url, 'Sync Moodle Users to GoPhish');

echo $OUTPUT->footer();

// You may customize user selection here
function get_users_to_sync()
{
    global $DB;
    return $DB->get_records('user', ['deleted' => 0, 'suspended' => 0]);
}
