## Courses platform

## Description
This Laravel 11 project aims to provide an online platform for hosting and managing courses.

## Features and Explanations

### 1. User Registration and Authentication
**Description:**  Users can create accounts, log in, and manage their profiles securely.

**Explanation:**
- Utilizes Laravel's built-in authentication system.
- Passwords are hashed for security.
- Users can reset their passwords via email.
- User roles (admin, teacher, student) can be managed for access control.

---

### 2. Course Listings and Catalog
**Description:**  A public catalog displays all available courses with details.

**Explanation:**
- Courses are shown with title, description, instructor, duration, and ratings.
- Users can search and filter courses by category or keyword.
- Each course has a dedicated page with full details and reviews.

---

### 3. Student Enrollment
**Description:**  Students can enroll in courses they are interested in.

**Explanation:**
- Enrollment is tracked in the database.
- Students can view their enrolled courses in their dashboard.
- Enrollment may be free or require payment, depending on course settings.

---

### 4. Admin Dashboard
**Description:**  Admins have a dedicated dashboard to manage the platform.

**Explanation:**
- Admins can create, update, or delete courses, categories, and users.
- System settings (like site name, contact email) can be managed.
- Admins can view statistics such as total users, enrollments, and revenue.

---

### 5. Teacher Dashboard
**Description:**  Teachers can manage their own courses and content.

**Explanation:**
- Teachers can create and edit courses, upload materials, and manage lessons.
- Teachers can view enrollments and student progress in their courses.

---

### 6. File Uploads for Courses
**Description:**  Courses can have images, videos, and documents attached.

**Explanation:**
- Images (jpg, png, webp), videos (mp4, mov, webm), and documents (pdf, doc, docx) are supported.
- Files are validated for type and size before upload.
- Old files are deleted when replaced to save storage.

---

### 7. Contact Form with Email Notifications
**Description:**  A contact form allows users to send messages to the admin.

**Explanation:**
- Submissions are stored in the database.
- An email notification is sent to the admin (configured via `MAIL_ADMIN` in `.env`).
- Uses Laravel's Mailable system for email formatting and delivery.

---

### 8. Reviews and Ratings
**Description:**  Students can leave reviews and ratings for courses.

**Explanation:**
- Each course page displays user reviews and average rating.
- Only enrolled students can leave reviews to ensure authenticity.

---

### 9. Wishlist
**Description:**  Users can add courses to their wishlist for future enrollment.

**Explanation:**
- Wishlists are user-specific and stored in the database.
- Users can view and manage their wishlist from their dashboard.

---

### 10. Search and Filtering
**Description:**  Users can search for courses and filter by category, rating, or other criteria.

**Explanation:**
- Search is performed on course name and description.
- Filtering options help users find relevant courses quickly.

---

### 11. Payment Integration (if enabled)
**Description:**  Supports paid courses with payment processing.

**Explanation:**
- Integrates with payment gateways (e.g., Stripe, PayPal).
- Handles payment validation, receipts, and enrollment upon successful payment.

---

### 12. Responsive Design
**Description:**  The platform is mobile-friendly and works on all devices.

**Explanation:**
- Uses Bootstrap for responsive layouts.
- Ensures usability on desktops, tablets, and smartphones.

---

### 13. Role-Based Access Control
**Description:**  Different user roles have different permissions.

**Explanation:**
- Admins have full access.
- Teachers can manage their own courses.
- Students can enroll, review, and track their courses.

---

### 14. Exam and Result Management
**Description:**  Courses can include exams and quizzes.

**Explanation:**
- Teachers can create exams for their courses.
- Students can take exams and view their results.
- Results are stored and can be reviewed by both students and teachers.

---

### 15. Certification PDF After Exam Success
**Description:**  When a user successfully passes an exam, a downloadable PDF certificate is generated.

**Explanation:**
- Uses a package like `barryvdh/laravel-dompdf` to generate certificates.
- After passing an exam, the system creates a PDF with user/course details.
- Certificate is available for download in the user dashboard and can be emailed to the user.

---

### 16. Notifications for New Contact Messages
**Description:**  Admins are notified when a new contact message is received.

**Explanation:**
- In addition to email, in-app notifications are sent to admins.
- Notifications appear in the admin dashboard for quick response.

---

### 17. Notifications for Admin/Teacher CRUD Actions
**Description:**  Users are notified when admins or teachers perform actions that affect them (e.g., course created, updated, deleted).

**Explanation:**
- Notifications are triggered after CRUD actions in relevant controllers.
- Enrolled users are notified of changes to their courses.
- Notifications can be in-app and/or via email.

---


## Technologies Used
- Laravel 11
- PHP
- MySQL
- HTML/CSS
- JavaScript
- Bootstrap

## Installation

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd laravel_courses_platform
   ```
2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```
3. **Copy and configure environment:**
   ```bash
   cp .env.example .env
   ```
   - Set your database credentials in `.env`
   - Set `MAIL_ADMIN` to the admin email for contact notifications
   - Configure mail settings for email sending
4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
5. **Run migrations:**
   ```bash
   php artisan migrate
   ```
6. **(Optional) Seed the database:**
   ```bash
   php artisan db:seed
   ```
7. **Build frontend assets:**
   ```bash
   npm run build
   ```

## Running the Application

- Start the local development server:
  ```bash
  php artisan serve
  ```
- Visit [http://localhost:8000](http://localhost:8000) in your browser.

## Key Files and Their Purpose

- `app/Models/Contact.php`: Handles contact form submissions and sends admin notifications via email.
- `app/Mail/ContactMail.php`: Defines the email sent to the admin when a contact form is submitted.
- `app/Http/Controllers/ContactController.php`: Manages contact form requests.
- `app/Services/`: Contains business logic for courses, lessons, exams, etc.
- `resources/views/`: Blade templates for all pages (home, admin, teacher, contact, etc.)

## Mail/Contact Functionality

- The contact form sends an email to the admin address specified in `.env` as `MAIL_ADMIN`.
- Make sure your mail settings (`MAIL_MAILER`, `MAIL_HOST`, etc.) are correctly configured in `.env`.
- Example:
  ```
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.mailtrap.io
  MAIL_PORT=2525
  MAIL_USERNAME=your_username
  MAIL_PASSWORD=your_password
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS=from@example.com
  MAIL_FROM_NAME="Courses Platform"
  MAIL_ADMIN=admin@example.com
  ```

## Contribution Guidelines

1. Fork the repository and create your branch.
2. Commit your changes with clear messages.
3. Push to your fork and submit a pull request.

## Troubleshooting

- **Email not sending:** Check your `.env` mail settings and ensure your mail server is running.
- **Database errors:** Ensure you have run migrations and your database credentials are correct.
- **File uploads not working:** Check permissions on the `public/uploads` directory.








