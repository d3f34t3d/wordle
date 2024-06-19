# Design System Documentation

## Overview
This document describes the design and implementation of the Wordle game variant developed by Areeb Akazai & Aydin Yalcinkaya, including details on the JavaScript logic, HTML structure, and CSS styling.

## HTML Structure
- **Game Container**:
  - Contains all game elements, centrally positioned on the page.
  - Structured using `div` elements for the game board (`guess_container`) with individual `guess` rows, each containing five `letter` cells.
  - An `input-container` includes a text input field for guesses and a submit button.

- **Semantic HTML**:
  - The use of `<h1>`, `<h2>`, and `<p>` tags for game titles and instructions ensures the content is accessible and semantically organized.

## CSS Styling
- **Fonts**:
  - Uses Google's Roboto font for clean, modern typography.
  
- **Layout**:
  - Flexbox centers the `game-container` vertically and horizontally on the page.
  - The `guess_container` uses a CSS grid to align `letter` cells into rows, creating a structured layout for the game board.

- **Styling Details**:
  - Background colors differentiate game elements, with `whitesmoke` for the page and white for the game container.
  - The `letter` cells change color based on the game state (`correct`, `change`, `wrong`), using transitions for a smooth visual effect.
  - Buttons have a hover effect to improve user interaction.

## JavaScript Components
- **Word Selection**:
  - Selects a random word from an array (`wordList`) to start the game or after resetting the board.

- **Game Mechanics**:
  - Manages guess submissions, validating the format and length before processing.
  - Compares each submitted letter against the selected word, providing feedback via CSS classes that change the appearance of letter cells.

- **Scoring and Streaks**:
  - Tracks and updates the player's current and highest win streaks.
  - Displays win streaks dynamically in the game UI.

- **Game State Management**:
  - Functions like `resetBoard`, `gameWon`, and `gameLost` manage the game's state between rounds and sessions, resetting variables and UI elements accordingly.
