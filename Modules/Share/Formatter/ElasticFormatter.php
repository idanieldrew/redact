<?php

namespace Module\Share\Formatter;

use Monolog\Formatter\NormalizerFormatter;

class ElasticFormatter extends NormalizerFormatter
{
    public function format(array $record): string
    {
        $message = [
            '@timestamp' => $this->normalize($record['datetime']),
            'log' => [
                'level' => $record['level_name'],
                'logger' => $record['channel'],
            ],
        ];

        if (isset($record['message'])) {
            $message['message'] = $record['message'];
        }

        return $this->toJson($message) . "\n";
    }
}
