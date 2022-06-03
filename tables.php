<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <h2>Users have orders</h2>
    <?php
      require_once 'login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) die($conn->connect_error);

      $query = 'SELECT DISTINCT name FROM users, orders WHERE users.id=user_id';
      $result = $conn->query($query);

      if (!$result) die ("Сбой при доступе к базе данных: " . $conn->error);

      $rows = $result->num_rows;

      echo "<table><thead><tr> <th>name</th> </tr></thead><tbody>";

      for ($j = 0; $j < $rows; ++$j)
      {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_NUM);

        echo "<tr>";
          for ($k = 0; $k < 1; ++$k) echo "<td>$row[$k]</td>";
        echo "</tr>";
      }

      echo "</tbody></table>";
    ?>
    <h2>Products and catalogs</h2>
    <?php
      $query = 'SELECT catalogs.name, products.name FROM catalogs, products WHERE catalogs.id=catalog_id';
      $result = $conn->query($query);

      if (!$result) die ("Сбой при доступе к базе данных: " . $conn->error);

      $rows = $result->num_rows;

      echo "<table><thead><tr> <th>catalog name</th> <th>product name</th> </tr></thead><tbody>";

      for ($j = 0; $j < $rows; ++$j)
      {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_NUM);

        echo "<tr>";
          for ($k = 0; $k < 2; ++$k) echo "<td>$row[$k]</td>";
        echo "</tr>";
      }

      echo "</tbody></table>";
    ?>
    <h2>Random user</h2>
    <?php
      $query = 'SELECT user.name FROM users AS user INNER JOIN orders AS orders ON (orders.user_id = user.id) WHERE ( TIMESTAMPDIFF(YEAR, user.birthday_at, CURDATE() ) )>30 AND (orders.created_at < NOW() - INTERVAL 183 DAY) GROUP BY user.name HAVING COUNT(orders.id) >= 3 ORDER BY RAND() LIMIT 1;
';
      $result = $conn->query($query);

      if (!$result) die ("Сбой при доступе к базе данных: " . $conn->error);

      $rows = $result->num_rows;

      echo "<table><thead><tr> <th>name</th> </tr></thead><tbody>";

      for ($j = 0; $j < $rows; ++$j)
      {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_NUM);

        echo "<tr>";
          for ($k = 0; $k < 1; ++$k) echo "<td>$row[$k]</td>";
        echo "</tr>";
      }

      echo "</tbody></table>";
    ?>
  </div>
</body>
</html>