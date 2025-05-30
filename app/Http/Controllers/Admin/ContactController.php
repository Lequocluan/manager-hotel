<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $title ='Danh sách phản hồi của khách hàng.';
        $contacts = Contact::latest()->get();
        return view('admin.contacts.index', compact('title','contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['seen' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required',
        ]);

        $contact = Contact::findOrFail($id);
        $messageContent = $request->reply_message;

        Mail::to($contact->email)->queue(new ContactReplyMail($contact, $messageContent));

        $contact->update(['replied' => true]);

        return redirect()->route('admin.contacts.index')->with('success', 'Phản hồi đã được gửi thành công.');
    }
    public function destroy(string $id){
        $contact = Contact::find($id);
        try{
            $contact ->delete();
            return response([
                'success' => true,
                'message' => 'Xóa liên hệ thành công.',
            ]);
        }catch(\Exception $e){
            return response([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e,]);
        }
    }
}
