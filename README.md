Here's the improved documentation:

---

## **Documentation for Book List Application**

### **1. Design Choices**

#### **Frontend:**
- **React:** 
  - Chosen for its component-based architecture, which allows for reusable components and efficient rendering.
  - **Routing:** Utilizes `react-router-dom` for navigation between different pages (e.g., Home, Add Book, Borrow Book).
  - **State Management:** `useState` and `useEffect` hooks manage application state and side effects, such as fetching data from the backend.
  - **CSS:** Custom CSS is used to style the application, ensuring a clean, modern, and responsive user interface.
  - **LocalStorage:** Used to store the authentication token securely in the user's browser, which is then used for authenticated API requests.

#### **Backend:**
- **Laravel:** 
  - A robust PHP framework chosen for its built-in support for RESTful API development and easy integration with database systems.
  - **Authentication:** Implements token-based authentication using Laravel Sanctum, ensuring secure access to API endpoints.
  - **Validation:** Uses Laravel's powerful validation feature to ensure that only valid data is processed by the API.
  - **SOLID Principles:** The codebase follows SOLID principles, ensuring maintainability, scalability, and ease of understanding.

---

### **2. Setup Instructions**

#### **Prerequisites:**
- **Node.js** and **npm** installed on your system.
- **PHP** and **Composer** installed on your system.
- **MySQL** or any other database supported by Laravel.

#### **Backend (Laravel):**

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/chandrashekharjoshi302/library-management.git
   cd library-management/backend
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   ```

3. **Environment Setup:**
   - Copy the `.env.example` file to `.env` and configure your database:
     ```bash
     cp .env.example .env
     ```
   - Generate the application key:
     ```bash
     php artisan key:generate
     ```
   - Update the `.env` file with your database credentials.

4. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

5. **Serve the Application:**
   ```bash
   php artisan serve
   ```
   - The application will be available at `http://localhost:8000`.

#### **Frontend (React):**

1. **Navigate to the Frontend Directory:**
   ```bash
   cd ../
   ```

2. **Install Dependencies:**
   ```bash
   npm install
   ```

3. **Run the React Application:**
   ```bash
   npm start
   ```
   - The frontend will be available at `http://localhost:3000`.

---

### **3. API Endpoints**

#### **Authentication**

1. **Signup**
   - **Endpoint:** `POST /api/signup`
   - **Description:** Registers a new user.
   - **Request Body:**
     ```json
     {
       "name": "John Doe",
       "email": "johndoe@example.com",
       "password": "password123",
       "password_confirmation": "password123"
     }
     ```
   - **Response:**
     ```json
     {
       "status": true,
       "message": "User registered successfully.",
       "token": "auth_token_here"
     }
     ```

2. **Login**
   - **Endpoint:** `POST /api/login`
   - **Description:** Authenticates a user and provides a token.
   - **Request Body:**
     ```json
     {
       "email": "johndoe@example.com",
       "password": "password123"
     }
     ```
   - **Response:**
     ```json
     {
       "status": true,
       "message": "Login successful.",
       "token": "auth_token_here"
     }
     ```

#### **Books Management**

1. **Get All Books**
   - **Endpoint:** `GET /api/books`
   - **Description:** Retrieves a list of all books.
   - **Response:**
     ```json
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
     ```

2. **Get Filtered Books**
   - **Endpoint:** `GET /api/books?author={author}&genre={genre}&publication_year={year}`
   - **Description:** Retrieves books based on optional filters. You can filter by `author`, `genre`, or `publication_year` independently or in combination.
   - **Response:** Same as "Get All Books".

3. **Add a New Book**
   - **Endpoint:** `POST /api/books`
   - **Description:** Adds a new book to the collection.
   - **Request Body:**
     ```json
     {
       "title": "Book Title",
       "author": "Author Name",
       "publication_year": 2023,
       "genre": "Fiction",
       "image": "book_image.jpg"
     }
     ```
   - **Response:**
     ```json
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
     ```

4. **Update a Book**
   - **Endpoint:** `PUT /api/books/{id}`
   - **Description:** Updates details of an existing book.
   - **Request Body:** Same as "Add a New Book".
   - **Response:**
     ```json
     {
       "status": true,
       "message": "Book updated successfully."
     }
     ```

5. **Delete a Book**
   - **Endpoint:** `DELETE /api/books/{id}`
   - **Description:** Deletes a book from the collection.
   - **Response:**
     ```json
     {
       "status": true,
       "message": "Book deleted successfully."
     }
     ```

#### **Borrowing and Returning Books**

1. **Borrow a Book**
   - **Endpoint:** `POST /api/books/{id}/borrow`
   - **Description:** Marks a book as borrowed.
   - **Response:**
     ```json
     {
       "status": true,
       "message": "Book borrowed successfully."
     }
     ```

2. **Return a Book**
   - **Endpoint:** `POST /api/books/{id}/return`
   - **Description:** Marks a book as returned.
   - **Response:**
     ```json
     {
       "status": true,
       "message": "Book returned successfully."
     }
     ```

---

This documentation provides a comprehensive guide to setting up and running the application locally
