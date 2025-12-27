# nextFeed – PRD & Claude Agent Spec

### TL;DR

nextFeed is a minimal, privacy-respecting, open-source baby feeding tracker designed for parents and caregivers who need an effortless way to log, review, and recall feeding sessions. It emphasizes ease-of-use with one-handed operation and optional reminders, aiming to reduce cognitive overhead while providing just enough history to empower confident, stress-free care.

---

## Goals

### Business Goals

* Deliver an open-source MVP for baby feeding tracking within 4 weeks.

* Achieve 100+ GitHub stars and at least 25 active users within 3 months.

* Obtain user satisfaction ratings above 80% in post-use surveys.

* Encourage contributions from at least 3 external developers in the first 6 months.

### User Goals

* Enable rapid, single-handed logging of breast, bottle, or formula feedings.

* Offer clear, concise history of recent feeding times and quantities.

* Provide optional, customizable notifications for the next potential feeding.

* Ensure full data ownership: users can export and control their own feeding logs.

* Deliver a distraction-free, mobile-first interface usable at 3 a.m.

### Non-Goals

* No social sharing, growth hacks, or integrations with commercial health platforms.

* No advanced analytics or diagnosis (nextFeed is not a health advice tool).

* No user account management beyond local device or encrypted personal cloud storage.

---

## User Stories

**Parent or Caregiver**

* As a parent, I want to quickly log a feeding with one hand, so that I can record feedings even while holding my baby.

* As a caregiver, I want to review the last few feeds at a glance, so that I never double-feed or miss a session.

* As a parent, I want to set a gentle reminder for the next expected feeding, so that I don’t stress about tracking time mentally.

* As a user, I want to keep all feeding data private and portable, so that I’m in control of this sensitive information.

**Co-Parent/Partner**

* As a co-parent, I want to view or contribute to the same feeding log on a shared device, so that our team caregiving stays in sync.

**Developer/User with Technical Skills**

* As a technically minded user, I want to self-host or audit the code, so that I trust the product and can adapt it if needed.

* As an open-source developer, I want clear contribution guidelines, so that I can efficiently improve the app.

---

## Functional Requirements

* **Feeding Log & Tracking (Priority: High)**

  * Log feeding events: Record type (breast, bottle, formula), start/end time, and optional quantity.

  * One-tap entry from a minimal main screen dedicated to rapid use.

  * View recent feed history: Display a timeline of the last 12–24 hours or N events.

  * Edit/delete previous entries with minimal steps.

* **Reminders & Notifications (Priority: Medium)**

  * Optional, user-configurable reminders for next feeding interval (customizable default).

  * Silent/DND modes for nighttime use.

* **Privacy & Data Controls (Priority: High)**

  * Local-only storage by default, with optional encrypted cloud backup (only via user’s cloud storage, e.g. Dropbox, iCloud).

  * Data export to CSV or JSON for portability.

* **Settings & Customization (Priority: Low)**

  * Dark mode and font size adjustments.

  * Customization of feeding types, units, and recurring schedules.

* **Open Source/Technical Features (Priority: Medium)**

  * Developer-friendly documentation and local setup instructions.

  * Simple agent/plugin API for integrating physical buttons or voice triggers.

---

## User Experience

**Entry Point & First-Time User Experience**

* Users discover the app via GitHub, open-source catalogs, or a friend’s recommendation.

* Upon first launch: a 1–2 screen onboarding introduces privacy, local storage, and how to start the first log.

* Optional (skippable) 20-second interactive demo: “Swipe or tap here to start a feed.”

**Core Experience**

* **Step 1:** Open the app (from home screen or quick-launch).

  * Main action button (“Start Feed”) clearly visible at thumb’s reach.

  * No login, splash, or onboarding once set up.

* **Step 2:** Start logging a feed.

  * One-tap for time-stamped log, plus optional quick-select: left/right breast, bottle, specify ounces/ml.

  * Defaults to current time; can easily override before saving.

  * Large buttons, easy to reach at bottom of the screen.

  * Error checks: required type; fallback to current time if time not specified.

* **Step 3:** End feeding (if tracking duration).

  * One-tap “Stop” or “Finish” if duration is measured, else auto-log for quick sessions.

  * Success: clear, immediate feedback (e.g., “Feed logged!” snackbar).

  * Snackbar “Undo” for accidental taps.

* **Step 4:** Review history.

  * Feed timeline displayed beneath log controls; swipe or scroll for more.

  * Tapping a feed opens an edit/delete modal.

  * “Next Feed in NN minutes” indicator, if reminders enabled.

* **Step 5:** Export or backup data.

  * “Export” button in settings triggers download of CSV/JSON to user’s chosen location.

  * Backup to cloud (if enabled) is manual-first, auto-optional.

* **Step 6:** Settings.

  * Accessible via unobtrusive icon.

  * Customize reminders, feeding types, notification modes.

**Advanced Features & Edge Cases**

* Quick physical shortcut: (if agent API) map feed logging to a voice command or smart button.

* Error handling: warning if device storage is full or write fails.

* Zero state UI: friendly instructions if no feeds are logged yet.

* Split/join feeds: combine or split two events if entered incorrectly.

**UI/UX Highlights**

* High-contrast, large-tap targets for one-handed/nighttime use.

* Responsive, mobile-first single-column design.

* All core actions reachable within a thumb’s radius.

* Minimal/no scrolling required for basic logging.

* Accessible color palette and readable font sizes.

* Respect user’s device accessibility settings (font scaling, high contrast).

---

## Narrative

It’s 4 a.m. in a softly-lit nursery. Ali, a first-time parent, cradles a sleepy, hungry baby with one arm while instinctively reaching for their phone with the other. Between exhaustion and worry, Ali struggles to remember the last feeding—was it 2 or 3 hours ago? Should they wake their partner to check the shared notes? Instead, nextFeed opens to a clean, high-contrast screen. A single tap logs the start of the feeding session; an optional swipe adds which side or bottle. When the session ends, nextFeed quietly records it, updating a simple history below. A gentle reminder is set for the next likely feed—no more clock-watching or second-guessing. Ali breathes easier, knowing the log is up-to-date and private, ready for doctor visits or just a peace-of-mind check. With nextFeed’s minimal workflow, they regain confidence and rest, trusting their data and their intuition.

---

## Success Metrics

### User-Centric Metrics

* Onboarding completion rate

* Median time to first log entry (<60 seconds)

* User-rated ease of one-handed use (survey)

* Feature (reminder) adoption

### Business Metrics

* Open-source engagement: GitHub stars, issues, and 3rd-party contributions

* Number of organic installs or deployments

### Technical Metrics

* Bug or crash reports per 100 sessions

* Successful local data exports/backups

### Tracking Plan

* App installs/first launches

* Feeding log creation and edit events

* Reminder set/off events

* Data export/backup/download

* In-app settings changes

* Errors/failures (anonymized, opt-in-only)

---

## Technical Considerations

### Technical Needs

* **Core Components:**

  * Simple feeding event data model (type, time, quantity)

  * Local data storage layer (file or lightweight embedded DB)

  * Mobile-first front end with touch input optimization

  * Minimal notification/reminder service

  * Settings and export/backup utility

* **Agent Specification:**

  * Simple API for “external triggers” (e.g., HTTP POST, Bluetooth button, voice assistant plugin)

  * Documentation for open-source agent extensions

### Integration Points

* Local device APIs (notifications, file system)

* Optional: Encrypted user cloud storage APIs (e.g., Dropbox, iCloud)

* Optional: Bluetooth/voice agent interface (open plugin, not proprietary)

### Data Storage & Privacy

* All feeding events stored locally by default, never sent off-device.

* User-initiated, opt-in backup/encrypted sync as extension only.

* No account creation, no third-party analytics by default.

* All exports/downloads user-driven.

* Documentation for user self-audit/export.

* Conform to GDPR/local privacy best practices for open source (no personal data by default).

### Scalability & Performance

* Target single-user or small-team (co-parents) use on one device.

* Fast startup and instant logging (<1s response).

* Minimal memory and battery demand.

### Potential Challenges

* Ensuring crash-free performance on a range of devices/OSs.

* Secure implementation of cloud backups (if enabled).

* UX that works equally well for left-/right-handed and visually impaired users.

* Error handling for storage/notification failures.

---

## Milestones & Sequencing

### Project Estimate

* **Medium:** 2–4 weeks for MVP (core local logging, history, basic reminders, data export), open-source-ready.

### Team Size & Composition

* **Small Team: 1–2 total people**

  * Product owner/UX (could also be the front-end dev)

  * Developer (front-end + light back-end/data)

### Suggested Phases

**Phase 1: MVP Core (1.5–2 weeks)**

* Key Deliverables: Feeding logging, timeline/history, edit/delete, dark mode, minimal settings (Product/Dev)

* Dependencies: None (local only)

**Phase 2: Notifications & Reminders (0.5–1 week)**

* Key Deliverables: Reminder system, DND/night mode, customizable intervals (Dev)

* Dependencies: Mobile notification API

**Phase 3: Data Export & Privacy (0.5 week)**

* Key Deliverables: CSV/JSON export, backup UI, privacy statement/docs (Dev)

* Dependencies: File system API

**Phase 4: Open Source & Agent API (0.5 week)**

* Key Deliverables: Public repo, contribution guidelines, basic agent/plugin API, self-hosting guide (Product/Dev)

* Dependencies: Finalized data model/api

---