<?php
session_start();

function connect_db() {
    $host = 'localhost';
    $port = '1337';
    $dbname = 'wordle';
    $user = 'admin';
    $password = 'admin';
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

    try {
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

function open_session($save_path, $session_name) {
    return true;
}

function close_session() {
    return true;
}

function read_session($session_id) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("SELECT session_data FROM sessions WHERE session_id = :session_id");
    $stmt->execute(['session_id' => $session_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['session_data'] : '';
}

function write_session($session_id, $session_data) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("INSERT INTO sessions (session_id, session_data) VALUES (:session_id, :session_data)
                           ON CONFLICT (session_id) DO UPDATE SET session_data = :session_data, last_activity = CURRENT_TIMESTAMP");
    $stmt->execute(['session_id' => $session_id, 'session_data' => $session_data]);
}

function destroy_session($session_id) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("DELETE FROM sessions WHERE session_id = :session_id");
    $stmt->execute(['session_id' => $session_id]);
}

function gc_session($max_lifetime) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("DELETE FROM sessions WHERE last_activity < (CURRENT_TIMESTAMP - INTERVAL '$max_lifetime seconds')");
    $stmt->execute();
}

function create_sid() {
    return bin2hex(random_bytes(16));
}

session_set_save_handler(
    "open_session",
    "close_session",
    "read_session",
    "write_session",
    "destroy_session",
    "gc_session",
    "create_sid"
);

register_shutdown_function('session_write_close');

function get_random_word() {
    $pdo = connect_db();
    $stmt = $pdo->query("SELECT word FROM words ORDER BY RANDOM() LIMIT 1");
    return $stmt->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action == 'start') {
        $player_name = $_POST['player_name'];
        $word = get_random_word();

        $_SESSION['player_name'] = $player_name;
        $_SESSION['word'] = $word;
        $_SESSION['win_streak'] = 0;
        $_SESSION['attempts'] = 0;

        echo json_encode(['status' => 'started']);
    } elseif ($action == 'guess') {
        $guess = $_POST['guess'];
        $word = $_SESSION['word'];
        $attempts = ++$_SESSION['attempts'];

        $result = [];
        for ($i = 0; $i < 5; $i++) {
            if ($guess[$i] == $word[$i]) {
                $result[] = 'correct';
            } elseif (strpos($word, $guess[$i]) !== false) {
                $result[] = 'change';
            } else {
                $result[] = 'wrong';
            }
        }

        if ($guess == $word) {
            $_SESSION['win_streak']++;
            echo json_encode(['status' => 'won', 'result' => $result, 'attempts' => $attempts, 'win_streak' => $_SESSION['win_streak']]);
        } else {
            echo json_encode(['status' => 'continue', 'result' => $result, 'attempts' => $attempts]);
        }
    } elseif ($action == 'play_again') {
        $word = get_random_word();
        $_SESSION['word'] = $word;
        $_SESSION['attempts'] = 0;

        echo json_encode(['status' => 'new_game']);
    }
}
?>