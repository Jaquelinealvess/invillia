Orientações de Instalação e uso 
============================== 

Para realizar a instalação é necessário ter o Docker rodando no host. 

O Docker pode ser baixado no link abaixo. 

[Docker](https://www.docker.com/) 

 
 
 Iniciando os containers 
-------------- 

Para que os testes rodem normalmente siga os passos descritos abaixo: 

 * Com o terminal entre na pasta Docker. 
 * Execute o comando *docker-composer up -d*. 
 * Aguarde a mensagem de *ok* informando que os containers foram iniciados. 
 
 

Métodos Disponíveis 
-------------- 

* 1: GET / - Página web de acesso público para importação dos arquivos XML. 
* 2: POST /user/create - Método público de cadastro de usuários para a autenticação da api. Deve informar *username* e *password* na requisição. 
* 3: GET /api/people - Método protegido por autenticação para listar people importadas. 
* 4: GET /api/people/{id} - Método protegido por autenticação para mostrar uma person. 
* 5: GET /api/shiporders - Método protegido por autenticação que lista todos os shiporders. 
* 6: GET /api/shiporders/id/{id} - Método protegido por autenticação que mostra um shiporder. 
* 7: GET /api/shiporders/person/{id} - Método protegido por autenticação que mostra os shiporders de uma person. 

 
 
Ferramenta de Teste 
--------------- 

* Postman - Para todos os métodos protegidos por autenticação deve utilizar a configuração *Autorization:* *type: Basic Auth*, mais um *username* e *password* cadastrado com o método 2.  
 
 

Observação 
--------------- 

Já existe um usuário cadastrado com username teste e password teste. 