<div>
    <x-slot name="title">
        Dashboard
    </x-slot>
    
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <x-dashboard.stat-card
                icon="bi-envelope-paper-heart"
                title="Surat Masuk Hari Ini"
                :value="$countSuratMasukToday"
                color="primary"
            />
        </div>
        <div class="col-12 col-md-4">
            <x-dashboard.stat-card
                icon="bi-send-check"
                title="Surat Keluar Hari Ini"
                :value="$countSuratKeluarToday"
                color="danger"
            />
        </div>
        <div class="col-12 col-md-4">
            <x-dashboard.stat-card
                icon="bi-pencil-square"
                title="Request Surat Hari Ini"
                :value="$countRequestSuratToday"
                color="success"
            />
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="card-title fw-bold">Grafik Aktivitas 7 Hari Terakhir</h5>
                </div>
                <div class="card-body p-4">
                    <div wire:ignore style="height: 320px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <x-dashboard.letter-list
                title="Surat Masuk Terbaru"
                :letters="$latestSuratMasuk"
                dateKey="created_at"
                mainKey="perihal"
                subKey="nomor_surat"
                icon="bi-arrow-down-left-circle"
                color="primary"
            />
        </div>
        <div class="col-lg-4">
            <x-dashboard.letter-list
                title="Surat Keluar Terbaru"
                :letters="$latestSuratKeluar"
                dateKey="created_at"
                mainKey="klasifikasi"
                subKey="nomor_surat"
                icon="bi-arrow-up-right-circle"
                color="danger"
            />
        </div>
        <div class="col-lg-4">
            <x-dashboard.letter-list
                title="Request Surat Terbaru"
                :letters="$latestRequestSurat"
                dateKey="created_at"
                mainKey="bidang"
                subKey="status"
                icon="bi-patch-question"
                color="success"
            />
        </div>
    </div>


    {{-- SCRIPT UNTUK GRAFIK DENGAN VISUAL BARU --}}
    @push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
            // ... (kode untuk mengambil data chart tetap sama) ...
            const chartLabels = @json($chartLabels);
            const chartSuratMasuk = @json($chartSuratMasuk);
            const chartSuratKeluar = @json($chartSuratKeluar);
            const chartRequestSurat = @json($chartRequestSurat);

            let weeklyChartInstance = null;
            if (weeklyChartInstance) {
                weeklyChartInstance.destroy();
            }
            const ctx = document.getElementById('weeklyChart');
            if (!ctx) return;
            
            // Definisikan gradient untuk setiap dataset
            const createGradient = (color) => {
                const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, `rgba(${color}, 0.3)`);
                gradient.addColorStop(1, `rgba(${color}, 0)`);
                return gradient;
            };

            weeklyChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Surat Masuk',
                        data: chartSuratMasuk,
                        borderColor: 'rgb(13, 110, 253)',
                        backgroundColor: createGradient('13, 110, 253'),
                        tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 7, pointHoverBorderWidth: 2, pointHoverBackgroundColor: '#fff'
                    }, {
                        label: 'Surat Keluar',
                        data: chartSuratKeluar,
                        borderColor: 'rgb(220, 53, 69)',
                        backgroundColor: createGradient('220, 53, 69'),
                        tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 7, pointHoverBorderWidth: 2, pointHoverBackgroundColor: '#fff'
                    }, {
                        label: 'Request Surat',
                        data: chartRequestSurat,
                        borderColor: 'rgb(25, 135, 84)',
                        backgroundColor: createGradient('25, 135, 84'),
                        tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 7, pointHoverBorderWidth: 2, pointHoverBackgroundColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { border: { dash: [5, 5] }, grid: { color: '#e9ecef' }, ticks: { precision: 0 } },
                        x: { grid: { display: false } }
                    },
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, padding: 20 } },
                        tooltip: { backgroundColor: '#212529', titleFont: { size: 14, weight: 'bold' }, bodyFont: { size: 12 }, padding: 12, cornerRadius: 6 }
                    },
                    interaction: { intersect: false, mode: 'index' }
                }
            });
        });
    </script>
    @endpush
</div>