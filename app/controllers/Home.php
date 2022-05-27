<?php
class Home extends Controller
{
    public function index()
    {
        $data['judul'] = 'Dashboard';
        $data['mainController'] = 'Home';
        $this->view('templates/header', $data);
        $this->view('templates/sidemenu');
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
    
}
