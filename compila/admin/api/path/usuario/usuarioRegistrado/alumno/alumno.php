<?php
	class RestAlumno{

		// GET usuario/usureg/alu/listado/[orden]
		static public function getListaAlu($orden){
			$query = 'SELECT u.* FROM Alumno a, Usuario u WHERE u.Login = a.Login ';

			//orden = login/nombre/apellidos
			switch($orden){
				case 'login':
					$query .= 'ORDER BY Login';
				break;
				case 'nombre':
					$query .= 'ORDER BY nombre, apellidos';
				break;
				case 'apellidos':
					$query .= 'ORDER BY apellidos, nombre';
				break;
				default:
					$query .= 'ORDER BY Login';
				break;
			}

			$usu = getDatabase()->all($query);
			$json = json_encode($usu);

			echo $json;		
		}

		// GET usuario/usureg/alu/aulas/listado/[idAlumno]
		static public function getAulas($login){
			$query = 'SELECT a.* FROM Aula a, Alumno_Aula aa WHERE aa.id_aula = a.id AND aa.login_alu = :idLogAlu ORDER BY a.id';

			$usu = getDatabase()->all($query, array(':idLogAlu' => $login));
			$json = json_encode($usu);

			echo $json;		
		}

		// GET usuario/usureg/alu/profesor/listado/[idAlumno]
		static public function getProfesores($login){
			$query = 'SELECT iap.login_prof, iap.nombre_insti FROM Ins_alu_prof iap WHERE iap.login_alu = :idAlumno ORDER BY iap.login_prof, iap.nombre_insti';

			$usu = getDatabase()->all($query, array(':idAlumno' => $login));
			$json = json_encode($usu);

			echo $json;		
		}

		// GET usuario/usureg/alu/instituto/listado/[idAlumno]
		static public function getInstitutos($login){
			$query = 'SELECT DISTINCT iap.nombre_insti FROM Ins_alu_prof iap WHERE iap.login_alu = :idAlumno ORDER BY iap.nombre_insti';

			$usu = getDatabase()->all($query, array(':idAlumno' => $login));
			$json = json_encode($usu);

			echo $json;		
		}
	}

	class RestAlumnoPost{

		static public function createAlumno($nombre){
			
			$query = 'INSERT INTO Alumno (Login) VALUES (:login)';

			$ej = getDatabase()->execute($query, array(':login' => $nombre));
			$json = json_encode($ej);

			echo $json;
		}

		static public function destroyAlumno($id){
			//primero compruebo si tiene conexion con Aulas_Curso

			$query = 'DELETE FROM Alumno WHERE Alumno.Login = :id';

			$ej = getDatabase()->execute($query, array(':id' => $id));
			$json = json_encode($ej);

			echo $json;
		}
	}
?>