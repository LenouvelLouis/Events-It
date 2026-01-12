# Event-It

A comprehensive PHP MVC web application for cinema management, featuring film scheduling, IoT sensor analytics, user authentication, and a community forum.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Architecture](#architecture)
- [Database Schema](#database-schema)
- [Installation](#installation)
- [Configuration](#configuration)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

Event-It is a full-featured cinema management platform that enables:

- **Cinema & Film Management**: Create and manage cinemas, rooms, and film catalogs
- **Screening Scheduling**: Schedule screenings with conflict detection and room availability checks
- **IoT Integration**: Real-time monitoring of sound levels and temperature in cinema rooms
- **User Management**: Role-based access control with admin, manager, and user roles
- **Community Forum**: Discussion board for cinema-related topics
- **Contact System**: Email notifications powered by PHPMailer

The application follows the MVC (Model-View-Controller) architectural pattern with a custom front-controller routing system.

---

## Features

### Authentication & Authorization

| Feature | Description |
|---------|-------------|
| User Registration | Email validation, password hashing with bcrypt-style salt |
| Session Management | PHP session-based authentication |
| Role-Based Access | Three roles: `admin`, `gestionnaire` (manager), `user` |
| Profile Management | Update email, phone, and password |

### Cinema Management

- Create and manage cinema locations
- Configure accessibility options (wheelchair, hearing impaired, visually impaired)
- Indoor/outdoor venue classification
- Room (salle) management per cinema
- Image upload support

### Film Catalog

- Complete film database with metadata
- Fields: title, synopsis, duration, director, actors, genre
- Poster image management
- Film-to-screening association

### Screening Scheduler

- Create screenings linking cinema, room, and film
- Automatic conflict detection (no overlapping screenings in same room)
- Date validation (future dates only)
- Automatic end-time calculation based on film duration
- Display categories: "New Releases" and "Now Showing"

### IoT Analytics Dashboard

Real-time environmental monitoring for cinema rooms:

| Metric | Description |
|--------|-------------|
| Sound Level | Decibel readings from sound sensors |
| Temperature | Celsius readings from temperature sensors |
| Statistics | Mean, median, mode, min/max calculations |
| Visualization | Interactive charts with Chart.js and Plotly |

### Community Forum

- Create and participate in discussions
- Threaded message system
- Creator-based deletion permissions
- Search functionality

### Contact & Notifications

- Contact form with server-side validation
- SMTP email delivery via PHPMailer
- Toast-style notification system

---

## Tech Stack

### Backend

| Technology | Purpose |
|------------|---------|
| PHP 8+ | Server-side logic |
| MySQL/MariaDB | Relational database |
| PDO | Database abstraction with prepared statements |
| PHPMailer | SMTP email delivery |

### Frontend

| Technology | Purpose |
|------------|---------|
| HTML5/CSS3 | Structure and styling |
| Vanilla JavaScript | Client-side interactivity |
| jQuery | AJAX requests and DOM manipulation |
| Chart.js | Statistical visualizations |
| Plotly.js | Advanced interactive charts |
| moment.js | Date/time handling |
| Font Awesome | Icon library |

### Security

- Password hashing with bcrypt (`crypt()` with `$2y$10$` prefix)
- Random salt generation (22 bytes, base64 encoded)
- PDO prepared statements (SQL injection prevention)
- Input validation and sanitization

---

## Architecture

Event-It implements a custom MVC architecture with a front-controller pattern.

### Request Flow

```
HTTP Request
    │
    ▼
index.php (Front Controller)
    │
    ├── Parse ?path=controller/action
    │
    ▼
Controller (controle/*.php)
    │
    ├── Business logic
    ├── Call Model functions
    │
    ▼
Model (modele/*BD.php)
    │
    ├── Database queries (PDO)
    ├── Return data
    │
    ▼
View (vue/*/*.tpl)
    │
    ├── HTML templates
    ├── CSS styling
    ├── JavaScript interactivity
    │
    ▼
HTTP Response
```

### Routing System

The router parses URLs in the format `?path=controller/action`:

```php
// Example routes
?path=cinema/getInfoCinema&id=1    → cinema.php::getInfoCinema()
?path=pages/film                    → pages/film.php::film()
?path=seance/ajoutSeance            → seance.php::ajoutSeance()
```

---

## Database Schema

### Entity Relationship Diagram

```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│    user     │       │   cinema    │       │    film     │
├─────────────┤       ├─────────────┤       ├─────────────┤
│ id (PK)     │       │ id (PK)     │       │ id (PK)     │
│ name        │       │ nom         │       │ titre       │
│ email       │       │ adresse     │       │ synopsis    │
│ phone       │       │ type_cine   │       │ duree       │
│ password    │       │ handicape   │       │ realisateur │
│ status      │       │ sourd       │       │ acteurs     │
│ salt        │       │ malvoyant   │       │ genre       │
└─────────────┘       │ image       │       │ image       │
                      │ telephone   │       └──────┬──────┘
                      │ mail        │              │
                      └──────┬──────┘              │
                             │                     │
                      ┌──────┴──────┐              │
                      │    salle    │              │
                      ├─────────────┤              │
                      │ id (PK)     │              │
                      │ nom         │              │
                      │ id_cinema   │──────────────┤
                      └──────┬──────┘              │
                             │                     │
                      ┌──────┴──────┐              │
                      │   seance    │◄─────────────┘
                      ├─────────────┤
                      │ id (PK)     │
                      │ horairedébut│
                      │ date        │
                      │ type_affich │
                      │ id_cinema   │
                      │ id_film     │
                      │ id_salle    │
                      └─────────────┘

┌─────────────┐       ┌─────────────────────┐
│   capteur   │       │ data_capteur_son    │
├─────────────┤       ├─────────────────────┤
│ id (PK)     │◄──────│ id_capteur (FK)     │
│ id_salle    │       │ valeur              │
└─────────────┘       │ temps               │
                      └─────────────────────┘

┌───────────────────┐       ┌─────────────────┐
│ discussion-forum  │       │  message-forum  │
├───────────────────┤       ├─────────────────┤
│ id (PK)           │◄──────│ idDiscussion    │
│ titre             │       │ id (PK)         │
│ creator (FK)      │       │ message         │
│ date              │       │ idUser (FK)     │
└───────────────────┘       │ date            │
                            └─────────────────┘
```

### Key Tables

| Table | Description |
|-------|-------------|
| `user` | User accounts with roles and credentials |
| `cinema` | Cinema venues with accessibility flags |
| `salle` | Rooms within cinemas |
| `film` | Film catalog with metadata |
| `seance` | Scheduled screenings |
| `capteur` | IoT sensors linked to rooms |
| `data_capteur_son` | Sound level readings |
| `data_capteur_temperature` | Temperature readings |
| `discussion-forum` | Forum discussion threads |
| `message-forum` | Forum messages |
| `gestionnaire` | Manager-cinema assignments |

---

## Installation

### Prerequisites

- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Apache/Nginx web server (or WAMP/XAMPP/MAMP)
- Composer (optional, for PHPMailer updates)

### Step 1: Clone the Repository

```bash
git clone https://github.com/LenouvelLouis/Event-It.git
cd Event-It
```

### Step 2: Create the Database

```sql
CREATE DATABASE `events-it`
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
```

### Step 3: Import the Schema

```bash
mysql -u root -p events-it < events-it.sql
```

### Step 4: Configure Database Connection

Edit `MVC/modele/connectSQL.php`:

```php
$hostname = "localhost";
$base     = "events-it";
$loginBD  = "your_username";
$passBD   = "your_password";
```

### Step 5: Configure Web Server

Point your web server's document root to the `MVC/` directory, or access via:

```
http://localhost/Event-It/MVC/
```

---

## Configuration

### Database Connection

File: `MVC/modele/connectSQL.php`

```php
$hostname = "localhost";
$base     = "events-it";
$loginBD  = "root";
$passBD   = "root";
```

### Email Settings (PHPMailer)

File: `MVC/service/mailService.php`

```php
$mail->Host       = 'smtp.gmail.com';
$mail->Username   = 'your-email@gmail.com';
$mail->Password   = 'your-app-password';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
$mail->setFrom('no-reply@your-domain.com', 'Event-It');
```

> **Note**: For Gmail, use an [App Password](https://support.google.com/accounts/answer/185833) instead of your regular password.

### User Roles Configuration

Roles are automatically assigned based on email domain in `MVC/controle/inscription.php`:

| Email Domain | Assigned Role |
|--------------|---------------|
| `@events-it.fr` | `admin` |
| `@grandRex.fr` | `gestionnaire` |
| Other | `user` |

---

## Project Structure

```
Event-It/
├── events-it.sql                 # Database schema and sample data
├── README.md                     # Project documentation
├── .gitignore                    # Git ignore rules
│
└── MVC/
    ├── index.php                 # Front controller (router)
    │
    ├── controle/                 # Controllers
    │   ├── home.php              # Home page
    │   ├── connexion.php         # Authentication (login)
    │   ├── inscription.php       # User registration
    │   ├── logout.php            # Session termination
    │   ├── utilisateur.php       # User management
    │   ├── cinema.php            # Cinema operations
    │   ├── film.php              # Film operations
    │   ├── seance.php            # Screening operations
    │   ├── forum.php             # Forum operations
    │   ├── stat.php              # IoT statistics
    │   ├── contact.php           # Contact form handler
    │   └── pages/                # Page controllers
    │       ├── accueil.php
    │       ├── cinema.php
    │       ├── film.php
    │       ├── ajoutcinema.php
    │       ├── ajoutfilm.php
    │       ├── ajoutseance.php
    │       └── ...
    │
    ├── modele/                   # Models (database layer)
    │   ├── connectSQL.php        # PDO connection
    │   ├── utilisateurBD.php     # User queries
    │   ├── cinemaBD.php          # Cinema queries
    │   ├── filmBD.php            # Film queries
    │   ├── seanceBD.php          # Screening queries
    │   ├── forumBD.php           # Forum queries
    │   └── statBD.php            # Statistics queries
    │
    ├── service/                  # Services
    │   ├── mailService.php       # PHPMailer wrapper
    │   └── hashService.php       # Password hashing
    │
    ├── lib/                      # Third-party libraries
    │   └── PHPMailer/            # Email library
    │
    └── vue/                      # Views
        ├── style/                # Global CSS
        ├── navbar/               # Navigation component
        ├── footer/               # Footer component
        ├── modal/                # Modal component
        ├── notifier/             # Toast notifications
        ├── home/                 # Home page views
        ├── cinema/               # Cinema views
        ├── film/                 # Film views
        ├── forum/                # Forum views
        ├── statseance/           # Statistics views
        ├── profile/              # User profile views
        ├── contact/              # Contact form views
        └── img/                  # Image assets
            ├── cinemas/          # Cinema images
            ├── films/            # Film posters
            └── carousel/         # Homepage carousel
```

---

## API Endpoints

### Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `?path=connexion/login` | User login |
| POST | `?path=inscription/inscription` | User registration |
| GET | `?path=logout/deconnexion` | User logout |

### Users

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `?path=utilisateur/getUsers` | List all users (admin) |
| GET | `?path=utilisateur/getInfoUser&id={id}` | Get user details |
| POST | `?path=utilisateur/updateuser` | Update user profile |
| POST | `?path=utilisateur/deleteUser&id={id}` | Delete user (admin) |

### Cinemas

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `?path=seance/getCinema` | List all cinemas |
| GET | `?path=cinema/getInfoCinema&id={id}` | Get cinema details |
| POST | `?path=cinema/ajoutcinema` | Create cinema |

### Films

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `?path=seance/getFilm` | List all films |
| GET | `?path=film/getInfosFilm&id={id}` | Get film details |
| GET | `?path=film/getSeanceFilm&id={id}` | Get film screenings |
| POST | `?path=film/ajoutfilm` | Create film |
| POST | `?path=film/editfilm` | Update film |
| POST | `?path=film/deleteFilm&id={id}` | Delete film |

### Screenings

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `?path=seance/getSalle&id={cinema_id}` | Get rooms by cinema |
| GET | `?path=seance/getseanceid&id={id}` | Get screening details |
| POST | `?path=seance/ajoutSeance` | Create screening |
| POST | `?path=seance/editseance` | Update screening |
| POST | `?path=seance/deleteSeance&id={id}` | Delete screening |

### Statistics

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `?path=stat/getStatSeance&id={seance_id}` | Get IoT stats for screening |

### Forum

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `?path=forum/getDiscussions` | List discussions |
| GET | `?path=forum/getMessages&id={id}` | Get discussion messages |
| POST | `?path=forum/ajoutdiscussion` | Create discussion |
| POST | `?path=forum/ajoutmessage` | Add message |
| POST | `?path=forum/deleteQuestion&id={id}` | Delete discussion |

### Contact

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `?path=contact/sendemailcontact` | Send contact email |

---

## Screenshots

### Home Page
The landing page features a carousel showcasing featured content and quick access to cinema listings.

### Cinema Management
Browse cinemas with accessibility filters, view details, and manage rooms.

### Film Catalog
Complete film database with posters, metadata, and screening schedules.

### IoT Dashboard
Real-time environmental monitoring with interactive charts displaying sound and temperature data.

### Forum
Community discussion board for cinema-related topics.

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards for PHP
- Use meaningful commit messages
- Test your changes before submitting
- Update documentation as needed

---

## License

This project is licensed under the **MIT License**. See the [LICENSE](LICENSE) file for details.

---

## Author

**Louis Lenouvel** - [GitHub Profile](https://github.com/LenouvelLouis)

### Contributors

See the [Contributors](https://github.com/LenouvelLouis/Event-It/graphs/contributors) page for all project contributors.

---

## Acknowledgments

- [PHPMailer](https://github.com/PHPMailer/PHPMailer) - Email library
- [Chart.js](https://www.chartjs.org/) - Charting library
- [Plotly.js](https://plotly.com/javascript/) - Interactive visualizations
- [Font Awesome](https://fontawesome.com/) - Icon library
