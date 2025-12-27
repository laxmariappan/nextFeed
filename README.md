# nextFeed - Baby Feeding Tracker

A minimal, privacy-respecting, open-source baby feeding tracker designed for parents and caregivers. Built with Laravel and optimized for one-handed mobile use.

## Features

- **One-Tap Feed Logging** - Quick-log buttons for breast (left/right), bottle, and formula feeds
- **Feed History** - View recent feeding sessions with timestamps and durations
- **Next Feed Reminder** - Countdown timer showing when the next feed is due
- **Dark Mode** - Automatic dark mode with manual toggle
- **Data Export** - Export feeding logs to CSV or JSON format
- **Privacy First** - All data stored locally, no external tracking
- **Mobile-First Design** - Large touch targets optimized for one-handed use at 3am

## Screenshots

The app features:
- Large, color-coded feed type buttons at the bottom for thumb reach
- Feed history timeline with edit/delete options
- Next feed countdown reminder
- Dark mode support
- Clean, distraction-free interface

## Tech Stack

- **Laravel 12** - Latest PHP framework
- **MySQL** - Database
- **Tailwind CSS** - Styling
- **Vite** - Asset bundling
- **Alpine.js** (via Blade) - Minimal JavaScript interactivity

## Installation

### Prerequisites

- PHP 8.2+
- Composer
- MySQL
- Node.js & npm
- Laravel Herd (recommended) or similar local PHP environment

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/laxmariappan/nextFeed.git
   cd nextFeed
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   ```

   Edit `.env` and configure your database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nextfeed
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Create database**
   ```bash
   mysql -u root -e "CREATE DATABASE nextfeed CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
   ```

7. **Run migrations**
   ```bash
   php artisan migrate
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

   For development with hot reload:
   ```bash
   npm run dev
   ```

9. **Start the application**

   If using Laravel Herd:
   - The app should be available at `http://nextfeed.test`

   Otherwise, use Laravel's built-in server:
   ```bash
   php artisan serve
   ```
   - Visit `http://localhost:8000`

## Usage

### Logging a Feed

1. Open the app
2. Tap one of the four large buttons at the bottom:
   - **Left Breast** (pink)
   - **Right Breast** (purple)
   - **Bottle** (blue)
   - **Formula** (amber)
3. Feed is instantly logged with the current timestamp

### Viewing History

- Recent feeds appear in chronological order below the reminder
- Each entry shows:
  - Feed type (color-coded badge)
  - Time ago
  - Start time (and end time if tracked)
  - Duration (if end time exists)
  - Quantity in ml (if tracked)
  - Notes (if added)

### Deleting a Feed

- Tap the trash icon on any feed entry
- Confirm deletion

### Exporting Data

- Tap the download icon in the top right
- Choose format (CSV or JSON)
- Data downloads to your device

### Dark Mode

- Tap the sun/moon icon in the top right
- Preference is saved to localStorage

## API Endpoints

### Web Routes

- `GET /` - Dashboard (feed list)
- `POST /feeding-logs` - Create new feed
- `PUT /feeding-logs/{id}` - Update feed
- `DELETE /feeding-logs/{id}` - Delete feed
- `GET /export?format=csv|json` - Export data

### JSON API

All endpoints support JSON requests/responses by setting:
```
Accept: application/json
Content-Type: application/json
```

## Database Schema

### feeding_logs Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| type | enum | breast_left, breast_right, bottle, formula |
| start_time | datetime | When feeding started |
| end_time | datetime (nullable) | When feeding ended |
| quantity_ml | integer (nullable) | Amount in milliliters |
| notes | text (nullable) | Additional notes |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### settings Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| key | string (unique) | Setting name |
| value | text (nullable) | Setting value |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
./vendor/bin/pint
```

### Watch Assets (Development)

```bash
npm run dev
```

## Roadmap

- [ ] Timer mode for tracking feed duration in real-time
- [ ] Customizable reminder intervals
- [ ] Multiple baby profiles
- [ ] Charts and analytics
- [ ] PWA support for offline use
- [ ] Diaper change tracking
- [ ] Sleep tracking
- [ ] Cloud backup option (encrypted, user-controlled)
- [ ] Agent API for physical buttons/voice commands

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Privacy

nextFeed is designed with privacy as a core principle:

- All data stored locally on your server/device
- No external analytics or tracking
- No user accounts required
- Data export available at any time
- Open source for full transparency

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

For bugs and feature requests, please [open an issue](https://github.com/laxmariappan/nextFeed/issues).

## Acknowledgments

Built with love for tired parents everywhere 💜

---

**nextFeed** - Track feeds, not stress.
