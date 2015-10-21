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