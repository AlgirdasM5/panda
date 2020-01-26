<?php

namespace App\Console\Commands;

use App\Models\Youtube\Channel;
use App\Repositories\Youtube\YoutubeRepository;
use Exception;
use Illuminate\Console\Command;

class ScrapeYoutube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:youtube';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape youtube for video statistics';

    /**
     * @var YoutubeRepository
     */
    private $youtubeRepository;

    /**
     * ScrapeYoutube constructor.
     * @var YoutubeRepository $youtubeRepository
     */
    public function __construct(YoutubeRepository $youtubeRepository)
    {
        parent::__construct();
        $this->youtubeRepository = $youtubeRepository;
    }

    /**
     *
     */
    public function handle()
    {
        $this->info('Youtube scraping started');

        try {
            $this->youtubeRepository->scrapeVideosByChannels([Channel::TARGET_ID]);
        } catch (Exception $e) {
            $this->error('Youtube scraping failed', $e->getMessage());
        }

        $this->info('Youtube scraping end');
    }
}
