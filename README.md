# Rent N Repeat

Welcome to **Rent N Repeat**, a platform where users can rent clothes to and from each other with ease. This project focuses on creating a seamless experience for lessors and lessees, enabling users to manage their rentals efficiently while ensuring transparency and quality.

---

## **Features**

### **User Accounts**
- **Sign-Up & Sign-In**: Users can create accounts and log in securely.
- **Lessor Account**: Allows users to list clothes for rent and manage their inventory.
- **Lessee Account**: Enables users to browse, rent clothes, and leave reviews.

### **Product Management**
- Browse available clothes with images and descriptions.
- Search and filter options to sort by price, category, or rating.
- Add reviews and ratings for products.

### **Cart System**
- Add multiple products to the cart before checkout.
- Update or remove items from the cart.

### **Customer Support**
- Easy-to-access customer support for resolving issues.

### **Payment System**
- (Future Development): Integration with Stripe for secure payments.

### **Rating and Review System**
- Users can rate and review rented clothes to help others make informed decisions.

---

## **Technologies Used**

- **Frontend**: HTML, CSS
- **Backend**: PHP (with MySQLi for database interaction)
- **Database**: MySQL
- **Development Tools**: XAMPP, VSCode

---

## **Setup Instructions**

Follow these steps to set up the project on your local machine:

### **Prerequisites**
- Install [XAMPP](https://www.apachefriends.org/index.html) to run the PHP server and MySQL database.
- Install [VSCode](https://code.visualstudio.com/) or any preferred code editor.

### **Installation Steps**
1. Clone the repository:
   ```bash
   git clone https://github.com/fatin-israq/rent-n-repeat.git
   ```
2. Move the project folder to the `htdocs` directory of your XAMPP installation.
   ```bash
   cp -r rent-n-repeat /path/to/xampp/htdocs/
   ```
3. Start XAMPP and enable the **Apache** and **MySQL** modules.

4. Import the database:
   - Open `phpMyAdmin` in your browser (usually at `http://localhost/phpmyadmin`).
   - Create a new database named `rent_n_repeat`.
   - Import the `rent_n_repeat.sql` file located in the project directory.

5. Update database connection settings:
   - Open `config.php` in the project folder and update the database credentials:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "rent_n_repeat";
     ```

6. Open the project in your browser:
   - Visit `http://localhost/rent-n-repeat/`.

---

## **Usage**
- **For Lessors**:
  - Log in to your account.
  - List clothes for rent by providing details and images.
  - Manage your inventory.
- **For Lessees**:
  - Browse and search for clothes.
  - Add items to the cart and proceed to checkout.
  - Leave reviews for rented items.

---

## **Future Enhancements**
- Implement Stripe for payment processing.
- Add a notification system for rental updates.
- Enhance the UI/UX for a more seamless experience.
- Include an analytics dashboard for lessors.

---

## **Contributing**
Contributions are welcome! Follow these steps to contribute:
1. Fork the repository.
2. Create a new branch for your feature:
   ```bash
   git checkout -b feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m "Add feature-name"
   ```
4. Push your branch:
   ```bash
   git push origin feature-name
   ```
5. Open a pull request.

---

## **License**
This project is licensed under the [MIT License](LICENSE).

---

## **Contact**
For any inquiries or support, please reach out:
- **Email**: fatin.israqq2120@gmail.com
