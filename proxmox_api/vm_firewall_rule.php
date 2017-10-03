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

// Prepare params to use
$newFWRule = [
    'enable' => '0',
    'type' => 'in',
    'pos' => '0',
    'action' => 'DROP',
    'dport' => '22',
    'pos' => '0',
    'proto' => 'tcp',
    'sport' => '22',
];

// Create a new vm firewall rule
$result = $proxmox->create('/nodes/pve/qemu/101/firewall/rules', $newFWRule);

// If an error occurred the 'errors' key will exist in the response array
if (isset($result['errors'])) {
    error_log('Unable to create new fw rule.');
    foreach ($result['errors'] as $title => $description) {
        error_log($title . ': ' . $description);
    }
} else {
    echo 'Successful rule creation!';
}
