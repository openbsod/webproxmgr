<?php

// Require the autoloader
require_once 'vendor/autoload.php';

// Use the library namespace
use ProxmoxVE\Proxmox;

// Create your credentials array
$credentials = [
    'hostname' => '10.10.6.150',  // Also can be an IP
    'username' => 'root',
    'password' => 'password',
];

$proxmox = new Proxmox($credentials);

// Update existing firewall rule by position number
// We use set() function since we want to make a change on a existing resource
$result = $proxmox->set('/nodes/pve/qemu/101/firewall/rules/0', [
    'action' => 'ACCEPT'  // Want to change the user's email
]);

// If an error occurred the 'errors' key will exist in the response array
if (isset($result['errors'])) {
    error_log('Unable to create new fw rule.');
    foreach ($result['errors'] as $title => $description) {
        error_log($title . ': ' . $description);
    }
} else {
    echo 'Successful rule update!';
}
