<?php

// Require the autoloader
require_once 'vendor/autoload.php';

// Use the library namespace
use ProxmoxVE\Proxmox;

// Create your credentials array
$credentials = [
    'hostname' => '10.10.230.61',  // Also can be an IP
    'username' => 'root',
    'password' => 'passw0rd',
];

// Then simply pass your credentials when creating the API client object.
$proxmox = new Proxmox($credentials);

// Prepare params to use
$newSCSI = [
        // pvesh create /nodes/ma70/storage/ma-70/content -filename 'vm-130-disk-1.qcow2' -format 'qcow2' -size 20G -vmid 130
        "format" => "qcow2",
        "filename" => "vm-130-disk-1.qcow2",
        "size" => "20G",
        "vmid" => "130",
];

// We use set() function since we want to make a change on a existing resource
$result = $proxmox->create('/nodes/ma70/storage/ma-70/content', $newSCSI);
// If an error occurred the 'errors' key will exist in the response array
if (isset($result['errors'])) {
    error_log('Unable to create new SCSI.');
    foreach ($result['errors'] as $title => $description) {
        error_log($title . ': ' . $description);
    }
} else {
    echo 'Successful SCSI creation!';
}
