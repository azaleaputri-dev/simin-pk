<script>
    document.querySelectorAll('[data-password-target]').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = document.getElementById(button.getAttribute('data-password-target'));

            if (!input) {
                return;
            }

            var isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            button.textContent = isPassword ? 'Sembunyi' : 'Lihat';
        });
    });

    var previewModal = document.getElementById('documentPreviewModal');

    if (previewModal) {
        previewModal.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;

            if (!trigger) {
                return;
            }

            var url = trigger.getAttribute('data-preview-url');
            var name = trigger.getAttribute('data-preview-name') || 'Preview Berkas';
            var type = trigger.getAttribute('data-preview-type');

            var title = document.getElementById('documentPreviewTitle');
            var image = document.getElementById('documentPreviewImage');
            var frame = document.getElementById('documentPreviewFrame');
            var fallback = document.getElementById('documentPreviewFallback');
            var openLink = document.getElementById('documentPreviewOpenLink');

            title.textContent = name;
            image.classList.add('d-none');
            frame.classList.add('d-none');
            fallback.classList.add('d-none');
            image.removeAttribute('src');
            frame.removeAttribute('src');
            openLink.setAttribute('href', url || '#');

            if (type === 'image' && url) {
                image.src = url;
                image.classList.remove('d-none');
                return;
            }

            if (type === 'pdf' && url) {
                frame.src = url;
                frame.classList.remove('d-none');
                return;
            }

            fallback.classList.remove('d-none');
        });

        previewModal.addEventListener('hidden.bs.modal', function () {
            var image = document.getElementById('documentPreviewImage');
            var frame = document.getElementById('documentPreviewFrame');

            image.removeAttribute('src');
            frame.removeAttribute('src');
        });
    }

    var focusTimer = null;

    function focusDocumentFromHash() {
        var currentFocus = document.querySelector('.document-card.is-focus');

        if (currentFocus) {
            currentFocus.classList.remove('is-focus');
        }

        if (!window.location.hash || !window.location.hash.startsWith('#doc-')) {
            return;
        }

        var target = document.querySelector(window.location.hash);

        if (!target || !target.classList.contains('document-card')) {
            return;
        }

        target.classList.add('is-focus');

        if (focusTimer) {
            window.clearTimeout(focusTimer);
        }

        focusTimer = window.setTimeout(function () {
            target.classList.remove('is-focus');
        }, 2400);
    }

    window.addEventListener('hashchange', focusDocumentFromHash);
    focusDocumentFromHash();
</script>
