<?php

namespace App\Console\Commands;

use App\Factories\Youtube\YoutubeFactory;
use App\Models\Youtube\Channel;
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
     * @var YoutubeFactory
     */
    private $youtubeFactory;

    /**
     * ScrapeYoutube constructor.
     * @var YoutubeFactory $youtubeFactory
     */
    public function __construct(YoutubeFactory $youtubeFactory)
    {
        parent::__construct();
        $this->youtubeFactory = $youtubeFactory;
    }

    /**
     *
     */
    public function handle()
    {
        $this->info('Youtube scraping started');

        try {
            $this->youtubeFactory->scrapeVideosByChannels([Channel::TARGET_ID]);
        } catch (Exception $e) {
            $this->error('Youtube scraping failed', $e->getMessage());
        }

        $this->info('Youtube scraping end');
    }
}
