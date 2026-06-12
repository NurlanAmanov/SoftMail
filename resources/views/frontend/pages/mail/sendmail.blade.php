@extends('frontend.layout.master')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    /* ── Reset & base ──────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; }

    /* ── Layout ────────────────────────────────────────────── */
    .mc-page        { padding: 3rem 1rem 4rem; }
    .mc-header      { text-align: center; margin-bottom: 2.5rem; }
    .mc-header h2   { font-size: 1.45rem; font-weight: 700; color: #0f172a; letter-spacing: -.4px; margin: 0 0 6px; }
    .mc-header p    { font-size: .85rem; color: #94a3b8; margin: 0; }
    .mc-card        { background: #fff; border: 1px solid #f1f5f9; border-radius: 20px;
                      box-shadow: 0 4px 24px rgba(0,0,0,.04); padding: 2.5rem; }

    /* ── Section labels ─────────────────────────────────────── */
    .mc-section-label {
        font-size: .7rem; font-weight: 700; letter-spacing: .08em;
        text-transform: uppercase; color: #cbd5e1; margin-bottom: 14px;
        display: flex; align-items: center; gap: 8px;
    }
    .mc-section-label::after {
        content: ''; flex: 1; height: 1px; background: #f1f5f9;
    }

    /* ── Field helpers ──────────────────────────────────────── */
    .mc-label {
        display: block; font-size: .8rem; font-weight: 600;
        color: #475569; margin-bottom: 7px;
    }
    .mc-input {
        width: 100%; padding: 11px 15px;
        background: #f8fafc; border: 1.5px solid #e2e8f0;
        border-radius: 10px; color: #1e293b; font-size: .9rem;
        font-family: inherit; transition: all .2s; outline: none;
    }
    .mc-input:focus {
        background: #fff; border-color: #13b999;
        box-shadow: 0 0 0 4px rgba(19,185,153,.1);
    }
    .mc-input.is-invalid {
        border-color: #f87171;
        box-shadow: 0 0 0 4px rgba(248,113,113,.1);
    }
    .mc-hint {
        font-size: .74rem; color: #94a3b8; margin-top: 5px;
        display: flex; justify-content: space-between;
    }
    .mc-hint .ok   { color: #10b981; font-weight: 600; }
    .mc-hint .warn { color: #f59e0b; font-weight: 600; }

    /* ── Template grid ──────────────────────────────────────── */
    .tpl-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(148px, 1fr));
        gap: 12px;
        margin-bottom: 14px;
    }
    .tpl-card {
        border: 1.5px solid #e2e8f0; border-radius: 14px;
        cursor: pointer; overflow: hidden; position: relative;
        background: #fff; transition: all .22s;
    }
    .tpl-card:hover  { border-color: #13b999; transform: translateY(-2px); box-shadow: 0 6px 18px rgba(19,185,153,.1); }
    .tpl-card.active { border-color: #13b999; box-shadow: 0 0 0 4px rgba(19,185,153,.12); }

    /* mini preview */
    .tpl-prev        { background: #f8fafc; padding: 10px; border-bottom: 1px solid #f1f5f9; }
    .tpl-prev-inner  { background: #fff; border: 1px solid #e2e8f0; border-radius: 7px; overflow: hidden; }
    .tpl-p-hdr       { height: 15px; background: #13b999; }
    .tpl-p-body      { padding: 8px; display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .tpl-p-dot       { width: 20px; height: 20px; border-radius: 50%; background: #13b999;
                       display: flex; align-items: center; justify-content: center; }
    .tpl-p-dot svg   { width: 9px; height: 9px; fill: #fff; }
    .tpl-p-lines     { width: 100%; display: flex; flex-direction: column; gap: 4px; }
    .tpl-p-line      { height: 4px; border-radius: 2px; background: #a7f3d0; }
    .tpl-p-line.s    { width: 60%; }
    .tpl-p-line.l    { width: 100%; }

    /* card footer */
    .tpl-foot        { padding: 8px 10px 10px; }
    .tpl-name        { font-size: .78rem; font-weight: 700; color: #1e293b; margin: 0 0 2px; }
    .tpl-slug        { font-size: .7rem; color: #94a3b8; margin: 0; }

    /* checkmark badge */
    .tpl-badge {
        display: none; position: absolute; top: 7px; right: 7px;
        width: 20px; height: 20px; background: #13b999; border-radius: 50%;
        align-items: center; justify-content: center;
        box-shadow: 0 1px 4px rgba(0,0,0,.12);
    }
    .tpl-badge svg { width: 10px; height: 10px; fill: none; stroke: #fff; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
    .tpl-card.active .tpl-badge { display: flex; }

    /* selected bar */
    .mc-selected-bar {
        display: flex; align-items: center; gap: 9px;
        padding: 10px 14px; background: #f0fdfa;
        border: 1px solid #ccfbf1; border-radius: 10px;
        font-size: .82rem; color: #475569;
    }
    .mc-selected-bar strong { color: #0f766e; }
    .mc-selected-bar svg    { width: 14px; height: 14px; color: #13b999; flex-shrink: 0; }

    /* ── Dynamic fields ─────────────────────────────────────── */
    .dyn-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .dyn-grid .col-full { grid-column: 1 / -1; }
    @media(max-width: 600px) { .dyn-grid { grid-template-columns: 1fr; } }

    /* ── File upload zone ───────────────────────────────────── */
    .mc-file-zone {
        position: relative; border: 1.5px dashed #e2e8f0;
        border-radius: 10px; background: #f8fafc;
        padding: 18px 20px; cursor: pointer; transition: all .2s;
        display: flex; align-items: center; gap: 12px;
    }
    .mc-file-zone:hover,
    .mc-file-zone.drag-over { border-color: #13b999; background: #f0fdfa; }
    .mc-file-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .mc-file-icon {
        width: 36px; height: 36px; border-radius: 8px;
        background: #e6faf5; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .mc-file-icon svg {
        width: 18px; height: 18px; fill: none; stroke: #13b999;
        stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
    }
    .mc-file-text { flex: 1; }
    .mc-file-text strong { display: block; font-size: .82rem; font-weight: 600; color: #334155; }
    .mc-file-text span   { font-size: .74rem; color: #94a3b8; }

    /* file preview pill */
    .mc-file-pill {
        display: none; align-items: center; gap: 8px;
        padding: 8px 12px; background: #f0fdfa;
        border: 1px solid #ccfbf1; border-radius: 8px; margin-top: 8px;
        font-size: .78rem; color: #0f766e; font-weight: 500;
    }
    .mc-file-pill.show { display: flex; }
    .mc-file-pill svg  {
        width: 13px; height: 13px; fill: none; stroke: #13b999; stroke-width: 2;
        stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0;
    }
    .mc-file-pill .pill-remove {
        margin-left: auto; cursor: pointer; color: #94a3b8; font-size: .7rem;
        background: none; border: none; padding: 0; line-height: 1;
    }
    .mc-file-pill .pill-remove:hover { color: #ef4444; }
    .mc-file-pill .pill-size { color: #94a3b8; font-weight: 400; }

    /* ── Rich Text Editor ───────────────────────────────────── */
    .mc-editor-wrap .ql-toolbar {
        border: 1.5px solid #e2e8f0; border-bottom: none;
        border-radius: 10px 10px 0 0; background: #f8fafc; font-family: inherit;
    }
    .mc-editor-wrap .ql-container {
        border: 1.5px solid #e2e8f0; border-top: none;
        border-radius: 0 0 10px 10px; font-family: inherit;
        font-size: .9rem; color: #1e293b; min-height: 200px;
    }
    .mc-editor-wrap .ql-editor {
        min-height: 200px; padding: 14px 16px; line-height: 1.65;
    }
    .mc-editor-wrap .ql-editor.ql-blank::before {
        color: #cbd5e1; font-style: normal; font-size: .88rem;
    }
    .mc-editor-wrap:focus-within .ql-toolbar,
    .mc-editor-wrap:focus-within .ql-container { border-color: #13b999; }
    .mc-editor-wrap:focus-within .ql-container {
        box-shadow: 0 0 0 4px rgba(19,185,153,.1);
    }
    .mc-editor-wrap.is-invalid .ql-toolbar,
    .mc-editor-wrap.is-invalid .ql-container { border-color: #f87171; }
    .mc-editor-wrap.is-invalid .ql-container {
        box-shadow: 0 0 0 4px rgba(248,113,113,.1);
    }
    .ql-snow .ql-stroke                             { stroke: #475569; }
    .ql-snow .ql-fill                               { fill:   #475569; }
    .ql-snow.ql-toolbar button:hover .ql-stroke,
    .ql-snow.ql-toolbar button.ql-active .ql-stroke { stroke: #13b999; }
    .ql-snow.ql-toolbar button:hover .ql-fill,
    .ql-snow.ql-toolbar button.ql-active .ql-fill   { fill:   #13b999; }
    .ql-snow.ql-toolbar .ql-picker-label:hover,
    .ql-snow.ql-toolbar .ql-picker-item:hover       { color:  #13b999; }
    .ql-snow a                                      { color:  #13b999; }

    /* ── Submit button ──────────────────────────────────────── */
    .mc-submit {
        width: 100%; padding: 15px; background: #13b999; color: #fff;
        border: none; border-radius: 12px; font-size: .95rem; font-weight: 700;
        font-family: inherit; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 9px;
        transition: background .25s, transform .15s, box-shadow .25s;
        box-shadow: 0 4px 14px rgba(19,185,153,.25);
    }
    .mc-submit:hover  { background: #0f9e84; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(19,185,153,.3); }
    .mc-submit:active { transform: translateY(0); }
    .mc-submit svg    { width: 16px; height: 16px; fill: none; stroke: #fff; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* ── Flash alert ────────────────────────────────────────── */
    .mc-alert {
        position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999;
        display: flex; align-items: center; gap: 10px;
        background: #fff; border-left: 4px solid #13b999;
        border-radius: 10px; padding: 12px 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        font-size: .85rem; color: #1e293b; font-weight: 500;
        animation: slideIn .3s ease;
    }
    .mc-alert svg { width: 16px; height: 16px; fill: none; stroke: #13b999; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }

    /* ── Divider ────────────────────────────────────────────── */
    .mc-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.75rem 0; }

    /* ── Empty state ────────────────────────────────────────── */
    .mc-empty { font-size: .82rem; color: #94a3b8; }
    .mc-empty a { color: #13b999; text-decoration: none; font-weight: 600; }
    .mc-empty a:hover { text-decoration: underline; }

    /* ── Step header ─────────────────────────────────────────── */
    .mc-step-header {
        display: flex; align-items: center; gap: 14px;
    }
    .mc-step-num {
        width: 34px; height: 34px; border-radius: 50%;
        background: #0f172a; color: #fff;
        font-size: .85rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .mc-step-title {
        font-size: .95rem; font-weight: 700; color: #0f172a; line-height: 1.2;
    }
    .mc-step-sub {
        font-size: .75rem; color: #94a3b8; margin-top: 2px;
    }
    .mc-required { color: #ef4444; margin-left: 2px; }
</style>
@endpush

@section('content')

{{-- Template JSON data for JS --}}
<script id="tpl-data" type="application/json">
{!! $templates->mapWithKeys(fn($t) => [$t->id => $t->json_structure ?? []])->toJson() !!}
</script>

<div class="container-fluid mc-page">

    {{-- Flash message --}}
    @if(session('message'))
        <div class="mc-alert" id="flash-alert">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- Page header --}}
    <div class="mc-header">
        <h2>Yeni Kampaniya Hazırla</h2>
        <p>Müştərilərinizə göndəriləcək mailin detal və dizaynını seçin.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <form method="POST" action="{{ route('admin.mailer.send') }}" id="mc-form" enctype="multipart/form-data">
                @csrf
                {{-- ══ ADDIM 1: Dizayn Şablonu ══════════════════════════════ --}}
                <div class="mc-card mb-4">
                    <div class="mc-step-header">
                        <span class="mc-step-num">1</span>
                        <div>
                            <div class="mc-step-title">Dizayn Şablonu</div>
                            <div class="mc-step-sub">Emailinizin görünüşünü seçin</div>
                        </div>
                    </div>

                    @if($templates->isEmpty())
                        <p class="mc-empty mt-3">
                            Hələ heç bir şablon yoxdur.
                            <a href="{{ route('admin.templates.create') }}">Yarat</a>
                        </p>
                    @else
                        <div class="tpl-grid mt-3">
                            @foreach($templates as $index => $tpl)
                                <div class="tpl-card {{ $index === 0 ? 'active' : '' }}"
                                     data-id="{{ $tpl->id }}"
                                     data-title="{{ $tpl->name }}">
                                    <div class="tpl-prev">
                                        <div class="tpl-prev-inner">
                                            <div class="tpl-p-hdr"></div>
                                            <div class="tpl-p-body">
                                                <div class="tpl-p-dot">
                                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                                        <polyline points="22,6 12,13 2,6" style="fill:none;stroke:#fff;stroke-width:2"/>
                                                    </svg>
                                                </div>
                                                <div class="tpl-p-lines">
                                                    <div class="tpl-p-line l"></div>
                                                    <div class="tpl-p-line s"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tpl-foot">
                                        <p class="tpl-name">{{ $tpl->name }}</p>
                                        <p class="tpl-slug">{{ $tpl->slug }}</p>
                                    </div>
                                    <div class="tpl-badge">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <input type="hidden" name="template" id="hidden-template"
                               value="{{ $templates->first()->id }}">

                        <div class="mc-selected-bar mt-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            Seçilmiş şablon: <strong id="selected-tpl-name">{{ $templates->first()->name }}</strong>
                        </div>
                    @endif
                </div>

                {{-- ══ ADDIM 2: Kampaniya Məlumatları ═══════════════════════════ --}}
                <div class="mc-card mb-4">
                    <div class="mc-step-header">
                        <span class="mc-step-num">2</span>
                        <div>
                            <div class="mc-step-title">Kampaniya Məlumatları</div>
                            <div class="mc-step-sub">Mövzu, qəbulçular və şablon sahələri</div>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        {{-- Mövzu --}}
                        <div class="col-md-6">
                            <label class="mc-label" for="mc-subject">
                                Email mövzusu
                                <span class="mc-required">*</span>
                            </label>
                            <input id="mc-subject"
                                   name="subject"
                                   class="mc-input"
                                   placeholder="Məs: Yeni endirim kampaniyası — 40% qənaət!"
                                   maxlength="255"
                                   value="{{ old('subject') }}"
                                   required>
                            <div class="mc-hint">
                                <span class="text-muted" style="font-size:.72rem">Alıcının gördüyü ilk mətn</span>
                                <span id="subj-counter">0 / 255</span>
                            </div>
                        </div>

                        {{-- Qəbulçular --}}
                        <div class="col-md-6">
                            <label class="mc-label" for="mc-recipients">
                                Qəbulçular
                                <span class="mc-required">*</span>
                            </label>
                            <input id="mc-recipients"
                                   name="recipients"
                                   class="mc-input"
                                   placeholder="nurlan@softlink.az, info@company.com"
                                   value="{{ old('recipients', $recipientsList) }}">
                            <div class="mc-hint">
                                <span id="rec-counter"></span>
                                <span style="color:#cbd5e1; font-size:.72rem">vergül və ya nöqtəli vergül ilə ayırın</span>
                            </div>
                        </div>

                        {{-- Şablon sahələri (dinamik) --}}
                        <div class="col-12" id="dyn-section" style="display:none">
                            <hr class="mc-divider" style="margin:.5rem 0 1rem">
                            <div class="mc-section-label" style="margin-bottom:12px">Şablon sahələri</div>
                            <div class="dyn-grid" id="dyn-fields-inner"></div>
                        </div>
                    </div>
                </div>

                {{-- ══ ADDIM 3: Mesaj Mətni ══════════════════════════════════════ --}}
                <div class="mc-card mb-4">
                    <div class="mc-step-header">
                        <span class="mc-step-num">3</span>
                        <div>
                            <div class="mc-step-title">Mesaj Mətni</div>
                            <div class="mc-step-sub">Emailin əsas məzmunu — istəyə bağlı</div>
                        </div>
                    </div>

                    <div class="mc-editor-wrap mt-3" id="editor-wrap">
                        <div id="mc-body-editor"></div>
                    </div>
                    <input type="hidden" name="body_html" id="mc-body-html">
                    <div class="mc-hint mt-2">
                        <span></span>
                        <span id="body-char-counter" style="color:#cbd5e1">0 simvol</span>
                    </div>
                </div>

                {{-- ══ ADDIM 4: Əlavə Fayl + Submit ═══════════════════════════════ --}}
                <div class="mc-card">
                    <div class="mc-step-header mb-3">
                        <span class="mc-step-num">4</span>
                        <div>
                            <div class="mc-step-title">Əlavə Fayl</div>
                            <div class="mc-step-sub">Sənəd əlavə et — istəyə bağlı</div>
                        </div>
                    </div>

                    <div class="mc-file-zone" id="file-zone">
                        <input type="file"
                               name="attachment"
                               id="mc-attachment"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                        <div class="mc-file-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                            </svg>
                        </div>
                        <div class="mc-file-text">
                            <strong>Faylı buraya sürüşdürün və ya seçin</strong>
                            <span>PDF, Word, Excel, JPG, PNG — maks. 10 MB</span>
                        </div>
                    </div>

                    <div class="mc-file-pill" id="file-pill">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <span id="pill-name">fayl.pdf</span>
                        <span class="pill-size" id="pill-size"></span>
                        <button type="button" class="pill-remove" id="pill-remove" title="Sil">✕</button>
                    </div>

                    <hr class="mc-divider">

                    <button type="submit" class="mc-submit">
                        <svg viewBox="0 0 24 24">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Kampaniyanı başlat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Data ─────────────────────────────────────────────────────── */
    var tplData = JSON.parse(document.getElementById('tpl-data').textContent);

    var LABELS = {
        TITLE:       'Başlıq',
        BUTTON_URL:  'Düymə linki (URL)',
        BUTTON_TEXT: 'Düymə mətni',
        PHONE:       'Əlaqə nömrəsi',
    };
    var DEFAULTS = {
        BUTTON_TEXT: 'Kampaniyaya bax',
        BUTTON_URL:  'https://adminity.dev',
        PHONE:       '+994 (50) 000 00 00',
    };

    /* ── Elements ─────────────────────────────────────────────────── */
    var hiddenInput     = document.getElementById('hidden-template');
    var selName         = document.getElementById('selected-tpl-name');
    var dynSection      = document.getElementById('dyn-section');
    var dynInner        = document.getElementById('dyn-fields-inner');
    var subjInput       = document.getElementById('mc-subject');
    var subjCounter     = document.getElementById('subj-counter');
    var recInput        = document.getElementById('mc-recipients');
    var recCounter      = document.getElementById('rec-counter');
    var form            = document.getElementById('mc-form');
    var bodyHtmlInput   = document.getElementById('mc-body-html');
    var bodyCharCounter = document.getElementById('body-char-counter');

    /* ── Quill Rich Text Editor ───────────────────────────────────── */
    var quill = new Quill('#mc-body-editor', {
        theme: 'snow',
        placeholder: 'Müştərilərinizə göndəriləcək mesajın məzmununu buraya yazın...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['link'],
                ['clean']
            ]
        }
    });

    quill.on('text-change', function () {
        var text = quill.getText().trim();
        bodyHtmlInput.value = text.length === 0 ? '' : quill.root.innerHTML;

        var len = text.length;
        bodyCharCounter.textContent = len > 0 ? len + ' simvol' : '0 simvol';
        bodyCharCounter.style.color = len > 2000 ? '#f59e0b' : '#cbd5e1';
    });

    /* ── Template card selection ──────────────────────────────────── */
    document.querySelectorAll('.tpl-card').forEach(function (card) {
        card.addEventListener('click', function () {
            document.querySelectorAll('.tpl-card').forEach(function (c) { c.classList.remove('active'); });
            this.classList.add('active');

            var id = this.dataset.id;
            hiddenInput.value   = id;
            selName.textContent = this.dataset.title;
            renderDynamicFields(id);
        });
    });

    /* ── Dynamic field renderer (CONTENT skip edilir) ─────────────── */
    function renderDynamicFields(templateId) {
        var keys = tplData[String(templateId)] || [];
        dynInner.innerHTML = '';

        // CONTENT çıxarıldıqdan sonra qalan sahələri say
        var filtered = keys.filter(function (k) { return k !== 'CONTENT'; });

        if (!filtered.length) {
            dynSection.style.display = 'none';
            return;
        }

        dynSection.style.display = 'block';

        filtered.forEach(function (key) {
            var label = LABELS[key] || key;
            var def   = DEFAULTS[key] || '';

            var col = document.createElement('div');
            col.innerHTML = '<label class="mc-label">' + label + '</label>'
                + '<input name="' + key.toLowerCase() + '" class="mc-input" placeholder="' + label + '" value="' + def + '">';

            dynInner.appendChild(col);
        });
    }

    if (hiddenInput && hiddenInput.value) {
        renderDynamicFields(hiddenInput.value);
    }

    /* ── Subject counter ──────────────────────────────────────────── */
    function updateSubjCounter() {
        var len = subjInput.value.length;
        subjCounter.textContent = len + ' / 255';
        subjCounter.className   = len > 200 ? 'warn' : '';
    }
    subjInput && subjInput.addEventListener('input', updateSubjCounter);
    updateSubjCounter();

    /* ── Recipient counter ────────────────────────────────────────── */
    function parseEmails(raw) {
        return raw.split(/[,;\n]+/)
                  .map(function (s) { return s.trim(); })
                  .filter(function (s) { return s.length > 0; });
    }
    function validEmails(parts) {
        return parts.filter(function (s) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(s); });
    }

    function updateRecCounter() {
        var parts = parseEmails(recInput.value);
        var valid = validEmails(parts);
        if (valid.length > 0) {
            recCounter.className   = 'ok';
            recCounter.textContent = valid.length + ' düzgün e-mail ünvanı aşkarlandı';
        } else {
            recCounter.className   = '';
            recCounter.textContent = '';
        }
    }
    recInput && recInput.addEventListener('input', updateRecCounter);
    updateRecCounter();

    /* ── File upload handling ─────────────────────────────────────── */
    var fileInput  = document.getElementById('mc-attachment');
    var fileZone   = document.getElementById('file-zone');
    var filePill   = document.getElementById('file-pill');
    var pillName   = document.getElementById('pill-name');
    var pillSize   = document.getElementById('pill-size');
    var pillRemove = document.getElementById('pill-remove');

    function formatSize(bytes) {
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(2) + ' MB';
    }

    function showFilePill(file) {
        pillName.textContent = file.name;
        pillSize.textContent = '(' + formatSize(file.size) + ')';
        filePill.classList.add('show');
    }

    function clearFile() {
        fileInput.value      = '';
        filePill.classList.remove('show');
        pillName.textContent = '';
        pillSize.textContent = '';
    }

    fileInput && fileInput.addEventListener('change', function () {
        if (this.files[0]) {
            var file     = this.files[0];
            var maxBytes = 10 * 1024 * 1024;
            if (file.size > maxBytes) {
                alert('Fayl həcmi 10 MB-dan çox ola bilməz.');
                clearFile();
                return;
            }
            showFilePill(file);
        } else {
            clearFile();
        }
    });

    pillRemove && pillRemove.addEventListener('click', clearFile);

    fileZone && fileZone.addEventListener('dragover', function (e) {
        e.preventDefault(); this.classList.add('drag-over');
    });
    fileZone && fileZone.addEventListener('dragleave', function () {
        this.classList.remove('drag-over');
    });
    fileZone && fileZone.addEventListener('drop', function (e) {
        e.preventDefault(); this.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

    /* ── Flash alert auto-dismiss ─────────────────────────────────── */
    var flashAlert = document.getElementById('flash-alert');
    if (flashAlert) {
        setTimeout(function () {
            flashAlert.style.transition = 'opacity .4s';
            flashAlert.style.opacity    = '0';
            setTimeout(function () { flashAlert.remove(); }, 400);
        }, 4000);
    }

    /* ── Client-side form validation ─────────────────────────────── */
    function shake(el) {
        el.classList.add('is-invalid');
        if (el.focus) el.focus();
        setTimeout(function () { el.classList.remove('is-invalid'); }, 2000);
    }

    form && form.addEventListener('submit', function (e) {
        /* Subject required */
        if (!subjInput.value.trim()) {
            e.preventDefault();
            shake(subjInput);
            return;
        }

        /* At least one valid recipient */
        var valid = validEmails(parseEmails(recInput.value));
        if (valid.length === 0) {
            e.preventDefault();
            shake(recInput);
            return;
        }

        /* Quill HTML-ini hidden input-a yaz */
        var text = quill.getText().trim();
        bodyHtmlInput.value = text.length === 0 ? '' : quill.root.innerHTML;
    });

});
</script>
@endpush