<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'guestbook');

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

$valid_sort_by = ['username', 'email', 'created_at'];
$valid_order = ['ASC', 'DESC'];

if (!in_array($sort_by, $valid_sort_by)) {
    $sort_by = 'created_at';
}

if (!in_array($order, $valid_order)) {
    $order = 'DESC';
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;

$count_query = "SELECT COUNT(*) as total FROM messages";
$count_result = $conn->query($count_query);
$count_row = $count_result->fetch_assoc();
$total_records = $count_row['total'];

$total_pages = ceil($total_records / $limit);
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM messages ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гостевая книга</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow: hidden;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th a {
            display: inline-block;
            text-decoration: none;
            color: black;
            transition: color 0.3s ease;
        }

        th a:hover {
            color: #444444;
        }

        th .sort-arrow {
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            transition: border-bottom 0.3s ease;
            vertical-align: middle;
        }

        .sort-arrow.up {
            border-bottom: 5px solid #333;
        }

        .sort-arrow.down {
            border-top: 5px solid #333;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pagination {
            margin-top: 20px;
            list-style-type: none;
            padding: 0;
        }

        .pagination li {
            display: inline-block;
            margin-right: 5px;
        }

        .pagination a {
            display: inline-block;
            text-decoration: none;
            color: #37B7C3;
            font-size: 14px;
            width: 25px;
            height: 25px;
            line-height: 25px;
            text-align: center;
            border: 1px solid #37B7C3;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #088395;
            color: #fff;
        }

        .pagination .active a {
            background-color: #37B7C3;
            color: #fff;
        }

        .add-message-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            text-decoration: none;
            padding: 10px 24px;
            background-color: #37B7C3;
            border: 2px solid #37B7C3;
            border-radius: 25px;
            transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        }

        .add-message-link:hover {
            color: #fff;
            background-color: #088395;
            border-color: #088395;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Гостевая книга</h1>
        
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="?sort_by=username&order=<?php echo $order === 'ASC' && $sort_by === 'username' ? 'DESC' : 'ASC'; ?>">
                            Имя пользователя
                            <span class="sort-arrow <?php echo $sort_by === 'username' ? ($order === 'ASC' ? 'up' : 'down') : ''; ?>"></span>
                        </a>
                    </th>
                    <th>
                        <a href="?sort_by=email&order=<?php echo $order === 'ASC' && $sort_by === 'email' ? 'DESC' : 'ASC'; ?>">
                            Электронная почта
                            <span class="sort-arrow <?php echo $sort_by === 'email' ? ($order === 'ASC' ? 'up' : 'down') : ''; ?>"></span>
                        </a>
                    </th>
                    <th>
                        <a href="?sort_by=created_at&order=<?php echo $order === 'ASC' && $sort_by === 'created_at' ? 'DESC' : 'ASC'; ?>">
                            Дата добавления
                            <span class="sort-arrow <?php echo $sort_by === 'created_at' ? ($order === 'ASC' ? 'up' : 'down') : ''; ?>"></span>
                        </a>
                    </th>
                    <th>Сообщение</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo htmlspecialchars($row['text']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li><a href="?page=<?php echo ($page - 1); ?>">&laquo;</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li <?php echo ($i === $page) ? 'class="active"' : ''; ?>>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li><a href="?page=<?php echo ($page + 1); ?>">&raquo;</a></li>
            <?php endif; ?>
        </ul>

        <a class="add-message-link" href="form.php">Добавить сообщение</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
