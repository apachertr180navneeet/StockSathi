<?php
require 'vendor/autoload.php';

if (class_exists('Spatie\Permission\PermissionServiceProvider')) {
    echo "Class Found!\n";
} else {
    echo "Class NOT Found!\n";
}
