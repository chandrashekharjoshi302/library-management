import React, { useState } from "react";

const BorrowBook = () => {
  const [bookId, setBookId] = useState("");
  const [message, setMessage] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    const response = await fetch(
      `http://localhost:8000/api/books/${bookId}/borrow/`,
      {
        method: "POST",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );

    const data = await response.json();

    setMessage(data.message);
  };

  return (
    <div className="container">
      <h2>Borrow Book</h2>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          value={bookId}
          onChange={(e) => setBookId(e.target.value)}
          placeholder="Book ID"
          required
        />
        <button type="submit">Borrow</button>
        {message && <p>{message}</p>}
      </form>
    </div>
  );
};

export default BorrowBook;
