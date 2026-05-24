<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Auto Records View',
    'description' => 'Automatically switches to records mode for specific pages in the TYPO3 backend.',
    'category' => 'be',
    'author' => 'Tanel Põld',
    'author_email' => 'tanel@brightside.ee',
    'author_company' => 'Brightside OÜ / t3brightside.com',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '0.1.1',
    'constraints' => [
        'depends' => [
            'typo3' => '14.0.0-14.99.99',
        ],
    ],
];