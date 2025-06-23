
// Impor library yang dibutuhkan jika perlu (contoh: SweetAlert)
import Swal from 'sweetalert2';
import * as bootstrap from 'bootstrap';

export function initAppListeners() { // Atau initAppListeners jika Anda mengganti namanya
    // Listener untuk MEMBUKA modal secara dinamis
    document.addEventListener('open-modal', (event) => {
        // Ambil nama modal dari event yang dikirim Livewire
        const modalName = event.detail.name;
        if (!modalName) return;

        const modalElement = document.getElementById(modalName);
        if (modalElement) {
            // Ambil atau buat instance modal Bootstrap dan tampilkan
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
            modalInstance.show();
        }
    });

    // Listener untuk MENUTUP modal secara dinamis
    document.addEventListener('close-modal', (event) => {
        const modalName = event.detail.name;
        if (!modalName) return;

        const modalElement = document.getElementById(modalName);
        if (modalElement) {
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    });


    // Listener untuk notifikasi sukses (SweetAlert2)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    document.addEventListener('swal:success', (event) => {
        const { message } = event.detail;
        Toast.fire({
            icon: 'success',
            title: message
        });
    });

    // Listener untuk konfirmasi hapus (SweetAlert2)
    document.addEventListener('swal:confirm', (event) => {
        const { id, title, text, confirmButtonText, cancelButtonText } = event.detail;

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim event 'destroy' kembali ke komponen Livewire yang memanggil
                Livewire.dispatch('destroy', { id: id });
            }
        });
    });
}


// Bungkus semua logika dalam sebuah fungsi yang bisa diekspor
// export function initAppListeners() {
//     // ------------------ PENGATURAN MODAL ------------------
//     const userModalElement = document.getElementById('user-modal');
//     let userModal; // Definisikan di luar scope agar bisa diakses listener

//     if (userModalElement) {
//         userModal = new bootstrap.Modal(userModalElement);
//     }

//     // Gunakan document untuk event delegation karena Livewire bisa merender ulang DOM
//     // Ini lebih aman daripada listener biasa
//     document.addEventListener('open-modal', (event) => {
//         if (event.detail.name === 'user-modal' && userModal) {
//             userModal.show();
//         }
//     });

//     document.addEventListener('close-modal', (event) => {
//         if (event.detail.name === 'user-modal' && userModal) {
//             userModal.hide();
//         }
//     });


//     const Toast = Swal.mixin({
//         toast: true,
//         position: 'top-end',
//         showConfirmButton: false,
//         timer: 3000,
//         timerProgressBar: true,
//         didOpen: (toast) => {
//             toast.onmouseenter = Swal.stopTimer;
//             toast.onmouseleave = Swal.resumeTimer;
//         }
//     });

//     document.addEventListener('swal:success', (event) => {
//         const { message } = event.detail;
//         Toast.fire({
//             icon: 'success',
//             title: message
//         });
//     });

//      document.addEventListener('swal:confirm', (event) => {

//         // Ambil data dari event yang dikirim backend
//         const { id, title, text, confirmButtonText, cancelButtonText } = event.detail;

//         Swal.fire({
//             title: title, // Gunakan title dari event
//             text: text,   // Gunakan text dari event
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#d33',
//             cancelButtonColor: '#3085d6',
//             confirmButtonText: confirmButtonText,
//             cancelButtonText: cancelButtonText,
//         }).then((result) => {
//             // Jika pengguna menekan tombol "Ya, hapus!"
//             if (result.isConfirmed) {
//                 Livewire.dispatch('destroy', { id: id });

//             }
//         });
//     });
// }