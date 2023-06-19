<?php


class Employee extends Database{


    public $emp_id;
    protected $table =  "Emp_Info";



    public function __construct()
    {

        parent::__construct();
        
    }




    public function employee_by_search()
    {

        $column     =   "emp_id";
        $search     =   $this->emp_id;

        $response   =   parent::get_search_data($this->table, $column, $search);
        
        return $response;
        
    }


    public function get_all_employees()
    {
        // , 'division', 'department', 'designation'
        $column     =   ['emp_id', 'emp_name'];
        return parent::get_all_data($this->table, '', $column, 'ASC', 'emp_name');
    }


    public function get_employee_info()
    {
        $where  =   [
            'emp_id'    =>  $this->emp_id
        ];
        $column     =   ['emp_id', 'emp_name', 'division', 'department', 'designation'];
        return parent::get_data($this->table, $where, $column);
    }


}


?>