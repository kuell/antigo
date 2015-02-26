<?php 
	/*Filtro Status*/
		$f_status = "%";
		if (isset($_REQUEST['status'])) {
		  $f_status = $_REQUEST['status'];
		  echo "Status = ".$status."<br />";
		}
	/*Filtro Setor*/
			$f_setor = "%";
			if (isset($_REQUEST['setor'])) {
			  $f_setor = $_REQUEST['setor'];
			    echo "Setor = ".$setor."<br />";
		}
	/*Filtro Equipamento*/
			$f_equip = "%";
			if (isset($_REQUEST['equip'])) {
			  $f_equip = $_REQUEST['equip'];
			    echo "Equip = ".$equip."<br />";
		}
	/*Filtro Requisitante*/
			$f_requisit = "%";
			if (isset($_REQUEST['requisit'])) {
			  $f_requisit = $_REQUEST['requisit'];
			    echo "Requisitante = ".$requisit ."<br />";
		}
	/*Filtro data_1*/
	$data = date('d/m/Y');
			$data_11 = $data ;
			if (isset($_REQUEST['data_1'])) {
			  $data_11 = $_REQUEST['data_1'];
					$data_1 = date('Y-m-d', strtotime($data_11));
			echo "Data 1 =".$data_1."<br />";
	}
	/*Filtro data_2*/
			$data_22 = $data;
			if (isset($_REQUEST['data_2'])) {
			  $data_22 = $_REQUEST['data_2'];
			  $data_2 = print $data_2;
			 echo "Data 2 = ".$data_2;
		}
?>