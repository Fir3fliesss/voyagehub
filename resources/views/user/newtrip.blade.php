@extends('layouts.main')

@section('content')
    <style>
        /* === Internal CSS === */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .card-header {
            background: linear-gradient(to right, #059669, #047857);
            padding: 16px;
            color: white;
        }
        .card-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .form-section {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
        }
        .form-section h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #111827;
        }
        .form-section p {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }
        label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            display: block;
            margin-bottom: 6px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 2px rgba(5,150,105,0.2);
        }
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
            border: none;
        }
        .btn-primary {
            background: #059669;
            color: white;
        }
        .btn-primary:hover {
            background: #047857;
        }
        .btn-secondary {
            background: #f9fafb;
            border: 1px solid #d1d5db;
            color: #374151;
        }
        .btn-secondary:hover {
            background: #f3f4f6;
        }
        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .main-header {
            background:#fff;
            border-bottom:1px solid #e5e7eb;
            position:sticky;
            top:0;
            z-index:10;
            box-shadow:0 2px 4px rgba(0,0,0,0.1);
        }
        .main-header .wrapper {
            padding:16px 24px;
            display:flex;
            gap:16px;
            align-items:center;
            justify-content: space-between;
        }
        .main-header h1 {
            font-size:20px;
            font-weight:700;
            color:#111827;
        }
        .content-area {
            padding:24px;
            max-width:800px;
            margin:auto;
        }
    </style>

    <header class="main-header">
        <div class="wrapper">
            <h1>Add New Trip</h1>
            <a href="{{ route('journeys.index') }}" class="btn btn-secondary">Back to Trips</a>
        </div>
    </header>

    <div class="content-area">
        <div class="card">
            <div class="card-header">
                <h2>Trip Information</h2>
                <p style="color:#d1fae5;font-size:13px;margin-top:4px;">Fill in the details for your business trip</p>
            </div>

            <div style="padding:32px;">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if($errors->any())
                    <div class="alert-error">
                        <strong>Please fix the following errors:</strong>
                        <ul style="margin-top:8px;padding-left:20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('journeys.store') }}" method="POST" style="display:flex;flex-direction:column;gap:24px;">
                    @csrf

                    {{-- Basic Information --}}
                    <div class="form-section">
                        <h3>Travel Request</h3>
                        <p>Pilih travel request yang sudah disetujui untuk dibuat tripnya</p>
                    </div>

                    <div>
                        <label for="travel_request_id">Pilih Travel Request yang Disetujui <span style="color:red">*</span></label>
                        <select id="travel_request_id" name="travel_request_id" required>
                            <option value="">-- Pilih Travel Request --</option>
                            @foreach($approvedRequests as $request)
                                <option value="{{ $request->id }}"
                                        data-purpose="{{ $request->purpose }}"
                                        data-destination="{{ $request->destination }}"
                                        data-start-date="{{ $request->start_date->format('Y-m-d') }}"
                                        data-end-date="{{ $request->end_date->format('Y-m-d') }}"
                                        data-budget="{{ $request->budget }}"
                                        {{ old('travel_request_id') == $request->id ? 'selected' : '' }}>
                                    {{ $request->purpose }} - {{ $request->destination }}
                                    ({{ $request->start_date->format('d M Y') }} - {{ $request->end_date->format('d M Y') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Trip Details (Auto-filled from selected travel request) --}}
                    <div class="form-section">
                        <h3>Detail Trip</h3>
                        <p>Informasi ini otomatis terisi dari travel request yang dipilih</p>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div>
                            <label for="display_purpose">Judul Trip</label>
                            <input type="text" id="display_purpose" readonly style="background-color: #f9fafb; color: #6b7280;" placeholder="Akan otomatis terisi">
                        </div>

                        <div>
                            <label for="display_destination">Destination</label>
                            <input type="text" id="display_destination" readonly style="background-color: #f9fafb; color: #6b7280;" placeholder="Akan otomatis terisi">
                        </div>

                        <div>
                            <label for="display_start_date">Start Date</label>
                            <input type="date" id="display_start_date" readonly style="background-color: #f9fafb; color: #6b7280;">
                        </div>

                        <div>
                            <label for="display_end_date">End Date</label>
                            <input type="date" id="display_end_date" readonly style="background-color: #f9fafb; color: #6b7280;">
                        </div>
                    </div>

                    {{-- Travel Details --}}
                    <div class="form-section">
                        <h3>Travel Details</h3>
                        <p>Transportation and accommodation information</p>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div>
                            <label for="transport">Transportation</label>
                            <input type="text" id="transport" name="transport" value="{{ old('transport') }}">
                        </div>

                        <div>
                            <label for="accommodation">Accommodation</label>
                            <input type="text" id="accommodation" name="accommodation" value="{{ old('accommodation') }}">
                        </div>

                        <div style="grid-column:1/3;">
                            <label for="budget">Budget (IDR)</label>
                            <input type="number" id="budget" name="budget" value="{{ old('budget') }}" step="0.01" placeholder="Kosongkan jika menggunakan budget dari travel request">
                        </div>
                    </div>

                    {{-- Additional Notes --}}
                    <div class="form-section">
                        <h3>Additional Information</h3>
                        <p>Any additional notes or special requirements</p>
                    </div>

                    <div>
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                    </div>

                    <div style="display:flex;gap:12px;justify-content:flex-end;">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Trip</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Auto-fill form berdasarkan travel request yang dipilih
    document.getElementById('travel_request_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value) {
            // Isi field display yang readonly
            document.getElementById('display_purpose').value = selectedOption.getAttribute('data-purpose');
            document.getElementById('display_destination').value = selectedOption.getAttribute('data-destination');
            document.getElementById('display_start_date').value = selectedOption.getAttribute('data-start-date');
            document.getElementById('display_end_date').value = selectedOption.getAttribute('data-end-date');

            // Set placeholder untuk budget jika kosong
            const budgetField = document.getElementById('budget');
            if (!budgetField.value) {
                const requestBudget = selectedOption.getAttribute('data-budget');
                budgetField.placeholder = `Default: Rp ${Number(requestBudget).toLocaleString('id-ID')}`;
            }
        } else {
            // Clear semua field jika tidak ada yang dipilih
            document.getElementById('display_purpose').value = '';
            document.getElementById('display_destination').value = '';
            document.getElementById('display_start_date').value = '';
            document.getElementById('display_end_date').value = '';
            document.getElementById('budget').placeholder = 'Kosongkan jika menggunakan budget dari travel request';
        }
    });

    // Trigger change event jika ada nilai yang sudah terpilih (untuk old input)
    window.addEventListener('load', function() {
        const travelRequestSelect = document.getElementById('travel_request_id');
        if (travelRequestSelect.value) {
            travelRequestSelect.dispatchEvent(new Event('change'));
        }
    });
    </script>
@endsection
