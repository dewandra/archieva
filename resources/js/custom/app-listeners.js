// Impor library yang dibutuhkan jika perlu (contoh: SweetAlert)
import Swal from "sweetalert2";
import * as bootstrap from "bootstrap";

export function initAppListeners() {
    document.addEventListener("open-modal", (event) => {
        // Ambil nama modal dari event yang dikirim Livewire
        const modalName = event.detail.name;
        if (!modalName) return;

        const modalElement = document.getElementById(modalName);
        if (modalElement) {
            const modalInstance =
                bootstrap.Modal.getOrCreateInstance(modalElement);
            modalInstance.show();
        }
    });

    // Listener untuk MENUTUP modal secara dinamis
    document.addEventListener("close-modal", (event) => {
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

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });

    document.addEventListener("swal:success", (event) => {
        const { message } = event.detail;
        Toast.fire({
            icon: "success",
            title: message,
        });
    });

    window.addEventListener("swal:error", (event) => {
        Swal.fire({
            title: "Gagal!",
            text: event.detail.message,
            icon: "error",
            confirmButtonColor: "#3085d6",
        });
    });

window.addEventListener("swal:confirm-delete", (event) => {
    Swal.fire({
        title: "Anda Yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus Saja!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch("delete-request-confirmed", { requestId: event.detail.requestId });
        }
    });
});

    // Listener untuk konfirmasi hapus (SweetAlert2)
    document.addEventListener("swal:confirm", (event) => {
        const { id, title, text, confirmButtonText, cancelButtonText } =
            event.detail;

        Swal.fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("destroy", { id: id });
            }
        });
    });
}