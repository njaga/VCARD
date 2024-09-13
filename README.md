# VCARD - Générateur de QR Code pour Enregistrement de Contact

## Description

VCARD est une application simple permettant de générer un QR code pour faciliter l'enregistrement d'un contact. Les utilisateurs peuvent saisir des informations telles que le nom, le numéro de téléphone, l'email, et d'autres détails, puis générer un QR code compatible avec les carnets d'adresses des smartphones.

## Technologies utilisées

- **PHP** : Pour le backend et la génération du QR code.
- **JavaScript** : Pour l'interaction utilisateur et la prévisualisation en temps réel.
- **CSS** : Pour le style et la mise en page.
- **Bibliothèque QR Code** : Utilisée pour la génération du QR code.

## Fonctionnalités

- Formulaire permettant d'entrer les informations du contact (nom, téléphone, email, etc.).
- Génération dynamique du QR code basé sur les informations saisies.
- Possibilité de télécharger le QR code généré.

## Installation

### Prérequis

- Un serveur web avec PHP installé (Apache, Nginx, etc.).
- Une bibliothèque PHP pour la génération de QR codes (par exemple, `phpqrcode`).

### Étapes d'installation

1. Clonez le dépôt GitHub :
   ```bash
   git clone https://github.com/njaga/VCARD
   ```

2. Placez les fichiers dans un répertoire accessible par votre serveur web.

3. Accédez à l'application dans votre navigateur pour générer des QR codes.

## Utilisation

1. Ouvrez l'application via un navigateur.
2. Remplissez le formulaire avec les informations du contact.
3. Cliquez sur "Générer le QR Code".
4. Téléchargez ou scannez le QR code pour enregistrer le contact.

## Exemple d'Utilisation

Supposons que vous entrez les informations suivantes :

- **Nom** : Jane Doe
- **Numéro** : +221 77 654 32 10
- **Email** : janedoe@example.com

Un QR code sera généré, que vous pourrez scanner avec un smartphone pour ajouter directement ce contact à vos contacts.

## Auteur

Développé par [Ton Nom] avec l'intention de simplifier l'enregistrement de contacts via des QR codes.

## Licence

Ce projet est sous licence MIT. Veuillez consulter le fichier `LICENSE` pour plus d'informations.
