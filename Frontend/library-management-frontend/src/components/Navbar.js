import React from "react";
import { Link, useNavigate } from "react-router-dom";

const Navbar = () => {
  const navigate = useNavigate();

  const handleLogout = () => {
    localStorage.removeItem("token");
    navigate("/login"); // Redirect to login page after logout
  };

  const isLoggedIn = !!localStorage.getItem("token");

  return (
    <div className="navbar">
      <div>
        <Link to="/">Home</Link>
        <Link to="/add-book">Add Book</Link>
        <Link to="/borrow-book">Borrow Book</Link>
        <Link to="/return-book">Return Book</Link>

        {!isLoggedIn && <Link to="/login">Login</Link>}
      </div>
      {isLoggedIn && <button onClick={handleLogout}>Logout</button>}
    </div>
  );
};

export default Navbar;
