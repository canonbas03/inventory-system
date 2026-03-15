# Warehouse Inventory Management System

A **web-based inventory management system** designed to efficiently track products, suppliers, and stock levels. Built with PHP, MySQL, JavaScript, AJAX, and jQuery, this project demonstrates full-stack web development, secure backend logic, and dynamic data handling.

![Dashboard Screenshot](https://github.com/user-attachments/assets/dfbcdacb-c901-467d-a3ab-bd9e77b09dff)

---

## Features

- **Product Management** – Add, edit, and remove products with validation to prevent duplicate SKUs.  
- **Supplier & Category Management** – Organize products by suppliers and categories.  
- **Stock Tracking & Audit Logging** – Track quantity changes, user actions, and historical stock movements.  
- **REST-style API Endpoints** – AJAX-based dynamic filtering, searching, and real-time updates without page reloads.  
- **Secure Backend** – Prepared statements, server-side validation, and role-based access ensure data integrity.  
- **Responsive UI** – Clean, mobile-friendly interface for easy navigation.
- **CSV Export** – Export product lists and stock movements to CSV for reporting and analysis.

---

## Technologies Used

- **Backend:** PHP, MySQL, AJAX, jQuery  
- **Frontend:** HTML, CSS, JavaScript  
- **Database:** Relational MySQL with normalized tables for products, categories, suppliers, and stock movements  
- **Version Control & Collaboration:** Git/GitHub  

---

## Installation & Setup

1. Clone the repository:  
   ```bash
   git clone https://github.com/canonbas03/inventory-system.git
   ```
2. Import the database from database.sql into your local MySQL server.

3. Configure the database connection in includes/db.php.

4. Start your local PHP server (XAMPP, WAMP, or similar).

5. Navigate to http://localhost/inventory-system in your browser

---

## Screenshots

Dashboard:
<img width="1920" height="1200" alt="Image" src="https://github.com/user-attachments/assets/dfbcdacb-c901-467d-a3ab-bd9e77b09dff" />

Product List & Filtering:
<img width="1920" height="1200" alt="Image" src="https://github.com/user-attachments/assets/d1b00b7c-269e-4c01-b36c-65afcb0c0395" />

Stock Movement Audit Log:
<img width="1920" height="1200" alt="Image" src="https://github.com/user-attachments/assets/5f520573-c384-4ee9-a3df-50f6121aa232" />

**Add Product Page:**  
![Add Product Page](https://github.com/user-attachments/assets/3ae1bd8b-079e-4d77-a7db-c56715554cd3)

## Key Highlights

- Implements REST-style API endpoints for seamless dynamic data operations.

- Tracks stock movements to maintain a complete audit trail.

- Uses AJAX and jQuery to update tables in real time without page reloads.

- Demonstrates strong full-stack skills in PHP, MySQL, JavaScript, and frontend design.
