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

$proxmox = new Proxmox($credentials);
$newSCSI = [
        "format" => "qcow2",
        "filename" => "vm-134-disk-1.qcow2",
        "size" => "40G",
        "vmid" => "134",
];

// Prepare params to use
$newVMData = [
        "vmid" => "134",
        "agent" => "1",
        "bootdisk" => "virtio0",
	"boot" => "cdn",
        "cores" => "2",
	"ide0" => "iso:iso/virtio-win.iso,media=cdrom,size=152204K",
        "ide2" => "iso:iso/win2012.iso,media=cdrom",
        "memory" => "4096",
        "name" => "win-auto",
        "net0" => "virtio=C2:E9:70:7B:21:F4",
        "numa" => "0",
        "ostype" => "win8",
        "scsihw" => "virtio-scsi-pci",
	"virtio0" => "ma-70:134/vm-134-disk-1.qcow2,cache=writeback,size=40G",
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
$result = $proxmox->create('/nodes/ma70/qemu/134/status/start');
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
