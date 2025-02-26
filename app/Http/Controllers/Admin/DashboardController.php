<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        $title = "Admin -Trang chủ";
        return view("admin.home.dashboard", compact('title'));
    }
}
