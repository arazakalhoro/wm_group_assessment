## WM Group Assigment - User authentication and authorization

This application provides a user management system with role-based access control, featuring two types of users:
Administrators and Users.

A User can perform the following actions:
- View and update their own profile information
- Change their password

An Administrator has elevated privileges and can perform the following actions:
- Register new users
- Edit existing user information
- Disable or delete user accounts
- Manage user profiles and passwords

###### Note: Disabled user functionality is not covered in this version

The application ensures that users can only access features and perform actions that are authorized for their role, providing a secure and controlled environment for user management.


### Prerequisites
- PHP 8.2^
- MySQL 8.3.*
- Composer
- PHP Extensions:
    - pdo
    - mbstring
    - gd
    - curl
    - openssl
    - xml
- Install ChromeDriver and add it to your system's PATH.

### Installation

To install the project, Clone the repository or download the project template. And run following commands:

1. Clone the repository:
   ```bash
   git clone https://github.com/arazakalhoro/wm_group_assessment.git
2. Composer Installation
   ```
   cd APPLICATION_ROOT/
   composer install
   php yii migrate
   composer dump-autoload
3. Assign .env variables for application usage
4. Running Tests
   ```
   # Prefered before running othere acceptance tests
   php vendor/bin/codecept run migrations
   php vendor/bin/codecept run acceptance
