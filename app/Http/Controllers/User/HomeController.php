<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\News;
use App\Models\RoomType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $title = 'Trang chủ';
        $news = News::orderByDesc('id')->with('newsCategories')->where('status', 1) -> take(6) -> get();
        $roomTypes = RoomType::where('status', 1)->take(4)->get();
        $aboutUs = News::where('status', 1)
                   ->whereHas('newsCategories', function($query) {
                       $query->where('slug', 'about-us');})
                   ->latest()
                   ->first();
        return view('user.home.home', compact('title', 'news', 'roomTypes', 'aboutUs'));
    }
    public function listRoomTypes(){
        $title = 'Danh sách loại phòng';
        $roomTypes = RoomType::where('status', 1)->with('images')->paginate(6);
        return view('user.roomtypes.list', compact('title', 'roomTypes'));
    }
    
    public function roomtypeDetail($slug){
        $roomType = RoomType::where('slug', $slug)->first();
        $title = 'Phòng '. $roomType->name;
        $ortherRoomTypes = RoomType::where('slug', '!=', $slug)->where('status', 1)->take(4)->get();
        if($roomType){
            return view('user.roomtypes.detail', compact('title', 'roomType', 'ortherRoomTypes'));
        }else{
            return redirect()->route('home') -> with('error', 'Không tìm thấy loại phòng');
        }
        
    }
    public function aboutUs(){
        $title = 'Về chúng tôi - Havana Hotel';
        return view('user.home.about_us', compact('title'));
    }
    
    public function contact(){
        $title = 'Liên hệ với chúng tôi - Havana Hotel';
        return view('user.home.contact', compact('title'));
    }
    public function store(Request $request)
    {
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi liên hệ!');
    }
}