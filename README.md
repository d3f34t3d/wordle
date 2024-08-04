# Wordle Game - PHP Enhanced with Database Support
### CSI3140 A4

## Overview
This enhanced version of the classic Wordle game now incorporates a backend sql database to manage game state and player scores more effectively, moving away from PHP session storage.

## How to Play
- Download or clone the repository.
- Ensure your PHP server environment (like XAMPP or WAMP) supports PostgreSQL or MySQL.
- Import the `db.sql` file to set up the database.
- Run the project on a server with PHP and database support.
- Open the provided HTML file in a browser to start the game.
- Enter your guesses to try and match the word selected by the server.

## Features
- **Database-Driven State Management**: Uses a relational database to store user data, game sessions, and words for gameplay.
- **JSON API Interaction**: Frontend makes AJAX calls to the backend, allowing for a clear separation of concerns.
- **Dynamic Leaderboard**: Utilizes database queries to retrieve and display top player scores.
- **Secure and Validated Inputs**: Extends validation to ensure safe and correct user inputs, enhancing security against web vulnerabilities.

## Screenshots
- **Game Start**: ![Game Start](docs/game_start.png)
- **Mid Game**: ![Mid Game](docs/mid_game.png)
- **Game Win**: ![Game Win](docs/game_win.png)
- **Game Win Play Again**: ![Game Win](docs/game_win_restart.png)
- **Game Lose**: ![Game Lose](docs/game_lose.png)

## Setup
Steps to set up and run the game:
1. Set up a PHP server environment with database support.
2. Import the database schema from `db.sql`.
3. Place the game files in your server's document root.
4. Access the game through your browser at the URL like `http://localhost/path/to/game`.

## Credits
Developed by Areeb Akazai & Aydin Yalcinkaya as part of CSI 3140 A3.