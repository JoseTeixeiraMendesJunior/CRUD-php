<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['confirmcep']) ) {
    $adress = getAddres();
} else {
    $adress = addresEmpty();
}

 
// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['cadastrar'])) {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $cpf = (isset($_POST["cpf"]) && $_POST["cpf"] != null) ? $_POST["cpf"] : "";
    $datanasc = (isset($_POST["datanasc"]) && $_POST["datanasc"] != null) ? $_POST["datanasc"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $cep = (isset($_POST["cep"]) && $_POST["cep"] != null) ? $_POST["cep"] : "";
    $logradouro = (isset($_POST["logradouro"]) && $_POST["logradouro"] != null) ? $_POST["logradouro"] : "";
    $numero = (isset($_POST["numero"]) && $_POST["numero"] != null) ? $_POST["numero"] : "";
    $bairro = (isset($_POST["bairro"]) && $_POST["bairro"] != null) ? $_POST["bairro"] : "";
    $cidade = (isset($_POST["cidade"]) && $_POST["cidade"] != null) ? $_POST["cidade"] : "";
    $uf = (isset($_POST["uf"]) && $_POST["uf"] != null) ? $_POST["uf"] : "";


} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $cpf = NULL;
    $datanasc = NULL;
    $email = NULL;
    $cep = NULL;
    $logradouro = NULL;
    $numero = NULL;
    $bairro = NULL;
    $cidade = NULL;
    $uf = NULL;

}
 
// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost;dbname=crudphp", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão:".$erro->getMessage();
}
 
// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE clientes SET nome=?, cpf=?, datanasc=?, email=?, logradouro =?, numero =?, bairro =?, cidade=?, uf=?, cep=? WHERE id = ?");
            $stmt->bindParam(11, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO clientes (nome, cpf, datanasc, email, logradouro, numero, bairro, cidade, uf, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? ,?)");
        }
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $cpf);
        $stmt->bindParam(3, $datanasc);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $logradouro);
        $stmt->bindParam(6, $numero);
        $stmt->bindParam(7, $bairro);
        $stmt->bindParam(8, $cidade);
        $stmt->bindParam(9, $uf);
        $stmt->bindParam(10, $cep);
 
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
                $id = null;
                $nome = null;
                $cpf = null;
                $datanasc = null;
                $email = null;
                $logradouro = null;
                $numero = null;
                $bairro = null;
                $cidade = null;
                $uf = null;
                $cep = null;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
 
// Bloco if que recupera as informações no formulário, etapa utilizada pelo Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nome = $rs->nome;
            $cpf = $rs->cpf;
            $datanasc = $rs->datanasc;
            $email = $rs->email;
            $logradouro = $rs->logradouro;
            $numero = $rs->numero;
            $bairro = $rs->bairro;
            $cidade = $rs->cidade;
            $uf = $rs->uf;
            $cep = $rs->cep;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
 
// Bloco if utilizado pela etapa Delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Registo foi excluído com êxito";
            $id = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
?>

<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Cadastro de Clientes</title>
        </head>
        <body>
        
            <form action="?act=save" method="POST" name="form1" >
                <h1>Cadastro dados cliente</h1>
                <hr>
                CEP:
               <input type="text" name="cep" value="<?php echo $adress->cep ?>" <?php
 
               if (isset($cep) && $cep != null || $cep != "") {
                   echo "value=\"{$cep}\"";
               }
               ?> />
               <input type="submit" value="consultar" name="confirmcep" />
               <hr>
               Logradouro:
               <input type="text" name="logradouro" value="<?php echo $adress->logradouro ?>" <?php
 
               if (isset($logradouro) && $logradouro != null || $logradouro != "") {
                   echo "value=\"{$logradouro}\"";
               }
               ?> />
               Número:
               <input type="text" name="numero" placeholder="ex:(123) ou (SN)" <?php
 
               if (isset($numero) && $numero != null || $numero != "") {
                   echo "value=\"{$numero}\"";
               }
               ?> />
               Bairro:
               <input type="text" name="bairro" value="<?php echo $adress->bairro ?>"<?php
 
                if (isset($bairro) && $bairro != null || $bairro != "") {
                echo "value=\"{$bairro}\"";
                }
                ?> />
                Cidade:
               <input type="text" name="cidade" value="<?php echo $adress->localidade ?>"<?php
 
                if (isset($cidade) && $cidade != null || $cidade != "") {
                echo "value=\"{$cidade}\"";
                }
                ?> />
                UF:
               <input type="text" name="uf" value="<?php echo $adress->uf?>" <?php
 
                if (isset($uf) && $uf != null || $uf != "") {
                echo "value=\"{$uf}\"";
                }
                ?> />
               <hr>
                <input type="hidden" name="id" <?php
                 
                // Preenche o id no campo id com um valor "value"
                if (isset($id) && $id != null || $id != "") {
                    echo "value=\"{$id}\"";
                }
                ?> />
                Nome:
               <input type="text" name="nome" <?php
 
               // Preenche o nome no campo nome com um valor "value"
               if (isset($nome) && $nome != null || $nome != "") {
                   echo "value=\"{$nome}\"";
               }
               ?> />
                Cpf:
               <input type="text" name="cpf" <?php

               if (isset($cpf) && $cpf != null || $cpf != "") {
                   echo "value=\"{$cpf}\"";
               }
               ?> />
               Data de Nascimento:
               <input type="text" name="datanasc" placeholder="AAAAMMDD" <?php

               if (isset($datanasc) && $datanasc != null || $datanasc != "") {
                   echo "value=\"{$datanasc}\"";
               }
               ?> />
               E-mail:
               <input type="text" name="email" <?php
 
               // Preenche o email no campo email com um valor "value"
               if (isset($email) && $email != null || $email != "") {
                   echo "value=\"{$email}\"";
               }
               ?> />
               <hr>
               
               <input type="submit" value="salvar" name="cadastrar" />
               <hr>
            </form>
            <table border="1" width="100%">
                <tr>
                    <th>Nome</th>
                    <th>Cpf</th>
                    <th>Data de Nascimento</th>
                    <th>E-mail</th>
                    <th>Logadouro</th>
                    <th>Número</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>CEP</th>
                    <th>Ações</th>
                </tr>
                <?php
 
                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                try {
                    $stmt = $conexao->prepare("SELECT * FROM clientes");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>".$rs->nome."</td><td>".$rs->cpf."</td><td>".$rs->datanasc."</td><td>".$rs->email."</td><td>".$rs->logradouro."</td><td>".$rs->numero."</td><td>".$rs->bairro."</td><td>".$rs->cidade."</td><td>".$rs->uf."</td><td>".$rs->cep
                                       ."</td><td><center><a href=\"?act=upd&id=".$rs->id."\">[Alterar]</a>"
                                       ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                       ."<a href=\"?act=del&id=".$rs->id."\">[Excluir]</a></center></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Erro: Não foi possível recuperar os dados do banco de dados";
                    }
                } catch (PDOException $erro) {
                    echo "Erro: ".$erro->getMessage();
                }
                ?>
            </table>
        </body>
    </html>