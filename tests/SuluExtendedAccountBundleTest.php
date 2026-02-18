<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Tests;

use Manuxi\SuluExtendedAccountBundle\SuluExtendedAccountBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SuluExtendedAccountBundleTest extends TestCase
{
    public function testExtendsBundle(): void
    {
        $bundle = new SuluExtendedAccountBundle();
        $this->assertInstanceOf(Bundle::class, $bundle);
    }

    public function testGetName(): void
    {
        $bundle = new SuluExtendedAccountBundle();
        $this->assertSame('SuluExtendedAccountBundle', $bundle->getName());
    }
}
