<?php

// Require the autoloader
require_once 'vendor/autoload.php';

// Use the library namespace
use ProxmoxVE\Proxmox;

// Create your credentials array
$credentials = [
    'hostname' => '10.202.230.61',  // Also can be an IP
    'username' => 'root',
    'password' => 'password',
];

// Then simply pass your credentials when creating the API client object.
$proxmox = new Proxmox($credentials);

// Prepare params to use
$newVMData = [
        "vmid" => "111",
        "agent" => "1",
        "bootdisk" => "scsi0",
        "boot" => "cdn",
        "cores" => "1",
        "ide2" => "iso:iso/CentOS-7-x86_64-Minimal-1611-ks.iso,media=cdrom",
        "memory" => "1024",
        "name" => "cent7-1",
        "net0" => "virtio=C2:E9:70:7B:21:F4,bridge=vmbr0",
        "numa" => "0",
        "ostype" => "l26",
        // mkdir /var/vm/images/111
        // cd /var/vm/images/111
        // qemu-img create -f qcow2 vm-111-disk-1.qcow2 20G
        "scsi0" => "ma-70:111/vm-111-disk-1.qcow2,size=20G",
        "scsihw" => "virtio-scsi-pci",
        "sockets" => "1",
];

// We use create() function
$result = $proxmox->create('/nodes/ma70/qemu', $newVMData);
// If an error occurred the 'errors' key will exist in the response array
if (isset($result['errors'])) {
    error_log('Unable to create new proxmox VM.');
    foreach ($result['errors'] as $title => $description) {
        error_log($title . ': ' . $description);
    }
} else {
    echo 'Successful VM creation!';
}
