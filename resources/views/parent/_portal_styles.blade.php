<style>
    .password-toggle {
        min-width: 92px;
    }

    .min-w-0 {
        min-width: 0;
    }

    .parent-account-actions {
        flex-shrink: 0;
    }

    #ringkasan-akun .list-surface-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .parent-account-icon,
    .parent-list-icon {
        width: 2.5rem;
        height: 2.5rem;
        flex: 0 0 2.5rem;
        border-radius: 0.8rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--simin-accent);
        background: var(--simin-accent-soft);
    }

    .parent-list-icon {
        width: 2.35rem;
        height: 2.35rem;
        flex-basis: 2.35rem;
    }

    .parent-payment-table th,
    .parent-payment-table td {
        white-space: nowrap;
    }

    .journey-step {
        border: 1px solid rgba(18, 52, 59, 0.12);
        border-radius: 1rem;
        padding: 1rem;
        height: 100%;
        background: #fff;
    }

    .journey-step.is-active {
        border-color: var(--simin-accent);
        background: var(--simin-accent-soft);
    }

    .journey-step.is-complete {
        border-color: rgba(25, 135, 84, 0.25);
        background: rgba(25, 135, 84, 0.08);
    }

    .journey-badge {
        width: 2rem;
        height: 2rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        background: rgba(18, 52, 59, 0.08);
    }

    .journey-step.is-active .journey-badge {
        background: var(--simin-accent);
        color: #fff;
    }

    .journey-step.is-complete .journey-badge {
        background: #198754;
        color: #fff;
    }

    .document-card {
        border: 1px dashed rgba(18, 52, 59, 0.18);
        border-radius: 1rem;
        padding: 1rem;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        scroll-margin-top: 6rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, transform 0.2s ease;
    }

    .document-card:target,
    .document-card.is-focus {
        border-color: rgba(31, 122, 140, 0.55);
        background: rgba(232, 245, 248, 0.96);
        box-shadow: 0 0 0 0.25rem rgba(31, 122, 140, 0.14);
        transform: translateY(-2px);
    }

    .document-preview {
        border-radius: 0.9rem;
        border: 1px solid rgba(18, 52, 59, 0.08);
        background: linear-gradient(180deg, #fbfaf7 0%, #f3eee4 100%);
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .document-preview img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
    }

    .document-file-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        background: rgba(18, 52, 59, 0.08);
        color: var(--simin-ink);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.7rem;
    }

    .preview-frame {
        width: 100%;
        min-height: 70vh;
        border: 0;
        border-radius: 1rem;
        background: #f8f9fa;
    }

    .preview-image {
        width: 100%;
        max-height: 70vh;
        object-fit: contain;
        border-radius: 1rem;
        background: #f8f9fa;
    }

    .document-progress {
        height: 0.75rem;
        border-radius: 999px;
        background: rgba(18, 52, 59, 0.08);
        overflow: hidden;
    }

    .document-progress-bar {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #1f7a8c 0%, #49a3b3 100%);
    }

    .highlight-panel {
        border-radius: 1rem;
        border: 1px solid rgba(217, 164, 65, 0.18);
        background: linear-gradient(180deg, rgba(255, 248, 231, 0.96) 0%, rgba(250, 242, 221, 0.96) 100%);
        padding: 1rem 1.1rem;
    }

    .action-panel {
        border-radius: 1rem;
        border: 1px solid rgba(31, 122, 140, 0.14);
        background: linear-gradient(180deg, rgba(240, 250, 252, 0.96) 0%, rgba(232, 245, 248, 0.96) 100%);
        padding: 1rem 1.1rem;
    }

    @media (max-width: 767.98px) {
        .page-card {
            padding: 1rem !important;
        }

        .floating-chip-nav {
            margin-right: -1rem;
            margin-left: -1rem;
            padding-right: 1rem;
            padding-left: 1rem;
            flex-wrap: nowrap;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .floating-chip-nav::-webkit-scrollbar {
            display: none;
        }

        .floating-chip-nav .chip-link {
            flex: 0 0 auto;
        }

        .parent-stat-grid .stat-card {
            height: 100%;
            padding: 1rem;
        }

        .parent-stat-grid .stat-card strong {
            font-size: clamp(1.1rem, 5vw, 1.5rem);
            overflow-wrap: anywhere;
        }

        .parent-account-actions .btn {
            flex: 1 1 100%;
        }
    }
</style>
