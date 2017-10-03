
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

// Then simply pass your credentials when creating the API client object.
$proxmox = new Proxmox($credentials);

$allNodes = $proxmox->create('/nodes/pve/qemu/102/monitor', [
    'command' => 'change vnc none'  // setting vnc password
]);

print_r($allNodes);
