@php
    $statePath = $getStatePath();
@endphp

<div
    x-data="{
        state: $wire.$entangle('{{ $statePath }}'),
        savedRange: null,
        initializeEditor() {
            this.$refs.editor.innerHTML = this.state || '';
        },
        rememberSelection() {
            const selection = window.getSelection();

            if (! selection.rangeCount) return;

            const range = selection.getRangeAt(0);

            if (this.$refs.editor.contains(range.commonAncestorContainer)) {
                this.savedRange = range.cloneRange();
            }
        },
        restoreSelection() {
            if (! this.savedRange) return;

            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(this.savedRange);
        },
        format(command, value = null) {
            this.$refs.editor.focus();
            this.restoreSelection();
            document.execCommand(command, false, value);
            this.sync();
            this.rememberSelection();
        },
        sync() {
            this.state = this.$refs.editor.innerHTML;
        },
    }"
    x-init="initializeEditor()"
    class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/5 dark:ring-white/20"
>
    <div class="flex flex-wrap items-center gap-1.5 border-b border-gray-200 bg-gray-50 p-2 dark:border-white/10 dark:bg-white/5" role="toolbar" aria-label="Herramientas de formato">
        <label class="sr-only" for="{{ $getId() }}-font-size">Tamaño del texto</label>
        <select
            id="{{ $getId() }}-font-size"
            class="h-9 rounded-lg border-0 bg-white px-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-950/10 focus:ring-2 focus:ring-primary-600 dark:bg-gray-900 dark:text-gray-200 dark:ring-white/10"
            @mousedown="rememberSelection()"
            @change="format('fontSize', $event.target.value); $event.target.value = ''"
            title="Tamaño del texto"
        >
            <option value="">Tamaño</option>
            <option value="2">Pequeño</option>
            <option value="3">Normal</option>
            <option value="4">Mediano</option>
            <option value="5">Grande</option>
            <option value="6">Muy grande</option>
        </select>

        <span class="mx-1 h-6 w-px bg-gray-300 dark:bg-white/15" aria-hidden="true"></span>

        @foreach([
            ['bold', 'Negrita', 'B'],
            ['italic', 'Cursiva', 'I'],
            ['underline', 'Subrayado', 'U'],
        ] as [$command, $title, $label])
            <button type="button" class="flex h-9 min-w-9 items-center justify-center rounded-lg px-2 text-sm font-bold text-gray-700 transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('{{ $command }}')" title="{{ $title }}" aria-label="{{ $title }}">
                <span @class(['italic' => $command === 'italic', 'underline' => $command === 'underline'])>{{ $label }}</span>
            </button>
        @endforeach

        <span class="mx-1 h-6 w-px bg-gray-300 dark:bg-white/15" aria-hidden="true"></span>

        <button type="button" class="h-9 rounded-lg px-2.5 text-xs font-bold text-gray-700 hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('justifyLeft')" title="Alinear a la izquierda" aria-label="Alinear a la izquierda">Izquierda</button>
        <button type="button" class="h-9 rounded-lg px-2.5 text-xs font-bold text-gray-700 hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('justifyCenter')" title="Centrar" aria-label="Centrar">Centro</button>
        <button type="button" class="h-9 rounded-lg px-2.5 text-xs font-bold text-gray-700 hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('justifyRight')" title="Alinear a la derecha" aria-label="Alinear a la derecha">Derecha</button>

        <span class="mx-1 h-6 w-px bg-gray-300 dark:bg-white/15" aria-hidden="true"></span>

        <button type="button" class="h-9 rounded-lg px-2.5 text-sm font-bold text-gray-700 hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('insertUnorderedList')" title="Lista con viñetas" aria-label="Lista con viñetas">• Lista</button>
        <button type="button" class="h-9 rounded-lg px-2.5 text-sm font-bold text-gray-700 hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('insertOrderedList')" title="Lista numerada" aria-label="Lista numerada">1. Lista</button>

        <span class="mx-1 h-6 w-px bg-gray-300 dark:bg-white/15" aria-hidden="true"></span>

        <button type="button" class="h-9 rounded-lg px-2.5 text-base text-gray-700 hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('undo')" title="Deshacer" aria-label="Deshacer">↶</button>
        <button type="button" class="h-9 rounded-lg px-2.5 text-base text-gray-700 hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-white/10" @mousedown.prevent="format('redo')" title="Rehacer" aria-label="Rehacer">↷</button>
    </div>

    <div
        x-ref="editor"
        contenteditable="true"
        role="textbox"
        aria-multiline="true"
        data-placeholder="Escribe aquí toda la información del proyecto..."
        @input.debounce.250ms="sync(); rememberSelection()"
        @keyup="rememberSelection()"
        @mouseup="rememberSelection()"
        @blur="rememberSelection(); sync()"
        class="mini-rich-editor min-h-[360px] w-full px-4 py-4 text-base leading-7 text-gray-950 outline-none dark:text-white [&_div]:min-h-[1.5rem] [&_font]:leading-relaxed [&_ol]:list-decimal [&_ol]:pl-6 [&_ul]:list-disc [&_ul]:pl-6"
    ></div>
</div>

<style>
    .mini-rich-editor:empty::before {
        color: rgb(156 163 175);
        content: attr(data-placeholder);
        pointer-events: none;
    }

    .mini-rich-editor ul {
        list-style: disc outside;
        margin: 0.75rem 0;
        padding-left: 1.75rem;
    }

    .mini-rich-editor ol {
        list-style: decimal outside;
        margin: 0.75rem 0;
        padding-left: 1.75rem;
    }

    .mini-rich-editor li {
        display: list-item;
        margin: 0.25rem 0;
    }
</style>
