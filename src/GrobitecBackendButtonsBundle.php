<?php

declare(strict_types=1);

namespace Grobitec\ContaoBackendButtonsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Hauptklasse des Grobitec Backend-Buttons Bundles.
 *
 * Registriert das Bundle im Symfony-Kernel.
 * getPath() gibt das Bundle-Stammverzeichnis zurück, damit Contao
 * die Ressourcen unter contao/ (DCA, Languages) findet.
 */
class GrobitecBackendButtonsBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
