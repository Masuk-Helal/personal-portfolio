(function () {
    'use strict';

    var provider = document.getElementById('jinni-jr-provider');
    var select = document.getElementById('jinni-jr-model');
    var search = document.getElementById('jinni-jr-model-search');
    var status = document.getElementById('jinni-jr-model-status');
    if (!provider || !select || !search || !status) return;
    var picker = document.getElementById('jinni-jr-model-picker');
    var toggle = document.getElementById('jinni-jr-model-toggle');
    var popup = document.getElementById('jinni-jr-model-popup');
    var results = document.getElementById('jinni-jr-model-results');
    select.hidden = true;
    picker.style.display = 'block';

    function syncPicker() {
        toggle.textContent = select.options[select.selectedIndex].text + ' ▾';
        results.textContent = '';
        Array.prototype.forEach.call(select.options, function (option) {
            var item = document.createElement('div');
            item.setAttribute('role', 'option');
            item.setAttribute('aria-selected', option.selected ? 'true' : 'false');
            item.tabIndex = 0;
            item.textContent = option.text;
            item.style.cssText = 'padding:6px; cursor:pointer; overflow-wrap:anywhere;';
            if (option.selected) item.style.background = '#f0f0f1';
            function choose() {
                select.value = option.value;
                select.dispatchEvent(new Event('change', {bubbles: true}));
                popup.hidden = true;
                toggle.setAttribute('aria-expanded', 'false');
                syncPicker();
                toggle.focus();
            }
            item.addEventListener('click', choose);
            item.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); choose(); }
                if (event.key === 'ArrowDown' && item.nextElementSibling) { event.preventDefault(); item.nextElementSibling.focus(); }
                if (event.key === 'ArrowUp') { event.preventDefault(); (item.previousElementSibling || search).focus(); }
            });
            results.appendChild(item);
        });
    }

    toggle.addEventListener('click', function () {
        popup.hidden = !popup.hidden;
        toggle.setAttribute('aria-expanded', popup.hidden ? 'false' : 'true');
        if (!popup.hidden) { search.focus(); }
    });
    search.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowDown' && results.firstElementChild) { event.preventDefault(); results.firstElementChild.focus(); }
    });
    picker.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !popup.hidden) { popup.hidden = true; toggle.setAttribute('aria-expanded', 'false'); toggle.focus(); }
    });
    document.addEventListener('click', function (event) {
        if (!picker.contains(event.target)) { popup.hidden = true; toggle.setAttribute('aria-expanded', 'false'); }
    });

    var initialProvider = provider.value;
    var savedModel = select.dataset.savedModel;
    var requestId = 0;
    var models = [];
    var apiKeys = document.querySelectorAll('[data-provider-key]');
    var loadModels = document.getElementById('jinni-jr-load-models');
    function currentKey() { return document.getElementById('jinni-jr-api-key-' + provider.value); }
    var verify = document.getElementById('jinni-jr-verify');
    var verifyStatus = document.getElementById('jinni-jr-verify-status');

    if (verify && verifyStatus) {
        apiKeys.forEach(function (key) { key.addEventListener('input', function () { verifyStatus.textContent = ''; }); });
        verify.addEventListener('click', function () {
            verify.disabled = true;
            verifyStatus.textContent = jinniJrModels.verifying;
            var checkedProvider = provider.value;
            var checkedKey = currentKey().value;
            var data = new URLSearchParams({action: 'jinni_jr_verify_openrouter', nonce: jinniJrModels.nonce, provider: checkedProvider, api_key: checkedKey});
            fetch(jinniJrModels.url, {method: 'POST', credentials: 'same-origin', body: data})
                .then(function (response) { if (!response.ok) throw new Error('Request failed'); return response.json(); })
                .then(function (response) { if (provider.value === checkedProvider && currentKey().value === checkedKey) verifyStatus.textContent = response.data && response.data.message ? response.data.message : jinniJrModels.verifyFailed; })
                .catch(function () { if (provider.value === checkedProvider && currentKey().value === checkedKey) verifyStatus.textContent = jinniJrModels.verifyFailed; })
                .then(function () { verify.disabled = false; });
        });
    }

    function filterModels() {
        var selected = select.value;
        var query = search.value.trim().toLowerCase();
        var matches = 0;
        select.length = 1;
        models.forEach(function (model) {
            var isSelected = model.id === selected;
            if ((model.name + ' ' + model.id).toLowerCase().indexOf(query) !== -1 || isSelected) {
                select.add(new Option(model.name + ' (' + model.id + ')', model.id, false, isSelected));
                if ((model.name + ' ' + model.id).toLowerCase().indexOf(query) !== -1) matches++;
            }
        });
        if (selected && select.value !== selected) select.add(new Option(selected, selected, false, true));
        status.textContent = query && !matches ? jinniJrModels.noResults : jinniJrModels.ready;
        syncPicker();
    }

    function updateModels() {
        var currentRequest = ++requestId;
        apiKeys.forEach(function (key) { key.hidden = key.dataset.providerKey !== provider.value; key.style.display = key.hidden ? 'none' : ''; });
        if (verifyStatus) verifyStatus.textContent = '';
        var selected = provider.value === initialProvider ? savedModel : '';
        models = [];
        search.value = '';
        select.length = 1;
        if (selected) select.add(new Option(selected, selected, true, true));
        syncPicker();

        if (provider.value === 'wordpress_ai') {
            status.textContent = jinniJrModels.connector;
            return;
        }

        status.textContent = jinniJrModels.loading;
        var data = new URLSearchParams({action: 'jinni_jr_models', nonce: jinniJrModels.nonce, provider: provider.value, api_key: currentKey() ? currentKey().value : ''});
        fetch(jinniJrModels.url, {method: 'POST', credentials: 'same-origin', body: data})
            .then(function (response) {
                if (!response.ok) throw new Error('Request failed');
                return response.json();
            })
            .then(function (response) {
                if (currentRequest !== requestId) return;
                if (!response.success || !Array.isArray(response.data)) {
                    status.textContent = response.data && response.data.message ? response.data.message : jinniJrModels.failed;
                    return;
                }
                models = response.data.sort(function (a, b) { return a.name.localeCompare(b.name); });
                filterModels();
            })
            .catch(function () {
                if (currentRequest === requestId) status.textContent = jinniJrModels.failed;
            });
    }

    select.addEventListener('change', function () {
        if (provider.value === initialProvider) savedModel = select.value;
    });
    search.addEventListener('input', function () {
        if (models.length) filterModels();
    });
    provider.addEventListener('change', function () {
        apiKeys.forEach(function (key) { key.value = ''; });
        updateModels();
    });
    if (loadModels) loadModels.addEventListener('click', updateModels);
    updateModels();
}());
