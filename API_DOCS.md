# DaurixSkills API Documentation

This document provides details on the available API endpoints for the DaurixSkills platform.

## Authentication

All API endpoints require authentication. The authentication method is **JWT (JSON Web Token)**. The token must be provided in the `Authorization` header with the `Bearer` scheme.

**Example Header:**
```
Authorization: Bearer <your_jwt_token>
```
*Note: The current implementation for the internal Zahra AI widget uses the user's active web session for authentication. For external API usage, a JWT would be issued upon login.*

---

## AI Endpoints

### 1. AI Chat

This endpoint provides access to the Zahra AI assistant. It supports conversation history through a `session_id`.

- **Endpoint:** `POST /api/ai/chat`
- **Description:** Sends a user message to the AI assistant and receives a response. The endpoint uses a simple RAG (Retrieval-Augmented Generation) system to provide context from relevant course summaries.
- **Authentication:** Required (User session or JWT).

#### Request Body

The request body must be a JSON object with the following properties:

| Field         | Type   | Required | Description                                                  |
|---------------|--------|----------|--------------------------------------------------------------|
| `message`     | string | Yes      | The message from the user to the AI.                         |
| `session_id`  | string | No       | An identifier for the conversation. If omitted, a new one is generated. |

**Example Request Body:**
```json
{
  "message": "Can you tell me about web development?",
  "session_id": "chat_1678886400000"
}
```

#### Responses

**Success Response (200 OK):**
A JSON object containing the AI's reply and the session ID.

| Field         | Type   | Description                                                  |
|---------------|--------|--------------------------------------------------------------|
| `reply`       | string | The AI's response message.                                   |
| `session_id`  | string | The session ID for the conversation (useful for subsequent calls). |

**Example Success Response:**
```json
{
  "reply": "Of course! The Web Development Basics course covers HTML for structure, CSS for styling, and JavaScript for interactivity. It's a great starting point for beginners!",
  "session_id": "chat_1678886400000"
}
```

**Error Response (400 Bad Request):**
If the `message` field is missing or empty.
```json
{
  "error": "Message is required"
}
```

**Error Response (500 Internal Server Error):**
If the server fails to communicate with the AI service.
```json
{
  "error": "Failed to get response from AI service"
}
```

#### Example cURL Request

```bash
curl -X POST http://localhost:8080/api/ai/chat \
-H "Content-Type: application/json" \
-H "Authorization: Bearer <your_jwt_token>" \
-d '{
  "message": "What is data science?",
  "session_id": "chat_session_12345"
}'
```
