<?php

/**
 * PHP Autoload Override (https://github.com/adriansuter/php-autoload-override)
 *
 * @license https://github.com/adriansuter/php-autoload-override/blob/master/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace AdrianSuter\Autoload\Override\Tests;

use AdrianSuter\Autoload\Override\AutoloadCollection;
use AdrianSuter\Autoload\Override\CodeConverter;
use AdrianSuter\Autoload\Override\FileStreamWrapper;
use AdrianSuter\Autoload\Override\Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Override::class)]
#[UsesClass(AutoloadCollection::class)]
#[UsesClass(CodeConverter::class)]
#[UsesClass(FileStreamWrapper::class)]
class IntegrationCustomNamespaceTest extends AbstractIntegrationTestCase
{
    public static function setUpBeforeClass(): void
    {
        require_once(__DIR__ . '/assets/PHPCustomAutoloadOverride.php');
    }

    protected function getOverrideDeclarations(): array
    {
        return [
            \My\Integration\TestCustomNamespaceOverride\Hash::class => [
                'md5' => 'PHPCustomAutoloadOverride'
            ]
        ];
    }

    public function testHash()
    {
        $hash = new \My\Integration\TestCustomNamespaceOverride\Hash();
// Calls \md5() > Overridden by FQCN-declaration.
        $GLOBALS['md5_return'] = '---';
        $this->assertEquals('---', $hash->hash('1'));
    }
}
