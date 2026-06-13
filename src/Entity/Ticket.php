<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Repository\TicketRepository;
use App\State\TicketPersistProcessor;
use App\State\CloneTicketProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'ticket:read'],
    operations: [
        new Get(),
        new GetCollection(),
        new Patch(),
        new Delete(),
        new Post(processor: TicketPersistProcessor::class),
        new Post(
            name: 'clone',
            uriTemplate: '/tickets/{id}/clone',
            class: Ticket::class,
            processor: CloneTicketProcessor::class,
        )
])]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('ticket:read')]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Groups('ticket:read')]
    private ?string $title = null;

    #[ORM\Column(type: Types::BIGINT)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[Groups('ticket:read')]
    private ?string $ticketNumber = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('ticket:read')]
    private ?string $description = null;

    #[ORM\Column(enumType: TicketStatus::class)]
    #[Groups('ticket:read')]
    private ?TicketStatus $status = null;
    
    #[ORM\Column(enumType: TicketPriority::class)]
    #[Groups('ticket:read')]
    private ?TicketPriority $priority = null;
    
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Category $category = null;
    
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?User $requester = null;
    
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[Groups('ticket:read')]
    private ?User $assignedTo = null;
    
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?Departament $departament = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?TicketType $ticketType = null;

    #[ORM\Column(type: Types::JSONB)]
    private ?array $metaData = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Action $action = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTicketNumber(): ?string
    {
        return $this->ticketNumber;
    }

    public function setTicketNumber(string $ticketNumber): static
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?TicketStatus
    {
        return $this->status;
    }

    public function setStatus(TicketStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): ?TicketPriority
    {
        return $this->priority;
    }

    public function setPriority(TicketPriority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getRequester(): ?User
    {
        return $this->requester;
    }

    public function setRequester(?User $requester): static
    {
        $this->requester = $requester;

        return $this;
    }

    public function getAssignedTo(): ?User
    {
        return $this->assignedTo;
    }

    public function setAssignedTo(?User $assignedTo): static
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    public function getDepartament(): ?Departament
    {
        return $this->departament;
    }

    public function setDepartament(?Departament $departament): static
    {
        $this->departament = $departament;

        return $this;
    }

    public function getTicketType(): ?TicketType
    {
        return $this->ticketType;
    }

    public function setTicketType(?TicketType $ticketType): static
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    public function getMetaData(): mixed
    {
        return $this->metaData;
    }

    public function setMetaData(mixed $metaData): static
    {
        $this->metaData = $metaData;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): static
    {
        $this->action = $action;

        return $this;
    }
}
