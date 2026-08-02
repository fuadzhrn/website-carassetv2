<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactMessages\UpdateContactMessageStatusRequest;
use App\Models\ContactMessage;
use App\Services\ContactMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function __construct(private readonly ContactMessageService $contactMessageService)
    {
    }

    /**
     * List messages, newest first, with search + status filter + pagination.
     * Never loads the whole table into memory.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        if (! in_array($status, ['all', ...ContactMessage::statuses()], true)) {
            $status = 'all';
        }

        $messages = ContactMessage::query()
            ->search($search !== '' ? mb_substr($search, 0, 100) : null)
            ->status($status)
            ->newest()
            ->paginate(config('contact-form.pagination', 20))
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Show one message's full detail. A GET request never changes status —
     * status only changes through updateStatus() (PATCH).
     */
    public function show(ContactMessage $contactMessage): View
    {
        return view('admin.messages.show', [
            'message' => $contactMessage->load('handledBy'),
        ]);
    }

    public function updateStatus(UpdateContactMessageStatusRequest $request, ContactMessage $contactMessage): RedirectResponse
    {
        $this->contactMessageService->changeStatus(
            $contactMessage,
            $request->validated('status'),
            $request->user(),
        );

        return redirect()->route('admin.messages.show', $contactMessage)
            ->with('success', 'Status pesan berhasil diperbarui.');
    }

    /**
     * Permanent delete — only ever allowed once a message is archived.
     */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        if ($contactMessage->status !== ContactMessage::STATUS_ARCHIVED) {
            return redirect()->route('admin.messages.show', $contactMessage)
                ->with('error', 'Arsipkan pesan sebelum melakukan penghapusan permanen.');
        }

        $this->contactMessageService->delete($contactMessage);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus secara permanen.');
    }
}
