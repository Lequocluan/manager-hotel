<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function category($slug)
    {
        $category = NewsCategory::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }
        $news = $category->news()->orderByDesc('id')->where('status', 1)->paginate(12);
        $title = $category->name;
        return view('user.news.category', compact('title', 'news', 'category'));
    }
    public function blog_detail($slugCategory, $slugBlog)
    {
        $category = NewsCategory::where('slug', $slugCategory)->first();
        if (!$category) {
            abort(404);
        }
        $news = $category->news()->where('slug', $slugBlog)->first();
        if (!$news) {
            abort(404);
        }
        $news->load('newsCategories');

        $allCategories = NewsCategory::where('status', 1)->get();
        $title = 'Chi tiết tin tức';
        $recommendedNews = \App\Models\News::where('id', '!=', $news->id)
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('user.news.blog-detail', compact('title', 'news', 'category', 'allCategories', 'recommendedNews'));
    }

}
