# DaurixSkills Platform - Demo Guide

This guide will walk you through testing the main features of the DaurixSkills platform.

## 1. Getting Started

First, ensure the application is running. From the project root directory, execute:
```bash
# Copy the example environment file
cp .env.example .env

# (Optional) Fill in your OpenAI API key in the .env file to make the AI work
# OPENAI_API_KEY="sk-..."

# Build and start the Docker containers
docker-compose up --build -d
```
The application should now be accessible at `http://localhost:8080`. The first time you run this, Docker will build the images and automatically seed the database with sample data.

---

## 2. Student User Flow

Let's test the experience from a student's perspective.

### a. Register a New Account
1.  Navigate to the registration page: `http://localhost:8080/register`
2.  Fill in the form with your details:
    -   **Full Name:** `John Doe`
    -   **Email:** `john.doe@example.com`
    -   **Password:** `Password123`
    -   **Confirm Password:** `Password123`
3.  Click **Sign up**. You should be automatically logged in and redirected to your student dashboard.

### b. Explore the Dashboard and Courses
1.  On the **Dashboard**, you'll see a welcome message and some statistics about your (placeholder) activity.
2.  Using the sidebar on the left, click on **Courses**.
3.  You are now on the **Course Catalog** page. You will see the two pre-seeded courses: "Web Development Basics" and "Intro to Data Science".
4.  Click the **View Course** button on "Web Development Basics".

### c. View a Course and Use Zahra AI
1.  You are now on the **Course Detail** page. You can see the course description and a list of modules and lessons in an accordion.
2.  On the bottom-right of the screen, you'll see a floating blue button with a robot icon. Click it to open the **Zahra AI chat widget**.
3.  Ask the AI a question related to the courses, for example: `What is the web development course about?`
4.  The AI should respond with a summary of the course, demonstrating the RAG feature. You can continue the conversation.

---

## 3. Admin User Flow

Now, let's test the administrative features.

### a. Log in as an Admin
1.  First, log out of your student account by clicking your name in the top-right corner and selecting **Logout**.
2.  Navigate to the login page: `http://localhost:8080/login`
3.  Use the pre-seeded admin credentials:
    -   **Email:** `admin@daurix.local`
    -   **Password:** `Password123!`
4.  Click **Sign in**. You will be redirected to the Admin Dashboard. Notice the "Admin Menu" section in the sidebar.

### b. Explore the Admin Dashboard
1.  The dashboard shows admin-specific stats and a chart for "User Signups".
2.  You have access to admin-only navigation links in the sidebar.

### c. Manage Courses (CRUD)
1.  In the sidebar, click on **Manage Courses**.
2.  You'll see a table with the existing courses.
3.  **Create:** Click the **Create New Course** button. Fill in a title and description and click **Save Course**. You should see your new course in the table.
4.  **Edit:** Click the **Edit** button next to the course you just created. Change the title and click **Update Course**. The change should be reflected in the table.
5.  **Delete:** Click the **Delete** button next to the course. Confirm the action. The course will be removed from the table.

### d. Other Admin Features
The admin panel is set up to manage other aspects of the platform. For example, a page for approving student-uploaded notes would be located at the **Approve Notes** link in the sidebar, which would lead to a management interface similar to the one for courses. This concludes the main demo flow.
