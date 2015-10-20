# PHP e MVC com CodeIgniter: Desenvolvimento Web com Framework
---
![CodeIgniter 3](https://github.com/marcelogarbin/mvc-com-ci-e-bootstrap/raw/master/assets/img/codeigniter-logo.png "CodeIgniter 3") ![Bootstrap 3](https://github.com/marcelogarbin/mvc-com-ci-e-bootstrap/raw/master/assets/img/bootstrap-logo.png "Bootstrap 3")

Neste minicurso veremos uma introdução ao framework CodeIgniter utilizando o padrão MVC (Model, View,
Controller) no desenvolvimento web e também teremos uma parte prática de como criar um CRUD
(Create, Read, Update e Delete),utilizando banco de dados MySQL.

### Objetivo
Primeiramente será apresentado o framework CodeIgniter, para que o aluno possa conhecer suas
principais características e funcionalidades que serão aproveitadas para a criação do CRUD.
Após o entendimento das principais funções do framework, será feita a explicação/prática do
funcionamento em MVC e desenvolvimento das funções para serem utilizadas, também será integrado na aplicação o framework Bootstrap, responsável pelo front-end.

### Requisitos Solicitados (Não obrigatórios):
  - HTML / CSS
  - Linguagem PHP (Básico)
  - Linguagem SQL (Básico)

### Softwares Utilizados:
- WAMPSERVER OU XAMPP: [Download WampServer](http://sourceforge.net/projects/wampserver/files/latest/download) OU
[Download Xampp](https://www.apachefriends.org/xampp-files/5.6.12/xampp-win32-5.6.12-0-VC11-installer.exe);
- CodeIgniter 3.0.2: [Download CodeIgniter 3.0.2](https://github.com/bcit-ci/CodeIgniter/archive/3.0.2.zip);
- CodeIgniter 3 Translations: [CodeIgniter 3 Translations](https://github.com/bcit-ci/codeigniter3-translations);
- Bootstrap 3.3.5: [Download Bootstrap 3.3.5](https://github.com/twbs/bootstrap/releases/download/v3.3.5/bootstrap-3.3.5-dist.zip);
- Editor para Desenvolvimento. _Sugestão: Sublime Text, Brackets, NetBeans IDE_

### Referências
BCIT, British Columbia Institute of Technology. __CodeIgniter User Guide__. Disponível em:
<[http://www.codeigniter.com/user_guide](http://www.codeigniter.com/user_guide)>

GABARDO, Ademir Cristiano. __PHP e MVC com CodeIgniter__. Novatec Editaroa Ltda, 2012.

Bootstrap. __Bootstrap 3 Examples__. Disponível em: <[http://getbootstrap.com/getting-started/#examples](http://getbootstrap.com/getting-started/#examples)>.

---
### Parte Teórica

### Parte Prática
Primeiramente vamos acessar a pasta __application__, nela se encontra a estrutura necessária para criarmos nosso CRUD.
Algumas pastas que vamos utilizar são: 
- __config__: Pasta responsável pelas configurações do sistema (banco de dados, rotas, configurações gerais, etc...);
- __controllers__: Camada responsável pela comunicação entre a camada de dados (models) e também pela camada de apresentação (views);
- __models__: Camada responsável pela comunicação entre o banco de dados;
- __views__: Camada responsável pela parte de apresentação, recebe dados do controller.

1. Acessar a o arquivo __application/config/config.php__, nesse arquivo vamos definir a __base_url__ (caminho completo da URL que se encontra o sistema) e também __language__ para definirmos a linguagem das mensagens que o CI irá apresentar. Para nossa aplicação iremos configurar somente esses dois parâmetros.
```php
$config['base_url'] = 'http://localhost/mvc-com-ci-e-bootstrap/';
$config['language'] = 'pt-br';
```
2. Acessar o arquivo __application/config/database.php__ e alterar as configurações de conexão com o BD.
```php
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'root',
	'database' => 'mvc_crud',
	'dbdriver' => 'mysqli',
	...
```

3. Acessar o arquivo __application/config/autoload.php__ e definir as bibliotecas e helpers que iremos carregar em nossa aplicação:
```php
$autoload['libraries'] = array('database', 'form_validation');
$autoload['helper'] = array('form');
```


4. Vamos criar os arquivos para as camadas: __controllers__, __models__ e __views__.
- Controller: __application/controllers/Pessoa.php__ _(Sempre a primeira letra do arquivo e da classe em maiuscula)_
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()	{
		$this->load->view('welcome_message');
	}
}
```