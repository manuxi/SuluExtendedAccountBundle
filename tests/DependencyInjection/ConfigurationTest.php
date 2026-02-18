<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Tests\DependencyInjection;

use Manuxi\SuluExtendedAccountBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationTest extends TestCase
{
    public function testImplementsConfigurationInterface(): void
    {
        $configuration = new Configuration();
        $this->assertInstanceOf(ConfigurationInterface::class, $configuration);
    }

    public function testGetConfigTreeBuilderHasCorrectRootNode(): void
    {
        $configuration = new Configuration();
        $treeBuilder = $configuration->getConfigTreeBuilder();

        $this->assertSame('extended-account', $treeBuilder->buildTree()->getName());
    }
}
