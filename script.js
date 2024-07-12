document.addEventListener('DOMContentLoaded', (event) => {
    fetch('game.php')
        .then(response => response.json())
        .then(data => {
            if (data.playerName) {
                document.getElementById('name_input_container').style.display = 'none';
                document.getElementById('game').style.display = 'block';
                updateGameUI(data);
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
        .then(data => updateGameUI(data))
        .catch(error => console.error('Error submitting guess:', error));
}

function updateGameUI(data) {
    if (data.error) {
        alert(data.error);
        return;
    }

    const guessContainer = document.getElementById('guess_container');
    guessContainer.innerHTML = '';

    data.guesses.forEach((guess, index) => {
        const guessDiv = document.createElement('div');
        guessDiv.classList.add('guess');
        
        for (let i = 0; i < 5; i++) {
            const letterDiv = document.createElement('div');
            letterDiv.classList.add('letter');
            letterDiv.innerHTML = guess[i];

            if (guess[i] === data.word[i]) {
                letterDiv.classList.add('correct');
            } else if (data.word.includes(guess[i])) {
                letterDiv.classList.add('change');
            } else {
                letterDiv.classList.add('wrong');
            }

            guessDiv.appendChild(letterDiv);
        }

        guessContainer.appendChild(guessDiv);
    });

    document.getElementById('current_win_streak').innerHTML = `Current Win Streak: ${data.currentWinStreak}`;
    document.getElementById('highest_win_streak').innerHTML = `Highest Win Streak: ${data.highestWinStreak}`;
    document.getElementById('guess_input').value = '';
}
