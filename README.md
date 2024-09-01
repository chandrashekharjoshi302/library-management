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

### 3. API Endpoints with Examples

**Base URL:** `http://localhost:8000/api`

1. **Get All Books**
   - **Endpoint:** `/books`
   - **Method:** `GET`
   - **Description:** Retrieves a list of all books.
   - **Example Response:**
     ```json
     [
       {
         "id": 1,
         "title": "Book Title",
         "author": "Author Name",
         "genre": "Genre",
         "publication_year": 2020,
         "is_borrowed": false,
         "image": "book_image.jpg"
       }
     ]
     ```

2. **Filter Books**
   - **Endpoint:** `/books`
   - **Method:** `GET`
   - **Parameters:**
     - `author` (optional)
     - `genre` (optional)
     - `publication_year` (optional)
   - **Description:** Retrieves books filtered by the provided parameters. If no parameters are passed, all books are returned.
   - **Example Request:** `GET /books?author=Author Name`
   - **Example Response:**
     ```json
     [
       {
         "id": 2,
         "title": "Another Book",
         "author": "Author Name",
         "genre": "Genre",
         "publication_year": 2019,
         "is_borrowed": false,
         "image": "another_book_image.jpg"
       }
     ]
     ```

3. **Add a Book**
   - **Endpoint:** `/books`
   - **Method:** `POST`
   - **Description:** Adds a new book to the collection.
   - **Request Body:**
     ```json
     {
       "title": "New Book",
       "author": "New Author",
       "genre": "New Genre",
       "publication_year": 2021,
       "image": "new_book_image.jpg"
     }
     ```
   - **Example Response:**
     ```json
     {
       "status": true,
       "message": "Book added successfully."
     }
     ```

4. **Update a Book**
   - **Endpoint:** `/books/{id}`
   - **Method:** `PUT`
   - **Description:** Updates an existing book.
   - **Request Body:** Similar to the Add a Book endpoint.
   - **Example Response:**
     ```json
     {
       "status": true,
       "message": "Book updated successfully."
     }
     ```

5. **Delete a Book**
   - **Endpoint:** `/books/{id}`
   - **Method:** `DELETE`
   - **Description:** Deletes a book from the collection.
   - **Example Response:**
     ```json
     {
       "status": true,
       "message": "Book deleted successfully."
     }
     ```

6. **Borrow a Book**
   - **Endpoint:** `/books/borrow/{id}`
   - **Method:** `POST`
   - **Description:** Marks a book as borrowed.
   - **Example Response:**
     ```json
     {
       "status": true,
       "message": "Book borrowed successfully."
     }
     ```

7. **Return a Book**
   - **Endpoint:** `/books/return/{id}`
   - **Method:** `POST`
   - **Description:** Marks a book as returned.
   - **Example Response:**
     ```json
     {
       "status": true,
       "message": "Book returned successfully."
     }
     ```

This documentation should help in understanding the project structure, setting up the environment, and using the API effectively.
