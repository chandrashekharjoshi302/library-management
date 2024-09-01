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
      try {
        const response = await fetch(`http://localhost:8000/api/books/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });

        if (!response.ok) {
          throw new Error("Network response was not ok.");
        }

        const data = await response.json();
        if (data.status) {
          setTitle(data.data.title);
          setAuthor(data.data.author);
          setPublicationYear(data.data.publication_year);
          setGenre(data.data.genre);
        } else {
          setError(data.message);
        }
      } catch (err) {
        console.error("Failed to fetch book details:", err);
        setError("Failed to fetch book details.");
      }
    };

    fetchBook();
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Prepare book data as JSON
    const bookData = {
      title,
      author,
      publication_year: publicationYear,
      genre,
    };

    try {
      // Update book data
      const response = await fetch(`http://localhost:8000/api/books/${id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        body: JSON.stringify(bookData),
      });

      if (!response.ok) {
        throw new Error("Network response was not ok.");
      }

      const data = await response.json();

      if (data.status) {
        // Handle image upload if there is an image
        if (image) {
          const imageData = new FormData();
          imageData.append("image", image);

          const imageResponse = await fetch(
            `http://localhost:8000/api/books/${id}/upload-image`,
            {
              method: "POST",
              headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
              },
              body: imageData,
            }
          );

          if (!imageResponse.ok) {
            throw new Error("Failed to upload image.");
          }
        }

        navigate("/books");
      } else {
        setError(data.message);
      }
    } catch (err) {
      console.error("Failed to update book:", err);
      setError("Failed to update book.");
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
