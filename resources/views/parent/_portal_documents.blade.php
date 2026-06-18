<div class="col-12">
    <div class="border rounded-4 p-4 bg-white">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
            <div>
                <div class="section-label mb-2">Berkas PPDB</div>
                <h3 class="h5 mb-1">Upload dokumen dari portal user</h3>
                <p class="text-muted mb-0">Upload KK, akte, dan foto untuk pendaftaran terbaru yang terhubung ke akun ini.</p>
            </div>
            @if($latestPpdb)
                <div class="text-lg-end">
                    <span class="badge {{ $latestPpdb->statusAppearance()['class'] }}">{{ $latestPpdb->statusAppearance()['label'] }}</span>
                    @if($latestPpdb->canManagePortalDocuments())
                        <div class="small text-muted mt-2">Berkas masih bisa diubah selama status belum final.</div>
                    @else
                        <div class="small text-danger mt-2">Upload dikunci karena status PPDB sudah final.</div>
                    @endif
                </div>
            @endif
        </div>

        @if($latestPpdb)
            <div class="border rounded-4 p-3 mb-4" style="background: rgba(31, 122, 140, 0.06); border-color: rgba(31, 122, 140, 0.15) !important;">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                    <div>
                        <div class="fw-semibold">Kelengkapan berkas: {{ $documentSummary['completed'] }}/{{ $documentSummary['total'] }}</div>
                        <div class="small text-muted">Checklist ini membantu melihat dokumen mana yang sudah lengkap untuk pendaftaran terbaru.</div>
                    </div>
                    <span class="badge {{ $documentSummary['is_complete'] ? 'text-bg-success' : 'text-bg-warning' }}">
                        {{ $documentSummary['is_complete'] ? 'Semua Berkas Lengkap' : 'Masih Ada Berkas Kurang' }}
                    </span>
                </div>
                <div class="mt-3">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <span>Progress kelengkapan</span>
                        <span>{{ $documentSummary['percentage'] }}%</span>
                    </div>
                    <div class="document-progress">
                        <div class="document-progress-bar" style="width: {{ $documentSummary['percentage'] }}%;"></div>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap mt-3">
                    @foreach($documentSummary['items'] as $item)
                        <span class="badge {{ $item['uploaded'] ? 'text-bg-success' : 'text-bg-secondary' }}">
                            {{ $item['label'] }} - {{ $item['uploaded'] ? 'Lengkap' : 'Belum Upload' }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="row g-3">
                @foreach(['kk' => 'Kartu Keluarga', 'akte' => 'Akte Kelahiran', 'foto' => 'Foto Siswa'] as $docKey => $docLabel)
                    @php($document = $uploadedDocuments[$docKey] ?? null)
                    @php($documentUrl = $document['url'] ?? null)
                    @php($documentName = $document['original_name'] ?? ($document['filename'] ?? null))
                    @php($documentNameLower = $documentName ? \Illuminate\Support\Str::lower($documentName) : null)
                    @php($isImage = $documentNameLower ? \Illuminate\Support\Str::endsWith($documentNameLower, ['.jpg', '.jpeg', '.png', '.webp']) : false)
                    @php($isPdf = $documentNameLower ? \Illuminate\Support\Str::endsWith($documentNameLower, '.pdf') : false)
                    <div class="col-md-6 col-xl-4">
                        <div class="document-card" id="doc-{{ $docKey }}">
                            <div class="fw-semibold mb-1">{{ $docLabel }}</div>
                            <div class="small text-muted mb-3">
                                @if($document)
                                    Sudah diupload pada {{ \Illuminate\Support\Carbon::parse($document['uploaded_at'])->format('d M Y H:i') }}
                                @else
                                    Belum ada file yang diupload.
                                @endif
                            </div>

                            @if($document)
                                <div class="document-preview">
                                    @if($isImage && $documentUrl)
                                        <img src="{{ $documentUrl }}" alt="{{ $docLabel }}">
                                    @elseif($isPdf)
                                        <div class="text-center px-3">
                                            <div class="document-file-badge mb-2">PDF</div>
                                            <div class="small text-muted">{{ $documentName }}</div>
                                        </div>
                                    @else
                                        <div class="text-center px-3">
                                            <div class="document-file-badge mb-2">FILE</div>
                                            <div class="small text-muted">{{ $documentName }}</div>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex gap-2 flex-wrap mb-3">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-dark"
                                        data-bs-toggle="modal"
                                        data-bs-target="#documentPreviewModal"
                                        data-preview-url="{{ $documentUrl }}"
                                        data-preview-name="{{ $documentName }}"
                                        data-preview-type="{{ $isImage ? 'image' : ($isPdf ? 'pdf' : 'file') }}"
                                    >
                                        Lihat
                                    </button>
                                    <a href="{{ $documentUrl }}" download="{{ $documentName }}" class="btn btn-sm btn-outline-secondary">Download</a>
                                </div>
                                <div class="small text-muted mb-3">
                                    <span class="document-file-badge">{{ $isImage ? 'GAMBAR' : ($isPdf ? 'PDF' : 'DOKUMEN') }}</span>
                                    <span class="ms-2">{{ $documentName }}</span>
                                </div>
                            @endif

                            @if($latestPpdb->canManagePortalDocuments())
                                <form action="{{ route('parent.portal.ppdb.documents.store', $latestPpdb) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="document_type" value="{{ $docKey }}">
                                    <div class="mb-3">
                                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                                        @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary btn-sm">{{ $document ? 'Ganti' : 'Upload' }} {{ $docLabel }}</button>
                                </form>
                                @if($document)
                                    <form action="{{ route('parent.portal.ppdb.documents.destroy', [$latestPpdb, $docKey]) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus berkas ini?')">Hapus</button>
                                    </form>
                                @endif
                            @else
                                <div class="small text-muted">Berkas terkunci dan tidak bisa diubah.</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">Belum ada data PPDB untuk akun ini. Isi formulir PPDB dulu agar upload berkas bisa dibuka.</p>
        @endif
    </div>
</div>
