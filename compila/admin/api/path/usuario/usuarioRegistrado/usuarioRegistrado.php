<?php
	class RestUsuarioRegistrado{
		
		// GET usuario/usureg/listado/[orden]
		static public function getListaUsuReg($orden){
			$query = 'SELECT u.* FROM UsuarioRegistrado ur, Usuario u WHERE ur.Login = u.Login ';

			//orden = login/nombre/apellidos
			switch($orden){
				case 'login':
					$query .= 'ORDER BY login';
				break;
				case 'nombre':
					$query .= 'ORDER BY nombre, apellidos';
				break;
				case 'apellidos':
					$query .= 'ORDER BY apellidos, nombre';
				break;
				default:
					$query .= 'ORDER BY login';
				break;
			}

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;		
		}

		// GET usuario/usureg/compras/listado/[idUsuarioRegistrado]/fecha1/[yyyy-mm-dd]/fecha2/[yyyy-mm-dd]
		static public function getCompras($login){
			$query = 'SELECT c.fecha, c.plazo, p.descuento, cr.nombre, cr.descripcion, cr.nivel FROM Comprar c, Pack p, Curso_Pack cp, Curso cr WHERE c.login_usuR = :idUsuReg AND c.id_pack = p.id AND p.id = cp.id_Pack AND cp.id_Curso = cr.id';
			
			/*if($fecha1 != 'null'){
				if($fecha2 != -1){
					$fecha .= ' AND c.fecha >= :f1 AND c.fecha <= :f2';
					$usu = getDatabase()->all($query, array(':idUsuReg' => $login, ':f1' => $fecha1, ':f2' => $fecha2));
				}else{
					$fecha .= ' AND c.fecha >= :f1';
					$usu = getDatabase()->all($query, array(':idUsuReg' => $login, ':f1' => $fecha1));
				}
			}else if($fecha2 != 'null'){
				$fecha .= ' AND c.fecha <= :f2';
				$usu = getDatabase()->all($query, array(':idUsuReg' => $login, ':f1' => $fecha1, ':f2' => $fecha2));
			}else{
				$usu = getDatabase()->all($query, array(':idUsuReg' => $login));
			}*/		
			$usu = getDatabase()->all($query, array(':idUsuReg' => $login));
			$json = json_encode($usu);

			echo $json;	
		}
	}
?>