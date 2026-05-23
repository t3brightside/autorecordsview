<?php
return [
    'backend' => [
        't3brightside/autorecordsview/force-list-mode' => [
            'target' => \Brightside\Autorecordsview\Middleware\AutorecordsviewMiddleware::class,
            'after' => [
                'typo3/cms-backend/authentication',
                'typo3/cms-backend/backend-routing',
            ],
        ],
    ],
];