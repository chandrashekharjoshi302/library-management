Here's the brief documentation:

## Documentation for Book List Application

### 1. Design Choices

**Frontend:**
- **React**: Chosen for its component-based architecture, allowing for reusable components and efficient rendering.
- **CSS**: Custom CSS is used for styling, providing a clean and modern look.
- **State Management**: `useState` and `useEffect` hooks manage the application state and side effects, such as fetching data.
- **Routing**: `react-router-dom` is used for navigation between pages (e.g., Home, Add Book, Borrow Book).
- **LocalStorage**: Used to store the authentication token securely in the user's browser.

**Backend:**
- **Laravel**: Provides a robust framework with built-in support for RESTful API development.
- **Authentication**: Token-based authentication ensures secure access to the API.
- **Validation**: Laravel's validation ensures that only valid data is accepted by the API.

### 2. Setup Instructions

#### Prerequisites:
- **Node.js** and **npm** installed on your system.
- **PHP** and **Composer** installed on your system.
- **MySQL** or any other database supported by Laravel.

#### Backend (Laravel):
1. Clone the repository:
   ```bash
   git clone https://github.com/chandrashekharjoshi302/library-management.git
   cd backend
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy the `.env.example` to `.env` and configure your database:
   ```bash
   cp .env.example .env
   ```

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Migrate the database:
   ```bash
   php artisan migrate
   ```

6. Serve the application:
   ```bash
   php artisan serve
   ```

#### Frontend (React):
1. Navigate to the frontend directory:
   ```bash
   cd frontend
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Run the React application:
   ```bash
   npm start
   ```

API Endpoints
Authentication
Signup

Endpoint: POST /api/signup
Description: Registers a new user.
Request Body:
json
Copy code
{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
Response:
json
Copy code
{
  "status": true,
  "message": "User registered successfully.",
  "token": "auth_token_here"
}
Login

Endpoint: POST /api/login
Description: Authenticates a user and provides a token.
Request Body:
json
Copy code
{
  "email": "johndoe@example.com",
  "password": "password123"
}
Response:
json
Copy code
{
  "status": true,
  "message": "Login successful.",
  "token": "auth_token_here"
}
Books Management
Get All Books

Endpoint: GET /api/books
Description: Retrieves a list of all books.
Response:
json
Copy code
{
  "status": true,
  "data": [
    {
      "id": 1,
      "title": "Book Title",
      "author": "Author Name",
      "publication_year": 2023,
      "genre": "Fiction",
      "is_borrowed": false,
      "image": "book_image.jpg"
    }
  ]
}
Get Filtered Books

Endpoint: GET /api/books?author={author}&genre={genre}&publication_year={year}
Description: Retrieves books based on optional filters.
Response: Same as "Get All Books".
Add a New Book

Endpoint: POST /api/books
Description: Adds a new book to the collection.
Request Body:
json
Copy code
{
  "title": "Book Title",
  "author": "Author Name",
  "publication_year": 2023,
  "genre": "Fiction",
  "image": "book_image.jpg"
}
Response:
json
Copy code
{
  "status": true,
  "message": "Book added successfully.",
  "data": {
    "id": 1,
    "title": "Book Title",
    "author": "Author Name",
    "publication_year": 2023,
    "genre": "Fiction",
    "is_borrowed": false,
    "image": "book_image.jpg"
  }
}
Update a Book

Endpoint: PUT /api/books/{id}
Description: Updates details of an existing book.
Request Body: Same as "Add a New Book".
Response:
json
Copy code
{
  "status": true,
  "message": "Book updated successfully."
}
Delete a Book

Endpoint: DELETE /api/books/{id}
Description: Deletes a book from the collection.
Response:
json
Copy code
{
  "status": true,
  "message": "Book deleted successfully."
}
Borrowing and Returning Books
Borrow a Book

Endpoint: POST /api/books/{id}/borrow
Description: Marks a book as borrowed.
Response:
json
Copy code
{
  "status": true,
  "message": "Book borrowed successfully."
}
Return a Book

Endpoint: POST /api/books/{id}/return
Description: Marks a book as returned.
Response:
json
Copy code
{
  "status": true,
  "message": "Book returned successfully."
}


This documentation should help in understanding the project structure, setting up the environment, and using the API effectively.
