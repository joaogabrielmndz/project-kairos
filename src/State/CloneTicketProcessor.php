<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Ticket;
use App\Services\TicketInitializer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CloneTicketProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private PersistProcessor $persistProcessor,
        private TicketInitializer $initializer
    ){}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $currentTicket = $data;

        $cloneTicket = new Ticket();
        
        $cloneTicket->setTitle($currentTicket->getTitle());
        $cloneTicket->setDescription($currentTicket->getDescription());

        $cloneTicket->setDepartament($currentTicket->getDepartament());
        $cloneTicket->setRequester($currentTicket->getRequester());
        $cloneTicket->setAssignedTo(null);

        $cloneTicket->setCategory($currentTicket->getCategory());
        $cloneTicket->setTicketType($currentTicket->getTicketType());
        $cloneTicket->setPriority($currentTicket->getPriority());
        $cloneTicket->setMetaData($currentTicket->getMetaData());

        $this->initializer->initialize($cloneTicket);

        return $this->persistProcessor->process($cloneTicket, $operation, $uriVariables, $context);
        
    }
}
