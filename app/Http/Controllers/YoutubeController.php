<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class YoutubeController extends Controller
{
    /**
     * @return View
     */
    public function show()
    {
        return view('youtube.show');
    }
}
