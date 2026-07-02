<?php
$content = file_get_contents('resources/views/admin/body/sidebar.blade.php');

$replacements = [
    'POS' => 'pos.all',
    'Brand Manage' => 'brand.all',
    'Warehouse Manage' => 'warehouse.all',
    'Supplier Manage' => 'supplier.all',
    'Customer Manage' => 'customer.all',
    'Product Manage' => 'product.all',
    'Purchase Manage' => 'purchase.all',
    'Sale Manage' => 'sale.all',
    'Due Setup' => 'sale.all',
    'Transfers Setup' => 'transfer.all',
    'Report Setup' => 'financial.report.all',
    'Stock Adjustment' => 'stock.adjustment.all',
    'Batch / Lot' => 'batch.all',
    'Bin / Rack' => 'bin.rack.all',
    'Delivery Tracking' => 'delivery.all',
    'HR Management' => 'hr.menu',
    'Accounting Manage' => 'account.all',
    'Role & Permission' => 'role.all',
    'Admin Manage' => 'admin.all',
];

foreach ($replacements as $text => $permission) {
    if ($text === 'POS') {
        $pattern = '/<li>\s*<a href="[^"]*pos\.index[^"]*"[^>]*>\s*<i[^>]*><\/i>\s*<span>' . preg_quote($text, '/') . '<\/span>\s*<\/a>\s*<\/li>/is';
    } else {
        $pattern = '/<li>\s*<a[^>]*>\s*<i[^>]*><\/i>\s*<span>' . preg_quote($text, '/') . '<\/span>.*?<\/ul>\s*<\/li>/is';
    }
    
    $content = preg_replace_callback($pattern, function($matches) use ($permission) {
        return "@can('$permission')\n                " . ltrim($matches[0]) . "\n                @endcan";
    }, $content);
}

file_put_contents('resources/views/admin/body/sidebar.blade.php', $content);
echo "Sidebar RBAC applied.\n";
