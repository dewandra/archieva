
<div>
    {{-- Atur Judul Halaman --}}
    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="header">
        
    </div>
    {{-- ===== cards ===== --}}
    <div class="row mb-4">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="card text-white bg-my-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Surat Masuk</h5>
                    <p class="card-text">{{ $cdmasuk }} Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="card text-white bg-my-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Surat Keluar</h5>
                    <p class="card-text">{{ $cdkeluar }} Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="card text-my-primary bg-my-info shadow">
                <div class="card-body">
                    <h5 class="card-title">Request Surat</h5>
                    <p class="card-text">{{ $cdrequest }} Hari ini</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== weekly chart ===== --}}
    <div class="card mb-4 shadow">
        <div class="card-body">
            <h5 class="card-title mb-3">Surat Masuk & Keluar Mingguan</h5>
            
            {{-- FIX 1: Typo 'wire:wire:ignore' menjadi 'wire:ignore' --}}
            <div wire:ignore>
                <canvas id="weeklyChart" style="height:300px;"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== table report surat masuk ===== --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <h5 class="card-title mb-3">Surat Masuk</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover text-white">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suratMasuk as $surat)
                                    <tr>
                                        <td>{{ $surat['tanggal'] }}</td>
                                        <td>{{ $surat['nomor'] }}</td>
                                        <td>{{ $surat['perihal'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {{-- Duplikat tabel untuk surat keluar (asumsi) --}}
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <h5 class="card-title mb-3">Surat Keluar (Contoh)</h5>
                    {{-- Ganti dengan data surat keluar jika ada --}}
                    <p class="text-white-50">Tabel data surat keluar bisa diletakkan di sini.</p>
                </div>
            </div>
        </div>
    </div>


    @script
    <script>
        let weeklyChartInstance = null;

        const renderWeeklyChart = (labels, masukData, keluarData, requestData) => {
            if (weeklyChartInstance) {
                weeklyChartInstance.destroy();
            }

            const ctx = document.getElementById('weeklyChart');
            if (!ctx) return;

            const chartData = {
                labels: labels,
                datasets: [{
                    label: 'Surat Masuk',
                    data: masukData,
                    borderColor: 'rgba(0, 123, 255, 1)',
                    backgroundColor: 'rgba(0, 123, 255, 0.2',
                    tension: 0.4
                }, {
                    label: 'Surat Keluar',
                    data: keluarData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4
                }, {
                    label: 'Request Surat',
                    data: requestData,
                    borderColor: 'rgba(25, 135, 84, 1)',
                    backgroundColor: 'rgba(25, 135, 84, 0.2)',
                    tension: 0.4
                }]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            };

            weeklyChartInstance = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: chartData,
                options: chartOptions
            });
        }

        // Inisialisasi chart hanya sekali saat halaman dimuat
        document.addEventListener('livewire:navigated', () => {
            renderWeeklyChart(@json($labels), @json($masuk), @json($keluar), @json($request));
        }, { once: true });

    </script>
    @endscript
</div> 