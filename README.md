# Domain Registration and Management System

This project is a simple PHP application to manage domain registrations. It fetches WHOIS data for a given domain and stores relevant information in a database.

## Features

- Fetches domain information using the WHOIS API
- Stores domain registration, update, and expiry dates in a database
- Calculates and displays the number of days remaining until the domain expires
- User-friendly interface for viewing and managing domain records

## Requirements

- PHP 7.x or higher
- cURL extension enabled
- A MySQL database
- WHOIS API key

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/uydevops/domain-registration-system.git](https://github.com/uydevops/DomainSorgulama)
    cd domain-DomainSorgulama
    ```

2. **Configure the database:**

    Create a MySQL database and import the provided `schema.sql` file to set up the necessary tables.

3. **Update the database connection:**

    Edit the `db.php` file to add your database connection details:

    ```php
    <?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=your_database_name;charset=utf8', 'your_username', 'your_password');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    ?>
    ```

4. **Update the WHOIS API key:**

    Replace the placeholder API key in your main script with your actual WHOIS API key:

    ```php
    $apikey = "your_actual_api_key";
    ```

## Usage

1. **Run the application:**

    Make sure your web server is running and navigate to the project directory.

2. **Add a new domain:**

    Click on the "Yeni Veri Ekle" button and fill in the domain name and company name. Submit the form to fetch and store the domain information.

3. **View domain records:**

    The main table displays all stored domain records with their respective registration, update, and expiry dates, along with the number of days remaining until expiry.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes. Ensure your code follows the existing coding style and includes appropriate tests.

## License

This project is open-source and available under the MIT License. See the [LICENSE](LICENSE) file for more information.

## Contact

For any questions or suggestions, feel free to reach out to me on [GitHub](https://github.com/uydevops).

---

Thank you for checking out this project! Your contributions and feedback are highly appreciated.
