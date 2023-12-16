<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#tiny-mce-editor',
            plugins: 'code table lists advlist media link image hr pagebreak paste preview fullpage fullscreen toc',
            toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | media | link | image | hr | pagebreak | paste pastetext | preview | fullpage | fullscreen | toc'
        });
        tinymce.init({
            selector: 'textarea#tiny-mces',
            max_chars : "5000",
            setup: function (ed) {
                ed.on('keydown', function (e) {
                    var len = tinymce.get(tinymce.activeEditor.id).contentDocument.body.innerText.length;
                    // if (allowedKeys.indexOf(e.keyCode) != -1) return true;
                    if (len + 1 > 5000) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                    // return true;
                });
            },
            plugins: 'code table lists advlist media link image hr pagebreak paste preview fullpage fullscreen toc',
            toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | media | link | image | hr | pagebreak | paste pastetext | preview | fullpage | fullscreen | toc'
        });
        tinymce.init({
            selector: 'textarea#tiny-mce',
            max_chars : "1000",
            setup: function (ed) {
                ed.on('keydown', function (e) {
                    var len = tinymce.get(tinymce.activeEditor.id).contentDocument.body.innerText.length;
                    // if (allowedKeys.indexOf(e.keyCode) != -1) return true;
                    if (len + 1 > 1000) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                    // return true;
                });
            },
            plugins: 'code table lists advlist media link image hr pagebreak paste preview fullpage fullscreen toc',
            toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | media | link | image | hr | pagebreak | paste pastetext | preview | fullpage | fullscreen | toc'
        });

    </script>
</div>


