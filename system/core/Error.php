<?php

namespace Apollo\Core;

use Apollo\Core\Polyfill\Enum;

/**
 * Class Error
 *
 * @package Apollo\Core
 * @method static Undefined()
 * @method static ApolloSQL()
 * @method static ApolloTemplate()
 * @method static ApolloUninstalled()
 * @method static ApolloOutdated()
 * @method static ApolloCore()
 * @method static HTTP()
 *
 */
class Error extends Enum
{
    // Something unspecified went wrong
    public const Undefined = '0';
    // SQL error
    public const ApolloSQL = '10';
    // Templating error
    public const ApolloTemplate = '20';
    // Site is uninstalled
    public const ApolloUninstalled = '30';
    // Site db version does not match installation (not updated)
    public const ApolloOutdated = '40';
    // Core functionality failed
    public const ApolloCore = '50';
    // Typically a Router error for resources
    public const HTTP = '6969';
}