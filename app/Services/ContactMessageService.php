<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Owns ContactMessage persistence and status transitions. Never sends
 * email, never contacts WhatsApp, never logs message content/WhatsApp/
 * email — only whitelisted, normalized fields ever reach the database.
 */
class ContactMessageService
{
    /**
     * @param array<string, mixed> $data validated + normalized fields:
     *   name, whatsapp, email, program, message
     */
    public function create(array $data, Request $request): ContactMessage
    {
        $message = new ContactMessage();
        $message->name = $data['name'];
        $message->whatsapp = $data['whatsapp'];
        $message->email = $data['email'];
        $message->program = $data['program'];
        $message->message = $data['message'];
        $message->consent = true;
        $message->consented_at = now();
        $message->status = ContactMessage::STATUS_NEW;

        if (config('contact-form.privacy.store_ip_address', false)) {
            $message->ip_address = $request->ip();
        }

        if (config('contact-form.privacy.store_user_agent', false)) {
            $message->user_agent = Str::limit((string) $request->userAgent(), 500, '');
        }

        $message->save();

        return $message;
    }

    /**
     * Applies one of the allowed status transitions and stamps the
     * corresponding timestamp(s) + handled_by. Never touches name/
     * whatsapp/email/program/message/consent/created_at.
     */
    public function changeStatus(ContactMessage $message, string $status, User $admin): ContactMessage
    {
        $now = now();

        switch ($status) {
            case ContactMessage::STATUS_READ:
                $message->read_at ??= $now;
                break;

            case ContactMessage::STATUS_COMPLETED:
                $message->read_at ??= $now;
                $message->completed_at = $now;
                $message->archived_at = null;
                break;

            case ContactMessage::STATUS_ARCHIVED:
                $message->archived_at = $now;
                break;
        }

        $message->status = $status;
        $message->handled_by = $admin->id;
        $message->save();

        return $message;
    }

    /**
     * Permanently deletes a message — callers must already have confirmed
     * status === archived (see ContactMessageController::destroy()).
     */
    public function delete(ContactMessage $message): void
    {
        $message->delete();
    }
}
