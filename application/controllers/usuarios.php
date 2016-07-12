<?php 
class Usuarios extends CI_Controller{
 
    function __construct(){
        parent::__construct();
        $this->load->model('usuario');        
    }
     


    public function login(){ 

        //$this->load->view('encabezado');
        $this->load->view('/usuarios/login');
        //$this->load->view('pie');


    }



     public function validarDatos(){        
        $data=array(
        'USERNAME_USU'=> $this->input->post('USERNAME_USU'),
        'PASSWORD_USU'=> $this->input->post('PASSWORD_USU')
        );
        
        $resultado = $this -> usuario -> consultaUsuario($data);   //username y password     
        if($resultado){
            
            $this -> session -> set_flashdata('bienvenida','Bienvenido al sistema!');
            
            $datosSesion = array(
                'id'=> $resultado -> ID_USU, 
                'username' => $resultado -> USERNAME_USU, 
                'nombre' => $resultado -> NOMBRE_USU,
                'apellido' => $resultado -> APELLIDO_USU,
                'perfil' => $resultado -> DESCRIPCION_PER, 
                'idSucursal' => $resultado -> ID_SUC,
                'sucursal' => $resultado -> CIUDAD_SUC
            );
            $this -> session -> set_userdata($datosSesion);
          redirect("/");
            
        }else
        {
            $this -> session -> set_flashdata('errorLogin','Usuario o Contraseña Incorrectos');
            redirect('/usuarios/login');
        }
    }
    
     public function cerrarSesion(){
        $this -> session -> sess_destroy(); 
        $this -> session -> set_flashdata('cerrarSesion','Sesión Cerrada Exitosamente!');
        redirect('/');
    }
    

}
?>
