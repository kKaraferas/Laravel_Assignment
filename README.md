<h1>Video Game Management System API</h1>

<h3>Overview</h3>

This is a RESTful API for managing video games, including user authentication, role-based permissions, game management, and user reviews.

<h3>Features</h3>
<ul>
    <li>User authentication (registration, login, JWT authentication)</li>
    <li>Role-based access control (Admin, Regular User)</li>
    <li>CRUD operations for video games</li>
    <li>Only Admin users can delete games added by other users</li>
    <li>Users can rate and review games</li>
</ul>


<h3>Installation</h3>

<h4>Prerequisites</h4>

Ensure you have the following installed:
<ul>
    <li>PHP 8.1+</li>
    <li>Composer 2.6+</li>
    <li>Laravel 10.2+</li>
    <li>MySQL (or any database supported by Laravel)</li>
    <li>XAMPP (optional, for local MySQL database)</li>
    <li>DBeaver (optional, for database management)</li>
</ul>

<h4>Setup Instructions</h4>
<ol>
    <li>Clone the repository: 
        <ul>
            <li>git clone <repository-url></li>
            <li>cd game_management</li>
        </ul>
    </li>
    <li>Install dependencies:
        <ul>
            <li>composer install</li>
        </ul>
    </li>
    <li>Create a .env file:
        <ul>
            <li>cp .env.example .env</li>
        </ul>
    </li>
    <li>Configure database settings in .env:
        <ul>
            <li>DB_CONNECTION=mysql</li>
            <li>DB_HOST=127.0.0.1</li>
            <li>DB_PORT=3306</li>
            <li>DB_DATABASE=game_management</li>
            <li>DB_USERNAME=root</li>
            <li>DB_PASSWORD=</li>
        </ul>
    </li>
    <li>Generate application key:
        <ul>
            <li>php artisan key:generate</li>
        </ul>
    </li>
    <li>Run migrations and seed the database:
        <ul>
            <li>php artisan migrate --seed</li>
        </ul>
    </li>
    <li>Start the Laravel development server:
        <ul>
            <li>php artisan serve</li>
        </ul>
    </li>
</ol>

<h3>API Endpoints</h3>

<h4>Authentication</h4>
<ul>
    <li>POST /api/register - Register a new user</li>
    <li>POST /api/login - Authenticate and get a token</li>
</ul>

<h4>Video Game Management</h4>
<ul>
    <li>GET /api/games - List all games</li>
    <li>POST /api/games - Add a new game (authenticated users)</li>
    <li>PUT /api/games/{id} - Update game details (only owner/admin)</li>
    <li>DELETE /api/games/{id} - Delete a game (only admin)</li>
</ul>

<h4>User Reviews</h4>
<ul>
    <li>POST /api/games/{id}/review - Add a review (authenticated users)</li>
    <li>GET /api/games/{id}/reviews - Get all reviews for a game</li>
</ul>

<h4>Roles & Permissions</h4>
<ul>
    <li>Admin: Full control over games and reviews</li>
    <li>Regular User: Can add/edit their own games and leave reviews</li>
</ul>

<h4>Testing</h4>

Run tests with:

<ul>
    <li>php artisan test</li>
</ul>

<h4>License</h4>

This project is licensed under the MIT License.

<h4>Author</h4>

Konstantinos Karaferas
