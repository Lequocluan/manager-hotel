<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
public function index(Request $request)
{
    $title = 'Danh sách các liên hệ';
    $query = Contact::query();

    if ($request->has('replied') && $request->filled('replied')) {
        if ($request->replied === '1') {
            $query->where('replied', true);
        } elseif ($request->replied === '0') {
            $query->where('replied', false);
        }
    }

    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('subject', 'like', "%{$keyword}%");
        });
    }

    $contacts = $query->latest()->paginate(10);
    
    /** @var \Illuminate\Pagination\LengthAwarePaginator $contacts */
    $contacts->withQueryString();
    return view('admin.contacts.index', compact('title', 'contacts'));
}

    public function show($id)
    {
        $this->authorize('xem-lien-he');
        $contact = Contact::findOrFail($id);
        $contact->update(['seen' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $this->authorize('dap-lien-he');
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
        $this->authorize('xoa-lien-he');
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
