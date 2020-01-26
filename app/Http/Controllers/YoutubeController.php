<?php

namespace App\Http\Controllers;

use App\Repository\Youtube\YoutubeRepository;
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
     */
    public function show()
    {
        $this->youtubeRepository->getVideoInfoById();

        return view('youtube.show');
    }
}
