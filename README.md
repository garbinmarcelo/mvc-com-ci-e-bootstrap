# PHP e MVC com CodeIgniter: Desenvolvimento Web com Framework
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

#### Como funciona as chamadas para os controllers?
Essa parte é bastante importante e simples de compreender, pois é aqui que começamos a entender de onde os métodos são chamados.
Um controller nada mais é que uma classe com vários métodos, e um método é um procedimento a ser executado (Função).

Temos a seguinte URL: http://nome_do_projeto/index.php/controller/metodo/variavel

Como podemos ver, para chamar um método do controller, sempre devemos chamar o controller e posteriormente o método para ser executado, caso seja passado mais um parametro pela URL, o mesmo passa a informação ao método. Certo?...?... Vamos ao exemplo:

Temos a URL: http://nome_do_projeto/index.php/pessoa/editar/1

Nessa URL, estamos chamando o controller _pessoa_, que executa o método _editar_, que recebe o valor 1.

E se chamarmos somente o controller? Exemplo: http://nome_do_projeto/index.php/pessoa/

Quando se chama somente o controller, o método a ser chamado é o _index()_, porém caso não existir esse método na classe do controller, irá ocorrer um erro (404).

#### Começando...
1 - Acessar a o arquivo __application/config/config.php__, nesse arquivo vamos definir a __base_url__ (caminho completo da URL que se encontra o sistema) e também __language__ para definirmos a linguagem das mensagens que o CI irá apresentar. Para nossa aplicação iremos configurar somente esses dois parâmetros.
```php
$config['base_url'] = 'http://localhost/mvc-com-ci-e-bootstrap/';
$config['language'] = 'pt-br';
```

2 - Acessar o arquivo __application/config/database.php__ e alterar as configurações de conexão com o BD.
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

3 - Acessar o arquivo __application/config/autoload.php__ e definir as bibliotecas e helpers que iremos carregar em nossa aplicação:
```php
$autoload['libraries'] = array('database', 'form_validation', 'session');
$autoload['helper'] = array('url', 'form');
```


4 - Vamos criar os arquivos para as camadas: __controllers__, __models__ e __views__.

- Controller: __application/controllers/Pessoa.php__ _(Sempre a primeira letra do arquivo e da classe em maiuscula)_
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa extends CI_Controller {

	function __construct() {
        parent::__construct();
        // Carrega o model Pessoa
        $this->load->model('pessoa_model', 'PM');
    }

	public function index()	{
		// Busca as informações do model e passa para o array $data
		$data['registros'] = $this->PM->listar_pessoas();

		$this->load->view('template/header');
		$this->load->view('pessoa_cadastrar', $data); // array $data é passado para view pessoa_cadastrar
		$this->load->view('template/footer');
	}

	public function cadastrar(){
		// Seta as regras para validação do formulário
		$this->form_validation->set_rules('nome', '<strong>Nome</strong>', 'required|trim');
		$this->form_validation->set_rules('sobrenome', '<strong>Sobrenome</strong>', 'required|trim');
		$this->form_validation->set_rules('email', '<strong>E-mail</strong>', 'required|valid_email|trim');
		if($this->form_validation->run() === FALSE){
			$this->index();
		}else{
			// Se é feito o cadastro no bd é retornado true
			if($this->PM->cadastrar() === TRUE){
				$this->session->set_flashdata('mensagem', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Sucesso!</strong> Seu cadastro foi efetuado sem erros.</div>');
			}else{
				$this->session->set_flashdata('mensagem', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Erro!</strong> Seu cadastro não foi efetuado.</div>');
			}
			redirect('pessoa','refresh');
		}
	}

	public function editar($id_pessoa = NULL){
		if((isset($id_pessoa) && !empty($id_pessoa)) && ($this->PM->listar_pessoa($id_pessoa) !== NULL)){
			// Busca as informação da pessoa pelo id passado no parametro da funcao
			$data['registro'] = $this->PM->listar_pessoa($id_pessoa);

			$this->load->view('template/header');
			$this->load->view('pessoa_editar', $data);
			$this->load->view('template/footer');
		}else{
			redirect('pessoa','refresh');
		}
	}

	public function gravar_edicao(){
		$this->form_validation->set_rules('nome', '<strong>Nome</strong>', 'required|trim');
		$this->form_validation->set_rules('sobrenome', '<strong>Sobrenome</strong>', 'required|trim');
		$this->form_validation->set_rules('email', '<strong>E-mail</strong>', 'required|valid_email|trim');
		if($this->form_validation->run() === FALSE){
			$this->editar($this->input->post('id_pessoa'));
		}else{
			if($this->PM->gravar_edicao($this->input->post('id_pessoa')) === TRUE){
				$this->session->set_flashdata('mensagem', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Sucesso!</strong> Cadastro editado sem erros.</div>');
			}else{
				$this->session->set_flashdata('mensagem', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Erro!</strong> Não foi possível editar o cadastro.</div>');
			}
			redirect('pessoa','refresh');
		}
	}

	public function deletar($id_pessoal = NULL){
		if((isset($id_pessoal) && !empty($id_pessoal)) && ($this->PM->deletar($id_pessoal) === TRUE)){
			$this->session->set_flashdata('mensagem', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Sucesso!</strong> Cadastro deletado do banco de dados.</div>');
		}else{
			$this->session->set_flashdata('mensagem', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><span class="glyphicon glyphicon-ok"></span> Erro!</strong> Não foi possível deletar o cadastro.</div>');
		}
		redirect('pessoa','refresh');
	}

	public function sobre(){
		$this->load->view('template/header');
		$this->load->view('sobre');
		$this->load->view('template/footer');
	}
}
```

- Model: __application/models/Pessoa_model.php__ _(Sempre a primeira letra do arquivo e da classe em maiuscula)_
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function listar_pessoas(){
		return $this->db->get('pessoas')->result();
	}

	public function listar_pessoa($id_pessoa = NULL){
    	// Monta a consulta SQL e retorna um objeto
		return $this->db->get_where('pessoas', array('id_pessoa' => $id_pessoa))->row();
	}

	public function cadastrar(){
		$data['nome'] 		= $this->input->post('nome');
		$data['sobrenome']  = $this->input->post('sobrenome');
		$data['email'] 		= $this->input->post('email');

		$this->db->insert('pessoas', $data);

		if($this->db->affected_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function gravar_edicao($id_pessoa = NULL){
		if(isset($id_pessoa) && !empty($id_pessoa)){
			$data['nome'] 		= $this->input->post('nome');
			$data['sobrenome']  = $this->input->post('sobrenome');
			$data['email'] 		= $this->input->post('email');

			$this->db->update('pessoas', $data, array('id_pessoa' => $id_pessoa));

			if($this->db->affected_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function deletar($id_pessoa = NULL){
		if(isset($id_pessoa) && !empty($id_pessoa)){

			$this->db->delete('pessoas', array('id_pessoa' => $id_pessoa));

			if($this->db->affected_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

}
```

- View: __application/views/template/header.php__
```php
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MVC com CodeIgniter 3 e Bootstrap 3">
    <meta name="author" content="Marcelo Garbin">

    <title>PHP e MVC com CodeIgniter: Desenvolvimento Web com Framework</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-fire"></span> PHP e MVC com CodeIgniter e Bootstrap</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo base_url('sobre'); ?>"><span class="glyphicon glyphicon-star-empty"></span> Sobre</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Begin page content -->
    <div class="container">
```

- View: __application/views/template/footer.php__
```php
    </div>
    
    <footer class="footer">
      <div class="container">
        <p class="text-muted">PHP e MVC com CodeIgniter: Desenvolvimento Web com Framework</p>
      </div>
    </footer>
	<!-- Javascript -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
  </body>
</html>
```

- View: __application/views/pessoa_cadastrar.php__
```php
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="text-center">
      <img src="<?php echo base_url('assets/img/codeigniter-logo.png'); ?>" alt="CodeIgniter" />
    </div>
    <?php
      $atributos = array('class' => 'form-cadastro', 'id' => 'form-cadastro');
      echo form_open('pessoa/cadastrar', $atributos);
        echo form_fieldset('<span class="glyphicon glyphicon-user"></span> Cadastro de Pessoas');
        if(validation_errors()){
          echo '<div role="alert" class="alert alert-danger alert-dismissible fade in">';
          echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
          echo '<h4 id="erro_titulo">Ops! Verifique o seu formulário!</h4>';
          echo '<p>Encontramos algumas pendências no cadastro:</p>';
          echo '<ul class="Unordered">';
          echo validation_errors('<li>', '</li>');
          echo '</ul>';
          echo '</div>';
        }
        if($this->session->flashdata('mensagem')){echo $this->session->flashdata('mensagem');}
        echo '<div class="row">';
          echo '<div class="form-group col-sm-6"">';
            echo form_label('* Nome', 'nome');
            echo form_input(array('name' => 'nome', 'type' => 'text', 'placeholder' => 'Digite seu nome', 'class' => 'form-control', 'value' => set_value('nome')));
          echo '</div>';  
          echo '<div class="form-group col-md-6">';
            echo form_label('* Sobrenome', 'sobrenome');
            echo form_input(array('name' => 'sobrenome', 'type' => 'text', 'placeholder' => 'Digite seu sobrenome', 'class' => 'form-control', 'value' => set_value('sobrenome')));
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="form-group col-md-12">';
            echo form_label('* E-mail', 'email');
            echo form_input(array('name' => 'email', 'type' => 'email', 'placeholder' => 'Digite seu e-mail', 'class' => 'form-control', 'value' => set_value('email')));
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="col-md-12">';
            echo '<div class="pull-right">';
            echo form_button(array('name' => 'BtnLimpar', 'type' => 'reset', 'class' => 'btn btn-default btn-md'), '<span class="glyphicon glyphicon-repeat"></span> Limpar Campos');
            echo form_button(array('name' => 'BtnCadastrar', 'type' => 'submit', 'class' => 'btn btn-success btn-md'), '<span class="glyphicon glyphicon-ok"></span> Cadastrar');
            echo '</div>';
          echo '</div>';
        echo '</div>';
        echo form_fieldset_close();
      echo form_close();
    ?>
    <div class="registros">
      <h4><span class="glyphicon glyphicon-th-list"></span> Registros Cadastrado</h4>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Sobrenome</th>
              <th>Email</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if(count($registros) <= 0){
                echo '<tr>';
                echo '<td colspan="5" class="text-center">Nenhum registro encontrado</td>';
                echo '</tr>';
              }else{
                foreach ($registros as $registro) { 
            ?>
            <tr>
              <td class="text-center"><?php echo $registro->id_pessoa; ?></td>
              <td><?php echo $registro->nome; ?></td>
              <td><?php echo $registro->sobrenome; ?></td>
              <td><?php echo $registro->email; ?></td>
              <td width="150" class="text-center">
                <a href="<?php echo base_url('pessoa/deletar/'.$registro->id_pessoa); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Deletar registro?');"><span class="glyphicon glyphicon-trash"></span> Deletar</a>
                <a href="<?php echo base_url('pessoa/editar/'.$registro->id_pessoa); ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-edit"></span> Editar</a>
              </td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>
    </div>
  </div>
</div>
```

- View: __application/views/pessoa_editar.php__
```php
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <?php
      $atributos = array('class' => 'form-cadastro', 'id' => 'form-cadastro');
      $hidden    = array('id_pessoa' => $registro->id_pessoa);
      echo form_open('pessoa/gravar_edicao', $atributos, $hidden);
        echo form_fieldset('<span class="glyphicon glyphicon-user"></span> Editar Cadastro: #'.$registro->id_pessoa);
        if(validation_errors()){
          echo '<div role="alert" class="alert alert-danger alert-dismissible fade in">';
          echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>';
          echo '<h4 id="erro_titulo">Ops! Verifique o seu formulário!</h4>';
          echo '<p>Encontramos algumas pendências no cadastro:</p>';
          echo '<ul class="Unordered">';
          echo validation_errors('<li>', '</li>');
          echo '</ul>';
          echo '</div>';
        }
        if($this->session->flashdata('mensagem')){echo $this->session->flashdata('mensagem');}
        echo '<div class="row">';
          echo '<div class="form-group col-sm-6"">';
            echo form_label('* Nome', 'nome');
            echo form_input(array('name' => 'nome', 'type' => 'text', 'placeholder' => 'Digite seu nome', 'class' => 'form-control', 'value' => set_value('nome', $registro->nome)));
          echo '</div>';  
          echo '<div class="form-group col-md-6">';
            echo form_label('* Sobrenome', 'sobrenome');
            echo form_input(array('name' => 'sobrenome', 'type' => 'text', 'placeholder' => 'Digite seu sobrenome', 'class' => 'form-control', 'value' => set_value('sobrenome', $registro->sobrenome)));
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="form-group col-md-12">';
            echo form_label('* E-mail', 'email');
            echo form_input(array('name' => 'email', 'type' => 'email', 'placeholder' => 'Digite seu e-mail', 'class' => 'form-control', 'value' => set_value('email', $registro->email)));
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="col-md-12">';
            echo '<div class="pull-right">';
            echo form_button(array('name' => 'BtnCancelar', 'type' => 'button', 'class' => 'btn btn-default btn-md', 'onclick' => "location.href='".base_url('pessoa')."'"), '<span class="glyphicon glyphicon-arrow-left"></span> Cancelar');
            echo form_button(array('name' => 'BtnCadastrar', 'type' => 'submit', 'class' => 'btn btn-success btn-md'), '<span class="glyphicon glyphicon-edit"></span> Editar Cadastro');
            echo '</div>';
          echo '</div>';
        echo '</div>';
        echo form_fieldset_close();
      echo form_close();
    ?>
  </div>
</div>
```

- View: __application/views/sobre.php__
```php
<div class="row">
  <div class="col-md-12">
  	<h1><span class="glyphicon glyphicon-star-empty"></span> Sobre</h1>
  	<hr />
  	<div class="col-md-6 text-center">
      <img class="img-circle" src="<?php echo base_url('assets/img/marcelo.jpg'); ?>" alt="Marcelo Garbin" width="200" height="200">
      <h2><span class="glyphicon glyphicon-star-empty"></span> Marcelo Garbin <span class="glyphicon glyphicon-star-empty"></span></h2>
      <p>Cursando Especialização em Desenvolvimento Web, Cloud e Dispositivos Móveis pela Universidade do Oeste de Santa Catarina (UNOESC, 2015). Possui Graduação de Sistemas de Informação pela Universidade Federal de Santa Maria (UFSM, 2014), Técnico em Gerenciamento de Sistemas de Informação pela Escola Técnica Estadual 25 de Julho de Ijuí/RS. Atualmente é Sócio-proprietário da Nibrag Web Sistemas Planejados.</p>
      <p>Skype: marcelo.nibragweb</p>
      <p>E-mail: marcelo@nibragweb.com.br</p>
      <p><a href="http://lattes.cnpq.br/9667886691685779" title="Currículo Lattes" target="_blank">Currículo Lattes</a></p>
      <p><a class="btn btn-default" href="https://www.facebook.com/garbin.marcelo" role="button" target="_blank">Facebook »</a></p>
    </div>
    <div class="col-md-6 text-center">
      <img class="img-circle" src="<?php echo base_url('assets/img/dreslei.jpg'); ?>" alt="Dreslei Garbin Barcelos" width="200" height="200">
      <h2><span class="glyphicon glyphicon-star-empty"></span> Dreslei Garbin Barcelos <span class="glyphicon glyphicon-star-empty"></span></h2>
      <p>Graduação em andamento em Sistemas de Informação pela Universidade Federal de Santa Maria (UFSM).</p>
      <p><a class="btn btn-default" href="https://www.facebook.com/Dresleigb" role="button" target="_blank">Facebook »</a></p>
    </div>
  </div>
</div>
```

5 - Vamos criar o banco e a tabela no MySQL, podemos utilizar o phpMyAdmin para executar o seguinte código:
```sql
--
-- Database: `mvc_crud`
--
CREATE DATABASE IF NOT EXISTS `mvc_crud` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mvc_crud`;

--
-- Estrutura da tabela `pessoas`
--
DROP TABLE IF EXISTS `pessoas`;
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id_pessoa` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
```

6 - Vamos remover o index.php da URL, para isso precisamos verificar se o módulo _mod_rewrite_ está habilitado. No arquivo de configuração do Apache __httpd.conf__, verifique se o módulo _ modules/mod_rewrite.so_ está sem o # em sua linha. Se o mesmo estiver com o sinal de # em sua linha, remova, salve o arquivo e reinicia o Apache. Pronto, você habilitou o _mod_rewrite_.
Nosso próximo passo é criar um arquivo na raiz da nossa aplicação, crie um arquivo com o nome de __.htaccess__, dentro deste arquivo copie o código a seguir e salve o mesmo:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

7 - Teste sua aplicação sem o _index.php_ na url, exemplo:
```
Antes: http://localhost/mvc-com-ci-e-bootstrap/index.php/welcome/

Agora: http://localhost/mvc-com-ci-e-bootstrap/welcome/
```

8 - Vamos definir as rotas, acesse o arquivo __application/config/routes.php__, defina as rotas da seguinte forma:

```php
$route['default_controller'] = 'pessoa';
$route['sobre'] 		 	 = 'pessoa/sobre';
```

Dessa forma ao acessar o endereço padrão definido na base_url, sua aplicação ira abrir primeiramente o controller _pessoa_. Se você acessar o endereço _http://localhost/mvc-com-ci-e-bootstrap/sobre_, você ira ser direcionado para o controller _pessoa_ e posteriormente será executado o método _sobre_.