<?php
session_start();

if (!isset($_SESSION['game_state'])) {
    $_SESSION['game_state'] = [
        'playerName' => '',
        'word' => '',
        'guessCount' => 0,
        'currentWinStreak' => 0,
        'highestWinStreak' => 0,
        'guesses' => [],
        'gameOver' => false
    ];
}

$wordList = ["APPLE", "HOUSE", "BOARD", "TRAIN", "PLANT"]; // add your word list

function resetGame() {
    global $wordList;
    $_SESSION['game_state']['word'] = $wordList[array_rand($wordList)];
    $_SESSION['game_state']['guessCount'] = 0;
    $_SESSION['game_state']['guesses'] = [];
    $_SESSION['game_state']['gameOver'] = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['playerName'])) {
        $_SESSION['game_state']['playerName'] = trim($_POST['playerName']);
        resetGame();
        echo json_encode($_SESSION['game_state']);
        exit;
    }

    if (isset($_POST['playAgain'])) {
        resetGame();
        echo json_encode($_SESSION['game_state']);
        exit;
    }

    $input = strtoupper(trim($_POST['guess']));

    if (strlen($input) != 5 || !ctype_alpha($input) || !in_array($input, $wordList)) {
        echo json_encode(['error' => 'Invalid guess']);
        exit;
    }

    $_SESSION['game_state']['guesses'][] = $input;
    $_SESSION['game_state']['guessCount']++;

    $word = $_SESSION['game_state']['word'];
    if ($input === $word) {
        $_SESSION['game_state']['currentWinStreak']++;
        if ($_SESSION['game_state']['currentWinStreak'] > $_SESSION['game_state']['highestWinStreak']) {
            $_SESSION['game_state']['highestWinStreak'] = $_SESSION['game_state']['currentWinStreak'];
        }
        $_SESSION['game_state']['gameOver'] = true;
    } elseif ($_SESSION['game_state']['guessCount'] >= 6) {
        $_SESSION['game_state']['currentWinStreak'] = 0;
        $_SESSION['game_state']['gameOver'] = true;
    }

    echo json_encode($_SESSION['game_state']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (empty($_SESSION['game_state']['word'])) {
        resetGame();
    }
    echo json_encode($_SESSION['game_state']);
    exit;
}
?>
