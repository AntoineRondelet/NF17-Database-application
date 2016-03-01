Tous les controllers doivent s'appeller 'NomController.php' où 'Nom' est le nom de votre choix. Ils doivent aussi hériter de 'Controller' (pas d'include() ou de require() à faire) et implémenter la méthode

```php
public function execute($action = 'index') {
  ...
}
```