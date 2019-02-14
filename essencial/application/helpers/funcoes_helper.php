<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('set_msg')):

	function set_msg($msg=null){
		$ci = & get_instance();
		$ci->session->set_userdata('aviso',$msg);	
	}

endif;

if(!function_exists('get_msg')):
	function get_msg($destroy=true){
		$ci = & get_instance();
		$retorno = $ci->session->userdata('aviso');
		if($destroy) $ci->session->unset_userdata('aviso');
		return $retorno;			
	}
endif;

if(!function_exists('verifica_login')):
	//virifica usuario logado
	function verifica_login($redirect='login/login'){
		$ci = & get_instance();	
		if($ci->session->userdata('logged') != true):
			set_msg('<p>Acesso Restrito! Faça login para continuar</p>');
			redirect($redirect,'refresh');
		endif;
	}
endif;
