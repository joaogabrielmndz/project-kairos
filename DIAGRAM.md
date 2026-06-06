```mermaid
classDiagram
    class User {
        -int id
        -string email
        -array roles
        -string password
        -string fullName
        -Collection tickets
        +getId() int
        +getEmail() string
        +getRoles() array
        +getFullName() string
    }

    class Category {
        -int id
        -string name
        -Collection tickets
        +getId() int
        +getName() string
    }

    class Departament {
        -int id
        -string name
        -Collection tickets
        +getId() int
        +getName() string
    }

    class TicketType {
        -int id
        -string name
        -Collection tickets
        +getId() int
        +getName() string
    }

    class Action {
        -int id
        -string label
        -Collection tickets
        +getId() int
        +getLabel() string
    }

    class Ticket {
        -int id
        -string title
        -string ticketNumber
        -string description
        -TicketStatus status
        -TicketPriority priority
        -Category category
        -User requester
        -User assignedTo
        -Departament departament
        -TicketType ticketType
        -Action action
        -array metaData
        +getId() int
        +getTitle() string
        +getStatus() TicketStatus
        +getPriority() TicketPriority
        +getMetaData() mixed
    }

    class TicketStatus {
        <<enumeration>>
        PENDING
        IN_PROGRESS
        SUSPENDED
        CANCELLED
        CLOSED
    }

    class TicketPriority {
        <<enumeration>>
        LOW
        MEDIUM
        HIGH
        CRITICAL
    }

    %% Relacionamentos de Associação do ORM
    Ticket --> TicketStatus : uses
    Ticket --> TicketPriority : uses
    Ticket "0..*" --> "1" Category : mapped by
    Ticket "0..*" --> "1" Departament : mapped by
    Ticket "0..*" --> "1" TicketType : mapped by
    Ticket "0..*" --> "1" Action : mapped by
    Ticket "0..*" --> "1" User : requester
    Ticket "0..*" --> "0..1" User : assignedTo