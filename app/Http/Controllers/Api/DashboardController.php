<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        $content    = "Made from 100% Spanish Iberico Pork from a certified and controlled farm, 
        these selected meats are superior in flavour, texture and aroma. They are also a good source of
         unsaturated fatty acids and oleic acid.  \t\t\t\t\t\t\r\n  \t\t\t\t\t\t\r\n  \t\t\t\t\t\t- 
         Spanish Iberico Ham 1KG  \t\t\t\t\t\t\r\n  \t\t\t\t\t\t- 
        Spanish Iberico Sausages 1.2KG  \t\t\t\t\t\t\r\n  \t\t\t\t\t\t- Spanish Iberico Jumbo Ribs 1.7KG";

        return response()->json($content);
    }
}
