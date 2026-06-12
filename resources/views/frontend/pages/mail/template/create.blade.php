@extends('frontend.layout.master')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body, .tpl-builder { font-family: 'DM Sans', sans-serif; background: #f5f6fa; }

/* ── Top Bar ── */
.tb-bar {
    position: sticky; top: 0; z-index: 200;
    height: 56px; background: #fff;
    border-bottom: 1px solid #e8eaf0;
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.tb-left  { display: flex; align-items: center; gap: 14px; }
.tb-right { display: flex; align-items: center; gap: 8px; }

.tb-logo {
    display: flex; align-items: center; gap: 8px;
    font-weight: 600; font-size: 14.5px; color: #0f172a;
    text-decoration: none;
}
.tb-logo-icon {
    width: 30px; height: 30px;
    background: #0f172a; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
}
.tb-logo-icon svg { color: #fff; }

#tpl-name {
    height: 34px; border: 1px solid #e2e8f0; border-radius: 8px;
    padding: 0 12px; font-size: 13.5px; font-family: inherit;
    color: #0f172a; width: 200px; outline: none; background: #f8fafc;
    transition: border-color .2s, box-shadow .2s;
}
#tpl-name:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
#tpl-name::placeholder { color: #94a3b8; }

.tb-sep { width: 1px; height: 22px; background: #e2e8f0; }

.btn-save {
    height: 34px; padding: 0 18px;
    background: #0f172a; color: #fff;
    border: none; border-radius: 8px;
    font-size: 13px; font-family: inherit; font-weight: 500;
    cursor: pointer; display: flex; align-items: center; gap: 6px;
    transition: background .15s;
}
.btn-save:hover { background: #1e293b; }
.btn-save.loading { opacity: .65; pointer-events: none; }

.btn-ghost {
    height: 34px; padding: 0 13px;
    background: transparent; color: #475569;
    border: 1px solid #e2e8f0; border-radius: 8px;
    font-size: 13px; font-family: inherit;
    cursor: pointer; display: flex; align-items: center; gap: 6px;
    transition: background .15s, border-color .15s;
}
.btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; color: #0f172a; }

.btn-ghost-sm {
    height: 30px; padding: 0 10px;
    background: transparent; color: #64748b;
    border: 1px solid #e2e8f0; border-radius: 6px;
    font-size: 12px; font-family: inherit;
    cursor: pointer; display: flex; align-items: center; gap: 5px;
    transition: all .15s;
}
.btn-ghost-sm:hover { background: #f1f5f9; border-color: #cbd5e1; }

.edit-badge {
    display: flex; align-items: center; gap: 5px;
    font-size: 11.5px; font-weight: 500; color: #7c3aed;
    background: #f5f3ff; border: 1px solid #e0d9ff;
    padding: 3px 10px; border-radius: 20px;
}

/* ── Main Layout ── */
.tb-layout {
    display: flex; height: calc(100vh - 56px); overflow: hidden;
}

/* ── Left Panel: Blocks ── */
.tb-blocks {
    width: 200px; min-width: 200px;
    background: #fff; border-right: 1px solid #e8eaf0;
    display: flex; flex-direction: column; overflow: hidden;
}
.tb-blocks-title {
    padding: 14px 14px 8px;
    font-size: 10px; font-weight: 600; letter-spacing: .08em;
    text-transform: uppercase; color: #94a3b8;
}
.tb-block-list { padding: 6px 10px; overflow-y: auto; flex: 1; }
.tb-block-group-title {
    font-size: 10px; font-weight: 600; letter-spacing: .06em;
    text-transform: uppercase; color: #94a3b8;
    padding: 10px 4px 5px;
}

.block-chip {
    display: flex; align-items: center; gap: 9px;
    padding: 9px 11px; border-radius: 8px;
    border: 1px solid #e8eaf0; background: #fafafa;
    cursor: grab; margin-bottom: 5px;
    font-size: 12.5px; font-weight: 500; color: #374151;
    user-select: none; transition: all .15s;
}
.block-chip:active { cursor: grabbing; }
.block-chip:hover { border-color: #c7d2fe; background: #eef2ff; color: #4338ca; }
.block-chip .bc-icon { font-size: 16px; flex-shrink: 0; }

/* ── Canvas ── */
.tb-canvas-wrap {
    flex: 1; background: #f5f6fa;
    display: flex; flex-direction: column; overflow: hidden;
}
.tb-device-bar {
    display: flex; align-items: center; justify-content: center;
    gap: 4px; padding: 8px; background: #f5f6fa;
    border-bottom: 1px solid #e8eaf0; flex-shrink: 0;
}
.dev-btn {
    width: 28px; height: 28px; border-radius: 6px;
    border: 1px solid transparent; background: transparent;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #94a3b8; transition: all .15s;
}
.dev-btn.active, .dev-btn:hover { background: #fff; border-color: #e2e8f0; color: #6366f1; }

.tb-canvas {
    flex: 1; overflow-y: auto;
    display: flex; justify-content: center;
    padding: 24px 20px;
}
.canvas-email {
    background: #fff;
    width: 600px; max-width: 100%;
    min-height: 200px;
    border-radius: 12px;
    border: 1.5px dashed #c7d2fe;
    transition: width .3s ease;
    overflow: hidden;
    position: relative;
}
.canvas-email.tablet  { width: 480px; }
.canvas-email.mobile  { width: 360px; }
.canvas-email.drag-over { border-color: #6366f1; background: #f5f3ff; }

.canvas-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; padding: 60px 20px;
    color: #94a3b8; text-align: center; pointer-events: none;
}
.canvas-empty svg { margin-bottom: 12px; opacity: .4; }
.canvas-empty p { font-size: 13.5px; }

/* ── Block Row (rendered in canvas) ── */
.email-block {
    position: relative; cursor: pointer;
    border: 2px solid transparent; transition: border-color .15s;
}
.email-block:hover { border-color: #c7d2fe; }
.email-block.selected { border-color: #6366f1; }

.block-controls {
    position: absolute; top: 6px; right: 6px;
    display: none; gap: 4px; z-index: 10;
}
.email-block:hover .block-controls,
.email-block.selected .block-controls { display: flex; }

.block-ctrl-btn {
    width: 26px; height: 26px; border-radius: 6px;
    border: 1px solid #e2e8f0; background: #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 12px; color: #64748b;
    transition: all .12s;
}
.block-ctrl-btn:hover { background: #f1f5f9; color: #0f172a; }
.block-ctrl-btn.del:hover { background: #fff1f2; border-color: #fca5a5; color: #ef4444; }
.block-drag-handle {
    position: absolute; left: 6px; top: 50%; transform: translateY(-50%);
    cursor: grab; color: #94a3b8; padding: 4px;
    display: none; font-size: 14px;
}
.email-block:hover .block-drag-handle { display: flex; }

/* ── Right Panel: Properties ── */
.tb-props {
    width: 256px; min-width: 256px;
    background: #fff; border-left: 1px solid #e8eaf0;
    display: flex; flex-direction: column; overflow-y: auto;
}
.tb-props-header {
    padding: 14px 14px 0;
    font-size: 10px; font-weight: 600; letter-spacing: .08em;
    text-transform: uppercase; color: #94a3b8;
    flex-shrink: 0;
}
.props-empty {
    flex: 1; display: flex; align-items: center; justify-content: center;
    padding: 40px 20px; text-align: center; color: #94a3b8; font-size: 13px;
}

/* ── Prop Fields ── */
.prop-group { padding: 14px 14px 8px; border-top: 1px solid #f1f5f9; }
.prop-label {
    font-size: 11px; font-weight: 600; text-transform: uppercase;
    letter-spacing: .06em; color: #94a3b8; margin-bottom: 10px;
}
.prop-row { margin-bottom: 10px; }
.prop-row label { display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; }
.prop-input {
    width: 100%; height: 32px; border: 1px solid #e2e8f0; border-radius: 6px;
    padding: 0 10px; font-size: 12.5px; font-family: inherit; color: #0f172a;
    background: #fafafa; outline: none; transition: border-color .2s;
}
.prop-input:focus { border-color: #6366f1; background: #fff; }
.prop-input.color-input { height: 32px; padding: 3px 6px; cursor: pointer; }
.prop-textarea {
    width: 100%; border: 1px solid #e2e8f0; border-radius: 6px;
    padding: 8px 10px; font-size: 12.5px; font-family: inherit; color: #0f172a;
    background: #fafafa; outline: none; resize: vertical; min-height: 72px;
    transition: border-color .2s;
}
.prop-textarea:focus { border-color: #6366f1; background: #fff; }

.prop-row select.prop-input { cursor: pointer; }
.prop-row .color-row { display: flex; align-items: center; gap: 8px; }
.prop-row .color-row input[type=color] {
    width: 32px; height: 32px; padding: 2px; border: 1px solid #e2e8f0;
    border-radius: 6px; cursor: pointer; background: #fff;
}
.prop-row .color-row input[type=text] { flex: 1; }

/* ── Variable chips ── */
.var-chips { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 6px; }
.var-chip {
    font-size: 10.5px; font-family: inherit; font-weight: 500; color: #6366f1;
    background: #eef2ff; border: 1px solid #e0e7ff; border-radius: 5px;
    padding: 3px 8px; cursor: pointer; transition: all .12s;
}
.var-chip:hover { background: #e0e7ff; border-color: #c7d2fe; }

/* ── Preset chips ── */
.preset-chip { cursor: pointer; }

/* ── Block controls extra ── */
.block-ctrl-btn.dup:hover { background: #eef2ff; border-color: #c7d2fe; color: #6366f1; }

/* ── Undo / Redo ── */
.tb-undo-redo { display: flex; gap: 2px; }
.tb-undo-redo .btn-ghost-sm:disabled { opacity: .35; cursor: default; pointer-events: none; }

/* ── Settings Modal ── */
#settings-modal {
    display: none; position: fixed; inset: 0; z-index: 10000;
    background: rgba(15,23,42,.55);
    align-items: center; justify-content: center;
}
#settings-modal .prev-box { width: 380px; }
#settings-modal .settings-body { padding: 16px 18px; }
#settings-modal .settings-body .prop-row:last-child { margin-bottom: 0; }

/* ── Toast ── */
#tb-toast {
    position: fixed; bottom: 22px; left: 50%;
    transform: translateX(-50%) translateY(16px);
    background: #0f172a; color: #f8fafc;
    font-size: 13.5px; font-family: 'DM Sans', sans-serif; font-weight: 500;
    padding: 10px 18px; border-radius: 10px;
    display: flex; align-items: center; gap: 8px;
    opacity: 0; pointer-events: none;
    transition: opacity .25s, transform .25s;
    z-index: 9999; white-space: nowrap;
    box-shadow: 0 4px 18px rgba(0,0,0,.22);
}
#tb-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
#tb-toast.ok   .ti { color: #34d399; }
#tb-toast.err  .ti { color: #f87171; }
#tb-toast.info .ti { color: #60a5fa; }

/* Preview Modal */
#prev-modal {
    display: none; position: fixed; inset: 0; z-index: 10000;
    background: rgba(15,23,42,.55);
    align-items: center; justify-content: center;
}
.prev-box {
    background: #fff; border-radius: 14px;
    width: 660px; max-width: 95vw;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,.22);
}
.prev-head {
    padding: 13px 16px; display: flex;
    justify-content: space-between; align-items: center;
    border-bottom: 1px solid #e8eaf0;
}
.prev-head span { font-size: 14px; font-weight: 600; color: #0f172a; }
.prev-body { padding: 16px; background: #f5f6fa; }
#prev-iframe { width: 100%; height: 480px; border: none; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.07); }

::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
</style>
@endpush

@section('content')
<div class="tpl-builder">

    {{-- Top Bar --}}
    <div class="tb-bar">
        <div class="tb-left">
            <a href="{{ route('admin.templates.index') }}" class="tb-logo">
                <div class="tb-logo-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/>
                    </svg>
                </div>
                MailBuilder
            </a>
            <div class="tb-sep"></div>
            @isset($template)
                <span class="edit-badge">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Redaktə modu
                </span>
            @endisset
            <input type="text" id="tpl-name"
                   placeholder="Şablon adını yazın..."
                   value="{{ $template->name ?? '' }}">
        </div>
        <div class="tb-right">
            <div class="tb-undo-redo">
                <button class="btn-ghost-sm" id="undo-btn" style="width:30px;justify-content:center;" title="Geri al (Ctrl+Z)" onclick="undo()" disabled>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 14L4 9l5-5"/><path d="M4 9h11a5 5 0 010 10h-1"/></svg>
                </button>
                <button class="btn-ghost-sm" id="redo-btn" style="width:30px;justify-content:center;" title="Təkrar et (Ctrl+Y)" onclick="redo()" disabled>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 14l5-5-5-5"/><path d="M20 9H9a5 5 0 000 10h1"/></svg>
                </button>
            </div>
            <div class="tb-sep"></div>
            <button class="btn-ghost" onclick="openSettings()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                Ayarlar
            </button>
            <button class="btn-ghost" onclick="previewEmail()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Önizlə
            </button>
            <button id="save-btn" class="btn-save" onclick="saveTemplate()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                {{ isset($template) ? 'Yenilə' : 'Yadda saxla' }}
            </button>
        </div>
    </div>

    {{-- Layout --}}
    <div class="tb-layout">

        {{-- Left: Block Palette --}}
        <aside class="tb-blocks">
            <div class="tb-blocks-title">Bloklar</div>
            <div class="tb-block-list">
                <div class="tb-block-group-title">Layoutlar</div>
                <div class="block-chip" draggable="true" data-block="header">
                    <span class="bc-icon">✉️</span> Başlıq
                </div>
                <div class="block-chip" draggable="true" data-block="two-col">
                    <span class="bc-icon">▣</span> 2 Sütun
                </div>
                <div class="block-chip" draggable="true" data-block="card">
                    <span class="bc-icon">🃏</span> Kart
                </div>
                <div class="block-chip" draggable="true" data-block="footer">
                    <span class="bc-icon">📋</span> Footer
                </div>

                <div class="tb-block-group-title">Məzmun</div>
                <div class="block-chip" draggable="true" data-block="text">
                    <span class="bc-icon">📝</span> Mətn
                </div>
                <div class="block-chip" draggable="true" data-block="button">
                    <span class="bc-icon">🔘</span> Düymə
                </div>
                <div class="block-chip" draggable="true" data-block="image">
                    <span class="bc-icon">🖼️</span> Şəkil
                </div>
                <div class="block-chip" draggable="true" data-block="image-text">
                    <span class="bc-icon">🖼️📝</span> Şəkil + Mətn
                </div>
                <div class="block-chip" draggable="true" data-block="list">
                    <span class="bc-icon">📋</span> Siyahı
                </div>
                <div class="block-chip" draggable="true" data-block="quote">
                    <span class="bc-icon">❝</span> Sitat
                </div>
                <div class="block-chip" draggable="true" data-block="social">
                    <span class="bc-icon">🔗</span> Sosial Media
                </div>
                <div class="block-chip" draggable="true" data-block="divider">
                    <span class="bc-icon">—</span> Bölücü
                </div>
                <div class="block-chip" draggable="true" data-block="spacer">
                    <span class="bc-icon">⬜</span> Boşluq
                </div>

                <div class="tb-block-group-title">Hazır Bölmələr</div>
                <div class="block-chip preset-chip" onclick="addPreset('welcome')">
                    <span class="bc-icon">👋</span> Xoş Gəliş Bölməsi
                </div>
                <div class="block-chip preset-chip" onclick="addPreset('promo')">
                    <span class="bc-icon">🎉</span> Promo Bölmə
                </div>
                <div class="block-chip preset-chip" onclick="addPreset('cta')">
                    <span class="bc-icon">📣</span> CTA Bölmə
                </div>
            </div>
        </aside>

        {{-- Canvas --}}
        <div class="tb-canvas-wrap">
            <div class="tb-device-bar">
                <button class="dev-btn active" title="Desktop" onclick="setDevice('desktop', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </button>
                <button class="dev-btn" title="Tablet" onclick="setDevice('tablet', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                </button>
                <button class="dev-btn" title="Mobil" onclick="setDevice('mobile', this)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                </button>
            </div>
            <div class="tb-canvas">
                <div class="canvas-email" id="canvas-email" ondragover="handleDragOver(event)" ondrop="handleDrop(event)" ondragleave="handleDragLeave(event)">
                    <div class="canvas-empty" id="canvas-empty">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12h14"/></svg>
                        <p>Sol tərəfdən blokları<br>sürükləyib buraya atın</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Properties --}}
        <aside class="tb-props" id="tb-props">
            <div class="tb-props-header">Xüsusiyyətlər</div>
            <div class="props-empty" id="props-empty">
                <span>Düzəliş etmək üçün<br>bir bloka klikləyin</span>
            </div>
            <div id="props-content" style="display:none;"></div>
        </aside>

    </div>

    {{-- Toast --}}
    <div id="tb-toast"><span class="ti"></span><span id="tb-toast-msg"></span></div>

    {{-- Preview Modal --}}
    <div id="prev-modal" onclick="if(event.target===this)closePrev()">
        <div class="prev-box">
            <div class="prev-head">
                <span>Önizləmə</span>
                <div style="display:flex;gap:8px;">
                    <button class="btn-ghost-sm" onclick="copyHtmlToClipboard()">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        HTML kopyala
                    </button>
                    <button class="btn-ghost-sm" onclick="closePrev()" style="width:30px;justify-content:center;font-size:16px;">×</button>
                </div>
            </div>
            <div class="prev-body">
                <iframe id="prev-iframe"></iframe>
            </div>
        </div>
    </div>

    {{-- Settings Modal --}}
    <div id="settings-modal" onclick="if(event.target===this)closeSettings()">
        <div class="prev-box">
            <div class="prev-head">
                <span>Şablon Ayarları</span>
                <button class="btn-ghost-sm" onclick="closeSettings()" style="width:30px;justify-content:center;font-size:16px;">×</button>
            </div>
            <div class="settings-body">
                <div class="prop-row">
                    <label>Səhifə fonu rəngi</label>
                    <div class="color-row">
                        <input type="color" id="set-bgColor" value="#f1f5f9" oninput="document.getElementById('set-bgColorTxt').value=this.value">
                        <input type="text" id="set-bgColorTxt" class="prop-input" value="#f1f5f9" oninput="document.getElementById('set-bgColor').value=this.value">
                    </div>
                </div>
                <div class="prop-row">
                    <label>Məzmun genişliyi (px)</label>
                    <input type="text" id="set-contentWidth" class="prop-input" value="600">
                </div>
                <div class="prop-row">
                    <label>Əsas şrift</label>
                    <select id="set-fontFamily" class="prop-input">
                        <option value="Arial, Helvetica, sans-serif">Arial</option>
                        <option value="'DM Sans', Arial, sans-serif">DM Sans</option>
                        <option value="Georgia, 'Times New Roman', serif">Georgia</option>
                        <option value="Verdana, Geneva, sans-serif">Verdana</option>
                        <option value="'Courier New', Courier, monospace">Courier New</option>
                    </select>
                </div>
                <button class="btn-save" style="width:100%;justify-content:center;margin-top:6px;" onclick="saveSettings()">Tətbiq et</button>
            </div>
        </div>
    </div>

</div>

{{-- Existing template data (edit mode) --}}
@isset($template)
<script id="existing-tpl" type="application/json">
{!! json_encode(['id' => $template->id, 'html' => $template->html_content, 'name' => $template->name]) !!}
</script>
@endisset
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
// ────────────────────────────────────────────────
//  STATE
// ────────────────────────────────────────────────
var blocks      = [];   // { id, type, props }
var selectedId  = null;
var dragType    = null;

var existingEl  = document.getElementById('existing-tpl');
var existingTpl = existingEl ? JSON.parse(existingEl.textContent) : null;
var isEdit      = !!existingTpl;

// Global template settings (page bg, content width, font)
var globalSettings = { bgColor: '#f1f5f9', contentWidth: '600', fontFamily: 'Arial, Helvetica, sans-serif' };

// Quick-insert merge tags for personalisation
var VAR_TOKENS = [
    {token: '[[NAME]]',    label: 'Ad'},
    {token: '[[EMAIL]]',   label: 'E-poçt'},
    {token: '[[COMPANY]]', label: 'Şirkət'},
    {token: '[[COUPON]]',  label: 'Kupon'},
    {token: '[[PHONE]]',   label: 'Telefon'}
];

// Undo / redo history
var history      = [];
var historyIndex = -1;
var MAX_HISTORY  = 50;

// ────────────────────────────────────────────────
//  BLOCK DEFINITIONS
// ────────────────────────────────────────────────
var BLOCK_DEFAULTS = {
    header: {
        label: 'Başlıq',
        props: { bg: '#6366f1', title: '[[TITLE]]', titleColor: '#ffffff', subtitleColor: 'rgba(255,255,255,0.8)', align: 'center', paddingY: '40' }
    },
    text: {
        label: 'Mətn',
        props: { content: '[[CONTENT]]', color: '#374151', fontSize: '15', lineHeight: '1.8', align: 'left', paddingY: '28' }
    },
    button: {
        label: 'Düymə',
        props: { text: '[[BUTTON_TEXT]]', url: '[[BUTTON_URL]]', bg: '#6366f1', color: '#ffffff', align: 'center', radius: '8', paddingY: '18' }
    },
    image: {
        label: 'Şəkil',
        props: { src: 'https://placehold.co/600x200/e0e7ff/6366f1?text=Şəkiliniz', alt: 'Şəkil', align: 'center', radius: '8', paddingY: '18' }
    },
    'image-text': {
        label: 'Şəkil + Mətn',
        props: { src: 'https://placehold.co/260x180/e0e7ff/6366f1?text=Şəkil', alt: 'Şəkil', imgPos: 'left', title: 'Başlıq', text: 'Bu sahədə şəkil ilə yanaşı mətn yerləşir.', color: '#374151', radius: '8', paddingY: '20' }
    },
    list: {
        label: 'Siyahı',
        props: { title: 'Üstünlüklər', items: 'Sürətli çatdırılma\nKeyfiyyət zəmanəti\n7/24 dəstək', icon: '✓', color: '#374151', paddingY: '20' }
    },
    quote: {
        label: 'Sitat',
        props: { text: 'Bu məhsul gözləntilərimi tam doğrultdu, tövsiyə edirəm!', author: '— Müştəri rəyi', color: '#374151', bg: '#f9fafb', paddingY: '24' }
    },
    social: {
        label: 'Sosial Media',
        props: { align: 'center', facebook: 'https://facebook.com', instagram: 'https://instagram.com', twitter: 'https://twitter.com', linkedin: 'https://linkedin.com', paddingY: '20' }
    },
    divider: {
        label: 'Bölücü',
        props: { color: '#e5e7eb', thickness: '1', margin: '10' }
    },
    spacer: {
        label: 'Boşluq',
        props: { height: '30' }
    },
    'two-col': {
        label: '2 Sütun',
        props: { col1Title: 'Sütun 1', col1Text: 'Məzmun buradadır.', col2Title: 'Sütun 2', col2Text: 'Məzmun buradadır.', bg: '#ffffff', paddingY: '20' }
    },
    card: {
        label: 'Kart',
        props: { title: 'Kart Başlığı', text: 'Bu kart məzmunu nümunəsidir.', linkText: 'Daha çox →', linkUrl: '#', bg: '#f9fafb', radius: '10', paddingY: '20' }
    },
    footer: {
        label: 'Footer',
        props: { company: 'Şirkət Adı', year: '2025', unsubUrl: '#', privacyUrl: '#', bg: '#f3f4f6', color: '#9ca3af', paddingY: '28' }
    },
};

// ────────────────────────────────────────────────
//  RENDER HTML from block props
// ────────────────────────────────────────────────
function renderBlockHtml(type, props) {
    var font = globalSettings.fontFamily;
    switch (type) {
        case 'header':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="background:${props.bg};padding:${props.paddingY}px 30px;text-align:${props.align};font-family:${font};">
<tr><td><h1 style="color:${props.titleColor};margin:0;font-size:28px;font-weight:700;">${props.title}</h1></td></tr></table>`;
        case 'text':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};">
<tr><td style="color:${props.color};font-size:${props.fontSize}px;line-height:${props.lineHeight};text-align:${props.align};">${props.content.replace(/\n/g,'<br>')}</td></tr></table>`;
        case 'button':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};text-align:${props.align};">
<tr><td><a href="${props.url}" style="display:inline-block;background:${props.bg};color:${props.color};padding:13px 30px;border-radius:${props.radius}px;text-decoration:none;font-weight:600;font-size:15px;">${props.text}</a></td></tr></table>`;
        case 'image':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};text-align:${props.align};">
<tr><td><img src="${props.src}" alt="${props.alt}" style="max-width:100%;border-radius:${props.radius}px;" /></td></tr></table>`;
        case 'image-text':
            var imgCell  = `<td width="260" style="padding:0 16px;vertical-align:middle;"><img src="${props.src}" alt="${props.alt}" style="max-width:100%;border-radius:${props.radius}px;display:block;" /></td>`;
            var textCell = `<td style="padding:0 16px;vertical-align:middle;"><h3 style="margin:0 0 8px;color:#111;font-size:18px;">${props.title}</h3><p style="margin:0;color:${props.color};font-size:14px;line-height:1.7;">${props.text}</p></td>`;
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};">
<tr>${props.imgPos === 'right' ? textCell + imgCell : imgCell + textCell}</tr></table>`;
        case 'list':
            var items = props.items.split('\n').filter(function(x){ return x.trim() !== ''; })
                .map(function(item){ return `<tr><td style="padding:4px 0;color:${props.color};font-size:14px;line-height:1.6;"><span style="color:#6366f1;font-weight:700;margin-right:8px;">${props.icon}</span>${item}</td></tr>`; })
                .join('');
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};">
<tr><td>${props.title ? `<h3 style="margin:0 0 10px;color:#111;font-size:17px;">${props.title}</h3>` : ''}<table width="100%" cellpadding="0" cellspacing="0">${items}</table></td></tr></table>`;
        case 'quote':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};">
<tr><td style="background:${props.bg};border-left:4px solid #6366f1;border-radius:8px;padding:18px 22px;">
<p style="margin:0 0 8px;color:${props.color};font-size:15px;line-height:1.7;font-style:italic;">"${props.text}"</p>
<p style="margin:0;color:#9ca3af;font-size:13px;">${props.author}</p></td></tr></table>`;
        case 'social':
            var icons = [
                {key:'facebook',  char:'f',  color:'#1877f2'},
                {key:'instagram', char:'IG', color:'#e1306c'},
                {key:'twitter',   char:'X',  color:'#000000'},
                {key:'linkedin',  char:'in', color:'#0a66c2'}
            ];
            var links = icons.filter(function(i){ return props[i.key]; }).map(function(i){
                return `<a href="${props[i.key]}" style="display:inline-block;width:34px;height:34px;line-height:34px;border-radius:50%;background:${i.color};color:#ffffff;text-decoration:none;font-size:13px;font-weight:700;text-align:center;margin:0 5px;">${i.char}</a>`;
            }).join('');
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};">
<tr><td style="text-align:${props.align};">${links}</td></tr></table>`;
        case 'divider':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.margin}px 30px;font-family:${font};"><tr><td style="border-top:${props.thickness}px solid ${props.color};font-size:0;">&nbsp;</td></tr></table>`;
        case 'spacer':
            return `<table width="100%" cellpadding="0" cellspacing="0"><tr><td style="height:${props.height}px;line-height:${props.height}px;font-size:0;">&nbsp;</td></tr></table>`;
        case 'two-col':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};background:${props.bg};border-collapse:collapse;">
<tr><td width="50%" style="padding:12px;vertical-align:top;"><h3 style="margin:0 0 8px;color:#111;font-size:16px;">${props.col1Title}</h3><p style="color:#6b7280;font-size:14px;margin:0;">${props.col1Text}</p></td>
<td width="50%" style="padding:12px;vertical-align:top;border-left:1px solid #e5e7eb;"><h3 style="margin:0 0 8px;color:#111;font-size:16px;">${props.col2Title}</h3><p style="color:#6b7280;font-size:14px;margin:0;">${props.col2Text}</p></td></tr></table>`;
        case 'card':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="padding:${props.paddingY}px 30px;font-family:${font};">
<tr><td style="background:${props.bg};border-radius:${props.radius}px;padding:24px;border:1px solid #e5e7eb;">
<h2 style="margin:0 0 10px;color:#111;font-size:20px;">${props.title}</h2>
<p style="color:#6b7280;font-size:14px;line-height:1.6;margin:0 0 16px;">${props.text}</p>
<a href="${props.linkUrl}" style="color:#6366f1;font-weight:600;font-size:14px;text-decoration:none;">${props.linkText}</a></td></tr></table>`;
        case 'footer':
            return `<table width="100%" cellpadding="0" cellspacing="0" style="background:${props.bg};padding:${props.paddingY}px 30px;text-align:center;font-family:${font};">
<tr><td>
<p style="color:${props.color};font-size:12px;margin:0 0 8px;">© ${props.year} ${props.company}. Bütün hüquqlar qorunur.</p>
<p style="margin:0;font-size:11px;"><a href="${props.unsubUrl}" style="color:${props.color};text-decoration:underline;">Abunəlikdən çıx</a> · <a href="${props.privacyUrl}" style="color:${props.color};text-decoration:underline;">Məxfilik siyasəti</a></p>
</td></tr></table>`;
    }
    return '';
}

// ────────────────────────────────────────────────
//  CANVAS RENDER
// ────────────────────────────────────────────────
function renderCanvas() {
    var canvas = document.getElementById('canvas-email');
    var empty  = document.getElementById('canvas-empty');

    if (blocks.length === 0) {
        if (!empty) {
            var e = document.createElement('div');
            e.className = 'canvas-empty'; e.id = 'canvas-empty';
            e.innerHTML = '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12h14"/></svg><p>Sol tərəfdən blokları<br>sürükləyib buraya atın</p>';
            canvas.insertBefore(e, canvas.firstChild);
        }
    } else {
        var emp = document.getElementById('canvas-empty');
        if (emp) emp.remove();
    }

    // remove old block rows
    canvas.querySelectorAll('.email-block').forEach(function(el){ el.remove(); });

    blocks.forEach(function(b) {
        var row = document.createElement('div');
        row.className  = 'email-block' + (b.id === selectedId ? ' selected' : '');
        row.dataset.id = b.id;

        var inner = document.createElement('div');
        inner.innerHTML = renderBlockHtml(b.type, b.props);
        row.appendChild(inner);

        // drag handle
        var handle = document.createElement('div');
        handle.className = 'block-drag-handle'; handle.title = 'Yerdəyişdir';
        handle.innerHTML = '⠿';
        row.appendChild(handle);

        // controls
        var ctrl = document.createElement('div');
        ctrl.className = 'block-controls';
        ctrl.innerHTML = `<button class="block-ctrl-btn" title="Yuxarı" onclick="moveBlock('${b.id}',-1)">↑</button>
<button class="block-ctrl-btn" title="Aşağı" onclick="moveBlock('${b.id}',1)">↓</button>
<button class="block-ctrl-btn dup" title="Dublikat et" onclick="duplicateBlock('${b.id}')">⧉</button>
<button class="block-ctrl-btn del" title="Sil" onclick="deleteBlock('${b.id}')">✕</button>`;
        row.appendChild(ctrl);

        row.addEventListener('click', function(e) {
            if (e.target.closest('.block-ctrl-btn')) return;
            selectBlock(b.id);
        });

        canvas.appendChild(row);
    });

    // Sortable for reordering
    if (window._sortable) window._sortable.destroy();
    window._sortable = Sortable.create(canvas, {
        handle: '.block-drag-handle',
        animation: 150,
        filter: '.canvas-empty',
        onEnd: function(evt) {
            var moved = blocks.splice(evt.oldIndex, 1)[0];
            blocks.splice(evt.newIndex, 0, moved);
            pushHistory();
        }
    });
}

// ────────────────────────────────────────────────
//  BLOCK OPERATIONS
// ────────────────────────────────────────────────
function addBlock(type, atEnd) {
    var def = BLOCK_DEFAULTS[type];
    if (!def) return;
    var b = { id: 'b_' + Date.now() + '_' + Math.random().toString(36).slice(2,6), type: type, props: JSON.parse(JSON.stringify(def.props)) };
    blocks.push(b);
    renderCanvas();
    selectBlock(b.id);
    pushHistory();
}

function duplicateBlock(id) {
    var idx = blocks.findIndex(function(b){ return b.id === id; });
    if (idx < 0) return;
    var clone = JSON.parse(JSON.stringify(blocks[idx]));
    clone.id  = 'b_' + Date.now() + '_' + Math.random().toString(36).slice(2,6);
    blocks.splice(idx + 1, 0, clone);
    renderCanvas();
    selectBlock(clone.id);
    pushHistory();
}

function deleteBlock(id) {
    blocks = blocks.filter(function(b){ return b.id !== id; });
    if (selectedId === id) { selectedId = null; renderProps(null); }
    renderCanvas();
    pushHistory();
}

function moveBlock(id, dir) {
    var idx = blocks.findIndex(function(b){ return b.id === id; });
    if (idx < 0) return;
    var newIdx = idx + dir;
    if (newIdx < 0 || newIdx >= blocks.length) return;
    var tmp = blocks[idx]; blocks[idx] = blocks[newIdx]; blocks[newIdx] = tmp;
    renderCanvas();
    pushHistory();
}

function selectBlock(id) {
    selectedId = id;
    renderCanvas();
    var b = blocks.find(function(x){ return x.id === id; });
    renderProps(b);
}

// ────────────────────────────────────────────────
//  PROPERTIES PANEL
// ────────────────────────────────────────────────
function renderProps(block) {
    var empty   = document.getElementById('props-empty');
    var content = document.getElementById('props-content');
    if (!block) {
        empty.style.display   = 'flex';
        content.style.display = 'none';
        content.innerHTML     = '';
        return;
    }
    empty.style.display   = 'none';
    content.style.display = 'block';

    var html = '<div class="prop-group"><div class="prop-label">' + BLOCK_DEFAULTS[block.type].label + '</div>';
    var p = block.props;

    var fields = getPropFields(block.type, p);
    fields.forEach(function(f) {
        var fieldId = 'pf_' + block.id + '_' + f.key;
        html += '<div class="prop-row"><label>' + f.label + '</label>';
        if (f.type === 'color') {
            html += '<div class="color-row">'
                  + '<input type="color" value="' + f.value + '" oninput="updateProp(\'' + block.id + '\',\'' + f.key + '\',this.value);document.getElementById(\'ct_' + f.key + '\').value=this.value">'
                  + '<input type="text" id="ct_' + f.key + '" class="prop-input" value="' + f.value + '" oninput="updateProp(\'' + block.id + '\',\'' + f.key + '\',this.value)">'
                  + '</div>';
        } else if (f.type === 'textarea') {
            html += '<textarea id="' + fieldId + '" class="prop-textarea" oninput="updateProp(\'' + block.id + '\',\'' + f.key + '\',this.value)">' + f.value + '</textarea>';
        } else if (f.type === 'select') {
            html += '<select class="prop-input" onchange="updateProp(\'' + block.id + '\',\'' + f.key + '\',this.value)">';
            f.options.forEach(function(o) {
                html += '<option value="' + o.v + '"' + (f.value === o.v ? ' selected' : '') + '>' + o.l + '</option>';
            });
            html += '</select>';
        } else {
            html += '<input type="text" id="' + fieldId + '" class="prop-input" value="' + escAttr(f.value) + '" oninput="updateProp(\'' + block.id + '\',\'' + f.key + '\',this.value)">';
        }
        if (f.vars) {
            html += '<div class="var-chips">';
            VAR_TOKENS.forEach(function(v) {
                html += '<span class="var-chip" onclick="insertVar(\'' + fieldId + '\',\'' + v.token + '\')">+ ' + v.label + '</span>';
            });
            html += '</div>';
        }
        html += '</div>';
    });
    html += '</div>';
    content.innerHTML = html;
}

function getPropFields(type, p) {
    var alignOpts = [{v:'left',l:'Sol'},{v:'center',l:'Orta'},{v:'right',l:'Sağ'}];
    var sideOpts  = [{v:'left',l:'Solda'},{v:'right',l:'Sağda'}];
    var padding   = {key:'paddingY', label:'Şaquli boşluq (px)', type:'text', value: p.paddingY};
    switch (type) {
        case 'header': return [
            {key:'title',       label:'Başlıq mətni',    type:'text',     value: p.title, vars: true},
            {key:'bg',          label:'Fon rəngi',       type:'color',    value: p.bg},
            {key:'titleColor',  label:'Başlıq rəngi',    type:'color',    value: p.titleColor},
            {key:'align',       label:'Hizalanma',       type:'select',   value: p.align, options: alignOpts},
            padding,
        ];
        case 'text': return [
            {key:'content',    label:'Mətn',          type:'textarea', value: p.content, vars: true},
            {key:'color',      label:'Rəng',          type:'color',    value: p.color},
            {key:'fontSize',   label:'Şrift ölçüsü',  type:'text',     value: p.fontSize},
            {key:'lineHeight', label:'Sətir hündür.',  type:'text',     value: p.lineHeight},
            {key:'align',      label:'Hizalanma',     type:'select',   value: p.align, options: alignOpts},
            padding,
        ];
        case 'button': return [
            {key:'text',  label:'Düymə mətni', type:'text',  value: p.text, vars: true},
            {key:'url',   label:'Link (URL)',  type:'text',  value: p.url},
            {key:'bg',    label:'Fon rəngi',   type:'color', value: p.bg},
            {key:'color', label:'Mətn rəngi',  type:'color', value: p.color},
            {key:'align', label:'Hizalanma',   type:'select',value: p.align, options: alignOpts},
            {key:'radius',label:'Künc radiusu (px)', type:'text', value: p.radius},
            padding,
        ];
        case 'image': return [
            {key:'src',   label:'Şəkil URL',   type:'text', value: p.src},
            {key:'alt',   label:'Alt mətni',   type:'text', value: p.alt},
            {key:'align', label:'Hizalanma',   type:'select',value: p.align, options: alignOpts},
            {key:'radius',label:'Künc radiusu (px)', type:'text', value: p.radius},
            padding,
        ];
        case 'image-text': return [
            {key:'src',    label:'Şəkil URL',     type:'text',     value: p.src},
            {key:'alt',    label:'Alt mətni',     type:'text',     value: p.alt},
            {key:'imgPos', label:'Şəklin yeri',   type:'select',   value: p.imgPos, options: sideOpts},
            {key:'title',  label:'Başlıq',        type:'text',     value: p.title, vars: true},
            {key:'text',   label:'Mətn',          type:'textarea', value: p.text, vars: true},
            {key:'color',  label:'Mətn rəngi',    type:'color',    value: p.color},
            {key:'radius', label:'Şəkil radiusu (px)', type:'text', value: p.radius},
            padding,
        ];
        case 'list': return [
            {key:'title', label:'Başlıq (boş ola bilər)', type:'text',     value: p.title, vars: true},
            {key:'items', label:'Sətirlər (hər biri yeni sətirdə)', type:'textarea', value: p.items, vars: true},
            {key:'icon',  label:'İşarə',           type:'text',     value: p.icon},
            {key:'color', label:'Mətn rəngi',      type:'color',    value: p.color},
            padding,
        ];
        case 'quote': return [
            {key:'text',   label:'Sitat mətni', type:'textarea', value: p.text, vars: true},
            {key:'author', label:'Müəllif',     type:'text',     value: p.author, vars: true},
            {key:'color',  label:'Mətn rəngi',  type:'color',    value: p.color},
            {key:'bg',     label:'Fon rəngi',   type:'color',    value: p.bg},
            padding,
        ];
        case 'social': return [
            {key:'facebook',  label:'Facebook linki',  type:'text', value: p.facebook},
            {key:'instagram', label:'Instagram linki', type:'text', value: p.instagram},
            {key:'twitter',   label:'X (Twitter) linki', type:'text', value: p.twitter},
            {key:'linkedin',  label:'LinkedIn linki',  type:'text', value: p.linkedin},
            {key:'align',     label:'Hizalanma',       type:'select', value: p.align, options: alignOpts},
            padding,
        ];
        case 'divider': return [
            {key:'color',     label:'Rəng',         type:'color', value: p.color},
            {key:'thickness', label:'Qalınlıq (px)', type:'text', value: p.thickness},
            {key:'margin',    label:'Boşluq (px)',   type:'text', value: p.margin},
        ];
        case 'spacer': return [
            {key:'height', label:'Hündürlük (px)', type:'text', value: p.height},
        ];
        case 'two-col': return [
            {key:'col1Title', label:'1-ci sütun başlığı', type:'text', value: p.col1Title, vars: true},
            {key:'col1Text',  label:'1-ci sütun mətni',   type:'textarea', value: p.col1Text, vars: true},
            {key:'col2Title', label:'2-ci sütun başlığı', type:'text', value: p.col2Title, vars: true},
            {key:'col2Text',  label:'2-ci sütun mətni',   type:'textarea', value: p.col2Text, vars: true},
            {key:'bg',        label:'Fon rəngi',           type:'color', value: p.bg},
            padding,
        ];
        case 'card': return [
            {key:'title',    label:'Başlıq',       type:'text',     value: p.title, vars: true},
            {key:'text',     label:'Mətn',         type:'textarea', value: p.text, vars: true},
            {key:'linkText', label:'Link mətni',   type:'text',     value: p.linkText, vars: true},
            {key:'linkUrl',  label:'Link URL',     type:'text',     value: p.linkUrl},
            {key:'bg',       label:'Fon rəngi',    type:'color',    value: p.bg},
            {key:'radius',   label:'Künc radiusu (px)', type:'text', value: p.radius},
            padding,
        ];
        case 'footer': return [
            {key:'company',     label:'Şirkət adı',   type:'text',  value: p.company, vars: true},
            {key:'year',        label:'İl',            type:'text',  value: p.year},
            {key:'unsubUrl',    label:'Çıxış linki',  type:'text',  value: p.unsubUrl},
            {key:'privacyUrl',  label:'Gizlilik linki',type:'text', value: p.privacyUrl},
            {key:'bg',          label:'Fon rəngi',    type:'color', value: p.bg},
            {key:'color',       label:'Mətn rəngi',   type:'color', value: p.color},
            padding,
        ];
    }
    return [];
}

var _historyTimer = null;
function updateProp(id, key, val) {
    var b = blocks.find(function(x){ return x.id === id; });
    if (!b) return;
    b.props[key] = val;
    // update only that block row's inner html
    var row = document.querySelector('[data-id="' + id + '"] > div:first-child');
    if (row) row.innerHTML = renderBlockHtml(b.type, b.props);
    clearTimeout(_historyTimer);
    _historyTimer = setTimeout(pushHistory, 600);
}

function escAttr(s) {
    return String(s).replace(/"/g, '&quot;').replace(/</g, '&lt;');
}

// ────────────────────────────────────────────────
//  DRAG & DROP (from palette)
// ────────────────────────────────────────────────
document.querySelectorAll('.block-chip').forEach(function(chip) {
    chip.addEventListener('dragstart', function(e) {
        dragType = this.dataset.block;
        e.dataTransfer.effectAllowed = 'copy';
    });
    chip.addEventListener('dragend', function() { dragType = null; });
});

function handleDragOver(e) {
    if (!dragType) return;
    e.preventDefault();
    e.dataTransfer.dropEffect = 'copy';
    document.getElementById('canvas-email').classList.add('drag-over');
}
function handleDragLeave() {
    document.getElementById('canvas-email').classList.remove('drag-over');
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('canvas-email').classList.remove('drag-over');
    if (dragType) { addBlock(dragType); dragType = null; }
}

// ────────────────────────────────────────────────
//  DEVICE SWITCHER
// ────────────────────────────────────────────────
function setDevice(mode, btn) {
    var c = document.getElementById('canvas-email');
    c.classList.remove('tablet','mobile');
    if (mode === 'tablet') c.classList.add('tablet');
    if (mode === 'mobile') c.classList.add('mobile');
    document.querySelectorAll('.dev-btn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    c.style.width = (mode === 'desktop') ? (globalSettings.contentWidth + 'px') : '';
}

// ────────────────────────────────────────────────
//  GLOBAL SETTINGS (page bg / content width / font)
// ────────────────────────────────────────────────
function openSettings() {
    document.getElementById('set-bgColor').value      = globalSettings.bgColor;
    document.getElementById('set-bgColorTxt').value   = globalSettings.bgColor;
    document.getElementById('set-contentWidth').value = globalSettings.contentWidth;
    document.getElementById('set-fontFamily').value   = globalSettings.fontFamily;
    document.getElementById('settings-modal').style.display = 'flex';
}
function closeSettings() {
    document.getElementById('settings-modal').style.display = 'none';
}
function saveSettings() {
    globalSettings.bgColor      = document.getElementById('set-bgColorTxt').value.trim() || '#f1f5f9';
    globalSettings.contentWidth = document.getElementById('set-contentWidth').value.trim() || '600';
    globalSettings.fontFamily   = document.getElementById('set-fontFamily').value;
    applyGlobalSettings();
    closeSettings();
    pushHistory();
    toast('Ayarlar tətbiq edildi.', 'ok');
}
function applyGlobalSettings() {
    var wrap = document.querySelector('.tb-canvas');
    if (wrap) wrap.style.background = globalSettings.bgColor;
    var email = document.getElementById('canvas-email');
    if (email) {
        var activeBtn = document.querySelector('.dev-btn.active');
        var isDesktop = !activeBtn || activeBtn.title === 'Desktop';
        email.style.width = isDesktop ? (globalSettings.contentWidth + 'px') : '';
    }
    renderCanvas();
}

// ────────────────────────────────────────────────
//  PRESET SECTIONS
// ────────────────────────────────────────────────
var PRESETS = {
    welcome: [
        { type: 'header', props: { bg: '#10b981', title: 'Xoş gəlmisiniz, [[NAME]]!', titleColor: '#ffffff', subtitleColor: 'rgba(255,255,255,0.85)', align: 'center', paddingY: '40' } },
        { type: 'text',   props: { content: 'Ailəmizə qoşulduğunuz üçün təşəkkür edirik. Hesabınızdan maksimum yararlanmaq üçün aşağıdakı düyməyə klikləyin.', color: '#374151', fontSize: '15', lineHeight: '1.8', align: 'left', paddingY: '24' } },
        { type: 'button', props: { text: 'Hesabıma keç', url: '[[BUTTON_URL]]', bg: '#10b981', color: '#ffffff', align: 'center', radius: '8', paddingY: '10' } },
    ],
    promo: [
        { type: 'header', props: { bg: '#6366f1', title: '🎉 Xüsusi Kampaniya', titleColor: '#ffffff', subtitleColor: 'rgba(255,255,255,0.85)', align: 'center', paddingY: '36' } },
        { type: 'text',   props: { content: '[[NAME]], sizin üçün xüsusi endirim hazırladıq! [[COUPON]] kuponu ilə endirimdən yararlanın.', color: '#374151', fontSize: '15', lineHeight: '1.8', align: 'center', paddingY: '20' } },
        { type: 'button', props: { text: 'İndi istifadə et', url: '[[BUTTON_URL]]', bg: '#6366f1', color: '#ffffff', align: 'center', radius: '8', paddingY: '10' } },
        { type: 'divider', props: { color: '#e5e7eb', thickness: '1', margin: '20' } },
    ],
    cta: [
        { type: 'text',   props: { content: 'Növbəti addımı atmağa hazırsınız?', color: '#111827', fontSize: '18', lineHeight: '1.6', align: 'center', paddingY: '20' } },
        { type: 'button', props: { text: '[[BUTTON_TEXT]]', url: '[[BUTTON_URL]]', bg: '#0f172a', color: '#ffffff', align: 'center', radius: '8', paddingY: '8' } },
    ],
};

function addPreset(name) {
    var preset = PRESETS[name];
    if (!preset) return;
    preset.forEach(function(item) {
        var def = BLOCK_DEFAULTS[item.type];
        if (!def) return;
        var props = JSON.parse(JSON.stringify(def.props));
        Object.assign(props, item.props);
        blocks.push({ id: 'b_' + Date.now() + '_' + Math.random().toString(36).slice(2,6), type: item.type, props: props });
    });
    renderCanvas();
    pushHistory();
    toast('Bölmə əlavə edildi.', 'ok');
}

// ────────────────────────────────────────────────
//  VARIABLE INSERT (merge tags)
// ────────────────────────────────────────────────
function insertVar(fieldId, token) {
    var el = document.getElementById(fieldId);
    if (!el) return;
    var start = el.selectionStart != null ? el.selectionStart : el.value.length;
    var end   = el.selectionEnd   != null ? el.selectionEnd   : el.value.length;
    el.value = el.value.slice(0, start) + token + el.value.slice(end);
    el.selectionStart = el.selectionEnd = start + token.length;
    el.dispatchEvent(new Event('input'));
    el.focus();
}

// ────────────────────────────────────────────────
//  HISTORY (UNDO / REDO)
// ────────────────────────────────────────────────
function pushHistory() {
    history = history.slice(0, historyIndex + 1);
    history.push(JSON.stringify({ blocks: blocks, settings: globalSettings }));
    if (history.length > MAX_HISTORY) history.shift();
    historyIndex = history.length - 1;
    updateUndoRedoButtons();
}
function undo() {
    if (historyIndex <= 0) return;
    historyIndex--;
    restoreHistory();
}
function redo() {
    if (historyIndex >= history.length - 1) return;
    historyIndex++;
    restoreHistory();
}
function restoreHistory() {
    var state = JSON.parse(history[historyIndex]);
    blocks = state.blocks;
    globalSettings = state.settings;
    selectedId = null;
    renderProps(null);
    applyGlobalSettings();
    updateUndoRedoButtons();
}
function updateUndoRedoButtons() {
    var u = document.getElementById('undo-btn');
    var r = document.getElementById('redo-btn');
    if (u) u.disabled = historyIndex <= 0;
    if (r) r.disabled = historyIndex >= history.length - 1;
}

// ────────────────────────────────────────────────
//  EXPORT HTML
// ────────────────────────────────────────────────
function buildHtml() {
    var inner = blocks.map(function(b){ return renderBlockHtml(b.type, b.props); }).join('');
    var width = globalSettings.contentWidth || '600';
    var font  = globalSettings.fontFamily || 'Arial, Helvetica, sans-serif';
    var bg    = globalSettings.bgColor || '#f1f5f9';
    return '<table width="100%" cellpadding="0" cellspacing="0" style="background:' + bg + ';font-family:' + font + ';padding:24px 0;">'
         + '<tr><td align="center">'
         + '<table width="' + width + '" cellpadding="0" cellspacing="0" style="background:#ffffff;max-width:' + width + 'px;width:100%;margin:0 auto;">'
         + inner
         + '</table></td></tr></table>';
}

// ────────────────────────────────────────────────
//  PREVIEW
// ────────────────────────────────────────────────
function previewEmail() {
    if (blocks.length === 0) { toast('Önizləmə üçün blok əlavə edin.', 'err'); return; }
    var html = buildHtml();
    document.getElementById('prev-iframe').srcdoc =
        '<!DOCTYPE html><html><body style="margin:0;padding:0;">' + html + '</body></html>';
    document.getElementById('prev-modal').style.display = 'flex';
}
function closePrev() { document.getElementById('prev-modal').style.display = 'none'; }
function copyHtmlToClipboard() {
    navigator.clipboard.writeText(buildHtml())
        .then(function(){ toast('HTML kopyalandı!', 'info'); })
        .catch(function(){ toast('Kopyalama uğursuz.', 'err'); });
}

// ────────────────────────────────────────────────
//  SAVE
// ────────────────────────────────────────────────
async function saveTemplate() {
    var name = document.getElementById('tpl-name').value.trim();
    if (!name) { toast('Şablon adını daxil edin!', 'err'); document.getElementById('tpl-name').focus(); return; }
    if (blocks.length === 0) { toast('Ən az bir blok əlavə edin!', 'err'); return; }

    var html   = buildHtml();
    var btn    = document.getElementById('save-btn');
    var url    = isEdit ? '/admin/templates/' + existingTpl.id : '{{ route('admin.templates.store') }}';
    var method = isEdit ? 'PUT' : 'POST';

    btn.classList.add('loading'); btn.textContent = '...';
    try {
        var res  = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ name: name, html_content: html })
        });
        var data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Xəta');
        toast(data.message || (isEdit ? 'Yeniləndi!' : 'Saxlanıldı!'), 'ok');
        setTimeout(function(){ window.location.href = '{{ route('admin.templates.index') }}'; }, 1600);
    } catch (err) {
        toast(err.message || 'Xəta baş verdi.', 'err');
    } finally {
        btn.classList.remove('loading'); btn.textContent = isEdit ? 'Yenilə' : 'Yadda saxla';
    }
}

// ────────────────────────────────────────────────
//  TOAST
// ────────────────────────────────────────────────
function toast(msg, type) {
    var icons = {ok:'✓', err:'✕', info:'ℹ'};
    var t = document.getElementById('tb-toast');
    t.className = type + ' show';
    t.querySelector('.ti').textContent = icons[type] || '✓';
    document.getElementById('tb-toast-msg').textContent = msg;
    clearTimeout(t._t);
    t._t = setTimeout(function(){ t.classList.remove('show'); }, 3000);
}

// ────────────────────────────────────────────────
//  LOAD EXISTING (edit mode) — parse blocks from saved HTML
// ────────────────────────────────────────────────
if (isEdit && existingTpl.html) {
    // For edit mode: try to rebuild block state from saved HTML.
    // Since we now save structured blocks, we attempt to parse.
    // Fallback: inject raw HTML as a single "text" block so content is not lost.
    var raw = existingTpl.html;
    // Check if it was built with this builder (structured blocks joined in a table)
    // Simple approach: add as one raw html block so user sees their content
    var raw = existingTpl.html;
    blocks.push({
        id: 'b_imported',
        type: '_raw',
        props: { html: raw }
    });

    // Override renderBlockHtml for _raw type
    var _orig = renderBlockHtml;
    renderBlockHtml = function(type, props) {
        if (type === '_raw') return props.html;
        return _orig(type, props);
    };

    // Show a notice
    setTimeout(function(){
        toast('Köhnə şablon yükləndi. Blokları yenidən sürükləyib əlavə edə bilərsiniz.', 'info');
    }, 600);
}

// ────────────────────────────────────────────────
//  INIT
// ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    applyGlobalSettings();
    pushHistory();
});

document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') { e.preventDefault(); saveTemplate(); }

    var typing = document.activeElement && (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA');

    if (!typing && (e.ctrlKey || e.metaKey) && !e.shiftKey && e.key.toLowerCase() === 'z') { e.preventDefault(); undo(); }
    if (!typing && (e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'y' || (e.shiftKey && e.key.toLowerCase() === 'z'))) { e.preventDefault(); redo(); }

    if (e.key === 'Escape') { closePrev(); closeSettings(); }
    if (e.key === 'Delete' && selectedId && !typing) {
        deleteBlock(selectedId);
    }
});
</script>
@endpush