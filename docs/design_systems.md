# Design System Documentation

## Overview
This document describes the design and implementation of the Wordle game variant developed by Areeb Akazai & Aydin Yalcinkaya. It covers JavaScript logic, HTML structure, CSS styling, and the integration of a PHP backend with a database for managing game logic and player data.

## HTML Structure
- **Game Container**:
  - Central hub containing all game elements, structured for central visibility on the page.
  - Utilizes `div` elements to organize the game board (`guess_container`) with rows of `guesses` consisting of five `letter` cells each.
  - The `input-container` includes an input field for player guesses and a submit button to process the input.

- **Semantic HTML**:
  - Employs `<h1>`, `<h2>`, and `<p>` tags for game titles and instructions, ensuring content is accessible and well-organized.

## CSS Styling
- **Fonts**:
  - Incorporates Google's Roboto font for a clean, modern look.
  
- **Layout**:
  - Uses Flexbox to center the `game-container` both vertically and horizontally.
  - Implements a CSS grid in the `guess_container` to align `letter` cells neatly into rows, forming the structured layout of the game board.

- **Styling Details**:
  - Distinguishes game elements with background colors, using `whitesmoke` for the page background and white for the game container.
  - `letter` cells change colors based on game state (`correct`, `change`, `wrong`), with smooth transitions for visual effects.
  - Enhances user interaction with buttons that display a hover effect.

## JavaScript Components
- **Word Selection**:
  - Randomly selects a word from a server-managed list stored in a database at the start of the game or upon resetting.

- **Game Mechanics**:
  - Manages and validates guess submissions for correct format and length.
  - Compares each submitted letter against the selected word, providing feedback through CSS classes that alter the appearance of the letter cells.

- **Scoring and Streaks**:
  - Monitors and updates the player's current and highest win streaks, displaying these dynamically within the game UI.

- **Game State Management**:
  - Utilizes functions such as `resetBoard`, `gameWon`, and `gameLost` to control the game's state across rounds and sessions, effectively resetting variables and UI elements.

## PHP Backend and Database Integration
- **Database Setup**:
  - Replaces PHP session storage with a PostgreSQL database to manage user data, game sessions, and words.
  - Utilizes tables `users`, `sessions`, and `words` to store and manage game data efficiently.

- **Session Management**:
  - Maintains game state using database entries, providing robust data persistence across multiple requests.

- **Leaderboard Implementation**:
  - Retrieves and updates player rankings directly from the database, facilitating real-time leaderboard updates.

- **Game Logic**:
  - Handles guess processing and game state updates server-side, ensuring secure and consistent game operations.

- **Security and Validation**:
  - Implements enhanced security measures including input validation and database interaction checks to prevent SQL injection and other common vulnerabilities.

This documentation reflects the transition of the worlde game to a database-driven architecture, whilst providing detailed insights into the game's development and operational logic for maintainability and scalability.
