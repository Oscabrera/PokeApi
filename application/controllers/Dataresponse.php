<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dataresponse extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('error');
        $this->load->helper('apoyos');
        $this->load->helper('funcionphp');
        date_default_timezone_set('America/Mexico_City');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
    }


    public function datatable()
    {

        $this->load->model('Homemodel');
        $this->Homemodel->set_table(desencripta($this->input->post('cue')));
        if ($this->input->post('cond') != '') {
            $this->Homemodel->set_where(desencripta($this->input->post('cond')));
        }

        foreach ($this->input->post('columns') as $key => $value) {
            $columns[] = $value['name'];
        }

        $this->Homemodel->set_columns($columns);
        $i = 0;

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = null;

        $colum_search = array();

        foreach ($columns as $key => $value) {
            $colum_search[] = $this->input->post('columns')[$key]['search'];
        }

        /*DATA */
        $totalData = $this->Homemodel->allposts_count();
        if ($limit == -1) {
            $limit = $totalData;
        }

        $posts = $this->Homemodel->posts_search($limit, $start, $search, $order, $dir, $colum_search);
        $totalFiltered = $this->Homemodel->posts_search_count($search, $colum_search);

        $data = array();

        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                foreach ($post as $key_post => $val) {
                    $nestedData[$key_post] = $val;
                }
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
}