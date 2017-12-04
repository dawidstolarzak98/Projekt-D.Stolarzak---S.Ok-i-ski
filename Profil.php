<?php
class Profil extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('profilM');
  }

  public function index() {
    $this->profilM->sprawdz();
    $data['tytul']='Mój profil';
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('profil/index');
    $this->load->view('szablon/koniec');
  }

  public function wyloguj() {
    $this->profilM->wyloguj();
    redirect(site_url());
  }

  public function usun($id=false) {
    if(!$id) show_404();
    $this->profilM->sprawdz();
    if(!$this->profilM->jestWlascicielem($id)) redirect('profil');
    $this->profilM->usun($id);
    redirect('profil/posiadane');
  }

  public function nowa() {
    $this->profilM->sprawdz();
    $this->form_validation->set_rules('nazwaAukcji','Nazwa','required');
    $this->form_validation->set_rules('opis','Opis','required');
    $this->form_validation->set_rules('terminKoncowy','Termin aukcji','required');
    $this->form_validation->set_rules('cena','Cena','required|greater_than_equal_to[0.01]');
    $data['tytul']='Nowa aukcja';
    if($this->form_validation->run()) {
      if($this->profilM->dodajAukcje()) redirect('profil/posiadane');
      else redirect('profil/nowa');
    }
    else {
      $this->load->view('szablon/start',$data);
      $this->load->view('szablon/menu');
      $this->load->view('profil/nowa');
      $this->load->view('szablon/koniec');
    }
  }

  public function posiadane() {
    $this->profilM->sprawdz();
    $data['aukcje']=$this->profilM->wczytajAukcje();
    $data['tytul']='Moje aukcje';
    $data['usuwanie']=true;
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('profil/posiadane');
    $this->load->view('szablon/koniec');
  }

  public function historia() {
    $this->profilM->sprawdz();
    $data['aukcje']=$this->profilM->wczytajHistorie();
    $data['tytul']='Historia';
    $data['usuwanie']=false;
    $this->load->view('szablon/start',$data);
    $this->load->view('szablon/menu');
    $this->load->view('profil/historia');
    $this->load->view('szablon/koniec');
  }

  public function powiadomienie($id) {
    $powiadomienie=$this->db->get_where('powiadomienia',array('id'=>$id))->row_array();
    if($id) {
      $where=array('id'=>$id,'idUzytkownika'=>$this->session->userdata('id'));
      $this->db->delete('powiadomienia',$where);
    }
    redirect('aukcje/szczegoly/'.$powiadomienie['idAukcji']);
  }
}
