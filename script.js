document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('name_input_container').addEventListener('submit', submitName);
    document.getElementById('guess_input').addEventListener('submit', submitGuess);
    document.getElementById('play_again').addEventListener('click', playAgain);
});

function submitName(event) {
    event.preventDefault();
    const playerName = document.getElementById('player_name').value;
    fetch('game.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'start',
            player_name: playerName
        })
    }).then(response => response.json()).then(data => {
        if (data.status === 'started') {
            document.getElementById('name_input_container').style.display = 'none';
            document.getElementById('game').style.display = 'block';
        }
    });
}

function submitGuess(event) {
    event.preventDefault();
    const guess = document.getElementById('guess_input').value;
    fetch('game.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'guess',
            guess: guess
        })
    }).then(response => response.json()).then(data => {
        if (data.status === 'won') {
            alert('Congratulations! You won.');
            document.getElementById('play_again').style.display = 'block';
        } else if (data.status === 'continue') {
            updateGuessResult(data.result);
        }
    });
}

function playAgain() {
    fetch('game.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: 'play_again'
        })
    }).then(response => response.json()).then(data => {
        if (data.status === 'new_game') {
            document.getElementById('play_again').style.display = 'none';
            resetGameUI();
        }
    });
}

function updateGuessResult(result) {
    const guessContainer = document.getElementById('guess_container');
    const guessDivs = guessContainer.getElementsByClassName('guess');
    const currentGuessDiv = guessDivs[guessDivs.length - 1];

    const letterDivs = currentGuessDiv.getElementsByClassName('letter');
    for (let i = 0; i < letterDivs.length; i++) {
        letterDivs[i].classList.add(result[i]);
    }

    const newGuessDiv = document.createElement('div');
    newGuessDiv.classList.add('guess');
    for (let i = 0; i < 5; i++) {
        const newLetterDiv = document.createElement('div');
        newLetterDiv.classList.add('letter');
        newGuessDiv.appendChild(newLetterDiv);
    }
    guessContainer.appendChild(newGuessDiv);
}

function resetGameUI() {
    const guessContainer = document.getElementById('guess_container');
    while (guessContainer.firstChild) {
        guessContainer.removeChild(guessContainer.firstChild);
    }

    const newGuessDiv = document.createElement('div');
    newGuessDiv.classList.add('guess');
    for (let i = 0; i < 5; i++) {
        const newLetterDiv = document.createElement('div');
        newLetterDiv.classList.add('letter');
        newGuessDiv.appendChild(newLetterDiv);
    }
    guessContainer.appendChild(newGuessDiv);

    document.getElementById('guess_input').value = '';
}
