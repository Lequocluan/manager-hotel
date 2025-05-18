<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $title = 'Trang chủ';
        $news = News::orderByDesc('id')->with('newsCategories')->where('status', 1) -> take(6) -> get();
        return view('user.home.home', compact('title', 'news'));
    }
}
