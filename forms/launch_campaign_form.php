<?php

require_once("$CFG->libdir/formslib.php");

class launch_campaign_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        // Campaign name
        $mform->addElement('text', 'name', get_string('campaignname', 'local_gophishintegration'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required');

        // Group select
        $groups = $this->_customdata['groups']; // passed from the main script
        $options = [];
        foreach ($groups as $group) {
            $options[$group->id] = format_string($group->name);
        }

        $mform->addElement('select', 'groupid', get_string('selectgroup', 'local_gophishintegration'), $options);
        $mform->addRule('groupid', null, 'required');

        // Hidden fields if needed
        $mform->addElement('hidden', 'sesskey', sesskey());
        $mform->setType('sesskey', PARAM_RAW);

        // Action buttons
        $this->add_action_buttons(true, get_string('launchcampaign', 'local_gophishintegration'));
    }
}
