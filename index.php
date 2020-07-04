<style>
table, th, td {
  border: 1px solid black;
}
</style>
<br>
<center><form action="index.php" method="get">
Název: <input type="text" name="nazev"> <input type="submit">
</form><br><br>

<?php
if (isset($_GET["nazev"])!="")
{
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "akihabara";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Nefunguje připojení k DB: " . $conn->connect_error);
}

$sql = "SELECT id_anime, jmeno_orig, jmeno_eng, id_mal, epizody FROM anime WHERE jmeno_orig LIKE '%".$_GET["nazev"]."%' OR jmeno_eng LIKE '%".$_GET["nazev"]."%' ORDER BY id_anime ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<table style="width:100%"><center>
<tr>
    <th>Náhled</th>
    <th>Název</th>
    <th>Anglický název</th>
    <th>Počet epizod</th>
    <th>Záznamy</th>
  </tr>';
  while($row = $result->fetch_assoc()) {
    echo "<tr style='text-align:center'><td></td><td><b>".$row["jmeno_orig"]. "</b></td><td>" . $row["jmeno_eng"]. "</td><td>" . $row["epizody"]. "</td><td><b><a href='preklad.php?id=".$row["id_anime"]."'> ZÁZNAMY </a></td>";
  }
  echo "</table>";
} else {
  echo "<h2><center>Bohužel žádný záznam.";
}
$conn->close();
}
?>