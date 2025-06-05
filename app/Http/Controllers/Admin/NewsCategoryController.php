<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCategoryRequest;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('xem-danh-muc-tin-tuc');
        $title = 'Danh sách loại tin tức';
        $categories = NewsCategory::orderByDesc('id')->paginate(15);
        return view('admin.news_category.list', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('them-danh-muc-tin-tuc');
        $title = 'Thêm loại tin tức';
        return view('admin.news_category.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsCategoryRequest $request)
    {
        $this->authorize('them-danh-muc-tin-tuc');
        try {
            NewsCategory::create([
                'name' => $request->name,
                'slug' => Helper::createSlug($request->name),
                'status' => $request->status
            ]);
            Session::flash('success', 'Tạo danh mục tin tức thành công');
            return redirect()->route('news-category.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi tạo');
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
        $this->authorize('sua-danh-muc-tin-tuc');
        $title = 'Chỉnh sửa loại tin tức';
        $category = NewsCategory::findOrFail($id);
        return view('admin.news_category.edit', compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsCategoryRequest $request, string $id)
    {
        $this->authorize('sua-danh-muc-tin-tuc');
        $newsCategory = NewsCategory::findOrFail($id);
        try {
            $newsCategory->update([
                'name' => $request->name,
                'slug' => Helper::createSlug($request->name),
                'status' => $request->status
            ]);
            Session::flash('success', 'Cập nhật danh mục tin tức thành công');
            return redirect()->route('news-category.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi cập nhật');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('xoa-danh-muc-tin-tuc');
        $newsCategory = NewsCategory::findOrFail($id);
        try{
            $newsCategory->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa danh mục thành công'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa danh mục'
            ]);
        }
    }
}
