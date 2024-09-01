import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import "./BookList.css"; // Ensure this CSS file is included

const BookList = () => {
  const [books, setBooks] = useState([]);
  const [author, setAuthor] = useState("");
  const [genre, setGenre] = useState("");
  const [publicationYear, setPublicationYear] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  const fetchBooks = async () => {
    setLoading(true);
    setError("");

    // Construct query string dynamically
    const params = new URLSearchParams();
    if (author) params.append("author", author);
    if (genre) params.append("genre", genre);
    if (publicationYear) params.append("publication_year", publicationYear);

    const queryString = params.toString();
    const url = queryString
      ? `http://localhost:8000/api/books?${queryString}`
      : "http://localhost:8000/api/books";

    try {
      const response = await fetch(url, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });

      const data = await response.json();
      if (data.status) {
        setBooks(data.data);
      } else {
        setError(data.message || "Failed to fetch books.");
      }
    } catch (err) {
      setError("An error occurred while fetching books.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchBooks();
  }, [author, genre, publicationYear]);

  return (
    <div className="book-list-container">
      <h2 className="header">Books List</h2>
      <form
        className="filter-form"
        onSubmit={(e) => {
          e.preventDefault();
          fetchBooks();
        }}
      >
        <input
          type="text"
          value={author}
          onChange={(e) => setAuthor(e.target.value)}
          placeholder="Filter by Author"
          className="filter-input"
        />
        <input
          type="text"
          value={genre}
          onChange={(e) => setGenre(e.target.value)}
          placeholder="Filter by Genre"
          className="filter-input"
        />
        <input
          type="number"
          value={publicationYear}
          onChange={(e) => setPublicationYear(e.target.value)}
          placeholder="Filter by Publication Year"
          className="filter-input"
        />
        <button type="submit" className="filter-button">
          Filter
        </button>
      </form>

      {loading && <p className="loading">Loading...</p>}
      {error && <p className="error">{error}</p>}

      <ul className="book-list">
        {books.map((book) => (
          <li key={book.id} className="book-item">
            <h3 className="book-title">{book.title}</h3>
            <p className="book-detail">
              <strong>Book ID:</strong> {book.id}
            </p>
            <p className="book-detail">
              <strong>Author:</strong> {book.author}
            </p>
            <p className="book-detail">
              <strong>Publication Year:</strong> {book.publication_year}
            </p>
            <p className="book-detail">
              <strong>Genre:</strong> {book.genre}
            </p>
            <p className="book-detail">
              <strong>Borrowed:</strong> {book.is_borrowed ? "Yes" : "No"}
            </p>
            {book.image && (
              <img
                src={`http://localhost:8000/uploads/${book.image}`}
                alt={book.title}
                className="book-image"
              />
            )}
            <div className="book-actions">
              <Link to={`/update-book/${book.id}`} className="update-link">
                Update
              </Link>
              <button
                onClick={async () => {
                  await fetch(`http://localhost:8000/api/books/${book.id}`, {
                    method: "DELETE",
                    headers: {
                      Authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                  });
                  fetchBooks();
                }}
                className="delete-button"
              >
                Delete
              </button>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default BookList;
