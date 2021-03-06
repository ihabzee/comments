<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit47d55c5880b37648ca1535fdfd27f40e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit47d55c5880b37648ca1535fdfd27f40e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit47d55c5880b37648ca1535fdfd27f40e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
