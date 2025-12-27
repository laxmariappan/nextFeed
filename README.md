# nextFeed - Baby Feeding Tracker

A minimal, privacy-respecting, open-source baby feeding tracker designed for parents and caregivers. Built with Laravel and optimized for one-handed mobile use.

## Features

- **One-Tap Feed Logging** - Quick-log buttons for breast (left/right), bottle, and formula feeds
- **Edit Feed Logs** - Update feed times, quantities, and notes after logging
- **Feed History** - View recent feeding sessions with timestamps and durations
- **Statistics & Calendar** - Day/week/month views with visual calendar showing feeding patterns
- **Next Feed Reminder** - Countdown timer showing when the next feed is due with actual time
- **Timezone Support** - Configurable timezone for accurate time tracking
- **Daily Target Tracking** - Set and monitor daily milk intake goals
- **Dark Mode** - Manual dark mode toggle with localStorage persistence
- **Data Export** - Export feeding logs to CSV or JSON format
- **Privacy First** - All data stored locally, no external tracking
- **Mobile-First Design** - Large touch targets optimized for one-handed use at 3am
- **Soft Pastel Theme** - Eye-friendly colors for tired parents at night

## Screenshots

The app features:
- Large, color-coded feed type buttons at the bottom for thumb reach
- Feed history timeline with edit/delete options
- Next feed countdown reminder with actual time display
- Day/week/month statistics views
- Visual calendar showing feeding patterns
- Dark mode support with soft pastel colors
- Clean, distraction-free interface

## Tech Stack

- **Laravel 12** - Latest PHP framework
- **MySQL** - Database for storing feeding logs and settings
- **Tailwind CSS v4** - Styling with custom theme
- **Vite** - Asset bundling
- **Vanilla JavaScript** - Minimal JavaScript for interactivity
- **Carbon** - Date/time manipulation

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
   - **Left Breast** (soft lavender)
   - **Right Breast** (soft lavender)
   - **Bottle** (soft blue)
   - **Formula** (muted peach)
3. Enter the quantity in ml (quick-select buttons: 30, 60, 90, 120)
4. Feed is logged with the current timestamp

### Editing a Feed

1. Tap the edit icon (pencil) on any feed entry
2. Update any of the following:
   - Feed type
   - Start time
   - End time (optional)
   - Quantity (ml)
   - Notes (optional)
3. Tap "Update" to save changes

### Viewing History

- Recent feeds appear in chronological order below the reminder
- Each entry shows:
  - Quantity in ml
  - Feed type (color-coded badge)
  - Time ago
  - Full timestamp
  - Duration (if end time exists)
  - Notes (if added)

### Viewing Statistics

1. Tap the stats icon in the header
2. Choose from three views:
   - **Day** - Today's summary with feed timeline
   - **Week** - 7-day breakdown with daily totals
   - **Month** - Calendar view showing feeding patterns
3. Navigate between dates using arrow buttons

### Settings

1. Tap the settings icon in the header
2. Configure:
   - **Daily Target** - Set your ml goal (default: 700ml)
   - **Reminder Interval** - Time between feeds (default: 180 min)
   - **Timezone** - Your local timezone (default: Asia/Kolkata)
   - **Default Feed Type** - Preferred feed type for quick logging
   - **Notifications** - Enable/disable reminders

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
- `GET /stats?view={day|week|month}&date={Y-m-d}` - Statistics view
- `GET /settings` - Settings page
- `POST /settings` - Update settings

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
- [ ] Multiple baby profiles
- [ ] Enhanced charts and analytics
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
