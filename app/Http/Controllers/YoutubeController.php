<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\View\View;

class YoutubeController extends Controller
{
    /**
     * @return View
     * @throws Exception
     */
    public function show()
    {
        return view('youtube.show');
    }
}
