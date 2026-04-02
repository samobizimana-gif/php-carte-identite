<?php
// Connexion base de données
$host = "localhost";
$user = "root";
$password = "";
$dbname = "carteIdentite";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion");
}

$personne = null;
$message = "";

// Vérifier si numero est envoyé
if (isset($_GET['numero'])) {

    $numeroCarte = $_GET['numero'];

    // Requête sécurisée
    $stmt = $conn->prepare("SELECT * FROM personne WHERE numeroCarte = ?");
    $stmt->bind_param("s", $numeroCarte);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $personne = $result->fetch_assoc();
    } else {
        $message = "❌ Personne non trouvée";
    }

    $stmt->close();
} else {
    $message = "⚠️ Aucun numéro reçu";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Carte d'identité</title>
    <link rel="stylesheet" href="infosStyle.css">

</head>

<body>

    <?php if ($personne) { ?>

        <div class="all">
            <div class="carte" id="carte">
                <div class="titre">CARTE D'IDENTITÉ</div>

                <div class="ident">
                    <div class="photo" id="photo">
                        <img src="" alt="" id="passport">
                    </div>
                    <div class="names">
                        <p><strong>Numéro :</strong> <?php echo $personne['numeroCarte']; ?></p>
                        <p><strong>Nom :</strong> <?php echo $personne['nom']; ?></p>
                        <p><strong>Prénom :</strong> <?php echo $personne['prenom']; ?></p>
                        <p><strong>Date de naissance :</strong> <?php echo $personne['dateNaissance']; ?></p>
                    </div>
                </div>
                <div class="enBas">
                    <div class="infos">
                        <p><strong>Père :</strong> <?php echo $personne['pere']; ?></p>
                        <p><strong>Mère :</strong> <?php echo $personne['mere']; ?></p>
                        <p><strong>Province :</strong> <?php echo $personne['province']; ?></p>
                        <p><strong>Commune :</strong> <?php echo $personne['commune']; ?></p>
                        <p><strong>Zone :</strong> <?php echo $personne['zoneRes']; ?></p>
                        <p><strong>Etat civil :</strong> <?php echo $personne['etatCivil']; ?></p>
                        <p><strong>Fonction :</strong> <?php echo $personne['fonction']; ?></p>
                        <p><strong>Résidence :</strong> <?php echo $personne['residenceActuel']; ?></p>
                        <p><strong>Nationalité :</strong> <?php echo $personne['nationalite']; ?></p>
                        <p><strong>Sexe :</strong> <?php echo $personne['sexe']; ?></p>
                    </div>
                    <div class="time">
                        <p><strong>Delivré à:</strong><?php echo $personne['zoneRes'] ?></p>
                        <p><strong>Le :</strong> <?php echo date("d/m/Y", strtotime($personne['dateEnregistrement'])); ?></p>
                        <p><strong>par:</strong><?php echo "Chef de zone <br>" . $personne['zoneRes'] ?></p>

                    </div>
                </div>
            </div>

            <div class="btn">
                <button class="print" onclick="imprimer()">🖨️ Imprimer</button>
                <button class="sendMail" id="sendMail">📧Envoyer per email</button>
                <button class="return" onclick="window.location.href='index.php'">🔙 Retour</button>

            </div>

        <?php } else { ?>

            <p><?php echo $message; ?></p>
            <button onclick="window.location.href='index.php'">Retour</button>

        <?php } ?>

        </div>
        <script>
            function imprimer() {
                window.print();
            }
        </script>

</body>

</html>