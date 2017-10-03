<?php

// Require the autoloader
require_once 'vendor/autoload.php';

// Use the library namespace
use ProxmoxVE\Proxmox;

// Create your credentials array
$credentials = [
    'hostname' => '10.10.230.61',
    'username' => 'root',
    'password' => 'passw0rd',
];

$proxmox = new Proxmox($credentials);

// Prepare scsi0 params to use
$newSCSI = [
        "format" => "qcow2",
        "filename" => "vm-111-disk-1.qcow2",
        "size" => "20G",
        "vmid" => "111",
];

// Prepare VM params to use
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
        "scsi0" => "ma-70:111/vm-111-disk-1.qcow2,size=20G",
        "scsihw" => "virtio-scsi-pci",
        "sockets" => "1",
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
    $result = $proxmox->create('/nodes/ma70/qemu', $newVMData);
        if (isset($result['errors'])) {
        error_log('Unable to create new VM.');
        foreach ($result['errors'] as $title => $description) {
        error_log($title . ': ' . $description);
          }
          } else {
          echo 'Successful VM creation!';
          $result = $proxmox->create('/nodes/ma70/qemu/111/status/start');
            if (isset($result['errors'])) {
            error_log('Unable to create new VM.');
            foreach ($result['errors'] as $title => $description) {
            error_log($title . ': ' . $description);
              }
              } else {
              echo 'Successful VM start!';
              }
          }
}
