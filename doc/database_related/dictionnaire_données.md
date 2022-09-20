# Dictionnaire de données

## USER

| Champs | Type | Spécificités | Description |
|--|--|--|--|
| id | int | PRIMARY_KEY, NOT_NULL, AUTO_INCREMENT | Identifiant de l'utilisateur |
| username | VARCHAR(65) | NOT_NULL | Pseudo de l'utilisateur |
| email | VARCHAR(65) | NOT_NULL | Email de l'utilisateur |
| password | VARCHAR(65) | NOT_NULL | Email de l'utilisateur |
| slug | VARCHAR(255) | NOT_NULL | Email de l'utilisateur |

## POST

| Champs | Type | Spécificités | Description |
|--|--|--|--|
| id | int | PRIMARY_KEY, NOT_NULL, AUTO_INCREMENT | Identifiant du post |
| title | VARCHAR(65) | NOT_NULL | Titre du post |
| content | LONGTEXT | NOT_NULL | Contenu du post |
| created_at | DATETIME | NOT_NULL | Date de création du post |

## COMMENT

| Champs | Type | Spécificités | Description |
|--|--|--|--|
| id | int | PRIMARY_KEY, NOT_NULL, AUTO_INCREMENT | Identifiant du commentaire |
| content | LONGTEXT | NOT_NULL | Contenu du commentaire |
| created_at | DATETIME | NOT_NULL | Date de création du commentaire |

