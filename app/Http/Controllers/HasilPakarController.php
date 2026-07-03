<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPakar;


class HasilPakarController extends Controller
{
    public function indexLaporan()
    {
        return view('report.index');
    }
}
