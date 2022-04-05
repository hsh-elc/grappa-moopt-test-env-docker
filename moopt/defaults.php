<?php
//=========================================================================
// START: MOOPT plugin prefs
// https://docs.moodle.org/311/en/Administration_via_command_line#Custom_site_defaults
//=========================================================================
$defaults['qtype_moopt']['service_url'] = 'http://grappa-tomcat:8181/grappa-webservice-2/rest';
$defaults['qtype_moopt']['lms_id'] = 'test';
$defaults['qtype_moopt']['lms_password'] = 'test';
$defaults['qtype_moopt']['communicator'] = 'grappa';
//default settings from 'moodle/question/type/moopt/settings.php' 
$defaults['qtype_moopt']['service_timeout'] = '10';
$defaults['qtype_moopt']['service_client_polling_interval'] = '5';
$defaults['qtype_moopt']['max_number_free_text_inputs'] = '10';
//=========================================================================
// END: MOOPT plugin prefs
//=========================================================================


//TODO: add other Moodle settings for development (debug etc.)