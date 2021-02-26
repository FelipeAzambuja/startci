<?php
table('clientes')->create([
    'nome' => 'text',
    'telefone' => 'text',
    'idade' => 'int',
]);
$faker = faker();
table('pessoas')->insert([
    'nome' => 'Felipe',
    'telefone' => '',
    'idade' => '',
]);
