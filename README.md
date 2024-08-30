Here's a complete README file incorporating all the updated details:

---

# KilimoForum

KilimoForum is an online platform designed to connect customers, farmers, and sellers of agricultural tools. This project is set up to run locally using XAMPP.

## Prerequisites

Before you begin, ensure you have the following installed on your local machine:

- **XAMPP**: A local server environment that includes Apache and MySQL. You can download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/index.html).

## Getting Started

To set up and run KilimoForum locally, follow these steps:

### Clone the Repository

First, clone the repository from GitHub:

```bash
git clone https://github.com/mumumpepe/KilimoForum.git
cd KilimoForum
```

### Set Up the Environment

1. **Move the Database Folder**:
   - Copy the `database` folder into the `htdocs` directory of your XAMPP installation. For example, if XAMPP is installed in `C:\xampp`, place the `database` folder in `C:\xampp\htdocs\KilimoForum\database`.

2. **Configure XAMPP**:
   - Open the XAMPP Control Panel and start the Apache and MySQL services.

3. **Update the `.env` File**:
   - In the root directory of your project, create a copy of the `.env.example` file and rename it to `.env`.
   - Open the `.env` file and configure the database settings to match your local setup. An example configuration is as follows:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kilimo_forum
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run Migrations**:
   - Open a terminal or command prompt in the project directory and run the following command to set up the database schema:

   ```bash
   php artisan migrate
   ```

### Access the Application

Once the setup is complete, open your web browser and navigate to `http://localhost/KilimoForum/public` to view and interact with the KilimoForum application.

### User Credentials

For testing purposes, you can use the following credentials:

- **Farmer**:
  - Username: `farmer`
  - Password: `MUMUMPEPE`
  
- **Seller**:
  - Username: `seller`
  - Password: `MUMUMPEPE`
  
- **Customer**:
  - Username: `mumumpepe`
  - Password: `MUMUMPEPE`
  
- **Administrator**:
  - Username: `secretadminmumumpepe`
  - Password: `MUMUMPEPE`

## Contributing

If you wish to contribute to KilimoForum, please fork the repository and submit a pull request with your changes. For detailed guidelines on contributing, please refer to the `CONTRIBUTING.md` file in the repository.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

---

Feel free to adjust or expand upon any sections based on your specific needs or additional details you might want to include!
