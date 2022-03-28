<?php

/**
 * Simple class loader
 *
 * @param string $className
 *
 * @throws Exception
 */
function autoload(string $className)
{
    $baseDir = __DIR__;
    $fileExtension = 'php';
    $fileName = sprintf('%s/%s.%s',
        $baseDir,
        str_replace('\\', '/', $className),
        $fileExtension
    );

    if (file_exists($fileName)) {
        require $fileName;

    } else {
        throw new Exception(sprintf('File %s not found', $fileName));
    }
}

spl_autoload_register('autoload');