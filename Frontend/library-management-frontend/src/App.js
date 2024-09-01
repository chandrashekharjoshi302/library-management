import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import Login from "./components/Login";
import Signup from "./components/Signup";
import AddBook from "./components/AddBook";
import UpdateBook from "./components/UpdateBook";
import BookList from "./components/BookList";
import BorrowBook from "./components/BorrowBook";
import ReturnBook from "./components/ReturnBook";
import "./styles.css";

function App() {
  return (
    <Router>
      <Navbar />
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/signup" element={<Signup />} />
        <Route path="/add-book" element={<AddBook />} />
        <Route path="/update-book/:id" element={<UpdateBook />} />
        <Route path="/books" element={<BookList />} />
        <Route path="/borrow-book" element={<BorrowBook />} />
        <Route path="/return-book" element={<ReturnBook />} />
        <Route path="/" element={<BookList />} />
      </Routes>
    </Router>
  );
}

export default App;
