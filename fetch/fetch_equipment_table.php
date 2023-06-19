<?php
//fetch.php
include('../connection/connect.php');
$column = array("equipments.id", "equipments.name", "equipments.eel_code", "projects.project_name");
$query = "
 SELECT * FROM equipments 
 INNER JOIN projects 
 ON projects.id = equipments.project_id 
";
$query .= " WHERE ";
if(isset($_POST["is_projects"]))
{
 $query .= "equipments.project_id = '".$_POST["is_projects"]."' AND ";
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(equipments.id LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR equipments.name LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR equipments.eel_code LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR projects.project_name LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY equipments.name DESC ';
}

$query1 = '';

if($_POST["length"] != 1)
{
 $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
	$actionData     =   get_equipment_list_action_data($row);
 $sub_array = array();
 $sub_array[] = $row["name"];
 $sub_array[] = $row["eel_code"];
 $sub_array[] = $row["project_name"];
 $sub_array[] = $actionData;
 $data[] = $sub_array;
}

function get_equipment_list_action_data($row){
    $view_url = 'equipment_view.php?id='.$row["eel_code"];
    $action = "";
	
	$action.='<span><a class="action-icons c-approve" href="'.$view_url.'" title="View"><i class="fas fa-eye text-success mborder"></i></a></span>';

    return $action;
}

function get_all_data($conn)
{
 $query = "SELECT * FROM equipments";
 $result = mysqli_query($conn, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($conn),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>