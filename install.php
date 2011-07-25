<?php

// ----------------------------------------------------------------------
// This install file will be included by the module automatically
// at the first time that it is run. This file will take care of
// adding the custom user field "mod_recent_messages" to Phorum.
// This way, the administrator won't have to create the custom field
// manually.
// ----------------------------------------------------------------------

if(!defined("PHORUM")) return;

if (file_exists('./include/api/custom_profile_fields.php')) {
    require_once('./include/api/custom_profile_fields.php');
}

// See if we already have this field configured.
$existing = phorum_api_custom_profile_field_byname("mod_recent_messages");

// We have, but it is a deleted field.
// In this case restore the field and its data.
if (!empty($existing["deleted"])) {
    phorum_api_custom_profile_field_restore($existing["id"]);
    $id = $existing["id"];
}
// Existing field.
elseif (!empty($existing)) {
    $id = $existing["id"];
}
// New field.
else {
    $id = NULL;
}

// Configure the field.
phorum_api_custom_profile_field_configure(array(
    'id'            => $id,
    'name'          => 'mod_recent_messages',
    'length'        => 65000, // since field is 65000+ in the database anyway
    'html_disabled' => 0, // we need raw storage
));

// tell that the module has been installed
phorum_db_update_settings(array(
  "mod_recent_messages" => array('installed' => 1)
));

?>
