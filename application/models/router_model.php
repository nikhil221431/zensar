<?php
if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );
class Router_model extends CI_Model
{

    public function registerSumbit($username, $email, $password){

        $data  = array(
                    'username'            => $username,
                    'email'               => $email,
                    'password'            => md5($password)
                );
        $queryOpt = $this->db->insert( 'user', $data );

        $result = new stdClass();

        if(!$queryOpt) {

            $result->output = "FALSE";
            $result->message = "Unable to create user. Try again.";
        }
        else {

            $result->output = "TRUE";
            $result->message = "User successfully registered";
        }

        return $result;
    }

    public function loginSumbit($email, $password){

        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
   		$query = $this->db->get('user');

        $result = new stdClass();

        if($query->num_rows() > 0){

            $userInfo = $query->row();
            $newdata  = array(
                            'userid'    => $userInfo->id,
                            'username'  => $userInfo->username,
                            'useremail' => $userInfo->email
                        );
            $this->session->set_userdata( $newdata );
            
            $result->output = "TRUE";
            $result->message = "User Successfully Login";
        }
        else {

            $result->output = "False";
            $result->message = "Please Try agein";
        }

        return $result;
    }

    public function routerInfo(){

        $this->db->where('created_by', $this->session->userdata('userid'));
        $this->db->where('is_validate', 1);
        $this->db->where('is_deleted', 0);
        $result = $this->db->get('router_details')->result();
        return $result;
    }

    public function createRouterSave($routersDetails){

      $data = $routersDetails;
      $queryOpt = $this->db->insert_batch( 'router_details', $data );

      $result = new stdclass();

      if(!$queryOpt) {

        $result->output   = "FALSE";
        $result->message  = "Unable To Insert Data";
        $result->result   = "";
      }
      else {

        $result->output   = "TRUE";
        $result->message  = "Data Successfully Inserted";
        $result->result   = "";
      }
      return  $result;
    }

    public function confirmation(){

      $this->db->where('created_by', $this->session->userdata('userid'));
      $this->db->where('is_validate', 0);
      $this->db->where('is_deleted', 0);
      $result = $this->db->get('router_details')->result();
      return $result;
    }

    public function deleteRouterData($routerDetailId){

        $data = array(
                'is_deleted'  => 1,
                'deleted_by'  => $this->session->userdata("userid")
            );

        $this->db->where('id', $routerDetailId);
        $query = $this->db->update('router_details', $data);

        $result = new stdclass();

        if(!$query){

            $result->message = "Unable to delete record. Please try again.";
            $result->output  = "FALSE";
        }
        else{

            $result->message = "Record Successfuly Deleted";
            $result->output  = "TRUE";
        }

        return $result;
    }

    public function confirmationSave($routersDetails){

      foreach ($routersDetails['id'] as $key => $value) {

        $data = array(
                  'sapid'        => $routersDetails['sapid'][$key],
                  'hostname'     => $routersDetails['hostname'][$key],
                  'loopback'     => $routersDetails['loopback'][$key],
                  'mac_address'  => $routersDetails['mac_address'][$key],
                  'is_validate'  => 1,
                );

        $this->db->where('id', $value);
        $query = $this->db->update('router_details', $data);
      }

      $result = new stdClass();
      $result->output   = "TRUE";
      $result->message  = "Data Successfully Inserted";
    }
}//Welcome_model end
?>