<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit1e4dfbc3f688067e6874984a5f380869
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit1e4dfbc3f688067e6874984a5f380869', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit1e4dfbc3f688067e6874984a5f380869', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit1e4dfbc3f688067e6874984a5f380869::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
