<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des locations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Liste des locations</h1>
    <div class="container">
        <a href="formulaire.html" class="btn btn-primary my-5 text-light text-decoration-none">كراء جديد</a>
        <a href="Rechercher.php" class="btn btn-primary my-5 text-light text-decoration-none">البحت بواسطة :  تاريخ التسجيل /  تاريخ الكراء / اللون</a>
        <a href="VetementSortie.php" class="btn btn-primary my-5 text-light text-decoration-none">الملابس الخارجة</a>
        <a href="Aujourdhuit.php" class="btn btn-primary my-5 text-light text-decoration-none">كراء اليوم </a>
    </div>

    <?php
    // Connexion à la base de données avec PDO
    $servername = "sql7.freesqldatabase.com";
    $username = "sql7768024 ";
    $password = "E9RlyVmAZ2";
    $dbname = "sql7768024";
    

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour calculer les sommes de `avance` et `reste`
        $query = "SELECT SUM(avance) AS total_avance, SUM(reste) AS total_reste FROM personnes";
        $stmt = $pdo->query($query);
        $totals = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalAvance = $totals['total_avance'] ?? 0; // Valeur par défaut si null
        $totalReste = $totals['total_reste'] ?? 0; // Valeur par défaut si null

        // Récupérer les données de la table `personnes`
        $sql = "SELECT id, dateE, dateL, image, design, couleur, position, prix, avance, reste, tel, obs FROM personnes";
        $result = $pdo->query($sql);

        // Afficher le tableau
        if ($result->rowCount() > 0) {
            echo "<table border='1'>
                    <tr>
                        <th> الرقم</th>
                        <th>تاريخ التشجيل</th>
                        <th>تاريخ الكراء</th>
                        <th>الصورة</th>
                        <th>نوع اللباس</th>
                        <th>اللون</th>
                        <th>الوضع</th>
                        <th>الثمن</th>
                        <th>الدفع</th>
                        <th>الباقي</th>
                        <th>الهاتف</th>
                        <th>ملاحظات</th>
                        <th>عملية</th>
                    </tr>";

            // Parcourir les résultats
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["id"]) . "</td>
                        <td>" . htmlspecialchars($row["dateE"]) . "</td>
                        <td>" . htmlspecialchars($row["dateL"]) . "</td>
                        <td>";

                // Afficher l'image si elle existe
                if (!empty($row["image"])) {
                    $imageData = base64_encode($row["image"]);
                    echo "<img src='data:image/jpeg;base64,{$imageData}' alt='Image' width='50'>";
                } else {
                    echo "Aucune image";
                }

                echo "</td>
                      <td>" . htmlspecialchars($row["design"]) . "</td>
                      <td>" . htmlspecialchars($row["couleur"]) . "</td>
                      <td>" . htmlspecialchars($row["position"]) . "</td>
                      <td>" . htmlspecialchars($row["prix"]) . "</td>
                      <td>" . htmlspecialchars($row["avance"]) . "</td>
                      <td>" . htmlspecialchars($row["reste"]) . "</td>
                      <td>" . htmlspecialchars($row["tel"]) . "</td>
                      <td>" . htmlspecialchars($row["obs"]) . "</td>
                      <td>
                          <a href='modifier.php?modifieid=" . htmlspecialchars($row["id"]) . "' class='btn btn-primary'>التعديل</a>
                          <a href='supprimer.php?supprimeid=" . htmlspecialchars($row["id"]) . "' class='btn btn-danger'>المسح</a>
                      </td>
                    </tr>";
            }

            // Afficher les totaux
            echo "<tr>
                    <td colspan='8'><strong>Totaux</strong></td>
                    <td><strong style='color: green;'>$totalAvance</strong></td>
                    <td><strong style='color: red;'>$totalReste</strong></td>
                    <td colspan='2'></td>
                  </tr>";

            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    ?>
</body>
</html>