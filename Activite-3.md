# Soumettez : a%' or 1 = 1 ; --
  
Injection SQL
Ce qui est saisi dans le champ est récupéré par une variable($leNom).
Et cette variable est utilisée dans la requête SQL : LIKE '$leNom'.

=> LIKE 'a%' or 1 = 1 ; --
or comme il y a un ";" ce qui suit ne sera pas pris en compte
=> erreur