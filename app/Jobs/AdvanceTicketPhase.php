<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class AdvanceTicketPhase implements ShouldQueue
{
    use Queueable;

    public $ticket;
    public $targetPhase;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket, int $targetPhase)
    {
        $this->ticket = $ticket;
        $this->targetPhase = $targetPhase;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Refresh ticket to get latest status
        $this->ticket->refresh();

        // If ticket is no longer broadcasting, or has already advanced past this target phase, do nothing.
        if ($this->ticket->vendor_service_status !== 'broadcasting' || $this->ticket->vendor_broadcast_phase > $this->targetPhase) {
            return;
        }

        // We are advancing the phase because the previous phase timed out.
        $nextPhase = $this->targetPhase + 1;

        if ($nextPhase > 3) {
            // Escalate to admin
            $this->ticket->update([
                'vendor_service_status' => 'escalated',
                'status' => 'pending', // Revert to generic pending for admin view
            ]);
            Log::info("Ticket {$this->ticket->id} escalated to admin after vendor fanout timeouts.");
        } else {
            // Move to next phase
            $this->ticket->update([
                'vendor_broadcast_phase' => $nextPhase,
                'vendor_broadcast_started_at' => now(),
            ]);

            $timeoutMinutes = $this->ticket->organization->vendor_acceptance_timeout_minutes ?? 30;

            // Dispatch job for next phase timeout
            AdvanceTicketPhase::dispatch($this->ticket, $nextPhase)->delay(now()->addMinutes($timeoutMinutes));
            Log::info("Ticket {$this->ticket->id} advanced to vendor broadcast phase {$nextPhase}.");
        }
    }
}
