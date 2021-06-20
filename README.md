<h1>CRUD CLIENTES</h1>

>status: Developing ⚠️



## Comentários



Primeiro projeto utilizando a linguagem de progamação PHP.

## FUNCIONABILIDADE

Implementação de um CRUD, acrônimo para as quatro operações básicas de um Bando de Dados : CREATE(Criar), READ(Ler), UPDATE(Atualizar) e DELETE(Excluir), desenvolvido a partir da 
linguagem de progamção PHP e o SGBD MySQL. Com a finalidade de criar um cadastro de clientes é alimentado com os seguintes atributos:
+ Nome
+ CPF
+ Data de Nascimento
+ E-mail
+ Endereço
  + Logradouro
  + Número
  + Bairro
  + Cidade
  + UF
  + CEP

O cadastro dos atributos referentes ao "Endereço", são preenchidos a partir do consumo da API dos correios "ViaCep".

## Aplicação

layout do modelo em aplicação:
![CRUDphp](https://user-images.githubusercontent.com/79478309/122689527-9dd55d80-d1f9-11eb-95f9-aaa39c305eb4.jpeg)

## Tecnologias Utilizadas
<table>
  <tr>
    <td>PHP</td>
    <td>MySQL</td>
    <td>WampServer</td>
    <td>ViaCep</td>
  </tr>
  <tr>
    <td>8.1.0</td>
    <td>8.0.21</td>
    <td>3.2.0</td>
    <td>Json</td>
  </tr>
</table>

## Instruções
Para aplicação do projeto é necessário a utilização dos scripts localizados em:
- [Versão Final](https://github.com/JoseTeixeiraMendesJunior/CRUD-php/tree/main/C%C3%B3digo/Vers%C3%A3o%20Final)

Foi necessário habilitar o driver do PDO, acessando o arquivo **php.ini**, que se encontra no diretório onde foi instalado o php.
Para não ser necessária a alteração nos scripts a estrtutura do banco de dados pode ser construída a partir dos seguindos comandos:


**1)** 

CREATE DATABASE crudphp


default character set utf8


default collate utf8_general_ci;

**2)**


CREATE TABLE clientes (


id INT NOT NULL AUTO_INCREMENT,


nome VARCHAR(40) NOT NULL,


cpf CHAR(11) UNIQUE NOT NULL,


datanasc DATE NOT NULL,


email VARCHAR(40) NOT NULL,


logradouro VARCHAR(100) NOT NULL,


numero VARCHAR(5) NOT NULL,


bairro VARCHAR(50) NOT NULL,


cidade VARCHAR(50) NOT NULL,


uf CHAR(2) NOT NULL,


cep CHAR(9) NOT NULL,


PRIMARY KEY (id)


);


- [Esquema do Banco de Dados crudphp](- [Versão Final](https://github.com/JoseTeixeiraMendesJunior/CRUD-php/tree/main/C%C3%B3digo/Vers%C3%A3o%20Final))

## Observações
⚠️ O código no momento apresenta um problema de execução! ⚠️


Ao tentar alterar os dados cadastrados em um cliente já registrado na base de dados, era esperado que os dados atuais completasse, automaticamente os campos de registros, porém os campos destinados aos dados de endereço não são atualizados, portanto deve-se tomar cuidado, pois se realizar uma **consulta** a um CEP enquanto estiver na aba para alteração de dados, esta será atualizada e redirecionada a página inicial de inserção de novos registros!
