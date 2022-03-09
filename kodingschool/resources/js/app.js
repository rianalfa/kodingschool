require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all.min.js');

//AlpineJS
    import Alpine from 'alpinejs';
    window.Alpine = Alpine;
    Alpine.data('initData', () => ({
            isSideMenuOpen: false,
            toggleSideMenu() {
                this.isSideMenuOpen = !this.isSideMenuOpen
            },
            closeSideMenu() {
                this.isSideMenuOpen = false
            },
        })
    );
    Alpine.start();
    window.$ = require( "jquery" );

//SweetAlert
    import swal from 'sweetalert2';
    window.Swal = swal;

//Toast UI Editor
    import Editor from '@toast-ui/editor';
    import Viewer from '@toast-ui/editor/dist/toastui-editor-viewer';
    import 'codemirror/lib/codemirror.css';
    import '@toast-ui/editor/dist/toastui-editor.css';
    import '@toast-ui/editor/dist/toastui-editor-viewer.css';
    window.Editor = Editor;
    window.Viewer = Viewer;

    import 'tui-color-picker/dist/tui-color-picker.css';
    import '@toast-ui/editor-plugin-color-syntax/dist/toastui-editor-plugin-color-syntax.css';
    import colorSyntax from '@toast-ui/editor-plugin-color-syntax';
    window.colorSyntax = colorSyntax;

    import 'prismjs/themes/prism.css';
    import '@toast-ui/editor-plugin-code-syntax-highlight/dist/toastui-editor-plugin-code-syntax-highlight.css';
    import codeSyntaxHighlight from '@toast-ui/editor-plugin-code-syntax-highlight';
    window.codeSyntaxHighlight = codeSyntaxHighlight;

//CodeMirror
    import CodeMirror from 'codemirror';
    import 'codemirror/addon/edit/matchbrackets';
    import 'codemirror/mode/javascript/javascript.js';
    import 'codemirror/mode/htmlmixed/htmlmixed.js';
    import 'codemirror/mode/xml/xml.js';
    import 'codemirror/mode/css/css.js';
    import 'codemirror/mode/clike/clike.js';
    import 'codemirror/mode/php/php.js';
    window.CodeMirror = CodeMirror;
