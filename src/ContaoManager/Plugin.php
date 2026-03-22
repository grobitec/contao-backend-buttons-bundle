<?php

declare(strict_types=1);

namespace Grobitec\ContaoBackendButtonsBundle\ContaoManager;

use Grobitec\ContaoBackendButtonsBundle\GrobitecBackendButtonsBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * ContaoManager-Plugin – wird vom Contao Manager automatisch erkannt.
 *
 * Teilt dem Contao Manager mit, dass dieses Bundle nach dem
 * ContaoCoreBundle geladen werden soll.
 */
class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(GrobitecBackendButtonsBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
