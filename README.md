# 🏛️ Project Kairós - Core Backend

**Project Kairós** is a specialized Help Desk and Service Desk system structured on a decoupled, restful API architecture. The backend ecosystem is built using **Symfony 7.x**, **API Platform** (with semantic support for JSON-LD/Hydra), and **Doctrine ORM**, persisting data in a containerized **PostgreSQL** cluster.

---

## 🛠️ Prerequisites

Before cloning and running the application, ensure your local development machine (e.g., Fedora Linux) has the following system dependencies installed and configured:

* **PHP 8.2 or higher** (including required extensions: `pdo_pgsql`, `mbstring`, `xml`, `intl`, `iconv`, `json`)
* **Composer 2.x** (PHP package manager)
* **Docker & Docker Compose** (To orchestrate the database and cache layers)
* **Symfony CLI** (Highly recommended for local web server management and certificate provisioning)

---

## 🚀 Getting Started & Installation Guide

Follow these sequential steps to clone the repository and spin up the complete backend architecture:

### 1. Clone the Repository
Clone the project locally and navigate into the backend subdirectory:
```bash
git clone https://github.com/joaogabrielmndz/project-kairos.git
cd project-kairos/backend
```
---

## 📂 1. Simplified Folder Structure

The project directory organization strictly isolates infrastructure, API lifecycle, and pure business domain responsibilities:
```text
.
├── api/                    # Files for test endpoits
├── bin/                    # Command-line utility binaries (Symfony CLI Operational Console)
├── config/                 # Global configuration for routing, packages, and security
│   ├── packages/           # Strict package tuning (Doctrine, Security, Api Platform)
│   └── routes/             # Complementary static routing definitions
├── migrations/             # Database schema versioning history files (SQL)
├── public/                 # Web server public entry point directory (index.php)
└── src/                    # Main application source code directory
    ├── ApiResource/        # Classes representing strict API-specific resources
    ├── Controller/         # Traditional controllers for custom imperative actions
    ├── DataFixtures/       # Static data seeds for consistent test data states
    ├── Entity/             # Domain entities mapped to physical ORM tables
    ├── Enum/               # Structured value objects for state immutable values (Status, Priorities)
    ├── Repository/         # Isolated database queries abstraction (Query Builders)
    ├── Services/           # Specialized pure business logic layer classes
    └── State/              # Intercepting processors/providers for the API lifecycle
```

---

## 🔐 2. Environment Configuration Guide (`.env`)

The project environment variables management is handled by the `Symfony Dotenv` component. It maps keys straight from the files into PHP superglobals (`$_ENV` and `$_SERVER`) before loading them into the Service Container.

### 🛡️ Local Environment Best Practices
* **`.env`**: Contains generic fallback values for the ecosystem. Must be versioned in Git.
* **`.env.local`**: Contains your actual local machine development credentials. **Must never be versioned in Git**.

### ⚙️ Unified Database Configuration (PostgreSQL + Docker)
To ensure Symfony authenticates properly without being blocked by PostgreSQL's SCRAM authentication mechanism, the keys in your `.env.local` must match the port mapping exposed by Docker (`docker ps`):

```ini
APP_ENV=dev
APP_SECRET=1f200007a8f95c75420dd6688e531392

# Initialization credentials read by Docker Compose (example)
POSTGRES_USER=kairos
POSTGRES_PASSWORD=db1234

# Connection string consumed by the Doctrine DBAL Wrapper
# postgresql://USER:PASSWORD@HOST:PORT_CONTAINER/DATABASE_NAME?parameters
DATABASE_URL="postgresql://kairos:1234@127.0.0.1:32770/app?serverVersion=16&charset=utf8"
``
