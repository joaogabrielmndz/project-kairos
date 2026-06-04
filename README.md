# Project Kairós - Backend API 🚀

**Project Kairós** is a modern, decoupled Help Desk and ticket management system. This repository contains the robust RESTful API built to handle data persistence, state transitions, and business logic validation for the entire platform.

## 🧠 Architecture & Tech Stack

The API is engineered following enterprise-grade software development practices, emphasizing strict separation of concerns, high testability, and a lean data pipeline:

- **PHP 8.4+**
- **Symfony 8.1** & **API Platform 3** – Framework core powering the REST semantic resources.
- **Doctrine ORM** & **PostgreSQL** – Relational data persistence tier.
- **Docker & Compose** – Containerized local development stack.
- **JSON-LD / Hydra** – Standardized semantic web data format for seamless frontend integration.

## 🛠️ Implemented Features (Current Sprint)

- **Ticket Resource Modeling:** Complete database schema mapped via Doctrine entities to support support tickets, structural titles, rich descriptions, and status states via native Enums.
- **Custom State Processors:** Business logic interceptors implemented to detach framework persistence from domain-driven rules.
- **Automated Lifecycle Initialization:** Behind-the-scenes generation of unique, non-sequential `ticketNumber` properties (composed of Current Year + zero-padded random seconds) and enforcing the safe initial `PENDING` state.
- **Secure Partial Updates:** Native support for the `PATCH` verb using the *JSON Merge Patch* specification (RFC 7396) for moving Kanban cards and processing logical cancellations.

## 🚀 Local Setup & Installation

### Prerequisites
- Docker and Docker Compose installed.
- PHP 8.4 or higher available locally.
- Symfony CLI (highly recommended).

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/your-username/project-kairos-backend.git](https://github.com/your-username/project-kairos-backend.git)
   cd project-kairos-backend
