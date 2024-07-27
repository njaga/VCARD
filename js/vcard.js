document.getElementById('vcard-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(document.getElementById('vcard-form'));

    fetch('upload_vcard.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            QRCode.toDataURL(data.url, { errorCorrectionLevel: 'H' }, function (err, url) {
                if (err) throw err;

                const img = document.createElement('img');
                img.src = url;
                const qrcodeContainer = document.getElementById('qrcode');
                qrcodeContainer.innerHTML = '';
                qrcodeContainer.appendChild(img);
            });
        } else {
            alert('Erreur lors de la création de la vCard.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
