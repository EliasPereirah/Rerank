# Exemplo Rerank Usando Cohere - PHP
O que é rerank em busca?
Em sistemas de busca, rerank, ou re-ranqueamento, é o processo de refinar a ordem dos resultados da busca inicial, aplicando algoritmos adicionais para melhorar a relevância e a qualidade da lista final apresentada ao usuário.

## Exemplo usando Cohere
```php
<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/vendor/autoload.php";

$Cohere = new \App\Cohere();

// Supondo que tenha feita uma busca no banco de dados e tenha retornado esses resultados
$query = 'Onde você mora hoje?'; // termo de busca

$docs = [
    'Hoje eu fui ver você.',
    'Ela mora em Angola',
    'Eu moro na minha casa',
    'Eu sou do Brasil.',
    'Hoje eu acordei cedo'
]; // exemplo de possível resultados de busca, seja de uma base SQL, vetorial ou hibrido


$data = $Cohere->rerank($query, $docs); // faz rerank retornado os resultados por relevância
$results = $data['result']->results;
foreach ($results as $score) {
    $text = $docs[$score->index];
    echo "id:{$score->index} => {$text}<hr>";
}
?>
```

Imprime:

```txt
id:3 => Eu sou do Brasil.
id:2 => Eu moro na minha casa
id:1 => Ela mora em Angola
id:0 => Hoje eu fui ver você.
id:4 => Hoje eu acordei cedo
```
