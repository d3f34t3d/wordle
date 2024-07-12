document.addEventListener('DOMContentLoaded', (event) => {
    // Check if player name is already set
    fetch('game.php')
        .then(response => response.json())
        .then(data => {
            if (data.playerName) {
                document.getElementById('name_input_container').style.display = 'none';
                document.getElementById('game').style.display = 'block';
                updateGameUI(data);
                // Update button states based on game state
                updateButtonState(data.gameOver);
            }
        })
        .catch(error => console.error('Error fetching game state:', error));
});

function submitName() {
    let playerName = document.getElementById('player_name').value.trim();
    
    if (playerName === '') {
        alert('Please enter your name.');
        return;
    }

    fetch('game.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `playerName=${playerName}`
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('name_input_container').style.display = 'none';
        document.getElementById('game').style.display = 'block';
        updateGameUI(data);
        updateButtonState(data.gameOver);
    })
    .catch(error => console.error('Error submitting player name:', error));
}

function submitGuess() {
    let input = document.getElementById('guess_input').value;

    if (input.length != 5) {
        alert("Guesses can only be 5 characters long");
        return;
    }

    if (!/^[a-zA-Z]+$/.test(input)) {
        alert("Guesses can only contain letters");
        return;
    }

    fetch('game.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `guess=${input}`
    })
        .then(response => response.json())
        .then(data => {
            updateGameUI(data);
            updateButtonState(data.gameOver);
        })
        .catch(error => console.error('Error submitting guess:', error));
}

function playAgain() {
    fetch('game.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'playAgain=true'
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('play_again').style.display = 'none';
        updateGameUI(data);
        updateButtonState(data.gameOver);
    })
    .catch(error => console.error('Error starting new game:', error));
}

function updateGameUI(data) {
    if (data.error) {
        alert(data.error);
        return;
    }

    const guessContainer = document.getElementById('guess_container');
    const guessRows = guessContainer.getElementsByClassName('guess');
    for (let i = 0; i < guessRows.length; i++) {
        const guessDiv = guessRows[i];
        const letters = guessDiv.getElementsByClassName('letter');

        if (data.guesses[i]) {
            const guess = data.guesses[i];
            for (let j = 0; j < letters.length; j++) {
                letters[j].innerHTML = guess[j];
                if (guess[j] === data.word[j]) {
                    letters[j].classList.add('correct');
                } else if (data.word.includes(guess[j])) {
                    letters[j].classList.add('change');
                } else {
                    letters[j].classList.add('wrong');
                }
            }
        } else {
            for (let j = 0; j < letters.length; j++) {
                letters[j].innerHTML = '';
                letters[j].classList.remove('correct', 'change', 'wrong');
            }
        }
    }

    document.getElementById('current_win_streak').innerHTML = `Current Win Streak: ${data.currentWinStreak}`;
    document.getElementById('highest_win_streak').innerHTML = `Highest Win Streak: ${data.highestWinStreak}`;
    document.getElementById('guess_input').value = '';
}

function updateButtonState(gameOver) {
    const guessButton = document.querySelector('#guess_input + .submit-button');
    const playAgainButton = document.getElementById('play_again');

    if (gameOver) {
        playAgainButton.style.display = 'block';
        guessButton.disabled = true;
    } else {
        playAgainButton.style.display = 'none';
        guessButton.disabled = false;
    }
}
