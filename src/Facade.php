<?php

namespace TRS\FactoryGirl\Faker;

/**
 * This is the faker facade class.
 *
 * This class dynamically proxies static method calls to the underlying faker.
 *
 * @see TRS\FactoryGirl\Faker\Faker
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Facade
{
    /**
     * The underlying faker instance.
     *
     * @var \TRS\FactoryGirl\Faker\Faker
     */
    private static $instance;

    /**
     * Get the underlying faker instance.
     *
     * We'll always cache the instance and reuse it.
     *
     * @return \TRS\FactoryGirl\Faker\Faker
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new Faker();
        }

        return self::$instance;
    }

    /**
     * Reset the underlying faker instance.
     *
     * @return \TRS\FactoryGirl\Faker\Faker
     */
    public static function reset()
    {
        self::$instance = null;

        return self::instance();
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @codeCoverageIgnore
     *
     * @param string $method    The method name.
     * @param array  $arguments The arguments.
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        switch (count($arguments)) {
            case 0:
                return self::instance()->$method();
            case 1:
                return self::instance()->$method($arguments[0]);
            case 2:
                return self::instance()->$method($arguments[0], $arguments[1]);
            case 3:
                return self::instance()->$method($arguments[0], $arguments[1], $arguments[2]);
            case 4:
                return self::instance()->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
            case 5:
                return self::instance()->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4]);
            case 6:
                return self::instance()->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4], $arguments[5]);
            default:
                return call_user_func_array([self::instance(), $method], $arguments);
        }
    }
}
