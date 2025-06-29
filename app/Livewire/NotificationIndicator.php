<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationIndicator extends Component
{    
    public $unreadCount = 0;

    /**
     * getListeners digunakan untuk event dari luar, seperti notifikasi real-time.
     */
    public function getListeners(): array
    {
        if (!Auth::check()) {
            return [];
        }

        return [
            'notificationRead' => 'updateCount',
            'echo-private:App.Models.User.'.Auth::id().',.Illuminate\Notifications\Events\DatabaseNotificationCreated' => 'updateCount',
        ];
    }

    /**
     * FUNGSI UTAMA: Dipanggil saat tombol notifikasi diklik.
     * Menandai semua sebagai dibaca dan langsung mengupdate angka di tampilan.
     */
    public function openAndMarkAllAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->updateCount(); // Perbarui angka setelah ditandai
        }
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
        // Menghapus limit untuk menampilkan semua notifikasi
        return Auth::check() ? Auth::user()->unreadNotifications : collect();
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