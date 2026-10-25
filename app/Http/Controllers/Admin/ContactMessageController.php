<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of inquiries.
     */
    public function index(Request $request): View
    {
        $settings = CompanySetting::current();
        $status = $request->query('status');

        $query = ContactMessage::query();

        if ($status === 'unread') {
            $query->where('is_read', false);
        } elseif ($status === 'read') {
            $query->where('is_read', true);
        }

        $messages = $query->latest()->paginate(10)->withQueryString();

        return view('admin.messages.index', compact('settings', 'messages', 'status'));
    }

    /**
     * Toggle read status of a message.
     */
    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $message->update(['is_read' => ! $message->is_read]);

        $status = $message->is_read ? 'marked as read' : 'marked as unread';

        return back()->with('success', "Message from {$message->name} has been {$status}.");
    }

    /**
     * Remove the message from storage.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Contact message deleted successfully.');
    }
}
