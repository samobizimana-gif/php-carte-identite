<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "carteIdentite";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connection");
}


$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Récupération des données
    $numeroCarte = $_POST['numeroCarte'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $dateNaissance = $_POST['dateNaissance'] ?? '';
    $pere = $_POST['pere'] ?? '';
    $mere = $_POST['mere'] ?? '';
    $province = $_POST['province'] ?? '';
    $commune = $_POST['commune'] ?? '';
    $zoneRes = $_POST['zoneRes'] ?? '';
    $etatCivil = $_POST['etatCivil'] ?? '';
    $fonction = $_POST['fonction'] ?? '';
    $residenceActuel = $_POST['residenceActuel'] ?? '';
    $nationalite = $_POST['nationalite'] ?? '';
    $sexe = $_POST['sexe'] ?? '';

    // Vérification des champs
    if (
        !empty($numeroCarte) && !empty($nom) && !empty($prenom) && !empty($dateNaissance) &&
        !empty($pere) && !empty($mere) && !empty($province) && !empty($commune) &&
        !empty($zoneRes) && !empty($etatCivil) && !empty($fonction) &&
        !empty($residenceActuel) && !empty($nationalite) && !empty($sexe)
    ) {

        $stmt = $conn->prepare("SELECT id FROM personne WHERE numeroCarte = ?");
        $stmt->bind_param("s", $numeroCarte);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Ce numero existe deja";
            $stmt->close();
        } else {
            $stmt->close();

            // Préparation de la requête sécurisée
            $stmt = $conn->prepare("INSERT INTO personne (numeroCarte, nom, prenom, dateNaissance, pere, mere, province, commune, zoneRes, etatCivil, fonction, residenceActuel, nationalite, sexe) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Vérifier si la préparation a réussi
            if ($stmt) {

                $stmt->bind_param(
                    "ssssssssssssss",
                    $numeroCarte,
                    $nom,
                    $prenom,
                    $dateNaissance,
                    $pere,
                    $mere,
                    $province,
                    $commune,
                    $zoneRes,
                    $etatCivil,
                    $fonction,
                    $residenceActuel,
                    $nationalite,
                    $sexe
                );

                // Exécution
                if ($stmt->execute()) {
                    $message = "✅ Succès !!!";
                    $success = true;
                } else {
                    $message = "❌ Erreur lors de l'exécution : " . $stmt->error;
                }

                $stmt->close();
            } else {
                $message = "❌ Erreur de préparation : " . $conn->error;
            }
        }
    } else {
        $message = "⚠️ Tous les champs sont obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carte d'identite</title>
    <link rel="stylesheet" href="indexStyle.css">
</head>

<body>

    <?php if (!$success) { ?>

        <form action="" method="POST" onsubmit="return verifier()">
            <h1 class="titre">
                <img src="images (1).jpeg" alt="Burundi">
                <p>REPUBLIQUE DU BURUNDI</p>
            </h1>
            <div class="upInfos">
                <div class="img">
                    <img src="" alt="" id="preview">
                </div>
                <div class="names">
                    <input id="numero" name="numeroCarte" readonly style="display: none;">
                    <input type="text" id="nom" name="nom" placeholder="nom">
                    <input type="text" id="prenom" name="prenom" placeholder="prenom">
                    <input type="date" id="dateNaissance" name="dateNaissance">

                    <input type="file" id="fileInput" accept="image/*" style="display: none;">
                    <button id="chooseImage" type="button">Ajouter une photo</button>
                </div>
            </div>

            <div class="down">

                <input type="text" id="pere" name="pere" placeholder="Nom du pere">
                <input type="text" id="mere" name="mere" placeholder="Nom du mere">

                <select name="province" id="province" onchange="chargerCommunes()">
                    <option value="">--Choisir province--</option>
                    <option value="bujumbura">Bujumbura</option>
                    <option value="gitega">Gitega</option>
                    <option value="butanyerera">Butanyerera</option>
                </select>

                <select name="commune" id="commune">
                    <option value="">--commune--</option>
                </select>

                <input type="text" id="zoneRes" name="zoneRes" placeholder="Zone">
                <select name="etatCivil" id="etatCivil">
                    <option value="">--Etat civil--</option>
                    <option value="marie">Marie</option>
                    <option value="celibatire">Celibataire</option>
                </select>
                <input type="text" id="fonction" name="fonction" placeholder="Votre fonction">
                <input type="text" id="residenceActuel" name="residenceActuel" placeholder="Residence actuel">
                <input type="text" id="nationalite" name="nationalite" placeholder="nationalite">

                <select name="sexe" id="sexe">
                    <option value="">--sexe--</option>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>

            </div>

            <button type="submit" class="btn">Enregistrer Maintanant</button>
        </form>
        <p><?php echo $message ?></p>
    <?php  } else { ?>

        <div style="text-align:center; margin-top:50px;">
            <p style="color:green; font-size:20px;"><?php echo $message; ?></p>

            <a href="infosPersonne.php?numero=<?php echo $numeroCarte; ?>">
                <button>Terminer</button>
            </a>
        </div>

    <?php } ?>

    <script src="script.js"> </script>
</body>

</html>