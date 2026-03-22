<?php

declare(strict_types=1);

namespace Grobitec\ContaoBackendButtonsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Lädt die Service-Konfiguration (config/services.yaml) in den
 * Symfony DI-Container.
 *
 * WARUM IST DIESE KLASSE NÖTIG?
 * ──────────────────────────────
 * Ein Symfony-Bundle lädt seine config/services.yaml NICHT automatisch.
 * Es braucht eine Extension-Klasse, die die YAML-Datei explizit lädt.
 * Ohne diese Klasse werden die Services (EventListener, Hooks etc.)
 * nicht im Container registriert und die #[AsHook]-Attribute greifen nicht.
 */
class GrobitecBackendButtonsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config')
        );

        $loader->load('services.yaml');
    }
}
