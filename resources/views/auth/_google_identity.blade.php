<form id="googleIdentityForm" action="{{ route('auth.google') }}" method="POST">
    @csrf
    <input type="hidden" name="credential" id="googleIdentityCredential">
</form>

<div id="googleIdentityButton" class="d-flex justify-content-center"></div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    window.addEventListener('load', function () {
        if (!window.google || !google.accounts || !google.accounts.id) {
            return;
        }

        google.accounts.id.initialize({
            client_id: @json(config('services.google.client_id')),
            callback: function (response) {
                document.getElementById('googleIdentityCredential').value = response.credential;
                document.getElementById('googleIdentityForm').submit();
            }
        });

        google.accounts.id.renderButton(
            document.getElementById('googleIdentityButton'),
            {
                type: 'standard',
                theme: 'outline',
                size: 'large',
                text: @json($googleButtonText),
                shape: 'pill',
                width: 360
            }
        );
    });
</script>
