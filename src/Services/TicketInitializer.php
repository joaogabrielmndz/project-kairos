<?php 

namespace App\Services;

use App\Entity\Ticket;
use App\Enum\TicketStatus;

final class TicketInitializer
{
    public function initialize(Ticket $ticket)
    {
        if ($ticket->getStatus() === null) $ticket->setStatus(TicketStatus::PENDING);

        if ($ticket->getTicketNumber() === null || $ticket->getTicketNumber() === 0) {
            $year = date('Y');
            $randomSecond = str_pad(string: (string) rand(100000, 999999), length: 6, pad_string: '0', pad_type: STR_PAD_LEFT);
            $ticketNumber = $year.$randomSecond;

            $ticket->setTicketNumber($ticketNumber);
        }
    }
}