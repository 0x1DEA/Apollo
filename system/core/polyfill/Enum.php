<?php
// Credit: anon
// TODO: Reimplement
namespace Apollo\Core\Polyfill;

/**
 * Class Enum
 *
 * @package Apollo\Core\Polyfill
 */
abstract class Enum
{
    /**
     * Name of the Enum
     *
     * @var string
     */
    private string $name;
    /**
     * List of all the Enums
     *
     * @var
     */
    private static array $enums;

    /**
     * Enum constructor.
     *
     * @param $name
     */
    private function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns an array of all Enums as keys to their values
     *
     * @return array
     * @throws \Exception
     */
    public static function getAll(): array
    {
        $class = static::class;
        if ( ! isset(self::$enums[$class])) {
            static::init();
        }

        return self::$enums[$class];
    }

    /**
     * Returns an Enum from it's name
     *
     * @param  string  $name
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function fromString(string $name)
    {
        return static::__callStatic($name, []);
    }

    /**
     * Returns the name of the Enum
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function __callStatic($name, $arguments)
    {
        $class = static::class;
        if ( ! isset(self::$enums[$class])) {
            static::init();
        }
        if ( ! isset(self::$enums[$class][$name])) {
            throw new \TypeError('Undefined enum '.$class.'::'.$name.'()');
        }

        return self::$enums[$class][$name];
    }

    /**
     * @throws \ReflectionException
     */
    private static function init()
    {
        $class = static::class;

        if ($class === __CLASS__) {
            throw new \Exception(
                'Do not invoke methods directly on class Enum'
            );
        }

        $doc = (new \ReflectionClass($class))->getDocComment();

        if (preg_match_all('/@method\s+static\s+(\w+)/i', $doc, $matches)) {
            foreach ($matches[1] as $name) {
                self::$enums[$class][$name] = new static($name);
            }
        } else {
            throw new \Exception(
                'Please provide a PHPDoc for '.$class
                .' with a static @method for each enum value.'
            );
        }
    }
}