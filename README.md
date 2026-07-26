# TrendAura 🛍️

A full-featured PHP + MySQL e-commerce platform for fashion, footwear, and accessories —
with a customer-facing storefront and a separate admin panel for managing the catalog,
orders, and users.

---

## ✨ Features

### Customer-facing site (`web/`)
- Product catalog with categories & sub-categories
- Cart, checkout, and order placement (Cash on Delivery — see
  `PAYMENT_GATEWAY_README.md` for adding a real gateway later)
- Email + password authentication (login/register)
- **Order tracking** — a visual status timeline (Pending → Processing → Shipped →
  Delivered) on `track-order.php`, with full history of status changes
- **Customer-initiated order cancellation** — customers can cancel their own order
  while it's still Pending/Processing; cancelled/delivered orders lock further
  changes, and cancelling automatically restocks the ordered items
- Stock is only deducted at checkout — not when an item is merely added to a cart
- Branded HTML order-confirmation emails (PHPMailer + Gmail SMTP)
- Mobile-responsive layout, optimized images, and a shared toast notification system
  (no native browser `alert()` popups)
- Per-page SEO titles/meta descriptions, `robots.txt`, and a dynamic `sitemap.php`
  that stays in sync with the live product catalog

### Admin panel (`admin/`)
- Role-based access (Admin, Product Manager, Order Dispatcher)
- Full CRUD for categories, sub-categories, products, roles, homepage slider, and
  the "About Us" page
- Order management with a status workflow (Pending → Processing → Shipped →
  Delivered). Admins cannot set an order to Cancelled — that's customer-initiated
  only. Delivery automatically marks payment as Paid. Delivered/Cancelled orders are
  locked to further edits.
- **Analytics dashboard** — 14-day sales trend chart, order-status breakdown, top
  products, top customers, and a low-stock alert list (ApexCharts). All figures
  correctly exclude cancelled orders from "sold"/revenue counts, and revenue only
  counts Delivered orders (when the money is actually collected).
- Admin-styled toast notifications (no native browser `alert()` popups)

### Security
- Parameterized queries (prepared statements) throughout — no raw SQL string
  concatenation from user input
- CSRF protection on login, registration, checkout, and order actions
- Credentials (DB + Gmail SMTP) loaded from a `.env` file, never hardcoded, and
  excluded from version control via `.gitignore`

---

## 🧱 Tech Stack
- **Backend:** PHP (vanilla, mysqli with prepared statements)
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap-based theme, vanilla JS, ApexCharts (admin analytics)
- **Email:** PHPMailer via Gmail SMTP
- **Admin theme:** Bootstrap 5 admin template

---

## 🚀 Setup (local — XAMPP or similar)

1. **Clone/copy the project** into your server's web root (e.g. `htdocs/TrendAura`).

2. **Create the database** and import the schema:
   - Create a MySQL database (e.g. `ecommerce`)
   - Import `ecommerce.sql`
   - Import `migration_phase4.sql` (adds payment tracking + order status history —
     required for the order tracking feature; skip this if your database already
     has these columns/table)

3. **Configure environment variables:**
   - Copy `.env.example` to `.env` in the project root
   - Fill in your database credentials and Gmail SMTP app password (generate one at
     [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords) —
     never use your real Gmail password)
   - Set `APP_ENV=local` for development (shows detailed PHP errors) or
     `APP_ENV=production` when deployed live (hides them)

4. **Visit the site:**
   - Storefront: `http://localhost/TrendAura/web/home.php`
   - Admin panel: `http://localhost/TrendAura/admin/login.php`

---

## 📁 Key Files & Folders

| Path | What it is |
|---|---|
| `web/` | Customer-facing storefront |
| `admin/` | Admin panel |
| `config/db.php`, `config/env.php`, `config/csrf.php` | Shared DB connection, `.env` loader, and CSRF helpers |
| `ecommerce.sql` | Base database schema + seed data |
| `migration_phase4.sql` | Adds `payment_method`/`payment_status` to orders + `order_status_history` table |
| `.env.example` | Template for required environment variables |
| `PAYMENT_GATEWAY_README.md` | How the current COD-only payment flow works, and how to plug in a real gateway (JazzCash/Easypaisa/Stripe) later |
| `PHASE1_SECURITY_CHANGELOG.md` | Detailed log of the security hardening pass (SQL injection fixes, credential handling, CSRF) |

---

## ⚠️ Before deploying live

- Rotate any credentials that were ever committed or shared in plain text
- Double-check `.env` is **not** tracked by git (`git status` should never show it)
- Update the placeholder domain in `web/robots.txt` and `web/sitemap.php`
- Set `APP_ENV=production` on the live server
