# Design System Documentation

## Overview
This document details the design and implementation of the Wordle game variant developed by Areeb Akazai & Aydin Yalcinkaya. It covers the JavaScript logic, HTML structure, CSS styling, and the PHP backend handling game logic and session management.

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
  - Randomly selects a word from an array (`wordList`) at the start of the game or upon resetting.

- **Game Mechanics**:
  - Manages and validates guess submissions for correct format and length.
  - Compares each submitted letter against the selected word, providing feedback through CSS classes that alter the appearance of the letter cells.

- **Scoring and Streaks**:
  - Monitors and updates the player's current and highest win streaks, displaying these dynamically within the game UI.

- **Game State Management**:
  - Utilizes functions such as `resetBoard`, `gameWon`, and `gameLost` to control the game's state across rounds and sessions, effectively resetting variables and UI elements.

## PHP Backend
- **Session Management**:
  - Utilizes PHP sessions to maintain game state across multiple requests, preserving player progress and settings without the need for constant server communication.

- **Leaderboard Implementation**:
  - Manages a leaderboard stored in a JSON file (`leaderboard.json`), handling file reads and writes to update and retrieve player rankings based on win streaks.

- **Game Logic**:
  - Processes guesses and updates the game state, checking win conditions, updating streaks, and managing the end of game scenarios through server-side scripting.

- **Security and Validation**:
  - Ensures robust input validation to prevent common security vulnerabilities such as injection attacks, maintaining the integrity of game operations and user interactions.

This design system is structured to provide a comprehensive understanding of the game's development and operational logic, ensuring maintainability and scalability.
