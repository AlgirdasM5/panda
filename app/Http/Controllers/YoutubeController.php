<?php

namespace App\Http\Controllers;

use App\Factories\Youtube\YoutubeFactory;
use App\Models\Youtube\Channel;
use Exception;
use Illuminate\View\View;

class YoutubeController extends Controller
{
    /**
     * @var YoutubeFactory
     */
    private $youtubeFactory;

    /**
     * YoutubeController constructor.
     * @var YoutubeFactory $youtubeFactory
     */
    public function __construct(YoutubeFactory $youtubeFactory)
    {
        $this->youtubeFactory = $youtubeFactory;
    }

    /**
     * @return View
     * @throws Exception
     */
    public function show()
    {
        $this->youtubeFactory->scrapeVideosByChannels([Channel::TARGET_ID]);

        return view('youtube.show');
    }
}
