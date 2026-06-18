<div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="documentPreviewTitle">Preview Berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="documentPreviewImage" class="preview-image d-none" alt="Preview berkas">
                <iframe id="documentPreviewFrame" class="preview-frame d-none" title="Preview PDF"></iframe>
                <div id="documentPreviewFallback" class="text-center py-5 d-none">
                    <p class="text-muted mb-3">Preview langsung tidak tersedia untuk file ini.</p>
                    <a id="documentPreviewOpenLink" href="#" target="_blank" class="btn btn-outline-dark">Buka di Tab Baru</a>
                </div>
            </div>
        </div>
    </div>
</div>
