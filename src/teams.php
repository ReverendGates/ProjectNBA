<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THROW</title>
    <link href="teams.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>
<body>
    <header>
        <a href="../index.php" class="logo-link">
            <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="231" height="44" viewBox="0 0 231 44"
                fill="none">
                <g clip-path="url(#clip0_29_2)">
                    <path
                        d="M159.72 34.44C162.76 31.08 164.84 26.6 165 21.64H153.8C153.96 26.76 156.2 31.4 159.72 34.44Z"
                        fill="white" />
                    <path
                        d="M158.6 6.27996C155.24 3.07996 150.76 1.15996 145.8 1V20.2H152.2C152.36 14.76 154.76 9.80004 158.6 6.27996Z"
                        fill="white" />
                    <path
                        d="M130.28 7.39999C127.24 10.76 125.16 15.24 125 20.2H136.2C135.88 15.08 133.64 10.6 130.28 7.39999Z"
                        fill="white" />
                    <path d="M165 20.2C164.84 15.24 162.92 10.92 159.72 7.39999C156.2 10.6 153.96 15.08 153.8 20.2H165Z"
                        fill="white" />
                    <path
                        d="M125 21.8C125.16 26.12 126.76 30.12 129.16 33.16C129.48 33.64 130.28 34.44 130.28 34.44C133.8 31.24 136.04 26.76 136.2 21.64H125V21.8Z"
                        fill="white" />
                    <path
                        d="M145.8 21.8V41C150.76 40.84 155.24 38.76 158.6 35.72C154.92 32.2 152.36 27.4 152.2 21.8H145.8Z"
                        fill="white" />
                    <path
                        d="M137.8 20.2H144.2V1C139.24 1.16004 134.76 3.24 131.4 6.27996C135.08 9.80004 137.48 14.76 137.8 20.2Z"
                        fill="white" />
                    <path
                        d="M131.4 35.72C134.76 38.92 139.24 40.84 144.2 41V21.8H137.8C137.48 27.24 135.08 32.2 131.4 35.72Z"
                        fill="white" />
                </g>
                <path
                    d="M13.2741 41V9.365H0.506063V0.814998H36.5301V9.365H23.7621V41H13.2741ZM40.4947 41V0.814998H50.9827V16.319H67.5697V0.814998H78.0007V41H67.5697V24.926H50.9827V41H40.4947ZM85.3043 41V0.814998H104.627C109.187 0.814998 112.702 1.936 115.172 4.178C117.68 6.382 118.934 9.46 118.934 13.412C118.934 16.414 118.174 18.941 116.654 20.993C115.172 23.007 113.006 24.413 110.156 25.211C112.284 25.781 113.994 27.244 115.286 29.6L121.556 41H110.042L103.088 28.232C102.632 27.434 102.043 26.864 101.321 26.522C100.637 26.18 99.8393 26.009 98.9273 26.009H95.7923V41H85.3043ZM95.7923 18.599H102.746C106.888 18.599 108.959 16.965 108.959 13.697C108.959 10.467 106.888 8.852 102.746 8.852H95.7923V18.599ZM181.592 41L167.171 0.814998H177.887L186.266 26.009L195.329 0.814998H202.739L211.403 26.522L220.181 0.814998H230.27L215.735 41H207.356L198.749 16.832L189.971 41H181.592Z"
                    fill="white" />
                <defs>
                    <clipPath id="clip0_29_2">
                        <rect width="40" height="40" fill="white" transform="translate(125 1)" />
                    </clipPath>
                </defs>
            </svg>
        </a>
        <nav>
            <ul>
                <li><a href="schedule.php">РАСПИСАНИЕ</a></li>
                <li><a href="account.php">АККАУНТ</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Команды</h2>
        <section class="teams-list">
            <?php
            $db = new mysqli('localhost', 'reverendo_throw', 'Synyster7', 'reverendo_throw');

            if ($db->connect_error) {
                die('Ошибка соединения: ' . $db->connect_error);
            }

            $query = "SELECT TeamID, TeamName FROM TEAMS";
            $result = $db->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<section class='team'>";
                    echo "<h2>" . htmlspecialchars($row['TeamName']) . "</h2>";
                    $teamId = $row['TeamID'];
                    $playerQuery = "SELECT PlayerName, Performance, Number, Role FROM PLAYERS WHERE TeamID = ?";
                    $stmt = $db->prepare($playerQuery);
                    $stmt->bind_param("i", $teamId);
                    $stmt->execute();
                    $playerResult = $stmt->get_result();

                    if ($playerResult->num_rows > 0) {
                        echo "<p><strong>Ростер:</strong></p>";
                        echo "<ul>";
                        while ($playerRow = $playerResult->fetch_assoc()) {
                            echo "<li>" . htmlspecialchars($playerRow['PlayerName']) . " (№" . htmlspecialchars($playerRow['Number']) . ") - " . htmlspecialchars($playerRow['Role']) . " - Производительность: " . htmlspecialchars($playerRow['Performance']) . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Нет данных о ростере.</p>";
                    }

                    echo "</section>";
                }
            } else {
                echo "<p>Нет данных о командах.</p>";
            }

            $db->close();
            ?>
        </section>
    </main>
    <footer>
        <a href="newsletter.php">РАССЫЛКА</a>
    </footer>
</body>
</html>