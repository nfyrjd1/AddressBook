<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64e746b04ab4cbcbac014878dbe9982a
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AddressBook\\Core\\Db\\' => 20,
            'AddressBook\\Contact\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AddressBook\\Core\\Db\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core/db',
        ),
        'AddressBook\\Contact\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/contact',
        ),
    );

    public static $classMap = array (
        'AddressBook\\Core\\Db\\MySql' => __DIR__ . '/../..' . '/core/db/MySql.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit64e746b04ab4cbcbac014878dbe9982a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64e746b04ab4cbcbac014878dbe9982a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit64e746b04ab4cbcbac014878dbe9982a::$classMap;

        }, null, ClassLoader::class);
    }
}