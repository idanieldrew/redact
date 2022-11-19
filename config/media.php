<?php

return [

    'media' => [

        'types' => [
            'image' => [
                'extensions' => [
                    'jpg',
                    'png'
                ],
                'handler' => \Module\Media\Services\v1\ImageService::class
            ],
            'video' => [
                'extensions' => [
                    'mp4'
                ],
                'handler' => \Module\Media\Services\v1\VideoService::class
            ]
        ]
    ]
];
