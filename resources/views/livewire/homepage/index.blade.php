<div>
    <x-slot name="title">
        Dashboard
    </x-slot>
    
    {{-- STAT CARDS dengan Warna UM --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <x-dashboard.stat-card
                icon="bi-envelope-paper-heart"
                title="Surat Masuk Hari Ini"
                :value="$countSuratMasukToday"
                color="um-primary-blue"
            />
        </div>
        <div class="col-12 col-md-4">
            <x-dashboard.stat-card
                icon="bi-send-check"
                title="Surat Keluar Hari Ini"
                :value="$countSuratKeluarToday"
                color="um-yellow"
            />
        </div>
        <div class="col-12 col-md-4">
            <x-dashboard.stat-card
                icon="bi-pencil-square"
                title="Request Surat Hari Ini"
                :value="$countRequestSuratToday"
                color="um-green"
            />
        </div>
    </div>

    {{-- GRAFIK --}}
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

    {{-- LETTER LISTS --}}
    <div class="row g-4">
        <div class="col-lg-4">
            <x-dashboard.letter-list
                title="Surat Masuk Terbaru"
                :letters="$latestSuratMasuk"
                dateKey="created_at"
                mainKey="perihal"
                subKey="nomor_surat"
                icon="bi-arrow-down-left-circle"
                color="um-primary-blue"
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
                color="um-yellow"
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
                color="um-green"
            />
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
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
            
            // Warna UM untuk chart
            const umColors = {
                primary: { rgb: '67, 89, 154', hex: '#43589A' },  // UM Blue
                yellow: { rgb: '254, 244, 0', hex: '#FEF400' },    // UM Yellow
                green: { rgb: '170, 210, 5', hex: '#AAD205' }      // UM Green
            };
            
            const createGradient = (rgbColor) => {
                const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, `rgba(${rgbColor}, 0.3)`);
                gradient.addColorStop(1, `rgba(${rgbColor}, 0)`);
                return gradient;
            };

            weeklyChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Surat Masuk',
                        data: chartSuratMasuk,
                        borderColor: umColors.primary.hex,
                        backgroundColor: createGradient(umColors.primary.rgb),
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 7,
                        pointHoverBorderWidth: 2,
                        pointHoverBackgroundColor: '#fff',
                        borderWidth: 2
                    }, {
                        label: 'Surat Keluar',
                        data: chartSuratKeluar,
                        borderColor: umColors.yellow.hex,
                        backgroundColor: createGradient(umColors.yellow.rgb), // PERBAIKAN: Pakai yellow
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 7,
                        pointHoverBorderWidth: 2,
                        pointHoverBackgroundColor: '#fff',
                        borderWidth: 2
                    }, {
                        label: 'Request Surat',
                        data: chartRequestSurat,
                        borderColor: umColors.green.hex,
                        backgroundColor: createGradient(umColors.green.rgb),
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 7,
                        pointHoverBorderWidth: 2,
                        pointHoverBackgroundColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            border: { dash: [5, 5] },
                            grid: { color: '#e9ecef' },
                            ticks: { precision: 0 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#212529',
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 6
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        });
    </script>
    @endpush
</div>