<?php

namespace App\Http\Controllers;

use App\Models\Youtube\Channel;
use App\Repositories\Youtube\YoutubeRepository;
use Exception;
use Illuminate\View\View;

class YoutubeController extends Controller
{
    /**
     * @var YoutubeRepository
     */
    private $youtubeRepository;

    /**
     * YoutubeController constructor.
     * @var YoutubeRepository $youtubeRepository
     */
    public function __construct(YoutubeRepository $youtubeRepository)
    {
        $this->youtubeRepository = $youtubeRepository;
    }

    /**
     * @return View
     * @throws Exception
     */
    public function show()
    {
        $this->youtubeRepository->scrapeVideosByChannels([Channel::TARGET_ID]);

        return view('youtube.show');
    }
}
