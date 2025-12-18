@extends('koor-pkl.layouts.app')

@section('title', 'SPK Penentuan Bobot & Rekomendasi')

@section('content')
<div class="container-fluid mt-4 flex-grow-1 px-4">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="spkTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ahp-tab" data-bs-toggle="tab" data-bs-target="#ahp-content" type="button" role="tab" aria-controls="ahp-content" aria-selected="true">
                <i class="fas fa-balance-scale me-2"></i>1. Pembobotan Kriteria (AHP)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="saw-tab" data-bs-toggle="tab" data-bs-target="#saw-content" type="button" role="tab" aria-controls="saw-content" aria-selected="false">
                <i class="fas fa-stream me-2"></i>2. Perankingan Alternatif (SAW)
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="spkTabsContent">
        <!-- AHP Tab -->
        <div class="tab-pane fade show active" id="ahp-content" role="tabpanel" aria-labelledby="ahp-tab">
            <div class="row">
                <div class="col-lg-7">
                    <!-- Step 1: Criteria Selection -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header" style="background: #113F67; color: white;">
                            <h5 class="mb-0"><i class="fas fa-check-square me-2"></i>Langkah 1: Pilih Kriteria</h5>
                        </div>
                        <div class="card-body">
                            <p>Pilih kriteria yang akan diikutsertakan dalam proses perhitungan bobot AHP.</p>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"><input type="checkbox" id="checkAllCriteria" class="form-check-input"></th>
                                        <th style="width: 10%;">Kode</th>
                                        <th>Nama Kriteria</th>
                                        <th style="width: 20%;">Tipe</th>
                                    </tr>
                                </thead>
                                <tbody id="criteriaSelectionTbody">
                                    @foreach($criteria as $criterion)
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input criteria-checkbox" value="{{ $criterion->id }}" data-code="{{ $criterion->code }}" data-name="{{ $criterion->name }}"></td>
                                        <td>{{ $criterion->code }}</td>
                                        <td>{{ $criterion->name }}</td>
                                        <td><span class="badge bg-{{ $criterion->type == 'benefit' ? 'success' : 'danger' }}">{{ ucfirst($criterion->type) }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button id="generateComparisonsBtn" class="btn btn-primary w-100"><i class="fas fa-arrow-right me-2"></i>Lanjutkan ke Perbandingan</button>
                        </div>
                    </div>

                    <!-- Step 2: Pairwise Comparison -->
                    <div class="card shadow-sm" id="pairwiseComparisonCard" style="display: none;">
                        <div class="card-header" style="background: #113F67; color: white;">
                             <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Langkah 2: Perbandingan Berpasangan</h5>
                        </div>
                        <div class="card-body">
                             <div id="alertContainerAHP"></div>
                             <div class="alert alert-info small">
                                <strong><i class="fas fa-info-circle me-2"></i>Skala Saaty:</strong> 1 (Sama) | 3 (Sedikit Lebih) | 5 (Lebih) | 7 (Sangat) | 9 (Mutlak)
                            </div>
                            <div id="comparisonContainer">
                                <!-- Dynamic content will be generated here -->
                            </div>
                             <div id="ahpLoading" class="text-center mt-2" style="display: none;">
                                <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                                <p class="mt-2">Menghitung bobot AHP...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results -->
                <div class="col-lg-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Hasil Bobot Kriteria</h5>
                        </div>
                        <div class="card-body">
                            <div id="criteriaResults">
                                <div class="text-center p-4 text-muted">Pilih kriteria dan lakukan perhitungan untuk melihat hasilnya.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SAW Tab -->
        <div class="tab-pane fade" id="saw-content" role="tabpanel" aria-labelledby="saw-tab">
            <div class="card shadow-sm">
                <div class="card-header" style="background: #113F67; color: white;">
                    <h5 class="mb-0"><i class="fas fa-award me-2"></i>Hasil Perankingan Tempat PKL (SAW)</h5>
                </div>
                <div class="card-body">
                    <div id="alertContainerSAW"></div>
                    <div class="d-flex justify-content-between mb-3">
                        <button id="calculateSawBtn" class="btn btn-primary"><i class="fas fa-play-circle me-2"></i>Mulai Proses Perankingan SAW</button>
                        <div id="sawLoading" style="display: none;">
                            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                            <span class="ms-2">Menghitung perankingan...</span>
                        </div>
                    </div>
                    <div id="sawResultsContainer">
                        <div class="alert alert-info">Klik tombol "Mulai Proses Perankingan" untuk melihat hasilnya.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script>
$(document).ready(function() {
    let selectedCriteria = [];

    // Check all criteria
    $('#checkAllCriteria').change(function() {
        $('.criteria-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Generate AHP comparison form
    $('#generateComparisonsBtn').click(function() {
        selectedCriteria = [];
        $('.criteria-checkbox:checked').each(function() {
            selectedCriteria.push({
                id: $(this).val(),
                name: $(this).data('name'),
                code: $(this).data('code')
            });
        });

        if (selectedCriteria.length < 2) {
            showAlert('Pilih minimal 2 kriteria untuk perbandingan.', 'warning', 'AHP');
            return;
        }

        let container = $('#comparisonContainer');
        container.empty();
        $('#pairwiseComparisonCard').slideDown();

        for (let i = 0; i < selectedCriteria.length; i++) {
            for (let j = i + 1; j < selectedCriteria.length; j++) {
                let c1 = selectedCriteria[i];
                let c2 = selectedCriteria[j];
                
                let comparisonBox = `
                <div class="ahp-comparison-box mb-3">
                    <label class="form-label">
                        <span class="fw-bold text-primary">${c1.name}</span> vs <span class="fw-bold text-success">${c2.name}</span>
                    </label>
                    <select class="form-select comparison-select" data-criteria1="${c1.id}" data-criteria2="${c2.id}" required>
                        <option value="">-- Pilih Nilai --</option>
                        <optgroup label="👑 ${c1.name} Lebih Penting">
                            <option value="9">9 - Mutlak</option><option value="7">7 - Sangat</option><option value="5">5 - Lebih</option><option value="3">3 - Sedikit</option>
                        </optgroup>
                        <optgroup label="⚖️ Sama Penting">
                            <option value="1" selected>1 - Sama Penting</option>
                        </optgroup>
                        <optgroup label="👑 ${c2.name} Lebih Penting">
                            <option value="0.333333">3 - Sedikit (1/3)</option><option value="0.2">5 - Lebih (1/5)</option><option value="0.142857">7 - Sangat (1/7)</option><option value="0.111111">9 - Mutlak (1/9)</option>
                        </optgroup>
                    </select>
                </div>`;
                container.append(comparisonBox);
            }
        }
        container.append('<button type="button" id="calculateAHPBtn" class="btn btn-success w-100"><i class="fas fa-calculator me-2"></i>Hitung & Simpan Bobot</button>');
    });

    // AHP Calculation (event delegation)
    $(document).on('click', '#calculateAHPBtn', function() {
        let isValid = true;
        $('.comparison-select').each(function() {
            if (!$(this).val()) { isValid = false; $(this).addClass('is-invalid'); } 
            else { $(this).removeClass('is-invalid'); }
        });
        
        if (!isValid) {
            showAlert('Harap isi semua nilai perbandingan!', 'danger', 'AHP');
            return;
        }
        
        let comparisons = [];
        $('.comparison-select').each(function() {
            comparisons.push({
                criteria_1_id: $(this).data('criteria1'),
                criteria_2_id: $(this).data('criteria2'),
                value: parseFloat($(this).val())
            });
        });

        let activeCriteriaIds = selectedCriteria.map(c => c.id);
        
        $.ajax({
            url: '{{ route("koor.api.ahp.calculate") }}',
            type: 'POST',
            data: {
                comparisons: comparisons,
                active_criteria_ids: activeCriteriaIds,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: () => { $('#ahpLoading').show(); $(this).prop('disabled', true); },
            success: (response) => {
                if (response.success) {
                    updateCriteriaTable(response.data.criteria_all);
                    let cr = response.data.consistency.consistency_ratio;
                    let msg = `<strong>Perhitungan Berhasil!</strong><br>${cr < 0.1 ? '✅' : '⚠️'} Konsistensi Rasio (CR) = ${cr.toFixed(4)}.`;
                    showAlert(msg, cr < 0.1 ? 'success' : 'warning', 'AHP');
                } else {
                    showAlert(response.message, 'danger', 'AHP');
                }
            },
            error: (xhr) => showAlert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Server error'), 'danger', 'AHP'),
            complete: () => { $('#ahpLoading').hide(); $(this).prop('disabled', false); }
        });
    });

    // Function to update criteria weights table
    function updateCriteriaTable(criteria) {
        let container = $('#criteriaResults');
        container.empty();
        if (!criteria || criteria.length === 0) {
            container.html('<div class="alert alert-info">Kriteria tidak ditemukan.</div>');
            return;
        }

        let totalWeight = criteria.reduce((sum, c) => sum + parseFloat(c.weight), 0);
        let table = $('<table class="table table-sm table-hover"></table>');
        table.append(`<thead><tr><th>Kriteria</th><th>Bobot</th><th>Persentase</th></tr></thead>`);
        
        let tbody = $('<tbody></tbody>');
        criteria.forEach(c => {
            let weight = parseFloat(c.weight);
            let percent = totalWeight > 0 ? (weight / totalWeight) * 100 : 0;
            tbody.append(`
            <tr>
                <td>${c.name} (${c.code})</td>
                <td>${weight.toFixed(4)}</td>
                <td>
                    <div class="progress" style="height: 20px;"><div class="progress-bar" style="width: ${percent.toFixed(2)}%;">${percent.toFixed(2)}%</div></div>
                </td>
            </tr>`);
        });
        table.append(tbody);
        container.append(table);
    }
    
    // Initial load
    (function loadInitialWeights() {
        $.get('{{ route("koor.api.criteria.weights") }}', response => {
            if(response.success) updateCriteriaTable(response.criteria);
        });
    })();

    // ===================================
    // SAW (Simple Additive Weighting)
    // ===================================
    $('#calculateSawBtn').click(function() {
        $.ajax({
            url: '{{ route("koor.api.saw.calculate") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            beforeSend: () => { $('#sawLoading').show(); $(this).prop('disabled', true); },
            success: (response) => {
                if (response.success) {
                    let container = $('#sawResultsContainer');
                    container.empty();
                    if (response.data && response.data.length > 0) {
                        let table = $('<table class="table table-hover table-striped"></table>');
                        table.append(`<thead class="table-light"><tr><th>Peringkat</th><th>Nama Tempat PKL</th><th>Skor Akhir</th></tr></thead>`);
                        let tbody = $('<tbody></tbody>');
                        response.data.forEach(item => {
                            tbody.append(`<tr>
                                <td><span class="badge bg-primary fs-6">${item.rank}</span></td>
                                <td><strong>${item.nama_tempat}</strong><br><small class="text-muted">${item.alamat}</small></td>
                                <td><span class="badge bg-success fs-6">${item.score.toFixed(4)}</span></td>
                            </tr>`);
                        });
                        table.append(tbody);
                        container.append(table);
                        showAlert('Perankingan SAW berhasil dibuat.', 'success', 'SAW');
                    } else {
                        container.html('<div class="alert alert-warning">Tidak ada data untuk diperingkatkan.</div>');
                    }
                } else {
                    showAlert(response.message, 'danger', 'SAW');
                }
            },
            error: (xhr) => showAlert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Server error'), 'danger', 'SAW'),
            complete: () => { $('#sawLoading').hide(); $(this).prop('disabled', false); }
        });
    });

    // ===================================
    // Utility
    // ===================================
    function showAlert(message, type, context) {
        let container = context === 'AHP' ? $('#alertContainerAHP') : $('#alertContainerSAW');
        container.empty().html(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`).hide().fadeIn(300);
    }
});
</script>
@endsection
