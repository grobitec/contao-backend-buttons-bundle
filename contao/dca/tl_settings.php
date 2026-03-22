<?php

declare(strict_types=1);

/*
 * DCA-Konfiguration für tl_settings.
 *
 * Fügt dem Backend-Bereich "System → Einstellungen" eine neue Legende
 * "Backend-Buttons" hinzu, in der pro Tabelle konfiguriert werden kann,
 * welche Operationen direkt sichtbar sein sollen (statt im Dropdown-Menü).
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

// ─── Felder definieren ───────────────────────────────────────────────────────

$GLOBALS['TL_DCA']['tl_settings']['fields']['gtBtnPages'] = [
    'inputType' => 'checkbox',
    'options'   => ['copy', 'copyChildren', 'cut', 'delete', 'show', 'versions', 'articles'],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['gtBtnOptions'],
    'eval'      => ['multiple' => true, 'tl_class' => 'clr w50'],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['gtBtnArticles'] = [
    'inputType' => 'checkbox',
    'options'   => ['copy', 'cut', 'delete', 'show', 'versions'],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['gtBtnOptions'],
    'eval'      => ['multiple' => true, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['gtBtnContent'] = [
    'inputType' => 'checkbox',
    'options'   => ['copy', 'cut', 'delete', 'show', 'versions'],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['gtBtnOptions'],
    'eval'      => ['multiple' => true, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['gtBtnNews'] = [
    'inputType' => 'checkbox',
    'options'   => ['copy', 'cut', 'delete', 'show', 'versions'],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['gtBtnOptions'],
    'eval'      => ['multiple' => true, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['gtBtnEvents'] = [
    'inputType' => 'checkbox',
    'options'   => ['copy', 'cut', 'delete', 'show', 'versions'],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['gtBtnOptions'],
    'eval'      => ['multiple' => true, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['gtBtnMembers'] = [
    'inputType' => 'checkbox',
    'options'   => ['copy', 'delete', 'show', 'versions'],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['gtBtnOptions'],
    'eval'      => ['multiple' => true, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['gtBtnFaq'] = [
    'inputType' => 'checkbox',
    'options'   => ['copy', 'cut', 'delete', 'show', 'versions'],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['gtBtnOptions'],
    'eval'      => ['multiple' => true, 'tl_class' => 'w50'],
];

// ─── Legende zur Palette hinzufügen ─────────────────────────────────────────

PaletteManipulator::create()
    ->addLegend('gt_backend_buttons_legend', 'global_legend', PaletteManipulator::POSITION_AFTER)
    ->addField(
        ['gtBtnPages', 'gtBtnArticles', 'gtBtnContent', 'gtBtnNews', 'gtBtnEvents', 'gtBtnMembers', 'gtBtnFaq'],
        'gt_backend_buttons_legend',
        PaletteManipulator::POSITION_APPEND
    )
    ->applyToPalette('default', 'tl_settings');
