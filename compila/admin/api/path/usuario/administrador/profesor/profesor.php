<?php
	class RestProfesor{
		// GET usuario/admin/prof/listado/[orden]
		static public function getListaProf($order){
			$query = 'SELECT u.* FROM Profesor p, Usuario u WHERE p.Login = u.Login';

			//orden = login/nombre/apellidos
			switch($orden){
				case 'login':
					$query .= ' ORDER BY login';
				break;
				case 'nombre':
					$query .= ' ORDER BY nombre, apellidos';
				break;
				case 'apellidos':
					$query .= ' ORDER BY apellidos, nombre';
				break;
				default:
					$query .= ' ORDER BY login';
				break;
			}
			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;		
		}

		//GET usuario/admin/prof/aulas/listado/[loginProfesor]
		static public function getAulasProf($login){
			$query = 'SELECT a.id, a.nombre FROM Aula a WHERE a.Login = :loginProf ORDER BY a.nombre';

			$usu = getDatabase()->all($query, array(':loginProf' => $login));
			$json = json_encode($usu);

			echo $json;	
		}

		//GET usuario/admin/prof/listado/alumno/[loginProfesor]/instituto/[nombreInstituto]
		static public function getAlumnos($login, $instituto){
			$query = 'SELECT iap.login_alu FROM Ins_alu_prof iap WHERE iap.login_prof = :loginProf';
			if($instituto != 'null'){
				$query .= ' AND iap.nombre_insti = :instituto ORDER BY iap.login_alu';
				$usu = getDatabase()->all($query, array(':loginProf' => $login, ':instituto' => $instituto));
			}else{
				$query .= ' ORDER BY iap.login_alu';
				$usu = getDatabase()->all($query, array(':loginProf' => $login));
			}
			$json = json_encode($usu);

			echo $json;
		}

		//GET usuario/admin/prof/institutos/listado/[loginProfesor]
		static public function getInstitutos($login){
			$query = 'SELECT DISTINCT iap.nombre_insti FROM Ins_alu_prof iap WHERE iap.login_prof = :loginProf ORDER BY iap.nombre_insti';

			$usu = getDatabase()->all($query, array(':loginProf' => $login));
			$json = json_encode($usu);

			echo $json;
		}
	}

	class RestProfesorPost{

		static public function createProfesor($usu){
			$query = 'INSERT INTO Profesor (Login) VALUES (:idUsu)';

			$ej = getDatabase()->execute($query, array( ':idUsu' => $usu));
			$json = json_encode($ej);

			echo $json;
		}

		static public function deleteProfesor($id){
			//primero compruebo si tiene conexion con Aulas_Curso
			$query = 'DELETE FROM Profesor WHERE Profesor.Login = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>