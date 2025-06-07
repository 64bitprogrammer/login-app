# Login-App - Innovins 

1. Signup Page
    - Name, Email & Password

2. Login Page
    - Session Management

3. Forgot Password Page
    - Default OTP 1111

4. Users Page
    - Users crud operations, add , delete, edit

5. Products Page
    - Crud operations as per table columns, add edit delete

6. Crud api for products
    - Fetch all items
    - add item
    - delete item
    - update item

=====================================================

Table List

CREATE TABLE users (

        id INT AUTO_INCREMENT PRIMARY KEY,

        name VARCHAR(255) NOT NULL,

        email VARCHAR(255) NOT NULL UNIQUE,

        password  VARCHAR(255) NOT NULL UNIQUE,

        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    );


    CREATE TABLE products (

        id INT AUTO_INCREMENT PRIMARY KEY,

        name VARCHAR(255) NOT NULL,

        description  VARCHAR(255) NOT NULL,

        price  int(100) NOT NULL,

        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    );