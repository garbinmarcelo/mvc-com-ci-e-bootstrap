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