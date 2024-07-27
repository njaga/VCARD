<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de QR Code pour vCard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background: #218838;
        }

        #qrcode {
            text-align: center;
            margin-top: 20px;
        }

        #qrcode img {
            max-width: 100%;
            height: auto;
        }

        .qr-options {
            margin-top: 20px;
            text-align: center;
        }

        .qr-options label {
            margin-right: 10px;
        }

        #debug-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Générateur de QR Code pour vCard</h1>
        <form id="vcard-form">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="telephone-professionnel">Téléphone professionnel (avec indicatif):</label>
                <input type="tel" id="telephone-professionnel" name="telephone-professionnel" placeholder="+33712345678" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="website">Site web:</label>
                <input type="url" id="website" name="website">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse:</label>
                <textarea id="adresse" name="adresse" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="whatsapp">Contact WhatsApp (avec indicatif):</label>
                <input type="tel" id="whatsapp" name="whatsapp" placeholder="+33612345678">
            </div>
            <div class="form-group">
                <label for="facebook">Facebook:</label>
                <input type="url" id="facebook" name="facebook">
            </div>
            <div class="form-group">
                <label for="instagram">Instagram:</label>
                <input type="url" id="instagram" name="instagram">
            </div>
            <div class="form-group">
                <label for="linkedin">LinkedIn:</label>
                <input type="url" id="linkedin" name="linkedin">
            </div>
            <div class="qr-options">
                <label>
                    <input type="radio" name="qr-type" value="full" checked> QR Code complet
                </label>
                <label>
                    <input type="radio" name="qr-type" value="simple"> QR Code simplifié
                </label>
            </div>
            <button type="submit">Générer QR Code</button>
        </form>
        <div id="qrcode"></div>
        <div id="debug-info"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script>
    document.getElementById('vcard-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const debugInfo = document.getElementById('debug-info');
        debugInfo.innerHTML = '';

        const nom = document.getElementById('nom').value;
        const prenom = document.getElementById('prenom').value;
        const telephoneProfessionnel = document.getElementById('telephone-professionnel').value;
        const email = document.getElementById('email').value;
        const website = document.getElementById('website').value;
        const adresse = document.getElementById('adresse').value;
        const whatsapp = document.getElementById('whatsapp').value;
        const qrType = document.querySelector('input[name="qr-type"]:checked').value;

        let vcard = `BEGIN:VCARD\nVERSION:3.0\n`;
        vcard += `N:${nom};${prenom};;;\n`;
        vcard += `FN:${prenom} ${nom}\n`;
        if (telephoneProfessionnel) vcard += `TEL;TYPE=WORK:${telephoneProfessionnel}\n`;
        vcard += `EMAIL:${email}\n`;
        
        if (qrType === 'full') {
            if (website) vcard += `URL:${website}\n`;
            if (adresse) vcard += `ADR:;;${adresse};;;;\n`;
            if (whatsapp) vcard += `TEL;TYPE=WHATSAPP:${whatsapp}\n`;

            const socialNetworks = ['facebook', 'instagram', 'linkedin'];
            socialNetworks.forEach(network => {
                const input = document.getElementById(network);
                if (input && input.value) {
                    vcard += `X-SOCIALPROFILE;TYPE=${network}:${input.value}\n`;
                }
            });
        }

        vcard += `END:VCARD`;

        debugInfo.innerHTML += `<p>Taille des données vCard : ${vcard.length} caractères</p>`;

        const qrCodeContainer = document.getElementById('qrcode');
        qrCodeContainer.innerHTML = '';

        function generateQR(version) {
            return new Promise((resolve, reject) => {
                QRCode.toDataURL(vcard, { 
                    errorCorrectionLevel: 'M',
                    version: version,
                    mode: 'byte'
                }, function (err, url) {
                    if (err) {
                        reject(err);
                    } else {
                        resolve(url);
                    }
                });
            });
        }

        async function tryGenerateQR() {
            for (let version = 10; version <= 40; version += 5) {
                try {
                    debugInfo.innerHTML += `<p>Tentative avec la version ${version}...</p>`;
                    const url = await generateQR(version);
                    const img = document.createElement('img');
                    img.src = url;
                    qrCodeContainer.appendChild(img);

                    const downloadLink = document.createElement('a');
                    downloadLink.href = url;
                    downloadLink.download = `${prenom}_${nom}_vcard.png`;
                    downloadLink.textContent = 'Télécharger le QR Code';
                    downloadLink.style.display = 'block';
                    downloadLink.style.marginTop = '10px';
                    qrCodeContainer.appendChild(downloadLink);

                    debugInfo.innerHTML += `<p>QR Code généré avec succès (version ${version})</p>`;
                    return;
                } catch (err) {
                    console.error(`Erreur avec la version ${version}:`, err);
                }
            }
            debugInfo.innerHTML += `<p>Impossible de générer le QR Code. Essayez de réduire la quantité d'informations.</p>`;
        }

        tryGenerateQR();
    });
    </script>
</body>

</html>