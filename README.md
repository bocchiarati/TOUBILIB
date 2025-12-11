# Projet TOUBILIB
## CONTRIBUTEURS :
### TULINE LEVEQUE (tuline-leveque) & SOFIEN CHERCHARI (bocchiarati)

## ACCEDER AU PROJET :
### 1 - Lancer la commande docker "docker compose up"
### 2 - Aller sur le lien "127.0.0.1:6080" pour acceder à l'api (les differentes routes y sont renseignees)
### 3 - Acceder a la BDD grace au port "8080"

## Liste des routes existantes :
#### GET /praticiens => acceder a la liste des praticiens (QueryParams : ville, scpecialite)
#### GET /praticiens/{id_prat} => detail d'un praticien en renseignant son id
#### GET /praticiens/{id_prat}/rdvs => obtenir les rendez-vous d'un praticien
#### GET /praticiens/{id_prat}/rdvs/{rdv_id} => acceder au detail d'un rendez-vous (un parametre de debut 'date_debut' et de fin 'date_fin' peuvent etre ajoutes en queryParams)
#### POST /praticiens/{id_prat}/rdvs => creer un rendez-vous (exemple : /praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/rdvs?duree=30&date_heure_debut=2025-10-07 15:00:00&date_heure_fin=2025-10-07 15:30:00&id_pat=d975aca7-50c5-3d16-b211-cf7d302cba50)
#### POST /signin => se connecter
#### DELETE /praticiens/{id_prat}/rdvs/{id_rdv} => annuler un rendez-vous
