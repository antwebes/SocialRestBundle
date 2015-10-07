<?php
/*
 * This file is part of the SocialRestBundle package.
 *
 * (c) PrettyBundle <https://github.com/antwebes/SocialRestBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
$file = __DIR__.'/../vendor/autoload.php';
$file_in_project = __DIR__ . '/../../../../../autoload.php';

if (!file_exists($file)) {
    if (!file_exists($file_in_project)) {
        throw new RuntimeException('Install dependencies to run test suite. Or add the bundle in project symfony2');
    }else{
        $file = $file_in_project;
    }
}
$autoload = require_once $file;