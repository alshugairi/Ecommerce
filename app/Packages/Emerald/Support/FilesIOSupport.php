<?php


namespace App\Packages\Emerald\Support;

use phpDocumentor\Reflection\DocBlock\Tag;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class FilesIOSupport
{
    /**
     * return classes in path
     * @param string $path
     * @return array
     */
    public static function getCLassesByPath(string $path): array
    {
        $fullyQualifiedCNames = array();

        if (!self::isPathExists($path)) {
            throw new \RuntimeException("$path not exists");
        }

        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2; // Skip class keyword and whitespace
                    $fullyQualifiedCNames[] = $namespace . '\\' . $tokens[$index][1];

                    # break if you have one class per file (psr-4 compliant)
                    # otherwise you'll need to handle class constants (Foo::class)
                    break;
                }
            }
        }
        return $fullyQualifiedCNames;
    }

    /**
     * @param string $path
     * @return bool
     */
    private static function isPathExists(string $path): bool
    {
        return is_dir($path);
    }


}
