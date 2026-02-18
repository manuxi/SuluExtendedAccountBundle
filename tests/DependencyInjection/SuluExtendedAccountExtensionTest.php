<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Tests\DependencyInjection;

use Manuxi\SuluExtendedAccountBundle\Admin\ExtendedAccountAdmin;
use Manuxi\SuluExtendedAccountBundle\Controller\Admin\ExtendedAccountController;
use Manuxi\SuluExtendedAccountBundle\DependencyInjection\SuluExtendedAccountExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SuluExtendedAccountExtensionTest extends TestCase
{
    private SuluExtendedAccountExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new SuluExtendedAccountExtension();
    }

    public function testImplementsExtensionInterface(): void
    {
        $this->assertInstanceOf(ExtensionInterface::class, $this->extension);
    }

    public function testImplementsPrependExtensionInterface(): void
    {
        $this->assertInstanceOf(PrependExtensionInterface::class, $this->extension);
    }

    public function testLoadRegistersServices(): void
    {
        $container = new ContainerBuilder();
        $this->extension->load([], $container);

        $this->assertTrue($container->hasDefinition(ExtendedAccountController::class));
        $this->assertTrue($container->hasDefinition(ExtendedAccountAdmin::class));
    }

    public function testLoadedControllerServiceIsPublic(): void
    {
        $container = new ContainerBuilder();
        $this->extension->load([], $container);

        $definition = $container->getDefinition(ExtendedAccountController::class);
        $this->assertTrue($definition->isPublic());
    }

    public function testPrependConfiguresSuluAdmin(): void
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new FakeSuluAdminExtension());
        $container->registerExtension(new FakeFrameworkExtension());

        $this->extension->prepend($container);

        $configs = $container->getExtensionConfig('sulu_admin');
        $merged = array_merge_recursive(...$configs);

        $this->assertArrayHasKey('resources', $merged);
        $this->assertArrayHasKey('extended_account', $merged['resources']);
        $this->assertSame(
            'sulu_extended_account.get',
            $merged['resources']['extended_account']['routes']['detail']
        );
    }

    public function testPrependConfiguresSuluContact(): void
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new FakeSuluAdminExtension());
        $container->registerExtension(new FakeSuluContactExtension());
        $container->registerExtension(new FakeFrameworkExtension());

        $this->extension->prepend($container);

        $configs = $container->getExtensionConfig('sulu_contact');
        $merged = array_merge_recursive(...$configs);

        $this->assertArrayHasKey('objects', $merged);
        $this->assertSame(
            'Manuxi\SuluExtendedAccountBundle\Entity\Account',
            $merged['objects']['account']['model']
        );
    }

    public function testPrependSkipsSuluAdminWhenNotRegistered(): void
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new FakeFrameworkExtension());

        $this->extension->prepend($container);

        $this->assertEmpty($container->getExtensionConfig('sulu_admin'));
    }
}

class FakeSuluAdminExtension extends Extension
{
    public function getAlias(): string { return 'sulu_admin'; }
    public function load(array $configs, ContainerBuilder $container): void {}
}

class FakeSuluContactExtension extends Extension
{
    public function getAlias(): string { return 'sulu_contact'; }
    public function load(array $configs, ContainerBuilder $container): void {}
}

class FakeFrameworkExtension extends Extension
{
    public function getAlias(): string { return 'framework'; }
    public function load(array $configs, ContainerBuilder $container): void {}
}
