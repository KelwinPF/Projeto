<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function get_user($user_nom){
		$this->db->where('user_nome',$user_nom);
		$query = $this->db->get('user',1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->user_nome;
		else:
			return false; 
		endif;
	}
	public function get_verify_user($id,$user_nom){
		$this->db->where('id_user',$id);
		$this->db->where_not_in('user_nome',$user_nom);
		$query = $this->db->get('user',1);
		if($query->num_rows() == 0):
			return 1;
		else:
			return 0; 
		endif;
	}

	public function get_id_user($user_nom){
		$this->db->where('user_nome',$user_nom);
		$query = $this->db->get('user',1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->id_user;
		else:
			return false; 
		endif;
	}

	public function get_email($user_nome){
		$this->db->where('user_nome',$user_nome);
		$query = $this->db->get('user',1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->email;
		else:
			return null; 
		endif;
	}

	public function get_senha($user_nome){
		$this->db->where('user_nome',$user_nome);
		$query = $this->db->get('user',1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->senha;
		else:
			return null; 
		endif;
	}

	public function insert_user($user_name,$email,$senha){
			$dados = array(
				'user_nome' => $user_name,
				'email' => $email,
				'senha' => $senha
			);
			$this->db->insert('user',$dados);
			return $this->db->insert_id();
	}

	public function update($user_antigo,$email_novo){
			$this->db->set('email',$email_novo);
			$this->db->where('user_nome',$user_antigo);
			$this->db->update('user');
			return true;
	}
	public function update_nome($user_antigo,$user_novo){
			$this->db->set('user_nome',$user_novo);
			$this->db->where('user_nome',$user_antigo);
			$this->db->update('user');
			return true;
	}

	public function get_qtd(){
		$this->db->select('*');
		$query = $this->db->get('user');
		if($query->num_rows() > 0):
			$row = $query->row();
			return true;
		else:
			return false; 
		endif;
	}

	public function get_qtd_empresa(){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return 0; 
		endif;
	}

	public function get_ult_empresa(){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$this->db->order_by('data', 'asc');
		$query = $this->db->get('empresa',1);
		if($query->num_rows() > 0):
			$row = $query->row();
			return $row->nome;
		else:
			return 'Sem empresa cadastrada'; 
		endif;
	}

	public function get_count_empresa(){
		$this->db->select('id_empresa,COUNT(id_empresa) as total');
		$this->db->where('ativo',1);
 		$this->db->group_by('id_empresa'); 
 		$this->db->order_by('total', 'desc'); 
		$query = $this->db->get('colaborador',1);
		if($query->num_rows() > 0):
			$row = $query->row();
			return $row->id_empresa;
		else:
			return null; 
		endif;
	}
		public function get_ult_colaborador(){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$this->db->order_by('data', 'asc');
		$query = $this->db->get('colaborador',1);
		if($query->num_rows() > 0):
			$row = $query->row();
			return $row->nome;
		else:
			return 'Sem colaborador cadastrado'; 
		endif;
	}

	public function get_allnome_empresa(){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return false; 
		endif;
	}

	public function get_id_empresa($nome){
		$this->db->select('*');
		$this->db->where('nome',$nome);
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa');
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->id_empresa;
		else:
			return null; 
		endif;
	}

	public function get_id_colaborador($nome){
		$this->db->select('*');
		$this->db->where('nome',$nome);
		$this->db->where('ativo',1);
		$query = $this->db->get('colaborador');
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->id_colaborador;
		else:
			return null; 
		endif;
	}

	public function get_id_col_empresa($id){
		$this->db->select('*');
		$this->db->where('id_colaborador',$id);
		$this->db->where('ativo',1);
		$query = $this->db->get('colaborador');
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->id_empresa;
		else:
			return null; 
		endif;
	}

	public function get_id_cnpj_empresa($cnpj){
		$this->db->select('*');
		$this->db->where('cnpj',$cnpj);
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa');
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->id_empresa;
		else:
			return null; 
		endif;
	}


	public function get_id_cpf_colaborador($cpf){
		$this->db->select('*');
		$this->db->where('cpf',$cpf);
		$this->db->where('ativo',1);
		$query = $this->db->get('colaborador',1);
		if($query->num_rows() > 0):
			$row = $query->row();
			return $row->id_colaborador;
		else:
			return null; 
		endif;
	}


	public function get_qtd_colaborador(){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$query = $this->db->get('colaborador');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return 0; 
		endif;
	}


	public function get_all_empresas($qtde = 0,$inicio = 0){
		$this->db->where('ativo',1);
		if($qtde>0) $this->db->limit($qtde,$inicio);
		$query = $this->db->get('empresa');
		return $query->result();
	}

	public function get_qtd_pesquisa_colaborador($pesquisa){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$this->db->group_start();
		$this->db->like('nome', $pesquisa);
		$this->db->or_like('cpf', $pesquisa);
		$this->db->group_end();
		$query = $this->db->get('colaborador');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return false; 
		endif;
	}
	public function get_pesquisa_empresas($pesquisa,$qtde = 0,$inicio = 0){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$this->db->group_start();
		$this->db->like('nome', $pesquisa);
		$this->db->or_like('cnpj', $pesquisa);
		$this->db->group_end();
		if($qtde>0) $this->db->limit($qtde,$inicio);
		$query = $this->db->get('empresa');
		return $query->result();
	}

	public function get_pesquisa_colaboradores($pesquisa,$qtde = 0,$inicio = 0){
		$this->db->select('colaborador.nome AS colaborador_nome,colaborador.email,colaborador.sexo,colaborador.data,colaborador.id_colaborador,colaborador.CPF,colaborador.id_empresa,empresa.nome AS empresa_nome')->from('colaborador')->join('empresa', 'colaborador.id_empresa = empresa.id_empresa');
		$this->db->where('colaborador.ativo',1);
		$this->db->group_start();
		$this->db->like('colaborador.nome', $pesquisa);
		$this->db->or_like('colaborador.cpf', $pesquisa);
		$this->db->group_end();
		if($qtde>0) $this->db->limit($qtde,$inicio);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_qtd_pesquisa_empresa($pesquisa){
		$this->db->select('*');
		$this->db->where('ativo',1);
		$this->db->group_start();
		$this->db->like('nome', $pesquisa);
		$this->db->or_like('cnpj', $pesquisa);
		$this->db->group_end();
		$query = $this->db->get('empresa');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return false; 
		endif;
	}

	public function get_all_colaboradores($qtde = 0,$inicio = 0){
		$this->db->select('colaborador.nome AS colaborador_nome,colaborador.email,colaborador.sexo,colaborador.data,colaborador.id_colaborador,colaborador.CPF,colaborador.id_empresa,empresa.nome AS empresa_nome')->from('colaborador')->join('empresa', 'colaborador.id_empresa = empresa.id_empresa');
		$this->db->where('colaborador.ativo',1);
		if($qtde>0) $this->db->limit($qtde,$inicio);
		$query = $this->db->get();
		return $query->result();
	}  

	public function delete_empresa($id = 0){
		$this->db->where('id_empresa',$id);
		$this->db->set('ativo',0);
		$this->db->update('empresa');
		return true;
	}

	public function delete_empresa_col($id = 0){
		$this->db->where('id_empresa',$id);
		$this->db->set('ativo',0);
		$this->db->update('colaborador');
		return true;
	}

	public function delete_colaborador($id = 0){
		$this->db->where('id_colaborador',$id);
		$this->db->set('ativo',0);
		$this->db->update('colaborador');
		return true;
	}
	public function update_colaborador($id,$nome,$email,$cpf,$sexo,$empresa){

		$this->db->set('nome',$nome);
		$this->db->set('email',$email);
		$this->db->set('sexo',$sexo);
		$this->db->set('cpf',$cpf);
		$this->db->set('id_empresa',$empresa);
		$this->db->where('id_colaborador', $id);
		$this->db->update('colaborador');
		return true;
	}
	public function update_empresa($id,$nome,$email,$cnpj){

		$this->db->set('nome',$nome);
		$this->db->set('email',$email);
		$this->db->set('cnpj',$cnpj);
		$this->db->where('id_empresa', $id);
		$this->db->update('empresa');
		return true;
	}
	public function insert_empresa($nome,$email,$cnpj){
		$dados = array(
				'nome' => $nome,
				'email' => $email,
				'cnpj' => $cnpj,
				'ativo' => 1,
			);
			$this->db->insert('empresa',$dados);
			return $this->db->insert_id();
	}

	public function insert_colaborador($nome,$email,$cpf,$sexo,$id_empresa){
		$dados = array(
				'nome' => $nome,
				'email' => $email,
				'cpf' => $cpf,
				'sexo' => $sexo,
				'id_empresa' => $id_empresa,
				'ativo' => 1,
			);
			$this->db->insert('colaborador',$dados);
			return $this->db->insert_id();
	}

	public function buscar_colaborador($id,$qtde,$inicio){
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		if($qtde>0) $this->db->limit($qtde,$inicio);
		$query = $this->db->get('colaborador');
		return $query->result();
	}

	public function buscar_mulheres_empresa($id,$qtde,$inicio){
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		$this->db->where('sexo','Feminino');
		if($qtde>0) $this->db->limit($qtde,$inicio);
		$query = $this->db->get('colaborador');
		return $query->result();
	}


	public function buscar_mulheres(){
		$this->db->select('colaborador.nome AS colaborador_nome,colaborador.email,colaborador.sexo,colaborador.data,colaborador.id_colaborador,colaborador.CPF,colaborador.id_empresa,empresa.nome AS empresa_nome')->from('colaborador')->join('empresa', 'colaborador.id_empresa = empresa.id_empresa');
		$this->db->where('colaborador.ativo',1);
		$this->db->where('colaborador.sexo','Feminino');
		$query = $this->db->get();
		return $query->result();
	}

	public function pesquisa_colaborador($pesquisa,$id,$qtde,$inicio){
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		$this->db->group_start();
		$this->db->like('nome', $pesquisa);
		$this->db->or_like('cpf', $pesquisa);
		$this->db->group_end();
		if($qtde>0) $this->db->limit($qtde,$inicio);
		$query = $this->db->get('colaborador');
		return $query->result();
	}

	public function get_colaborador($id){
		$this->db->where('id_colaborador',$id);
		$this->db->where('ativo',1);
		$query = $this->db->get('colaborador',1);
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return false; 
		endif;
	}

	public function get_empresa($id){
		$this->db->select('*');
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa',1);
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return false; 
		endif;
	}

	public function get_n_empresa($id){
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa',1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row->nome;
		else:
			return null; 
		endif;
	}

	public function get_verify_empresa($id,$nome){
		$this->db->where('nome',$nome);
		$this->db->where('ativo',1);
		$this->db->where_not_in('id_empresa',$id);
		$query = $this->db->get('empresa');
		if($query->num_rows() == 0):
			return 1;
		else:
			return 0;
		endif;
	}
		public function get_verify_new_empresa($nome){
		$this->db->where('nome',$nome);
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa');
		if($query->num_rows() == 0):
			return true;
		else:
			return false;
		endif;
	}
	public function get_verify_colaborador($id,$nome){
		$this->db->where('nome',$nome);
		$this->db->where('ativo',1);
		$this->db->where_not_in('id_colaborador',$id);
		$query = $this->db->get('colaborador');
		if($query->num_rows() == 0):
			return 1;
		else:
			return 0;
		endif;
	}

	public function get_verify_cnpj_empresa($id,$cnpj){
		$this->db->where('cnpj',$cnpj);
		$this->db->where('ativo',1);
		$this->db->where_not_in('id_empresa',$id);
		$query = $this->db->get('empresa');
		if($query->num_rows() == 0):
			return 1;
		else:
			return 0; 
		endif;
	}

	public function get_verify_new_cnpj_empresa($cnpj){
		$this->db->where('cnpj',$cnpj);
		$this->db->where('ativo',1);
		$query = $this->db->get('empresa');
		if($query->num_rows() == 0):
			return true;
		else:
			return false; 
		endif;
	}

	public function get_verify_cpf_colaborador($id,$cpf){
		$this->db->where('cpf',$cpf);
		$this->db->where('ativo',1);
		$this->db->where_not_in('id_colaborador',$id);
		$query = $this->db->get('colaborador');
		if($query->num_rows() == 0):
			return true;
		else:
			return false; 
		endif;
	}
		public function get_verify_new_cpf_colaborador($cpf){
		$this->db->where('cpf',$cpf);
		$this->db->where('ativo',1);
		$query = $this->db->get('colaborador');
		if($query->num_rows() == 0):
			return true;
		else:
			return false; 
		endif;
	}

	public function get_qtd_empcol($id){
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		$query = $this->db->get('colaborador');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return 0; 
		endif;
	}

	public function get_qtd_empfemale($id){
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		$this->db->where('sexo','Feminino');
		$query = $this->db->get('colaborador');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return 0; 
		endif;
	}

		public function get_qtd_female(){
		$this->db->where('ativo',1);
		$this->db->where('sexo','Feminino');
		$query = $this->db->get('colaborador');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return 0; 
		endif;
	}

	public function get_qtd_pesquisa_empcol($pesquisa,$id){
		$this->db->where('id_empresa',$id);
		$this->db->where('ativo',1);
		$this->db->group_start();
		$this->db->like('nome', $pesquisa);
		$this->db->or_like('cpf', $pesquisa);
		$this->db->group_end();
		$query = $this->db->get('colaborador');
		if($query->num_rows() > 0):
			return $query->num_rows();
		else:
			return 0; 
		endif;
	}

}