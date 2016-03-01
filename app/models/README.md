Les noms des attributs doivent être EXACTEMENT les mêmes qu'en base de données.  
Les getters/setters doivent être de la forme getAttribut_un() ou setAttribut_un($attribut_un) avec 'attribut_un' une colonne dans la table, en base de données.
Les modèles doivent aussi hériter de 'Model' (pas d'include() ou de require() à faire) et toujours faire appel au constructeur et au destructeur du parent.