<?php

namespace Module\Media\Jobs;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForDownloading implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $media)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lowBitrateFormat = (new X264)->setKiloBitrate(500);

        FFMpeg::fromDisk('local')
            ->open($this->media->files)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(960, 540));
            })
            ->export()
            ->toDisk('public')
            ->inFormat($lowBitrateFormat)
            ->save("download-" . $this->media->name);
        
        $this->media->update([
            'converted_for_downloading_at' => now(),
        ]);
    }
}
