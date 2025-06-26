<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationIndicator extends Component
{    
    public $unreadCount = 0;

    /**
     * Menggunakan method getListeners() untuk mendefinisikan listener secara dinamis.
     * Ini memastikan auth()->id() hanya dipanggil saat user sudah login.
     *
     * @return array
     */
    public function getListeners(): array
    {
        // Pastikan user sudah login sebelum membuat channel pribadi
        if (!Auth::check()) {
            return [];
        }

        return [
            'notificationRead' => 'updateCount',
            // Membuat nama channel dinamis setelah user terautentikasi
            'echo-private:App.Models.User.'.Auth::id().',.Illuminate\Notifications\Events\DatabaseNotificationCreated' => 'updateCount',
        ];
    }

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
        }
    }

    public function getUnreadNotificationsProperty()
    {
        return Auth::check() ? Auth::user()->unreadNotifications()->limit(5)->get() : collect();
    }

    public function markAsRead($notificationId)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
            }
            $this->updateCount();
        }
        return redirect()->route('request-surat');
    }

    public function render()
    {
        return view('livewire.notification-indicator');
    }
}
