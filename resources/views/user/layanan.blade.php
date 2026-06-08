@extends('layouts.user')

@section('content')
{{-- ============================================================
     Layanan Saran & Masukan — Redesign
     Requires: Tailwind CSS + Tabler Icons (atau pakai style manual di bawah)
     ============================================================ --}}

@if(session('success'))
    <div class="toast show" id="toast">
        <i class="ti ti-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

<div class="lsm-page">
    <p class="lsm-title">Layanan Saran & Masukan</p>
    <p class="lsm-sub">Silakan kirim saran, masukan, atau aduan untuk membantu meningkatkan pelayanan kelurahan.</p>

    {{-- Toast (dipicu JS, bukan session) --}}
    <div class="toast" id="toast" role="alert" aria-live="polite">
        <i class="ti ti-circle-check" aria-hidden="true"></i>
        Masukan berhasil dikirim. Terima kasih!
    </div>

    <form action="{{ route('user.layanan.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="lsmForm"
          class="lsm-card">
        @csrf

        {{-- NAMA --}}
        <div class="lsm-field">
            <label for="nama" class="lsm-label">Nama</label>
            <input type="text"
                   id="nama"
                   name="nama"
                   class="lsm-input"
                   placeholder="Nama lengkap (opsional)"
                   value="{{ old('nama') }}">
        </div>

        {{-- ANONIM --}}
        <div class="lsm-field">
            <label class="lsm-label">Identitas</label>
            <div class="lsm-anon-row" onclick="toggleAnon()">
                <input type="checkbox"
                       id="anonim"
                       name="anonim"
                       value="1"
                       checked>
                <span>Kirim sebagai anonim</span>
                <span class="lsm-anon-hint" id="anonHint">Nama tidak akan ditampilkan</span>
            </div>
        </div>

        {{-- KATEGORI --}}
        <div class="lsm-field">
            <label class="lsm-label">Kategori</label>
            <div class="lsm-kat-grid">
                <div class="lsm-kat-btn active" onclick="setKat(this, 'Saran')">
                    <i class="ti ti-bulb" aria-hidden="true"></i>
                    Saran
                </div>
                <div class="lsm-kat-btn" onclick="setKat(this, 'Masukan')">
                    <i class="ti ti-message-dots" aria-hidden="true"></i>
                    Masukan
                </div>
                <div class="lsm-kat-btn" onclick="setKat(this, 'Aduan')">
                    <i class="ti ti-alert-triangle" aria-hidden="true"></i>
                    Aduan
                </div>
            </div>
            <input type="hidden" id="kategori" name="kategori" value="Saran">
        </div>

        {{-- PESAN --}}
        <div class="lsm-field">
            <label for="pesan" class="lsm-label">Pesan</label>
            <textarea id="pesan"
                      name="pesan"
                      class="lsm-textarea"
                      placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
            @error('pesan')
                <p class="lsm-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- FOTO --}}
        <div class="lsm-field">
            <label class="lsm-label">
                Foto <span class="lsm-label-opt">(opsional)</span>
            </label>
            <div class="lsm-file-area">
                <input type="file"
                       name="foto"
                       accept="image/*"
                       onchange="setFile(this)">
                <i class="ti ti-photo-up" aria-hidden="true"></i>
                <p>Klik untuk upload foto</p>
                <p class="lsm-file-name" id="fileName"></p>
            </div>
        </div>

        <div class="lsm-divider"></div>

        {{-- SUBMIT --}}
        <div class="lsm-submit-row">
            <span class="lsm-submit-hint" id="submitHint">
                <i class="ti ti-lock" aria-hidden="true"></i>
                Semua data aman dan terenkripsi
            </span>
            <button type="submit" class="lsm-btn-kirim" id="btnKirim">
                <i class="ti ti-send" aria-hidden="true"></i>
                Kirim
            </button>
        </div>
    </form>
</div>


{{-- ============================================================
     CSS — letakkan di <style> pada layout, atau file .css terpisah
     ============================================================ --}}
<style>
/* ---------- Page ---------- */
.lsm-page {
    max-width: 560px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: system-ui, sans-serif;
}
.lsm-title {
    font-size: 1.375rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 6px;
}
.lsm-sub {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 1.75rem;
}

/* ---------- Toast ---------- */
.toast {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ecfdf5;
    border: 1px solid #6ee7b7;
    color: #065f46;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    transform: translateY(-8px);
    opacity: 0;
    pointer-events: none;
    transition: transform .35s cubic-bezier(.22,1,.36,1), opacity .35s ease;
}
.toast.show {
    transform: translateY(0);
    opacity: 1;
    pointer-events: auto;
}
.toast i { font-size: 1.125rem; }

/* ---------- Card ---------- */
.lsm-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 1.5rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
}

/* ---------- Field & Label ---------- */
.lsm-field { margin-bottom: 1.25rem; }
.lsm-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 7px;
}
.lsm-label-opt {
    font-size: 0.75rem;
    font-weight: 400;
    text-transform: none;
    color: #9ca3af;
}

/* ---------- Input, Textarea, Select ---------- */
.lsm-input,
.lsm-textarea {
    width: 100%;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.9375rem;
    color: #111827;
    font-family: inherit;
    transition: border-color .15s, box-shadow .15s;
    outline: none;
}
.lsm-input:focus,
.lsm-textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    background: #fff;
}
.lsm-textarea {
    resize: vertical;
    min-height: 110px;
    line-height: 1.6;
}
.lsm-error {
    font-size: 0.8125rem;
    color: #dc2626;
    margin-top: 5px;
}

/* ---------- Anonim row ---------- */
.lsm-anon-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    user-select: none;
    font-size: 0.9375rem;
    color: #111827;
}
.lsm-anon-row input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #6366f1;
    cursor: pointer;
    flex-shrink: 0;
}
.lsm-anon-hint {
    margin-left: auto;
    font-size: 0.75rem;
    color: #9ca3af;
}

/* ---------- Kategori grid ---------- */
.lsm-kat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}
.lsm-kat-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 10px 4px;
    font-size: 0.8125rem;
    font-weight: 500;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    background: #f9fafb;
    color: #6b7280;
    transition: all .15s;
}
.lsm-kat-btn i { font-size: 1.125rem; }
.lsm-kat-btn:hover { background: #f3f4f6; border-color: #d1d5db; }
.lsm-kat-btn.active {
    background: #eef2ff;
    border-color: #a5b4fc;
    color: #4338ca;
}

/* ---------- File upload area ---------- */
.lsm-file-area {
    border: 1.5px dashed #d1d5db;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    position: relative;
    transition: background .15s;
}
.lsm-file-area:hover { background: #f9fafb; border-color: #9ca3af; }
.lsm-file-area input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.lsm-file-area i { font-size: 1.5rem; color: #9ca3af; display: block; margin-bottom: 6px; }
.lsm-file-area p { font-size: 0.8125rem; color: #6b7280; }
.lsm-file-name { color: #6366f1 !important; font-weight: 500; margin-top: 4px; }

/* ---------- Divider ---------- */
.lsm-divider {
    height: 1px;
    background: #f3f4f6;
    margin: 1.25rem 0;
}

/* ---------- Submit row ---------- */
.lsm-submit-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.lsm-submit-hint {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.75rem;
    color: #9ca3af;
}
.lsm-submit-hint i { font-size: 0.875rem; }
.lsm-btn-kirim {
    display: flex;
    align-items: center;
    gap: 7px;
    background: #111827;
    color: #ffffff;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-size: 0.9375rem;
    font-weight: 500;
    cursor: pointer;
    font-family: inherit;
    transition: opacity .15s, transform .1s;
}
.lsm-btn-kirim:hover { opacity: .87; }
.lsm-btn-kirim:active { opacity: .75; transform: scale(.98); }
.lsm-btn-kirim.loading { opacity: .6; pointer-events: none; }
.lsm-btn-kirim i { font-size: 1rem; }

/* ---------- Spinner ---------- */
@keyframes lsm-spin { to { transform: rotate(360deg); } }
.lsm-spin { animation: lsm-spin .8s linear infinite; display: inline-block; }
</style>


{{-- ============================================================
     JavaScript — letakkan sebelum </body>
     ============================================================ --}}
<script>
function toggleAnon() {
    const cb = document.getElementById('anonim');
    cb.checked = !cb.checked;
    document.getElementById('anonHint').textContent = cb.checked
        ? 'Nama tidak akan ditampilkan'
        : 'Nama akan ditampilkan';
}

function setKat(el, val) {
    document.querySelectorAll('.lsm-kat-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('kategori').value = val;
}

function setFile(input) {
    const name = input.files[0]?.name || '';
    document.getElementById('fileName').textContent = name;
}

// Tampilkan toast lalu hilang otomatis (untuk redirect dengan session flash)
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('toast');
    if (toast && toast.classList.contains('show')) {
        setTimeout(() => toast.classList.remove('show'), 4000);
    }
});

// Validasi sisi klien sebelum submit
document.getElementById('lsmForm').addEventListener('submit', function (e) {
    const pesan = document.getElementById('pesan').value.trim();
    const hint  = document.getElementById('submitHint');

    if (!pesan) {
        e.preventDefault();
        document.getElementById('pesan').focus();
        hint.textContent = '⚠ Pesan tidak boleh kosong.';
        hint.style.color  = '#dc2626';
        return;
    }

    hint.textContent = 'Semua data aman dan terenkripsi';
    hint.style.color  = '';

    const btn = document.getElementById('btnKirim');
    btn.classList.add('loading');
    btn.innerHTML = '<i class="ti ti-loader-2 lsm-spin"></i> Mengirim...';
});
</script>
@endsection