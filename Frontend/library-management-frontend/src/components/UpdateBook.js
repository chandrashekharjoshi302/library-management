import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";

const UpdateBook = () => {
  const [title, setTitle] = useState("");
  const [author, setAuthor] = useState("");
  const [publicationYear, setPublicationYear] = useState("");
  const [genre, setGenre] = useState("");
  const [image, setImage] = useState(null);
  const [error, setError] = useState("");
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    const fetchBook = async () => {
      const response = await fetch(`http://localhost:8000/api/books/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      const data = await response.json();
      if (data.status) {
        setTitle(data.data.title);
        setAuthor(data.data.author);
        setPublicationYear(data.data.publication_year);
        setGenre(data.data.genre);
        // No need to set image as it's a file
      } else {
        setError(data.message);
      }
    };
    fetchBook();
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("title", title);
    formData.append("author", author);
    formData.append("publication_year", publicationYear);
    formData.append("genre", genre);
    if (image) {
      formData.append("image", image);
    }

    const response = await fetch(`http://localhost:8000/api/books/${id}`, {
      method: "PUT",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      body: formData,
    });

    const data = await response.json();

    if (data.status) {
      navigate("/books");
    } else {
      setError(data.message);
    }
  };

  return (
    <div className="container">
      <h2>Update Book</h2>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          placeholder="Title"
          required
        />
        <input
          type="text"
          value={author}
          onChange={(e) => setAuthor(e.target.value)}
          placeholder="Author"
          required
        />
        <input
          type="number"
          value={publicationYear}
          onChange={(e) => setPublicationYear(e.target.value)}
          placeholder="Publication Year"
          required
        />
        <input
          type="text"
          value={genre}
          onChange={(e) => setGenre(e.target.value)}
          placeholder="Genre"
          required
        />
        <input type="file" onChange={(e) => setImage(e.target.files[0])} />
        <button type="submit">Update Book</button>
        {error && <p className="error">{error}</p>}
      </form>
    </div>
  );
};

export default UpdateBook;
