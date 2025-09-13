<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function comingSoon()
    {
        // Anda bisa menerima parameter untuk menyesuaikan pesan jika perlu
        // $page = request('page', 'fitur');
        return view('coming-soon'); // atau 'pages.coming-soon' jika Anda menggunakan subfolder
    }
}
