<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh sách tin tức';
        $news = News::orderByDesc('id')->with('newsCategories')->paginate(15);
        return view('admin.news.list', compact('title', 'news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm tin tức';
        $categories = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        return view('admin.news.add', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        try {
            $news = News::create([
                'title' => $request->title,
                'slug' => Helper::createSlug($request->title),
                'content' => $request->content,
                'status' => $request->status,
                'poster_id' => auth()->guard('admin')->id(),
                'image' => '/uploads/news/default.jpg',
                'category_id' => $request->category_id,
            ]);
            if ($request->file('image')) {
                $file = $request->file('image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('news'), $filename);

                if ($news->image && file_exists(public_path($news->image))) {
                    unlink(public_path($news->image));
                }
                $news->image = '/news/' . $filename;
                $news->save();
            }
            Session::flash('success', 'Thêm mới tin tức thành công');
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi tạo' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Chỉnh sửa tin tức';
        $news = News::findOrFail($id);
        $categories = NewsCategory::where('status', 1)->orderByDesc('id')->get();
        return view('admin.news.edit', compact('title', 'news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, string $id)
    {
        $news = News::findOrFail($id);
        try {
            $news->update([
                'title' => $request->title,
                'slug' => Helper::createSlug($request->title),
                'content' => $request->content,
                'status' => $request->status,
                'category_id' => $request->category_id,
            ]);
            if ($request->file('image')) {
                $file = $request->file('image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('news'), $filename);

                if ($news->image && file_exists(public_path($news->image))) {
                    unlink(public_path($news->image));
                }
                $news->image = '/news/' . $filename;
                $news->save();
            }
            Session::flash('success', 'Cập nhật tin tức thành công');
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi cập nhật tin tức' . $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);
        try {
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }
            $news->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa tin tức thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tin tức'
            ]);
        }
    }
}
