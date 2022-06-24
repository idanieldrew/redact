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
            ]

        ]
    ]
];