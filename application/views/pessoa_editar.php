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