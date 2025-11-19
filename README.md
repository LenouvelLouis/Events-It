# 🎬 Event-It

Event-It is a PHP MVC web application for managing cinemas, films and screenings, with user accounts, a forum and IoT sensor statistics (sound and temperature) for each cinema room.

The UI is currently in French, but the codebase and structure are documented here in English for easier reuse and maintenance.

---

## 📚 Table of contents

1. Overview
2. Features
3. Tech stack
4. Getting started
5. Database setup
6. Configuration
7. Project structure
8. Screens and flows
9. Known limitations / TODO
10. License & author

---

## 1. Overview

Event-It centralizes the management of:

- Cinemas (contact info, accessibility options, indoor / outdoor)
- Films
- Screenings (séances)
- Users and roles (admin, manager, basic user)
- A forum for cinema related questions
- Live statistics for screenings based on IoT sensors  
  (sound level and temperature per room / screening)

It is designed as a teaching / learning project around PHP, MVC, MySQL and front-end JavaScript with charts.

---

## 2. Features

### 👥 Users & auth

- User registration and login
- Session based authentication (`$_SESSION`)
- Roles:
    - `admin`
    - `gestionnaire` (manager)
    - `user`
- User profile page:
    - View and update email and phone
    - Optional password reset
    - Logout

### 🎦 Cinemas & films

- List of cinemas with:
    - Address
    - Type: indoor or outdoor
    - Accessibility flags: wheelchair, deaf, visually impaired
    - Contact info and image
- Cinema creation form (admin / manager)
- Film management:
    - List films
    - Add / edit film with:
        - Title, description
        - Duration
        - Poster image
        - Age restrictions etc.

### 🕒 Screenings (séances)

- Create a screening:
    - Link to a cinema and a film
    - Choose room (`salle`)
    - Date and time
- Edit / delete screenings
- Detailed view of a screening, including sensor statistics (see next section)

### 📊 IoT statistics for screenings

For each screening, Event-It can display environmental data collected from sensors in the cinema room:

- Sound sensors (`data_capteur_son`)
- Temperature sensors (`data_capteur_temperature`)

On the **Statistiques de séances** page you get:

- Dropdown to select a screening
- Dynamic statistics:
    - Average, minimum, maximum, median, mode
- Charts:
    - Time series for sound and temperature
    - Chart.js and Plotly based visualizations

This can be used to study:
- Comfort of spectators
- Noise level throughout a screening
- Temperature evolution during a session

### 💬 Forum

- Forum page with:
    - Search bar and live suggestions for questions
    - List of discussions
    - Discussion view with messages
- Create new discussions
- Reply to existing discussions
- Stored in `discussion-forum` and `message-forum` tables

### 📩 Contact & email notifications

- Contact form with:
    - Name, email, message
- Server side validation
- Email sending with **PHPMailer** (via `MVC/service/mailService.php`)
- Notification component (`notifier`) for success / error messages displayed in the UI

### 🌐 Other pages

- Home page with carousel and hero images
- FAQ and CGU (terms of use) pages
- Users page listing all users (for admin)

---

## 3. Tech stack

**Backend**

- PHP 8 (procedural style with MVC structure)
- MySQL / MariaDB
- PHPMailer (SMTP emails)

**Frontend**

- HTML5, CSS3
- Vanilla JavaScript
- Chart.js and Plotly for charts
- moment.js + chartjs-adapter-moment for time-based charts
- Font Awesome for icons

**Architecture**

- Custom MVC routing through `MVC/index.php` using `?path=controller/action`
- Controllers in `MVC/controle/`
- Models in `MVC/modele/`
- Views in `MVC/vue/`
- Services in `MVC/service/` (e.g. mail service, notification helper)

---

## 4. Getting started

### ✅ Prerequisites

- PHP 8+
- MySQL / MariaDB
- A local web server (Apache, Nginx, WAMP, MAMP, XAMPP or similar)

### 🧩 Clone the project

```bash
git clone https://github.com/LenouvelLouis/Events-It.git
cd Events-It
```
### Database setup
Create a database:
```sql
CREATE DATABASE `events-it` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```
Import the SQL dump:
```bash
mysql -u root -p events-it < events-it.sql
```
Default connection configuration is defined in
MVC/modele/connectSQL.php:
```php
$hostname = "localhost";
$base     = "events-it";
$loginBD  = "root";
$passBD   = "root";
```

### Configuration
Edit `MVC/service/mailService.php` to set up SMTP email sending:
```php
$mail->Host

$mail->Username

$mail->Password

$mail->SMTPSecure

$mail->Port

$mail->setFrom(...)
```

### Project structure
```
Event-It/
├── events-it.sql         # Database schema + sample data
└── MVC/
    ├── index.php         # Front controller (router)
    ├── controle/         # Controllers
    │   ├── cinema.php
    │   ├── connexion.php
    │   ├── contact.php
    │   ├── film.php
    │   ├── forum.php
    │   ├── home.php
    │   ├── insciption.php
    │   ├── logout.php
    │   ├── seance.php
    │   ├── stat.php
    │   ├── utilisateur.php
    │   └── pages/        # Small routing wrappers for pages
    ├── modele/           # Database access layer
    │   ├── connectSQL.php
    │   ├── cinemaBD.php
    │   ├── filmBD.php
    │   ├── forumBD.php
    │   ├── seanceBD.php
    │   ├── statBD.php
    │   └── utilisateurBD.php
    ├── service/          # Services (e.g. mail)
    │   └── mailService.php
    ├── lib/              # Third party libraries
    │   └── PHPMailer/
    └── vue/              # Views (HTML/CSS/JS)
        ├── home/
        ├── navbar/
        ├── footer/
        ├── cinema/
        ├── film/
        ├── seance/
        ├── statseance/
        ├── forum/
        ├── profile/
        ├── users/
        ├── contact/
        └── style/

```
### 📄 License & Credits

This project is released under the **MIT License**.  
You are free to use, modify and distribute it, provided the original license is included.

👨‍💻 **Author**  
**Louis Lenouvel** — [GitHub Profile](https://github.com/LenouvelLouis)

🤝 **Contributors**  
For all additional contributors, please refer to the **GitHub Collaborators** section of the repository.
