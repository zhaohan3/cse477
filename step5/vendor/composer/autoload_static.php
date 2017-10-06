<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite5696d7c6092f25fc2ce53918676e7a6
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Guessing\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Guessing\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/Guessing',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite5696d7c6092f25fc2ce53918676e7a6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite5696d7c6092f25fc2ce53918676e7a6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
