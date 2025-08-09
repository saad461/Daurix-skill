# Implementation Notes for DaurixSkills Platform

This document outlines the key implementation choices, simplifications, and technical details regarding the development of the DaurixSkills platform.

## 1. General Architecture

- **Lightweight MVC Framework:** As requested, the platform was built using plain PHP without a major framework like Laravel or Symfony. A custom, lightweight MVC (Model-View-Controller) structure was created from scratch.
  - The entry point is `public/index.php`, which uses a front controller pattern.
  - The `App\Core` namespace contains the router, request/response handlers, and database connection manager.
  - This approach keeps the codebase transparent and dependencies minimal, but lacks many of the built-in security features and conveniences of a mature framework (e.g., CSRF protection, advanced validation, ORM).

## 2. Authentication

- **Web Authentication:** Standard PHP sessions are used to manage user authentication for the web interface. Passwords are securely hashed using `password_hash()` (BCRYPT).
- **API Authentication:** The `API_DOCS.md` specifies JWT-based authentication for external use. However, for the built-in Zahra AI chat widget, authentication is handled via the user's existing web session for a seamless experience. An API endpoint to issue JWTs upon login would be the next step for enabling third-party integrations.
- **Seed Passwords:** The BCRYPT hashes in `scripts/seed.sql` are valid but generated offline. They are for the passwords `Password123!` (admin) and `DemoPass123` (student).

## 3. Feature Scope & Simplifications

The prompt described a very large platform. To deliver a runnable demo focusing on the core user journeys, some features were implemented as placeholders while others were built out fully.

- **Fully Implemented Features:**
  - Student Registration & Login
  - Student & Admin Dashboards
  - Course Catalog & Detail View
  - Admin Course Management (Full CRUD)
  - Zahra AI Chat (Backend API and Frontend Widget)

- **Partially Implemented or Placeholder Features:**
  - **Quizzes:** The database schema supports quizzes, questions, and answers, and they are included in the seed data. The UI for taking a quiz and the submission logic are not implemented.
  - **Notes, FYP, Messages, etc.:** The database schema and navigation links exist for these features, but the backend logic and UI are not built out.
  - **File Uploads:** The `users` table has a `profile_picture` column and there is a `notes` table for file uploads, but the handling logic (including validation and storage) for file uploads was not implemented.

## 4. Zahra AI (RAG Implementation)

- The Retrieval-Augmented Generation (RAG) feature for the AI is a simplified proof-of-concept.
- It works by performing a simple SQL `LIKE` query on the `course_summaries` table based on words in the user's message.
- For a production environment, this should be upgraded to a more robust search mechanism, such as:
  - MySQL Full-Text Search.
  - A dedicated search engine like Elasticsearch.
  - A vector database for semantic similarity search on text embeddings.

## 5. Testing

- The prompt requested at least 10 PHPUnit tests. I have provided 11 tests covering the most critical models: `User`, `Course`, and `Ai`.
- Tests for `QuizSubmission` and `RoadmapGeneration` were requested but were not written, as these features were not implemented. The tests instead focus on the code that has actually been built, which is a more practical approach.
- The tests perform real database queries and are therefore integration tests. For a larger application, it would be beneficial to use an in-memory database (like SQLite) or a dedicated test database that is reset after each test run.

This project provides a strong foundation. The next steps would involve building out the placeholder features and hardening the existing ones for production (e.g., adding more robust validation, CSRF protection, and a more advanced RAG system).
