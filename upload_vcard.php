<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephoneProfessionnel = $_POST['telephone-professionnel'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $adresse = $_POST['adresse'];
    $whatsapp = $_POST['whatsapp'];
    
    $vcard = "BEGIN:VCARD\nVERSION:3.0\n";
    $vcard .= "N:$nom;$prenom;;;\n";
    $vcard .= "FN:$prenom $nom\n";
    if ($telephoneProfessionnel) $vcard .= "TEL;TYPE=WORK:$telephoneProfessionnel\n";
    $vcard .= "EMAIL:$email\n";
    if ($website) $vcard .= "URL:$website\n";
    if ($adresse) $vcard .= "ADR:;;$adresse;;;;\n";
    if ($whatsapp) $vcard .= "TEL;TYPE=WHATSAPP:$whatsapp\n";

    $photoData = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $photoPath = $uploadDir . basename($_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            $photoData = base64_encode(file_get_contents($photoPath));
            $vcard .= "PHOTO;ENCODING=BASE64;TYPE=JPEG:$photoData\n";
        }
    }

    if (isset($_POST['social-platform']) && isset($_POST['social-url'])) {
        $socialPlatforms = $_POST['social-platform'];
        $socialUrls = $_POST['social-url'];
        foreach ($socialPlatforms as $index => $platform) {
            $url = $socialUrls[$index];
            if ($url) {
                $vcard .= "X-SOCIALPROFILE;TYPE=$platform:$url\n";
            }
        }
    }

    $vcard .= "END:VCARD";

    $filename = $uploadDir . uniqid() . '.vcf';
    if (file_put_contents($filename, $vcard)) {
        echo json_encode(['success' => true, 'url' => $filename]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
