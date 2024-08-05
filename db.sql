CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    win_streak INT DEFAULT 0
);

CREATE TABLE sessions (
    id SERIAL PRIMARY KEY,
    session_id VARCHAR(255) UNIQUE NOT NULL,
    user_id INT REFERENCES users(id),
    session_data TEXT,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE words (
    id SERIAL PRIMARY KEY,
    word VARCHAR(5) NOT NULL
);

