<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Builder - {{ $page->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- GrapesJS core CSS -->
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        #gjs {
            height: 100vh;
            width: 100%;
        }
        
        /* Add a custom panel for the save button */
        .gjs-pn-panel.gjs-pn-options {
            display: flex;
            align-items: center;
        }
        .custom-save-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 15px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
            margin-right: 10px;
        }
        .custom-save-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div id="gjs">
        @if($page->html)
            {!! $page->html !!}
            <style>{!! $page->css !!}</style>
        @else
            <div class="p-8 text-center bg-gray-100 min-h-screen">
                <h1 class="text-4xl font-bold text-gray-800">Welcome to {{ $page->title }}</h1>
                <p class="text-gray-600 mt-4">Start dragging blocks from the right panel to build your page.</p>
            </div>
        @endif
    </div>

    <!-- GrapesJS core JS -->
    <script src="https://unpkg.com/grapesjs"></script>
    
    <!-- GrapesJS Tailwind Plugin -->
    <script src="https://unpkg.com/grapesjs-tailwind"></script>

    <!-- GrapesJS Basic Blocks Plugin (optional but helpful) -->
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>

    <script>
        const pageId = {{ $page->id }};
        const saveEndpoint = "{{ route('admin.cms.saveBuilder', $page->id) }}";
        const uploadEndpoint = "{{ route('admin.cms.uploadAsset') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const editor = grapesjs.init({
            container: '#gjs',
            fromElement: true,
            height: '100vh',
            width: 'auto',
            
            storageManager: {
                type: 'remote',
                stepsBeforeSave: 1,
                options: {
                    remote: {
                        urlStore: saveEndpoint,
                        urlLoad: '', // We load manually via Blade initially, or setup API if needed
                        fetchOptions: opts => (opts.method === 'POST' ?  { method: 'POST' }  : {}),
                        onStore: (data, editor) => {
                            // Extract HTML and CSS
                            const html = editor.getHtml();
                            const css = editor.getCss();
                            
                            return {
                                _token: csrfToken,
                                html: html,
                                css: css,
                                gjs_data: JSON.stringify(data)
                            };
                        }
                    }
                }
            },
            
            assetManager: {
                upload: uploadEndpoint,
                uploadName: 'files',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                autoAdd: true,
            },

            plugins: ['grapesjs-tailwind', 'gjs-blocks-basic'],
            pluginsOpts: {
                'grapesjs-tailwind': {
                    // Tailwind plugin options
                },
                'gjs-blocks-basic': {
                    flexGrid: true,
                }
            },
            
            canvas: {
                styles: [
                    // Load your project's main CSS or Tailwind CDN for the canvas to render correctly
                    'https://cdn.tailwindcss.com'
                ],
                scripts: []
            }
        });

        // Add a manual Save button to the top panel
        editor.Panels.addButton('options', {
            id: 'save-db',
            className: 'custom-save-btn',
            label: 'Save Page',
            command: function(editor) {
                editor.store();
                alert('Page saved successfully!');
            },
            attributes: { title: 'Save Page' }
        });
        
        // Add a back button
        editor.Panels.addButton('options', {
            id: 'go-back',
            className: 'custom-save-btn',
            style: 'background-color: #6c757d;',
            label: 'Exit',
            command: function() {
                window.location.href = "{{ route('admin.cms.index') }}";
            },
            attributes: { title: 'Back to CMS Pages' }
        });

        @if($page->gjs_data)
            // If we have saved raw data, load it (this preserves complex GrapesJS state)
            const gjsData = {!! $page->gjs_data !!};
            if(Object.keys(gjsData).length > 0) {
                editor.loadProjectData(gjsData);
            }
        @endif
    </script>
</body>
</html>
