<?php

namespace App;

use App\Technologies\TechnologyType;
use App\Technologies\TechTree;
use Illuminate\Support\Collection;

class ClassesInDirectory
{
    /**
     * @param string $directory
     * @param string[] $ignoreClasses
     * @return Collection<int, string>
     */
    public static function get(string $directory, array $ignoreClasses = []): Collection
    {
        $rii = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $directory,
                \FilesystemIterator::SKIP_DOTS
            ),
        );
        $classNames = collect();
        /** @var \SplFileInfo $file */
        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }

            /** @var string|object $className */
            $className = 'App' . str_replace(
                    '/',
                    '\\',
                    str_replace(
                        [app_path(), '.php'],
                        '',
                        $file->getPathname()
                    )
                );

            // Skip unwanted files
            if (in_array($className, $ignoreClasses)) {
                continue;
            }

            $classNames[] = $className::get();
        }
        return $classNames;
    }
}
