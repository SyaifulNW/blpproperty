<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Database Calon Pembeli BLP Property</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Product+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS for spacing/utilities -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f0ebf8;
            font-family: 'Roboto', sans-serif;
            color: #202124;
            padding: 12px 0 48px;
        }

        .form-container {
            max-width: 640px;
            margin: 0 auto;
        }

        /* Top Accent Card */
        .header-card {
            background-color: #ffffff;
            border-radius: 8px;
            border-top: 10px solid #673ab7;
            padding: 24px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        }

        .header-title {
            font-family: 'Product Sans', 'Roboto', sans-serif;
            font-size: 32px;
            font-weight: 400;
            line-height: 40px;
            margin-bottom: 8px;
            color: #202124;
        }

        .header-description {
            font-size: 14px;
            color: #5f6368;
            margin-top: 16px;
            line-height: 20px;
        }

        .required-indicator {
            color: #d93025;
            font-size: 14px;
        }

        /* Question Cards */
        .question-card {
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid #dadce0;
            padding: 24px;
            margin-bottom: 12px;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15);
            transition: border-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .question-card.active {
            border-color: #673ab7;
            box-shadow: 0 2px 6px 2px rgba(103, 58, 183, 0.15);
        }

        .question-label {
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 0.1px;
            line-height: 24px;
            color: #202124;
            margin-bottom: 12px;
        }

        /* Form Controls Styled Like Google Forms */
        .gform-input-text {
            width: 100%;
            border: none;
            border-bottom: 1px solid #dadce0;
            padding: 8px 0;
            font-size: 14px;
            line-height: 20px;
            background: transparent;
            outline: none;
            transition: border-bottom-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gform-input-text:focus {
            border-bottom: 2px solid #673ab7;
        }

        /* Custom Dropdown/Select Styling */
        .gform-select {
            width: 100%;
            max-width: 250px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            padding: 10px 16px;
            font-size: 14px;
            color: #202124;
            background-color: #ffffff;
            outline: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .gform-select:focus {
            border-color: #673ab7;
            background-color: #f8f9fa;
        }

        /* Submit Button */
        .btn-submit {
            background-color: #673ab7;
            color: #ffffff;
            font-weight: 500;
            padding: 10px 24px;
            border-radius: 4px;
            border: none;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15);
            transition: background-color 0.2s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            background-color: #512da8;
            box-shadow: 0 2px 6px 2px rgba(60,64,67,0.15);
        }

        .btn-clear {
            color: #673ab7;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            background: none;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .btn-clear:hover {
            background-color: rgba(103, 58, 183, 0.04);
            color: #512da8;
        }

        /* Error Messages */
        .invalid-feedback {
            display: block;
            color: #d93025;
            font-size: 12px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>
</head>
<body>

    <div class="container py-2">
        <div class="form-container">
            
            <form action="{{ route('public.form-leads.submit') }}" method="POST" id="leadForm">
                @csrf
                <input type="hidden" name="sales" value="{{ $salesName }}">

                <!-- Header Card -->
                <div class="header-card">
                    <h1 class="header-title">Formulir Database Calon Pembeli BLP Property {{ $salesName ? '- Sales ' . $salesName : '' }}</h1>
                    <div class="header-description">
                        Silakan lengkapi formulir di bawah ini dengan data calon pembeli BLP Property secara akurat. Data yang Anda kirim akan langsung terintegrasi secara aman ke dalam sistem database kami.
                    </div>
                    <div class="border-top mt-3 pt-3 required-indicator">
                        * Menunjukkan pertanyaan yang wajib diisi
                    </div>
                </div>

                <!-- Nama Lengkap Card -->
                <div class="question-card" onclick="focusInput(this, 'nama')">
                    <div class="question-label">Nama Lengkap <span class="required-indicator">*</span></div>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           class="gform-input-text @error('nama') is-invalid @enderror" 
                           placeholder="Jawaban Anda" 
                           value="{{ old('nama') }}"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- No Whatsapp Card -->
                <div class="question-card" onclick="focusInput(this, 'no_wa')">
                    <div class="question-label">No Whatsapp <span class="required-indicator">*</span></div>
                    <input type="text" 
                           id="no_wa" 
                           name="no_wa" 
                           class="gform-input-text @error('no_wa') is-invalid @enderror" 
                           placeholder="Jawaban Anda" 
                           value="{{ old('no_wa') }}"
                           required>
                    @error('no_wa')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Sumber Leads Card -->
                <div class="question-card">
                    <div class="question-label">Sumber Leads <span class="required-indicator">*</span></div>
                    <select name="leads" id="leads" class="gform-select @error('leads') is-invalid @enderror" required>
                        <option value="" disabled {{ old('leads') ? '' : 'selected' }}>Pilih</option>
                        @foreach($leadSources as $ls)
                            <option value="{{ $ls->name }}" {{ old('leads') == $ls->name ? 'selected' : '' }}>{{ $ls->name }}</option>
                        @endforeach
                    </select>
                    @error('leads')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Jenis Produk (Kelas) Card -->
                <div class="question-card">
                    <div class="question-label">Jenis Produk <span class="required-indicator">*</span></div>
                    <select name="kelas_id" id="kelas_id" class="gform-select @error('kelas_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('kelas_id') ? '' : 'selected' }}>Pilih</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ old('kelas_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="invalid-feedback">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Submit and Clear Row -->
                <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                    <button type="submit" class="btn btn-submit">Kirim</button>
                    <button type="reset" class="btn-clear" onclick="clearForm()">Kosongkan formulir</button>
                </div>

            </form>

        </div>
    </div>

    <script>
        // Visual indicator when card input is focused
        function focusInput(card, inputId) {
            document.querySelectorAll('.question-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            document.getElementById(inputId).focus();
        }

        // Add focus listener for active class
        document.querySelectorAll('.gform-input-text, .gform-select').forEach(input => {
            input.addEventListener('focus', function() {
                document.querySelectorAll('.question-card').forEach(c => c.classList.remove('active'));
                this.closest('.question-card').classList.add('active');
            });
        });

        // Clear Form helper
        function clearForm() {
            if (confirm("Apakah Anda yakin ingin mengosongkan formulir?")) {
                document.getElementById('leadForm').reset();
                document.querySelectorAll('.question-card').forEach(c => c.classList.remove('active'));
            }
        }
    </script>
</body>
</html>
