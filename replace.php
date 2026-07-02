<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/Models'));
$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'protected $guarded = [];') !== false) {
            $content = str_replace('protected $guarded = [];', "protected \$guarded = ['id'];", $content);
            file_put_contents($file->getPathname(), $content);
            $count++;
        }
    }
}
echo "Replaced in $count files.\n";
