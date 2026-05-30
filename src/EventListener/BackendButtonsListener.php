<?php

declare(strict_types=1);

namespace Grobitec\ContaoBackendButtonsBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;

/**
 * loadDataContainer-Hook Listener.
 *
 * Wird nach dem DefaultOperationsListener (Priorität 200) ausgeführt,
 * damit die Standard-Operationen bereits vorhanden sind.
 *
 * Liest die Konfiguration aus tl_settings und setzt 'primary' => true
 * auf die Operationen, die der Benutzer als direkt sichtbar konfiguriert hat.
 */
#[AsHook('loadDataContainer', priority: 100)]
class BackendButtonsListener
{
    /**
     * Zuordnung: Feldname in tl_settings → Tabellenname.
     *
     * Definiert, welche Tabellen von dieser Erweiterung unterstützt werden
     * und unter welchem Feldnamen die Konfiguration gespeichert ist.
     */
    private const TABLE_FIELD_MAP = [
        'gtBtnPages'        => 'tl_page',
        'gtBtnArticles'     => 'tl_article',
        'gtBtnContent'      => 'tl_content',
        'gtBtnNewsArchives' => 'tl_news_archive',
        'gtBtnNews'         => 'tl_news',
        'gtBtnCalendars'    => 'tl_calendar',
        'gtBtnEvents'       => 'tl_calendar_events',
        'gtBtnMembers'      => 'tl_member',
        'gtBtnFaq'          => 'tl_faq',
        'gtBtnFiles'        => 'tl_files',
    ];

    /**
     * Invertierte Zuordnung: Tabellenname → Feldname in tl_settings.
     * Wird beim ersten Aufruf aufgebaut.
     */
    private static array|null $reverseMap = null;

    public function __invoke(string $table): void
    {
        // Reverse-Map aufbauen (einmalig)
        if (null === self::$reverseMap) {
            self::$reverseMap = array_flip(self::TABLE_FIELD_MAP);
            
            // CSS für das Abschneiden/Ausblenden der Icons bei Platzmangel injizieren
            if (defined('TL_MODE') && TL_MODE === 'BE') {
                $GLOBALS['TL_HEAD'][] = '<style>
                    .tl_listing .operations > ul {
                        display: flex;
                        flex-wrap: nowrap;
                    }
                    .tl_listing .operations > ul > li {
                        flex-shrink: 1;
                        min-width: 0;
                        overflow: hidden;
                    }
                    .tl_listing .operations > ul > li:has(> .edit),
                    .tl_listing .operations > ul > li:has(> .children),
                    .tl_listing .operations > ul > li.operations-menu-container {
                        flex-shrink: 0;
                        overflow: visible;
                    }
                </style>';
            }
        }

        // Prüfen, ob diese Tabelle konfiguriert ist
        $fieldName = self::$reverseMap[$table] ?? null;

        if (null === $fieldName) {
            return;
        }

        // Konfiguration aus tl_settings lesen
        $configValue = Config::get($fieldName);

        if (empty($configValue)) {
            return;
        }

        // Checkbox-Werte als serialisiertes Array lesen / deserialisieren
        $primaryOperations = \Contao\StringUtil::deserialize($configValue, true);

        if (empty($primaryOperations)) {
            return;
        }

        // Operationen als primary markieren
        $this->setPrimaryOperations($table, $primaryOperations);
    }

    /**
     * Setzt 'primary' => true auf die gewünschten Operationen.
     *
     * @param string   $table             Der Tabellenname (z.B. 'tl_page')
     * @param string[] $primaryOperations Liste der Operationsnamen (z.B. ['copy', 'delete'])
     */
    private function setPrimaryOperations(string $table, array $primaryOperations): void
    {
        if (!isset($GLOBALS['TL_DCA'][$table]['list']['operations'])) {
            return;
        }

        foreach ($primaryOperations as $operationName) {
            if (
                isset($GLOBALS['TL_DCA'][$table]['list']['operations'][$operationName])
                && \is_array($GLOBALS['TL_DCA'][$table]['list']['operations'][$operationName])
            ) {
                $GLOBALS['TL_DCA'][$table]['list']['operations'][$operationName]['primary'] = true;
            }
        }
    }

    /**
     * Gibt die unterstützten Tabellen und ihre Feldnamen zurück.
     * Wird von der tl_settings DCA-Konfiguration verwendet.
     */
    public static function getTableFieldMap(): array
    {
        return self::TABLE_FIELD_MAP;
    }
}
