# Chat Application Backend

This is a simple chat application backend written in PHP using the Slim framework and SQLite database.

## Features

- Users can create chat groups, join groups, and send messages within groups.
- Groups are public; any user can join any group.
- Users are identified by their user ID.
- Messages are stored in a SQLite database.
- Communication between the client and server happens over a RESTful JSON API over HTTP(s).

## Prerequisites

- PHP (7.4 or higher)
- Composer (for installing dependencies)
- SQLite

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/chat-app-backend.git
   cd chat-app-backend
   
2. Install the dependencies:
   ```bash
   composer install
   
3.Set up the database schema:

Open the chat.db file using an SQLite client or command-line tool and run the SQL commands from the schema section in the index.php file to create the necessary tables.

## Usage

### Create a New Group

- Method: POST
- URL: `http://localhost:8000/groups`
- Body: `{ "name": "Group Name" }`

### Get All Groups

- Method: GET
- URL: `http://localhost:8000/groups`

### Get Messages for a Group

- Method: GET
- URL: `http://localhost:8000/groups/{group_id}/messages`

### Send a Message to a Group

- Method: POST
- URL: `http://localhost:8000/groups/{group_id}/messages`
- Body: `{ "user_id": 1, "message": "Hello, world!" }`

Replace `{group_id}` in the URLs with the actual group ID.

## Contributing

Contributions are welcome! If you find any issues or have improvements to suggest, please create an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
