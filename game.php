<?php
session_start();

define('LEADERBOARD_FILE', 'leaderboard.json');

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

function readLeaderboard() {
    if (!file_exists(LEADERBOARD_FILE)) {
        file_put_contents(LEADERBOARD_FILE, json_encode([]));
    }
    return json_decode(file_get_contents(LEADERBOARD_FILE), true);
}

function writeLeaderboard($leaderboard) {
    file_put_contents(LEADERBOARD_FILE, json_encode($leaderboard));
}

function updateLeaderboard($playerName, $score) {
    $leaderboard = readLeaderboard();
    $found = false;
    foreach ($leaderboard as &$entry) {
        if ($entry['playerName'] === $playerName) {
            $entry['score'] = max($score, $entry['score']);
            $found = true;
            break;
        }
    }
    if (!$found) {
        $leaderboard[] = ['playerName' => $playerName, 'score' => $score];
    }
    usort($leaderboard, function($a, $b) {
        return $b['score'] - $a['score'];
    });
    $leaderboard = array_slice($leaderboard, 0, 10);
    writeLeaderboard($leaderboard);
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
        updateLeaderboard($_SESSION['game_state']['playerName'], $_SESSION['game_state']['currentWinStreak']);
        $_SESSION['game_state']['gameOver'] = true;
    } elseif ($_SESSION['game_state']['guessCount'] >= 6) {
        $_SESSION['game_state']['currentWinStreak'] = 0;
        $_SESSION['game_state']['gameOver'] = true;
    }

    echo json_encode($_SESSION['game_state']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['leaderboard'])) {
        echo json_encode(readLeaderboard());
        exit;
    }
    
    if (empty($_SESSION['game_state']['word'])) {
        resetGame();
    }
    echo json_encode($_SESSION['game_state']);
    exit;
}
?>
