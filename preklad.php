<style>
table, th, td {
  border: 1px solid black;
}
</style>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "akihabara";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Nefunguje připojení k DB: " . $conn->connect_error);
}

$sql = "SELECT id_anime, jmeno_orig, jmeno_eng FROM anime WHERE id_anime=".$_GET["id"];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<h1><center>" . $row["jmeno_orig"]. " (" . $row["jmeno_eng"]. ")</h1>";
  }
} else {
  echo "Neexistuje.";
}

echo "<h2><center><a href='index.php'>ZPĚT NA SEZNAM</a><br><br>";

$sql = "SELECT id_preklad, id_anime, id_dil, prelozil, casoval, korektor, verze_originalu, original, typ_prekladu, adresa FROM anime_preklad WHERE id_anime=".$_GET["id"]." ORDER BY id_dil ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo '<table style="width:100%"><center>
<tr>
    <th>ID</th>
    <th>Díl</th>
    <th>Verze</th>
    <th>Originální název</th>
    <th>Přeložil</th>
    <th>Korektor</th>
    <th>Časoval</th>
    <th>Záznam</th>
  </tr>';
  while($row = $result->fetch_assoc()) {
    if (substr($row["typ_prekladu"],0,3) == "ext") $nazev = $row["adresa"];
    else if (strpos(substr($row["typ_prekladu"],0,3), '|') !== false) $nazev = "NENALEZENO";
    else $nazev = "http://akihabara.freeddns.org/akihabara/aki_2020-07-03/data-titulky-anime/".$row["id_anime"]."/".$row["id_preklad"].".".substr($row["typ_prekladu"],0,3);
    echo "<tr style='text-align:center'><td>" . $row["id_preklad"]. "</td><td>" . $row["id_dil"]. "</td><td>" . $row["verze_originalu"]. "</td><td>" . $row["original"]. "</td><td>" . $row["prelozil"]. "</td><td>" . $row["korektor"]. "</td><td>" . $row["casoval"]. "</td><td><a href='".$nazev."' download='".$row["id_dil"].substr($row["typ_prekladu"],0,3)."'>TITULKY</a></td></tr>";
  }
  echo "</table>";
} else {
  echo "<h2><center>Bohužel žádný záznam.";
}
$conn->close();
?>