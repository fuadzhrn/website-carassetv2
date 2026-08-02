{{--
    Reusable destructive-action confirmation dialog, built on the native
    <dialog> element (same primitive as media-picker.blade.php) — Escape,
    focus-trap, and focus-return-to-invoker all come from the browser for
    free. The confirm action is a REAL form (POST + @method), never a
    JavaScript-driven fetch/delete.
--}}
@props([
    'id',
    'title' => 'Konfirmasi Tindakan',
    'message' => 'Tindakan ini tidak dapat dibatalkan.',
    'formAction',
    'formMethod' => 'DELETE',
    'confirmLabel' => 'Hapus Permanen',
    'triggerLabel' => 'Hapus Permanen',
    'triggerIcon' => 'trash-2',
    // 'danger' (default, e.g. permanent delete) or 'primary' (e.g.
    // Publish — a confirmed action, not a destructive one).
    'variant' => 'danger',
])

<button
    type="button"
    class="ca-admin-btn ca-admin-btn--{{ $variant }} ca-admin-btn--sm"
    data-confirm-dialog-open="{{ $id }}"
>
    <span class="ca-admin-btn__icon" data-lucide="{{ $triggerIcon }}" aria-hidden="true"></span>
    {{ $triggerLabel }}
</button>

<dialog class="ca-admin-modal" id="{{ $id }}" data-confirm-dialog aria-labelledby="{{ $id }}-title">
    <div class="ca-admin-modal__inner">
        <div class="ca-admin-modal__header">
            <h2 class="ca-admin-modal__title" id="{{ $id }}-title">{{ $title }}</h2>
            <button type="button" class="ca-admin-modal__close" data-confirm-dialog-close aria-label="Tutup">
                <span data-lucide="x" aria-hidden="true"></span>
            </button>
        </div>

        <p class="ca-admin-modal__description">{{ $message }}</p>

        <div class="ca-admin-confirm-dialog__actions">
            <button type="button" class="ca-admin-btn ca-admin-btn--ghost" data-confirm-dialog-close>
                Batal
            </button>

            <form method="POST" action="{{ $formAction }}">
                @csrf
                @if (strtoupper($formMethod) !== 'POST')
                    @method($formMethod)
                @endif
                <button type="submit" class="ca-admin-btn ca-admin-btn--{{ $variant }}">
                    {{ $confirmLabel }}
                </button>
            </form>
        </div>
    </div>
</dialog>
