<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Ticket;
use App\Services\TicketInitializer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TicketPersistProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private TicketInitializer $ticketInitializer
    ){}

    /**
     * @param Ticket $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($operation instanceof Post && $data instanceof Ticket)
            $this->ticketInitializer->initialize($data);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
