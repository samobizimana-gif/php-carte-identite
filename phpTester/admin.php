<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$dbname = "carteIdentite";

$conn = new mysqli($host, $user, $password, $dbname);

// Vérification connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
};

if(isset($_GET['edit'])) {
    $numero = $_GET['edit'];

    $stmt = $conn->prepare("SELECT * FROM personne WHERE numeroCarte = ?");
    $stmt->bind_param("s", $numero);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $personne = $result->fetch_assoc();

        // Remplir les champs du formulaire
        $nom = $personne['nom'];
        $prenom = $personne['prenom'];
        $dateNaissance = $personne['dateNaissance'];
        $pere = $personne['pere'];
        $mere = $personne['mere'];
        $province = $personne['province'];
        $commune = $personne['commune'];
        $zoneRes = $personne['zoneRes'];
        $etatCivil = $personne['etatCivil'];
        $fonction = $personne['fonction'];
        $residenceActuel = $personne['residenceActuel'];
        $nationalite = $personne['nationalite'];
        $sexe = $personne['sexe'];
        $numeroCarte = $personne['numeroCarte'];
    }
    $stmt->close();
}

if(isset($_GET['delete'])) {
    $numero = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM personne WHERE numeroCarte = ?");
    $stmt->bind_param("s", $numero);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php"); // Rafraîchit la page
    exit();
}

$sql = "SELECT * FROM personne";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Admin</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 95%;
            margin: 20px auto;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #333;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
    </style>
</head>
<body>

<h2>Liste des personnes enregistrées</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Numéro Carte</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Date Naissance</th>
        <th>Pere</th>
        <th>Mere</th>
        <th>Province</th>
        <th>Commune</th>
        <th>Zone</th>
        <th>Etat civil</th>
        <th>Fonction</th>
        <th>Residence Actuel</th>
        <th>Nationalite</th>
        <th>sexe</th>
        <th>Date d'enregistrement</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['numeroCarte']."</td>";
            echo "<td>".$row['nom']."</td>";
            echo "<td>".$row['prenom']."</td>";
            echo "<td>".$row['dateNaissance']."</td>";
            echo "<td>".$row['pere']."</td>";
            echo "<td>".$row['mere']."</td>";
            echo "<td>".$row['province']."</td>";
            echo "<td>".$row['commune']."</td>";
            echo "<td>".$row['zoneRes']."</td>";
            echo "<td>".$row['etatCivil']."</td>";
            echo "<td>".$row['fonction']."</td>";
            echo "<td>".$row['residenceActuel']."</td>";
            echo "<td>".$row['nationalite']."</td>";
            echo "<td>".$row['sexe']."</td>";
            echo "<td>".$row['dateEnregistrement']."</td>";

            // Affichage image
            echo "<td>
                    <a href='index.php?edit=".$row['numeroCarte']."'><button>Editer</button></a>
                    <a href='admin.php?delete=".$row['numeroCarte']."' onclick='return confirm(\"Voulez-vous vraiment supprimer ?\");'><button>Supprimer</button></a>
                  </td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Aucune donnée trouvée</td></tr>";
    }
    ?>

</table>

</body>
</html>