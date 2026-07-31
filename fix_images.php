<?php
$dir = new RecursiveDirectoryIterator('resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);
foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $original = $content;
    
    // Pattern 1: Storage::url($x) -> (str_starts_with($x ?? '', 'http') ? $x : Storage::url($x))
    $content = preg_replace('/Storage::url\(([^)]+)\)/', '(str_starts_with($1 ?? \'\', \'http\') ? $1 : Storage::url($1))', $content);
    
    // Pattern 2: asset('storage/' . $x) -> (str_starts_with($x ?? '', 'http') ? $x : asset('storage/' . $x))
    $content = preg_replace('/asset\(\'storage\/\'\s*\.\s*([^)]+)\)/', '(str_starts_with($1 ?? \'\', \'http\') ? $1 : asset(\'storage/\' . $1))', $content);
    
    if ($content !== $original) {
        file_put_contents($path, $content);
        echo 'Updated: ' . $path . PHP_EOL;
    }
}
echo "Done.\n";
