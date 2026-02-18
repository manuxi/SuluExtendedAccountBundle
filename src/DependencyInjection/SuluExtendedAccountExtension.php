<?php

namespace Manuxi\SuluExtendedAccountBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SuluExtendedAccountExtension extends Extension implements PrependExtensionInterface
{

    public function prepend(ContainerBuilder $container)
    {
        if ($container->hasExtension('sulu_admin')) {
            $container->prependExtensionConfig('sulu_admin', [
                'forms' => [
                    'directories' => [
                        __DIR__ . '/../Resources/config/forms',
                    ],
                ],
                'resources' => [
                    'extended_account' => [
                        'routes' => [
                            'detail' => 'sulu_extended_account.get',
                        ],
                    ],
                ],
            ]);
        }

        if ($container->hasExtension('sulu_contact')) {
            $container->prependExtensionConfig('sulu_contact', [
                'objects' => [
                    'account' => [
                        'model' => 'Manuxi\SuluExtendedAccountBundle\Entity\Account',
                    ],
                ],
            ]);
        }

        $container->loadFromExtension('framework', [
            'default_locale' => 'en',
            'translator' => [
                'paths' => [__DIR__ . '/../Resources/translations/'],
            ],
        ]);
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yaml');
    }

}
