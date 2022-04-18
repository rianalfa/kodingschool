// Notyf
const { default: Editor } = require("@toast-ui/editor");
const { isElement, isEqual } = require("lodash");
const notification = require("notyf");
    const notyf = new notification.Notyf({ duration: 3000 });

    Livewire.on("error", (message) => {
        notyf.error(message);
    });

    Livewire.on("success", (message) => {
        notyf.success(message);
    });

// Swal
    const Swal = require('sweetalert2');
    Livewire.on('swal', (type, message) => {
        Swal.fire({
            'icon': type,
            'title': '',
            'text': message,
            'buttonsStyling': false,
            'customClass': {
                'confirmButton': 'font-semibold text-sm tracking-widest bg-gray-700 hover:bg-gray-500 text-white rounded-md active:bg-gray-500 focus:border-gray-500 focus:ring-gray-400 anchor-button py-2 px-4'
            },
        });
    });

    Livewire.on('swalcus', (iconHtml, message) => {
        Swal.fire({
            'iconHtml': iconHtml,
            'title': '',
            'text': message,
            'buttonsStyling': false,
            'customClass': {
                'confirmButton': 'font-semibold text-sm tracking-widest bg-gray-700 hover:bg-gray-500 text-white rounded-md active:bg-gray-500 focus:border-gray-500 focus:ring-gray-400 anchor-button py-2 px-4'
            },
        })
    });

// Modal
    Livewire.on('openmodal', (id) => {
        document.getElementById(id).style.display='block';
    });

    Livewire.on('closemodal', (id) => {
        document.getElementById(id).style.display='none';
    });

//Console log
    Livewire.on('consolelog', (text) => {
        console.log(text);
    });

//Viewer
    Livewire.on('viewer', (id, text) => {
        const viewer = new Viewer({
            el: document.getElementById(id),
            initialValue: text,
            plugins: [codeSyntaxHighlight],
        });
    });

//CodeMirror
    let codeEditor;
    Livewire.on('codeEditor', (id, mode) => {
        codeEditor = CodeMirror.fromTextArea(document.getElementById(id), {
            theme: 'dracula',
            matchBrackets: true,
            mode: mode,
            indentUnit: 4,
            smartIndent: true,
            indentWithTabs: true,
            cursorHeight: 0.85,
        });
        codeEditor.setSize("100%", "100%");
    });

    Livewire.on('saveCodeEditor', () => {
        if (codeEditor) {
            Livewire.emit('nextMatter', codeEditor.getValue());
        } else {
            Livewire.emit('nextMatter', '');
        }
    });

    Livewire.on('runScript', () => {
        if (codeEditor) {
            Livewire.emit('showScript', codeEditor.getValue());
        }
    });

//HTML Differ Checker
    const HtmlDiffer = require('html-differ').HtmlDiffer;
    Livewire.on('htmldiffer', (html1, html2) => {
        htmlDiffer = new HtmlDiffer({
            preset: 'bem',
            ignoreAttributes: ['for'],
            ignoreWhitespaces: true,
            ignoreComments: true,
        });

        isEq = htmlDiffer.isEqual(html1, html2);
        Livewire.emit('next', html1, isEq);
    });

//Go to top page
    Livewire.on('goToTop', () => {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    });
