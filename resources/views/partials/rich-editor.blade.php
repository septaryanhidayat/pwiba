{{-- TinyMCE 6 WYSIWYG Editor Component (WordPress CMS Style) --}}
@once
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        /* Styling kontainer TinyMCE agar senada dengan UI Modern PWI Banyuasin */
        .tox-tinymce {
            border-radius: 1rem !important;
            border-color: #cbd5e1 !important;
            overflow: hidden !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .dark .tox-tinymce {
            border-color: #334155 !important;
            background-color: #0f172a !important;
        }
        .tox .tox-toolbar, .tox .tox-toolbar__overflow, .tox .tox-toolbar__primary {
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
        .dark .tox .tox-toolbar, .dark .tox .tox-toolbar__overflow, .dark .tox .tox-toolbar__primary {
            background: #1e293b !important;
            border-bottom: 1px solid #334155 !important;
        }
        .tox .tox-tbtn {
            border-radius: 6px !important;
            margin: 2px 1px !important;
        }
        .tox .tox-tbtn:hover {
            background: #e2e8f0 !important;
        }
        .dark .tox .tox-tbtn:hover {
            background: #334155 !important;
        }
        .tox .tox-tbtn--enabled, .tox .tox-tbtn--enabled:hover {
            background: #dbeafe !important;
            color: #1d4ed8 !important;
        }
        .dark .tox .tox-tbtn--enabled, .dark .tox .tox-tbtn--enabled:hover {
            background: #1e3a8a !important;
            color: #93c5fd !important;
        }
        .tox-statusbar {
            border-top: 1px solid #e2e8f0 !important;
            font-size: 11px !important;
            background: #f8fafc !important;
        }
        .dark .tox-statusbar {
            border-top: 1px solid #334155 !important;
            background: #1e293b !important;
            color: #94a3b8 !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initWordPressEditor();
        });

        function initWordPressEditor() {
            if (typeof tinymce === 'undefined') return;

            const isDark = document.documentElement.classList.contains('dark');
            const editorElements = document.querySelectorAll('.rich-editor');

            editorElements.forEach(function(el) {
                // Catat jika sebelumnya memiliki atribut required agar validasi manual tetap jalan
                if (el.hasAttribute('required')) {
                    el.dataset.wasRequired = 'true';
                    el.removeAttribute('required');
                }
            });

            tinymce.init({
                selector: '.rich-editor',
                height: 380,
                min_height: 280,
                menubar: false,
                branding: false,
                promotion: false,
                statusbar: true,
                language: 'id',
                plugins: [
                    'autolink', 'lists', 'link', 'charmap', 'preview', 'anchor',
                    'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'table', 'help', 'wordcount'
                ],
                // Toolbar mirip WordPress CMS Classic Editor dengan dua baris rapi
                toolbar1: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify',
                toolbar2: 'bullist numlist | outdent indent | blockquote link unlink | table | removeformat | code fullscreen',
                
                block_formats: 'Paragraf=p; Judul 1 (H1)=h1; Judul 2 (H2)=h2; Judul 3 (H3)=h3; Judul 4 (H4)=h4; Kutipan=blockquote; Kode=pre',
                font_size_formats: '9pt 10pt 11pt 12pt 13pt 14pt 16pt 18pt 20pt 24pt 28pt 36pt',
                font_family_formats: 'Plus Jakarta Sans=Plus Jakarta Sans,sans-serif; Arial=arial,helvetica,sans-serif; Times New Roman=times new roman,times,serif; Georgia=georgia,palatino,serif; Courier New=courier new,courier,monospace',
                
                color_map: [
                    '0B132B', 'PWI Navy',
                    '0B2B68', 'PWI Blue',
                    '1E293B', 'Slate Dark',
                    '475569', 'Muted Gray',
                    'DC2626', 'Merah Peringatan',
                    'D97706', 'Emas / Amber',
                    '16A34A', 'Hijau Sukses',
                    '2563EB', 'Biru Utama',
                    '7C3AED', 'Ungu',
                    '000000', 'Hitam Pekat',
                    'FFFFFF', 'Putih',
                ],

                skin: isDark ? 'oxide-dark' : 'oxide',
                content_css: isDark ? 'dark' : 'default',
                
                content_style: `
                    body {
                        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                        font-size: 14px;
                        line-height: 1.7;
                        color: ${isDark ? '#f1f5f9' : '#0f172a'};
                        background-color: ${isDark ? '#0b132b' : '#ffffff'};
                        padding: 14px;
                    }
                    p { margin: 0 0 12px 0; }
                    h1, h2, h3, h4 { font-weight: 700; margin: 18px 0 8px 0; line-height: 1.25; }
                    blockquote {
                        border-left: 3px solid #2563eb;
                        margin: 12px 0;
                        padding-left: 12px;
                        font-style: italic;
                        color: ${isDark ? '#94a3b8' : '#475569'};
                    }
                    table { border-collapse: collapse; width: 100%; margin: 12px 0; }
                    table td, table th { border: 1px solid ${isDark ? '#334155' : '#cbd5e1'}; padding: 6px 10px; }
                `,

                setup: function(editor) {
                    editor.on('change keyup NodeChange SetContent', function() {
                        editor.save();
                    });

                    // Validasi form saat submit
                    editor.on('init', function() {
                        const targetEl = editor.getElement();
                        if (targetEl && targetEl.form) {
                            const form = targetEl.form;
                            if (!form.dataset.tinymceAttached) {
                                form.dataset.tinymceAttached = 'true';
                                form.addEventListener('submit', function(e) {
                                    tinymce.triggerSave();
                                    
                                    // Periksa field yang wajib diisi
                                    const requiredEditors = form.querySelectorAll('.rich-editor[data-was-required="true"]');
                                    for (let reqEl of requiredEditors) {
                                        const ed = tinymce.get(reqEl.id);
                                        if (ed) {
                                            const contentText = ed.getContent({ format: 'text' }).trim();
                                            if (contentText.length === 0 && !ed.getContent().includes('<img')) {
                                                e.preventDefault();
                                                ed.focus();
                                                if (typeof Swal !== 'undefined') {
                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'Bidang Wajib Diisi',
                                                        text: 'Harap lengkapi isi konten teks sebelum menyimpan dokumen.',
                                                        confirmButtonColor: '#2563eb',
                                                        confirmButtonText: 'Baik, Saya Mengerti'
                                                    });
                                                } else {
                                                    alert('Harap lengkapi teks sebelum menyimpan dokumen.');
                                                }
                                                return false;
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endonce
