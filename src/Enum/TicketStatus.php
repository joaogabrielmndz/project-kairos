<?php 

namespace App\Enum;

enum TicketStatus: string 
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case SUSPENDED = 'suspended';
    case CANCELLED = 'cancelled';
    case CLOSED = 'closed';
}