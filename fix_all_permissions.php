<?php

// Fungsi Auto Folder : 755 , File : 644 
// Di Gunakan Jika Alses Denied 404 Permission
// Run? sesuai kan domain lu https://vanzhosting.my.id/fix_all_permissions.php

function fixPermissions($dir) {
$rii = new RecursiveIteratorIterator(
new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
RecursiveIteratorIterator::SELF_FIRST
);

foreach ($rii as $file) {
$path = $file->getPathname();

if ($file->isDir()) {
chmod($path, 0755); // Folder
} elseif ($file->isFile()) {
chmod($path, 0644); // File
}
}

// Ubah juga root folder 
chmod($dir, 0755);
}

// Ganti Sesuai Folder Yang Mau Diubah 
$targets = ['X', __DIR__]; // folder X,  dan root

foreach ($targets as $folder) {
$path = is_dir($folder) ? realpath($folder) : $folder;
if ($path) {
fixPermissions($path);
}
}

echo "✅ Semua Permission Berhasil Di Set.";
