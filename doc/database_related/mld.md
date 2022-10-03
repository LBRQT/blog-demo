# MLD

---
## Légende

<span style="color:lightgreen"> Table </span> |
<span style="color:lightblue"> Primary Key </span> |
<span style="color:pink"> Foreign Key </span>

---

<span style="color:lightgreen"> USER </span>
<span style="color:lightblue"> code_user </span> |
<span style="color:pink"> code_post </span> |
username | email | password |

---

<span style="color:lightgreen"> POST </span> |
<span style="color:lightblue"> code_post </span> |
<span style="color:pink"> code_user </span> |
title | content | created_at

---

<span style="color:lightgreen"> COMMENT </span> |
<span style="color:lightblue"> code_comment </span> |
<span style="color:pink"> code_user </span> |
<span style="color:pink"> code_post </span> | 
content |



