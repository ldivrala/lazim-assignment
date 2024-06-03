# Lazim Task Assignment Setup Instructions

Project Link: [https://github.com/ldivrala/lazim-assignment](https://github.com/ldivrala/lazim-assignment)

## Setup Steps

1. **Clone the Project**
   ```bash
   git clone https://github.com/ldivrala/lazim-assignment
   ```

2. **Install Dependencies**
   ```bash
   composer update
   ```

3. **Update Database Configuration**
   Modify the `.env` file with your database settings.

4. **Set Storage Folder Permissions**
   ```bash
   chmod -R 775 storage
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Run the Project**
   ```bash
   php artisan serve
   ```

Visit the provided local URL to review the project.
