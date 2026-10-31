(function () {
    'use strict';
    var button = document.getElementById('jinni-import-docx');
    var input = document.getElementById('jinni-docx-file');
    var status = document.getElementById('jinni-import-status');
    if (!button || !input) return;

    button.addEventListener('click', function () { input.click(); });
    input.addEventListener('change', async function () {
        var file = input.files[0];
        if (!file) return;
        button.disabled = true;
        status.textContent = ' Importing document…';
        var form = new FormData();
        form.append('action', 'jinni_jr_import_docx');
        form.append('nonce', jinniKnowledge.nonce);
        form.append('document', file);
        try {
            var response = await fetch(ajaxurl, { method: 'POST', credentials: 'same-origin', body: form });
            var result = await response.json();
            if (!response.ok || !result.success) throw new Error(result.data && result.data.message || 'Import failed. Please try again.');
            var text = result.data.text;
            if (!text.trim()) throw new Error('The document contains no readable text.');
            var editor = window.tinymce && window.tinymce.get('content');
            if (editor && !editor.isHidden()) {
                var html = text.split(/\n\n/).map(function (paragraph) {
                    var node = document.createElement('div');
                    node.textContent = paragraph;
                    return '<p>' + node.innerHTML.replace(/\n/g, '<br>') + '</p>';
                }).join('');
                editor.insertContent(html);
            } else {
                var textarea = document.getElementById('content');
                var start = textarea.selectionStart;
                var end = textarea.selectionEnd;
                textarea.value = textarea.value.slice(0, start) + text + textarea.value.slice(end);
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
            }
            status.textContent = ' Document imported. Save your knowledge entry to keep it.';
        } catch (error) {
            status.textContent = ' ' + (error.message || 'Import failed. Please try again.');
        } finally {
            button.disabled = false;
            input.value = '';
        }
    });
}());
