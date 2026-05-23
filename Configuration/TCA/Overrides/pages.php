<?php
defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', [
    'tx_autorecordsview_force' => [
        'exclude' => true,
        'label' => 'LLL:EXT:autorecordsview/Resources/Private/Language/locallang_db.xlf:pages.tx_autorecordsview_force',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 0,
            'items' => [
                [
                    'label' => '',
                ]
            ],
        ]
    ]
]);

// Use the new TYPO3 v14 short form translation reference: core.form.tabs:behaviour
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    'tx_autorecordsview_force',
    '', // Empty string applies this to ALL doktypes (Pages, Folders, Shortcuts, etc.)
    'after:--div--;core.form.tabs:behaviour'
);