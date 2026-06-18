<?php

namespace Tests\Unit;

use App\Models\PPDB;
use Tests\TestCase;

class PpdbPortalProgressTest extends TestCase
{
    public function test_portal_progress_defaults_to_form_step_for_draft()
    {
        $ppdb = new PPDB(['status_pendaftaran' => 'draft']);

        $progress = $ppdb->portalProgress();

        $this->assertSame('formulir', $progress['current']);
        $this->assertContains('akun', $progress['completed']);
        $this->assertContains('formulir', $progress['completed']);
    }

    public function test_portal_progress_marks_review_and_result_steps()
    {
        $reviewPpdb = new PPDB(['status_pendaftaran' => 'lulus_tes']);
        $waitlistPpdb = new PPDB(['status_pendaftaran' => 'waitlist']);
        $resultPpdb = new PPDB(['status_pendaftaran' => 'diterima']);

        $reviewProgress = $reviewPpdb->portalProgress();
        $waitlistProgress = $waitlistPpdb->portalProgress();
        $resultProgress = $resultPpdb->portalProgress();

        $this->assertSame('review', $reviewProgress['current']);
        $this->assertContains('review', $reviewProgress['completed']);

        $this->assertSame('review', $waitlistProgress['current']);
        $this->assertContains('waitlist', $waitlistProgress['completed']);

        $this->assertSame('hasil', $resultProgress['current']);
        $this->assertContains('hasil', $resultProgress['completed']);
    }

    public function test_portal_document_summary_counts_uploaded_documents()
    {
        $ppdb = new PPDB([
            'berkas' => [
                'kk' => ['path' => 'ppdb/documents/kk.pdf'],
                'foto' => ['path' => 'ppdb/documents/foto.jpg'],
            ],
        ]);

        $summary = $ppdb->portalDocumentSummary();

        $this->assertSame(2, $summary['completed']);
        $this->assertSame(3, $summary['total']);
        $this->assertFalse($summary['is_complete']);
        $this->assertSame(67, $summary['percentage']);
        $this->assertSame(['Akte Kelahiran'], $summary['missing_labels']);
        $this->assertSame('akte', $summary['missing_items'][0]['key']);
    }

    public function test_empty_portal_journey_uses_same_step_shape()
    {
        $journey = PPDB::emptyPortalJourney();

        $this->assertSame('akun', $journey['current']);
        $this->assertSame(['akun'], $journey['completed']);
        $this->assertCount(5, $journey['steps']);
        $this->assertSame('waitlist', $journey['steps'][3]['key']);
    }
}
